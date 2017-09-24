<?php

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

Route::get('/', function () {
    return view('welcome');
});

//ingresos
Route::get('/ingreso/listar', 'IncomeController@index');
Route::get('/ingreso/agregar', 'IncomeController@add');
Route::post('/ingreso/agregar', 'IncomeController@add');
Route::get('/ingreso/editar/{id}', 'IncomeController@edit');
Route::post('/ingreso/editar/{id}', 'IncomeController@edit');
Route::get('/ingreso/borrar/{id}', 'IncomeController@delete');

//gastos
Route::get('/gasto/listar', 'ExpenseController@index');
Route::get('/gasto/agregar', 'ExpenseController@add');
Route::post('/gasto/agregar', 'ExpenseController@add');
Route::get('/gasto/editar/{id}', 'ExpenseController@edit');
Route::post('/gasto/editar/{id}', 'ExpenseController@edit');
Route::get('/gasto/borrar/{id}', 'ExpenseController@delete');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
