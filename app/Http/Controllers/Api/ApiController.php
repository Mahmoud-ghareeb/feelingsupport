<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\FeelingRequest;
use App\Http\Requests\ReplayRequest;
use App\Models\Comment;
use App\Models\Emoji;
use App\Models\Feeling;
use App\Models\Like;
use App\Models\Notification;
use App\Models\User;
use App\Traits\Imageable;
use App\Traits\Responseable;
use App\Traits\Shareable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    use Responseable, Imageable, Shareable;

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
        $emojis = Emoji::select('id', 'css_class', 'color', 'type_' . $lang . ' as type')->orderBy('raw_order')->get();
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
                return $this->returnSuccessMessage('stored and shared successfully', 'F000');
            break;
        }
    }

    public function diary($lang)
    {
        $user_id = Auth::id();
        $cats = Feeling::select('category')->distinct()->get();
        $nn = "";
        foreach($cats as $cat)
        {
            $nn .= $cat->category . ',';
        }
        $nn = substr($nn, 0, -1);
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang . ' as type', 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->with('comments', function($q){
                            $q->whereRaw('parent_id IS NULL');
                            $q->with('user');
                            $q->with('children', function($cq){
                                    return $cq->with('user');
                            });
                            return $q;
                        })
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->orderby('created_at', 'desc')
                        ->get();
        return $this->returnData('diary', $feels, $nn);
    }

    public function diaryAsc($lang)
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang . ' as type', 'user')
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
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang . ' as type', 'user')
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
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang . ' as type', 'user')
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
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang . ' as type', 'user')
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
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang . ' as type', 'user')
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
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang . ' as type', 'user')
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
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang . ' as type', 'user')
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
        $feels = Feeling::with('emojis:id,css_class,color,type_' . $lang . ' as type', 'user')
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

    public function profile()
    {
        $user = Auth::user();
        return $this->returnData('user_info', $user, 'user info for profile page');
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
        return $this->returnSuccessMessage('Email Updated Successfully', 'F000');
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
        return $this->returnSuccessMessage('Info Updated Successfully', 'F000');
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
        return $this->returnSuccessMessage('Password Updated Successfully', 'F000');
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
        return $this->returnSuccessMessage('Profile Picture Updated Successfully', 'F000');
    }

    public function showComments($id)
    {
        if(auth()->check()){
            $user_id = Auth::id();
        }else{
            $user_id = 123456487845435;
        }
        $feel = Feeling::with('emojis', 'user') 
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->findOrFail($id);
        if(Auth::check())
        {
            $this->authorize('show', $feel);
        } else {
            if($feel->type == 0) abort(403);
        }
        
        if(Auth::check())
        {
            if($feel->user_id == Auth::id()){
            
               $comments = Comment::with('children')
                                ->with('user')
                                ->where('feeling_id', $feel->id)
                                ->whereRaw('parent_id IS NULL')
                                ->orderby('created_at', 'desc')
                                ->get(); 
            }else{
                $comments = Comment::with('children')
                                    ->with('user')
                                    ->where('feeling_id', $feel->id)
                                    ->whereRaw('parent_id IS NULL')
                                    ->where(function($q){
                                        return $q ->where('type', '1')
                                                  ->orWhere('user_id', Auth::id());
                                    })
                                    ->orderby('created_at', 'desc')
                                    ->get();
            }
        }else{
            $comments = Comment::with('children')
                                    ->with('user')
                                    ->where('feeling_id', $feel->id)
                                    ->whereRaw('parent_id IS NULL')
                                    ->where('type', '1')
                                    ->orderby('created_at', 'desc')
                                    ->get();
        }
            
        
        return $this->returnData('comments', $comments, 'comments retreived successfully');
    }

    public function storeComment(CommentRequest $request,$feel_id)
    {
        $feeling = Feeling::findOrFail($feel_id);
        $original_id = $feeling->user_id;
        $registatoin_ids = User::where('id', $original_id)->pluck('fcm_token');

        $image = NULL;

        if($request->image){
            $image = $this->saveImage($request->image, 'assets/images/feels');
        }

        if(Auth::check() && !$request->has('anonymous')){
            $user_id = Auth::id();
            $com = Comment::create([
                'user_id' => $user_id,
                'feeling_id' => $feel_id,
                'comment'  => $request->comment,
                'image'   => $image,
            ]);
            Notification::create([
                'user_id' => $user_id,
                'owner_id' => $original_id,
                'type_id' => $feeling->id,
                'comment_id' => $com->id,
                'type' => 'comment'
            ]);
            $data = [
                'title' => 'FeelingSupport',
                'body' => Auth::user()->name . ' Commented on your Note',
                'type' => 'comment',
            ];
            // if($user_id != $original_id)
            // {
            //     $this->sendMessageThroughFCM($registatoin_ids, $data);
            // }

        }else{
            $com = Comment::create([
                'guest_name' => 'Anonymous',
                'feeling_id' => $feel_id,
                'comment'  => $request->comment,
                'image'   => $image,
            ]);
            Notification::create([
                'user_id' => 0,
                'type_id' => $feeling->id,
                'owner_id' => $original_id,
                'type' => 'comment',
                'comment_id' => $com->id,
            ]);
            $data = [
                'title' => 'FeelingSupport',
                'body' => 'Anonymous Commented on your Note',
                'type' => 'comment',
            ];
            
            //$this->sendMessageThroughFCM($registatoin_ids, $data);
        }
        
        return $this->returnSuccessMessage('commented Successfully', 'F000');
    }

    public function replay(ReplayRequest $request, $feel_id, $comment_id)
    {
        $feeling = Feeling::findOrFail($feel_id);
        $commenting = Comment::findOrFail($comment_id);
        $user_id = Auth::id();
        $original_id = $commenting->user_id;
        $rep = $comment = Comment::create([
            'user_id' => $user_id,
            'feeling_id' => $feel_id,
            'parent_id'  => $comment_id,
            'comment'  => $request->replay
        ]);
        $cts_ids = Comment::select('users.id')->join('users', 'users.id','=','comments.user_id')->where('parent_id', $commenting->id)->distinct()->pluck('users.id')->toarray();
        $cts_ids = implode(',', $cts_ids);
        $cts = Comment::where('parent_id', $commenting->id)->distinct()->pluck('id');
        Notification::create([
            'user_id' => $user_id,
            'owner_id' => $original_id,
            'type_id' => $feeling->id,
            'type' => 'replay',
            'comment_id' => $commenting->id,
            'replay_id' => $rep->id,
            'replayed_on' => $cts,
            'replayed_on_ids' => $cts_ids,
        ]);
        $gcomment = Comment::findOrFail($comment_id);
        if($gcomment->guest_name == 'Anonymous')
        {
            $gcomment->type = 1;   
            $gcomment->save();
        }

        return $this->returnSuccessMessage('replyed Successfully', 'F000');
    }

    public function deleteComment($feel_id, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        $feel = Feeling::findOrFail($feel_id);
        if (auth()->user()->can('showComment', $feel) or auth()->user()->can('deleteComment', $comment)){
            if($comment->guest_name != 'Anonymous'){
                $notifications = Notification::where(["owner_id" => Auth::id(), 
                                                      "type_id" => $feel_id, 
                                                      "comment_id" => $comment->id])->get();
                                              $notifications->each(function($n){
                                                $n->delete();
                                              });
                                }
            $comment->delete();
            Comment::where('parent_id', $comment_id)->delete();

            return $this->returnSuccessMessage('Your Comment Has Been Deleted Successfully', 'F000');
        }else{
            return $this->returnError('E000', 'Unauthoeized to delete this comment');
        }
        
    }

    public function makeCommentPrivate($feel_id, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        $feel = Feeling::findOrFail($feel_id);
        $this->authorize('makePrivate', $feel);
        $comment->type = 0;
        $comment->save();

        return $this->returnSuccessMessage('The Comment Has Been Made Private', 'F000');
    }

    public function makeCommentPublic($feel_id, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        $feel = Feeling::findOrFail($feel_id);
        $this->authorize('makePublic', $feel);
        $comment->type = 1;
        $comment->save();

        return $this->returnSuccessMessage('The Comment Has Been Made Public', 'F000');  
    }

    public function makeAllCommentsPrivate($id)
    {
        $feel = Feeling::findOrFail($id);
        $this->authorize('makePrivate', $feel);
        $comments = Comment::where('feeling_id', $feel->id)
                           ->whereRaw('parent_id IS NULL')
                           ->get();

        $comments->each(function($comment){
            $comment->type = 0;
            $comment->save();
        });

        $feel->save();

        return $this->returnSuccessMessage('all comments Has Been Made Private', 'F000');
    }

    public function makeAllCommentsPublic($id)
    {
        $feel = Feeling::findOrFail($id);
        $this->authorize('makePublic', $feel);
        $comments = Comment::where('feeling_id', $feel->id)
                           ->whereRaw('parent_id IS NULL')
                           ->get();

        $comments->each(function($comment){
            $comment->type = 1;
            $comment->save();
        });
        $feel->save();

        return $this->returnSuccessMessage('all comments Has Been Made public', 'F000');
    }

    public function uploadBaseImage(Request $request)
    {
        $user_id   = Auth::id();
        $user_name = Auth::user()->name; 

        $image_s = $this->saveSharedImage($request->imagedata);

        $data = Feeling::create([
            "reason"  => $request->reason ,
            "image"   => $image_s,
            "category" => "thanks",
            "user_id" => $user_id,
            "type" => "1"
        ]);
        
        $data = ['user_name' => $user_name, 'id' => $data->id];
        return $this->returnData('data', $data, 'info to construct the link of the feeling');
    }

    public function uploadChartImage(Request $request)
    {
        $user_id   = Auth::id();
        $user_name = Auth::user()->name; 

        $image_s = $this->saveSharedImage($request->imagedata);
        // if($request->startdatestart)
        // {
        //     $startdatestart = $request->startdatestart;
        //     $startdateend   = $request->startdateend;
        //     $enddatestart   = $request->enddatestart;
        //     $enddateend   = $request->enddateend;
        //     $period = "";
        //     if($startdatestart == $startdateend)
        //     {
        //         $period = " ( " . $startdateend . " ) ";
        //     }else
        //     {
        //         $period = " ( " . $startdatestart . " => " . $startdateend . " ) ";
        //     }
        //     $period .= " , ";
        //     if($enddatestart == $enddateend)
        //     {
        //         $period .= " ( " . $enddateend . " ) ";
        //     }else
        //     {
        //         $period .= " ( " . $enddatestart . " => " . $enddateend . " ) ";
        //     }
        // }else
        // {
        //     $datestart = $request->datestart;
        //     $dateend   = $request->dateend;
        //     $period = "";
        //     if($datestart == $dateend)
        //     {
        //         $period = " ( " . $datestart . " ) ";
        //     }else
        //     {
        //         $period = " ( " . $datestart . " => " . $dateend . " ) ";
        //     }
        // }
        
        $data = Feeling::create([
            "reason"  => $request->reason,
            "image"   => $image_s,
            "category" => "statistics",
            "user_id" => $user_id,
            "type" => "1"
        ]);
        
        $data = ['user_name' => $user_name, 'id' => $data->id];
        return $this->returnData('data', $data, 'info to construct the link of the feeling');
    }

}
