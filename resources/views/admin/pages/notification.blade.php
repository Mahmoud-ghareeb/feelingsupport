@extends('layouts.admin')

@section('content')

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> Send Notification
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">


                <form class="required-form" action="{{route('admin.send.notification')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div id="progressbarwizard">
                        <div class="tab-content b-0 mb-0">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row mb-3">
                                        <label class="col-md-3 col-form-label" for="title">title<span class="required">*</span></label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label class="col-md-3 col-form-label" for="message">message<span class="required">*</span></label>
                                        <div class="col-md-9">
                                            <textarea type="text" class="form-control" id="message" name="message" rows="6" required></textarea>
                                        </div>
                                        @error('message')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group row mb-3">
                                        <button type="submit" style="margin: 0px auto;" class="btn btn-primary">Send</button>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                        </div> <!-- tab-content -->
                    </div> <!-- end #progressbarwizard-->
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div>
</div>

@endsection