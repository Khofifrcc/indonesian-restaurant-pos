<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;

Route::get('/login', [PosController::class, 'loginPage'])->name('pos.loginPage');
Route::post('/login', [PosController::class, 'login'])->name('pos.login');

Route::get('/', [PosController::class, 'index'])->name('pos.index');
Route::post('/order/add-item', [PosController::class, 'addItem'])->name('pos.addItem');
Route::post('/order/clear', [PosController::class, 'clearOrder'])->name('pos.clear');
Route::post('/order/create', [PosController::class, 'createOrder'])->name('pos.createOrder');
Route::post('/payment', [PosController::class, 'pay'])->name('pos.pay');

Route::get('/reports', [PosController::class, 'reports'])->name('pos.reports');
Route::post('/logout', [PosController::class, 'logout'])->name('pos.logout');
Route::post('/cart/increase/{index}', [PosController::class, 'increaseItem'])->name('pos.increase');
Route::post('/cart/decrease/{index}', [PosController::class, 'decreaseItem'])->name('pos.decrease');
Route::post('/cart/remove/{index}', [PosController::class, 'removeItem'])->name('pos.removeItem');
Route::get('/products/manage', [PosController::class, 'manageProducts'])->name('pos.manageProducts');
Route::post('/products/add', [PosController::class, 'addProduct'])->name('pos.addProduct');
Route::post('/products/delete/{id}', [PosController::class, 'deleteProduct'])->name('pos.deleteProduct');

Route::get('/staff/manage', [PosController::class, 'manageStaff'])->name('pos.manageStaff');
Route::post('/staff/add', [PosController::class, 'addStaff'])->name('pos.addStaff');
Route::post('/staff/delete/{id}', [PosController::class, 'deleteStaff'])->name('pos.deleteStaff');
Route::get('/receipt/{id}', [PosController::class, 'receipt'])->name('pos.receipt');
Route::get('/tables', [PosController::class, 'tables'])->name('pos.tables');
Route::get('/table/{number}', [PosController::class, 'selectTable'])->name('pos.selectTable');
Route::post('/staff/toggle/{id}', [PosController::class, 'toggleStaff'])
    ->name('pos.toggleStaff');