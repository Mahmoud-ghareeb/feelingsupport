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
        <a class="nav-link active" href="{{route('feeling.charts.compare')}}" id="v-pills-messages-tab" >{{__('messages.Compare Feeling')}}</a>  
        <a class="nav-link" href="{{route('feeling.charts.emoji')}}" id="v-pills-home-tab" >{{__('messages.Specific Chart')}}</a>
    </div>
    </div>
</div>

<div class="container" style="margin-bottom: -20px;">
    <div class="row justify-content-center" style="background: white;margin-bottom:20px;border-radius:15px;margin-top: 0px;">
        <p class="" style="margin-bottom: 15px;text-align: center;word-break: break-word;margin-top: 10px;">{{__('messages.Choose muliple emojis?')}}</p>
        <div class="emmo-div" style="position: relative;">
            <!-- <img src="{{ asset('assets/images/emotions/happy/amazing.svg') }}" alt=""> -->
            <!-- style="min-width: 300px;overflow-x: auto;overflow-y: hidden;white-space: nowrap;" -->
            <div>
                <div class="emmo-div" style="position: relative;display: flex;">
                    @foreach($emojis as $key => $emoji)
                        <div class="emmo-group">
                            <i class="fa-regular {{$emoji->css_class}} emmo-size emmo-select emmo-alter" data-id="{{$emoji->id}}" style="-webkit-text-stroke: 0.5px white;color: <?php echo $emoji->color ?>"></i>   
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
                        <ul class="dropdown-menu top-dropdown lg-dropdown notification-dropdown" @if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl') style="width: 324px;position: absolute;left: -66px;" @else style="width: 324px;position: absolute;left: -240px;" @endif aria-labelledby="emojii" id="xemoji">
                            <li>                                
                                <div class="scrollDiv" style="height: 250px;overflow-y: auto;">
                                    <div class="notification-list d-emoji">
                                        @foreach($emojis as $key => $emoji)
                                            @if($key > 3)
                                                <div class="emmo-group clearfix">
                                                    <i class="fa-regular {{$emoji->css_class}} emmo-size emmo-select" data-id="{{$emoji->id}}" style="-webkit-text-stroke: 0.5px white;color: <?php echo $emoji->color ?>"></i>   
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
        <form style="margin-bottom: 20px; margin-top: 10px;" id="change-date-start">
            <div class="row form-group justify-content-center">
                
                <label for="date" class="col-sm-1 col-form-label" style="width: fit-content;margin-top: 22px;">{{__('messages.Start Date')}}</label>
                <div class="col-sm-4">
                    <label class="center-element" for="startdatepickerstart">{{__('messages.From')}}</label>
                    <div class="input-group date" id="startdatepickerstart">
                        <input type="text" class="form-control" id="startdateChartstart">
                        <span class="input-group-append">
                            <span class="input-group-text bg-white d-block">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="col-sm-4">
                <label class="center-element" for="startdatepickerstart">{{__('messages.To')}}</label>
                    <div class="input-group date" id="startdatepickerend">
                        <input type="text" class="form-control" id="startdateChartend">
                        <span class="input-group-append">
                            <span class="input-group-text bg-white d-block">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </form>

        <form style="margin-bottom: 20px; margin-top: 10px;" id="change-date-end">
            <div class="row form-group justify-content-center">
                <label for="date" class="col-sm-1 col-form-label" style="width: fit-content;margin-top: 22px;">{{__('messages.End Date')}}</label>
                <div class="col-sm-4">
                    <label class="center-element" for="enddatepickerstart">{{__('messages.From')}}</label>
                    <div class="input-group date" id="enddatepickerstart">
                        <input type="text" class="form-control" id="enddateChartstart">
                        <span class="input-group-append">
                            <span class="input-group-text bg-white d-block">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label class="center-element" for="enddatepickerend">{{__('messages.To')}}</label>
                    <div class="input-group date" id="enddatepickerend">
                        <input type="text" class="form-control" id="enddateChartend">
                        <span class="input-group-append">
                            <span class="input-group-text bg-white d-block">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="center-element">
                <button type="submit" class="btn btn-primary" id="ok" style="width: 150px;margin-top: 30px;">{{__('messages.Submit')}}</button>
            </div>
        </form>
        <!-- <table class="table table-striped" style="width: 50vw;margin-top: 40px;">
            <tbody>
                <tr>
                    <td>Total Feeling</td>
                    <td id="tot"></td>
                </tr>
                <tr>
                    <td>General Mood</td>
                    <td id="gen"></td>
                </tr>
            </tbody>
        </table>
        <div class="col-md-8" style="height: 400px;">
            <div id="emoji_statistic" style="margin-top: 70px;"></div>
        </div> -->
        <div class="col-md-8">
            <div id="allchart">
                <p style="width: fit-content;margin: 0px auto -35px;font-size: large;text-align: center;">{{__('messages.comparative statistics')}} {{__('messages.first period')}} <span id="first_fir_span"></span> {{__('messages.to')}} <span id="second_fir_span"></span> {{__('messages.second period')}} <span id="first_sec_span"></span> {{__('messages.to')}} <span id="second_sec_span"></span> </p>
                <div id="chart" style="height: 400px;"></div>
            </div>
            
            <div class="row likecommentshare" style="margin-top: -41px;margin-bottom: 10px;">
                <div class="col-12">
                    <button style="border: none;background: none;" >
                        <i  class="fa-regular share-image fa-share-from-square interact-icons" style="font-size: 17px;" data-id="allchart"></i><p>{{__('messages.share')}}</p>
                    </button>
                </div>
            </div>
        </div>
        
    </div>
</div>
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

            $('#startdatepickerstart, #startdatepickerend').datepicker({
                    language: '{{app()->getLocale()}}',
                    autoHide: true,
                    endDate: new Date()
                });
            $('#enddatepickerstart, #enddatepickerend').datepicker({
                    language: '{{app()->getLocale()}}',
                    autoHide: true,
                    endDate: new Date()
                });
            
            $("#startdateChartstart, #startdateChartend, #enddateChartstart, #enddateChartend").val('<?php echo date('m/d/Y'); ?>');
            $("#first_fir_span, #second_fir_span, #first_sec_span, #second_sec_span").html('<?php echo date('m/d/Y'); ?>');
            var startdatestart = $("#startdateChartstart").val();
            var startdateend   = $("#startdateChartend").val();
            var enddatestart   = $("#enddateChartstart").val();
            var enddateend     = $("#enddateChartend").val();
            var ids            = $("#feel_id").val();
            
            var hooks = new ChartisanHooks();
            hooks.datasets('pie');
            hooks.tooltip(true);
            hooks.colors(['#15bda6', '#15e115', '#07b0f1', 'orange', 'red']);

            var ooks2 = new ChartisanHooks();
            ooks2.datasets('bar');
            ooks2.tooltip(true);
            
            const chart = new Chartisan({
                el: '#chart',
                url: "@chart('compare_chart')?startdatestart=" + startdatestart + "&startdateend=" + startdateend + "&enddatestart=" + enddatestart + "&enddateend=" + enddateend + "&lang=<?php echo app()->getLocale() ?>" + "&ids=" + ids,
                hooks: new ChartisanHooks()
                    .datasets('bar')
                    .tooltip(true)
                    .colors(['#15bda6', '#15e115', '#07b0f1', 'orange', 'red'])
                    .custom(({ data, merge, server }) => {
                        // $("#tot").html(server.chart.extra['total']);
                        // var html = "";
                        // var good = 0;
                        // var bad  = 0;
                        // for (const x of server.chart.extra.data) {
                        //     var percent = (x['count'] / server.chart.extra['total']) * 100;
                        //     if(x['category'] == "positive"){
                        //         good += x['count'];
                        //     }else{
                        //         bad += x['count'];
                        //     }
                        //     html += `<div class="emmo-group">
                        //                 <div style="position:relative">
                        //                     <i class="fa-solid ${x['class']} emmo-size emmo-select" style="-webkit-text-stroke: 0.5px white;color: ${x['color']}"></i>
                        //                     <div class="progress emmo-progress" style="border-radius: unset;">
                        //                         <div class="progress-bar" style="background: ${x['color']}; width: ${percent}%" role="progressbar" aria-valuenow="${x['count']}" aria-valuemin="0" aria-valuemax="${server.chart.extra['total']}"></div>
                        //                     </div>
                        //                     <div class="emmo-count" style="color: ${x['color']}">
                        //                         ${x['count']}
                        //                     </div>
                        //                 </div>
                        //             </div>`;
                        // };
                        // var gene = (good >= bad ? 'good' : 'bad'); 
                        // $("#gen").html(gene);
                        // $("#emoji_statistic").html(html);
                    return data;
                    }),
                
            });
            // const chartpie = new Chartisan({
            //     el: '#chartpie',
            //     url: "@chart('compare_chart')?startdate=" + datestart + "&enddate=" + dateend,
            //     hooks: new ChartisanHooks()
            //         .datasets('pie')
            //         .tooltip(true)
            //         .colors(['#15bda6', '#15e115', '#07b0f1', 'orange', 'red']),
            // });

            // $("#startdatepickerstart, #startdatepickerend, #enddatepickerstart, #enddatepickerend").on('change', function(){
                
            //     $(".datepicker").css('display', 'none');
            //     var startdatestart = $("#startdateChartstart").val();
            //     var startdateend   = $("#startdateChartend").val();
            //     var enddatestart   = $("#enddateChartstart").val();
            //     var enddateend     = $("#enddateChartend").val();
            //     var ids            = $("#feel_id").val();
            //     chart.update({
            //         url: "@chart('compare_chart')?startdatestart=" + startdatestart + "&startdateend=" + startdateend + "&enddatestart=" + enddatestart + "&enddateend=" + enddateend + "&lang=<?php echo app()->getLocale() ?>" + "&ids=" + ids,
            //         });
            // });

            $("#ok").on('click', function(e) {
                e.preventDefault();

                var startdatestart = $("#startdateChartstart").val();
                var startdateend   = $("#startdateChartend").val();
                var enddatestart   = $("#enddateChartstart").val();
                var enddateend     = $("#enddateChartend").val();
                var ids            = $("#feel_id").val();
                $("#first_fir_span").html(startdatestart);
                $("#second_fir_span").html(startdateend);
                $("#first_sec_span").html(enddatestart);
                $("#second_sec_span").html(enddateend);
                chart.update({
                    url: "@chart('compare_chart')?startdatestart=" + startdatestart + "&startdateend=" + startdateend + "&enddatestart=" + enddatestart + "&enddateend=" + enddateend + "&lang=<?php echo app()->getLocale() ?>" + "&ids=" + ids,
                    });
            });
            
        });
    </script>
    <!-- shareeee -->
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
                html2canvas(document.getElementById('allchart')).then(function (canvas) {
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
        });
    </script>
@endsection