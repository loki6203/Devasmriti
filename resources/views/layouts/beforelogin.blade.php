<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>DevaSmriti</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="DevaSmriti" name="description" />
        <meta content="DevaSmriti" name="DevaSmriti" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        <link href="{{ asset('assets/libs/chartist/chartist.min.css') }}" rel="stylesheet">

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    </head>
<body>
@yield('content')
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

</body>
</html>
