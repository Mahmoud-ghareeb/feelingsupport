@extends('layouts.site')

@section('title')
{{__('messages.Share')}}
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center" style="background: white;">
        <div class="col-md-12 share-padding">
            <h2 class="mb-5 text-center">{{__('messages.Share This Feel On')}}</h2>
            {!! $shareComponent !!}
        </div>
    </div>
</div>
@endsection
