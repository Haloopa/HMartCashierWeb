<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

Route::middleware('auth:sanctum')->get('/low-stock-count', function (Request $request) {
    return Product::where('stock', '<', 10)->where('stock', '>', 0)->count();
});