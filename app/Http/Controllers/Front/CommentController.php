<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ReplayRequest;
use App\Models\Comment;
use App\Models\Feeling;
use App\Models\Notification;
use App\Models\User;
use App\Traits\Notifiable;
use App\Traits\Imageable;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    use Notifiable, Imageable;

    public function __construct()
    {
        $this->middleware('auth')->except('store');
    }

    public function store(CommentRequest $request,$feel_id)
    {
        $feeling = Feeling::findOrFail($feel_id);
        //$this->authorize('createComment', $feeling);
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
        
        return redirect()->back()->with('success', __('messages.commented Successfully'));
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
        return redirect()->back();
    }

    public function delete($feel_id, $comment_id)
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
            return redirect()->to(route('feeling.show', [$feel->user->name, $feel->id]) . "?c_id=c" . $comment->id)->with('success', __('messages.Your Comment Has Been Deleted Successfully'));
        }else{
            return redirect()->to(route('feeling.show', [$feel->user->name, $feel->id]) . "?c_id=c" . $comment->id);
        }
        
    }

    public function makePrivate($feel_id, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        $feel = Feeling::findOrFail($feel_id);
        $this->authorize('makePrivate', $feel);
        $comment->type = 0;
        $comment->save();
        return redirect()->to(route('feeling.show', [$feel->user->name, $feel->id]) . "?c_id=c" . $comment->id)->with('success', __('messages.The Comment Has Been Made Private'));
    }

    public function makePublic($feel_id, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        $feel = Feeling::findOrFail($feel_id);
        $this->authorize('makePublic', $feel);
        $comment->type = 1;
        $comment->save();
        return redirect()->to(route('feeling.show', [$feel->user->name, $feel->id]) . "?c_id=c" . $comment->id)->with('success', __('messages.The Comment Has Been Made Public'));   
    }

    public function makeAllPrivate($id)
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
        return redirect()->back()->with('success', __('messages.all comments Has Been Made Private'));
    }

    public function makeAllPublic($id)
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
        return redirect()->back()->with('success', __('messages.all comments Has Been Made public')); 
    }
}