<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalogo/{id}', [CatalogController::class, 'show'])->name('catalog.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// O TEU BLOCO VIP FICA AQUI!
Route::middleware(['auth', 'role:C,A'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// CARRINHO DE COMPRAS
Route::post('/carrinho/adicionar', [CartController::class, 'store'])->name('cart.store');
Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
Route::delete('/carrinho/{key}', [CartController::class, 'destroy'])->name('cart.destroy');

// ==========================================
// BACKOFFICE ADMIN (Membro 3 - Produto)
// ==========================================
Route::middleware(['auth', 'role:A'])->prefix('admin')->name('admin.')->group(function () {
    // Rotas CRUD para Categorias e Cores
    Route::resource('categories', CategoryController::class);
    Route::resource('colors', ColorController::class);
});

require __DIR__ . '/auth.php';