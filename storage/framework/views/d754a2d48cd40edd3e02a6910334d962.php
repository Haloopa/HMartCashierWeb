

<?php $__env->startSection('title', 'Kelola Kasir'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">
            <i class="fas fa-users mr-2"></i>Kelola Kasir
        </h1>
        <a href="<?php echo e(route('admin.users.create')); ?>" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-user-plus mr-2"></i>Tambah Kasir Baru
        </a>
    </div>
</div>

<?php if(session('success')): ?>
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    <?php echo e(session('error')); ?>

</div>
<?php endif; ?>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Bergabung</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-700"><?php echo e(($users->currentPage() - 1) * $users->perPage() + $loop->iteration); ?></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-2 rounded-full mr-3">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900"><?php echo e($user->name); ?></div>
                                <div class="text-sm text-gray-500">
                                    <?php if($user->id === auth()->id()): ?>
                                        <span class="text-green-600">✓ Anda</span>
                                    <?php else: ?>
                                        Kasir
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-gray-900"><?php echo e($user->email); ?></div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-600">
                            <?php echo e($user->created_at->format('d/m/Y')); ?>

                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <a href="<?php echo e(route('admin.users.show', $user)); ?>" 
                           class="text-blue-600 hover:text-blue-900 mr-3" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?php echo e(route('admin.users.edit', $user)); ?>" 
                           class="text-green-600 hover:text-green-900 mr-3" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <?php if($user->id !== auth()->id()): ?>
                        <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Hapus kasir ini?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t border-gray-200">
        <?php echo e($users->links()); ?>

    </div>
</div>

<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
    <h3 class="font-bold text-blue-900 mb-3">
        <i class="fas fa-info-circle mr-2"></i>Informasi
    </h3>
    <ul class="text-sm text-blue-800 space-y-2">
        <li>• Total ada <strong><?php echo e($users->total()); ?></strong> kasir terdaftar</li>
        <li>• Menampilkan <?php echo e($users->count()); ?> dari <?php echo e($users->total()); ?> kasir</li>
        <li>• Kasir tidak dapat menghapus akun sendiri</li>
        <li>• Password default untuk kasir baru: sesuai yang diinput</li>
    </ul>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.cashier', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\KULIAH\SERTIFIKASI\h-mart-kasir\resources\views/admin/users/index.blade.php ENDPATH**/ ?>