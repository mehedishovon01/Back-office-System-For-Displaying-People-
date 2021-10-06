<?php

namespace Module\Production\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Exception;
use Module\Production\Models\ProductionSales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\Account\Models\Category;
use Module\Account\Models\Customer;
use Module\Account\Models\Product;
use Module\PosErp\Services\ProductService;
use Module\Production\Models\Factory;
use Module\Production\Models\ProductionSaleDetails;
use Module\Production\Services\IndexDataServices;
use Module\Production\Services\InvoiceNumberService;

class ProductionSalesController extends Controller
{
    private $indexService;
    private $invoiceNumberService;

    public function __construct()
    {
        $this->indexService = new IndexDataServices();
        $this->invoiceNumberService = new InvoiceNumberService();
        $this->service = new ProductService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['customer'] = Customer::pluck('name', 'id');
        if($request->customer_id){
            $data['sale_prod'] = ProductionSales::where('type', 'sales')->where('customer_id', $request->customer_id)->orwhereDate('date', [$request->from_date, $request->to_date])->paginate(20);
        }else{
            $data['sale_prod'] = ProductionSales::where('type', 'sales')->paginate(20);
        }
        
        return view('sales.sales.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['company'] = $this->indexService->getCompany();
        $data['customer'] = Customer::orderBy('name')->pluck('name', 'id');
        $data['products'] = $this->indexService->getManufacturedProdforSales();

        return view('sales.sales.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $store = ProductionSales::query()->create([
                'company_id' => $request->company_id,
                'customer_id' => $request->customer_id,
                'date' => $request->date,
                'is_approved' => 0,
                'discount_amount' => $request->discount_amount,
                'previous_due' => $request->previous_due,
                'total_amount' => $request->total_amount,
                'payable_amount' => $request->payable_amount,
                'type' => $request->type

            ]);
            $store->update([
                'invoice_no' => $this->invoiceNumberService->getSaleProductionInvoiceNo($store->company_id),
            ]);
            $this->invoiceNumberService->setNextInvoiceNo($store->company_id, 'Production-Sale', date('Y'));

            foreach ($request->product_id as $key => $id) {
                ProductionSaleDetails::query()->create([
                    'production_sales_id' => $store->id,
                    'product_id' => $id,
                    'assign_qty' => $request->assign_qty[$key],
                    'price' => $request->price[$key],
                    'total_amount' => $request->subtotal[$key]
                ]);
            }

            // $this->service->storeOrUpdateOpeningStock($request);
            // $this->service->storeOrUpdateBarcodeforproductionprod($request);

            DB::commit();
            return redirect()->route('sales.index')->with('message', 'Prodution Sales Created Successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductionSales  $productionSales
     * @return \Illuminate\Http\Response
     */
    public function show(ProductionSales $productionSales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductionSales  $productionSales
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['production_sale'] = ProductionSales::find($id);
        $data['company'] = $this->indexService->getCompany();
        $data['customer'] = Customer::orderBy('name')->pluck('name', 'id');
        $data['products'] = $this->indexService->getManufacturedProdforSales();

        return view('sales.sales.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductionSales  $productionSales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $find = ProductionSales::find($id);
        $find->update([
            'company_id' => $request->company_id,
            'customer_id' => $request->customer_id,
            'date' => $request->date,
            'discount_amount' => $request->discount_amount,
            'previous_due' => $request->previous_due,
            'total_amount' => $request->total_amount,
            'payable_amount' => $request->payable_amount,
        ]);

        $array = [];
        $i = 0;
        foreach ($request->product_id as $key => $id) {
            $data = $find->productionSaleDetails()->where('product_id', $id)->firstorfail();
            $array[$i]['product_id'] = $request->product_id[$key];
            $array[$i]['assign_qty'] = $request->assign_qty[$key];
            $array[$i]['price'] = $request->price[$key];
            $array[$i]['total_amount'] = $request->subtotal[$key];
            $data->update($array[$i]);
            $i++;
        }
        return redirect()->route('sales.index')->with('message', 'Update Successfully Done!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductionSales  $productionSales
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $find = ProductionSales::find($id);
        $find->delete();
        return redirect()->back()->with('message', 'Successfully Delete!');
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductionSales  $productionSales
     * @return \Illuminate\Http\Response
     */
    public function salesOrderIndex(Request $request)
    {
        $data['customer'] = Customer::pluck('name', 'id');
        if($request->customer_id){
            $data['sale_prod'] = ProductionSales::where('type', 'order')->where('customer_id', $request->customer_id)->orwhereDate('date', [$request->from_date, $request->to_date])->paginate(20);
        }else{
            $data['sale_prod'] = ProductionSales::where('type', 'order')->paginate(20);
        }
        return view('sales.sales-order.index', $data);
    }

    public function salesOrderCreate()
    {
        $data['company'] = $this->indexService->getCompany();
        $data['customer'] = Customer::orderBy('name')->pluck('name', 'id');
        $data['products'] = $this->indexService->getManufacturedProdforSales();

        return view('sales.sales-order.create', $data);
    }

    public function salesOrderStore(Request $request)
    {
        $this->store($request);

        return redirect()->route('sales.order.index')->with('message', 'Sales Order Created Successfully!');
    }

    public function isConfirm($id){
        $find = ProductionSales::find($id);
        $find->update([
            'is_approved' => 1
        ]);
        return redirect()->back()->with('message', 'Confirm Successfull!');
    }
}
