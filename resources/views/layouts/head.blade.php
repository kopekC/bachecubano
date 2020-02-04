<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="{{ asset('css/bs.css') }}">
    <!-- LineIcons CDN -->
    <link rel="stylesheet" href="https://cdn.lineicons.com/1.0.1/LineIcons.min.css">
    <!-- Slicknav Responsive Menu -->
    <!-- <link rel="stylesheet" href="{{ asset('css/slicknav.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}">
    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('css/main2.css') }}">
    <!-- Animate -->
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <!-- Responsive Style -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,400|Open+Sans">


    @stack('style')

    <!-- blog Feeds 
    include('feed::links')-->

    <!-- Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#2b5797">
    <meta name="theme-color" content="#1976D2">
</head>