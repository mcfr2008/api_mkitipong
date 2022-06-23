<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PasswordResetRequestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/demo-url',  function  (Request $request)  {
//     return response()->json(['Laravel 8 CORS Demo']);
// });


Route::group([
    'middleware' => 'api',

], function ($router) {

    Route::get('/demo-url',  function  (Request $request)  {
        return response()->json(['Laravel 8 CORS Demo']);
    });
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace'  => 'App\Http\Controllers',

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);

    Route::post('reset-password-request', 'PasswordResetRequestController@sendPasswordResetEmail');
    Route::post('change-password', 'ChangePasswordController@passwordResetProcess');
});

Route::group(
    [
        'middleware' => 'api',
        'namespace'  => 'App\Http\Controllers',
    ],
    function ($router) {

        // Todo
        Route::resource('todos', 'TodoController');

        // People
        Route::resource('peoples', 'PeopleController');
        Route::get('peoples-all', 'PeopleController@get_peoples');
        Route::get('peoples-id', 'PeopleController@get_peoples_id');

        // Organization
        Route::resource('organizations', 'OrganizationController');
        Route::post('organizations/adds', 'OrganizationController@adds');
        Route::put('organizations/del/{slug}', 'OrganizationController@del');

        // Special
        Route::resource('specials', 'SpecialController');
        Route::post('specials/adds', 'SpecialController@adds');
        Route::put('specials/del/{slug}', 'SpecialController@del');

        // Email
        Route::resource('emails', 'EmailController');
        Route::post('emails/adds', 'EmailController@adds');
        Route::put('emails/del/{slug}', 'EmailController@del');

         // Eucation
        Route::resource('eucations', 'EucationController');
        Route::post('eucations/adds', 'EucationController@adds');
        Route::put('eucations/del/{slug}', 'EucationController@del');

    }
);



