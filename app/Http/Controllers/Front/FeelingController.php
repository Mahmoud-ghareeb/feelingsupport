<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeelingRequest;
use App\Models\Comment;
use App\Models\Emoji;
use App\Models\Feeling;
use App\Models\Like;
use App\Models\Notification;
use App\Models\User;
use App\Traits\Imageable;
use App\Traits\Shareable;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jorenvh\Share\ShareFacade;
use App\Traits\Notifiable;
use Illuminate\Support\Facades\Session;
use JamesMills\LaravelTimezone\Facades\Timezone;

class FeelingController extends Controller
{
    use Imageable, Shareable, Notifiable;

    public function __construct()
    {
        $this->middleware('auth')->except('show', 'showUserNotes', 'like');
    }

    public function index()
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis', 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->orderby('created_at', 'desc')
                        ->get();
        return view('front.feels', compact('feels'));
    }

    public function indexAsc()
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis', 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->orderby('created_at', 'asc')
                        ->get();
        return view('front.feels', compact('feels'));
    }

    public function indexDate($date)
    {
        $date = date("Y-m-d", strtotime($date));
        $user_id = Auth::id();
        $feels = Feeling::with('emojis', 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->whereBetween('created_at', [$date.' 00:00:00',$date.' 23:59:59'])
                        ->orderby('created_at', 'desc')
                        ->get();
        return view('front.feels', compact('feels'));
    }

    public function indexPopular()
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis', 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->orderby('comments_count', 'desc')
                        ->orderby('likes_count', 'desc')
                        ->get();
        return view('front.feels', compact('feels'));
    }

    public function indexShare()
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis', 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->where('type', 1)
                        ->orderby('comments_count', 'desc')
                        ->orderby('likes_count', 'desc')
                        ->get();
        return view('front.feels', compact('feels'));
    }

    public function indexPrivate()
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis', 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->where('type', 0)
                        ->orderby('comments_count', 'desc')
                        ->orderby('likes_count', 'desc')
                        ->get();
        return view('front.feels', compact('feels'));
    }

    public function indexMe()
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis', 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->where('category', 'me')
                        ->orderby('created_at', 'desc')
                        ->get();
        return view('front.feels', compact('feels'));
    }

    public function indexStatistics()
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis', 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->where('category', 'statistics')
                        ->orderby('created_at', 'desc')
                        ->get();
        return view('front.feels', compact('feels'));
    }

    public function indexThanks()
    {
        $user_id = Auth::id();
        $feels = Feeling::with('emojis', 'user')
                        ->with(['likes' => function($q) use ($user_id){
                            return $q->where('user_id', $user_id);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->where('category', 'thanks')
                        ->orderby('created_at', 'desc')
                        ->get();
        return view('front.feels', compact('feels'));
    }

    public function showUserNotes($username)
    {
        if(auth()->check()){
            $userid = Auth::id();
        }else{
            $userid = 123456487845435;
        }
        
        $user = User::select('id')
                        ->where('name', $username)
                        ->get();
        
        if(empty($user[0])){
            abort(404);
        }
        $user_id = $user[0]->id;
        // if(Auth::id() == $user_id){
        //     $feels = Feeling::with('emojis', 'user')
        //                 ->with(['likes' => function($q) use ($user_id){
        //                     return $q->where('user_id', $user_id);
        //                 }])
        //                 ->withCount('comments', 'likes')
        //                 ->where('user_id', $user_id)
        //                 ->orderby('created_at', 'desc')
        //                 ->get();
        // }else{
            $feels = Feeling::with('emojis', 'user')
                        ->with(['likes' => function($q) use ($userid){
                            return $q->where('user_id', $userid);
                        }])
                        ->withCount('comments', 'likes')
                        ->where('user_id', $user_id)
                        ->where('type', 1)
                        ->orderby('created_at', 'desc')
                        ->get();
        // }
        
        return view('front.feels', compact('feels'));
    }

    public function show($username, $id)
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
            
        
            
        return view('front.feel', compact('feel', 'comments'));
    }

    public function viewThenShow($username, $id, $noti_id)
    {
        $noti = Notification::findOrFail($noti_id);
        $noti->is_viewed = 1;
        $noti->save();
        if($username == 0 && $id == 0)
            return redirect()->back();
        return redirect()->to(route('feeling.show', [$username, $id]));
    }

    public function showAsc($username, $id)
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
                                ->orderby('created_at', 'asc')
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
                                    ->orderby('created_at', 'asc')
                                    ->get();
            }
        }else{
            $comments = Comment::with('children')
                                    ->with('user')
                                    ->where('feeling_id', $feel->id)
                                    ->whereRaw('parent_id IS NULL')
                                    ->where('type', '1')
                                    ->orderby('created_at', 'asc')
                                    ->get();
        }
            
        
            
        return view('front.feel', compact('feel', 'comments'));
    }

    public function store(FeelingRequest $request)
    {
        $user_id   = Auth::id();
        $user_name = Auth::user()->name; 
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
            case __('messages.save'):
                return redirect()->route('feeling.feels');
            break;

            case __('messages.save and share'): 
                $data->type = 1;
                $data->save();
                return redirect()->route('feeling.feels');
            break;
        }
    }

    public function share($id)
    {
        $feeling = Feeling::findOrFail($id);
        $this->authorize('share', $feeling);

        $feeling->type = 1;
        $feeling->save();
        // $shareComponent = ShareFacade::page(
        //     env('APP_URL') . '/feelings/feel/' . $user_name . '/' . $id,
        //     'support him please!!',
        // )
        // ->facebook()
        // ->twitter()
        // ->telegram()
        // ->whatsapp()
        // ->pinterest();
        
        return response()->json('done');
    }

    public function shareDiary($user_name, $id)
    {
        $feeling = Feeling::findOrFail($id);
        $this->authorize('share', $feeling);

        $feeling->type = 1;
        $feeling->save();
        $shareComponent = ShareFacade::page(
            env('APP_URL') . '/feelings/feel/' . $user_name . '/' . $id,
            'support him please!!',
        )
        ->facebook()
        ->twitter()
        ->telegram()
        ->whatsapp()
        ->pinterest();
        
        return view('front.share_diary', compact('shareComponent'));
    }

    public function makePrivate($id)
    {
        $feel = Feeling::findOrFail($id);
        $this->authorize('makePrivate', $feel);
        $feel->type = 0;
        $feel->save();

        return redirect()->to(route('feeling.show', [$feel->user->name, $feel->id]))->with('success', __('messages.Your Note Has Been Made Private'));
    }

    public function makePublic($id)
    {
        $feel = Feeling::findOrFail($id);
        $this->authorize('makePublic', $feel);
        $feel->type = 1;
        $feel->save();
        return redirect()->to(route('feeling.show', [$feel->user->name, $feel->id]))->with('success', __('messages.Your Note Has Been Made Public'));   
    }

    public function delete($id)
    {
        $feel = Feeling::findOrFail($id);
        $this->authorize('delete', $feel);
        $feel->delete();
        return redirect()->to(route('feeling.feels'))->with('success', 'Your Note Has Been Deleted Successfully');
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
        return response()->json($data);
    }

    public function uploadChartImage(Request $request)
    {
        $user_id   = Auth::id();
        $user_name = Auth::user()->name; 

        $image_s = $this->saveSharedImage($request->imagedata);
        if($request->startdatestart)
        {
            $startdatestart = $request->startdatestart;
            $startdateend   = $request->startdateend;
            $enddatestart   = $request->enddatestart;
            $enddateend   = $request->enddateend;
            $period = "";
            if($startdatestart == $startdateend)
            {
                $period = " ( " . $startdateend . " ) ";
            }else
            {
                $period = " ( " . $startdatestart . " => " . $startdateend . " ) ";
            }
            $period .= " , ";
            if($enddatestart == $enddateend)
            {
                $period .= " ( " . $enddateend . " ) ";
            }else
            {
                $period .= " ( " . $enddatestart . " => " . $enddateend . " ) ";
            }
        }else
        {
            $datestart = $request->datestart;
            $dateend   = $request->dateend;
            $period = "";
            if($datestart == $dateend)
            {
                $period = " ( " . $datestart . " ) ";
            }else
            {
                $period = " ( " . $datestart . " => " . $dateend . " ) ";
            }
        }
        
        $data = Feeling::create([
            "reason"  => $request->reason,
            "image"   => $image_s,
            "category" => "statistics",
            "user_id" => $user_id,
            "type" => "1"
        ]);
        
        $data = ['user_name' => $user_name, 'id' => $data->id];
        return response()->json($data);
    }

    public function like(Request $request)
    {
        $feel = Feeling::findOrFail($request->feel_id);
        $request->validate([
            'feel_id' => ['required', 'integer']
        ]);
        $registatoin_ids = User::where('id', $feel->user_id)->pluck('fcm_token');
        if(Auth::check()){
            $likedata = like::where(["user_id" => Auth::id(), "feeling_id" => $request->feel_id])->get();
            if(empty($likedata[0]))
            {
                $user_id = Auth::id();
                like::create([
                    "feeling_id" => $request->feel_id,
                    "user_id" => $user_id,
                    "owner_id" => $feel->user_id
                ]);
                Notification::create([
                    'user_id' => $user_id,
                    "owner_id" => $feel->user_id,
                    'type_id' => $request->id,
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
                "feeling_id" => $request->feel_id,
                "user_id" => NULL,
                "owner_id" => $feel->user_id
            ]);
            Notification::create([
                'user_id' => 0,
                "owner_id" => $feel->user_id,
                'type_id' => $request->id,
                'type' => 'like'
            ]);
            
            $data = [
                'title' => 'FeelingSupport',
                'body' => 'Anonymous liked your Note',
                'type' => 'like',
            ];
            
            //$this->sendMessageThroughFCM($registatoin_ids, $data);
        }
        
        return response()->json('success');
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
        
        return response()->json($data);
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

        return response()->json($data->count());
    }

    public function returnToAdmin()
    {
        $id = Auth::id();
        $user = User::findOrFail($id);
        $admin_id = $user->admin_id;
        $user->admin_id = NULL;
        $user->save();
        $admin = User::find($admin_id);
        Auth::login($admin);
        return redirect()->to('admin');
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

        return redirect()->back()->with('success', __('messages.all feels Has Been Made Private'));
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

        return redirect()->back()->with('success', __('messages.all feels Has Been Made Public'));
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

        return redirect()->back();
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
        
        return redirect()->back();
    }

    public function searchEmojis(Request $request)
    {
        $request->validate([
            's' => 'string|nullable'
        ]);
        if(empty($request->s)) {
            $lang = app()->getLocale();
            $data = Emoji::all();
        }else {
            $lang = app()->getLocale();
            $data = Emoji::where('type_' . $lang, 'LIKE', "%$request->s%")->get();
        }

        return $data;
    }
    
}
