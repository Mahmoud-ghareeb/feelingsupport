<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Emoji;
use App\Services\WebNotificationService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $notification;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WebNotificationService $notification)
    {
        $this->middleware('auth')->except('privacy', 'terms', 'aboutUs');
        $this->notification = $notification;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $emojis = Emoji::orderBy('raw_order')->get();
        return view('front.home', compact('emojis'));
    }

    public function storeToken(Request $request)
    {
        $this->notification->storeToken($request->token);
    }

    public function terms()
    {
        return view('front.terms');
    }

    public function privacy()
    {
        return view('front.privacy');
    }
    
    public function aboutUs()
    {
        return view('front.about_us');
    }
}
