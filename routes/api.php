<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


$api = app("Dingo\Api\Routing\Router");
$api->version('v1', function ($api) {
    $api->group([
        "namespace" => "App\Http\Controllers\Api\V1",
        "prefix" => "v1",
    ], function ($api) {
        $api->group([
        ], function ($api) {
            //之后在这里写api
            $api->get('/get/sign', 'TestController@getSign');

        });
        $api->group([
            "middleware" => [
                'signature',
            ],
        ], function ($api) {
            //之后在这里写api
            $api->post('/verify/sign', 'TestController@verifySign');

        });

        $api->group([
            'middleware' => [
                'signature',
            ],
        ], function ($api) {
            //之后在这里写api
            $api->get('/upgrade', 'UpgradesController@upgrade');
            $api->get('/send/client/info', 'ClientsController@store');
            $api->post('/user/login', 'AuthController@login');
            $api->post('/user/register', 'AuthController@register');
        });

        $api->group([
            'middleware' => [
                'auth:api',
                'signature',
            ],
        ], function ($api) {
            $api->get('/user/me', 'AuthController@me');
            $api->get('/user/refresh', 'AuthController@refresh');
            $api->post('/user/logout', 'AuthController@logout');
            $api->post('/user/feedback', 'FeedbackController@feedback');
        });
    });
});
