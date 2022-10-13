<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeelingRequest;
use App\Models\Emoji;
use App\Models\Feeling;
use App\Models\User;
use App\Traits\Imageable;
use App\Traits\Responseable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    use Responseable, Imageable;

    // public function language(Request $request){
    //     $lang = $request->lang;
    //     app()->setLocale($lang);
    //     return $this->returnSuccessMessage("language set successfully", "F000");
    // }

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
        $row->token = $token;
        return $this->returnData('data', $row, 'user data');

    }

    public function login(Request $request){

        $filed = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $data = [
            $filed => $request->email,
            'password' => $request->password
        ];

        if(Auth::attempt($data)){
            $user = User::find(Auth::id());
            $token = $user->createToken('Token')->accessToken; 
            $user->token = $token;
            return $this->returnData('data', $user, 'user data');
        }else{
            return $this->returnError('F413', 'Unauthorised');
        }

    }

    // public function emojis()
    // {
    //     $emojis = Emoji::orderBy('raw_order')->get();
    //     return $this->returnData('emojis', $emojis, 'all emojis');
    // }

    public function emojis($lang)
    {
        $emojis = Emoji::select('css_class', 'color', 'type_' . $lang)->orderBy('raw_order')->get();
        return $this->returnData('emojis', $emojis, 'all emojis');
    }
    
    public function store(FeelingRequest $request)
    {
        $user_id = Auth::id();
        $emojis = explode(',', $request->feel_id);
        $image = NULL;

        if($request->image){
            $image = $this->saveImage($request->image, 'assets/images/feels');
        }

        $data = Feeling::create([
            "reason"  => $request->reason,
            "image"   => $image,
            "category" => "me",
            "user_id" => $user_id
        ]);

        $data->emojis()->attach($emojis, ['user_id' => Auth::id()]);

        switch($request->submitbutton) {
            case 'save':
                return $this->returnSuccessMessage('stored successfully', 'F000');
            break;

            case 'save and share': 
                $data->type = 1;
                $data->save();
                return $this->returnSuccessMessage('stored and shared successfully', 'F001');
            break;
        }
    }

    public function diary($lang)
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis:css_class,color,type_' . $lang, 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->orderby('created_at', 'desc')
                        ->get();
        return $this->returnData('diary', $feels, 'all feelings in descending order');
    }

    public function diaryAsc($lang)
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis:css_class,color,type_' . $lang, 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->orderby('created_at', 'asc')
                        ->get();
        return $this->returnData('diary', $feels, 'all feelings in ascending order');
    }

    public function diaryDate($date, $lang)
    {
        $date = date("Y-m-d", strtotime($date));
        $user_id = Auth::id();
        $feels = Feeling::with('emojis:css_class,color,type_' . $lang, 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->whereBetween('created_at', [$date.' 00:00:00',$date.' 23:59:59'])
                        ->orderby('created_at', 'desc')
                        ->get();
        return $this->returnData('diary', $feels, 'all feelings in particular date');
    }

    public function diaryPopular($lang)
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis:css_class,color,type_' . $lang, 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->orderby('comments_count', 'desc')
                        ->orderby('likes_count', 'desc')
                        ->get();
        return $this->returnData('diary', $feels, 'feelings order by comments count');
    }

    public function diaryShare($lang)
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis:css_class,color,type_' . $lang, 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->where('type', 1)
                        ->orderby('comments_count', 'desc')
                        ->orderby('likes_count', 'desc')
                        ->get();
        return $this->returnData('diary', $feels, 'all public feelings');
    }

    public function diaryPrivate($lang)
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis:css_class,color,type_' . $lang, 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->where('type', 0)
                        ->orderby('comments_count', 'desc')
                        ->orderby('likes_count', 'desc')
                        ->get();
        return $this->returnData('diary', $feels, 'all private feelings');
    }

    public function diaryMe($lang)
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis:css_class,color,type_' . $lang, 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->where('category', 'me')
                        ->orderby('created_at', 'desc')
                        ->get();
        return $this->returnData('diary', $feels, 'all feelings belongs to me');
    }

    public function diaryStatistics($lang)
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis:css_class,color,type_' . $lang, 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->where('category', 'statistics')
                        ->orderby('created_at', 'desc')
                        ->get();
        return $this->returnData('diary', $feels, 'all statistics feelings');
    }

    public function diaryThanks($lang)
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis:css_class,color,type_' . $lang, 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->where('category', 'thanks')
                        ->orderby('created_at', 'desc')
                        ->get();
        return $this->returnData('diary', $feels, 'all thanks feelings');
    }
    
}
