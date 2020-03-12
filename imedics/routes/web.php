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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/usuarios', 'UsuarioController@usuarios');
Route::post('/registrar', 'UsuarioController@Criar');
Route::post('/editar', 'UsuarioController@editar');
Route::post('/usuarios/excluir', 'UsuarioController@excluir');
Route::post('/usuarios/editar', 'UsuarioController@editar');
Route::get('/usuarios/data', 'UsuarioController@data');

Route::get('/pacientes', 'PacientesController@pacientes');
Route::post('/pacientes/criar', 'PacientesController@criar');
Route::post('/pacientes/editar', 'PacientesController@editar');
Route::post('/pacientes/excluir', 'PacientesController@excluir');
Route::get('/pacientes/data', 'PacientesController@data');

Route::get('/medicos', 'MedicosController@medicos');

Route::get('/agendamentos', 'AgendamentosController@agendamentos');
