<?php

use Illuminate\Support\Facades\Auth;
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
    return view('adminlte::auth.login');
});


Auth::routes();



Route::group(['middleware' => 'auth'], function () {

Route::resource('home', 'App\Http\Controllers\HomeController');

Route::resource('laboratorios', 'App\Http\Controllers\LaboratorioController');

Route::resource('reservas', 'App\Http\Controllers\ReservaController');

Route::resource('solicitante', 'App\Http\Controllers\SolicitanteController');

Route::resource('users', 'App\Http\Controllers\UsersController');

Route::resource('disciplinas', 'App\Http\Controllers\DisciplinaController');

Route::get('/calendario', [\App\Http\Controllers\CalendarioController::class, 'index']);

Route::get('/calendario/buscaReservasLab' , 'App\Http\Controllers\CalendarioController@buscaReservasLab')->name('calendario.buscaReservasLab');

Route::get('/calendario/mostrar', [\App\Http\Controllers\CalendarioController::class, 'show']);

Route::get('/reservas/{id}/alterar_status','App\Http\Controllers\ReservaController@alterarStatus')->name('reserva.alterar.status');


});
