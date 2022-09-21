@extends('layouts.site')

@section('title')
{{__('messages.Charts')}}
@endsection
@section('content')
<?php

//use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

 ?>
<div class="row">
    <div class="col-md-12 dish-menu">
    <div class="nav nav-pills justify-content-center ftco-animate" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link active" href="{{route('feeling.charts.daily')}}" id="v-pills-profile-tab" >{{__('messages.Daily Charts')}}</a> 
        <a class="nav-link" href="{{route('feeling.charts.egabi')}}" id="v-pills-home-tab" >{{__('messages.postive or negative')}}</a>
        <a class="nav-link" href="{{route('feeling.charts.compare')}}" id="v-pills-messages-tab" >{{__('messages.Compare Feeling')}}</a>  
        <a class="nav-link" href="{{route('feeling.charts.emoji')}}" id="v-pills-home-tab" >{{__('messages.Specific Chart')}}</a>
    </div>
    </div>
</div>

<div class="container" style="margin-bottom: -20px;">
    <div class="row justify-content-center" style="background: white;margin-bottom:20px;border-radius:15px;margin-top: 0px;">
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
        
        <div class="row likecommentshare d-none" style="margin-top: 21px;margin-bottom: 21px;">
            <div class="col-12">
                <button style="border: none;background: none;" >
                    <i  class="fa-regular share-image fa-share-from-square interact-icons" data-id="chartt"></i><p>{{__('messages.share')}}</p>
                </button>
            </div>
        </div>
        <div class="col-md-8" style="" id="chart1">
            <div id = "allchartstate">
                <p style="width: fit-content;margin: 0px auto 13px;font-size: large;">{{__('messages.statistic from')}} <span id="first_span"></span> {{__('messages.to')}} <span id="second_span"></span> </p>
                <table class="table table-striped" id="chartt" style="width: 50vw;margin: 0px auto 17px;">
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
            
            <div class="row likecommentshare" style="margin-top: 21px;">
                <div class="col-12">
                    <button style="border: none;background: none;" >
                        <i  class="fa-regular share-image fa-share-from-square interact-icons" data-id="allchartstate"></i><p>{{__('messages.share')}}</p>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-8" id="chart2" style="display:none">
            <div id="chart" style="height: 400px;"></div>
            <div class="row likecommentshare" style="margin-top: 21px;">
                <div class="col-12">
                    <button style="border: none;background: none;" >
                        <i  class="fa-regular share-image fa-share-from-square interact-icons" data-id="chart2"></i><p>{{__('messages.share')}}</p>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-8" id="chart3" style="display:none">
            <div id="chartpie" style="height: 400px;"></div>
            <div class="row likecommentshare" style="margin-top: 21px;">
                <div class="col-12">
                    <button style="border: none;background: none;" >
                        <i  class="fa-regular share-image fa-share-from-square interact-icons" data-id="chart3"></i><p>{{__('messages.share')}}</p>
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

            $('#datepickerstart, #datepickerend').datepicker({
                    language: '{{app()->getLocale()}}',
                    autoHide: true,
                    endDate: new Date()
                });
            $("#dateChartstart, #dateChartend").val('<?php echo date('m/d/Y'); ?>');
            <?php 
            //                                         $date = date('Y-m-d H:i:s');
            //                                         $newDateFormat = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date);
            //                                         echo Timezone::convertToLocal($newDateFormat); 
                                                 ?>
            $("#first_span, #second_span").html('<?php echo date('m/d/Y'); ?>');
            var datestart = $("#dateChartstart").val();
            var dateend   = $("#dateChartend").val();
            var hooks = new ChartisanHooks();
            hooks.datasets('pie');
            hooks.tooltip(true);
            hooks.colors(['#15bda6', '#15e115', '#07b0f1', 'orange', 'red']);

            var ooks2 = new ChartisanHooks();
            ooks2.datasets('bar');
            ooks2.tooltip(true);
            
            const chart = new Chartisan({
                el: '#chart',
                url: "@chart('daily_chart')?startdate=" + datestart + "&enddate=" + dateend + "&lang=<?php echo app()->getLocale() ?>",
                hooks: new ChartisanHooks()
                    .datasets('bar')
                    .tooltip(true)
                    .colors(['#15bda6', '#15e115', '#07b0f1', 'orange', 'red'])
                    .custom(({ data, merge, server }) => {
                        $("#tot").html(server.chart.extra['total']);
                        var html = "";
                        var good = 0;
                        var bad  = 0;
                        for (const x of server.chart.extra.data) {
                            var percent = (x['count'] / server.chart.extra['total']) * 100;
                            percent = isNaN(percent) ? 0 : Math.round(percent);
                            if(x['category'] == "positive"){
                                good += x['count'];
                            }else if(x['category'] == "negative"){
                                bad += x['count'];
                            }
                            <?php 
                                $la = app()->getLocale();
                                $type = "type_" . $la;
                            ?>
                            //console.log(x);
                            var typpe = "";
                            if("<?php echo $type ?>" in x){
                                typpe = "<?php echo $type ?>";
                                if(!x[typpe])
                                    typpe = "type_en"
                            }else{
                                typpe = "type_en";
                            }
                            if(x['count'] > 0){
                                html += `<div class="emmo-group" style="width: auto;">
                                            <div style="position:relative">
                                                <i class="fa-solid ${x['class']} emmo-size emmo-select" style="-webkit-text-stroke: 0.5px white;font-size: 50px;color: ${x['color']}"></i>
                                                <p class="emmo-text" style="color: ${x['color']}; margin-top: -7px;">
                                                    <?php
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
                            }
                        }
                        var gene = (good >= bad ? "{{__('messages.good')}}" : "{{__('messages.bad')}}"); 
                        if(good == 0 && bad == 0) gene = "";
                        $("#gen").html(gene);
                        if(html != "")
                            $("#emoji_statistic").html(html);
                        else
                            $("#emoji_statistic").html("<p style='margin: 0px auto;width: fit-content;font-size: large;'>{{__('messages.there is no statistic for that day')}}</p>");
                    return data;
                    }),
                
            });
            const chartpie = new Chartisan({
                el: '#chartpie',
                url: "@chart('daily_chart')?startdate=" + datestart + "&enddate=" + dateend + "&lang=<?php echo app()->getLocale() ?>",
                hooks: new ChartisanHooks()
                    .datasets('pie')
                    .tooltip(true)
                    .colors(['#15bda6', '#15e115', '#07b0f1', 'orange', 'red']),
            });

            $("#datepickerstart, #datepickerend").on('change', function(){
                $(".datepicker").css('display', 'none');
                var datestart = $("#dateChartstart").val();
                var dateend   = $("#dateChartend").val();
                $("#first_span").html(datestart);
                $("#second_span").html(dateend);
                chart.update({
                    url: "@chart('daily_chart')?startdate=" + datestart + "&enddate=" + dateend + "&lang=<?php echo app()->getLocale() ?>",
                    });
                chartpie.update({
                    url: "@chart('daily_chart')?startdate=" + datestart + "&enddate=" + dateend + "&lang=<?php echo app()->getLocale() ?>",
                    });
            });
            
        });
    </script>
    <!-- // shareeee -->
    <script>
        $(document).ready(function(){
            var i_id = 0;
            $(".share-image").on('click', function () {
                
               // $(this).parent().css('display', 'none');
                i_id = $(this).attr('data-id');
                $("#share-modal").modal('show');
                
            });
            $("#share-action").on('submit', function(e){
                e.preventDefault();
                $("#share-modal").modal('hide');
                html2canvas(document.getElementById(i_id)).then(function (canvas) {
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

