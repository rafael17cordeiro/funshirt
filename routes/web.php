<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\TshirtImageController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/catalogo', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalogo/{id}', [CatalogController::class, 'show'])->name('catalog.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ==========================================
// PERFIL DO UTILIZADOR (Área Protegida)
// ==========================================
Route::middleware(['auth', 'role:C,A'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); 
});



// REQUISITO G4: Rotas do Checkout Protegida
Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->middleware(['auth'])->name('checkout.index');
Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])->middleware(['auth'])->name('checkout.store');

// Rota para a Listagem de Encomendas do G4
Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
// Rota para ver os Detalhes de uma Encomenda específica
Route::get('/admin/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
// Rota para atualizar o estado da encomenda (G4)
Route::patch('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');


// Rota para o Cliente ver as suas próprias encomendas
Route::get('/minhas-encomendas', [\App\Http\Controllers\OrderController::class, 'myOrders'])->name('customer.orders.index');
Route::get('/encomendas/{id}', [OrderController::class, 'showOrder'])->middleware('auth')->name('customer.orders.show');
Route::get('/orders/{id}/receipt', [App\Http\Controllers\OrderController::class, 'downloadReceipt'])->name('customer.orders.receipt');

Route::patch('/admin/users/{id}/block', [UserController::class, 'toggleBlock'])->name('admin.users.block');

// ==========================================
// CARRINHO DE COMPRAS
// ==========================================
Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrinho/adicionar', [CartController::class, 'store'])->name('cart.store');
// Route::patch('/carrinho/{key}', [CartController::class, 'update'])->name('cart.update');
Route::put('/carrinho/{key}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrinho/limpar', [CartController::class, 'clear'])->name('cart.clear'); // Colocar ANTES da rota com parâmetro {key} para evitar conflitos de URL
Route::delete('/carrinho/{key}', [CartController::class, 'destroy'])->name('cart.destroy');


// ==========================================
// BACKOFFICE ADMIN (Apenas Administradores)
// ==========================================
Route::middleware(['auth', 'role:A'])->prefix('admin')->name('admin.')->group(function () {

    // --- PRODUTO E CATÁLOGO (Membro 3) ---
    Route::resource('categories', CategoryController::class);
    Route::resource('colors', ColorController::class);
    Route::resource('tshirt_images', TshirtImageController::class);
    Route::get('/prices', [PriceController::class, 'index'])->name('prices.index');
    Route::put('/prices', [PriceController::class, 'update'])->name('prices.update');

    // --- UTILIZADORES E CLIENTES (Membro 2) ---
    // CRUD de Colaboradores (Funcionários e Administradores)
    Route::resource('users', UserController::class);

    // Gestão de Clientes (Listagem, Bloqueio e Soft Delete)
    Route::get('/clients', [UserController::class, 'clientsIndex'])->name('clients.index');
    Route::patch('/clients/{id}/toggle-block', [UserController::class, 'toggleBlock'])->name('clients.toggle-block');
    Route::delete('/clients/{id}', [UserController::class, 'destroyClient'])->name('clients.destroy');
});

require __DIR__ . '/auth.php';