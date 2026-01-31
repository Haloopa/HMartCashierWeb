@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Tambah Kategori Baru</h1>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block text-gray-700 mb-2">Nama Kategori *</label>
                    <input type="text" 
                           name="name" 
                           required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                           placeholder="Contoh: Makanan Ringan">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" 
                              rows="3"
                              class="w-full px-4 py-2 border rounded-lg"
                              placeholder="Deskripsi kategori..."></textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('categories.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection