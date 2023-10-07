@extends('admin.layouts.master')

@push('css')
@endpush

@section('page-title')
    @include('admin.components.page-title', ['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('admin.dashboard'),
            ],
        ],
        'active' => __('User Care'),
    ])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __("All Users") }}</h5>
                <!-- EXPORT BUTTON -->
                <button id="exportButton" class="btn btn-primary">Export to PDF</button>
                <div class="table-btn-area">
                    @include('admin.components.search-input',[
                        'name'  => 'user_search',
                    ])
                </div>
            </div>
            <div class="table-responsive">
                @include('admin.components.data-table.user-table',compact('users'))
            </div>
        </div>
        {{ get_paginate($users) }}
    </div>

@endsection
@push('script')
    <script>
        itemSearch($("input[name=user_search]"), $(".user-search-table"), "{{ setRoute('admin.users.search') }}");
    </script>
   
   
<script>
  $(document).ready(function() {
    $("#exportButton").click(function() {
        const users = {!! json_encode($users->map(function($user) {
            return [
                'name' => $user->fullname,
                'kyc_verified' => $user->kyc_verified,
                'credit_limit' => $user->credit_limit,
                'mobile' => $user->mobile,
            ];
        })) !!};

        // Create an HTML table with headers
        var data = '<table><thead><tr><th>Name</th><th>KYC Status</th><th>Credit Limit</th><th>Mobile</th></tr></thead><tbody>';

        // Populate the table rows with user data with some spaces in between
        for (var i = 0; i < users.length; i++) {
            data += '<tr>';
            data += '<td>' + users[i].name + '&nbsp;&nbsp;</td>';
            data += '<td>' + (users[i].kyc_verified == 1 ? 'Verified' : 'Not Verified') + '&nbsp;&nbsp;</td>' 
            data += '<td>' + (users[i].credit_limit == 0 ? 'KYC Not Verified' : users[i].credit_limit) + '&nbsp;&nbsp;</td>';
            data += '<td>' + users[i].mobile + '</td>';
            data += '</tr>';
        }

        data += '</tbody></table>';

        // Create a new page with the table
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Data</title>');
        mywindow.document.write('</head><body>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        // Close the document and print
        mywindow.document.close();
        mywindow.focus();
        mywindow.print();
        mywindow.close();

        return true;
    });
});

</script>

@endpush
