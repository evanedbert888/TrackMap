<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/GeoSearch', function (Request $request) {
    $url = "https://www.arcgis.com/sharing/oauth2/token?client_id=FAvQ2yQYsmb4D8Rk&grant_type=client_credentials&client_secret=05e56276f99f46fda1b066b8b7e4eb4a&f=pjson";
    $responseToken = Http::get($url);
    $token = $responseToken["access_token"];

    $address = $request->get("address");
    $url = "https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/findAddressCandidates?singleLine=" . $address . "&forStorage=true
   &token=" . $token . "&f=pjson";

    $response = Http::get($url);
    $candidates = $response["candidates"];
    $array = $candidates[0];
    $location = $array["location"];
    $x = strval($location["x"]);
    $y = strval($location["y"]);
    return [
        "x"=>$x,
        "y"=>$y
    ];
});
