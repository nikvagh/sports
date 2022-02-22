<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Nikul Vaghani" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" href="{{ back_asset('images/favicon.ico') }}" type="image/x-icon">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ back_asset('css/style.css') }}">

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

    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            @include(backView().'.includes.breadcrumb')

            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    @yield('content')
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- Button trigger modal -->

    <!-- Required Js -->
    <script src="{{ back_asset('js/vendor-all.min.js') }}"></script>
    <script src="{{ back_asset('js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ back_asset('js/ripple.js') }}"></script>
    <script src="{{ back_asset('js/pcoded.min.js') }}"></script>

    @yield('js')
</body>

</html>