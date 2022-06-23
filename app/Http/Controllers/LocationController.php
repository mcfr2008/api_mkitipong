<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class LocationController extends Controller
{

    /**
        * @OA\Get(
        * path="/show-user-location-data",
        * summary="user location",
        * description="",
        * tags={"location"},
        *  @OA\Response(
        *    response=200,
        *    description="OK",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="OK")
        *        )
        *     )
        * )
    */
    public function index(Request $request)
    {
            // $userIp = $request->ip();
            // $locationData = Location::get($userIp);

            if ($userIp = Location::get()) {
                // Successfully retrieved position.
                // echo ;
                dd($userIp);
            } else {
                // Failed retrieving position.
            }

            // dd($locationData);
    }
}
