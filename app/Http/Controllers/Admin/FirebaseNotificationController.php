<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendNotificationRequest;
use App\Models\Notification;
use App\Models\User;
use App\Traits\Notifiable;
use Illuminate\Support\Facades\Auth;

class FirebaseNotificationController extends Controller
{
    use Notifiable;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.pages.notification');
    }

    public function sendNotification(SendNotificationRequest $request)
    {
        $registatoin_ids = User::whereRaw('fcm_token IS NOT NULL')->pluck('fcm_token');
        $data = [
            'title' => $request->title,
            'body' => $request->message,
            'type' => 'system',
        ];
        Notification::create([
            'user_id' => 0,
            "owner_id" => 0,
            'type_id' => Auth::id(),
            'type' => 'general',
            'message' => $request->message
        ]);
        //$this->sendMessageThroughFCM($registatoin_ids, $data);
        return redirect()->back()->with('info_message', 'Notification sent successfully');
    }
}
