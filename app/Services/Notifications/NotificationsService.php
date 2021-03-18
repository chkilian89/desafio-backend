<?php

namespace App\Services\Notifications;


use App\Models\Notification;
use App\Services\BaseService;
use Carbon\Carbon;


class NotificationsService extends BaseService
{
    public function getNotificationsByUser($data)
    {
        $query = Notification::where('usu_id', $data['user'])
        ->orderBy('not_date_insert', 'DESC')
        ->get();

        return $query;
    }

}
