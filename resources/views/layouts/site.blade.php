<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <meta name="description" content="feelingsupport is the first social network dedicated to supporting human feelings where you can save your feelings privately or share them on any social network like facebook, twitter, instagram, snap, whatsapp etc, to get support from your friends">

    <meta property="og:image" content="{{ asset('assets/images/logo.png') }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="667">
    <meta property="og:image:height" content="236">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZGVNBX0X0S"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-ZGVNBX0X0S');
    </script>

    <title>{{ config('app.name', 'FeelingSupport') }}</title>
    <link rel="shortcut icon" href="{{asset('assets/images/dislike.png')}}" type="image/x-icon">
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <script src="https://cdn.usebootstrap.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.usebootstrap.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropdown.js/0.0.2dev/jquery.dropdown.min.js" integrity="sha512-adjEXKENpif48TQtL+fRr7nVNrxJOLGZDbII7A1ZU6gNrh5+W9C9Ge9nn4wUb3Ug+rx/aE724v6Fsf2PIDilqg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/js/app.js') }}" defer></script>
    <script src="{{ asset('assets/js/custom.js') }}" defer></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Emoji:wght@300&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <!-- <link rel="stylesheet" href="https://cdn.usebootstrap.com/bootstrap/4.4.1/css/bootstrap.min.css" /> -->
    <link href="{{ asset('public/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom_v1.css') }}" rel="stylesheet">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/regular.min.js" integrity="sha512-eH31QC2/CLTAQpugtCMQh/w68mbefCbaDTsSbmqOk86RICy523PnuNMaFfQ5cAkwwJ1dsnn7OUt8bfkF24zprg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css" integrity="sha512-TQQ3J4WkE/rwojNFo6OJdyu6G8Xe9z8rMrlF9y7xpFbQfW5g8aSWcygCQ4vqRiJqFsDsE1T6MoAOMJkFXlrI9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="{{ asset('assets/css/all.css') }}">

</head>
<div id="loading">
    <div class="lds-ring">
        <div></div>
    </div>
</div>
<body style="overflow-x: hidden;overflow-y: auto;background: #f0f2f5;">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand mobile" href="{{ route('home') }}" style="margin: 0px;">
                    <img src="{{ asset('assets/images/logo.png') }}" width="100" alt="{{__('messages.support feeling')}}">
                </a>
                
                
                <ul class="navbar-nav center-element show-in-mobile" style="margin: 0px;padding: 0px;position: relative;">

                    <li class="nav-item me-sm-5 @if(LaravelLocalization::getCurrentLocaleDirection() == 'ltr') me-xs-5 @endif">
                        <a class="nav-link lhome" style="color: black;font-size: 19px;" href="{{route('home')}}"><i class="fa-solid fa-house"></i></a>
                    </li>
                    @auth
                    <li class="nav-item me-sm-5 me-xs-5">
                        <a class="nav-link lnotes" style="color: black;font-size: 19px;" href="{{route('feeling.feels')}}"><i class="fa-solid fa-pen-to-square"></i></a>
                    </li>
                    <li class="nav-item me-sm-5 me-xs-5">
                        <a class="nav-link lcharts" style="color: black;font-size: 19px;" href="{{route('feeling.charts.daily')}}"><i class="fa-solid fa-chart-line"></i></a>
                    </li>

                    <ul class="dropdown icon-dropdown me-sm-5 me-xs-5" style="padding: 0px 11px 0px 0px;position: relative;">
                        <li style="list-style-type: none;"></li>
                        <a id="navbarDropdownnoti" style="color: black; font-size: 19px;" class="nav-link dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i class="fa-solid fa-bell"></i><span class="badge badge-danger" id="messi_nums1" style="border-radius: 50%;padding: 3px;position: absolute;top: 7px;right: -5px;font-size: 10px;"></span></a>
                        <ul class="dropdown-menu top-dropdown lg-dropdown notification-dropdown" @if(LaravelLocalization::getCurrentLocaleDirection() == 'rtl') style="width: 300px;position: absolute;left: -90px;" @else style="width: 300px;position: absolute;left: -190px;" @endif aria-labelledby="navbarDropdownnoti">
                            <li> 
                            <div class="dropdown-header row" style="display: flex;">
                                 <div class="col-6" style="text-align: center;">
                                     <a href="{{route('read.all.notis')}}">{{__('messages.read all')}} </a>
                                 </div>
                                 <div class="col-6" style="text-align: center;">
                                     <a href="{{route('clear.all.notis')}}">{{__('messages.clear all')}} </a>
                                 </div>
        					</div>
                                <div class="scrollDiv" style="height: 350px;overflow-y: auto;">
                                    <div class="notification-list messi_notification">  
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </ul>
                    @endauth
                </ul>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    @auth
                    <ul class="navbar-nav center-element show-in-desktop">

                        <li class="nav-item me-sm-5 me-xs-5">
                            <a class="nav-link lhome" style="color: black;font-size: 19px;" href="{{route('home')}}"><i class="fa-solid fa-house"></i></a>
                        </li>
                        <li class="nav-item me-sm-5 me-xs-5">
                            <a class="nav-link lnotes" style="color: black;font-size: 19px;" href="{{route('feeling.feels')}}"><i class="fa-solid fa-pen-to-square"></i></a>
                        </li>
                        <li class="nav-item me-sm-5 me-xs-5">
                            <a class="nav-link lcharts" style="color: black;font-size: 19px;" href="{{route('feeling.charts.daily')}}"><i class="fa-solid fa-chart-line"></i></a>
                        </li>
                        
                        <ul class="icon-dropdown me-sm-5 me-xs-5" style="padding: 0px 11px 0px 0px;list-style-type:none;position: relative;">
                            <li style="list-style-type: none;"></li>
                            <a id="navbarDropdownnoti2" style="color: black; font-size: 19px;" class="nav-link dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa-solid fa-bell"></i><span class="badge badge-danger" id="messi_nums2" style="border-radius: 50%;padding: 3px;position: absolute;top: 7px;right: -5px;font-size: 10px;"></span></a>
                            <div class="dropdown-menu top-dropdown lg-dropdown notification-dropdown" style="width: 350px;" aria-labelledby="navbarDropdownnoti2">
                                 <div class="dropdown-header row" style="display: flex;">
                                     <div class="col-6" style="text-align: center;">
                                         <a href="{{route('read.all.notis')}}">{{__('messages.read all')}} </a>
                                     </div>
                                     <div class="col-6" style="text-align: center;">
                                         <a href="{{route('clear.all.notis')}}">{{__('messages.clear all')}} </a>
                                     </div>
            					</div>
                                    <div class="scrollDiv" style="height: 350px;overflow-y: auto;">
                                        <div class="notification-list messi_notification"> 
                                            
                                            
                                        </div>
                                    </div>
                            </div>
                        </ul>
                            <!-- <li class="dropdown icon-dropdown me-sm-5 me-xs-5" style="padding: 0px 11px 0px 0px;">
                                <a id="navbarDropdownnoti2" style="color: black; font-size: 19px;" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa-solid fa-bell"></i>
                                    <span class="badge badge-danger messi_nums"></span>
                                </a>
                                <div class="dropdown-menu navbarDropdownnoti2" aria-labelledby="navbarDropdownnoti2" style="width: 350px;" >
                                    <div class="scrollDiv" style="height: 350px;overflow-y: auto;">
                                        <div class="notification-list messi_notification">
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </li> -->

                    </ul>
                    @endauth

                    <div >

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav" style="padding: 0px 7px 0px 7px;width: fit-content;">
                            <!-- Authentication Links -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownlang" style="color:black;" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa-solid fa-globe"></i> {{ __('messages.languages') }}
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownlang" style="left: auto;right: auto;">
                                    <div class="scrollDiv" style="height: 400px;overflow-y: auto;">
                                    @foreach(LaravelLocalization::getLocalesOrder() as $localeCode => $properties)
                                        <a rel="alternate" class="dropdown-item" style="color: black;" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            {{ $properties['native'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </li>
                            <!-- <ul class="dropdown " style="padding: 0px;">
                                <li class="nav-item" style="list-style: none;">
                                    <a id="lang" style="color:black;" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <span style="padding: 0px 5px 5px 0px;">languages</span>
                                    </a>
                                    <div class="dropdown-menu lang" aria-labelledby="lang" style="top: 40px;left: auto;right: auto;padding: 5px;" >
                                            
                                    </div>
                                </li>
                            </ul> -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" style="color:black" href="{{ route('login') }}">{{ __('messages.Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" style="color:black" href="{{ route('register') }}">{{ __('messages.Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" style="color:black;" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fa-solid fa-user"></i> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="left: auto;right: auto;">
                                        
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                        <a class="dropdown-item" href="{{ route('profile') }}">
                                            {{__('messages.Profile')}}
                                        </a>
                                        @if(isset(auth()->user()->admin_id))
                                        <a class="dropdown-item" href="{{ route('return.to.admin') }}">
                                            {{__('messages.Return to admin')}}
                                        </a>
                                        @endif
                                        @can('moderatorPermission', auth()->user())
                                        <a class="dropdown-item" href="{{ route('dashboard') }}">
                                            {{__('messages.adminPanel')}}
                                        </a>
                                        @endcan

                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                            {{ __('messages.Logout') }}
                                        </a>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
                
            </div>
        </nav>
        <div class="body">
            <div style="padding: 1px 9px 1px 9px;display: flex;">
                <p style="font-size: x-large;margin-bottom: 0px;">@yield('title')</p>
            </div>
            <main class="py-4" style="padding-top: 0px !important;margin-bottom: -9px;">
                @yield('content')
            </main>
        </div>  
    </div>
    <footer class="bg-light text-center text-lg-start">
  <!-- Grid container -->
  <div class="container p-4" >
    <!--Grid row-->
    <div class="row">
      <!--Grid column-->
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <p>{{__('messages.footer head 1')}}</p>
        <p style="font-weight: 200;">{{__('messages.footer body 1')}}</p>
      </div>
      <!--Grid column-->
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <p>{{__('messages.footer head 2')}}</p>
        <p style="font-weight: 200;">{{__('messages.footer body 2')}}</p>
      </div>

      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <p >{{__('messages.footer head 3')}}</p>
        <p style="font-weight: 200;">{{__('messages.footer body 3')}}</p>
      </div>

      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <p>{{__('messages.footer head 4')}}</p>
        <p style="font-weight: 200;">{{__('messages.footer body 4')}}</p>
      </div>
      <!--Grid column-->
    </div>
    <!--Grid row-->
  </div>
  <!-- Grid container -->
    <div class="modal fade" id="share-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="share-action" method="POST" action="">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="message" style="display:none">{{__('messages.Type your feeling')}}</label>
                            <textarea class="form-control" name="commentShare" id="commentShare" rows="3" placeholder="{{__('messages.replay hint')}}"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" style="margin:0px auto; width:150px" class="btn btn-primary">{{__('messages.save and share')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="date-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="specificDate" method="POST" action="">
                    @csrf
                    <div class="modal-body">
                        <label for="date" class="col-sm-6 col-form-label" style="width: fit-content;margin-top: 22px;display: block;">{{__('messages.Choose Date')}}</label>
                        <div class="col-sm-9">
                            <div class="input-group date" id="dateSPP">
                                <input type="text" class="form-control" id="dateD">
                                <span class="input-group-append">
                                    <span class="input-group-text bg-white d-block">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" style="margin: 0px auto;" class="btn btn-primary">{{__('messages.Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  <!-- Copyright -->
  
  <!-- Copyright -->
</footer>
    <!-- Footer -->
<footer class="page-footer font-small blue" style="background: #bf1b2c;color: white;">

  <!-- Footer Links -->
  <div class="container-fluid text-center text-md-left">

    <!-- Grid row -->
    <div class="row">

      <!-- Grid column -->
      <div class="col-md-6 mt-md-0 mb-3" style="display:none">

        <!-- Content -->
        <h5>FeelingSupport</h5>
        <p style="text-align: initial;">Feeling support is a website to write your notes on and share it in other social media to get support.</p>

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-3 mb-md-0 mb-3" style="display:none">

        <!-- Links -->
        <h5>Social Links</h5>

        <ul class="list-unstyled" style="display: inline-flex;margin: 0px auto;">
          <li>
            <a class="fb-ic">
                <i class="fab fa-facebook-f fa-lg white-text mr-md-5 mr-3 fa-2x" style="color: #4267B2;"> </i>
            </a>
          </li>
          <li>
            <a class="tw-ic">
                <i class="fab fa-twitter fa-lg white-text mr-md-5 mr-3 fa-2x" style="color: #1DA1F2;"> </i>
            </a>
          </li>
          <li>
            <a class="ins-ic">
            <i class="fab fa-instagram fa-lg white-text mr-md-5 mr-3 fa-2x" style="color: #C13584"> </i>
          </a>
          </li>
        </ul>

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-12 mb-md-0">

        <ul class="list-unstyled" style="padding:0px;display: flex;margin: 12px auto;width: fit-content;font-size:14px;color:white;">
          <li style="margin: 0px 3px;">
            <a href="{{route('terms')}}" style="color: #fff;font-size: 11px;">{{__('messages.terms and condition')}}</a>
          </li>
          <li style="margin: 0px 10px;">
            <a href="{{route('privacy')}}" style="color: #fff;font-size: 11px;">{{__('messages.privacy policy')}}</a>
          </li>
          <li style="margin: 0px 3px;">
            <a href="{{route('about.us')}}" style="color: #fff;font-size: 11px;">{{__('messages.About us')}}</a>
          </li>
        </ul>

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </div>
  <!-- Footer Links -->

  <!-- Copyright -->
  <div class="footer-copyright text-center" style="background-color: #dee1e6;padding: 2px;color: black;">
    {!!__('messages.Copyright © 2022 :')!!}
    
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->
      
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>
    <script>
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        $(document).ready(function(){
        
            const firebaseConfig = {
            apiKey: "AIzaSyDRLjMy31iXQlOvRVxr1xOIX7PNbslq8PE",
            authDomain: "feelingsupport.firebaseapp.com",
            projectId: "feelingsupport",
            storageBucket: "feelingsupport.appspot.com",
            messagingSenderId: "286247524795",
            appId: "1:286247524795:web:2ab1344bec4b2ee50a8c9e",
            measurementId: "G-20QWXFYMMP"
            };

            // Initialize Firebase
            firebase.initializeApp(firebaseConfig);
            const messaging = firebase.messaging();
            function startFCM() {
                        messaging
                            .requestPermission()
                            .then(function () {
                                return messaging.getToken()
                            })
                            .then(function (response) {
                                console.log(response);
                                $.ajax({
                                    url: '{{ route("store.token") }}',
                                    type: 'POST',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        "firebasetoken": response
                                    },
                                    dataType: 'JSON',
                                    success: function (response) {
                                        console.log('Token stored.');
                                    },
                                    error: function (error) {
                                        console.log(error);
                                    },
                                });
                            }).catch(function (error) {
                                console.log(error);
                            });
                //     });
                // }
            }
            //startFCM();
            messaging.onMessage(function (payload) {
                const title = payload.data.title;
                const options = {
                    body: payload.data.body,
                    icon: "{{ asset('assets/images/logo.png') }}",
                };
                new Notification(title, options);
                notiCounts();
            });

            function copyToclipboard(str){
        
                const el = document.createElement('textarea');
                el.value = str;
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);

                swal({
                    heading: 'success',
                    text: '{{__("messages.link has been copied")}}',
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 3000,
                    stack: 1,
                    button: "{{__('messages.ok')}}"
                });

            }

            $(".copy-link").on("click", function(){
            
                var tx = $(this).data('link');
                tx = tx.replace('/<?php echo app()->getLocale() ?>/', '/')
                copyToclipboard(tx);    
                
            });

            function notiCounts(){
                $.ajax({
                    url: '{{ route("notification.count") }}',
                    type: 'GET',
                    dataType: 'JSON',
                    success: function (response) {
                        //console.log(response);
                        if(response > 0){
                            $("#messi_nums1, #messi_nums2").text(response);
                        }
                        
                    },
                    error: function (error) {
                        console.log(error);
                    },
                });
            }
            notiCounts();
            $("#navbarDropdownnoti, #navbarDropdownnoti2").on('click', function(){
                var html = "";
                notiCounts();
                $.ajax({
                    url: '{{ route("notification") }}',
                    type: 'GET',
                    dataType: 'JSON',
                    success: function (response) {
                        for(var noti of response){
                            var date = new Date(noti['created_at']);
                            var edited_date = date.toLocaleString()
                            if(noti['user_id'] == 0 && noti['owner_id'] == 0)
                            {
                                if(noti['message'].indexOf('messages.') == -1){
                                    html += `
                                    
                                        <a class="clearfix noti-active-${noti['is_viewed']} " href="/feelings/feel/view/0/0/${noti['id']}" style="padding: 6px 12px 6px 11px;">
                                            <span class="notification-description">
                                            FeelingSupport
                                            <label class="label label-warning pull-right" style="float: right;display:none;">
                                                <label class="badge badge-primary" style="display:none;">${noti['type']}</label>
                                            </label>
                                            </span> 
                                            <span class="notification-title">${noti['message']}</span> 
                                            <span class="notification-time">${edited_date}</span>
                                        </a>
                                    
                                    `;
                                }
                            }else{
                                
                                var message = '';
                                if(noti['type'] == "like"){
                                    message = '{{__("messages.liked your note")}}';
                                }else if(noti['type'] == "comment"){
                                    message = '{{__("messages.Commented on your note")}}';
                                }
                                else{
                                    message = noti['message'];
                                }
                                
                                if(noti['user_id'] == 0){
                                    html += `
                                    
                                    <a class="clearfix noti-active-${noti['is_viewed']}" href="/feelings/feel/view/${noti.owner?.name}/${noti['type_id']}/${noti['id']}#c${noti['comment_id']}" style="padding: 6px 12px 6px 11px;">
                                        <span class="notification-description">
                                        {{__('messages.Anonymous')}}
                                        <label class="label label-warning pull-right" style="float: right;display:none;">
                                            <label class="badge badge-primary">${noti['type']}</label>
                                        </label>
                                        </span> 
                                        <span class="notification-title">${message}</span> 
                                        <span class="notification-time" >${edited_date}</span>
                                    </a>
                                
                                `;
                                }else{
                                    html += `
                                    
                                    <a class="clearfix noti-active-${noti['is_viewed']}" href="/feelings/feel/view/${noti.owner?.name}/${noti['type_id']}/${noti['id']}#c${noti['comment_id']}" style="padding: 6px 12px 6px 11px;">
                                        <span class="notification-description">
                                        ${noti.user?.first_name} ${noti.user?.last_name}
                                        <label class="label label-warning pull-right" style="float: right;display:none;">
                                            <label class="badge badge-primary">${noti['type']}</label>
                                        </label>
                                        </span> 
                                        <span class="notification-title">${message}</span> 
                                        <span class="notification-time" >${edited_date}</span>
                                    </a>
                                
                                `;
                                }
                                
                            }
                        }

                        $(".messi_notification").html(html);

                    },
                    error: function (error) {
                        console.log(error);
                    },
                });

            });
        });
        
    </script>
    
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.ar.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.bn.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.de.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.es.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.en.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.fa.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.fr.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.hi.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.id.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.it.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.ja.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.ko.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.ms.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.pt.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.ru.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.tr.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.ur.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap-datepicker.zh.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#xemoji').click(function(e){
                e.stopPropagation();
            });
        });
    </script>
        @yield('scripts')
        
    @if ($errors->any())
    <script>
        $(document).ready(function(){
            swal({text:"{{ $errors->first() }}", button: "{{__('messages.ok')}}"});
        });
    </script>
    @endif
    
</body>
</html>