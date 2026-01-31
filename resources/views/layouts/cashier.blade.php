<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>H'Mart Cashier - @yield('title')</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        html, body {
            height: 100%;
            overflow: hidden;
        }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc; 
        }
        
        .sidebar {
            transition: all 0.3s;
        }
        
        .nav-link {
            transition: all 0.2s;
        }
        
        .nav-link:hover {
            background-color: #f1f5f9;
            transform: translateX(5px);
        }
        
        .nav-link.active {
            background-color: #3b82f6;
            color: white;
        }
        
        .nav-link.active:hover {
            background-color: #2563eb;
        }
        
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="sidebar w-64 bg-white shadow-lg flex-shrink-0">
            <div class="p-6 h-full overflow-y-auto">
                <!-- Logo & Store Name -->
                <div class="flex items-center space-x-3 mb-8">
                    <div class="bg-blue-600 p-3 rounded-lg">
                        <i class="fas fa-store text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-xl text-gray-900">H'Mart</h1>
                        <p class="text-sm text-gray-600">Supermarket</p>
                    </div>
                </div>
                
                <!-- User Info -->
                <div class="mb-6">
                    <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                        <div class="bg-blue-100 p-2 rounded-full">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-medium">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">Kasir</p>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Menu -->
                <nav class="space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                       class="nav-link flex items-center space-x-3 p-3 text-gray-700 hover:text-blue-600 rounded-lg 
                              {{ request()->routeIs('dashboard') ? 'active text-white' : '' }}">
                        <i class="fas fa-home w-5"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <!-- Point of Sale -->
                    <a href="{{ route('cashier.index') }}" 
                       class="nav-link flex items-center space-x-3 p-3 text-gray-700 hover:text-blue-600 rounded-lg
                              {{ request()->routeIs('cashier.*') && !request()->routeIs('cashier.transactions') ? 'active text-white' : '' }}">
                        <i class="fas fa-cash-register w-5"></i>
                        <span>Point of Sale</span>
                        <span class="ml-auto bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">POS</span>
                    </a>
                    
                    <!-- Transactions History -->
                    <a href="{{ route('cashier.transactions') }}" 
                       class="nav-link flex items-center space-x-3 p-3 text-gray-700 hover:text-blue-600 rounded-lg
                              {{ request()->routeIs('cashier.transactions') ? 'active text-white' : '' }}">
                        <i class="fas fa-history w-5"></i>
                        <span>Riwayat Transaksi</span>
                    </a>
                    
                    <!-- Products Management -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 px-3">
                            <i class="fas fa-boxes mr-2"></i>Manajemen Produk
                        </p>
                        
                        <a href="{{ route('products.index') }}" 
                           class="nav-link flex items-center space-x-3 p-3 text-gray-700 hover:text-blue-600 rounded-lg
                                  {{ request()->routeIs('products.*') ? 'active text-white' : '' }}">
                            <i class="fas fa-box w-5"></i>
                            <span>Produk</span>
                            <span class="ml-auto bg-green-100 text-green-600 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Product::count() }}
                            </span>
                        </a>
                        
                        <a href="{{ route('categories.index') }}" 
                           class="nav-link flex items-center space-x-3 p-3 text-gray-700 hover:text-blue-600 rounded-lg
                                  {{ request()->routeIs('categories.*') ? 'active text-white' : '' }}">
                            <i class="fas fa-tags w-5"></i>
                            <span>Kategori</span>
                            <span class="ml-auto bg-purple-100 text-purple-600 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\Category::count() }}
                            </span>
                        </a>
                        
                        <a href="{{ route('products.create') }}" 
                           class="nav-link flex items-center space-x-3 p-3 text-gray-700 hover:text-blue-600 rounded-lg
                                  {{ request()->routeIs('products.create') ? 'active text-white' : '' }}">
                            <i class="fas fa-plus-circle w-5"></i>
                            <span>Tambah Produk Baru</span>
                        </a>
                    </div>

                    <!-- Admin Section -->
                    @if(auth()->user()->email === 'admin@hmart.com' || auth()->user()->id === 1)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 px-3">
                            <i class="fas fa-user-shield mr-2"></i>Admin
                        </p>
                        
                        <a href="{{ route('admin.users.index') }}" 
                           class="nav-link flex items-center space-x-3 p-3 text-gray-700 hover:text-blue-600 rounded-lg
                                  {{ request()->routeIs('admin.users.*') ? 'active text-white' : '' }}">
                            <i class="fas fa-users-cog w-5"></i>
                            <span>Kelola Kasir</span>
                            <span class="ml-auto bg-indigo-100 text-indigo-600 text-xs px-2 py-1 rounded-full">
                                {{ \App\Models\User::count() }}
                            </span>
                        </a>
                    </div>
                    @endif
                    
                    <!-- Quick Stats -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 px-3">
                            <i class="fas fa-chart-bar mr-2"></i>Statistik Cepat
                        </p>
                        
                        <div class="space-y-2 px-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Stok Rendah:</span>
                                <span class="font-bold text-red-600">
                                    {{ \App\Models\Product::where('stock', '<', 10)->where('stock', '>', 0)->count() }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Stok Habis:</span>
                                <span class="font-bold text-red-600">
                                    {{ \App\Models\Product::where('stock', 0)->count() }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Hari Ini:</span>
                                <span class="font-bold text-green-600">
                                    Rp {{ number_format(\App\Models\Transaction::whereDate('created_at', today())->sum('total_amount') ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Logout -->
                    <div class="pt-6 border-t mt-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center space-x-3 p-3 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg">
                                <i class="fas fa-sign-out-alt w-5"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-h-0 overflow-hidden">
            <!-- Top Bar -->
            <div class="bg-white shadow-sm border-b flex-shrink-0">
                <div class="px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">
                                @yield('title')
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                H'Mart Supermarket • {{ now()->format('l, d F Y') }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="bg-blue-50 px-4 py-2 rounded-lg">
                                <div class="text-sm text-gray-600">Shift Kasir</div>
                                <div class="font-bold text-blue-600">{{ auth()->user()->name }}</div>
                            </div>
                            <div class="bg-gray-100 px-4 py-2 rounded-lg">
                                <div id="currentTime" class="font-mono">
                                    {{ now()->format('H:i:s') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t px-6 py-3 flex-shrink-0">
                <div class="flex justify-between items-center text-sm text-gray-600">
                    <div>
                        <i class="fas fa-copyright mr-1"></i> 
                        H'Mart Supermarket • Sistem Kasir v1.0
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-500">
                            <span id="clockTime">{{ date('H:i:s') }}</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            $('#currentTime').text(timeString);
            $('#clockTime').text(timeString);
        }
        
        $(document).ready(function() {
            updateClock();
            setInterval(updateClock, 1000);
        });
    </script>
    
    @stack('scripts')
</body>
</html>