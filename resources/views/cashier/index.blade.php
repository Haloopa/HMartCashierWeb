@extends('layouts.cashier')

@section('title', 'Point of Sale - H\'Mart')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">
        <i class="fas fa-cash-register mr-2"></i>Point of Sale
    </h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Products -->
    <div class="lg:col-span-2">
        <!-- Search -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <input type="text" 
                   id="searchInput" 
                   placeholder="Cari produk..." 
                   class="w-full p-3 border rounded-lg"
                   autofocus>
        </div>

        <!-- Products -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Produk Tersedia</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="productsContainer">
                @foreach($products as $product)
                <div class="border rounded-lg p-3 hover:bg-gray-50 cursor-pointer product"
                     data-id="{{ $product->id }}"
                     data-name="{{ $product->name }}"
                     data-price="{{ $product->price }}"
                     data-stock="{{ $product->stock }}">
                    <div class="font-bold">{{ $product->name }}</div>
                    <div class="text-green-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    <div class="text-sm text-gray-600 mt-1">
                        <span class="bg-gray-100 px-2 py-1 rounded">{{ $product->category->name ?? 'Umum' }}</span>
                        <span class="ml-2 {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                            Stok: {{ $product->stock }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Cart -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">Keranjang</h2>
            
            <!-- Cart Items -->
            <div id="cartContainer" class="mb-6 max-h-80 overflow-y-auto">
                <div class="text-center py-8 text-gray-500" id="emptyCart">
                    Keranjang kosong
                </div>
            </div>

            <!-- Total -->
            <div class="border-t pt-4 mb-4">
                <div class="flex justify-between text-lg font-bold">
                    <span>Total:</span>
                    <span id="totalDisplay">Rp 0</span>
                </div>
            </div>

            <!-- Payment -->
            <div class="space-y-4">
                <div>
                    <label class="block mb-2">Bayar</label>
                    <input type="number" id="paymentInput" class="w-full p-2 border rounded" placeholder="Rp">
                </div>
                
                <div>
                    <label class="block mb-2">Kembalian</label>
                    <div id="changeDisplay" class="p-2 bg-blue-50 rounded font-bold">Rp 0</div>
                </div>

                <button id="checkoutBtn" class="w-full bg-green-600 text-white p-3 rounded-lg font-bold">
                    CHECKOUT
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let cart = [];
    
    function formatRp(amount) {
        return 'Rp ' + amount.toLocaleString('id-ID');
    }
    
    function updateDisplay() {
        let total = 0;
        cart.forEach(item => {
            total += item.price * item.quantity;
        });
        
        document.getElementById('totalDisplay').textContent = formatRp(total);
        
        const payment = parseFloat(document.getElementById('paymentInput').value) || 0;
        const change = payment - total;
        document.getElementById('changeDisplay').textContent = formatRp(change > 0 ? change : 0);
        
        const cartContainer = document.getElementById('cartContainer');
        if (cart.length === 0) {
            cartContainer.innerHTML = '<div class="text-center py-8 text-gray-500" id="emptyCart">Keranjang kosong</div>';
            return;
        }
        
        let html = '<div class="space-y-2">';
        cart.forEach((item, index) => {
            html += `
                <div class="border rounded p-3">
                    <div class="flex justify-between">
                        <div>
                            <div class="font-bold">${item.name}</div>
                            <div class="text-sm">${formatRp(item.price)} x ${item.quantity}</div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-green-600">${formatRp(item.price * item.quantity)}</div>
                            <button onclick="removeFromCart(${index})" class="text-red-500 text-sm">Hapus</button>
                        </div>
                    </div>
                </div>
            `;
        });
        html += '</div>';
        cartContainer.innerHTML = html;
    }
    
    window.addToCart = function(productElement) {
        const id = productElement.getAttribute('data-id');
        const name = productElement.getAttribute('data-name');
        const price = parseFloat(productElement.getAttribute('data-price'));
        const stock = parseInt(productElement.getAttribute('data-stock'));
        
        let existing = cart.find(item => item.id == id);
        if (existing) {
            if (existing.quantity < stock) {
                existing.quantity++;
            } else {
                alert('Stok tidak cukup!');
                return;
            }
        } else {
            cart.push({
                id: id,
                name: name,
                price: price,
                quantity: 1,
                stock: stock
            });
        }
        
        updateDisplay();
    };
    
    window.removeFromCart = function(index) {
        cart.splice(index, 1);
        updateDisplay();
    };
    
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const search = e.target.value.toLowerCase();
        const products = document.querySelectorAll('.product');
        
        products.forEach(product => {
            const name = product.getAttribute('data-name').toLowerCase();
            if (name.includes(search)) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    });
    
    document.getElementById('checkoutBtn').addEventListener('click', function() {
        if (cart.length === 0) {
            alert('Keranjang kosong!');
            return;
        }
        
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const payment = parseFloat(document.getElementById('paymentInput').value) || 0;
        
        if (payment < total) {
            alert('Pembayaran kurang!');
            return;
        }
        
        if (!confirm(`Proses transaksi sebesar ${formatRp(total)}?`)) {
            return;
        }
        
        const items = cart.map(item => ({
            id: item.id,
            quantity: item.quantity
        }));
        
        const btn = this;
        btn.disabled = true;
        btn.textContent = 'Memproses...';
        
        fetch('{{ route("cashier.process") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                items: items,
                payment_method: 'cash',
                payment_amount: payment
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Transaksi berhasil! Invoice: ' + data.invoice_number);
                
                cart = [];
                updateDisplay();
                document.getElementById('paymentInput').value = '';
                document.getElementById('searchInput').value = '';
                
                if (data.transaction_id) {
                    window.open('/cashier/receipt/' + data.transaction_id, '_blank');
                }
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan: ' + error.message);
        })
        .finally(() => {
            btn.disabled = false;
            btn.textContent = 'CHECKOUT';
        });
    });
    
    document.getElementById('paymentInput').addEventListener('input', updateDisplay);
    
    document.querySelectorAll('.product').forEach(product => {
        product.addEventListener('click', function() {
            addToCart(this);
        });
    });
});
</script>
@endsection