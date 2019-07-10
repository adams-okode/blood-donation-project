<?php

namespace App\Http\Controllers;

use App\BloodGroup;
use App\BloodRequest;
use App\Helpers\Donation;
use App\Helpers\RealTime;
use App\Notification;
use App\Person;
use Illuminate\Http\Request;

/**
 * @group Donation
 */
class DonationController extends Controller
{

    /**
     * Send Donation Request
     *
     * @bodyParam recepient_id int required
     * @bodyParam max_acceptance_no int required
     * @bodyParam metadata json required
     *
     * @param $request
     * @return $response
     *
     * @response {
     *      "message":"status",
     *      "status_code":200,
     *      "data":[]
     * }
     *
     */
    public function sendBloodDonorRequest(Request $request)
    {
        $bloodRequest = new BloodRequest();
        $bloodRequest->recepient_id = $request->recepient_id;
        $bloodRequest->max_acceptance_no = $request->max_acceptance_no;
        $bloodRequest->data = json_encode($request->metadata);
        $bloodRequest->save();
        # code...

        $compatibleGroups = Donation::findAllOneCanReceiveFrom($bloodRequest->person->bloodgroup->group);

        for ($i = 0; $i < count($compatibleGroups); $i++) {
            $personGroup = BloodGroup::where('group', $compatibleGroups[$i])->get();
            $this->sendMultipleNotifications($personGroup, $bloodRequest);

        }

        return \Response::json([
            "message" => "status",
            "status_code" => 200,
            "data" => [],
        ]);

    }

    /**
     * Accept Donation Request
     *
     * @bodyParam recepient_id int required
     * @bodyParam request_id int required
     * @bodyParam acceptor_id int required
     *
     * @param $request
     * @return $response
     *
     * @response {
     *      "message":"status",
     *      "status_code":200,
     *      "data":[]
     * }
     *
     */
    public function acceptBloodDonorRequest(Request $request)
    {
        $bloodRequest = BloodRequest::where('id', $request->request_id)->first();

        $metadata = json_decode($bloodRequest->data, true);

        $person = Person::where('id', $request->acceptor_id)->first();
        $recepient = Person::where('id', $request->recepient_id)->first();

        if (isset($metadata['acceptors'])) {
            if (count($metadata['acceptors']) == $bloodRequest->max_acceptance_no) {
                # code...
                return \Response::json([
                    "message" => "Max No Of People Achieved",
                    "status_code" => 2001,
                    "data" => [],
                ]);

            }

            $key = array_search($request->acceptor_id, array_column($metadata['acceptors'], 'id'));

            if ($key == 0 || !empty($key) || $key != false) {
                return \Response::json([
                    "message" => "You have Already Accepted ",
                    "status_code" => 2002,
                    "data" => [],
                ]);
            }
        }

        $metadata['acceptors'][] = [
            "id" => $person->id,
            "email" => $person->email,
        ];

        $bloodRequest->update([
            'data' => json_encode($metadata),
        ]);

        $notification = new Notification();
        $notification->person_id = $person->person->id;
        $notification->save();

        $real = new Realtime();
        $real->sendAcceptanceNotification($recepient->email, [
            "data" => $metadata,
            "recepient" => $bloodRequest->recepient_id,
            "id" => $bloodRequest->id,
            "notification_id" => $notification->id,
        ]);

        return \Response::json([
            "message" => "status",
            "status_code" => 200,
            "data" => [],
        ]);

    }



    /**
     * @param $personGroup
     * @param $bloodRequest
     */
    public function sendMultipleNotifications($personGroup, $bloodRequest)
    {
        

        foreach ($personGroup as $key => $person) {

            // if ($person->person->id == $bloodRequest->recepient_id) {
            //     # code...
            //     continue;
            // }

            $notification = new Notification();
            $notification->person_id = $person->person->id;
            $notification->save();
            $real = new Realtime();
            $real->sendNotification($person->person->email, [
                "data" => json_decode($bloodRequest->data),
                "recepient" => $bloodRequest->recepient_id,
                "id" => $bloodRequest->id,
                "notification_id" => $notification->id,
            ]);
        }
    }

}
