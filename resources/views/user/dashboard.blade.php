@extends('user.layouts.master')
<link rel="stylesheet" href="{{ asset('public/frontend/') }}/css/virtual-card.css">


@section('breadcrumb')
    @include('user.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("user.dashboard"),
        ]
    ], 'active' => __("Dashboard")])
@endsection

@section('content')
<div class="body-wrapper">
    <div class="dashboard-area mt-10">
        <div class="dashboard-header-wrapper">
            <h3 class="title">{{ __("Welcome Back") }}, <span>{{ @$user->fullname }}</span></h3>
        </div>
        <div class="dashboard-item-area">
            <div class="row mb-20-none">
                <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title">{{__( $user->credit_limit > 0 ? "Credit Limit" : "")}}</span>
                            <h4 class="title">
                                @php 
                                @$userShow = Auth::user();
                                echo @$user->credit_limit > 0 ? @$baseCurrency->symbol . @$user->credit_limit : __("Check Credit Limit"); 
                                @endphp
                            </h4>
                        </div>
                        <div class="dashboard-icon">
                        <i class="fas fa-rupee-sign"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-20">
                    <div class="dashbord-item">
                        <div class="dashboard-content">
                            <span class="sub-title">{{ __("Active Card") }}</span>
                            <h4 class="title">{{ @$virtualCards }}</h4>
                        </div>
                        <div class="dashboard-icon">
                            <i class="menu-icon las la-credit-card"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-list-area mt-60">
        <div class="dashboard-header-wrapper">
            <h4 class="title" style="color: black;">{{ __("Latest Transactions") }}</h4>
            <div class="dashboard-btn-wrapper">
                <div class="dashboard-btn">
                    @if($virtualCards == 0)
                    <!-- if user kyc complete then show activate card otherwise show apply lexus card -->
                    <a href="javascript:void(0)" class="btn--base buyCard-stripe"> <i class="las la-plus"></i> @if($user->kyc_verified == 1) {{ __("Activate Card") }} @else {{ __("Apply Lexus Card") }} @endif</a>
                    @else
                    <a href="{{ setRoute('user.transactions.index','add-money') }}" class="btn--base">{{__("View More")}}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-list-wrapper">
        @include('user.components.transaction-log',compact("transactions"))
    </div>
</div>
@endsection
