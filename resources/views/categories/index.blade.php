@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Kelola Kategori</h1>
    <p class="text-gray-600">Kelola kategori produk</p>
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
                <span class="text-gray-700">Total Kategori: {{ $categories->total() }}</span>
            </div>
            <a href="{{ route('categories.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>Tambah Kategori
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($categories as $category)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900">{{ $category->name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $category->slug }}</code>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-gray-600 text-sm">{{ Str::limit($category->description, 50) }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('categories.edit', $category) }}" 
                           class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Hapus kategori ini?')">
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
        {{ $categories->links() }}
    </div>
</div>
@endsection