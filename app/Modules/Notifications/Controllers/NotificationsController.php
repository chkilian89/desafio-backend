<?php

namespace App\Modules\Notifications\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function getNotificationByMenu()
    {
        return $this->_callService('Notifications\NotificationsService', 'getNotificationsByUser', ['user' => Auth::user()->usu_id]);
    }
}
