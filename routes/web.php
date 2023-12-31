<?php

use App\Enums\Status;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('stripe', [PaymentController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('users', UserController::class);

    Route::get('subscriptions/{product_id}/status/{type}', [SubscriptionController::class, 'redirectPath'])->name('subscriptions.redirectPath')->whereIn('type', [Status::SUCCESS(), Status::ERROR()]);

    Route::get('subscriptions/checkout/{product_id}/{type}', [SubscriptionController::class, 'checkout'])->name('subscriptions.checkout')->whereIn('type' , ['subscription', 'payment']);

    Route::resource('subscriptions', SubscriptionController::class);
    Route::resource('products', ProductController::class);
    Route::resource('transactions', TransactionController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
