<?php

use App\Http\Controllers\Api\ApiController;
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

Route::post('register', [ApiController::class, 'registration']);
Route::post('login', [ApiController::class, 'login']);


Route::group(['middleware' => 'auth:api'], function(){
    
    Route::get('language', [ApiController::class, 'language']);
    Route::get('emojis/{lang}', [ApiController::class, 'emojis']);
    Route::post('store', [ApiController::class, 'store']);
    Route::get('diary/{lang}', [ApiController::class, 'diary']);
    Route::get('diaryAsc', [ApiController::class, 'diaryAsc']);
    Route::get('diaryDate/{date}', [ApiController::class, 'diaryDate']);
    Route::get('diaryPopular', [ApiController::class, 'diaryPopular']);
    Route::get('diaryShare', [ApiController::class, 'diaryShare']);
    Route::get('diaryPrivate', [ApiController::class, 'diaryPrivate']);
    Route::get('diaryMe', [ApiController::class, 'diaryMe']);
    Route::get('diaryStatistics', [ApiController::class, 'diaryStatistics']);
    Route::get('diaryThanks', [ApiController::class, 'diaryThanks']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
