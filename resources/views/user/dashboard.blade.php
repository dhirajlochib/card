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
                    @if($user->credit_limit > 0) 
                        <a href="{{ setRoute('user.add.money.index') }}">
                    @endif
                        <div class="dashboard-content">
                            @if($user->credit_limit > 0)
                            <span class="sub-title">{{__("Credit Limit")}}</span>
                            @else
                            <span class="sub-title">{{__("Click Here")}}</span>
                            @endif
                            <h4 class="title">
                                @php 
                                echo @$user->credit_limit > 0 ? @$baseCurrency->symbol . @$user->credit_limit : __("Check Credit Limit"); 
                                @endphp
                            </h4>
                        </div>
                        <div class="dashboard-icon">
                            <i class="las la-dollar-sign"></i>
                        </div>
                        @if($user->credit_limit > 0)
                    </a>
                    @endif

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
                    <a href="javascript:void(0)" class="btn--base buyCard-stripe"> <i class="las la-plus"></i> {{__("Apply Lexus Card")}}</a>
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
