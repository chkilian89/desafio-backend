<?php
Route::name('dynamicjs.')->prefix('dynamicjs')->namespace('App\Modules\Dynamicjs\Controllers')->group(function()
{
    Route::get('base.js','DynamicjsController@base')->name('base.js');
    Route::get('lang.js','DynamicjsController@lang')->name('lang.js');
});
