@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> dashboard</h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card widget-inline">
            <div class="card-body p-0">
                <div class="row no-gutters">
                    <div class="col-sm-6 col-xl-4">
                        <a href="{{route('admin.manage.users')}}" class="text-secondary">
                            <div class="card shadow-none m-0">
                                <div class="card-body text-center">
                                    <i class="dripicons-box text-muted" style="font-size: 24px;"></i>
                                    <h3><span>{{$users}}</span></h3>
                                    <p class="text-muted font-15 mb-0">number of users</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-xl-4">
                        <a href="{{route('admin.manage.admins')}}" class="text-secondary">
                            <div class="card shadow-none m-0 border-left">
                                <div class="card-body text-center">
                                    <i class="dripicons-box text-muted" style="font-size: 24px;"></i>
                                    <h3><span>{{$admins}}</span></h3>
                                    <p class="text-muted font-15 mb-0">number of admins</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-sm-6 col-xl-4">
                        <a href="{{route('admin.manage.emojis')}}" class="text-secondary">
                            <div class="card shadow-none m-0 border-left">
                                <div class="card-body text-center" style="margin-top: 8px;">
                                    <i class="fa-solid fa-face-grin text-muted" style="font-size: 24px;"></i>
                                    <h3><span>{{$emojis}}</span></h3>
                                    <p class="text-muted font-15 mb-0">number of emojis</p>
                                </div>
                            </div>
                        </a>
                    </div>

                </div> <!-- end row -->
            </div>
        </div> <!-- end card-box-->
    </div> <!-- end col-->
</div>
<!-- 
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title mb-4">users chart</h4>

                <div class="mt-3 chartjs-chart" style="height: 320px;">
                    <canvas id="task-area-chart"></canvas>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div> -->

@endsection