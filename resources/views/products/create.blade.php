@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Tambah Produk Baru</h1>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 mb-2">Nama Produk *</label>
                    <input type="text" 
                           name="name" 
                           required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Barcode</label>
                    <input type="text" 
                           name="barcode" 
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Kategori</label>
                    <select name="category_id" class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Harga *</label>
                    <input type="number" 
                           name="price" 
                           required
                           min="0"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Stok *</label>
                    <input type="number" 
                           name="stock" 
                           required
                           min="0"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Satuan *</label>
                    <select name="unit" class="w-full px-4 py-2 border rounded-lg">
                        <option value="pcs">pcs</option>
                        <option value="kg">kg</option>
                        <option value="liter">liter</option>
                        <option value="pack">pack</option>
                        <option value="botol">botol</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" 
                              rows="3"
                              class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('products.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection