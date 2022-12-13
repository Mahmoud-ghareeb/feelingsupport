<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Front\ChartController;
use App\Http\Controllers\Front\CommentController;
use App\Http\Controllers\Front\FeelingController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProfileController;
use App\Http\Controllers\Front\SocialLoginController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });



Route::group(
    [
        'prefix' => 'social',
        'middleware' => 'prevent-back-history'
    ], function(){

            Route::group(['prefix' => 'facebook', 'as' => 'facebook.'], function(){
                Route::get('/login', [SocialLoginController::class, 'facebookLogin'])->name('login');
                Route::get('/callback', [SocialLoginController::class, 'facebookCallback'])->name('callback');
            });
        
            Route::group(['prefix' => 'google', 'as' => 'google.'], function(){
                Route::get('/login', [SocialLoginController::class, 'googleLogin'])->name('login');
                Route::get('/callback', [SocialLoginController::class, 'googleCallback'])->name('callback');
            });

});

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

        Auth::routes();

        Route::get('/', [HomeController::class, 'index'])->name('main');
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

        Route::get('/search-emojis', [FeelingController::class, 'searchEmojis'])->name('search.emojis');

        Route::group(['prefix' => 'update', 'as' => 'update.'], function(){

            Route::post('email', [ProfileController::class, 'updateEmail'])->name('email');
            Route::post('info', [ProfileController::class, 'updateInfo'])->name('info');
            Route::post('password', [ProfileController::class, 'updatePassword'])->name('password');
            Route::post('picture', [ProfileController::class, 'updatePicture'])->name('picture');

        });

        Route::group(['prefix' => 'feelings', 'as' => 'feeling.'], function(){

            Route::get('/', [FeelingController::class, 'index'])->name('feels');
            Route::get('/asc', [FeelingController::class, 'indexAsc'])->name('feels.asc');
            Route::get('/popular', [FeelingController::class, 'indexPopular'])->name('feels.popular');
            Route::get('/share', [FeelingController::class, 'indexShare'])->name('feels.share');
            Route::get('/private', [FeelingController::class, 'indexPrivate'])->name('feels.private');
            Route::get('/me', [FeelingController::class, 'indexMe'])->name('feels.me');
            Route::get('/statistics', [FeelingController::class, 'indexStatistics'])->name('feels.statistics');
            Route::get('/thanks', [FeelingController::class, 'indexThanks'])->name('feels.thanks');
            Route::get('/date/{date}', [FeelingController::class, 'indexDate'])->name('feels.date');
            
            Route::get('test', [ChartController::class, 'test'])->name('test');
            Route::get('{username}', [FeelingController::class, 'showUserNotes'])->name('user');
            
            Route::post('store', [FeelingController::class, 'store'])->name('store');
            Route::post('share/{id}', [FeelingController::class, 'share'])->name('share');
            Route::get('share-diary/{username}/{id}', [FeelingController::class, 'shareDiary'])->name('share.diary');
            Route::get('feel/{username}/{id}', [FeelingController::class, 'show'])->name('show');
            Route::get('feel/view/{username}/{id}/{noti_id}', [FeelingController::class, 'viewThenShow'])->name('view.show');
            Route::get('feel/{username}/{id}/asc', [FeelingController::class, 'showAsc'])->name('show.asc');
            Route::get('delete/{id}', [FeelingController::class, 'delete'])->name('delete');
            Route::post('like/{id}', [FeelingController::class, 'like'])->name('like');

            Route::group(["prefix" => 'make', 'as' => 'make.'], function(){
                Route::get('private/{id}', [FeelingController::class, 'makePrivate'])->name('private');
                Route::get('public/{id}', [FeelingController::class, 'makePublic'])->name('public');
            });

            Route::group(["prefix" => '{feel_id}/comments', 'as' => 'comments.'], function($feel_id){
                Route::post('store', [CommentController::class, 'store'])->name('store');
                Route::post('{comment_id}/store', [CommentController::class, 'replay'])->name('replay');
                Route::get('delete/{comment_id}', [CommentController::class, 'delete'])->name('delete');
                Route::get('public/{comment_id}', [CommentController::class, 'makePublic'])->name('make.public');
                Route::get('private/{comment_id}', [CommentController::class, 'makePrivate'])->name('make.private');
                Route::get('all/puplic', [CommentController::class, 'makeAllPublic'])->name('make.all.public');
                Route::get('all/private', [CommentController::class, 'makeAllPrivate'])->name('make.all.private');
            });

            Route::group(['prefix' => 'charts', 'as' => 'charts.'], function(){
                Route::get('daily', [ChartController::class, 'index'])->name('daily');
                Route::get('compare', [ChartController::class, 'compare'])->name('compare');
                Route::get('emoji', [ChartController::class, 'emoji'])->name('emoji');
                Route::get('egabi', [ChartController::class, 'egabi'])->name('egabi');
            });
            
            

        });
        Route::get('all-private', [FeelingController::class, 'makeAllPrivate'])->name('all.private');
        Route::get('all-public', [FeelingController::class, 'makeAllPublic'])->name('all.public');
            
        Route::get('notification', [FeelingController::class, 'getNotifications'])->name('notification');
        Route::get('read-all', [FeelingController::class, 'reaAllNotification'])->name('read.all.notis');
        Route::get('clear-all', [FeelingController::class, 'clearAllNotification'])->name('clear.all.notis');
        Route::get('notification/count', [FeelingController::class, 'getNotificationsCount'])->name('notification.count');

        Route::get('terms-and-condition', [HomeController::class, 'terms'])->name('terms');
        Route::get('privacy-policy', [HomeController::class, 'privacy'])->name('privacy');
        Route::get('about-us', [HomeController::class, 'aboutUs'])->name('about.us');
        
    });

Route::group(['middleware' => 'prevent-back-history' ], function(){

    Route::post('/store-token', [HomeController::class, 'storeToken'])->name('store.token');
    Route::post('/base-image', [FeelingController::class, 'uploadBaseImage'])->name('upload.image');
    Route::post('/chart-image', [FeelingController::class, 'uploadChartImage'])->name('chart.image');
    Route::get('/return-to-admin', [FeelingController::class, 'returnToAdmin'])->name('return.to.admin');
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

});


