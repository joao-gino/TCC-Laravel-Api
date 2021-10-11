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

// * Rotas Principais
Route::post('/register', 'App\Http\Controllers\ControladorCadastro@cadastro')->name('register'); // Cadastro de Usuários
Route::post('/login', 'App\Http\Controllers\ControladorLogin@login')->name('login'); // Login de Usuário
Route::get('/email', 'App\Http\Controllers\MailController@sendEmail')->name('email'); // Envio de e-mail pós-cadastro
Route::post('/recovery-password', 'App\Http\Controllers\ControladorCadastro@recoveryPassword')->name('recoveryPassword'); // Recuperação de Senha do usuário

// * TCC's
Route::get('/tcc', 'App\Http\Controllers\ControladorTCC@listarTcc')->name('listarTcc');
Route::get('/tcc/{id_user}', 'App\Http\Controllers\ControladorTCC@getTccByUser')->name('getTcc');
Route::post('/new-tcc', 'App\Http\Controllers\ControladorTCC@novoTcc')->name('novoTcc');
Route::put('/att-tcc', 'App\Http\Controllers\ControladorTCC@updateTcc')->name('updateTcc');
Route::delete('/inactivate-tcc/{id_tcc}', 'App\Http\Controllers\ControladorTCC@inactivateTcc')->name('inactivateTcc');

// * Etapas
Route::get('/etapas/{id_tcc}', 'App\Http\Controllers\ControladorEtapas@listarEtapas')->name('listarEtapas'); // * OK
Route::post('/etapas/new-etapa', 'App\Http\Controllers\ControladorEtapas@novaEtapa')->name('novaEtapa'); // * OK
Route::put('/etapas/att-etapa', 'App\Http\Controllers\ControladorEtapas@updateEtapa')->name('updateEtapa'); // * OK
Route::delete('/etapas/delete-etapa', 'App\Http\Controllers\ControladorEtapas@deleteEtapa')->name('deleteEtapa'); // * OK

// * Tasks Status
Route::get('/etapas/tasks/{id_etapa}', 'App\Http\Controllers\ControladorTasks@listarTasks')->name('listarTasks'); // * OK
Route::get('/etapas/tasks/{id_etapa}/{id_task}', 'App\Http\Controllers\ControladorTasks@getTask')->name('getTask'); //
Route::post('/etapas/tasks/new', 'App\Http\Controllers\ControladorTasks@novaTask')->name('newTask'); // * OK
Route::put('/etapas/tasks/att', 'App\Http\Controllers\ControladorTasks@updateTask')->name('updateTask'); // * OK
Route::delete('/etapas/tasks/delete', 'App\Http\Controllers\ControladorTasks@deleteTask')->name('deleteTask'); // * OK

// * Status
Route::get('/status', 'App\Http\Controllers\ControladorStatus@listarStatus')->name('listarStatus'); // * OK

// * Usuários
Route::get('/users', 'App\Http\Controllers\ControladorUsuarios@listarUsers')->name('listarUsers'); // * OK

// * Categorias
Route::get('/categories', 'App\Http\Controllers\ControladorCategorias@listarCategories')->name('listarCategories'); // * OK

// * Orientadores
Route::get('/advisors', 'App\Http\Controllers\ControladorOrientadores@listarAdvisors')->name('listarAdvisors'); // * OK