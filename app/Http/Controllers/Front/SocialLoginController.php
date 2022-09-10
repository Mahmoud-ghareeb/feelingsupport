<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialLoginController extends Controller
{
    public function facebookLogin()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback(Request $request)
    {
        try {
            $user = Socialite::driver('facebook')->stateless()->user();
            $finduser = User::where('name', $user->id)->first();;
            $first_name = explode(' ', $user->name)[0];
            $last_name  = explode(' ', $user->name)[1];
            
            if($finduser)
            {
                Auth::login($finduser);
                return redirect()->to('home');
            }else{
                $user_email = $user->email;
                if(empty($user->email)){
                    $user_email = $user->id . '@fakefeelingsupport.com';
                }
                $newUser = User::create([
                                'name' => $user->id,
                                'first_name' => $first_name,
                                'last_name' => $last_name,
                                'email' => $user_email,
                                'picture' => $user->avatar,
                                'password' => Hash::make($user->id . $user->email),
                            ]);
                
                Auth::login($newUser);
                return redirect()->to('home');
            }
        } catch (Exception $exception) {
            return redirect()->to('login')->with('success', __('messages.The email has already been taken'));
        }
    }

    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $finduser = User::where('name', $user->id)->first();;
            $first_name = explode(' ', $user->name)[0];
            $last_name  = explode(' ', $user->name)[1];
            if($finduser)
            {
                Auth::login($finduser);
                return redirect()->to('home');
            }else{
    
                
                $newUser = User::create([
                                'name' => $user->id,
                                'first_name' => $first_name,
                                'last_name' => $last_name,
                                'email' => $user->email,
                                'picture' => $user->avatar,
                                'password' => Hash::make($user->id . $user->email),
                            ]);
                
                Auth::login($newUser);
                return redirect()->to('home');
            }
        } catch (Exception $exception) {
            return redirect()->to('login')->with('success', __('messages.The email has already been taken'));
        }
    }
}
