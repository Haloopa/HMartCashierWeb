@extends('layouts.cashier')

@section('title', 'Dashboard')

@section('content')
<div class="py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    <i class="fas fa-tachometer-alt text-blue-600 mr-3"></i>
                    Dashboard
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    H'Mart Supermarket • {{ now()->format('d F Y') }}
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="bg-blue-50 px-4 py-2 rounded-lg">
                    <div class="text-sm text-gray-600">Kasir Aktif</div>
                    <div class="font-bold text-blue-600">{{ auth()->user()->name }}</div>
                </div>
                <div class="bg-gray-100 px-4 py-2 rounded-lg">
                    <div class="text-xs text-gray-600">Jam</div>
                    <div id="currentTime" class="font-mono font-bold">{{ date('H:i:s') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards-->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-8">
        <!-- Today's Transactions -->
        <div class="bg-white rounded-lg shadow p-5">
            <div class="text-gray-500 text-sm font-medium mb-2">Transaksi Hari Ini</div>
            <div class="text-3xl font-bold text-gray-900">
                {{ \App\Models\Transaction::whereDate('created_at', today())->count() }}
            </div>
        </div>

        <!-- Today's Revenue -->
        <div class="bg-white rounded-lg shadow p-5">
            <div class="text-gray-500 text-sm font-medium mb-2">Pendapatan Hari Ini</div>
            <div class="text-3xl font-bold text-gray-900">
                Rp {{ number_format(\App\Models\Transaction::whereDate('created_at', today())->sum('total_amount') ?? 0, 0, ',', '.') }}
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white rounded-lg shadow p-5">
            <div class="text-gray-500 text-sm font-medium mb-2">Total Produk</div>
            <div class="text-3xl font-bold text-gray-900">
                {{ \App\Models\Product::count() }}
            </div>
        </div>

        <!-- Total Categories -->
        <div class="bg-white rounded-lg shadow p-5">
            <div class="text-gray-500 text-sm font-medium mb-2">Total Kategori</div>
            <div class="text-3xl font-bold text-gray-900">
                {{ \App\Models\Category::count() }}
            </div>
        </div>

        <!-- Total Kasir -->
        <div class="bg-white rounded-lg shadow p-5">
            <div class="text-gray-500 text-sm font-medium mb-2">Total Kasir</div>
            <div class="text-3xl font-bold text-gray-900">
                {{ \App\Models\User::count() }}
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Quick Actions -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Akses Cepat</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('cashier.index') }}" 
                       class="bg-blue-50 border border-blue-200 rounded-lg p-4 hover:bg-blue-100 transition duration-200">
                        <div class="flex items-center">
                            <div class="bg-blue-600 p-3 rounded-lg mr-4">
                                <i class="fas fa-cash-register text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Point of Sale</h3>
                                <p class="text-sm text-gray-600">Mulai transaksi baru</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('products.create') }}" 
                       class="bg-green-50 border border-green-200 rounded-lg p-4 hover:bg-green-100 transition duration-200">
                        <div class="flex items-center">
                            <div class="bg-green-600 p-3 rounded-lg mr-4">
                                <i class="fas fa-plus-circle text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Tambah Produk</h3>
                                <p class="text-sm text-gray-600">Tambahkan produk baru</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('products.index') }}" 
                       class="bg-purple-50 border border-purple-200 rounded-lg p-4 hover:bg-purple-100 transition duration-200">
                        <div class="flex items-center">
                            <div class="bg-purple-600 p-3 rounded-lg mr-4">
                                <i class="fas fa-boxes text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Kelola Produk</h3>
                                <p class="text-sm text-gray-600">Lihat semua produk</p>
                            </div>
                        </div>
                    </a>
                    
                    <a href="{{ route('cashier.transactions') }}" 
                       class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 hover:bg-indigo-100 transition duration-200">
                        <div class="flex items-center">
                            <div class="bg-indigo-600 p-3 rounded-lg mr-4">
                                <i class="fas fa-history text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Riwayat Transaksi</h3>
                                <p class="text-sm text-gray-600">Lihat semua transaksi</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Stock Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Status Stok</h2>
                
                @php
                    $lowStockCount = \App\Models\Product::where('stock', '<', 10)->where('stock', '>', 0)->count();
                    $outOfStockCount = \App\Models\Product::where('stock', 0)->count();
                    $inStockCount = \App\Models\Product::where('stock', '>=', 10)->count();
                @endphp
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                        <div>
                            <div class="font-medium text-gray-900">Stok Aman</div>
                            <div class="text-sm text-gray-600">≥ 10 unit</div>
                        </div>
                        <div class="text-2xl font-bold text-green-600">{{ $inStockCount }}</div>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-yellow-50 rounded-lg">
                        <div>
                            <div class="font-medium text-gray-900">Stok Rendah</div>
                            <div class="text-sm text-gray-600">1-9 unit</div>
                        </div>
                        <div class="text-2xl font-bold text-yellow-600">{{ $lowStockCount }}</div>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-red-50 rounded-lg">
                        <div>
                            <div class="font-medium text-gray-900">Stok Habis</div>
                            <div class="text-sm text-gray-600">0 unit</div>
                        </div>
                        <div class="text-2xl font-bold text-red-600">{{ $outOfStockCount }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-900">Transaksi Terbaru</h2>
                <a href="{{ route('cashier.transactions') }}" 
                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Lihat Semua
                </a>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kasir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $recent = \App\Models\Transaction::with('user')
                            ->latest()
                            ->limit(8)
                            ->get();
                    @endphp
                    
                    @forelse($recent as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-medium text-blue-600">
                                {{ $transaction->invoice_number }}
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $transaction->created_at->format('H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-900">{{ $transaction->user->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-green-600">
                                Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-shopping-cart text-3xl mb-3"></i>
                            <p>Belum ada transaksi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateClock() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById('currentTime').textContent = timeString;
    }
    setInterval(updateClock, 1000);
    updateClock();
});
</script>
@endsection