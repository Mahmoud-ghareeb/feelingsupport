@extends('layouts.site')

@section('title')
@endsection
@section('content')
<?php use Illuminate\Support\Facades\Schema; ?>
<div class="container" style="margin-top: -8px !important;">
    <div class="row justify-content-center" style="background: white;margin-bottom: 15px;border-radius: 15px;margin-top: 10px;">
            <div class="col-md-10" >
                @can('delete', $feel)
                <div @if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl') style="position: absolute; left: 0px; width: 50px;" @else style="position: absolute; right: 0px; width: 50px;" @endif>
                    <ul class="dropdown">
                        <li class="nav-item" style="list-style: none;">
                            <a id="dropdownMenuButton{{$feel->id}}" style="color:black;" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="bi bi-three-dots" style="font-size: 27px;position: absolute;right: 12px;left: 12px;top: 0px;"></i>
                            </a>
                            <div class="dropdown-menu dropdownMenuButton{{$feel->id}}" aria-labelledby="dropdownMenuButton{{$feel->id}}" style="top: 10px;" >
                                @if($feel->type == 0)
                                    <a class="dropdown-item" href="{{ route('feeling.make.public', $feel->id) }}">{{__('messages.Make Public')}}</a>
                                @else
                                    <a class="dropdown-item" href="{{ route('feeling.make.private', $feel->id) }}">{{__('messages.Make Private')}}</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('feeling.delete', $feel->id) }}">{{__('messages.Delete')}}</a>               
                                <a class="dropdown-item copy-link" href="javascript:void(0)" data-link="{{route('feeling.show', [$feel->user->name, $feel->id])}}">{{__('messages.Copy Link Url')}}</a>                                 
                            </div>
                        </li>
                    </ul> 
                </div>
                @endcan 
                
                    <div style="width: fit-content;display: flex;">
                        <a href="{{route('feeling.user', $feel->user->name)}}">
                            <img src="{{asset($feel->user->picture)}}" style="border-radius: 50%;margin-top: 12px;" width="50" height="50">
                        </a>
                        <div style="margin-top: 10px;margin-left: 10px;margin-right: 10px;">
                            <p style="margin: 0px;">
                                <a href="{{route('feeling.user', $feel->user->name)}}" style="color: black;">{{$feel->user->first_name}} {{$feel->user->last_name}}</a>  
                                @if($feel->type == 0)
                                    <i class="fa-solid fa-lock"></i>
                                @else
                                    <i class="fa-solid fa-lock-open"></i>
                                @endif
                            </p>
                            <p class="date-display"><?php 
                                                        $my_date = Carbon\Carbon::now()->subDays(6);
                                                        $bost_date = $feel->created_at;
                                                        if(strtotime($bost_date) < strtotime($my_date))
                                                        {
                                                    ?>
                                                        @displayDate($feel->created_at)
                                                    <?php
                                                        }else
                                                        {
                                                            echo $feel->created_at->diffForHumans();
                                                        }
                                                         
                                                    ?></p>
                        </div>

                    </div>
                <div style="min-width: 300px;overflow-x: auto;overflow-y: hidden;white-space: nowrap;">
                    <a href="{{route('feeling.show', [$feel->user->name, $feel->id])}}" class="gooo" style="color:black">
                        <div class="emmo-div" style="position: relative;display: flex;">
                        
                        @if(!empty($feel->emojis[0]))
                        <p style="padding-top: 10px;margin-left: 10px;margin-right: 10px;">{{__('messages.feel with')}}</p>
                        @endif
                        @foreach($feel->emojis as $emoji)
                            <div class="emmo-group" style="width: fit-content;">
                                <i class="fa-solid {{$emoji->css_class}} emmo-size" data-id="3" style="color: <?php echo $emoji->color ?>;font-size:50px;padding: 2px;"></i>   
                                <p class="emmo-text" style="color: <?php echo $emoji->color; ?>; font-size: medium !important; margin-top: 7px;">
                                <?php 
                                    $la = app()->getLocale();
                                    $type = "type_" . $la;
                                    if(Schema::hasColumn('emojis', $type)){
                                        if($emoji->$type == "" || is_null($emoji->$type)){
                                            echo $emoji->type_en;
                                        }else{
                                            echo $emoji->$type;
                                        }
                                    }else{
                                        echo $emoji->type_en;
                                    }  
                                ?>
                                </p>
                            </div>
                        @endforeach
                    </div>
                    </a>
                </div>
                <a href="{{route('feeling.show', [$feel->user->name, $feel->id])}}" class="gooo" style="color:black">
                @if($feel->image)
                    <p dir="auto" style="padding: 4px 2px;word-break: break-word;font-size: 15px;margin-bottom: 15px;">{{$feel->reason}}</p>
                    <img src="{{asset($feel->image)}}" class="center-element img-fluid" style="margin-bottom: 30px;">
                @else
                    <p class="mb-3" dir="auto" style="padding: 4px 2px;word-break: break-word;font-size: 15px;">{{$feel->reason}}</p>
                @endif
                </a>
                <a href="{{route('feeling.show', [$feel->user->name, $feel->id])}}" style="color:black">
                <div style="border-bottom: 1px solid rgb(240, 242, 245);">
                    <span id="like-count{{$feel->id}}" style="margin-left: 3px;margin-right: 3px;vertical-align: bottom;font-size: 12px;color: rgb(197, 87, 84);width: fit-content;display: inline-flex;">@if($feel->likes_count > 0) {{$feel->likes_count}} <p style="margin: 0px 5px;">{{__('messages.like')}}</p>@endif</span> 
                    
                    <span id="show-dot{{$feel->id}}" @if(LaravelLocalization::getCurrentLocaleDirection() == "ltr") style="display:none;margin: 0px 2px 0px -7px;vertical-align: bottom;font-size: 19px;color: rgb(197, 87, 84);" @else style="display:none;margin: 0px -5px 0px 3px;vertical-align: bottom;font-size: 19px;color: rgb(197, 87, 84);" @endif>.</span>

                    @if(($feel->likes_count > 0) and ($feel->comments_count > 0))
                        <span id="remove-dot{{$feel->id}}" @if(LaravelLocalization::getCurrentLocaleDirection() == "ltr") style="margin: 0px 2px 0px -7px;vertical-align: bottom;font-size: 19px;color: rgb(197, 87, 84);" @else style="margin: 0px -5px 0px 3px;vertical-align: bottom;font-size: 19px;color: rgb(197, 87, 84);" @endif>.</span>
                    @endif
                    <span style="margin-left: -2px;margin-right: -2px;font-size: 12px;color: rgb(197, 87, 84);width: fit-content;display: inline-flex;vertical-align: -webkit-baseline-middle;">@if($feel->comments_count > 0) {{$feel->comments_count}} <p style="margin: 0px 5px;">{{__('messages.comment')}}</p> @endif</span>
                </div>
                </a>
                @can('delete', $feel)
                <div class="row likecommentshare" style="margin-top: 3px;margin-bottom: 3px;">
                    <div class="col-4">                        
                        <img class="like" src="{{asset('assets/images/like.png')}}" data-commentCount="{{$feel->comments_count}}" data-count="{{$feel->likes_count}}" width="20px" @if(!empty($feel->likes[0])) style="display: none;" @endif style="cursor: pointer;" id="like{{$feel->id}}" data-id="{{$feel->id}}" alt="Like">
                        <img class="dislike" src="{{asset('assets/images/dislike.png')}}" data-commentCount="{{$feel->comments_count}}" data-count="{{$feel->likes_count}}" @if(empty($feel->likes[0])) style="display: none;" @endif width="20px" style="cursor: pointer;" data-id="{{$feel->id}}" id="dislike{{$feel->id}}" alt="dislike">
                        <p>{{__('messages.like')}}</p>
                    </div>
                    <div class="col-4">
                        <a href="{{route('feeling.show', [$feel->user->name, $feel->id])}}">
                        <i class="fa-regular fa-comment interact-icons" style="font-size: 17px;"></i></a>
                        <p>{{__('messages.comment')}}</p>
                    </div>
                    <div class="col-4">
                        <!--{{route('feeling.share.diary', [$feel->user->name, $feel->id])}}-->
                        <a href="javascript:void(0)"><i class="fa-regular fa-share-from-square share-outside interact-icons" style="font-size: 17px;" id="s{{ $feel->id }}" data-id="{{$feel->id}}" data-url="{{route('feeling.show', [$feel->user->name, $feel->id])}}"></i></a><p>{{__('messages.share')}}</p>
                    </div>
                    
                </div>
                @else
                    <div class="row likecommentshare" style="margin-top: 3px;margin-bottom: 3px;">
                        
                        <div class="col-6">
                            <img class="like" src="{{asset('assets/images/like.png')}}" data-commentCount="{{$feel->comments_count}}" data-count="{{$feel->likes_count}}" width="20px" @if(!empty($feel->likes[0])) style="display: none;" @endif style="cursor: pointer;" id="like{{$feel->id}}" data-id="{{$feel->id}}" alt="Like">
                            <img class="dislike" src="{{asset('assets/images/dislike.png')}}" data-commentCount="{{$feel->comments_count}}" data-count="{{$feel->likes_count}}" @if(empty($feel->likes[0])) style="display: none;" @endif width="20px" style="cursor: pointer;" data-id="{{$feel->id}}" id="dislike{{$feel->id}}" alt="dislike">
                            <p>{{__('messages.like')}}</p>
                        </div>
                        <div class="col-6">
                            <a href="{{route('feeling.show', [$feel->user->name, $feel->id])}}">
                            <i class="fa-regular fa-comment interact-icons" style="font-size: 17px;"></i></a>
                            <p>{{__('messages.comment')}}</p></div>
                        </div>
                @endcan
            </div>
        </div>
</div>       
        <form method="POST" class="row justify-content-center" style="margin-top: -3px;" action="{{ route('feeling.comments.store', $feel->id) }}" enctype="multipart/form-data">
            <div class="col-11 col-sm-8" style="background: white;padding: 10px;border-radius: 18px;">   
                @csrf
                <div class="form-group" style="margin-top: 10px;">
                    <textarea class="form-control" id="comment" name="comment" @auth placeholder="{{__('messages.Comment On His Note')}}" @else placeholder="{{__('messages.Comment On His Note Anonymoous')}}" @endauth rows="6"></textarea>
                </div>
                <div class="form-group" style="margin-top: 20px;display: flex;">
                    <a href="javascript:void(0);" style="display:block;width:fit-content; height:30px;" onclick="document.getElementById('image').click()"><i class="fa-solid fa-image" style="margin: 0px 7px;font-size: 29px;"></i>{{__('messages.Choose an image')}}</a>
                    <input type="file" class="form-control" id="image" name="image" placeholder="" style="display:none">
                    <img id="images" style="max-width: 80px;margin: 0px 20px;" />
                </div> 
                @auth
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="anonymous" id="anonymous" />
                    <label class="form-check-label" for="anonymous" style="margin-right: 24px;">{{__('messages.Comment As Anonymous')}}</label>
                </div>
                @endauth
                <div class="form-group center-element">
                    <input type="submit" class="btn btn-primary" name="submitbutton" style="margin-top: 20px;width: 140px;margin-right: 10px;" value="{{__('messages.Add Comment')}}">
                </div>
            </div>
        </form>
</div>
<section class="gradient-custom">
  <div class="container" style="margin-top: -10px;">   
  @auth
            @if(!empty($comments->first()))
                @if(auth()->id() == $feel->user->id)
                <div class="center-element">
                    <li class="nav-item dropdown" style="list-style: none;">
                        <a id="navbarDropdown" style="color:black;font-size: large;padding: 0px;" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{__('messages.comments')}}
                        </a>
                    
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="left: auto;right: auto;">
                            
                            <a class="dropdown-item" href="{{route('feeling.comments.make.all.public', $feel->id)}}">{{__('messages.Make Comments Public')}}</a>
                            <a class="dropdown-item" href="{{route('feeling.comments.make.all.private', $feel->id)}}">{{__('messages.Make Comments Private')}}</a> 
                        </div>
                    </li>
                    <h5></h5>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-10 col-xl-8" style="margin: 0px auto;display:flex">
                        <div class="dish-menu" style="margin-bottom: 7px;">
                            <ul class="dropdown col-1">
                                <li class="nav-item" style="list-style: none;">
                                    <a id="filter" style="color:black;height: 35px;" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fa-solid fa-arrow-down-short-wide" style="font-size: 27px;position: absolute;right: 0px;"></i>
                                    </a>
                                    <div class="dropdown-menu filter" aria-labelledby="filter" style="top: 40px;" >
                                        <a class="dropdown-item" href="{{route('feeling.show', [$feel->user->name, $feel->id])}}">{{__('messages.latest')}}</a>                        
                                        <a class="dropdown-item" href="{{route('feeling.show.asc', [$feel->user->name, $feel->id])}}">{{__('messages.oldest')}}</a>                                 
                                    </div>
                                </li>
                            </ul> 
                        </div>
                        <!-- {{__('messages.Sort By')}} -->
                         <ul class="dropdown col-4" style="display:none">
                            <li class="nav-item" style="list-style: none;">
                                <a id="filter" style="color:black;" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa-solid fa-filter" style="font-size: 27px;position: absolute;right: 0px;left: 0px;"></i>
                                </a>
                                <div class="dropdown-menu filter" aria-labelledby="filter" style="width: 200px;inset: 0px auto auto 0px;margin: 0px;transform: translate(15px, 17px);left: auto;right: 24px;top: 20px;z-index: 122222;" >
                                                               
                                </div>
                            </li>
                        </ul> 
                        
                    </div>
                    
                </div>
                
                @endif
            @endif
        @endauth             
                    @foreach($comments as $comment)
                    
                    <div class="row d-flex justify-content-center" id="c{{$comment->id}}" style="margin-bottom:15px;border-radius:15px;position: relative;">
        <div class="col-md-12 col-lg-10 col-xl-8" >
        <div style="position: absolute; right: 0px; width: 50px;">
            <ul class="dropdown">
                @if(auth()->check())
                    @if (auth()->user()->can('showComment', $feel) or auth()->user()->can('deleteComment', $comment))
                    <li class="nav-item" style="list-style: none;">
                        <a id="dropdownMenuButton{{$comment->id}}" style="color:black;" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="bi bi-three-dots" style="font-size: 27px;position: absolute;right: 19px;top: -11px;z-index: 999;"></i>
                        </a>
                        <div class="dropdown-menu dropdownMenuButton{{$comment->id}}" aria-labelledby="dropdownMenuButton{{$comment->id}}" style="top: 10px;" >
                            @can('showComment', $feel)
                                @if($comment->type == 0)
                                    <a class="dropdown-item" href="{{ route('feeling.comments.make.public', [$feel->id, $comment->id]) }}?c_id={{$comment->id}}">{{__('messages.Make Public')}}</a>
                                @else
                                    <a class="dropdown-item" href="{{ route('feeling.comments.make.private', [$feel->id, $comment->id]) }}?c_id={{$comment->id}}">{{__('messages.Make Private')}}</a>
                                @endif
                            @endcan                      
                                <a class="dropdown-item" href="{{ route('feeling.comments.delete', [$feel->id, $comment->id]) }}?c_id={{(int)($comment->id + 1)}}">{{__('messages.Delete')}}</a>                        
                            
                        </div>
                    </li>
                    @endif
                @endif
            </ul> 
        </div>
        
        <div class="card" style="border: none; border-radius: 15px;" >
          <div class="card-body p-2">

            <div class="row">
              <div class="col" id="image-div{{$comment->id}}">
                    <div class="d-flex flex-start">
                        <div class="flex-grow-1 flex-shrink-1" >
                            <div class="parent" style="margin-top: 10px;background: #f4d9D5;padding: 10px;border-radius: 15px;">
                                <div class="d-flex justify-content-between align-items-center" >
                                    <?php $name = $comment->user->name ?? '_a00' ?>
                                    @if($name != '_a00')
                                    <div style="width: fit-content;display: flex;">
                                        <a href="{{route('feeling.user', $comment->user->name)}}">
                                            <img src="{{asset($comment->user->picture)}}" style="border-radius: 50%;margin-top: 12px;" width="50" height="50">
                                        </a>
                                        <div style="margin-top: 10px;margin-left: 10px;margin-right: 10px;">
                                            <a href="{{route('feeling.user', $comment->user->name)}}">
                                           <p class="mb-1" style="color: #000;;display: flex;width: max-content;">{{$comment->user->first_name}} {{$comment->user->last_name}}  
                                                @if($comment->type == 0)
                                                    <i class="fa-solid fa-lock" style="padding: 4px 3px 0px 3px;"></i>
                                                @else
                                                    <i class="fa-solid fa-lock-open" style="padding: 4px 3px 0px 3px;"></i>
                                                @endif
                                            </p>
                                            </a>
                                            <p class="date-display"><?php 
                                                                        $my_date = Carbon\Carbon::now()->subDays(6);
                                                                        $bost_date = $comment->created_at;
                                                                        if(strtotime($bost_date) < strtotime($my_date))
                                                                        {
                                                                    ?>
                                                                        @displayDate($feel->created_at)
                                                                    <?php
                                                                        }else
                                                                        {
                                                                            echo $comment->created_at->diffForHumans();
                                                                        }
                                                                         
                                                                    ?></p>
                                        </div>
                                    </div>
                                    @else
                                    <div style="margin-top: 10px;margin-left: 10px;margin-right: 10px;">
                                       <p class="mb-1" style="color:#bf1b2c;">{{__('messages.Anonymous')}}  
                                            @if($comment->type == 0)
                                                <i class="fa-solid fa-lock"></i>
                                            @else
                                                <i class="fa-solid fa-lock-open"></i>
                                            @endif
                                        </p>
                                        <p class="date-display"><?php 
                                                                    $my_date = Carbon\Carbon::now()->subDays(6);
                                                                    $bost_date = $comment->created_at;
                                                                    if(strtotime($bost_date) < strtotime($my_date))
                                                                    {
                                                                ?>
                                                                    @displayDate($feel->created_at)
                                                                <?php
                                                                    }else
                                                                    {
                                                                        echo $comment->created_at->diffForHumans();
                                                                    }
                                                                     
                                                                ?></p>
                                    </div>
                                    @endif
                                    
                                </div>
                                @if($comment->image)
                                    <p class="mb-0 lead" dir="auto">{{$comment->comment}}</p>
                                    <img src="{{asset($comment->image)}}" class="center-element img-fluid" style="margin-bottom: 30px;">
                                @else
                                    <p class="mb-0 lead" dir="auto">{{$comment->comment}}</p>
                                @endif
                                
                            </div>
                        @foreach($comment->children as $child)
                            <div class="d-flex flex-start mt-1 child">
                                
                                <div class="flex-grow-1 flex-shrink-1" >
                                    <div @if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl') class="me-5" @else class="ms-5" @endif style="margin-top: 10px;background: #f4d9D5;padding: 10px;border-radius: 15px;">
                                        <div style="width: fit-content;display: flex;">
                                            <a href="{{route('feeling.user', $child->user->name)}}">
                                                <img src="{{asset($child->user->picture)}}" style="border-radius: 50%;margin-top: 12px;" width="40" height="40">
                                            </a>
                                            <div style="margin-top: 10px;margin-left: 10px;margin-right: 10px;">
                                                <a href="{{route('feeling.user', $child->user->name)}}">
                                               <p class="mb-1" style="color: black;font-size: 14px;">{{$child->user->first_name}} {{$child->user->last_name}}
                                                </p>
                                                </a>
                                                <p class="date-display"><?php 
                                                                    $my_date = Carbon\Carbon::now()->subDays(6);
                                                                    $bost_date = $child->created_at;
                                                                    if(strtotime($bost_date) < strtotime($my_date))
                                                                    {
                                                                ?>
                                                                    @displayDate($feel->created_at)
                                                                <?php
                                                                    }else
                                                                    {
                                                                        echo $child->created_at->diffForHumans();
                                                                    }
                                                                     
                                                                ?></p>
                                            </div>
                                        </div>
                                    <p class="small mb-0" style="margin-left: 10px; margin-right: 10px;" dir="auto">
                                        {{$child->comment}}
                                    </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                        
                    </div>
                </div>
                @can('showComment', $feel)
                <div class="row likecommentshare" style="margin-top: 21px;">
                    
                        @if(auth()->check())
                            <div class="col-6">
                                <button data-toggle="modal" style="border: none;background: none;font-size: 16px;color: #bf1b2c;text-decoration: none;" data-target="@if($name != '_a00') #replay-modal @else #anony-replay-modal @endif" data-url="{{ route('feeling.comments.replay', [$feel->id, $comment->id]) }}" class="btn-sm btn-link @if($name != '_a00') open-replay-modal @else open-anony-replay-modal @endif"><i class="fas fa-reply fa-xs" style="font-size: 14px;"></i> <p>{{__('messages.reply')}}</p></button>
                            </div>
                            <div class="col-6">
                                <button style="border: none;background: none;" >
                                    <i  class="fa-regular share-image fa-share-from-square interact-icons" data-id="image-div{{$comment->id}}" style="font-size: 17px;"></i><p style="margin: 3px;">{{__('messages.share')}}</p>
                                </button>
                            </div>
                            
                        @else
                            <div class="col-12">
                                <button style="border: none;background: none;" >
                                    <i  class="fa-regular share-image fa-share-from-square interact-icons" data-id="image-div{{$comment->id}}" style="font-size: 17px;"></i><p style="margin: 3px;">{{__('messages.share')}}</p>
                                </button>
                            </div>
                        @endif
                </div>
                @else
                    <div class="row likecommentshare" style="margin-top: 21px;">
                    
                        @if(auth()->check())
                            <div class="col-12">
                                <button data-toggle="modal" style="border: none;background: none;font-size: 16px;color: #bf1b2c;text-decoration: none;" data-target="@if($name != '_a00') #replay-modal @else #anony-replay-modal @endif" data-url="{{ route('feeling.comments.replay', [$feel->id, $comment->id]) }}" class="btn-sm btn-link @if($name != '_a00') open-replay-modal @else open-anony-replay-modal @endif"><i class="fas fa-reply fa-xs" style="font-size: 14px;"></i> <p>{{__('messages.reply')}}</p></button>
                            </div>
                        @endif
                    </div>
                @endcan
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
    
  </div>
  <div class="modal fade" id="reply-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="replay-action" method="POST" action="">
                    @csrf
                    <div class="modal-header" style="display:none">
                        <h5 class="modal-title">{{__('messages.reply')}}</h5>
                        <button type="button" class="close" data-dismiss="modal">
                        <span></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="message" style="display:none">{{__('messages.Reply on his comment')}}</label>
                            <textarea required class="form-control" name="replay" rows="3" placeholder="{{__('messages.register replay message')}}"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" style="margin:0px auto; width:150px;" class="btn btn-primary ">{{__('messages.reply')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
  <div class="modal fade" id="reply-anony-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="replay-anony-action" method="POST" action="">
                    @csrf
                    <div class="modal-header" style="display:none">
                        <h5 class="modal-title">{{__('messages.reply')}}</h5>
                        <button type="button" class="close" data-dismiss="modal">
                        <span></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="message" style="display:none">{{__('messages.Reply on his comment')}}</label>
                            <textarea required class="form-control" name="replay" rows="3" placeholder="{{__('messages.if you replay comment will be public')}}"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" style="margin:0px auto; width:150px;" class="btn btn-primary ">{{__('messages.reply')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
@section('scripts')
    
    @if (Session::has('success'))
        <script>
            $(document).ready(function(){
                swal({text:"{{ Session::get('success') }}", button: "{{__('messages.ok')}}"});
            });
            
        </script>
    @endif
    <script>
        $(document).ready(function(){
            var i_id;
            $(".share-image").on('click', function () {
                //$(this).parent().css('display', 'none');
                i_id = $(this).attr('data-id');
                
                $("#share-modal").modal('show');
                
            });
            $("#share-action").on('submit', function(e){
                    e.preventDefault();
                    $("#share-modal").modal('hide');
                html2canvas(document.getElementById(i_id)).then(function (canvas) { 
                    var dataUrl = canvas.toDataURL();
                     var text = $("#commentShare").val();
                    var imagedata = dataUrl.replace(/^data:image\/(png|jpg);base64,/,"");
                    
                    $.ajax({
                            
                        type:"POST",
                        url: "{{route('upload.image')}}",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            "reason": text,
                            "imagedata":imagedata
                        },
                        success: function(data){
                            var name = data.user_name;
                            var iddd = data.id;

                            var tx = "<?php echo env('APP_URL'); ?>/feelings/feel/" + name + "/" + iddd;
                            const shareData = {
                                title: 'FeelingSupport',
                                text: "{{__('messages.share feel message')}}",
                                url: tx
                            }
                            
                            try {
                                navigator.share(shareData);
                            } catch (err) {
                                console.log(err);
                            }
                            
                        },
                        error: function(err){
                            console.log(err);
                        }
                            
                    });
                });
            });
        });
    </script>
    <script>
        $(document).ready(function(){

            document.getElementById('image').onchange = function () {
              var src = URL.createObjectURL(this.files[0])
              document.getElementById('images').src = src
            }

            $(".lhome").css('color', 'black');
            $(".lnotes").css('color', '#bf1b2c');
            $(".lcharts").css('color', 'black'); 

            $(".like").on("click", function(){
                var count = $(this).data('count');
                count +=1;
                var id = $(this).attr('data-id');
                var ccount = $(this).attr('data-commentCount');
                if(ccount > 0)
                {
                    $("#show-dot" + id).css("display", "inline-flex");
                    $("#remove-dot" + id).css("display", "none");
                }
                $("#like-count" + id).html(count + "<p style='margin: 0px 5px;''>{{__('messages.like')}}</p>");
                $(this).attr('data-count', count); 
                $("#dislike" + id).attr('data-count', count);
                $(this).css('display', 'none');
                $("#dislike" + id).css('display', 'block');
                $.ajax({
                            
                    type:"POST",
                    url: "/feelings/like/" + id,
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "feel_id": id
                    },
                    success: function(data){
                        console.log(data);
                    },
                    error: function(err){
                        console.log(err);
                    }
                        
                });
            });

            $(".dislike").on("click", function(){
                var count = $(this).data('count');
                count -=1;
                var txt = "<p style='margin: 0px 5px;''>{{__('messages.like')}}</p>";
                var id = $(this).attr('data-id');
                if(count == 0)
                {
                    count = "";
                    txt = "";
                    $("#remove-dot" + id).css("display", "none");
                    $("#show-dot" + id).css("display", "none");
                }
                $("#like-count" + id).html(count + txt);
                $(this).attr('data-count', count); 
                $("#like" + id).attr('data-count', count);
                $(this).css('display', 'none');
                $("#like" + id).css('display', 'block')
                $.ajax({
                            
                    type:"POST",
                    url: "/feelings/like/" + id,
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "feel_id": id
                    },
                    success: function(data){
                        console.log(data);
                    },
                    error: function(err){
                        console.log(err);
                    }
                        
                });
            });

            $(".share-outside").on('click', function(){

                let id = $(this).data('id');
                $.ajax({
                            
                    type:"POST",
                    url: "/feelings/share/" + id,
                    data:{
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(data){
                        console.log(data);
                    },
                    error: function(err){
                        console.log(err);
                    }
                        
                });
               
               var tx = $(this).data('url');
               tx = tx.replace('/<?php echo app()->getLocale() ?>/', '/')
              
               const shareData = {
                 title: 'FeelingSupport',
                 text: "{{__('messages.share feel message')}}",
                 url: tx
               }
               
               try {
                   navigator.share(shareData);
               } catch (err) {
                   console.log(err);
               }
               
           });

        });
        
    </script>

    <?php if(isset($_GET['c_id'])){ ?>
                <script>
                    $(document).ready(function(){
                        var navigationFn = {
                            goToSection: function(id) {
                                console.log(id);
                                var off = $(id).offset().top;
                                $('html, body').animate({
                                    scrollTop: off
                                }, 0);
                            }
                        }

                        navigationFn.goToSection('<?php echo "#" . $_GET["c_id"] ?>');
                    });
                </script>
    <?php } ?>
@endsection