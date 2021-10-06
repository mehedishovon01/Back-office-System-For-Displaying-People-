@extends('layouts.master')
@section('title','Raw Materials Assign')
@section('page-header')
<i class="fa fa-list"></i> Raw Materials Assign Create
@stop
@push('style')
<link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
<style>
    .table {
        margin-bottom: 0 !important;
    }

    body {
        counter-reset: section;
        /* Set a counter named 'section', and its initial value is 0. */
    }

    .count:before {
        counter-increment: section;
        content: counter(section);
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
                            <a href="{{route('materials-assign.index')}}" class="dt-button btn btn-white btn-info btn-bold" title="Create New" data-toggle="tooltip" tabindex="0" aria-controls="dynamic-table">
                                <span>
                                    <i class="fa fa-list bigger-110"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space"></div>


            <!-- INPUTS -->
            <form action="{{ route('materials-assign.store') }}" method="post">
                @csrf
                <div class="row" style="width: 100%; margin: 0 0 20px !important;">
                    <div class="col-sm-12 px-4">
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="name"> <b>Date</b> </label>
                            <div class="col-sm-9">
                                <input required name="date" class="form-control date-picker" id="id-date-picker-1" type="text" value="{{ date('Y-m-d') }}" data-date-format="yyyy-mm-dd">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="name"> <b>Company Name</b> </label>
                            <div class="col-sm-9">
                                <select required id="company_id" name="company_id" class="chosen-select-100-percent" data-placeholder="- Select Company Name -">
                                    <option></option>
                                    @foreach($company as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="name"> <b>Factory Name</b> </label>
                            <div class="col-sm-9">
                                <select required id="factory_id" name="factory_id" class="chosen-select-100-percent" data-placeholder="- Select Factory Name -">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12">
                                <table id="myTable" class="table table-bordered order-list">
                                    <thead>
                                        <tr>
                                            <td width="40px;">SL.</td>
                                            <td>Product Name<span class="text-danger">*</span></td>
                                            <td class="text-right" width="120px;">Unit</td>
                                            <td class="text-right" width="120px;">Available Qty</td>
                                            <td class="text-right" width="120px;">Assign Qty</td>
                                            <td width="50px;"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="count"></td>
                                            <td>
                                                <div class="col-sm-12 prod-price">
                                                    <select required name="product_id[]" onchange="enableQty('quantity-enable', 'unit', 'quantity', 'hide-unitid', this)" class="input-qty input-sm chosen-select-100-percent" data-placeholder="- Select Account -">
                                                        <option></option>
                                                        @foreach($products as $data)
                                                        <option value="{{ $data['id'] }}" data-unit="{{ $data['unitName'] }}" data-unid="{{ $data['unitId'] }}" data-qty="{{ $data['qty'] }}">{{ $data['name'] }}</option>
                                                        @endforeach
                                                    </select>

                                                    @error('account_ids')
                                                    <span class="text-danger"> {{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </td>
                                            <td>
                                                <input name="unit[]" class="hide-unitid" type="hidden">
                                                <input readonly required type="text" onkeypress="return checkOnlyNumber(event)" class="form-control input-sm text-right unit" />
                                                @error('credit')
                                                <span class="text-danger"> {{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input name="available_quantity[]" readonly required type="text" onkeypress="return checkOnlyNumber(event)" class="form-control input-sm text-right quantity" />
                                                @error('credit')
                                                <span class="text-danger"> {{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input required name="assign_qty[]" disabled type="text" onkeypress="return checkOnlyNumber(event)" class="form-control input-sm text-right quantity-enable calculate-qty" />
                                                @error('credit')
                                                <span class="text-danger"> {{ $message }}</span>
                                                @enderror
                                            </td>
                                            <td class="text-center"><a class="btn btn-sm btn-danger" disabled="disabled"><i class="fa fa-trash"></i></a></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td>
                                                <button type="button" class="btn btn-minier btn-success pull-right" id="addrow">
                                                    + Add More
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <!-- Submit -->
                        <div class="pull-right mt-5">
                            <button id="draft" class="btn btn-sm btn-primary save-btn">
                                Draft
                                <i class="fa fa-file"></i>
                                <input type="hidden" name="draft" class="draft-value" value="0">
                            </button>
                            <button type="submit" class="btn btn-sm btn-success save-btn">
                                <i class="fa fa fa-save"></i>
                                Save With Approve
                            </button>
                        </div>
                    </div>
                </div>
            </form>

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
<script>
    const rowItem = `<tr>
                        <td class="count"></td>
                        <td>
                            <div class="col-sm-12 prod-price">
                                <select required name="product_id[]" onchange="enableQty('quantity-enable', 'unit', 'quantity', 'hide-unitid', this)" class="input-qty input-sm chosen-select-100-percent" data-placeholder="- Select Account -">
                                    <option></option>
                                    @foreach($products as $data)
                                        <option value="{{ $data['id'] }}" data-unit="{{ $data['unitName'] }}" data-unid="{{ $data['unitId'] }}" data-qty="{{ $data['qty'] }}">{{ $data['name'] }}</option>
                                    @endforeach
                                </select>

                                @error('account_ids')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </td>
                        <td>
                            <input name="unit[]" class="hide-unitid" type="hidden">
                            <input readonly required type="text" onkeypress="return checkOnlyNumber(event)" class="form-control input-sm text-right unit" />
                            @error('credit')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </td>
                        <td>
                            <input name="available_quantity[]" readonly required type="text" onkeypress="return checkOnlyNumber(event)" class="form-control input-sm text-right quantity" />
                            @error('credit')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </td>
                        <td>
                            <input name="assign_qty[]" disabled type="text" onkeypress="return checkOnlyNumber(event)" class="form-control input-sm text-right quantity-enable calculate-qty" />
                            @error('credit')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </td>
                        <td class="text-center"><a class="btn btn-sm btn-danger ibtnDel"><i class="fa fa-trash"></i></a></td>
                    </tr>`


    function enableQty($qty, $unit, $availableQty, $hideUnitID, object) {
        let getUnit = $(object).find('option:selected').data('unit')
        let getUnitID = $(object).find('option:selected').data('unid')
        let getQty = $(object).find('option:selected').data('qty')
        let showUnit = $(object).closest('tr').find('.' + $unit)
        let qty = $(object).closest('tr').find('.' + $qty)
        let availableQty = $(object).closest('tr').find('.' + $availableQty)
        let hideUnitID = $(object).closest('tr').find('.' + $hideUnitID)

        availableQty.val(getQty)
        showUnit.val(getUnit)
        hideUnitID.val(getUnitID)
        qty.attr('disabled', false)
    }

    $(".calculate-qty").each(function() {
        $(document).on("keyup", ".calculate-qty", function() {
            let getQty = parseInt($('.quantity').val(), 10)
            if (getQty >= $(this).val()) {
                return true
            } else {
                $(this).focus();
                alert("Assign Quantity Should Be Less Than Available Quantity. Please Try Again.");
                $(this).val('');
            }
            console.log(getQty)
        });
    });

    function checkOnlyNumber(evnt) {
        let keyCode = evnt.charCode
        let str = evnt.target.value
        let n = str.includes(".")

        if (keyCode == 13) {
            evnt.preventDefault();
        }
        if (keyCode == 46 && n) {
            return false
        }
        if (str.length > 12) {
            showAlertMessage('Number length out of range', 3000)
            calculateAmount()
            return false
        }
        return (keyCode >= 48 && keyCode <= 57) || keyCode == 13 || keyCode == 46
    }

    $(document).ready(function() {
        var i = 0;
        $("#addrow").on("click", function() {
            $("table.order-list").append(rowItem)
            chosenSelectInit()
            i++;
        });

        $("table.order-list").on("click", ".ibtnDel", function(event) {
            $(this).closest("tr").remove();
            i -= 1
            calculateAmount()
        });
    });

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

    var btn = document.getElementById("draft");
    btn.addEventListener("click", function() {
        // console.log("The function just got executed!");
        $(".draft-value").val(1);
    }, false);
</script>
<script>
    $(document).ready(function() {
        const factoryId = $('#factory_id');

        $('#company_id').change(function() {
            console.log($(this).val())
            $.get(`{{route('ajax.factories')}}?company_id=${$(this).val()}`, function(res) {
                factoryId.empty().append('<option></option>')

                res.forEach(function(item) {
                    factoryId.append(`<option value="${item.id}">${item.name}</option>`)
                })

                factoryId.trigger('chosen:updated');
            })
        })
    });
</script>
@endsection