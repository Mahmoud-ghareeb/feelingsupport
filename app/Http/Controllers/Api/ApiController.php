<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Emoji;
use App\Models\User;
use App\Traits\Responseable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    use Responseable;

    public function registration(Request $request){

        $this->validate($request,[
           'name'=>'required',
           'first_name'=>'required',
           'last_name'=>'required',
           'email'=>'required|unique:users,email',
           'password'=>'required',
           'confirm_password'=>'required|same:password'
        ]);
        $row = User::create([
           'name'=>$request->name,
           'first_name' => $request->first_name,
           'last_name' => $request->last_name,
           'email'=>$request->email,
           'password'=>bcrypt($request->password)
        ]);
        $token = $row->createToken('Token')-> accessToken;
        return $this->returnData('token', $token, 'user token');

    }

    public function login(Request $request){

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($data)){
            $user = User::find(Auth::id());
            $token = $user->createToken('Token')->accessToken; 
            return $this->returnData('token', $token, 'user token');
        }else{
            return $this->returnError('F413', 'Unauthorised');
        }

    }

    public function emojis()
    {
        $emojis = Emoji::orderBy('raw_order')->get();
        return $this->returnData('emojis', $emojis, 'all emojis');
    }
    
    // public function logoutApi()
    // {
    //     if (Auth::check()) {
    //         Auth::user()->AauthAcessToken()->delete();
    //     }
    // }
}
