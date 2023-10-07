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
      // Get the $users data only name and email, mobile, 

      const users = {!! json_encode($users->map(function($user) {
        return [
          'name' => $user->firstname . ' ' . $user->lastname,
          'email' => $user->email,
          'mobile' => $user->mobile,
        ];
      })) !!}; 

      console.warn(users);

      
        // create a new page with the table
        
        var data = '<table><thead><tr><th>Name</th><th>Email</th><th>Mobile</th></tr></thead><tbody>';
        for (var i = 0; i < users.length; i++) {
          data += '<tr>';
          data += '<td>' + users[i].firstname + ' ' + users[i].lastname + '</td>';
          data += '<td>' + users[i].email + '</td>';
          data += '<td>' + users[i].mobile + '</td>';
          data += '</tr>';
        }

        data += '</tbody></table>';

        // create a new page with the table
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>my div</title>');
        mywindow.document.write('</head><body>');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();

        return true;



    });
  });
</script>

@endpush
