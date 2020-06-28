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

Route::get('index',function(){
    return view('index');
});

Route::group(['middleware' => 'auth'], function(){
    Route::prefix('matricula')->name('matricula.')->group(function(){
        Route::resource('aluno','AlunoController');    
        Route::resource('curso','CursoController');
    });
    
    Route::get('aluno/listar','AlunoController@listarAluno');

    Route::get('curso/importarxml','CursoController@importarXml');
    Route::post('curso/importar','CursoController@importar');
    Route::get('curso/listar','CursoController@listarCursos');
});





Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
