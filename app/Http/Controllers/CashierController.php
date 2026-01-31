<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class CashierController extends Controller
{
    public function index()
    {
        try {
            $products = Product::with('category')
                ->where('stock', '>', 0)
                ->orderBy('name')
                ->limit(50) 
                ->get();
            
            if (!$products) {
                $products = collect();
            }
            
            Log::info('POS loaded with ' . $products->count() . ' products');
            
            return view('cashier.index', compact('products'));
            
        } catch (\Exception $e) {
            Log::error('Error loading POS: ' . $e->getMessage());
            $products = collect(); 
            return view('cashier.index', compact('products'));
        }
    }

    public function searchProduct(Request $request)
    {
        try {
            $request->validate([
                'search' => 'nullable|string|max:100'
            ]);
            
            $search = $request->input('search', '');
            
            Log::info('Searching products with keyword: ' . $search);
            
            $products = Product::with('category')
                ->where('stock', '>', 0)
                ->when($search, function ($query, $search) {
                    return $query->where(function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('barcode', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%");
                    });
                })
                ->orderBy('name')
                ->limit(20)
                ->get();
            
            Log::info('Found ' . $products->count() . ' products');
            
            return response()->json([
                'success' => true,
                'products' => $products,
                'count' => $products->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Search error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mencari produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function processTransaction(Request $request)
    {
        try {
            Log::info('Processing transaction request:', $request->all());
            
            $validated = $request->validate([
                'items' => 'required|array|min:1',
                'items.*.id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
                'payment_method' => 'required|in:cash,debit_card,credit_card,qr_code',
                'payment_amount' => 'required|numeric|min:0',
                'notes' => 'nullable|string|max:500'
            ]);
            
            Log::info('Validation passed', $validated);

            DB::beginTransaction();

            $total = 0;
            $itemsData = [];
            
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['id']);
                
                if (!$product) {
                    throw new \Exception("Produk tidak ditemukan: ID " . $item['id']);
                }
                
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi. Stok tersedia: {$product->stock}");
                }
                
                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;
                
                $itemsData[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal
                ];
            }
            
            $paymentAmount = $validated['payment_amount'];
            if ($paymentAmount < $total) {
                throw new \Exception("Jumlah bayar kurang. Total: Rp " . number_format($total, 0, ',', '.'));
            }
            
            $change = $paymentAmount - $total;
            
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
                'payment_amount' => $paymentAmount,
                'change' => $change,
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes'] ?? '',
            ]);
            
            Log::info('Transaction created: ' . $transaction->invoice_number);

            foreach ($itemsData as $item) {
                $product = $item['product'];
                
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $item['subtotal'],
                ]);

                $product->decrement('stock', $item['quantity']);
                Log::info('Reduced stock for product ' . $product->name . ' by ' . $item['quantity']);
            }

            DB::commit();
            
            Log::info('Transaction completed successfully: ' . $transaction->invoice_number);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil',
                'invoice_number' => $transaction->invoice_number,
                'transaction_id' => $transaction->id,
                'total_amount' => $total,
                'payment_amount' => $paymentAmount,
                'change' => $change,
                'receipt_url' => route('cashier.receipt', $transaction->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Transaction failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error_details' => env('APP_DEBUG') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    public function todayTransactions()
    {
        try {
            $transactions = Transaction::whereDate('created_at', today())
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(15);
            
            $totalToday = Transaction::whereDate('created_at', today())
                ->sum('total_amount');
            
            return view('cashier.transactions', compact('transactions', 'totalToday'));
            
        } catch (\Exception $e) {
            Log::error('Error loading transactions: ' . $e->getMessage());
            $transactions = collect();
            $totalToday = 0;
            return view('cashier.transactions', compact('transactions', 'totalToday'));
        }
    }

    public function receipt($id)
    {
        try {
            $transaction = Transaction::with(['details.product', 'user'])
                ->findOrFail($id);
            
            return view('cashier.receipt', compact('transaction'));
            
        } catch (\Exception $e) {
            Log::error('Error loading receipt: ' . $e->getMessage());
            abort(404, 'Struk tidak ditemukan');
        }
    }
    
    public function getLowStockCount()
    {
        try {
            $count = Product::where('stock', '>', 0)
                ->where('stock', '<', 10)
                ->count();
            
            return response()->json([
                'success' => true,
                'count' => $count
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'count' => 0
            ]);
        }
    }

    public function exportToday()
    {
        $transactions = Transaction::whereDate('created_at', today())
            ->with('user')
            ->get();
        
        return $this->exportToExcel($transactions, 'transaksi-hari-ini-' . date('Y-m-d'));
    }

    public function exportMonth()
    {
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();
        
        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->with('user')
            ->get();
        
        return $this->exportToExcel($transactions, 'transaksi-bulan-' . date('Y-m'));
    }

    public function exportCustom(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        
        $startDate = $request->start_date . ' 00:00:00';
        $endDate = $request->end_date . ' 23:59:59';
        
        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->with('user')
            ->get();
        
        $filename = 'transaksi-' . $request->start_date . '-sd-' . $request->end_date;
        
        return $this->exportToExcel($transactions, $filename);
    }

    private function exportToExcel($transactions, $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
        ];
        
        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            
            fputcsv($file, [
                'NO',
                'INVOICE',
                'TANGGAL',
                'WAKTU',
                'KASIR',
                'TOTAL TRANSAKSI',
                'METODE PEMBAYARAN',
                'BAYAR',
                'KEMBALIAN',
                'CATATAN'
            ]);
            
            $counter = 1;
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $counter++,
                    $transaction->invoice_number,
                    $transaction->created_at->format('d/m/Y'),
                    $transaction->created_at->format('H:i:s'),
                    $transaction->user->name,
                    $transaction->total_amount,
                    strtoupper(str_replace('_', ' ', $transaction->payment_method)),
                    $transaction->payment_amount,
                    $transaction->change,
                    $transaction->notes
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}