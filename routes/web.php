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

// BLOCO BACKOFFICE ADMIN (Apenas Administradores)
Route::middleware(['auth', 'role:A'])->prefix('admin')->name('admin.')->group(function () {

    // CRUD de Colaboradores (Funcionários e Administradores)
    Route::resource('users', App\Http\Controllers\UserController::class);

    // Gestão de Clientes
    Route::get('clientes', [App\Http\Controllers\UserController::class, 'clientsIndex'])->name('clients.index');
    Route::patch('clientes/{user}/bloquear', [App\Http\Controllers\UserController::class, 'toggleBlock'])->name('clients.toggleBlock');
});

Route::get('/catalogo/{id}', [CatalogController::class, 'show'])->name('catalog.show');
Route::post('/carrinho/adicionar', [CartController::class, 'store'])->name('cart.store');
Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
Route::delete('/carrinho/{key}', [CartController::class, 'destroy'])->name('cart.destroy');
require __DIR__ . '/auth.php';
