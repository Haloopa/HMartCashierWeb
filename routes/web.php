<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile 
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cashier 
    Route::prefix('cashier')->group(function () {
        Route::get('/', [CashierController::class, 'index'])->name('cashier.index');
        Route::post('/search', [CashierController::class, 'searchProduct'])->name('cashier.search');
        Route::post('/process', [CashierController::class, 'processTransaction'])->name('cashier.process');
        Route::get('/receipt/{id}', [CashierController::class, 'receipt'])->name('cashier.receipt');
        Route::get('/transactions', [CashierController::class, 'todayTransactions'])->name('cashier.transactions');
        
        // Export 
        Route::get('/export/today', [CashierController::class, 'exportToday'])->name('cashier.export.today');
        Route::get('/export/month', [CashierController::class, 'exportMonth'])->name('cashier.export.month');
        Route::get('/export/custom', [CashierController::class, 'exportCustom'])->name('cashier.export.custom');
    });

    // Product 
    Route::resource('products', ProductController::class);

    // Category
    Route::resource('categories', CategoryController::class);
});

// Admin-only 
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';