@extends('layouts.site')

@section('title')
@auth
    @if(!empty($feels->first()))
        @if(auth()->id() == $feels->first()->user->id)
        <li class="nav-item dropdown" style="list-style: none;">
            <a id="navbarDropdown" style="color:black;font-size: x-large;padding: 0px;" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{__('messages.Feels')}}
            </a>
        
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="left: auto;right: auto;">
                
                <a class="dropdown-item" href="{{route('all.public')}}">{{__('messages.Make feels Public')}}</a> 
                <a class="dropdown-item" href="{{route('all.private')}}">{{__('messages.Make feels Private')}}</a> 
            </div>
        </li>
        
        <ul class="dropdown col-1" style="position:absolute; @if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl') left:9px @else right:9px; @endif">
            <li class="nav-item" style="list-style: none;">
                <a id="filter" style="color:black;" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="fa-solid fa-arrow-down-short-wide" style="font-size: 27px;position: absolute;right: 0px;"></i>
                </a>
                <div class="dropdown-menu filter" aria-labelledby="filter" style="top: 10px;" >
                    <a class="dropdown-item" href="{{route('feeling.feels')}}">{{__('messages.latest')}}</a>
                    <a class="dropdown-item" href="{{route('feeling.feels.asc')}}">{{__('messages.oldest')}}</a>
                    <a class="dropdown-item" href="{{route('feeling.feels.popular')}}">{{__('messages.popular')}}</a> 
                    
                    
                </div>
            </li>
        </ul>
        <ul class="dropdown col-1" style="position:absolute; @if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl') left:50px @else right:50px; @endif">
            <li class="nav-item" style="list-style: none;">
                <a id="filter" style="color:black;" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="fa-solid fa-filter" style="font-size: 27px;position: absolute;right: 0px;"></i>
                </a>
                <div class="dropdown-menu filter" aria-labelledby="filter" style="top: 10px;" >
                    <a class="dropdown-item" href="javascript:void(0);" id="for-date">{{__('messages.specific')}}</a>
                    <a class="dropdown-item" href="{{route('feeling.feels.share')}}">{{__('messages.shared feels')}}</a>
                    <a class="dropdown-item" href="{{route('feeling.feels.private')}}">{{__('messages.private feels')}}</a>                         
                </div>
            </li>
        </ul>
        @endif
    @endif
@endauth
@endsection
@section('content')
<?php use Illuminate\Support\Facades\Schema; ?>

    @if(!empty($feels->first()))
        @if(auth()->id() == $feels->first()->user->id)
            <div class="container" style="margin-top: -8px !important;">
        @else
            <div class="container" style="margin-top: 0px !important;">
        @endif
    @endif
        @auth
            @if(!empty($feels->first()))
                @if(auth()->id() == $feels->first()->user->id)
                <div class="row">
                    <div style="min-width: 300px;overflow: auto hidden;white-space: nowrap;margin-top: 8px;">
                        <div style="width: fit-content;display: flex;">
                            <div class="col-11 dish-menu" style="margin-bottom: 7px;display: contents;">
                                <div class="nav nav-pills ftco-animate" style="margin-top: 7px;display: contents;" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link" href="{{route('feeling.feels')}}" id="v-pills-all-tab" >{{__('messages.all feels')}}</a> 
                                    <a class="nav-link" href="{{route('feeling.feels.me')}}" id="v-pills-share-tab" >{{__('messages.my feels')}}</a> 
                                    <a class="nav-link" href="{{route('feeling.feels.statistics')}}" id="v-pills-stat-tab" >{{__('messages.statistics')}}</a> 
                                    <a class="nav-link" href="{{route('feeling.feels.thanks')}}" id="v-pills-thank-tab" >{{__('messages.thanks')}}</a> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- {{__('messages.Sort By')}} -->
                     
                </div>
                @endif
            @else
                <div class="justify-content-center" style="padding: 20px;">
                        <p>{{__('messages.There is no feels')}}</p>
                </div>
            @endif
            
        @endauth
        
        @foreach($feels as $feel)
        <div class="row justify-content-center" style="background: white;margin-bottom:15px;border-radius:15px;">
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
                                <i class="fa-solid {{$emoji->css_class}} emmo-size" data-id="3" style="color: <?php echo $emoji->color ?>;font-size:50px;"></i>   
                                <p class="emmo-text" style="color: <?php echo $emoji->color; ?>;font-size: medium !important; margin-top: 7px;">
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
                <div>
                <span id="like-count{{$feel->id}}" style="margin-left: 3px;margin-right: 3px;font-size: 12px;color: rgb(197, 87, 84);width: fit-content;display: inline-flex;">@if($feel->likes_count > 0) {{$feel->likes_count}} <p style="margin: 0px 5px;">{{__('messages.like')}}</p>@endif</span> 
                <span style="margin-left: -2px;margin-right: 3px;font-size: 12px;color: rgb(197, 87, 84);width: fit-content;display: inline-flex;">@if($feel->comments_count > 0) {{$feel->comments_count}} <p style="margin: 0px 5px;"> | {{__('messages.comment')}}</p> @endif</span>
                </div>
                @can('delete', $feel)
                <div class="row likecommentshare" style="margin-bottom: 23px;">
                    <div class="col-4">
                        <img class="like" src="{{asset('assets/images/like.png')}}" data-count="{{$feel->likes_count}}" width="20px" @if(!empty($feel->likes[0])) style="display: none;" @endif style="cursor: pointer;" id="like{{$feel->id}}" data-id="{{$feel->id}}" alt="Like">
                        <img class="dislike" src="{{asset('assets/images/dislike.png')}}" data-count="{{$feel->likes_count}}" @if(empty($feel->likes[0])) style="display: none;" @endif width="20px" style="cursor: pointer;" data-id="{{$feel->id}}" id="dislike{{$feel->id}}" alt="dislike">
                        <p>{{__('messages.like')}}</p>
                    </div>
                    <div class="col-4">
                        <a href="{{route('feeling.show', [$feel->user->name, $feel->id])}}">
                        <i class="fa-regular fa-comment interact-icons" style="font-size: 17px;"></i></a>
                        <p>{{__('messages.comment')}}</p>
                    </div>
                    <div class="col-4">
                        <!--{{route('feeling.share.diary', [$feel->user->name, $feel->id])}}-->
                        <a href="javascript:void(0)"><i class="fa-regular fa-share-from-square share-outside interact-icons" style="font-size: 17px;" data-url="{{route('feeling.show', [$feel->user->name, $feel->id])}}"></i></a><p>{{__('messages.share')}}</p>
                    </div>
                    
                </div>
                @else
                    <div class="row likecommentshare" style="margin-bottom: 23px;">
                        
                        <div class="col-6">
                            <span id="like-count{{$feel->id}}" style="margin-left: 3px; margin-right: 3px;font-size: 15px;color: rgb(197, 87, 84);">@if($feel->likes_count > 0) {{$feel->likes_count}} @endif</span></i></a>
                            <img class="like" src="{{asset('assets/images/like.png')}}" data-count="{{$feel->likes_count}}" width="20px" @if(!empty($feel->likes[0])) style="display: none;" @endif style="cursor: pointer;" id="like{{$feel->id}}" data-id="{{$feel->id}}" alt="Like">
                            <img class="dislike" src="{{asset('assets/images/dislike.png')}}" data-count="{{$feel->likes_count}}" @if(empty($feel->likes[0])) style="display: none;" @endif width="20px" style="cursor: pointer;" data-id="{{$feel->id}}" id="dislike{{$feel->id}}" alt="dislike">
                            <p>{{__('messages.like')}}</p>
                        </div>
                        <div class="col-6">
                            <span style="margin-left: 3px;margin-right: 3px;font-size: 15px;color: rgb(197, 87, 84);">@if($feel->comments_count > 0) {{$feel->comments_count}} @endif</span>
                            <a href="{{route('feeling.show', [$feel->user->name, $feel->id])}}">
                            <i class="fa-regular fa-comment interact-icons" style="font-size: 17px;"></i></a>
                            <p>{{__('messages.comment')}}</p></div>
                        </div>
                @endcan
            </div>
        </div>
        @endforeach
</div>
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
            
            $('.gooo').click(function(e) {
                e.preventDefault();

            }).dblclick(function() {
                window.location = this.href;
                return false;
            });

            $("#for-date").on('click', function(){
                $("#dateSPP").datepicker({
                    language: '{{app()->getLocale()}}',
                    autoHide: true,
                    endDate: new Date()
                });
                $("#dateD").val('<?php echo date('m/d/Y'); ?>');
                $("#date-modal").modal('show');
            });

            $("#specificDate").on('submit', function(e){
                e.preventDefault();
                var ddMMyy = $("#dateD").val().split("/");
                var date = ddMMyy[1]+"-"+ddMMyy[0]+"-"+ddMMyy[2];
                location.href = "/feelings/date/" + date;
            })

            if(location.href.indexOf('me') != -1)
            {
                $('#v-pills-share-tab').addClass('active');
            }else if(location.href.indexOf('statistics') != -1)
            {
                $('#v-pills-stat-tab').addClass('active');
            }else if(location.href.indexOf('thanks') != -1)
            {
                $('#v-pills-thank-tab').addClass('active');
            }else
            {
                $('#v-pills-all-tab').addClass('active');
            }
            

            $(".lhome").css('color', 'black');
            $(".lnotes").css('color', '#bf1b2c');
            $(".lcharts").css('color', 'black'); 

            $(".like").on("click", function(){
                var count = $(this).data('count');
                count +=1;
                var id = $(this).attr('data-id');
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
                if(count == 0)
                    count = "";
                    txt = "";
                var id = $(this).attr('data-id');
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

            $("#sort").on('change', function(){
                location.href = $(this).val();
            });
            
            // $(".share-outside").on('click', async (e) => {
                
            //     let surl = $(this).attr('data-url');
            //     console.log(surl);
                
            //     let shareData = {
            //         title: 'FeelingSupport',
            //         text: "{{__('messages.share feel message')}}",
            //         url: surl
            //     }
                
            //     console.log(shareData);
                
            //     try {
            //         await navigator.share(shareData);
            //     } catch (err) {
            //         console.log(err);
            //     }
            // });
            
            $(".share-outside").on('click', function(){
               
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
@endsection