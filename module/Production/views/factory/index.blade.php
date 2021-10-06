@extends('layouts.master')
@section('title','Factory')
@section('page-header')
<i class="fa fa-list"></i> Factory List
@stop
@push('style')
<link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
<style>
    .table {
        margin-bottom: 0 !important;
    }

    select:invalid {
        height: 0px !important;
        opacity: 0 !important;
        position: absolute !important;
        display: flex !important;
    }

    select:invalid[multiple] {
        margin-top: 15px !important;
    }
</style>
@endpush

@section('content')
<div class="space"></div>

<div class="row">
    <div class="col-sm-7">

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
                        </div>
                    </div>
                </div>
            </div>
            <div class="space"></div>


            <!-- LIST -->
            <div class="row" style="width: 100%; margin: 0 !important;">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th class="bg-dark" width="20px;">SL</th>
                                <th class="bg-dark">Factory Name</th>
                            </tr>
                            @foreach($company as $value)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <ul>
                                        <li> 
                                        <span class="tree-label">{{ $value->name }}</span></div>
                                            @foreach($value->factory_name as $factory)
                                            <ul class="pb-1 tree-branch-children" role="group">
                                               <i class="menu-icon fa fa-caret-right"></i> {{ $factory->name }}
                                               <a href="{{ route('factories.edit', $factory->id) }}" class="btn btn-primary btn-minier" title="Edit"><i class="fa fa-pencil"></i></a>
                                                <a href="#" onclick="delete_item('{{ route('factories.destroy', $factory->id) }}')" class="btn btn-danger btn-minier" title="Delete"><i class="fa fa-trash"></i></a>
                                            </ul>
                                            @endforeach
                                            <div class="tree-loader hidden" role="alert">
                                                <div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="space"></div>
        </div>
    </div>

    <div class="col-sm-5">
        @include('partials._alert_message')
        <!-- heading -->
        <div class="widget-box widget-color-white ui-sortable-handle clearfix" id="widget-box-7">
            <div class="widget-header widget-header-small">
                <h3 class="widget-title smaller text-primary">
                    Add Factory
                </h3>
            </div>
            <div class="space"></div>

            <!-- LIST -->
            <div class="row" style="width: 100%; margin: 0 !important;">
                <div class="col-sm-12">
                    <form action="{{ route('factories.store') }}" method="post">
                        @csrf
                        <div>
                            <label for="form-field-8">Company Name</label>
                            <select required name="company_id" class="chosen-select-100-percent" data-placeholder="- Select Company -" style="display: none;">
                                <option></option>
                                @foreach($company as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div>
                            <label for="form-field-8">Factory Name</label>
                            <input required name="name" class="form-control" placeholder="Factory Name">
                        </div>
                        <br>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-sm btn-success">
                                Submit
                                <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="space"></div>
        </div>
    </div>


</div>

<!-- delete form -->
<form action="" id="deleteItemForm" method="POST">
    @csrf @method("DELETE")
</form>

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
</script>
@endsection