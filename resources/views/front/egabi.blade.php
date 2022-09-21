@extends('layouts.site')

@section('title')
{{__('messages.Charts')}}
@endsection
@section('content')

<div class="row">
    <div class="col-md-12 dish-menu">
    <div class="nav nav-pills justify-content-center ftco-animate" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link" href="{{route('feeling.charts.daily')}}" id="v-pills-profile-tab" >{{__('messages.Daily Charts')}}</a> 
        <a class="nav-link active" href="{{route('feeling.charts.egabi')}}" id="v-pills-home-tab" >{{__('messages.postive or negative')}}</a>
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
        <div class="col-md-8">
            <div id="statuschart">
                <p style="width: fit-content;margin: 0px auto -28px;font-size: large;">{{__('messages.status statistic from')}} <span id="first_span"></span> {{__('messages.to')}} <span id="second_span"></span> </p>
                <div id="chart" style="height: 400px;"></div>
                <div class="row justify-content-center" style="background: white; margin-bottom: 20px; border-radius: 15px; margin-top: 0px;">
                    <table class="table table-striped" id="chartt" style="width: 50vw;margin-top: -20px;">
                        <tbody id="bodyTT">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row likecommentshare" style="margin-top: 21px;">
                <div class="col-12">
                    <button style="border: none;background: none;" >
                        <i  class="fa-regular share-image fa-share-from-square interact-icons" data-id="statuschart"></i><p>{{__('messages.share')}}</p>
                    </button>
                </div>
            </div>
            
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
            
            const chart = new Chartisan({
                el: '#chart',
                url: "@chart('egabi_chart')?startdate=" + datestart + "&enddate=" + dateend + "&lang=<?php echo app()->getLocale() ?>",
                hooks: new ChartisanHooks()
                    .datasets('pie')
                    .axis(false)
                    .tooltip(true)
                    .custom(({ data, merge, server }) => {
                        //$("#tot").html(server.chart.extra['total']);
                        var per1 = Math.round((data.series[0].data[0].value / (data.series[0].data[0].value + data.series[0].data[1].value)) * 100);
                        var per2 = Math.round((data.series[0].data[1].value / (data.series[0].data[0].value + data.series[0].data[1].value)) * 100);
                        var html = `<tr>
                                        <td style="background-color:#15e115;color:white !important;text-align: center;">${data.series[0].data[0].name}</td>
                                        <td style="background-color:#4b4f4f;color:white;text-align: center;">${data.series[0].data[1].name}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color:#15e115;color:white !important;text-align: center;">${isNaN(per1) ? 0 : per1} %</td>
                                        <td style="background-color:#4b4f4f;color:white;text-align: center;">${isNaN(per2) ? 0 : per2} %</td>
                                    </tr>`;
                        var good = 0;
                        var bad  = 0;
                        //console.log(data);
                        // for (const x of server.chart.extra.data) {
                        //     var percent = (x['count'] / server.chart.extra['total']) * 100;
                        //     if(x['category'] == "positive"){
                        //         good += x['count'];
                        //     }else{
                        //         bad += x['count'];
                        //     }
                        //     if(x['count'] > 0){
                        //         html += `<tr>
                        //                     <td></td>
                        //                     <td id="tot"></td>
                        //                 </tr>
                        //                 <tr>
                        //                     <td>{{__('messages.General Mood')}}</td>
                        //                     <td id="gen"></td>
                        //                 </tr>`;
                        //     }
                        // }
                        // var gene = (good >= bad ? 'good' : 'bad'); 
                        // $("#gen").html(gene);
                        $("#bodyTT").html(html);
                    return data;
                    })
                    .colors(['#15e115', '#4b4f4f', '#07b0f1', 'orange', 'red'])                
            });
            
        // .custom(({ data }) => ({
        //               ...data,
        //               series: data.series.map((serie) => ({
        //                 ...serie,
        //                 label: { show: true, formatter: (value, ctx) => {
    
        //                         let name = value.name;
        //                         let percentage = value.percent + "%";
        //                         console.log(value);
        //                         return name + " " + percentage;
        //                     } },
        //               })),
        //             }))

            $("#datepickerstart, #datepickerend").on('change', function(){
                $(".datepicker").css('display', 'none');
                var datestart = $("#dateChartstart").val();
                var dateend   = $("#dateChartend").val();
                $("#first_span").html(datestart);
                $("#second_span").html(dateend);
                chart.update({
                    url: "@chart('egabi_chart')?startdate=" + datestart + "&enddate=" + dateend + "&lang=<?php echo app()->getLocale() ?>",
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
                    html2canvas(document.getElementById('statuschart')).then(function (canvas) {
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