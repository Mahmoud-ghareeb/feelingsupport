@extends('layouts.site')

@section('title')
{{__('messages.Charts')}}
@endsection
@section('content')
<?php use Illuminate\Support\Facades\Schema;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

 ?>
<div class="row">
    <div class="col-md-12 dish-menu">
    <div class="nav nav-pills justify-content-center ftco-animate" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link" href="{{route('feeling.charts.daily')}}" id="v-pills-profile-tab" >{{__('messages.Daily Charts')}}</a> 
        <a class="nav-link" href="{{route('feeling.charts.egabi')}}" id="v-pills-home-tab" >{{__('messages.postive or negative')}}</a>
        <a class="nav-link" href="{{route('feeling.charts.compare')}}" id="v-pills-messages-tab" >{{__('messages.Compare Feeling')}}</a>  
        <a class="nav-link active" href="{{route('feeling.charts.emoji')}}" id="v-pills-home-tab" >{{__('messages.Specific Chart')}}</a>
        
    </div>
    </div>
</div>

<div class="container" style="margin-bottom: -20px;">
    <div class="row justify-content-center" style="background: white;margin-bottom:20px;border-radius:15px;margin-top: 0px;">
    <div class="emmo-div" style="position: relative;">
                    <p class="center-element" style="margin-bottom: 15px;margin-top: 10px;">{{__('messages.Choose an emoji')}}</p>

                    
                    <!-- <img src="{{ asset('assets/images/emotions/happy/amazing.svg') }}" alt=""> -->
                    <div>
                        <div class="emmo-div" style="position: relative;display: flex;">
                            @foreach($emojis as $key => $emoji)
                                <div class="emmo-group" >
                                    <i class="fa-regular {{$emoji->css_class}} emmo-size emmo-chart" data-id="{{$emoji->id}}" style="-webkit-text-stroke: 0.5px white;color: <?php echo $emoji->color ?>"></i>   
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
                                        <div style="width: 100%;margin-bottom: 13px;">
                                            <input type="text" class="form-control" id="search-emojis" placeholder="{{__('messages.Search in emojis')}}">
                                        </div>                    
                                        <div class="scrollDiv" style="height: 250px;overflow-y: auto;">
                                            <div class="notification-list d-emoji" id="put-search-data">
                                                @foreach($emojis as $key => $emoji)
                                                    @if($key > 3)
                                                        <div class="emmo-group clearfix">
                                                            <i class="fa-regular {{$emoji->css_class}} emmo-size emmo-chart" data-id="{{$emoji->id}}" style="-webkit-text-stroke: 0.5px white;color: <?php echo $emoji->color ?>"></i>   
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
                    
                    <input type="hidden" name="feel_id" id="feel_id" value="1">
                    @error("feel_id")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
        <form style="margin-bottom: 20px; margin-top: 10px;" id="change-date">
            <div class="row form-group justify-content-center">
                <label for="date" class="col-sm-1 col-form-label" style="width: fit-content;margin-top: 22px;">{{__('messages.Choose Date')}}</label>
                <div class="col-sm-4">
                    <label class="center-element" for="datepickerstart">{{__('messages.From')}}</label>
                    <div class="input-group date" id="datepickerstart">
                        <input type="text" class="form-control" id="dateChartstart">
                        <span class="input-group-append">
                            <span class="input-group-text bg-white d-block">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="col-sm-4">
                <label class="center-element" for="datepickerstart">{{__('messages.To')}}</label>
                    <div class="input-group date" id="datepickerend">
                        <input type="text" class="form-control" id="dateChartend">
                        <span class="input-group-append">
                            <span class="input-group-text bg-white d-block">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </form>
        
        <div class="row likecommentshare d-none" style="margin-top: 21px;">
            <div class="col-12">
                <button style="border: none;background: none;" >
                    <i  class="fa-regular share-image fa-share-from-square interact-icons" data-id="chartt"></i><p>{{__('messages.share')}}</p>
                </button>
            </div>
        </div>
        <div class="col-md-8" >
            <div id = "allchartstate">
                <p style="width: fit-content;margin: 0px auto 13px;font-size: large;">{{__('messages.special statistic from')}} <span id="emoji_name"></span> {{__('messages.From')}} <span id="first_span"></span> {{__('messages.to')}} <span id="second_span"></span> </p>
                <table class="table table-striped d-none" id="chartt" style="width: 50vw;margin: 0px auto 17px;">
                    <tbody>
                        <tr>
                            <td>{{__('messages.Total Feeling')}}</td>
                            <td id="tot"></td>
                        </tr>
                        <tr>
                            <td>{{__('messages.General Mood')}}</td>
                            <td id="gen"></td>
                        </tr>
                    </tbody>
                </table>
                <div id="emoji_statistic"></div>
            </div>
            <div class="row likecommentshare" style="margin-top: -11px;margin-bottom: 10px;">
                <div class="col-12">
                    <button style="border: none;background: none;" >
                        <i  class="fa-regular share-image fa-share-from-square interact-icons" style="font-size: 17px;" data-id="allchartstate"></i><p>{{__('messages.share')}}</p>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div id="chart" style=" display:none"></div>
            
        </div>
    </div>
</div>
<input type="hidden" name="lang" value="<?php echo app()->getLocale() ?>">
@endsection
@section('scripts')

    <script src="https://unpkg.com/echarts/dist/echarts.min.js"></script>
    <!-- Chartisan -->
    <script src="https://unpkg.com/@chartisan/echarts/dist/chartisan_echarts.js"></script>
    <script>
        $(document).ready(function(){

            $(".lhome").css('color', 'black');
            $(".lnotes").css('color', 'black');
            $(".lcharts").css('color', '#bf1b2c'); 

            $('#datepickerstart, #datepickerend').datepicker({
                    language: '{{app()->getLocale()}}',
                    autoHide: true,
                    endDate: new Date()
                });
            $("#dateChartstart, #dateChartend").val('<?php echo date('m/d/Y'); ?>');
            $("#first_span, #second_span").html('<?php echo date('m/d/Y'); ?>');
            var datestart = $("#dateChartstart").val();
            var dateend   = $("#dateChartend").val();
            var whichEmmo = $("#feel_id").val();
            
            const chart = new Chartisan({
                el: '#chart',
                url: "@chart('emoji_chart')?startdate=" + datestart + "&enddate=" + dateend + "&emoji_id=" + whichEmmo + "&lang=<?php echo app()->getLocale() ?>",
                hooks: new ChartisanHooks()
                    .datasets('bar')
                    .tooltip(true)
                    .colors(['#15bda6', '#15e115', '#07b0f1', 'orange', 'red'])
                    .custom(({ data, merge, server }) => {
                        console.log(server);
                        $("#tot").html(server.chart.extra['total']);
                        var html = "";
                        var good = 0;
                        var bad  = 0;
                        for (const x of server.chart.extra.data) {
                            console.log(x);
                            var percent = isNaN(Math.round((x['count'] / server.chart.extra['total']) * 100)) ? '0' : Math.round((x['count'] / server.chart.extra['total']) * 100);
                            if(x['category'] == "positive"){
                                good += x['count'];
                            }else{
                                bad += x['count'];
                            }
                            <?php 
                                $la = app()->getLocale();
                                $type = "type_" . $la;
                            ?>
                            var typpe = "";
                            if("<?php echo $type ?>" in x){
                                typpe = "<?php echo $type ?>";
                                if(!x[typpe])
                                    typpe = "type_en"
                            }else{
                                typpe = "type_en";
                            }
                            html += `<div class="emmo-group" style="width: auto;">
                                        <div style="position:relative">
                                            <i class="fa-solid ${x['class']} emmo-size emmo-select" style="-webkit-text-stroke: 0.5px white;font-size: 50px;color: ${x['color']}"></i>
                                            <p class="emmo-text" style="color: ${x['color']}; margin-top: -7px;"><?php 
                                                if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
                                                { ?>
                                                    %${x[typpe]} ${percent}
                                                <?php }else{ ?>
                                                    ${x[typpe]} ${percent}%
                                                <?php }  ?>
                                            </p>
                                            <div class="progress emmo-progress" style="border-radius: unset;">
                                                <div class="progress-bar" style="background: ${x['color']}; width: ${percent}%" role="progressbar" aria-valuenow="${x['count']}" aria-valuemin="0" aria-valuemax="${server.chart.extra['total']}"></div>
                                            </div>
                                            <div class="emmo-count" style="color: ${x['color']}">
                                                ${x['count']}
                                            </div>
                                        </div>
                                    </div>`;
                                    $("#emoji_name").html(x[typpe]);
                        };
                        var gene = (good >= bad ? 'good' : 'bad'); 
                        $("#gen").html(gene);
                        $("#emoji_statistic").html(html);
                        
                    return data;
                    }),
                
            });
            

            $(".emmo-chart").on('click', function() {
                $(".emmo-chart").removeClass('fa-solid');
                $(".emmo-chart").addClass('fa-regular');
                $(this).addClass('fa-solid');
                $(this).removeClass('fa-regular');
                var ids = "";
                ids = $(this).attr('data-id');
                $("#feel_id").val(ids);
                var datestart = $("#dateChartstart").val();
                var dateend   = $("#dateChartend").val();
                var whichEmmo = $("#feel_id").val();
                $("#first_span").html(datestart);
                $("#second_span").html(dateend);
                
                
                chart.update({
                    url: "@chart('emoji_chart')?startdate=" + datestart + "&enddate=" + dateend + "&emoji_id=" + whichEmmo + "&lang=<?php echo app()->getLocale() ?>",
                    });
            });

            $("#datepickerstart, #datepickerend").on('change', function(){
                $(".datepicker").css('display', 'none');
                var datestart = $("#dateChartstart").val();
                var dateend   = $("#dateChartend").val();
                var whichEmmo = $("#feel_id").val();
                $("#first_span").html(datestart);
                $("#second_span").html(dateend);
                chart.update({
                    url: "@chart('emoji_chart')?startdate=" + datestart + "&enddate=" + dateend + "&emoji_id=" + whichEmmo + "&lang=<?php echo app()->getLocale() ?>",
                    });
            });
            
        });
    </script>
    <!-- // shareeee -->
    <script>
        $(document).ready(function(){
            $(".share-image").on('click', function () {
                
                //$(this).parent().css('display', 'none');
                var i_id = $(this).attr('data-id');
                
                $("#share-modal").modal('show');
                
            });
            $("#share-action").on('submit', function(e){
                e.preventDefault();
                $("#share-modal").modal('hide');
                html2canvas(document.getElementById('allchartstate')).then(function (canvas) {
                    var text = $("#commentShare").val();
                    var dataUrl = canvas.toDataURL();
                    var imagedata = dataUrl.replace(/^data:image\/(png|jpg);base64,/,"");
                    var datestart = $("#dateChartstart").val();
                    var dateend   = $("#dateChartend").val();
                    $.ajax({
                            
                        type:"POST",
                        url: "{{route('chart.image')}}",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            "imagedata":imagedata,
                            "datestart": datestart,
                            "reason": text,
                            "dateend": dateend
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
            $("#search-emojis").on('keyup', () => {

                let query = $("#search-emojis").val();
                $.ajax({
                    type:"GET",
                    url:'/search-emojis',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        "s": query
                    },
                    success: function(data){
                        let html = '';
                        for (const x of data) {
                            console.log(x);
                            html += `
                            
                                <div class="emmo-group clearfix">
                                    <i class="fa-regular ${x['css_class']} emmo-size emmo-chart" data-id="${x['id']}" style="-webkit-text-stroke: 0.5px white; font-size: 38px; color: ${x['color']}"></i>   
                                    <p class="emmo-text" style="color: ${x['color']}; margin-top: 7px;">
                                    ${x['type_<?php echo app()->getLocale(); ?>']}
                                    </p>
                                </div>
                            
                            `;
                        }
                        $("#put-search-data").html(html);

                        var datestart = $("#dateChartstart").val();
                        var dateend   = $("#dateChartend").val();
                        var whichEmmo = $("#feel_id").val();

                        const chart = new Chartisan({
                el: '#chart',
                url: "@chart('emoji_chart')?startdate=" + datestart + "&enddate=" + dateend + "&emoji_id=" + whichEmmo + "&lang=<?php echo app()->getLocale() ?>",
                hooks: new ChartisanHooks()
                    .datasets('bar')
                    .tooltip(true)
                    .colors(['#15bda6', '#15e115', '#07b0f1', 'orange', 'red'])
                    .custom(({ data, merge, server }) => {
                        console.log(server);
                        $("#tot").html(server.chart.extra['total']);
                        var html = "";
                        var good = 0;
                        var bad  = 0;
                        for (const x of server.chart.extra.data) {
                            console.log(x);
                            var percent = isNaN(Math.round((x['count'] / server.chart.extra['total']) * 100)) ? '0' : Math.round((x['count'] / server.chart.extra['total']) * 100);
                            if(x['category'] == "positive"){
                                good += x['count'];
                            }else{
                                bad += x['count'];
                            }
                            <?php 
                                $la = app()->getLocale();
                                $type = "type_" . $la;
                            ?>
                            var typpe = "";
                            if("<?php echo $type ?>" in x){
                                typpe = "<?php echo $type ?>";
                                if(!x[typpe])
                                    typpe = "type_en"
                            }else{
                                typpe = "type_en";
                            }
                            html += `<div class="emmo-group" style="width: auto;">
                                        <div style="position:relative">
                                            <i class="fa-solid ${x['class']} emmo-size emmo-select" style="-webkit-text-stroke: 0.5px white;font-size: 50px;color: ${x['color']}"></i>
                                            <p class="emmo-text" style="color: ${x['color']}; margin-top: -7px;"><?php 
                                                if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl')
                                                { ?>
                                                    %${x[typpe]} ${percent}
                                                <?php }else{ ?>
                                                    ${x[typpe]} ${percent}%
                                                <?php }  ?>
                                            </p>
                                            <div class="progress emmo-progress" style="border-radius: unset;">
                                                <div class="progress-bar" style="background: ${x['color']}; width: ${percent}%" role="progressbar" aria-valuenow="${x['count']}" aria-valuemin="0" aria-valuemax="${server.chart.extra['total']}"></div>
                                            </div>
                                            <div class="emmo-count" style="color: ${x['color']}">
                                                ${x['count']}
                                            </div>
                                        </div>
                                    </div>`;
                                    $("#emoji_name").html(x[typpe]);
                        };
                        var gene = (good >= bad ? 'good' : 'bad'); 
                        $("#gen").html(gene);
                        $("#emoji_statistic").html(html);
                        
                    return data;
                    }),
                
            });

                        $(".emmo-chart").on('click', function() {
                            $(".emmo-chart").removeClass('fa-solid');
                            $(".emmo-chart").addClass('fa-regular');
                            $(this).addClass('fa-solid');
                            $(this).removeClass('fa-regular');
                            var ids = "";
                            ids = $(this).attr('data-id');
                            $("#feel_id").val(ids);
                            var datestart = $("#dateChartstart").val();
                            var dateend   = $("#dateChartend").val();
                            var whichEmmo = $("#feel_id").val();
                            $("#first_span").html(datestart);
                            $("#second_span").html(dateend);
                            
                            
                            chart.update({
                                url: "@chart('emoji_chart')?startdate=" + datestart + "&enddate=" + dateend + "&emoji_id=" + whichEmmo + "&lang=<?php echo app()->getLocale() ?>",
                                });
                        });
                    },
                    error: function(err){
                        console.log(err);
                    }
                });

                });
            });
    </script>
@endsection