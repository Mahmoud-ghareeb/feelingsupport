<?php

/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------|
*/

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\EmojiController;
use App\Http\Controllers\Admin\FirebaseNotificationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'admin.', ['admin', 'prevent-back-history'] ], function(){

    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // admins
    Route::get('/manage-admins', [UsersController::class, 'manageAdmins'])->name('manage.admins');
    Route::get('/add-admin', [UsersController::class, 'addAdmin'])->name('add.admins');
    Route::post('/create-admin', [UsersController::class, 'createAdmin'])->name('create.admins');
    Route::get('/edit-admin/{admin_id}', [UsersController::class, 'editAdmin'])->name('edit.admins');
    Route::post('/modify-admin', [UsersController::class, 'modifyAdmin'])->name('modify.admins');
    Route::get('/delete-admin/{admin_id}', [UsersController::class, 'deleteAdmin'])->name('delete.admins');

    // users
    Route::get('/manage-users', [UsersController::class, 'manageUsers'])->name('manage.users');
    Route::get('/add-user', [UsersController::class, 'addUser'])->name('add.users');
    Route::post('/create-user', [UsersController::class, 'createUser'])->name('create.users');
    Route::get('/edit-user/{user_id}', [UsersController::class, 'editUser'])->name('edit.users');
    Route::post('/modify-user', [UsersController::class, 'modifyUser'])->name('modify.users');
    Route::get('/delete-user/{user_id}', [UsersController::class, 'deleteUser'])->name('delete.users');
    Route::get('/view-user/{user_id}', [UsersController::class, 'viewUser'])->name('view.users');

    // emojis
    Route::get('/manage-emojis', [EmojiController::class, 'manageEmojis'])->name('manage.emojis');
    Route::get('/add-emoji', [EmojiController::class, 'addEmoji'])->name('add.emojis');
    Route::post('/create-emoji', [EmojiController::class, 'createEmoji'])->name('create.emojis');
    Route::get('/edit-emoji/{emoji_id}', [EmojiController::class, 'editEmoji'])->name('edit.emojis');
    Route::post('/modify-emoji', [EmojiController::class, 'modifyEmoji'])->name('modify.emojis');
    Route::get('/delete-emoji/{emoji_id}', [EmojiController::class, 'deleteEmoji'])->name('delete.emojis');
    Route::get('/change-emojis-order', [EmojiController::class, 'changeEmojisOrder'])->name('change.emojis.order');
    Route::get('/update-emojis-order', [EmojiController::class, 'updateEmojisOrder'])->name('update.emojis.order');

    // firebase notification
    Route::get('/notification', [FirebaseNotificationController::class, 'index'])->name('notification');
    Route::post('/send-notification', [FirebaseNotificationController::class, 'sendNotification'])->name('send.notification'); 
    
    // settings
    Route::get('/language-settings', [SettingController::class, 'language'])->name('settings.language');
});
