

<?php $__env->startSection('title', 'Riwayat Transaksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Transaksi Hari Ini</h1>
        <div class="flex items-center space-x-4">
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg">
                <i class="fas fa-money-bill-wave mr-2"></i>
                Total: <strong>Rp <?php echo e(number_format($totalToday, 0, ',', '.')); ?></strong>
            </div>
            
            <!-- Export Button -->
            <div class="relative">
                <button id="exportDropdownBtn" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                    <i class="fas fa-file-export mr-2"></i> Export Data
                    <i class="fas fa-chevron-down ml-2 text-sm"></i>
                </button>
                
                <!-- Dropdown Export Options -->
                <div id="exportDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border hidden z-10">
                    <div class="py-2">
                        <a href="<?php echo e(route('cashier.export.today')); ?>" 
                           target="_blank"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <i class="fas fa-calendar-day mr-2 text-green-600"></i> 
                            <div>
                                <div>Hari Ini</div>
                                <div class="text-xs text-gray-500">(Excel)</div>
                            </div>
                        </a>
                        <a href="<?php echo e(route('cashier.export.month')); ?>" 
                           target="_blank"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                            <i class="fas fa-calendar-alt mr-2 text-blue-600"></i>
                            <div>
                                <div>Bulan Ini</div>
                                <div class="text-xs text-gray-500">(Excel)</div>
                            </div>
                        </a>
                        <button id="exportCustomBtn" 
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-calendar mr-2 text-purple-600"></i> Custom Date Range
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p class="text-gray-600 mt-2"><?php echo e(now()->format('l, d F Y')); ?></p>
</div>

<!-- Date Range Modal (Hidden by default) -->
<div id="dateRangeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-96 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-900">Export Data Transaksi</h3>
            <button id="closeDateRangeModal" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        
        <form id="exportForm" action="<?php echo e(route('cashier.export.custom')); ?>" method="GET" target="_blank">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" 
                           name="start_date" 
                           id="start_date"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="<?php echo e(date('Y-m-d')); ?>"
                           required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" 
                           name="end_date" 
                           id="end_date"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="<?php echo e(date('Y-m-d')); ?>"
                           required>
                </div>
                
                <div class="flex space-x-3 pt-4">
                    <button type="button" 
                            id="cancelExport" 
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center justify-center">
                        <i class="fas fa-download mr-2"></i> Export Excel
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-sm text-gray-600">Total Transaksi</div>
        <div class="text-2xl font-bold text-gray-900"><?php echo e($transactions->total()); ?></div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-sm text-gray-600">Rata-rata/Transaksi</div>
        <div class="text-2xl font-bold text-gray-900">
            Rp <?php echo e(number_format($transactions->avg('total_amount') ?? 0, 0, ',', '.')); ?>

        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-sm text-gray-600">Transaksi Tunai</div>
        <div class="text-2xl font-bold text-gray-900">
            <?php echo e($transactions->where('payment_method', 'cash')->count()); ?>

        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="text-sm text-gray-600">Transaksi Non-Tunai</div>
        <div class="text-2xl font-bold text-gray-900">
            <?php echo e($transactions->where('payment_method', '!=', 'cash')->count()); ?>

        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Invoice
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Waktu
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kasir
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Total
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Pembayaran
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kembalian
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            <?php echo e($transaction->invoice_number); ?>

                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            <?php echo e($transaction->created_at->format('H:i:s')); ?>

                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            <?php echo e($transaction->user->name); ?>

                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-bold text-green-600">
                            Rp <?php echo e(number_format($transaction->total_amount, 0, ',', '.')); ?>

                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            <?php if($transaction->payment_method == 'cash'): ?> bg-green-100 text-green-800
                            <?php elseif($transaction->payment_method == 'debit_card'): ?> bg-blue-100 text-blue-800
                            <?php elseif($transaction->payment_method == 'credit_card'): ?> bg-purple-100 text-purple-800
                            <?php else: ?> bg-orange-100 text-orange-800
                            <?php endif; ?>">
                            <?php echo e(strtoupper(str_replace('_', ' ', $transaction->payment_method))); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        Rp <?php echo e(number_format($transaction->change, 0, ',', '.')); ?>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="<?php echo e(route('cashier.receipt', $transaction->id)); ?>" 
                           target="_blank"
                           class="text-blue-600 hover:text-blue-900 mr-3">
                            <i class="fas fa-print"></i> Cetak
                        </a>
                        <button class="view-details text-green-600 hover:text-green-900"
                                data-transaction-id="<?php echo e($transaction->id); ?>">
                            <i class="fas fa-eye"></i> Detail
                        </button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center">
                        <div class="text-gray-500">
                            <i class="fas fa-shopping-cart text-4xl mb-3"></i>
                            <p class="text-lg">Belum ada transaksi hari ini</p>
                            <p class="text-sm mt-2">Mulai transaksi di halaman POS</p>
                            <a href="<?php echo e(route('cashier.index')); ?>" 
                               class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                <i class="fas fa-cash-register mr-2"></i> Buka POS
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($transactions->hasPages()): ?>
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        <?php echo e($transactions->links()); ?>

    </div>
    <?php endif; ?>
</div>

<!-- Modal Detail Transaksi -->
<div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Detail Transaksi</h3>
            <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        <div id="modalContent">
            <!-- Detail akan diisi via AJAX -->
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle export dropdown
    const exportDropdownBtn = document.getElementById('exportDropdownBtn');
    const exportDropdown = document.getElementById('exportDropdown');
    const exportCustomBtn = document.getElementById('exportCustomBtn');
    const dateRangeModal = document.getElementById('dateRangeModal');
    const closeDateRangeModal = document.getElementById('closeDateRangeModal');
    const cancelExport = document.getElementById('cancelExport');
    const exportForm = document.getElementById('exportForm');
    
    if (exportDropdownBtn) {
        exportDropdownBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            exportDropdown.classList.toggle('hidden');
        });
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (exportDropdown && exportDropdownBtn) {
            if (!exportDropdown.contains(e.target) && !exportDropdownBtn.contains(e.target)) {
                exportDropdown.classList.add('hidden');
            }
        }
    });
    
    // Show date range modal
    if (exportCustomBtn) {
        exportCustomBtn.addEventListener('click', function(e) {
            e.preventDefault();
            dateRangeModal.classList.remove('hidden');
            exportDropdown.classList.add('hidden');
        });
    }
    
    // Close date range modal
    if (closeDateRangeModal) {
        closeDateRangeModal.addEventListener('click', function(e) {
            e.preventDefault();
            dateRangeModal.classList.add('hidden');
        });
    }
    
    if (cancelExport) {
        cancelExport.addEventListener('click', function(e) {
            e.preventDefault();
            dateRangeModal.classList.add('hidden');
        });
    }
    
    // Validate date range
    if (exportForm) {
        exportForm.addEventListener('submit', function(e) {
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);
            
            if (startDate > endDate) {
                e.preventDefault();
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir!');
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
            submitBtn.disabled = true;
            
            // Restore button after 5 seconds if something goes wrong
            setTimeout(function() {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 5000);
        });
    }
    
    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.id === 'detailModal' || e.target.id === 'dateRangeModal') {
            document.getElementById('detailModal').classList.add('hidden');
            document.getElementById('dateRangeModal').classList.add('hidden');
        }
    });
    
    // ESC key closes modals
    document.addEventListener('keyup', function(e) {
        if (e.key === 'Escape') {
            if (document.getElementById('detailModal')) {
                document.getElementById('detailModal').classList.add('hidden');
            }
            if (document.getElementById('dateRangeModal')) {
                document.getElementById('dateRangeModal').classList.add('hidden');
            }
            if (exportDropdown) {
                exportDropdown.classList.add('hidden');
            }
        }
    });
    
    // View transaction details (jika menggunakan jQuery)
    if (typeof $ !== 'undefined') {
        $('.view-details').on('click', function() {
            const transactionId = $(this).data('transaction-id');
            
            $.ajax({
                url: `/cashier/receipt/${transactionId}`,
                method: 'GET',
                success: function(response) {
                    $('#modalContent').html(response);
                    $('#detailModal').removeClass('hidden');
                }
            });
        });
        
        $('#closeModal').on('click', function() {
            $('#detailModal').addClass('hidden');
        });
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.cashier', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\KULIAH\SERTIFIKASI\h-mart-kasir\resources\views/cashier/transactions.blade.php ENDPATH**/ ?>