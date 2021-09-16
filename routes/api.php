<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Rotas Principais
Route::get('/', 'App\Http\Controllers\ControladorPrincipal@index')->name('index');
Route::post('/register', 'App\Http\Controllers\ControladorCadastro@cadastro')->name('register');
Route::post('/login', 'App\Http\Controllers\ControladorLogin@login')->name('login');
Route::get('/email', 'App\Http\Controllers\MailController@sendEmail')->name('email');

// TCC's
Route::get('/tcc', 'App\Http\Controllers\ControladorTCC@listarTcc')->name('listarTcc');
Route::get('/tcc/{id_user}', 'App\Http\Controllers\ControladorTCC@getTccByUser')->name('getTcc');
Route::post('/new-tcc', 'App\Http\Controllers\ControladorTCC@novoTcc')->name('novoTcc');
Route::post('/att-tcc', 'App\Http\Controllers\ControladorTCC@updateTcc')->name('updateTcc');
Route::post('/inactivate-tcc', 'App\Http\Controllers\ControladorTCC@inactivateTcc')->name('inactivateTcc');