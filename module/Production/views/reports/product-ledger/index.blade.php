@php
function getModelValue($model)
{
    $models = ['Module\PosErp\Models\SaleDetails', 'Module\PosErp\Models\PurchaseDetails', 'Module\PosErp\Models\SaleReturnDetails', 'Module\PosErp\Models\PurchaseReturnDetails'];
    $values = ['Sale', 'Purchase', 'Sale Return', 'Purchase Return'];

    $index = array_search($model, $models);
    return $values[$index] ?? str_replace('Module\PosErp\Models\\', '', $model);
}

$from   = request('from', date('Y-m-d'));
$to     = request('to', date('Y-m-d'));
$quantity = $openingQty ?? 0;
@endphp

@extends('layouts.master')
@section('title', 'Product Ledger')
@section('page-header')
    <i class="fa fa-list"></i> Product Ledger
@stop
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}" />
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

                                @if (hasPermission('pos_erp.products.create', $slugs))
                                    <a href="{{ route('pos_erp.products.create') }}"
                                        class="dt-button btn btn-white btn-info btn-bold" title="Create New"
                                        data-toggle="tooltip" tabindex="0" aria-controls="dynamic-table">
                                        <span>
                                            <i class="fa fa-plus bigger-110"></i>
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space"></div>
                <div class="row px-3 pb-2" style="width: 100%; margin: 0 !important;">
                    <form action="" method="get">
                        <div class="col-sm-4">
                            @include('includes.input-groups.date-range', ['date1' => $from, 'date2' => $to, 'is_read_only'
                            => true])
                        </div>
                        <div class="col-sm-3">
                            <select name="product_id" id="product_id" class="select-sm form-control chosen-select">
                                @foreach ($products ?? [] as $key => $item)
                                    <option value="{{ $key }}"
                                        {{ request('product_id') == $key ? 'selected' : '' }}>
                                        {{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <div class="btn-group btn-corner">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"
                                        style="font-family: FontAwesome, Bangla220, sans-serif;"></i> Search</button>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- LIST -->
                <div class="row" style="width: 100%; margin: 0 !important;">
                    <div class="col-sm-12 px-2">
                        <table id="data-table" class="table table-bordered table-striped">
                            <thead>
                                <tr class="table-header-bg">
                                    <th class="text-center" style="color: white !important;" width="8%">Sl</th>
                                    <th class="pl-3" style="color: white !important;">Date</th>
                                    <th class="pl-3" style="color: white !important;">Description</th>
                                    <th class="pl-3" >Out</th>
                                    <th class="pl-3" >In</th>
                                    <th class="text-right" style="color: white !important;">Quantity</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th colspan="5">Opening Quantity</th>
                                    <th class="text-right">{{ $quantity }}</th>
                                </tr>
                                @foreach ($product_ledgers ?? [] as $item)
                                    @php
                                        $quantity = $quantity + ($item->in - $item->out);
                                    @endphp

                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="pl-3">{{ \Carbon\Carbon::parse($item->date)->format('Y-m-d') }}</td>
                                        <td class="pl-3">
                                            {{ getModelValue($item->product_transactionable_type) }}
                                        </td>
                                        <td  class="pl-3">{{ $item->out > 0 ? $item->out : '' }}</td>
                                        <td  class="pl-3">{{ $item->in>0 ? $item->in : '' }}</td>
                                        <td class="text-right">{{ $quantity ?? 0 }}</td>
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
    <script src="{{ asset('assets/custom_js/date-picker.js') }}"></script>


@endsection
