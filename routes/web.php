<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// O TEU BLOCO VIP FICA AQUI!
Route::middleware(['auth', 'role:C,A'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/catalogo/{id}', [CatalogController::class, 'show'])->name('catalog.show');
Route::post('/carrinho/adicionar', [CartController::class, 'store'])->name('cart.store');
Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
Route::delete('/carrinho/{key}', [CartController::class, 'destroy'])->name('cart.destroy');
require __DIR__ . '/auth.php';