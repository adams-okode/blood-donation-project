<?php

namespace App\Http\Controllers;

use App\Person;
use App\Token;
use App\User;
use Illuminate\Http\Request;

/**
 * @group User
 */
class PersonController extends Controller
{

    /**
     * Create User
     *
     * @bodyParam first_name string required
     * @bodyParam last_name string required
     * @bodyParam dob datetime required
     * @bodyParam weight integer required
     * @bodyParam ethnicity string required
     * @bodyParam gender string required
     * @bodyParam email string required
     * @bodyParam phone string required
     * @bodyParam password string required
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
    public function createUser(Request $request)
    {
        $person = Person::create($request->all());

        $user = new User();
        $user->name = "{$request->first_name}{$request->last_name}";
        $user->password = \Hash::make($request->password);
        $user->email = $request->email;
        $user->person_id = $person->id;
        $user->save();

        return \Response::json([
            "message" => "status",
            "status_code" => 200,
            "data" => $user->toArray(),
        ]);
    }

    /**
     * Authenticate User
     * Create a usable token for the logged in user
     *
     * @bodyParam email string required
     * @bodyParam password string required
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
     * @response 403 {
     *      "message":"Unauthorized Access",
     *      "status_code": 403,
     *      "data":[]
     * }
     *
     */
    public function authenticateUser(Request $request)
    {
        $auth = User::where('email', $request->email)->first();

        if (\Hash::check($request->password, $auth->password)) {

            $token = new Token();
            $token->user_id = $auth->id;
            $token->token = \Hash::make(date('YmdHis'));
            $token->save();

            return \Response::json([
                "message" => "status",
                "status_code" => 200,
                "data" => [
                    'user' => $auth,
                    'token' => $token->toArray(),
                ],
            ]);
        }

        return \Response::json([
            "message" => "status",
            "status_code" => 200,
            "data" => [],
        ]);

    }

    /**
     * Update User
     *
     * @pathParam id int required Users id
     *
     * @bodyParam first_name string required
     * @bodyParam last_name string required
     * @bodyParam dob datetime required
     * @bodyParam weight integer required
     * @bodyParam ethnicity string required
     * @bodyParam gender string required
     * @bodyParam phone string required
     * @bodyParam password string required
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
    public function updateUser($id, Request $request)
    {
        $user = User::where('id', $id)->first();
        $user->person->update($request->all());
        $user->person->save();

        return \Response::json([
            "message" => "status",
            "status_code" => 200,
            "data" => $user->toArray(),
        ]);
    }

    /**
     * Set Blood Group
     *
     * @bodyParam email string required
     * @bodyParam password string required
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
     * @response 403 {
     *      "message":"Unauthorized Access",
     *      "status_code": 403,
     *      "data":[]
     * }
     *
     */
    public function setBloodGroup($id, Request $request)
    {

    }

}
