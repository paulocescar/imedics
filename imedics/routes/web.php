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

Route::post('/registrar', 'UsuarioController@Criar');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/novoMedico', 'MedicosController@novo');
    Route::post('/medicos/criar', 'MedicosController@criar');

    Route::get('/agendamentos', 'AgendamentosController@agendamentos');
    Route::get('/agendar', 'AgendamentosController@agendar');
    Route::post('/agendar/criar', 'AgendamentosController@criar');
    Route::post('/agendamentos/cancelar', 'AgendamentosController@cancelar');
    Route::get('/agendamentos/data', 'AgendamentosController@data');

    Route::group(['middleware' => ['MedicoAcess']], function () {
        Route::get('/pacientes', 'PacientesController@pacientes');
        Route::get('/pacientes/data', 'PacientesController@data');
        
        Route::group(['middleware' => ['AdminAcess']], function () {
            Route::post('/pacientes/criar', 'PacientesController@criar');
            Route::post('/pacientes/editar', 'PacientesController@editar');
            Route::post('/pacientes/excluir', 'PacientesController@excluir');
            
            Route::get('/usuarios', 'UsuarioController@usuarios');
            Route::post('/editar', 'UsuarioController@editar');
            Route::post('/usuarios/excluir', 'UsuarioController@excluir');
            Route::post('/usuarios/editar', 'UsuarioController@editar');
            Route::get('/usuarios/data', 'UsuarioController@data');
            

            Route::get('/medicos', 'MedicosController@medicos');
            Route::post('/medicos/editar', 'MedicosController@editar');
            Route::post('/medicos/excluir', 'MedicosController@excluir');
            Route::get('/medicos/data', 'MedicosController@data');
        });
    });
});