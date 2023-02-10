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

Route::get('/', function () {
    $aArray = [10,20,30,40,50,60,70];
    $aNome = ['Samuel', 'Isadora', 'Marilucia'];

    return view('welcome', ['array' => $aArray, 'nome' => $aNome]);
});

Route::get('/contact', function () {
    $sBusca = request('search');

    return view('contact', ['busca' => $sBusca]);
});

Route::get('/produtos', function () {
    return view('products');
});

Route::get('/produtos_teste/{id?}', function ($id = null) {
    return view('product', ['id' => $id]);
});
