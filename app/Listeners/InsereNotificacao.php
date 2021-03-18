<?php

namespace App\Listeners;

use App\Api\CurlMaker;
use App\Events\UsuarioRecebeuPagamento;
use App\Models\Notification;
use App\Models\UsuarioSistema;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InsereNotificacao
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UsuarioRecebeuPagamento $event)
    {
        $dataCheckTransf = CurlMaker::get('https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');

        if(!empty($dataCheckTransf) && $dataCheckTransf['message'] == "Enviado")
        {
            $carteira = $event->carteira;

            $userInfo = UsuarioSistema::find($carteira->user_to);

            $notifcation = new Notification;
            $notifcation->not_desc = "{$userInfo->usu_nome} transferiu/pagou para você R$ ".number_format($carteira->valor, 2, ',', '.');
            $notifcation->usu_id = $carteira->user_from;
            $notifcation->save();
        }
    }
}
