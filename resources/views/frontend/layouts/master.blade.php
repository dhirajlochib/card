@php
    $lang = selectedLang();
    $cookie = App\Models\Admin\SiteSections::siteCookie();
    $cookie_accepted = session()->get('cookie_accepted');
    $cookie_decline = session()->get('cookie_decline');


@endphp
<!DOCTYPE html>
<html lang="{{ get_default_language_code() }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $basic_settings->sitename(__($page_title??'')) }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @include('partials.header-asset')

    @stack('css')
</head>
<body>
<div id="body-overlay" class="body-overlay"></div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Preloader
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="preloader">
    <div class="loader-inner">
        <div class="loader-circle">
            <img src="{{ get_fav($basic_settings) }}" alt="Preloader">
        </div>
        <div class="loader-line-mask">
        <div class="loader-line"></div>
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Preloader
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include('frontend.partials.header')
@include('frontend.partials.account-info')
@yield("content")


 <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start cookie
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
 
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End cookie
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include('frontend.partials.footer')
@include('partials.footer-asset')
@include('frontend.partials.extensions.tawk-to')

@stack('script')

</body>
</html>
