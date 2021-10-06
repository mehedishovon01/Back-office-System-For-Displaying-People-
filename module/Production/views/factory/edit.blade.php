@extends('layouts.master')

@section('title',' User')
@section('page-header')
<i class="fa fa-gears"></i> Edit Factories
@stop
@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}" />
@stop


@section('content')

<div class="page-header">
    <h1>
        <i class="fa fa-info-circle green"></i> Edit Factoryies
    </h1>
</div>

@include('partials._alert_message')

<div class="row">
    <div class="col-xs-6">
        <div class="col-sm-12">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title"> @yield('page-header')</h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main no-padding">

                        <div>
                            @include('partials._alert_message')
                        </div>

                        <div class="row" style="width: 100%; margin: 0 !important;">
                            <div class="col-sm-12">
                                <form class="form-horizontal" id="companyForm" action="{{ route('factories.update', $factory->id) }}" method="post">
                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label for="form-field-8">Company Name</label>
                                        <select required name="company_id" class="chosen-select-100-percent" data-placeholder="- Select Company -" style="display: none;">
                                            <option></option>
                                            @foreach($company as $value)
                                            <option value="{{ $value->id }}" {{ $value->id == $factory->company_id ? 'selected' : '' }}>{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    <div>
                                        <label for="form-field-8">Factory Name</label>
                                        <input required name="name" class="form-control" value="{{ $factory->name }}"><br>
                                    </div>

                                    <div class="pb-2 center" style="text-align: right !important;">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="ace-icon fa fa-save icon-on-right bigger-110"></i>
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
    }); <
    !--inline scripts related to this page-- >
    <
    script type = "text/javascript" >
        function delete_check(id) {
            Swal.fire({
                title: 'Are you sure ?',
                html: "<b>You want to delete permanently !</b>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                width: 400,
            }).then((result) => {
                if (result.value) {
                    $('#deleteCheck_' + id).submit();
                }
            })

        }
</script>
@stop