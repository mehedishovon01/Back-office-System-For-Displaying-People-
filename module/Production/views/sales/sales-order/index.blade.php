@extends('layouts.master')
@section('title','Stock In Hand')

@section('page-header')
<i class="fa fa-list"></i> Sales Order List
@stop
<!-- <i class="fa fa-list"></i> Inventory Reports -->

@section('css')

<link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}" />
@stop


@section('content')


<div class="page-header">
    <h1>
        @yield('page-header')&nbsp;
        <span style="font-size: 15px;">(<b>{{ $sale_prod->total() }} </b>Records Found, page <b>{{ request('page') ?? 1 }}</b> of <b>{{ $sale_prod->lastPage() }}</b>, Data Show per page <b>{{ $sale_prod->perPage() }}</b> ) </span>
    </h1>
</div>


<div class="row">
    <form class="form-horizontal" action="" method="get">

        <div class="col-sm-12">
            <table class="table table-bordered">

                <tr>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">Customer</span>
                            <select required id="customer_id" name="customer_id" class="chosen-select-100-percent" data-placeholder="- Select Company Name -">
                                <option></option>
                                @foreach($customer as $key => $name)
                                <option value="{{ $key }}" {{ request()->customer_id == $key ? 'selected':'' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>

                    <td width="350px">
                        <div class="input-group">
                            <input type="text" class="form-control input-sm date-picker" name="from_date" value="{{ request('from_date') }}" autocomplete="off">
                            <span class="input-group-addon">From|To</span>
                            <input type="text" class="form-control input-sm date-picker" name="to_date" value="{{ request('to_date') }}" autocomplete="off">
                        </div>
                    </td>


                    <td width="180px">
                        <div class="btn-group btn-corner">
                            <button class="btn btn-xs btn-primary"><i class="fa fa-search"></i> Search</button>
                            <a href="{{ route('items_stock') }}" class="btn btn-xs btn-pink"><i class="fa fa-refresh"></i> Refresh</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="text-center" style="font-size:20px"><strong>Sales Order List</strong></td>
                </tr>

            </table>
        </div>
    </form>
</div>



<div class="clearfix"></div>

<div class="row">
    <div class="col-xs-12">
        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
            <thead>
                <tr style="background: #C9DAF8 !important; color:black !important">
                    <th>SL</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Invoice No</th>
                    <th class="text-right">Prev. Due</th>
                    <th class="text-right">Discount Price</th>
                    <th class="text-right">Total Price</th>
                    <th class="text-right">Payable Price</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($sale_prod as $key => $value)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $value->customer->name }}</td>
                    <td style="font-weight: bold !important;">{{ fdate($value->date) }}</td>
                    <td>{{ $value->invoice_no }}
                        <button type="button" class="btn btn-minier btn-pink" data-container="body" data-toggle="popover" data-rel="popover" data-placement="left"
                        data-original-title="<i class='ace-icon fa fa-info-circle green'></i> {{ count($value->productionSaleDetails) }} Products Exist"
                        data-content="
                        @foreach($value->productionSaleDetails as $details)
                        <p>{{ $loop->iteration }}. {{ $details->product->name }} 
                            <span class='label label-minier label-yellow arrowed-in-right'>{{ $details->assign_qty }}</span>
                            <span class='label label-minier label-yellow arrowed arrowed-right'>{{ $details->price }} Tk</span>
                            <span class='label label-minier label-yellow arrowed-in'>{{ $details->total_amount }} Tk</span></p><hr>
                        @endforeach
                        ">
                        <i class="fa fa-info-circle"></i>
                        </button>
                        <style>
                            hr { margin: 2px 0 2px 0; }
                        </style>
                    </td>
                    <td class="text-right">{{ $value->previous_due }}</td>
                    <td class="text-right">{{ $value->discount_amount }}</td>
                    <td class="text-right">{{ $value->total_amount }}</td>
                    <td class="text-right">{{ $value->payable_amount }}</td>
                    <td class="text-center">
                        <div class="reload">
                            @if( $value->is_approved == 0)
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-minier btn-danger dropdown-toggle" aria-expanded="true">
                                    Pending
                                    <i class="ace-icon fa fa-angle-down icon-on-right"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-info">
                                    <li>
                                        <a href="{{ route('is.confirmed', $value->id) }}">Confirm</a>
                                    </li>
                                </ul>
                            </div>
                            @else
                            <span class="label label-purple label-white middle">Confirmed</span>
                            @endif
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-corner action">
                            @include('partials._user-log', ['data' => $value])
                            <!-- <a href="{{ route('materials-assign.show', $value->id) }}" target="_blank" class="btn btn-success btn-xs" title="View Details"><i class="fa fa-eye"></i></a> -->
                            @if( $value->is_approved == 0)
                            <a href="{{ route('sales.edit', $value->id) }}" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-pencil"></i></a>
                            <a href="#" onclick="delete_item('{{ route('sales.destroy', $value->id) }}')" class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></a>
                            @endif
                        </div>

                        <!-- delete form -->
                        <form action="" id="deleteItemForm" method="POST">
                            @csrf
                            @method("DELETE")
                        </form>

                    </td>
                </tr>
                @endforeach
                @if (count($sale_prod) == 0)
                <tr>
                    <td colspan="6" class="text-center">
                        <b class="text-danger">No records found!</b>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
        @include('partials._paginate', ['data' => $sale_prod])


    </div>
</div>


@endsection

@section('js')

<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
<script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/ace-elements.min.js') }}"></script>
<script src="{{ asset('assets/js/ace.min.js') }}"></script>
<script src="{{ asset('assets/custom_js/confirm_delete_dialog.js') }}"></script>
<script src="{{ asset('assets/custom_js/chosen-box.js') }}"></script>

<script type="text/javascript">
    function exportData(url) {
        $('.exportForm').attr('action', url).submit();
    }
</script>


<!--  Select Box Search-->
<script type="text/javascript">
    const comppanyId = $('#company_id')
    const itemId = $('#item_id')
    const itemStockRoute = `{{ route('company-items') }}`

    $(function() {
        $('[data-toggle="popover"]').popover()
    })

    // data picker
    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
    });


    function loadCompanyItems() {
        let company_id = comppanyId.val()

        $.get(itemStockRoute, {
            company_id: company_id
        }, function(res) {
            itemId.empty()
            itemId.append('<option value="">-Select-</option>')
            res.forEach(function(item) {
                itemId.append('<option value="' + item.id + '">' + item.name + '</option>')
            })

            itemId.trigger('chosen:updated')
        });
    }
</script>


@stop