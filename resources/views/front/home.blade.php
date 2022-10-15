@extends('layouts.site')

@section('title')
{{__('messages.Home')}}
@endsection

@section('content')
<?php use Illuminate\Support\Facades\Schema;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

 ?>
<div class="container">
    <div class="row justify-content-center" style="background: white;">
        <div class="col-md-8" style="padding: 20px;">
            <form method="POST" action="{{ route('feeling.store') }}" enctype="multipart/form-data">
                @csrf
                <p class="center-element" style="margin-bottom: 15px;">{{__('messages.how do you feel?')}} <span class="hint">{{__('messages.how do you feel hint')}}</span></p>
                <div class="emmo-div" style="position: relative;">
                    
                    <!-- <img src="{{ asset('assets/images/emotions/happy/amazing.svg') }}" alt=""> -->
                    <!-- style="min-width: 300px;overflow-x: auto;overflow-y: hidden;white-space: nowrap;" -->
                    <div>
                        <div class="emmo-div" style="position: relative;display: flex;">
                            @foreach($emojis as $key => $emoji)
                                <div class="emmo-group">
                                    <i class="fa-regular {{$emoji->css_class}} emmo-size emmo-select" data-id="{{$emoji->id}}" style="-webkit-text-stroke: 0.5px white;font-size: 38px;color: <?php echo $emoji->color ?>"></i>   
                                    <p class="emmo-text" style="color: <?php echo $emoji->color; ?>; margin-top: 7px;">
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
                                @if($key == 3)
                                    @break
                                @endif
                            @endforeach
                            <ul class="dropdown icon-dropdown" style="padding: 0px 0px 0px 0px;position: relative;">
                                <li style="list-style-type: none;"></li>
                                <a id="emojii" style="color: black; font-size: 19px;padding-left: 0px;<?php if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl'){ ?> padding-right: 10px; <?php }else{ ?> padding-right: 0px; <?php } ?>" class="nav-link dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i class="fa-solid fa-caret-down"></i></a>
                                <ul class="dropdown-menu top-dropdown lg-dropdown notification-dropdown" @if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl') style="width: 335px;position: absolute;left: -66px;" @else style="width: 335px;position: absolute;left: -240px;" @endif aria-labelledby="emojii" id="xemoji">
                                    <li>                                
                                        <div class="scrollDiv" style="height: 250px;overflow-y: auto;">
                                            <div class="notification-list d-emoji">
                                                @foreach($emojis as $key => $emoji)
                                                    @if($key > 3)
                                                        <div class="emmo-group clearfix">
                                                            <i class="fa-regular {{$emoji->css_class}} emmo-size emmo-select" data-id="{{$emoji->id}}" style="-webkit-text-stroke: 0.5px white; font-size: 38px; color: <?php echo $emoji->color ?>"></i>   
                                                            <p class="emmo-text" style="color: <?php echo $emoji->color; ?>; margin-top: 7px;">
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
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </ul>
                        </div>
                    </div>
                    <input type="hidden" name="feel_id" id="feel_id">
                    @error("feel_id")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group" style="margin-top: 10px;">
                    <textarea class="form-control" id="reason" name="reason" placeholder="{{__('messages.Type your feeling')}}" rows="6"></textarea>
                </div>
                <div class="form-group" style="margin-top: 20px;display: flex;">
                    <a href="javascript:void(0);" style="display:block;width:fit-content; height:30px;" onclick="document.getElementById('image').click()"><i class="fa-solid fa-image" style="margin: 0px 7px;font-size: 29px;"></i>{{__('messages.Choose an image')}}</a>
                    <input type="file" class="form-control" id="image" name="image" placeholder="" style="display:none">
                    <img id="images" style="max-width: 80px;margin: 0px 20px;" />
                </div>
                <div class="form-group center-element">
                    <input type="submit" class="btn btn-primary" name="submitbutton" style="margin-top: 20px;width: 140px;margin-right: 10px;" value="{{__('messages.save')}}">
                    <input type="submit" class="btn btn-primary" name="submitbutton" style="margin-top: 20px;width: 140px;margin-left: 10px;" value="{{__('messages.save and share')}}">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@error("feel_id")
<script>
    $(document).ready(function(){
        swal({text:"{{__('messages.Error : you must choose a feel')}}", button:"{{__('messages.ok')}}"});
    });
    
</script>
@enderror
<script>
    $(".lhome").css('color', '#bf1b2c');
    $(".lnotes").css('color', 'black');
    $(".lcharts").css('color', 'black'); 
    $(document).ready(function(){
       document.getElementById('image').onchange = function () {
          var src = URL.createObjectURL(this.files[0])
          document.getElementById('images').src = src
        } 
    });
</script>
@endsection