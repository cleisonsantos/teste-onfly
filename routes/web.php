<?php

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('despesas', 'App\Http\Controllers\ExpenseController@index')->name('expense.index');

Route::post('despesas', 'App\Http\Controllers\ExpenseController@store')->name('expense.store');

Route::put('despesas/{expense}', 'App\Http\Controllers\ExpenseController@update')->name('expense.update');

Route::delete('despesas/{expense}', 'App\Http\Controllers\ExpenseController@destroy')->name('expense.destroy');

