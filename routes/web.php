<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Auth controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CustomerController;
// Adding the controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\WelcomeController;

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('providers', ProviderController::class);
    Route::resource('shippings', ShippingController::class);
    Route::resource('profile', ProfileController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('incomes', IncomeController::class);
    Route::patch('incomes/{id}/cancel', [IncomeController::class, 'cancel'])->name('incomes.cancel');
    Route::resource('sales', SaleController::class);
    Route::patch('sales/{id}/cancel', [SaleController::class, 'cancel'])->name('sales.cancel');
});

Route::middleware([])->group(function () {
    // Rutas para las vistas públicas
    Route::resource('welcome', WelcomeController::class);
    Route::get('/welcome', [WelcomeController::class, 'index']);
    Route::get('/all-products', [WelcomeController::class, 'showAllProducts'])->name('welcome.showAllProducts');
    Route::get('/product/{id}', [WelcomeController::class, 'create'])->name('welcome.create');
    Route::post('/cart/addToCart', [CartController::class, 'addToCart'])->name('cart.addToCart');
    Route::get('/cart/count', [CartController::class, 'getCartCount']);
    Route::get('/cart/watch', [CartController::class, 'showCart'])->name('cart.show');
    Route::match(['get', 'post'], '/cart/clear', [CartController::class, 'clearCart'])->name('cart.clearCart');
    Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.removeFromCart');
    Route::get('/cart/search-customer-by-dni', [CartController::class, 'searchByDni'])->name('search.customer.by.dni');
    Route::post('/cart/save-purchase', [CartController::class, 'savePurchase'])->name('cart.savePurchase');


    // Otras rutas...
});



// Define auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/forgot-password', [PasswordController::class, 'forgotPassword'])->name('password.email');
Route::post('/reset-password', [PasswordController::class, 'resetPassword'])->name('password.update');
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('password.email');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');

Auth::routes();

Route::get('profile/modify', [ProfileController::class, 'edit'])->name('profile.modify');

Route::get('/search-customer-by-dni', [CustomerController::class, 'searchByDni'])->name('search.customer.by.dni');
Route::post('/customers/useExistingCustomer', [CustomerController::class, 'useExistingCustomer'])->name('customers.useExistingCustomer');

// Define Client routes
Route::get('/shoppingCart', function () {
    return view('main.shoppingCart');
});
