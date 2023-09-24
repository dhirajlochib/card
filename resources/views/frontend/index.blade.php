@extends('frontend.layouts.master')
@php
$lang = selectedLang();
$banner_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::HOME_BANNER);
$banner = App\Models\Admin\SiteSections::getData( $banner_slug)->first();

@endphp

@section('content')

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Banner
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="banner-section pt-60">
    <div class="baner-element">
        <img src="https://mukto.appdevs.net/stripcard/assets/images/baner/baner-bg.png">
    </div>
    <div class="container">
        <div class="row align-items-center mb-30-none">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="banner-content">
                    @php
                    $heading = explode(' ', @$banner->value->language->$lang->heading);

                    @endphp
                    <h1 class="title">{{ @$heading[0] }} <br> {{ @$heading[4] }} {{ @$heading[5] }} <br> <span class="text--base" style="background-color: transparent; -webkit-text-fill-color: transparent; background-clip: text; -webkit-background-clip: text; background-image: linear-gradient(160deg, #DCFFEA 0%, #1B756B 53%); font-size: 75px; line-height: 0.8;"> {{ @$heading[6] }}</span> {{ @$heading[7] }} {{ @$heading[8] }}</h1>
                    <p>{{ __(@$banner->value->language->$lang->sub_heading) }}</p>
                    <div class="banner-btn">
                        <button class="btn--base reg-dashboard-btn"><i aria-hidden="true" class="far fa-credit-card" style="color: white;"></i> &nbsp;{{ __(@$banner->value->language->$lang->button_name) }}</button>
                        <a class="text--base" href="{{ route('about') }}">
                            <span class="base--text" style="color: #1b756b;"> &nbsp; Learn More <i class="fas fa-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="banner-thumb">
                    <img src="{{ get_image(@$banner->value->images->banner_image,'site-section') }}" alt="element">
                </div>
            </div>
        </div>
    </div>
</section>
<script>
// if we get ref-facebook then default click on register button
    var url_string = window.location.href;
    var url = new URL(url_string);
    console.log(url.searchParams.get("ref"));
    var ref = url.searchParams.get("ref");
    if (ref == "facebook") {
      //$(".reg-dashboard-btn").trigger("click");
    document.getElementById("reg-dashboard-btn").click();
    
    }
    </script>

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Banner
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start About
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include('frontend.sections.about')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End About
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Feature
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include('frontend.sections.feature')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Feature
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start How it works
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include('frontend.sections.how-work')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End How it works
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
   start Statistics section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include('frontend.sections.statistics')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Statistics section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!-- testimonial-section  -->
@include('frontend.sections.testimonial')
<!-- End section -->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Call-to-action
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include('frontend.sections.start-section')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Call-to-action
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


@endsection

@push("script")

@endpush