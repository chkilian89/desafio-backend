<?php

use Illuminate\Support\Facades\Route;

Route::name('login.')->namespace('App\Modules\Login\Controllers')->group(function(){
    Route::get('/','LoginController@index')->name('index');
    Route::post('/login','LoginController@login')->name('login');
    Route::get('/logout','LoginController@logout')->name('logout');

    Route::get('/novo-registro/cadastrar', 'RegisterController@create')->name('newUser');
    Route::post('/novo-registro/salvar', 'RegisterController@criar')->name('saveUser');

});
