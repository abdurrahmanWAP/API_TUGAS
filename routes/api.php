<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\Api\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('products', ProductController::class);
Route::apiResource('keranjangs', KeranjangController::class);
Route::resource('pesanans', PesananController::class);

Route::get('/product', [ProductController::class, 'home']);

Route::get('/product/cari', [ProductController::class, 'search']);

Route::get('/best-product', [ProductController::class, 'home1']);

