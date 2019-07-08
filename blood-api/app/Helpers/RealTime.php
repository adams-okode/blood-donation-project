<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;

class RealTime
{
    
    public static $pusher;

    const GENERAL_NOTIFICATION = 'GENERAL_NOTIFICATION';

    public function __construct()
    {
        self::$pusher = App::make('pusher');
    }

    /**
     * @param $chanel
     * @param $data
     * @return boolean $response
     */
    public static function sendNotification(String $channel, array $data)
    {
        $response = true;
        try {

            self::$pusher->trigger(
                "{$channel}",
                self::GENERAL_NOTIFICATION,
                $data
            );
            return $response;
        } catch (\Throwable $th) {
            //throw $th;
            return $response = false;
        }
    }

}
