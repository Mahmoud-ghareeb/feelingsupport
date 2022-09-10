<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <title>{{ config('app.name', 'FeelingSupport') }}</title>
    <link rel="shortcut icon" href="{{asset('assets/images/dislike.png')}}" type="image/x-icon">
    
    <!-- all the meta tags -->
    @include ('admin.metas')
    <!-- all the css files -->
    @include ('admin.includes_top')
</head>
<body data-layout="detached">
    <!-- HEADER -->
    @include ('admin.header');
    <div class="container-fluid">
        <div class="wrapper">
            <!-- BEGIN CONTENT -->
            <!-- SIDEBAR -->
            @include('admin.navigation')
            <!-- PAGE CONTAINER-->
            <div class="content-page">
                <div class="content">
                    @yield('content')
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
    <!-- all the js files -->
    @include ('admin.includes_bottom')
    @include ('admin.modal')
    @include ('admin.common_scripts')
    @yield('scripts')
    @if ($errors->any())
    <script>
        $(document).ready(function(){
            $.NotificationApp.send("oh snap!", '{{ $errors->first() }}' ,"top-right","rgba(0,0,0,0.2)","error");
        });
    </script>
    @endif
</body>
</html>
