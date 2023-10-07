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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
        // Function to export the table data to a PDF
        function exportToPDF() {
            // Check if jsPDF is defined
            if (typeof jsPDF !== 'undefined') {
                // Create a new jsPDF instance
                const pdf = new jsPDF();

                // Add a title to the PDF
                pdf.text("User Data", 10, 10);

                // Get the table element by its ID
                const table = document.getElementById('myTable');

                // Convert the table to a data URL
                const tableDataURL = table.toDataURL();

                // Add the table as an image to the PDF
                pdf.addImage(tableDataURL, 'PNG', 10, 20, 180, 0);

                // Save or download the PDF
                pdf.save('user_data.pdf');
            } else {
                console.error("jsPDF is not defined. Make sure the library is loaded.");
            }
        }

        // Attach the exportToPDF function to the button click event
        $(document).ready(function() {
            $('#exportButton').click(function() {
                exportToPDF();
            });
        });
    </script>
@endpush
