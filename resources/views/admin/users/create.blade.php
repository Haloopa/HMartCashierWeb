@extends('layouts.cashier')

@section('title', 'Tambah Kasir Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            <i class="fas fa-user-plus mr-2"></i>Tambah Kasir Baru
        </h1>
        <p class="text-gray-600 mt-1">Tambahkan kasir baru ke sistem</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Kasir *
                </label>
                <input type="text" 
                       name="name" 
                       id="name"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Masukkan nama kasir">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email *
                </label>
                <input type="email" 
                       name="email" 
                       id="email"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       placeholder="email@contoh.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Password *
                </label>
                <input type="password" 
                       name="password" 
                       id="password"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Minimal 8 karakter">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    Konfirmasi Password *
                </label>
                <input type="password" 
                       name="password_confirmation" 
                       id="password_confirmation"
                       required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Ulangi password">
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.users.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan Kasir
                </button>
            </div>
        </form>
    </div>
</div>
@endsection