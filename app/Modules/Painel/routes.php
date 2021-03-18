<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('painel')->name('painel.')->namespace('App\Modules\Painel\Controllers')->group(function(){
    Route::get('/inicio','PainelController@index')->name('inicio');

    Route::post('/get-dados', 'PainelController@getDados')->name('get-dados');
    Route::post('/adicionar-saldo', 'PainelController@adicionarSaldo')->name('adicionar-saldo');
    Route::post('/transferir', 'PainelController@transferir')->name('transferir-saldo');

});
