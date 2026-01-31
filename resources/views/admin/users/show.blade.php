@extends('layouts.cashier')

@section('title', 'Detail Kasir: ' . $user->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            <i class="fas fa-user mr-2"></i>Detail Kasir
        </h1>
        <a href="{{ route('admin.users.index') }}" 
           class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <!-- User Info Card -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex items-center mb-6">
            <div class="bg-blue-100 p-4 rounded-full mr-4">
                <i class="fas fa-user text-blue-600 text-2xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                <p class="text-gray-600">{{ $user->email }}</p>
                <p class="text-sm text-gray-500 mt-1">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    Bergabung: {{ $user->created_at->format('d M Y') }}
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    <i class="fas fa-clock mr-1"></i>
                    Terakhir diupdate: {{ $user->updated_at->format('d M Y') }}
                </p>
            </div>
        </div>

        <!-- Info Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full mr-3">
                        <i class="fas fa-user-circle text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status Akun</p>
                        <p class="text-lg font-bold text-blue-700">
                            @if($user->id === auth()->id())
                                <span class="text-green-600">✓ Aktif (Anda)</span>
                            @else
                                Aktif
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-full mr-3">
                        <i class="fas fa-envelope text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email Terverifikasi</p>
                        <p class="text-lg font-bold text-green-700">
                            @if($user->email_verified_at)
                                <span class="text-green-600">✓ {{ $user->email_verified_at->format('d/m/Y') }}</span>
                            @else
                                <span class="text-yellow-600">Belum diverifikasi</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="border-t pt-6">
            <div class="flex space-x-4">
                <a href="{{ route('admin.users.edit', $user) }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-edit mr-2"></i>Edit Kasir
                </a>
                @if($user->id !== auth()->id())
                <form action="{{ route('admin.users.destroy', $user) }}" 
                      method="POST"
                      onsubmit="return confirm('Hapus kasir ini? Data tidak dapat dikembalikan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 flex items-center">
                        <i class="fas fa-trash mr-2"></i>Hapus Kasir
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Informasi Tambahan -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold mb-4 flex items-center">
            <i class="fas fa-info-circle mr-2 text-blue-600"></i>Informasi Kasir
        </h3>
        
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">ID Kasir</p>
                    <p class="font-bold text-gray-900">{{ $user->id }}</p>
                </div>
                
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">Tanggal Dibuat</p>
                    <p class="font-bold text-gray-900">{{ $user->created_at->format('d F Y H:i') }}</p>
                </div>
            </div>
            
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <h4 class="font-bold text-yellow-800 mb-2">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Informasi Penting
                </h4>
                <ul class="text-sm text-yellow-700 space-y-1">
                    <li>• Kasir tidak dapat menghapus akun sendiri</li>
                    <li>• Email kasir digunakan untuk login ke sistem</li>
                    <li>• Password dapat direset melalui halaman edit</li>
                    <li>• Pastikan data kasir selalu diperbarui</li>
                </ul>
            </div>
            
            @if($user->id === auth()->id())
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                <h4 class="font-bold text-green-800 mb-2">
                    <i class="fas fa-user-check mr-2"></i>Akun Anda
                </h4>
                <p class="text-sm text-green-700">
                    Anda sedang melihat detail akun sendiri. Untuk mengubah password atau informasi pribadi, 
                    gunakan menu <a href="{{ route('profile.edit') }}" class="font-bold underline">Profil</a>.
                </p>
            </div>
            @endif
        </div>
    </div>

    <!-- Quick Links -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="font-bold text-blue-900 mb-3">
            <i class="fas fa-link mr-2"></i>Tautan Cepat
        </h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.users.index') }}" 
               class="bg-white border border-blue-200 text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-50">
                <i class="fas fa-users mr-2"></i>Semua Kasir
            </a>
            <a href="{{ route('admin.users.create') }}" 
               class="bg-white border border-green-200 text-green-700 px-4 py-2 rounded-lg hover:bg-green-50">
                <i class="fas fa-user-plus mr-2"></i>Tambah Kasir Baru
            </a>
            <a href="{{ route('profile.edit') }}" 
               class="bg-white border border-purple-200 text-purple-700 px-4 py-2 rounded-lg hover:bg-purple-50">
                <i class="fas fa-user-edit mr-2"></i>Edit Profil
            </a>
        </div>
    </div>
</div>
@endsection