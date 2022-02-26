<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'Laravel') }} | {{ (isset($titles->title)) ? $titles->title : ''}} </title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Nikul Vaghani" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="_token" content="{!! csrf_token() !!}" />

    <!-- Favicon icon -->
    <link rel="icon" href="{{ back_asset('images/favicon.ico') }}" type="image/x-icon">
    
    <!-- vendor css -->
    <link rel="stylesheet" href="{{ back_asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ back_asset('css/custom_dash.css') }}">

    <link href="https://fonts.googleapis.com/css?family=Google+Sans:100,300,400,500,700,900,100i,300i,400i,500i,700i,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@100;200;300;400;500;700;900&display=swap" rel="stylesheet">

    @yield('css')
</head>

<body class="background-grd-purple">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    @include(backView().'.includes.sidebar')
    @include(backView().'.includes.header')

    <div class="pcoded-main-container">
        <div class="pcoded-content">
            @include(backView().'.includes.breadcrumb')

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    @yield('content')
                </div>
            </div>

        </div>
    </div>

    <script src="{{ back_asset('js/vendor-all.min.js') }}"></script>
    <script src="{{ back_asset('js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ back_asset('js/ripple.js') }}"></script>
    <script src="{{ back_asset('js/pcoded.min.js') }}"></script>

    @yield('js')
</body>

</html>