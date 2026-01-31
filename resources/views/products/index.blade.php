@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Kelola Produk</h1>
    <p class="text-gray-600">Kelola stok dan informasi produk</p>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <div>
                <span class="text-gray-700">Total Produk: {{ $products->total() }}</span>
            </div>
            <a href="{{ route('products.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Tambah Produk
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $product->name }}</div>
                        <div class="text-sm text-gray-500">{{ $product->barcode }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">
                            {{ $product->category->name ?? 'Tidak ada' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-green-600">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $product->stock }} {{ $product->unit }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('products.edit', $product) }}" 
                           class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="px-6 py-4 border-t border-gray-200">
        {{ $products->links() }}
    </div>
</div>
@endsection