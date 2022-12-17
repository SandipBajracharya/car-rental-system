<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Everest Car Rental</title>
    <link href="{{asset('css/1.style.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    @yield('page-specific-css')
</head>

<body>
    @include('include.main.sideMenu')
    @include('include.main.loading')

    @yield('main-content')
    
    <div class="opt-content" style="display: none;">
        @include('sweetalert::alert')
        @include('include.main.footer')
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{asset('js/vendors.js')}}"></script>
    <script src="{{asset('js/home.js')}}"></script>
    <script src="{{asset('js/miscellaneous.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('page-specific-script')
</body>
</html>