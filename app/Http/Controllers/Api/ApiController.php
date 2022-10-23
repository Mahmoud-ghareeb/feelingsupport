<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeelingRequest;
use App\Models\Comment;
use App\Models\Emoji;
use App\Models\Feeling;
use App\Models\Like;
use App\Models\Notification;
use App\Models\User;
use App\Traits\Imageable;
use App\Traits\Responseable;
use Chartisan\PHP\Chartisan;
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
        $emojis = Emoji::select('id', 'css_class', 'color', 'type_' . $lang)->orderBy('raw_order')->get();
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
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang, 'user')
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
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang, 'user')
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
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang, 'user')
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
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang, 'user')
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
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang, 'user')
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
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang, 'user')
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
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang, 'user')
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
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang, 'user')
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
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang, 'user')
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

    public function makePrivate($id)
    {
        $feel = Feeling::findOrFail($id);
        $this->authorize('makePrivate', $feel);
        $feel->type = 0;
        $feel->save();
        return $this->returnSuccessMessage('Your Note Has Been Made Private', 'F000');
    }

    public function makePublic($id)
    {
        $feel = Feeling::findOrFail($id);
        $this->authorize('makePublic', $feel);
        $feel->type = 1;
        $feel->save();
        return $this->returnSuccessMessage('Your Note Has Been Made Public', 'F000');   
    }

    public function delete($id)
    {
        $feel = Feeling::findOrFail($id);
        $this->authorize('delete', $feel);
        $feel->delete();
        return $this->returnSuccessMessage('Your Note Has Been Deleted Successfully', 'F000');
    }   
    
    public function like($id)
    {
        $feel = Feeling::findOrFail($id);
        $registatoin_ids = User::where('id', $feel->user_id)->pluck('fcm_token');
        if(Auth::check()){
            $likedata = Like::where(["user_id" => Auth::id(), "feeling_id" => $id])->get();
            if(empty($likedata[0]))
            {
                $user_id = Auth::id();
                like::create([
                    "feeling_id" => $id,
                    "user_id" => $user_id,
                    "owner_id" => $feel->user_id
                ]);
                Notification::create([
                    'user_id' => $user_id,
                    "owner_id" => $feel->user_id,
                    'type_id' => $id,
                    'type' => 'like'
                ]);
                
                $data = [
                    'title' => 'FeelingSupport',
                    'body' => Auth::user()->name . ' liked your Note',
                    'type' => 'like',
                ];
                
                //$this->sendMessageThroughFCM($registatoin_ids, $data);
            }else {
                $notification = Notification::where(["user_id" => Auth::id(), "owner_id" => $feel->user_id, "type_id" => $feel->id, 'type' => 'like'])->get();
                $notification[0]->delete();
                $likedata[0]->delete();
            }
        }else
        {
            like::create([
                "feeling_id" => $id,
                "user_id" => NULL,
                "owner_id" => $feel->user_id
            ]);
            Notification::create([
                'user_id' => 0,
                "owner_id" => $feel->user_id,
                'type_id' => $id,
                'type' => 'like'
            ]);
            
            $data = [
                'title' => 'FeelingSupport',
                'body' => 'Anonymous liked your Note',
                'type' => 'like',
            ];
            
            //$this->sendMessageThroughFCM($registatoin_ids, $data);
        }
        
        return $this->returnSuccessMessage('success', 'F000');
    }

    public function makeAllPrivate()
    {
        $user_id = Auth::id();
        $feels   = Feeling::where('user_id', $user_id)
                           ->get();

        $feels->each(function($feel){
            $this->authorize('makePrivate', $feel);
            $feel->type = 0;
            $feel->save();
        });
        return $this->returnSuccessMessage('all feels Has Been Made Private', 'F000');
    }

    public function makeAllPublic()
    {
        $user_id = Auth::id();
        $feels   = Feeling::where('user_id', $user_id)
                           ->get();

        $feels->each(function($feel){
            $this->authorize('makePublic', $feel);
            $feel->type = 1;
            $feel->save();
        });
        return $this->returnSuccessMessage('all feels Has Been Made Public', 'F000');
    }

    public function getNotifications()
    {
        $data = Notification::where(function($q){
                                return $q->whereRaw('IF (`type` = "replay", `user_id` !=' . Auth::id() . ', user_id != ' . Auth::id() . ' and owner_id = '. Auth::id() . ')');
                            })
                            ->orWhereIn('replay_id', (array)'replayed_on')
                            ->orWhere('owner_id', 0)
                            ->with('owner', 'feeling', 'user')
                            ->orderBy('created_at', 'DESC')
                            ->get();
                    //->whereRaw('IF (`type` = "replay", 1,`user_id` !=' . Auth::id() . ')')
        
        $data = $data->filter(function($raw){
            
            if($raw->user_id == 0 and $raw->owner_id == 0)
            {
                $raw->message = __('messages.' . $raw->message);
            }
            
            if($raw->type == 'replay')
            {
                $raw->message = __('messages.replayed on comment you participate in');
                
                $comment = Comment::find($raw->comment_id);
                $feel    = Feeling::find($raw->type_id);
                
                $feel_user_iddd = $feel->user_id ?? 'nooo';
                if(auth()->id() == $feel_user_iddd)
                {
                    return $raw;
                }
                
                $user_iddd = $comment->user_id ?? 'nooo';
                if(auth()->id() == $user_iddd)
                {
                    $raw->message = __('messages.replayed on your comment');
                    return $raw;
                }
                
                $comment_typpe = $comment->type ?? 0;
                $ccidd = $comment->id ?? 'noo';
                // $repids = Comment::select('users.id')->join('users', 'users.id','=','comments.user_id')->where('parent_id', $ccidd)->distinct()->pluck('users.id')->toarray();
                $repids = explode(',', $raw->replayed_on_ids);
                
                if($comment_typpe)
                {
                    if(in_array(auth()->id(), $repids))
                    {
                        return $raw;
                    }
                    
                }
                
                //return $raw;
                
            }else
            {
                return $raw;
            }
        })->values();
        
        return $this->returnData('notifications', $data, 'notification retrived successfully');
    }

    public function reaAllNotification()
    {
        $notis   = Notification::where(function($q){
                                return $q->whereRaw('IF (`type` = "replay", `user_id` !=' . Auth::id() . ',user_id != ' . Auth::id() . ' and owner_id = '. Auth::id() . ')');
                            })
                            ->orWhereIn('replay_id', (array)'replayed_on')
                            ->orWhere('owner_id', 0)
                            ->get();

        $notis->each(function($noti){
            $noti->is_viewed = 1;
            $noti->save();
        });

        return $this->returnSuccessMessage('notification read successfully', 'F000');
    }

    public function getNotificationsCount()
    {
        $data = Notification::where(function($q){
                                return $q->where(function($q){
                                    return $q->whereRaw('IF (`type` = "replay", `user_id` !=' . Auth::id() . ', user_id != ' . Auth::id() . ' and owner_id = '. Auth::id() . ')');
                                    })
                                ->orWhereIn('replay_id', (array)'replayed_on')
                                ->orWhere('owner_id', 0);
                            })
                            ->where('is_viewed', 0)
                            ->get();
                            
        $data = $data->filter(function($raw){
            if($raw->type == 'replay')
            {
                $comment = Comment::find($raw->comment_id);
                $feel    = Feeling::find($raw->type_id);
                
                $feel_user_iddd = $feel->user_id ?? 'nooo';
                if(auth()->id() == $feel_user_iddd)
                {
                    return $raw;
                }
                
                $user_iddd = $comment->user_id ?? 'nooo';
                if(auth()->id() == $user_iddd)
                {
                    return $raw;
                }
                
                $comment_typpe = $comment->type ?? 0;
                $ccidd = $comment->id ?? 'noo';
                // $repids = Comment::select('users.id')->join('users', 'users.id','=','comments.user_id')->where('parent_id', $ccidd)->distinct()->pluck('users.id')->toarray();
                
                $repids = explode(',', $raw->replayed_on_ids);
                
                if($comment_typpe)
                {
                    if(in_array(auth()->id(), $repids))
                    {
                        return $raw;
                    }
                    
                }
                
                //return $raw;
                
            }else
            {
                return $raw;
            }
        });

        return $this->returnData('notification_count', $data->count(), 'count of notification');
    }
    
    public function clearAllNotification()
    {
        $notis   = Notification::where(function($q){
                                return $q->where('owner_id', Auth::id());
                            })
                            ->where('user_id', '!=', Auth::id())
                            ->get();
        $notis->each(function($noti){
            $noti->delete();
        });
        
        return $this->returnSuccessMessage('notifications cleard successfully', 'F000');
    }



}
