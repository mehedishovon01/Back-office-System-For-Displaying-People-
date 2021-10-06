@extends('layouts.master')
@section('title', 'Inventory Reports')
@section('page-header')
    <i class="fa fa-list"></i> Inventory Reports
@stop
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/custom_css/chosen-required.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
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
                                <a href="{{ request()->url() }}" class="dt-button btn btn-white btn-primary btn-bold"
                                    title="Refresh Data" data-toggle="tooltip">
                                    <span>
                                        <i class="fa fa-refresh bigger-110"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space"></div>
                <div class="row">
                    <div class="col-sm-12 px-5">
                            <form action="" method="get">
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <td width="20%" class="no-print ">
                                            <label class="control-label">Category</label>
                                            <select name="category_id" id="fk_category_id" class="form-control chosen-select">
                                                <option value=""> All Category</option>
                                                @foreach ($categories as $key => $category)
                                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td width="20%" class="no-print ">
                                            <label class="control-label">Product Name</label>
                                            <input type="text" name="product_name" value="{{ request('product_name') }}" class="form-control" autocomplete="off">
                                        </td>

                                        {{-- @if ($settings->where('title', 'Product Subcategory')->where('options', 'yes')->count() < 1) --}}
                                            <td width="10px" class="no-print ">
                                                <div class="btn-group btn-corner">
                                                    <button class="btn btn-md btn-primary" style="margin-top: 16px;"> <i class="fa fa-check"></i> Check </button>
                                                    <button type="button" class="btn btn-md btn-success" style="margin-top:16px;" onclick="window.print()">
                                                        <i class="fa fa-print"></i> Print
                                                    </button>
                                                </div>
                                            </td>
                                        {{-- @endif --}}
                                    </tr>
                                </table>
                            </form>
                    </div>
                </div>
                <!-- LIST -->
                <div class="row" style="width: 100%; margin: 0 !important;">
                    <div class="col-sm-12 px-2">
                        <table id="data-table" class="table table-bordered table-striped">
                            <thead>
                                <tr class="table-header-bg">
                                    <th class="text-center" style="color: white !important;" width="3%">Sl</th>
                                    <th class="pl-3" style="color: white !important;">Name</th>
                                    <th class="pl-3" style="color: white !important;">Code</th>
                                    <th class="pl-2" style="color: white !important;">Opening Qty</th>
                                    <th class="pl-2" style="color: white !important;">Sold Qty</th>
                                    <th class="pl-2" style="color: white !important;">Purchased Qty</th>
                                    <th class="pl-2" style="color: white !important;">Tranfer In Qty</th>
                                    <th class="pl-2" style="color: white !important;">Transfer Out Qty</th>
                                    <th class="pl-2" style="color: white !important;">Wastage Qty</th>
                                    <th class="pl-2" style="color: white !important;">Available Qty</th>
                                    <th class="pl-3" style="color: white !important;">Cost</th>
                                    <th class="pl-3" style="color: white !important;">Value</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $total_opening_quantity = 0;
                                    $total_purchase_quantity = 0;
                                    $total_sold_quantity = 0;
                                    $total_available_quantity = 0;
                                    $total_wastage_quantity = 0;
                                    $total_transfer_in_quantity = 0;
                                    $total_transfer_out_quantity = 0;
                                    $subtotal_price = 0;
                                @endphp
                                @foreach ($products as $item)
                                    @php
                                        $total_opening_quantity += $opening_quantity = $item->opening_qty;
                                        $total_purchase_quantity += $purchase_quantity = $item->purchased_qty;
                                        $total_sold_quantity += $sold_quantity = $item->sold_qty;
                                        $total_available_quantity += $available_quantity = $item->available_qty ?? 0;
                                        $total_wastage_quantity += $wastage_quantity = $item->wastage_qty ?? 0;
                                        $total_transfer_in_quantity += $transfer_in_quantity = $item->transfer_in_qty ?? 0;
                                        $total_transfer_out_quantity += $transfer_out_quantity = $item->transfer_out_qty ?? 0;
                                        $subtotal_price += $subtotal = $item->product_cost * $available_quantity;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $item->product_name }}</td>
                                        <td class="text-center">{{ $item->invoiceId }}</td>
                                        <td class="text-center">{{ $opening_quantity }}</td>
                                        <td class="text-center">{{ $sold_quantity }}</td>
                                        <td class="text-center">{{ $purchase_quantity }}</td>
                                        <td class="text-center">{{ $transfer_in_quantity }}</td>
                                        <td class="text-center">{{ $transfer_out_quantity }}</td>
                                        <td class="text-center">{{ $wastage_quantity }}</td>
                                        <td class="text-center">{{ $available_quantity }}</td>
                                        <td class="pl-3">{{ $item->product_cost }}</td>
                                        <td class="text-right">{{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Total this page:</th>
                                    <th class="text-center">{{ $total_opening_quantity }}</th>
                                    <th class="text-center">{{ $total_sold_quantity }}</th>
                                    <th class="text-center">{{ $total_purchase_quantity }}</th>
                                    <th class="text-center">{{ $total_transfer_in_quantity }}</th>
                                    <th class="text-center">{{ $total_transfer_out_quantity }}</th>
                                    <th class="text-center">{{ $total_wastage_quantity }}</th>
                                    <th class="text-center">{{ $total_available_quantity }}</th>
                                    <th colspan="2" class="text-right">{{ number_format($subtotal_price, 2) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="11">Grand Total:</th>
                                    <th class="text-right">{{ number_format($total_product_price, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @include('partials._paginate',['data'=>$products])
                </div>
               
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
    <script src="{{ asset('assets/custom_js/chosen-box.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
    
    <script src="{{ asset('assets/custom_js/confirm_delete_dialog.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.bootstrap.min.js') }}"></script>


    <script type="text/javascript">
        // jQuery(function($) {
        //     $('#data-table').DataTable({
        //         "ordering": false,
        //         "bPaginate": true,
        //         "lengthChange": false,
        //         "info": false,
        //         "pageLength": 25
        //     });
        // })
    </script>
@endsection
