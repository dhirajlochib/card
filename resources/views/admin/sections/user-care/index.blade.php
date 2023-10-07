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
      // Get the $users data
      const users = JSON.parse('{{ json_encode($users) }}');

      // Create a new PDF document
      const doc = new jsPDF();

      // Add the table header
      doc.setFontSize(12);
      doc.text(10, 10, 'Name');
      doc.text(60, 10, 'Mobile');
      doc.text(110, 10, 'Email');

      // Add the table rows
      for (const user of users) {
        doc.text(10, 20 + users.indexOf(user) * 10, user.name);
        doc.text(60, 20 + users.indexOf(user) * 10, user.mobile);
        doc.text(110, 20 + users.indexOf(user) * 10, user.email);
      }

      // Save the PDF document
      doc.save('users.pdf');
    });
  });
</script>

@endpush
