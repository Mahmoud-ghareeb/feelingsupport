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
    Route::get('diaryAsc/{lang}', [ApiController::class, 'diaryAsc']);
    Route::get('diaryDate/{date}/{lang}', [ApiController::class, 'diaryDate']);
    Route::get('diaryPopular/{lang}', [ApiController::class, 'diaryPopular']);
    Route::get('diaryShare/{lang}', [ApiController::class, 'diaryShare']);
    Route::get('diaryPrivate/{lang}', [ApiController::class, 'diaryPrivate']);
    Route::get('diaryMe/{lang}', [ApiController::class, 'diaryMe']);
    Route::get('diaryStatistics/{lang}', [ApiController::class, 'diaryStatistics']);
    Route::get('diaryThanks/{lang}', [ApiController::class, 'diaryThanks']);
    Route::group(["prefix" => 'make'], function(){
        Route::get('private/{id}', [ApiController::class, 'makePrivate']);
        Route::get('public/{id}', [ApiController::class, 'makePublic']);
    });
    Route::get('delete/{id}', [ApiController::class, 'delete']);
    Route::get('like/{id}', [ApiController::class, 'like']);
    Route::get('all-private', [ApiController::class, 'makeAllPrivate']);
    Route::get('all-public', [ApiController::class, 'makeAllPublic']);
        
    Route::get('notification', [ApiController::class, 'getNotifications']);
    Route::get('read-all', [ApiController::class, 'reaAllNotification']);
    Route::get('clear-all', [ApiController::class, 'clearAllNotification']);
    Route::get('notification/count', [ApiController::class, 'getNotificationsCount']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
