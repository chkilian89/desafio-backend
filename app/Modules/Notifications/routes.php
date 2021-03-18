<?php

Route::middleware('auth')->name('notifications.')->prefix('notifications')->namespace('App\Modules\Notifications\Controllers')->group(function()
{
    Route::post('/get-notificacoes', 'NotificationsController@getNotificationByMenu')->name('getNotificaoes');

});
