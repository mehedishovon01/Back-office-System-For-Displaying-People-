@extends('layouts.master')
@section('title','GRN List')
@section('page-header')
    <i class="fa fa-list"></i> GRN List
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
    <style>
        .bg-dark{
            background-color: #C9DAF8;
        }

    </style>
@stop


@section('content')

    <div class="page-header">

        @if(hasPermission("purchases.create", $slugs))
            <a class="btn btn-xs btn-info" href="{{ route('purchases.create') }}" style="float: right; margin: 0 2px;"> <i class="fa fa-plus"></i> Add @yield('title') </a>
        @endif

        @if(hasPermission("purchases.create", $slugs))
            <a class="btn btn-xs btn-success" href="{{ route('purchases.index') }}" style="float: right; margin: 0 2px;"> <i class="fa fa-list"></i> Purchase List </a>
        @endif
        <h1>@yield('page-header')</h1>
    </div>

    @include('partials._alert_message')
    <div class="row">
        <form class="form-horizontal" action="{{ route('grn.list') }}" method="get">
            @csrf
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <tr>
                        <th class="bg-dark">Company</th>
                        <th class="bg-dark">From - To</th>
                        <th class="bg-dark">GRN No</th>
                        <th class="bg-dark">Purchase No</th>
                        <th class="bg-dark text-center">Action</th>
                    </tr>
                    <tr>
                        <td>
                            <select name="company_id" class="form-control chosen-select">
                                <option selected value="">- Select Company -</option>
        
                            </select>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="text" class="form-control input-sm date-picker" name="from_date" value="{{ request('from_date') }}" autocomplete="off">
                                <span class="input-group-addon">From|To</span>
                                <input type="text" class="form-control input-sm date-picker" name="to_date" value="{{ request('to_date') }}" autocomplete="off">
                            </div>
                        </td>
                        <td>
                            <input type="text" class="form-control input-sm" name="grn_no" value="{{ request('grn_no') }}" style="max-width: 145px !important;" placeholder="GRN No">
                        </td>
                        <td>
                            <input type="text" class="form-control input-sm" name="purchase_number" value="{{ request('purchase_number') }}" style="max-width: 145px !important;" placeholder="Purchase No">
                        </td>
                        <td class="text-right">
                            <div class="btn-group btn-corner">
                                <button class="btn btn-xs btn-primary"><i class="fa fa-search"></i> Search</button>
                                <a href="{{ route('grn.list') }}" class="btn btn-xs btn-pink"><i class="fa fa-refresh"></i> Refresh</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>


    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr style="background: #C9DAF8 !important; color:black !important">
                        <th>SL</th>
                        <th>Date</th>
                        <th>GRN No.</th>
                        <th>Date</th>
                        <th>Purchase Number</th>
                        <th>Company</th>
                        <th>Required Qty</th>
                        <th>Received Qty</th>
                        <th>Challan Number</th>
                        <th>Received By</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>



                        <tr>
                            <td colspan="11" class="text-center">
                                <b class="text-danger">No data found!</b>
                            </td>
                        </tr>
                </tbody>
            </table>



                <div class="pull-left" style="margin-top:10px; margin-left:10px">
                    <span onclick="exportData('{{ url('export-gs-as-excel') }}')" style="margin-right: 5px; cursor: pointer;">
                        <img src="{{ asset('assets/images/export-icons/excel-icon.png') }}">
                    </span>
                    <span onclick="exportData('{{ url('export-gs-as-pdf') }}')" style="margin-right: 5px; cursor: pointer;">
                        <img src="{{ asset('assets/images/export-icons/pdf-icon.png') }}">
                    </span>
                </div>

                <form class="exportForm" method="POST">
                    @csrf
                    <input type="hidden" name="model" value="GRN List">
                    <input type="hidden" name="company_id" value="{{ request('company_id') }}">
                    <input type="hidden" name="from_date" value="{{ request('from_date') }}">
                    <input type="hidden" name="to_date" value="{{ request('to_date') }}">
                    <input type="hidden" name="grn_no" value="{{ request('grn_no') }}">
                    <input type="hidden" name="purchase_number" value="{{ request('purchase_number') }}">
                </form>


        </div>
    </div>



        <div id="purchase-receive-details" class="modal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="blue bigger"><i class="fa fa-eye"></i> View Purchase Receive Details</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <dl id="dt-list-1" class="dl-horizontal">
                                    <p class="text-center">Date :</p>
                                    <p class="text-center">Purchase Number : </p>
                                    <p class="text-center">GRN Number : </p>
                                    {{--                                <p class="text-center">Company : </p>--}}

                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Items</th>
                                            <th>Item Unit</th>
                                            <th>Vendor</th>
                                            <th>Remarks</th>
                                            <th>Required Qty</th>
                                            <th>Received Qty</th>
                                            <th>Rate</th>
                                            <th>Total</th>
                                        </tr>
                         
                                        <tr>
                                            <td colspan="4">Total</td>
                                            <td></td>
                                            <td colspan="2"></td>
                                            <td class="text-right"></td>
                                        </tr>
                                    </table>

                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-sm" data-dismiss="modal">
                            <i class="ace-icon fa fa-times"></i>
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>


@endsection

@section('js')

    <script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>

    

    <!-- printThis -->
    <script src="{{ asset('assets/js/printThis.js') }}"></script>
    <script type="text/javascript">
        function printReceive (receiveNumber) {
            $('#purchase-receive-details'+receiveNumber).printThis({
                importCSS: true
            });
            // $('#purchase-receive-details'+receiveNumber).printThis({
            //     importCSS: true,
            // });
        }
    </script>

    <script type="text/javascript">
        function exportData(url)
        {
            $('.exportForm').attr('action', url).submit();
        }
    </script>

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
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

    <!--  Select Box Search-->
    <script type="text/javascript">

        jQuery(function($){

            if(!ace.vars['touch']) {
                $('.chosen-select').chosen({allow_single_deselect:true});
                //resize the chosen on window resize

                $(window)
                    .off('resize.chosen')
                    .on('resize.chosen', function() {
                        $('.chosen-select').each(function() {
                            var $this = $(this);
                            $this.next().css({'width': '200px'});
                        })
                    }).trigger('resize.chosen');
                //resize chosen on sidebar collapse/expand
                $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
                    if(event_name != 'sidebar_collapsed') return;
                    $('.chosen-select').each(function() {
                        var $this = $(this);
                        $this.next().css({'width':'200px'});
                    })
                });
            }

        })
    </script>

    <!--datepicker plugin-->
    <script type="text/javascript">
        jQuery(function($) {

            $('.date-picker').datepicker({
                autoclose: true,
                format:'yyyy-mm-dd',
                todayHighlight: true
            })
                //show datepicker when clicking on the icon
                .next().on(ace.click_event, function(){
                $(this).prev().focus();
            });

        })
    </script>
@stop
