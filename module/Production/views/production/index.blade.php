@extends('layouts.master')
@section('title','Production')
@section('page-header')
<i class="fa fa-list"></i> Production List
@stop
@push('style')
<link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
<style>
    .table {
        margin-bottom: 0 !important;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-sm-12">

        @include('partials._alert_message')

        <!-- heading -->
        <div class="widget-box widget-color-white ui-sortable-handle clearfix" id="widget-box-7">
            <div class="widget-header widget-header-small">
                <h3 class="widget-title smaller text-primary">
                    @yield('page-header')
                </h3>

                <div class="widget-toolbar border smaller" style="padding-right: 0 !important">
                    <div class="pull-right tableTools-container" style="margin: 0 !important">
                        <div class="dt-buttons btn-overlap btn-group">
                            <a href="{{request()->url()}}" class="dt-button btn btn-white btn-primary btn-bold" title="Refresh Data" data-toggle="tooltip">
                                <span>
                                    <i class="fa fa-refresh bigger-110"></i>
                                </span>
                            </a>
                            <a href="{{route('production.create')}}" class="dt-button btn btn-white btn-info btn-bold" title="Create New" data-toggle="tooltip" tabindex="0" aria-controls="dynamic-table">
                                <span>
                                    <i class="fa fa-plus bigger-110"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space"></div>

            <!-- LIST -->
            <div class="row" style="width: 100%; margin: 0 !important;">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="table-header-bg">
                                <th class="" style="color: white !important;">Sl</th>
                                <th class="" style="color: white !important;">Name</th>
                                <th class="" style="color: white !important;">Category</th>
                                <th class="" style="color: white !important;">Unit</th>
                                <th class="" style="color: white !important;">Sale Price</th>
                                <th class="text-center" style="color: white !important;">Qty</th>
                                <th class="" style="color: white !important;">Factory Name</th>
                                <th class="text-center" style="color: white !important;">Status</th>
                                <th class="text-center" style="color: white !important;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($production as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $value->product_name }}</td>
                                <td>
                                    @if($value->category)
                                    {{ $value->category->name }}
                                    @endif
                                </td>
                                <td>
                                    @if($value->category)
                                    {{ $value->unit->name }}
                                    @endif
                                </td>
                                <td>{{ $value->product_price }}</td>
                                <td>{{ $value->opening_quantity }}</td>
                                <td>{{ $value->factory->name }}</td>
                                <td class="text-center">
                                    @if($value->is_approved == 1)
                                    <span class="btn btn-primary btn-minier">Approved</span>
                                    @else
                                    <div class="btn-group">
                                        <button data-toggle="dropdown" class="btn btn-minier btn-danger dropdown-toggle" aria-expanded="true">
                                            Unapproved
                                            <i class="ace-icon fa fa-angle-down icon-on-right"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-info">
                                            <li>
                                                <a href="{{ route('production.approve', $value->id) }}">Approve</a>
                                            </li>
                                        </ul>
                                    </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-corner">
                                        @include('partials._user-log', ['data' => $value])

                                        <a href="" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square"></i></a>

                                        <a href="#" onclick="delete_item('')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection

@section('js')
<script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/custom_js/confirm_delete_dialog.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/custom_js/chosen-box.js') }}"></script>
<script>
    jQuery(function($) {
        $('#id-input-file-3').ace_file_input({
            style: 'well',
            btn_choose: 'Drop files here or click to choose',
            btn_change: null,
            no_icon: 'ace-icon fa fa-cloud-upload',
            droppable: true,
            thumbnail: 'small' //large | fit

        }).on('change', function() {
            //console.log($(this).data('ace_input_files'));
            //console.log($(this).data('ace_input_method'));
        });

        // Start header, footer
        $('#header').ace_file_input({
            style: 'well',
            btn_choose: 'Drop files here or click to choose',
            btn_change: null,
            no_icon: 'ace-icon fa fa-cloud-upload',
            droppable: true,
            thumbnail: 'small' //large | fit
        });
        $('#footer').ace_file_input({
            style: 'well',
            btn_choose: 'Drop files here or click to choose',
            btn_change: null,
            no_icon: 'ace-icon fa fa-cloud-upload',
            droppable: true,
            thumbnail: 'small' //large | fit
        });
        // End header, footer
    });

    function approved($reload, object) {
        let action = $(object).closest('td').find('.action');
        let id = $(object).data('id')
        var url = "{{ route('is.approved', ": id ") }}";
        url = url.replace(':id', id);
        $.ajax({
            type: 'get',
            url: url,
            success: function(status) {
                $(object).closest('td').html('<span class="label label-info">Approved</span>')
            },
            error: function(status) {
                // console.log('something went wrong - debug it!');
            }
        });
    }
</script>
@endsection