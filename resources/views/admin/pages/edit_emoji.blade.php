@extends('layouts.admin')

@section('content')

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> Add Emoji
                    <a href="{{route('admin.manage.emojis')}}" class="btn btn-outline-primary btn-rounded alignToTitle"> <i class="mdi mdi-arrow-left"></i>Back to emojis</a>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title mb-3">Add emoji form</h4>

                <form class="required-form" action="{{route('admin.modify.emojis')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div id="progressbarwizard">
                        <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                            <li class="nav-item">
                                <a href="#basic_info" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                    <i class="mdi mdi-face-profile mr-1"></i>
                                    <span class="d-none d-sm-inline">emoji info</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#finish" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                    <i class="mdi mdi-checkbox-marked-circle-outline mr-1"></i>
                                    <span class="d-none d-sm-inline">finish</span>
                                </a>
                            </li>
                        </ul>
                        @foreach($emojis as $emoji)
                        <input type="hidden" name="id" value="{{$emoji->id}}">
                        <div class="tab-content b-0 mb-0">

                            <div id="bar" class="progress mb-3" style="height: 7px;">
                                <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
                            </div>

                            <div class="tab-pane" id="basic_info">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="css_class">select emoji<span class="required">*</span></label>
                                            <div class="col-md-9" style="display: inherit;">
                                            <i class="fa-solid {{$emoji->css_class}} emmo-size emmo-select" data-id="{{$emoji->id}}" style="-webkit-text-stroke: 0.5px white;font-size:30px;margin-right: 20px;margin-top: 4px;color: <?php echo $emoji->color ?>"></i>
                                                <select name="css_class" id="css_class" class="form-control" style="font-variant: small-caps;font-size: 19px;">
                                                    <option value="fa-face-grin">&#xf580; grin</option>
                                                    <option value="fa-face-angry">&#xf556; angry</option>
                                                    <option value="fa-face-dizzy">&#xf567; dizzy</option>
                                                    <option value="fa-face-flushed">&#xf579; flushed</option>
                                                    <option value="fa-face-frown">&#xf119; frown</option>
                                                    <option value="fa-face-frown-open">&#xf57a; frown open</option>
                                                    <option value="fa-face-grimace">&#xf57f; grimace</option>
                                                    <option value="fa-face-grin-beam">&#xf582; grin beam</option>
                                                    <option value="fa-face-grin-beam-sweat">&#xf583; grin beam sweat</option>
                                                    <option value="fa-face-grin-hearts">&#xf584; grin hearts</option>
                                                    <option value="fa-face-grin-squint">&#xf585; grin squint</option>
                                                    <option value="fa-face-grin-squint-tears">&#xf586; grin squint tears</option>
                                                    <option value="fa-face-grin-stars">&#xf587; grin stars</option>
                                                    <option value="fa-face-grin-tears">&#xf588; grin tears</option>
                                                    <option value="fa-face-grin-tongue">&#xf589; grin tongue</option>
                                                    <option value="fa-face-grin-tongue-squint">&#xf58a; grin tongue squint</option>
                                                    <option value="fa-face-grin-tongue-wink">&#xf58b; grin tongue wink</option>
                                                    <option value="fa-face-grin-wide">&#xf581; grin wide</option>
                                                    <option value="fa-face-grin-wink">&#xf58c; grin wink</option>
                                                    <option value="fa-face-kiss">&#xf596; kiss</option>
                                                    <option value="fa-face-kiss-beam">&#xf597; kiss beam</option>
                                                    <option value="fa-face-kiss-wink-heart">&#xf598; kiss wink heart</option>
                                                    <option value="fa-face-laugh">&#xf599; laugh</option>
                                                    <option value="fa-face-laugh-beam">&#xf59a; laugh beam</option>
                                                    <option value="fa-face-laugh-squint">&#xf59b; laugh squint</option>
                                                    <option value="fa-face-laugh-wink">&#xf59c; laugh wink</option>
                                                    <option value="fa-face-meh">&#xf11a; meh</option>
                                                    <option value="fa-face-meh-blank">&#xf5a4; meh blank</option>
                                                    <option value="fa-face-rolling-eyes">&#xf5a5; rolling eyes</option>
                                                    <option value="fa-face-sad-cry">&#xf5b3; sad cry</option>
                                                    <option value="fa-face-sad-tear">&#xf5b4; sad tear</option>
                                                    <option value="fa-face-smile">&#xf118; face smile</option>
                                                    <option value="fa-face-smile-beam">&#xf5b8; smile beam</option>
                                                    <option value="fa-face-smile-wink">&#xf4da; smile wink</option>
                                                    <option value="fa-face-surprise">&#xf5c2; surprise</option>
                                                    <option value="fa-face-tired">&#xf5c8; tired</option>                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in english<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_en}}" id="type_en" name="type_en" required>
                                            </div>
                                            @error('type_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_ar">name in arabic<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_ar}}" id="type_ar" dir="rtl" name="type_ar" required>
                                            </div>
                                            @error('type_ar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in Deutsch<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_de}}" id="type_de" name="type_de" required>
                                            </div>
                                            @error('type_de')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in español<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_es}}" id="type_es" name="type_es" required>
                                            </div>
                                            @error('type_es')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in français<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_fr}}" id="type_fr" name="type_fr" required>
                                            </div>
                                            @error('type_fr')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in italiano<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_it}}" id="type_it" name="type_it" required>
                                            </div>
                                            @error('type_it')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in Türkçe<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_tr}}" id="type_tr" name="type_tr" required>
                                            </div>
                                            @error('type_tr')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in hindi<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_hi}}" id="type_hi" name="type_hi" required>
                                            </div>
                                            @error('type_hi')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in chinese<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_zh}}" id="type_zh" name="type_zh" required>
                                            </div>
                                            @error('type_zh')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in urdu<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_ur}}" id="type_ur" name="type_ur" required>
                                            </div>
                                            @error('type_ur')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in faresi<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_fa}}" id="type_fa" name="type_fa" required>
                                            </div>
                                            @error('type_fa')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in bengali<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_bn}}" id="type_bn" name="type_bn" required>
                                            </div>
                                            @error('type_bn')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in Indonesian<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_id}}" id="type_id" name="type_id" required>
                                            </div>
                                            @error('type_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in Russian<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_ru}}" id="type_ru" name="type_ru" required>
                                            </div>
                                            @error('type_ru')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in Portuguese<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_pt}}" id="type_pt" name="type_pt" required>
                                            </div>
                                            @error('type_pt')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in Korean<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_ko}}" id="type_ko" name="type_ko" required>
                                            </div>
                                            @error('type_ko')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in Japanese<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_ja}}" id="type_ja" name="type_ja" required>
                                            </div>
                                            @error('type_ja')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in Malay<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" value="{{$emoji->type_ms}}" id="type_ms" name="type_ms" required>
                                            </div>
                                            @error('type_ms')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="category">category<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <select name="category" id="category" class="form-control">
                                                    <option value="positive">positive</option>
                                                    <option value="negative">negative</option>
                                                </select>
                                            </div>
                                            @error('category')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="color">color<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="color" name="color" value="{{$emoji->color}}" id="color" class="form-control">
                                            </div>
                                            @error('color')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>
                            <div class="tab-pane" id="finish">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-center">
                                            <h2 class="mt-0"><i class="mdi mdi-check-all"></i></h2>
                                            <h3 class="mt-0">Thank you !</h3>
                                            <div class="mb-3">
                                                <button type="button" class="btn btn-primary" onclick="checkRequiredFields()" name="button">submit</button>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>

                            <ul class="list-inline mb-0 wizard text-center">
                                <li class="previous list-inline-item">
                                    <a href="javascript:;" class="btn btn-info"> <i class="mdi mdi-arrow-left-bold"></i> </a>
                                </li>
                                <li class="next list-inline-item">
                                    <a href="javascript:;" class="btn btn-info"> <i class="mdi mdi-arrow-right-bold"></i> </a>
                                </li>
                            </ul>

                        </div> <!-- tab-content -->
                        @endforeach
                    </div> <!-- end #progressbarwizard-->
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $("#css_class").val("{{$emojis[0]->css_class}}");
        $("#category").val("{{$emojis[0]->category}}");
    });
</script>
@endsection