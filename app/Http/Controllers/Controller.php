<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * @OA\Info(
     *    title="API-MKITIPONG",
     *    version="1.0.0",
     * )
    */

    /**
     * @OA\SecurityScheme(
     *     type="http",
     *     description="Login with email and password to get the authentication token",
     *     name="Token based Based",
     *     in="header",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     securityScheme="apiAuth",
     * )
     */

    /**
        * @OA\Get(
        * path="/clear-route-cache",
        * summary="clear-route-cache",
        * description="",
        * tags={"clear-cache"},
        *  @OA\Response(
        *    response=200,
        *    description="OK",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="All routes cache has just been removed")
        *        )
        *     )
        * )
    */

     /**
        * @OA\Get(
        * path="/clear-config-cache",
        * summary="clear-config-cache",
        * description="",
        * tags={"clear-cache"},
        *  @OA\Response(
        *    response=200,
        *    description="OK",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Config cache has just been removed")
        *        )
        *     )
        * )
    */

     /**
        * @OA\Get(
        * path="/clear-app-cache",
        * summary="clear-app-cache",
        * description="",
        * tags={"clear-cache"},
        *  @OA\Response(
        *    response=200,
        *    description="OK",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="Application cache has just been removed")
        *        )
        *     )
        * )
    */

     /**
        * @OA\Get(
        * path="/clear-view-cache",
        * summary="clear-view-cache",
        * description="",
        * tags={"clear-cache"},
        *  @OA\Response(
        *    response=200,
        *    description="OK",
        *    @OA\JsonContent(
        *       @OA\Property(property="message", type="string", example="View cache has jut been removed")
        *        )
        *     )
        * )
    */

}
