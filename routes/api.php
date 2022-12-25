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

Route::post('facebook/login', [ApiController::class, 'facebookCallback']);
Route::post('google/login', [ApiController::class, 'googleCallback']);


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
        Route::post('private/{id}', [ApiController::class, 'makePrivate']);
        Route::post('public/{id}', [ApiController::class, 'makePublic']);
    });
    Route::post('delete/{id}', [ApiController::class, 'delete']);
    Route::post('like/{id}', [ApiController::class, 'like']);
    Route::post('all-private', [ApiController::class, 'makeAllPrivate']);
    Route::post('all-public', [ApiController::class, 'makeAllPublic']);
        
    Route::get('notification', [ApiController::class, 'getNotifications']);
    Route::post('read-all', [ApiController::class, 'reaAllNotification']);
    Route::post('read-notification/{noti_id}', [ApiController::class, 'readSingleNotification']);

    Route::post('clear-all', [ApiController::class, 'clearAllNotification']);
    Route::get('notification/count', [ApiController::class, 'getNotificationsCount']);

    Route::get('/profile', [ApiController::class, 'profile']);
    Route::group(['prefix' => 'update',], function(){
        Route::post('email', [ApiController::class, 'updateEmail']);
        Route::post('info', [ApiController::class, 'updateInfo']);
        Route::post('password', [ApiController::class, 'updatePassword']);
        Route::post('picture', [ApiController::class, 'updatePicture']);
    });

    Route::group(["prefix" => '{feel_id}/comments'], function($feel_id){ 
        Route::get('/', [ApiController::class, 'showComments']);
        Route::get('/asc', [ApiController::class, 'showCommentsAsc']);
        Route::post('store-comment', [ApiController::class, 'storeComment']);
        Route::post('{comment_id}/reply', [ApiController::class, 'replay']);
        Route::post('delete/{comment_id}', [ApiController::class, 'deleteComment']);
        Route::post('public/{comment_id}', [ApiController::class, 'makeCommentPublic']);
        Route::post('private/{comment_id}', [ApiController::class, 'makeCommentPrivate']);
        Route::post('all/public', [ApiController::class, 'makeAllCommentsPublic']);
        Route::post('all/private', [ApiController::class, 'makeAllCommentsPrivate']);
    });

    Route::post('share/comment-image', [ApiController::class, 'uploadBaseImage']);
    Route::post('share/chart-image', [ApiController::class, 'uploadChartImage']);

});

