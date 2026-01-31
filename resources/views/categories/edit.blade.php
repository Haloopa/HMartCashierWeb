@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Edit Kategori: {{ $category->name }}</h1>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block text-gray-700 mb-2">Nama Kategori *</label>
                    <input type="text" 
                           name="name" 
                           value="{{ $category->name }}"
                           required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" 
                              rows="3"
                              class="w-full px-4 py-2 border rounded-lg">{{ $category->description }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('categories.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection