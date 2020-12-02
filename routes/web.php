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

/* Route::get('/', function () {
    return view('welcome');
}); */

Auth::routes();

Route::get('/{any?}', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('despesas', 'ExpenseController@show')->name('expense.show');

Route::post('despesas', 'ExpenseController@store')->name('expense.store');

Route::put('despesas/{expense}', 'ExpenseController@update')->name('expense.update');

Route::delete('despesas/{expense}', 'ExpenseController@destroy')->name('expense.destroy');

