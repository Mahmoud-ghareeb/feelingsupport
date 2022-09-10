<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddEmojiRequest;
use App\Models\Emoji;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AdminController extends Controller
{
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
        $admins = User::where('is_admin', '1')->count();
        $users = User::where('is_admin', '0')->count();
        $emojis = Emoji::count();

        return view('admin.pages.dashboard', compact('admins', 'users', 'emojis'));
    }
}
