<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <meta property="og:image" content="{{ asset('assets/images/logo.png') }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="667">
    <meta property="og:image:height" content="236">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FeelingSupport') }}</title>
    <link rel="shortcut icon" href="{{asset('assets/images/dislike.png')}}" type="image/x-icon">

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.usebootstrap.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.usebootstrap.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropdown.js/0.0.2dev/jquery.dropdown.min.js" integrity="sha512-adjEXKENpif48TQtL+fRr7nVNrxJOLGZDbII7A1ZU6gNrh5+W9C9Ge9nn4wUb3Ug+rx/aE724v6Fsf2PIDilqg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/js/app.js') }}" defer></script>
    <script src="{{ asset('assets/js/custom.js') }}" defer></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.usebootstrap.com/bootstrap/4.4.1/css/bootstrap.min.css" />
    <link href="{{ asset('public/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom_v1.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/regular.min.js" integrity="sha512-eH31QC2/CLTAQpugtCMQh/w68mbefCbaDTsSbmqOk86RICy523PnuNMaFfQ5cAkwwJ1dsnn7OUt8bfkF24zprg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css" integrity="sha512-TQQ3J4WkE/rwojNFo6OJdyu6G8Xe9z8rMrlF9y7xpFbQfW5g8aSWcygCQ4vqRiJqFsDsE1T6MoAOMJkFXlrI9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<div id="loading">
    <div class="lds-ring">
        <div></div>
    </div>
</div>
<!--f0f2f4-->
<body style="background: #f0f2f5;">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/logo.png') }}" width="100" alt="{{__('messages.support feeling')}}">
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="top: 63px;padding: 10px;">
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav">
                        <!-- Authentication Links -->
                        <ul class="dropdown" style="padding: 0px;">
                            <li class="nav-item dropdown" style="list-style:none">
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
                        </ul>
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" style="color: black;" href="{{ route('login') }}">{{ __('messages.Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" style="color: black;" href="{{ route('register') }}">{{ __('messages.Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" style="color:black;" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('messages.Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        {{__('messages.Profile')}}
                                    </a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                    
                </div>
                
            </div>
        </nav>
        <div class="body">
            <div style="
                padding: 40px;
            "><p style="font-size: x-large;margin-bottom: 0px;">@yield('title')</p></div>
            <main class="py-4" style="padding-top: 0px !important;">
                @yield('content')
            </main>
        </div>  
    </div>
    <style>
        /*footer h5{*/
        /*    height: 105px;*/
        /*}*/
    </style>
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

  <!-- Copyright -->
  <!--<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">-->
  <!--  © 2022 Copyright:-->
  <!--  <a class="text-dark" href="https://www.feelingsupport.com/">feelingsupport.com</a>-->
  <!--</div>-->
  <!-- Copyright -->
  
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
      <div class="col-md-3 mb-md-0">

        <ul class="list-unstyled" style="padding:0px;display: flex;margin: 12px auto;width: fit-content;font-size:14px;color:white;">
          <li style="margin: 0px 3px;">
            <a href="{{route('terms')}}" style="color: #fff;">{{__('messages.terms and condition')}}</a>
          </li>
          <li style="margin: 0px 10px;">
            <a href="{{route('privacy')}}" style="color: #fff;">{{__('messages.privacy policy')}}</a>
          </li>
          <li style="margin: 0px 3px;">
            <a href="{{route('about.us')}}" style="color: #fff;">{{__('messages.About us')}}</a>
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
</footer>
    
    @yield('scripts')
    @if (Session::has('success'))
    <script>
        $(document).ready(function(){
            swal({text:"{{ Session::get('success') }}", button: "{{__('messages.ok')}}"});
        });
        
    </script>
    @endif
    
</body>
</html>
