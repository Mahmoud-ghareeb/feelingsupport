@extends('layouts.site')

@section('title')
{{__('messages.Profile')}}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" style="margin-top: 30px;">
            <div class="card" style="border-radius: 39px;margin-top: 38px;">
                <div style="border-radius: 100px;height: 150px;width: 150px;position: relative;margin: auto;top: -60px;">
                    <img src="{{asset($user->picture)}}" style="padding: 5px;border-radius: 50%;" height="150" width="150">
                    
                </div>
                <div style="margin-top: -50px;">
                    <h4 class="center-element">{{$user->first_name}} {{$user->last_name}}</h4>
                    <h5 class="center-element" style="color:gray">{{$user->name}}@</h5>
                    <p class="center-element" style="margin-bottom: 0px;padding: 5px;text-align: center;">{{__('messages.share account')}}</p>
                    <div class="row likecommentshare" style="margin-top: -3px;margin-bottom: 10px;">
                        <div class="col-12">
                            <button style="border: none;background: none;" >
                                <i  class="fa-regular share-outside fa-share-from-square interact-icons" style="font-size: 17px;" data-id="allchartstate"></i><p>{{__('messages.share')}}</p>
                            </button>
                        </div>
                    </div>
                    <div class="center-element d-none">
                        <a href="https://twitter.com/intent/tweet?text=support+me+please%21%21&url={{route('feeling.user', Auth::user()->name)}}">
                            <i class="fa-brands fa-twitter interact-icons" style="color: black;font-size: large;margin: 10px;" title="share on twitter"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{route('feeling.user', Auth::user()->name)}}">
                            <i class="fa-brands fa-facebook interact-icons" style="color: black;font-size: large;margin: 10px;" title="share on facebook"></i>
                        </a>
                        <i class="fa-solid fa-clipboard interact-icons copy-link" data-link="{{route('feeling.user', Auth::user()->name)}}" style="color: black;font-size: large;margin: 10px;" title="copy link"></i>
                    </div>
                    @if (!preg_match("/fakefeelingsupport.com/i", $user->email))
                    <form action="{{route('update.email')}}" method="post" style="margin: 20px;">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{__('messages.Email Address')}}</label>
                            <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$user->email}}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary center-element">{{__('messages.Update Email')}}</button>
                    </form>
                    @endif
                    <form action="{{route('update.info')}}" method="post" style="margin: 20px;">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{__('messages.first_name')}}</label>
                            <input type="text" class="form-control" name="first_name" id="first_name" aria-describedby="first name" value="{{$user->first_name}}">
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">{{__('messages.last_name')}}</label>
                            <input type="text" class="form-control" name="last_name" id="last_name" aria-describedby="last name" value="{{$user->last_name}}">
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary center-element">{{__('messages.Update Info')}}</button>
                    </form>

                    <form action="{{route('update.password')}}" method="post" style="margin: 20px;">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputPasswor1">{{__('messages.Password')}}</label>
                            <input type="password" class="form-control" name="password" id="exampleInputPasswor1">
                        </div>
                        <button type="submit" class="btn btn-primary center-element">{{__('messages.Update Password')}}</button>
                    </form>

                    <form action="{{route('update.picture')}}" method="post" style="margin: 20px;" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group" style="margin-top: 20px;display: flex;">
                            <a href="javascript:void(0);" style="display:block;width:fit-content; height:30px;font-size: 15px;font-size: 13px;" onclick="document.getElementById('image').click()"><i class="fa-solid fa-image" style="margin: 0px 7px;font-size: 29px;"></i>{{__('messages.Choose an image')}}</a>
                            <input type="file" class="form-control" id="image" name="picture" placeholder="" style="display:none">
                            <img id="images" style="max-width: 80px;margin: 0px 20px;" />
                        </div>
                        <button type="submit" class="btn btn-primary center-element">{{__('messages.Update Profile Picture')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
       document.getElementById('image').onchange = function () {
          var src = URL.createObjectURL(this.files[0])
          document.getElementById('images').src = src
        } 
    });
    </script>
    <script>
        $(document).ready(function(){

            $(".share-outside").on('click', function(){
               
               var tx = '<?php echo route('feeling.user', auth()->user()->name) ?>'
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