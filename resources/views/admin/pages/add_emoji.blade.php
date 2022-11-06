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

                <form class="required-form" action="{{route('admin.create.emojis')}}" enctype="multipart/form-data" method="post">
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
                        <div class="tab-content b-0 mb-0">

                            <div id="bar" class="progress mb-3" style="height: 7px;">
                                <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
                            </div>

                            <div class="tab-pane" id="basic_info">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="css_class">select emoji<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <select name="css_class" id="css_class" class="form-control" style="font-variant: small-caps;font-size: 19px;">
                                                    <option value="fa-message-smile"> &#xf4aa; message-smile </option>
                                                    <option value="fa-location-smile"> &#xf60d; location-smile </option>
                                                    <option value="fa-comment-smile"> &#xf4b4; comment-smile </option>
                                                    <option value="fa-face-awesome"> &#xe409; face-awesome </option>
                                                    <option value="fa-face-smile"> &#xf118; face-smile </option>
                                                    <option value="fa-face-vomit"> &#xe3a0; face-vomit </option>
                                                    <option value="fa-face-zipper"> &#xe3a5; face-zipper </option>
                                                    <option value="fa-face-zany"> &#xe3a4; face-zany </option>
                                                    <option value="fa-face-worried"> &#xe3a3; face-worried </option>
                                                    <option value="fa-face-woozy"> &#xe3a2; face-woozy </option>
                                                    <option value="fa-face-weary"> &#xe3a1; face-weary </option>
                                                    <option value="fa-face-unamused"> &#xe39f; face-unamused </option>
                                                    <option value="fa-face-tongue-sweat"> &#xe39e; face-tongue-sweat </option>
                                                    <option value="fa-face-tongue-money"> &#xe39d; face-tongue-money </option>
                                                    <option value="fa-face-tissue"> &#xe39c; face-tissue </option>
                                                    <option value="fa-face-tired"> &#xf5c8; face-tired </option>
                                                    <option value="fa-face-thinking"> &#xe39b; face-thinking </option>
                                                    <option value="fa-face-thermometer"> &#xe39a; face-thermometer </option>
                                                    <option value="fa-face-swear"> &#xe399; face-swear </option>
                                                    <option value="fa-face-surprise"> &#xf5c2; face-surprise </option>
                                                    <option value="fa-face-sunglasses"> &#xe398; face-sunglasses </option>
                                                    <option value="fa-face-spiral-eyes"> &#xe485; face-spiral-eyes </option>
                                                    <option value="fa-face-smirking"> &#xe397; face-smirking </option>
                                                    <option value="fa-face-smiling-hands"> &#xe396; face-smiling-hands </option>
                                                    <option value="fa-face-smile-wink"> &#xf4da; face-smile-wink </option>
                                                    <option value="fa-face-smile-upside-down"> &#xe395; face-smile-upside-down </option>
                                                    <option value="fa-face-smile-tongue"> &#xe394; face-smile-tongue </option>
                                                    <option value="fa-face-smile-tear"> &#xe393; face-smile-tear </option>
                                                    <option value="fa-face-smile-relaxed"> &#xe392; face-smile-relaxed </option>
                                                    <option value="fa-face-smile-horns"> &#xe391; face-smile-horns </option>
                                                    <option value="fa-face-smile-hearts"> &#xe390; face-smile-hearts </option>
                                                    <option value="fa-face-smile-halo"> &#xe38f; face-smile-halo </option>
                                                    <option value="fa-face-smile-beam"> &#xf5b8; face-smile-beam </option>
                                                    <option value="fa-face-sleepy"> &#xe38e; face-sleepy </option>
                                                    <option value="fa-face-sleeping"> &#xe38d; face-sleeping </option>
                                                    <option value="fa-face-shush"> &#xe38c; face-shush </option>
                                                    <option value="fa-face-scream"> &#xe38b; face-scream </option>
                                                    <option value="fa-face-saluting"> &#xe484; face-saluting </option>
                                                    <option value="fa-face-sad-tear"> &#xf5b4; face-sad-tear </option>
                                                    <option value="fa-face-sad-sweat"> &#xe38a; face-sad-sweat </option>
                                                    <option value="fa-face-sad-cry"> &#xf5b3; face-sad-cry </option>
                                                    <option value="fa-face-rolling-eyes"> &#xf5a5; face-rolling-eyes </option>
                                                    <option value="fa-face-relieved"> &#xe389; face-relieved </option>
                                                    <option value="fa-face-raised-eyebrow"> &#xe388; face-raised-eyebrow </option>
                                                    <option value="fa-face-pouting"> &#xe387; face-pouting </option>
                                                    <option value="fa-face-pleading"> &#xe386; face-pleading </option>
                                                    <option value="fa-face-persevering"> &#xe385; face-persevering </option>
                                                    <option value="fa-face-pensive"> &#xe384; face-pensive </option>
                                                    <option value="fa-face-party"> &#xe383; face-party </option>
                                                    <option value="fa-face-nose-steam"> &#xe382; face-nose-steam </option>
                                                    <option value="fa-face-nauseated"> &#xe381; face-nauseated </option>
                                                    <option value="fa-face-monocle"> &#xe380; face-monocle </option>
                                                    <option value="fa-face-melting"> &#xe483; face-melting </option>
                                                    <option value="fa-face-meh-blank"> &#xf5a4; face-meh-blank </option>
                                                    <option value="fa-face-meh"> &#xf11a; face-meh </option>
                                                    <option value="fa-face-mask"> &#xe37f; face-mask </option>
                                                    <option value="fa-face-lying"> &#xe37e; face-lying </option>
                                                    <option value="fa-face-laugh-wink"> &#xf59c; face-laugh-wink </option>
                                                    <option value="fa-face-laugh-squint"> &#xf59b; face-laugh-squint </option>
                                                    <option value="fa-face-laugh-beam "> &#xf59a; face-laugh-beam  </option>
                                                    <option value="fa-face-laugh"> &#xf599; face-laugh </option>
                                                    <option value="fa-face-kiss-wink-heart"> &#xf598; face-kiss-wink-heart </option>
                                                    <option value="fa-face-kiss-closed-eyes"> &#xe37d; face-kiss-closed-eyes </option>
                                                    <option value="fa-face-kiss-beam"> &#xf597; face-kiss-beam </option>
                                                    <option value="fa-face-kiss"> &#xf596; face-kiss </option>
                                                    <option value="fa-face-icicles"> &#xe37c; face-icicles </option>
                                                    <option value="fa-face-hushed"> &#xe37b; face-hushed </option>
                                                    <option value="fa-face-holding-back-tears"> &#xe482; face-holding-back-tears </option>
                                                    <option value="fa-face-head-bandage"> &#xe37a; face-head-bandage </option>
                                                    <option value="fa-face-hand-yawn"> &#xe379; face-hand-yawn </option>
                                                    <option value="fa-face-hand-peeking"> &#xe481; face-hand-peeking </option>
                                                    <option value="fa-face-hand-over-mouth"> &#xe378; face-hand-over-mouth </option>
                                                    <option value="fa-face-grin-wink"> &#xf58c; face-grin-wink </option>
                                                    <option value="fa-face-grin-wide"> &#xf581; face-grin-wide </option>
                                                    <option value="fa-face-grin-tongue-wink"> &#xf58b; face-grin-tongue-wink </option>
                                                    <option value="fa-face-grin-tongue"> &#xf589; face-grin-tongue </option>
                                                    <option value="fa-face-grin-tears"> &#xf588; face-grin-tears </option>
                                                    <option value="fa-face-grin-stars"> &#xf587; face-grin-stars </option>
                                                    <option value="fa-face-grin-squint-tears"> &#xf586; face-grin-squint-tears </option>
                                                    <option value="fa-face-grin-squint"> &#xf585; face-grin-squint </option>
                                                    <option value="fa-face-grin-hearts"> &#xf584; face-grin-hearts </option>
                                                    <option value="fa-face-grin-beam-sweat"> &#xf583; face-grin-beam-sweat </option>
                                                    <option value="fa-face-grin-beam"> &#xf582; face-grin-beam </option>
                                                    <option value="fa-face-grin"> &#xf580; face-grin </option>
                                                    <option value="fa-face-grimace"> &#xf57f; face-grimace </option>
                                                    <option value="fa-face-glasses"> &#xe377; face-glasses </option>
                                                    <option value="fa-face-frown-slight"> &#xe376; face-frown-slight </option>
                                                    <option value="fa-face-frown-open"> &#xf57a; face-frown-open </option>
                                                    <option value="fa-face-frown"> &#xf119; face-frown </option>
                                                    <option value="fa-face-flushed"> &#xf579; face-flushed </option>
                                                    <option value="fa-face-fearful"> &#xe375; face-fearful </option>
                                                    <option value="fa-face-eyes-xmarks"> &#xe374; face-eyes-xmarks </option>
                                                    <option value="fa-face-expressionless"> &#xe373; face-expressionless </option>
                                                    <option value="fa-face-explode"> &#xe2fe; face-explode </option>
                                                    <option value="fa-face-exhaling"> &#xe480; face-exhaling </option>
                                                    <option value="fa-face-drooling"> &#xe372; face-drooling </option>
                                                    <option value="fa-face-downcast-sweat"> &#xe371; face-downcast-sweat </option>
                                                    <option value="fa-face-dotted"> &#xe47f; face-dotted </option>
                                                    <option value="fa-face-dizzy"> &#xf567; face-dizzy </option>
                                                    <option value="fa-face-disguise"> &#xe370; face-disguise </option>
                                                    <option value="fa-face-disappointed"> &#xe36f; face-disappointed </option>
                                                    <option value="fa-face-diagonal-mouth"> &#xe47e; face-diagonal-mouth </option>
                                                    <option value="fa-face-cowboy-hat"> &#xe36e; face-cowboy-hat </option>
                                                    <option value="fa-face-confused"> &#xe36d; face-confused </option>
                                                    <option value="fa-face-clouds"> &#xe47d; face-clouds </option>
                                                    <option value="fa-face-beam-hand-over-mouth"> &#xe47c; face-beam-hand-over-mouth </option>
                                                    <option value="fa-face-astonished"> &#xe36b; face-astonished </option>
                                                    <option value="fa-face-anxious-sweat"> &#xe36a; face-anxious-sweat </option>
                                                    <option value="fa-face-anguished"> &#xe369; face-anguished </option>
                                                    <option value="fa-face-angry-horns"> &#xe368; face-angry-horns </option>
                                                    <option value="fa-face-angry"> &#xf556; face-angry </option>
                                                    <option value="fa-face-smile-plus"> &#xf5b9; face-smile-plus </option>
                                                    <option value="fa-heart"> &#xf004; heart </option>
                                                    <option value="fa-lock"> &#xf023; lock </option>
                                                    <option value="fa-hands"> &#xF2a7; hands </option>
                                                    <option value="fa-wand-magic-sparkles"> &#xE2ca; wand-magic-sparkles </option>
                                                    <option value="fa-hand"> &#xf256; hand </option>
                                                    <option value="fa-thumbs-up"> &#xF164; thumbs-up </option>
                                                    <option value="fa-thumbs-down"> &#xf165; thumbs-down </option>                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label class="col-md-3 col-form-label" for="type_en">name in english<span class="required">*</span></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" id="type_en" name="type_en" required>
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
                                                <input type="text" class="form-control" id="type_ar" dir="rtl" name="type_ar" required>
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
                                                <input type="text" class="form-control" id="type_de" name="type_de" required>
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
                                                <input type="text" class="form-control" id="type_es" name="type_es" required>
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
                                                <input type="text" class="form-control" id="type_fr" name="type_fr" required>
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
                                                <input type="text" class="form-control" id="type_it" name="type_it" required>
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
                                                <input type="text" class="form-control" id="type_tr" name="type_tr" required>
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
                                                <input type="text" class="form-control" id="type_hi" name="type_hi" required>
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
                                                <input type="text" class="form-control" id="type_zh" name="type_zh" required>
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
                                                <input type="text" class="form-control" id="type_ur" name="type_ur" required>
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
                                                <input type="text" class="form-control" id="type_fa" name="type_fa" required>
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
                                                <input type="text" class="form-control" id="type_bn" name="type_bn" required>
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
                                                <input type="text" class="form-control" id="type_id" name="type_id" required>
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
                                                <input type="text" class="form-control" id="type_ru" name="type_ru" required>
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
                                                <input type="text" class="form-control" id="type_pt" name="type_pt" required>
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
                                                <input type="text" class="form-control" id="type_ko" name="type_ko" required>
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
                                                <input type="text" class="form-control" id="type_ja" name="type_ja" required>
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
                                                <input type="text" class="form-control" id="type_ms" name="type_ms" required>
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
                                                <input type="color" name="color" id="color" class="form-control">
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
                    </div> <!-- end #progressbarwizard-->
                </form>

            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div>
</div>

@endsection