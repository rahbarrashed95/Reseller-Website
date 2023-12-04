@php 
    $settings = DB::table('settings')->first();
@endphp
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Soft IT Demo 2')</title>
    
    <link rel="icon" type="image/x-icon" href="{{$settings->favicon}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{asset('frontend/assets/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/silck/slick.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/silck/slick-theme.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/header.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/home.css')}}">
    @stack('css')
    <link rel="stylesheet" href="{{asset('frontend/assets/css/product.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/media.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/categories.css')}}">
    
    {!!\App\Models\GoogleAnalytic::value('analytic_id')!!}
    {!!\App\Models\FacebookPixel::value('app_id')!!}
    
    
</head>






