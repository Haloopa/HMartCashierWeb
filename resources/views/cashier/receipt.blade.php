<div class="font-mono text-sm">
    <div class="text-center mb-4">
        <h4 class="font-bold text-lg">H'Mart Supermarket</h4>
        <p>Jl. Jalan Jalan, Surakarta</p>
        <p>Telp: (021) 123-4567</p>
        <hr class="my-2">
    </div>
    
    <div class="mb-3">
        <p>Invoice: {{ $transaction->invoice_number }}</p>
        <p>Tanggal: {{ $transaction->created_at->format('d/m/Y H:i:s') }}</p>
        <p>Kasir: {{ $transaction->user->name }}</p>
    </div>
    
    <hr class="my-2">
    
    <div class="mb-3">
        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-1">Item</th>
                    <th class="text-center py-1">Qty</th>
                    <th class="text-right py-1">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->details as $detail)
                <tr class="border-b">
                    <td class="py-1">
                        {{ $detail->product->name }}
                    </td>
                    <td class="text-center py-1">
                        {{ $detail->quantity }} x Rp {{ number_format($detail->price, 0, ',', '.') }}
                    </td>
                    <td class="text-right py-1">
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <hr class="my-2">
    
    <div class="mb-4">
        <div class="flex justify-between">
            <span>Total:</span>
            <span class="font-bold">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between">
            <span>Bayar:</span>
            <span>Rp {{ number_format($transaction->payment_amount, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between">
            <span>Kembali:</span>
            <span>Rp {{ number_format($transaction->change, 0, ',', '.') }}</span>
        </div>
    </div>
    
    <hr class="my-2">
    
    <div class="text-center mt-4">
        <p class="text-sm">Terima kasih telah berbelanja</p>
        <p class="text-xs mt-1">Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</p>
    </div>
    
    <div class="mt-6 text-center">
        <button onclick="window.print()" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-print mr-2"></i>Cetak Struk
        </button>
    </div>
</div>