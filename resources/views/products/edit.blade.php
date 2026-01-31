@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Produk: {{ $product->name }}</h1>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 mb-2">Nama Produk *</label>
                    <input type="text" 
                           name="name" 
                           value="{{ $product->name }}"
                           required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Barcode</label>
                    <input type="text" 
                           name="barcode" 
                           value="{{ $product->barcode }}"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Kategori</label>
                    <select name="category_id" class="w-full px-4 py-2 border rounded-lg">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Harga *</label>
                    <input type="number" 
                           name="price" 
                           value="{{ $product->price }}"
                           required
                           min="0"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Stok *</label>
                    <input type="number" 
                           name="stock" 
                           value="{{ $product->stock }}"
                           required
                           min="0"
                           class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Satuan *</label>
                    <select name="unit" class="w-full px-4 py-2 border rounded-lg">
                        <option value="pcs" {{ $product->unit == 'pcs' ? 'selected' : '' }}>pcs</option>
                        <option value="kg" {{ $product->unit == 'kg' ? 'selected' : '' }}>kg</option>
                        <option value="liter" {{ $product->unit == 'liter' ? 'selected' : '' }}>liter</option>
                        <option value="pack" {{ $product->unit == 'pack' ? 'selected' : '' }}>pack</option>
                        <option value="botol" {{ $product->unit == 'botol' ? 'selected' : '' }}>botol</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" 
                              rows="3"
                              class="w-full px-4 py-2 border rounded-lg">{{ $product->description }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('products.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update Produk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection