@extends('layouts.master')
@section('title','Assign Materials Details')
@section('page-header')
<i class="fa fa-list"></i> Assign Materials Details
@stop
@push('style')
<link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
<style>


    p {
        margin-bottom: 0 !important;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-sm-12">

        @include('partials._alert_message')

        <!-- heading -->
        <div class="widget-box widget-color-white ui-sortable-handle clearfix" id="widget-box-7" style="width: 90%; margin-left: 5%; margin-top: 30px">
            <div class="widget-header widget-header-small">
                <h3 class="widget-title smaller text-primary">
                    @yield('page-header')
                </h3>

                <div class="widget-toolbar border smaller" style="padding-right: 0 !important">
                    <div class="pull-right tableTools-container" style="margin: 0 !important">
                        <div class="dt-buttons btn-overlap btn-group">
                            <a href="{{route('materials-assign.index')}}" class="dt-button btn btn-white btn-primary btn-bold" title="Refresh Data" data-toggle="tooltip">
                                <span>
                                    <i class="fa fa-list bigger-110"></i>
                                </span>
                            </a>

                            <a href="{{route('materials-assign.create')}}" class="dt-button btn btn-white btn-info btn-bold" title="Create New" data-toggle="tooltip" tabindex="0" aria-controls="dynamic-table">
                                <span>
                                    <i class="fa fa-plus bigger-110"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space"></div>

            <div class="row px-2 pb-3">
                <div class="col-md-8">
                    <p><span >Company Name: {{ $data->company->name }}</span></p>
                    <p><span>Factory Name: {{ $data->factories->name }}</span></p>
                </div>
                <div class="col-md-4">
                    <div style="width: 255px; float: right">
                        <p><span>Invoice No: {{ $data->invoice_no }}</span></p>
                        <p><span>Date: {{ $data->date }}</span> </p>
                    </div>
                </div>
            </div>

            <!-- LIST -->
            <div class="row" style="width: 100%; margin: 0 !important;">
                <div class="col-sm-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="table-header-bg">
                                <th class="text-center" style="color: white !important;" width="4%">Sl</th>
                                <th class="pl-3" style="color: white !important;" width="60%">Product Name</th>
                                <th class="pl-3" style="color: white !important;" width="10%">Unit</th>
                                <th class="pl-3" style="color: white !important;" width="10%">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data->materialDetails as $value)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="pl-3">{{ $value->product->name }}</td>
                                <td class="pl-3">{{ $value->unitName->name }}</td>
                                <td class="pl-3">{{ $value->assign_qty }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if(request()->routeIs('journal.approve.show') && !$data->is_approved)
            <div class="row" style="width: 100%; margin: 0 !important; padding-bottom: 15px">
                <div class="col-md-12 text-right">
                    <form action="" method="post">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check-circle"></i> Approve</button>
                    </form>
                </div>
            </div>
            @endif
            <!-- <div class="row" style="width: 100%; margin: 0 !important; padding-bottom: 15px">
                <div class="col-md-12 text-right">
                    <a href="" target="_blank" class="btn btn-sm btn-primary"><i class="ace-icon fa fa-print bigger-100"></i> Print</a>
                </div>
            </div> -->
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
@endsection