<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get All User Notifications
     *
     * @pathParam id int required Users id
     *
     *
     * @param $request
     * @return $response
     *
     * @response {
     *      "message":"status",
     *      "status_code":200,
     *      "data":[]
     * }
     */
    public function getUserNotifications($id, Request $request)
    {
       
        $notifications = Notification::where('person_id', $id)->paginate(20);
        return \Response::json([
            "message" => "status",
            "status_code" => 200,
            "data" => $notifications,
        ]);
    }

    /**
     * Get Notification Details
     *
     * @pathParam id int required Users id
     *
     *
     * @param $request
     * @return $response
     *
     * @response {
     *      "message":"status",
     *      "status_code":200,
     *      "data":[]
     * }
     */
    public function getNotificationDetails($id, Request $request)
    {
        $notification = Notification::where('id', $id)->first();
        return \Response::json([
            "message" => "status",
            "status_code" => 200,
            "data" => $notification,
        ]);
    }

    /**
     * Read Notifications
     *
     * @pathParam id int required Users id
     *
     *
     * @param $request
     * @return $response
     *
     * @response {
     *      "message":"status",
     *      "status_code":200,
     *      "data":[]
     * }
     */
    public function readNotification($id, Request $request)
    {
        $notification = Notification::where('id', $id)->update([
            'status' => 'READ',
        ]);
        return \Response::json([
            "message" => "status",
            "status_code" => 200,
            "data" => $notification,
        ]);
    }
}
