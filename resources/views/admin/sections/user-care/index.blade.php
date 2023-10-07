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
                <div class="actions">
                    <button class="btn btn-sm btn-primary" onclick="exportUserData()">
                        <i class="fas fa-file-export"></i>
                        {{ __("Export Data") }}
                    </button>
                </div>
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
        itemSearch($("input[name=user_search]"),$(".user-search-table"),"{{ setRoute('admin.users.search') }}");
        
        function exportUserData() {

            // export the users table to pdf
            var doc = new jsPDF('p', 'pt');
            var elem = document.getElementById("user-table");
            var res = doc.autoTableHtmlToJson(elem);
            doc.autoTable(res.columns, res.data, {
                startY: 60,
                theme: 'grid',
                styles: {
                    overflow: 'linebreak',
                    fontSize: 8,
                    cellPadding: 5,
                    overflowColumns: 'linebreak',
                    halign: 'center',
                    valign: 'middle',
                }
            });
            doc.save("users.pdf");
            
        }

    </script>
@endpush
