<?php

namespace Module\Production\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Module\Production\Models\RawMaterialsDetails;
use Exception;
use Illuminate\Http\RedirectResponse;
use Module\Production\Models\RawMaterials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\Account\Models\Product;
use Module\Account\Models\PurchaseDetail;
use Module\Production\Models\Factory;
use Module\Production\Services\IndexDataServices;
use Module\Production\Services\InvoiceNumberService;
use Module\Production\Services\ProductStockService;
use Module\PosErp\Services\ProductService;
use Module\PosErp\Services\SaleService;

class RawMaterialsController extends Controller
{
    private $invoiceNumberService;
    private $indexService;
    private $productStock;
    private $service;
    private $saleservice;

    public function __construct()
    {
        $this->invoiceNumberService = new InvoiceNumberService();
        $this->indexService = new IndexDataServices();
        $this->productStock = new ProductStockService();
        $this->saleservice = new SaleService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['rawMaterials'] = $this->indexService->getRawMaterialsData();

        return view('material.assign.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {      
        if (auth()->user()->id == 1) {
            $company = Company::get();
        } else {
            $company = Company::where('id', auth()->user()->company_id)->get();
        }

        $factory = Factory::get();
        $data['products'] = $this->indexService->getProdforMaterials();

        return view('material.assign.create', compact('company', 'factory'), $data);
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
            // $start = microtime(true);
            DB::beginTransaction();
            $store = RawMaterials::query()->create([
                'company_id' => $request->company_id,
                'factory_id' => $request->factory_id,
                'date' => $request->date,
                'is_approved' => 0,
            ]);
            $store->update([
                'invoice_no' => $this->invoiceNumberService->getMaterilasInvoiceNo($store->company_id),
            ]);
            $this->invoiceNumberService->setNextInvoiceNo($store->company_id, 'Raw-Materials', date('Y'));

            foreach ($request->product_id as $key => $id) {
                // $prodId = PurchaseDetail::where('product_id', $id)->firstorfail();
                RawMaterialsDetails::query()->create([
                    'raw_material_id' => $store->id,
                    // 'purchase_id' => $prodId->id,
                    'product_id' => $id,
                    'assign_qty' => $request->assign_qty[$key],
                    'unit' => $request->unit[$key],
                ]);
            }

            if ($request->draft == 0) {
                foreach ($request->product_id as $key => $id) {
                    $this->saleservice->updateProductStockFromProduction($request->product_id[$key], $key, $request);
                }
                $this->approveMaterials($store);
            }

            DB::commit();
            // $time_elapsed_secs = microtime(true) - $start;
            // dd($time_elapsed_secs);
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
        return redirect()->route('materials-assign.index');
    }

    public function is_approved($id)
    {
        try {
            DB::beginTransaction();
            $data = RawMaterials::find($id);
            $this->approveMaterials($data);
            DB::commit();
            return redirect()->back()->with('message', 'Your Raw Materials Approved Successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function approveMaterials(RawMaterials $rawMaterial)
    {
        try {
            DB::beginTransaction();
            $rawMaterial->update([
                'is_approved' => 1,
            ]);

            // foreach ($rawMaterial->materialDetails as $detail) {
            //     $prod_price = $this->getProduct($detail->product_id);
            //     $this->productStock->productStock($rawMaterial, $detail, $prod_price->selling_price, 'Raw-Materials', 'In'); //Not Hit Here Next Update
            // }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }

        return redirect()->route('materials-assign.index')->with('message', 'Your Raw Materials Approved Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RawMaterials  $rawMaterials
     * @return \Illuminate\Http\Response
     */
    public function show($rawMaterials)
    {
        $data['data'] = RawMaterials::find($rawMaterials);
        return view('material.assign.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RawMaterials  $rawMaterials
     * @return \Illuminate\Http\Response
     */
    public function edit($rawMaterials)
    {
        if (auth()->user()->id == 1) {
            $company = Company::get();
        } else {
            $company = Company::where('id', auth()->user()->company_id)->get();
        }

        $factory = Factory::get();
        $products = PurchaseDetail::get();
        $data['data'] = RawMaterials::find($rawMaterials);
        // return $products;

        return view('material.assign.edit', $data, compact('company', 'factory', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RawMaterials  $rawMaterials
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rawMaterials)
    {
        try {
            // $start = microtime(true);
            DB::beginTransaction();
            $data = RawMaterials::find($rawMaterials);

            $data->query()->update([
                'company_id' => $request->company_id,
                'factory_id' => $request->factory_id,
                'date' => $request->date,
                'is_approved' => 0,
            ]);

            // foreach ($data->materialDetails as $key => $id) {
            //     // dd($request->purchase_id);
            //     $prodId = PurchaseDetail::where('id', $request->purchase_id)->firstorfail();
            //     // dd($prodId);
            //     $detaildata = RawMaterialsDetails::where('raw_material_id', $id->raw_material_id)->firstorfail();
            //     dd($detaildata);
            //     $detaildata->query()->update([
            //         'purchase_id' => $request->purchase_id[$key],
            //         'product_id' => $prodId->product_id,
            //         'assign_qty' => $request->assign_qty[$key],
            //         'unit' => $request->unit[$key],
            //     ]);
            // }

            if ($request->draft == 0) {
                $this->approveMaterials($data);
            }

            DB::commit();
            // $time_elapsed_secs = microtime(true) - $start;
            // dd($time_elapsed_secs);
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RawMaterials  $rawMaterials
     * @return \Illuminate\Http\Response
     */
    public function destroy($rawMaterials): RedirectResponse
    {
        RawMaterials::query()->where('id', $rawMaterials)->delete();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RawMaterials  $rawMaterials
     * @return \Illuminate\Http\Response
     */

    public function getFactoryData(Request $request)
    {
        $data = Factory::query()
            ->where('company_id', $request->company_id)
            ->get();

        return response()->json($data);
    }

    public function getProduct($id)
    {
        return Product::find($id);
    }
}
