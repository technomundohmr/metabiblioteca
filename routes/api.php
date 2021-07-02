<?php

use App\Http\Controllers\OrcidApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('orcid/create',[OrcidApiController::class, 'create']);
Route::get('orcid/list',[OrcidApiController::class, 'list']);
Route::post('orcid/{orcid}',[OrcidApiController::class, 'delete']);
Route::get('orcid/{orcid}',[OrcidApiController::class, 'show']);