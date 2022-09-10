<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\Imageable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use Imageable;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        return view('front.profile', compact('user'));
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ],[
            'email.unique' => __('messages.The email has already been taken')    
        ]);
        $id = Auth::id();
        $user = User::findOrFail($id);
        $user->email = $request->email;
        $user->save();
        return redirect()->back()->with('success', __("messages.Email Updated Successfully"));
    }
    
    public function updateInfo(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50']
        ]);
        $id = Auth::id();
        $user = User::findOrFail($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->save();
        return redirect()->back()->with('success', __("messages.Info Updated Successfully"));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'max:255']
        ],[
            'password.required' => __("messages.you must type a password"),    
        ]);
        $id = Auth::id();
        $user = User::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->back()->with('success', __("messages.Password Updated Successfully"));
    }

    public function updatePicture(Request $request)
    {
        $request->validate([
            'picture' => ['required', 'image']
        ],[
            'picture.required' => __("messages.you must choose an image"),
            'picture.image' => __("messages.this file must be an image"),
        ]);
        $id = Auth::id();
        $user = User::findOrFail($id);

        $image = $this->saveImage($request->picture, 'assets/images/profiles');

        $user->picture = $image;
        $user->save();
        return redirect()->back()->with('success', __('messages.Profile Picture Updated Successfully'));
    }
}
