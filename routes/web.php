<?php

use App\Http\Middleware\AbortCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// });

Route::middleware(['user.ban'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Auth::routes();

    Route::put('/ban/{user}', [App\Http\Controllers\UserController::class, 'ban'])->name('users.ban');

    Route::resource('/users', App\Http\Controllers\UserController::class)->except('index', 'create', 'store');
    Route::resource('/gammes', App\Http\Controllers\GammeController::class);
    Route::resource('/products', App\Http\Controllers\ProductController::class);
    Route::resource('/commandes', App\Http\Controllers\CommandeController::class);
    Route::resource('/satisfactions', App\Http\Controllers\SatisfactionController::class);
    Route::resource('/comments', App\Http\Controllers\CommentController::class);
    Route::resource('/askings', App\Http\Controllers\AskingController::class);
    Route::resource('/catalogues', App\Http\Controllers\CatalogueController::class);

    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin')->middleware('admin');
    Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
    Route::get('/pasapas', [App\Http\Controllers\HomeController::class, 'pasapas'])->name('pasapas');
    Route::get('/politiques', [App\Http\Controllers\HomeController::class, 'politiques'])->name('politiques');

    Route::get('cart', [App\Http\Controllers\CartController::class, 'show'])->name('cart.show')->middleware(AbortCart::class);
    Route::post('cart/add/{product}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add')->middleware(AbortCart::class);
    Route::get('cart/remove/{product}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove')->middleware(AbortCart::class);
    Route::get('cart/empty', [App\Http\Controllers\CartController::class, 'empty'])->name('cart.empty')->middleware(AbortCart::class);
    Route::get('cart/emptyAfterOrder', [App\Http\Controllers\CartController::class, 'emptyAfterOrder'])->name('cart.emptyAfterOrder')->middleware(AbortCart::class);
});
