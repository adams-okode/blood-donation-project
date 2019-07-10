<?php

namespace App\Helpers;

use App\Events\PusherEvent;
use Illuminate\Support\Facades\App;

class RealTime
{

    public $pusher;

    const NEW_REQUEST_NOTIFICATION = 'NEW_REQUEST_NOTIFICATION';
    const ACCEPTANCE_REQUEST_NOTIFICATION = 'ACCEPTANCE_REQUEST_NOTIFICATION';

    public function __construct()
    {

    }

    /**
     * @param $chanel
     * @param $data
     * @return boolean $response
     */
    public function sendNotification(String $channel, array $data)
    {
        $response = true;
        try {
            event(new PusherEvent($channel, self::NEW_REQUEST_NOTIFICATION, $data));
            return $response;
        } catch (\Throwable $th) {
            //throw $th;
            // \Log::error($th->getMessage());
            return $response = false;
        }
    }

    /**
     * @param $chanel
     * @param $data
     * @return boolean $response
     */
    public function sendAcceptanceNotification(String $channel, array $data)
    {
        $response = true;
        try {
            event(new PusherEvent($channel, self::ACCEPTANCE_REQUEST_NOTIFICATION, $data));
            return $response;
        } catch (\Throwable $th) {
            //throw $th;
            // \Log::error($th->getMessage());
            return $response = false;
        }
    }

}
