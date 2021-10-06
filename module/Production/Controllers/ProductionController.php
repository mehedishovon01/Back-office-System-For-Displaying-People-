<?php

namespace Module\Production\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Company;
use Exception;
use Illuminate\Http\Request;
use Module\Account\Models\Category;
use Module\Account\Models\Product;
use Module\Production\Models\Factory;
use Module\Production\Models\ManufacturedProduct;
use Module\Production\Models\Production;
use Module\Production\Services\ManufactureService;
use Illuminate\Support\Facades\DB;
use Module\PosErp\Models\ProductStock;
use Module\PosErp\Services\ProductService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ProductionController extends Controller
{
    private $manufactureDataServices;

    public function __construct()
    {
        $this->manufactureDataServices = new ManufactureService();
        $this->service = new ProductService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('product_name', 255)->nullable()->change();
        });

        $data['production'] = $this->manufactureDataServices->getProduction();

        return view('production.index', $data);
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
        $data['manufactured_prod'] = Product::where('type', 'manufactured')->get();
        $categories = Category::orderBy('name')->pluck('name', 'id');

        return view('production.create', compact('company', 'factory', 'categories'), $data);
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
            $manufac_prod = $this->manufactureDataServices->getManufactureProduct($request->product_id);
            $data = $this->manufactureDataServices->manufactureProd($manufac_prod, $request, 'production');

            $prod = $this->manufactureDataServices->manufactureProductStore($data);

            if ($request->is_approved == 1) {
                $this->stockChange($request);
                $this->approve($prod);
            }

            DB::commit();
            return redirect()->route('production.index')->with('message', 'Production Inserted Successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
        return $prod;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function production_approve($id)
    {
        $prod = Product::find($id);
        $this->approve($prod);
        return redirect()->route('production.index')->with('message', 'Production Approved Done');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */

    public function approve($prod)
    {
        try {
            DB::beginTransaction();
            $prod->update([
                'is_approved' => 1
            ]);

            $productStock = $this->manufactureDataServices->productStockCheck($prod->id);

            if ($productStock) {
                $this->manufactureDataServices->productStockUpdate($productStock, $prod->product_alert_quantity);
            } else {
                $this->manufactureDataServices->productStockStore($prod->id, $prod->product_alert_quantity);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }
    public function stockChange($request)
    {
        try {
            DB::beginTransaction();
                $this->service->storeOrUpdateOpeningStock($request);
                $this->service->storeOrUpdateBarcodeforproductionprod($request);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function show(Production $production)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function edit(Production $production)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Production $production)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Production  $production
     * @return \Illuminate\Http\Response
     */
    public function destroy(Production $production)
    {
        //
    }
}
