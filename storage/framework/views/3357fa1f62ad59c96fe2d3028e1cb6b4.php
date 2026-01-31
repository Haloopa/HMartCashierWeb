

<?php $__env->startSection('title', 'Edit Kasir'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">
        <i class="fas fa-edit mr-2"></i>Edit Kasir: <?php echo e($user->name); ?>

    </h1>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="<?php echo e(route('admin.users.update', $user)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="space-y-6">
                <!-- Nama -->
                <div>
                    <label class="block text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" 
                           name="name" 
                           value="<?php echo e(old('name', $user->name)); ?>"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 mb-2">Email *</label>
                    <input type="email" 
                           name="email" 
                           value="<?php echo e(old('email', $user->email)); ?>"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Password (Optional) -->
                <div class="border-t pt-6">
                    <h3 class="font-bold text-gray-700 mb-4">
                        <i class="fas fa-key mr-2"></i>Ganti Password (Opsional)
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 mb-2">Password Baru</label>
                            <input type="password" 
                                   name="password" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                                   placeholder="Kosongkan jika tidak ingin mengganti">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div>
                            <label class="block text-gray-700 mb-2">Konfirmasi Password</label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="<?php echo e(route('admin.users.index')); ?>" 
                   class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Update Kasir
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.cashier', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\KULIAH\SERTIFIKASI\h-mart-kasir\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>