<?php

namespace Module\Production\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\PosErp\Models\Product;
use Module\PosErp\Models\Category;
use Module\PosErp\Models\ProductTransaction;
use Module\Production\Services\ProductReportService;

class ProductReportController extends Controller
{
    private $productreportService;

    public function __construct()
    {
        $this->productreportService = new ProductReportService();
    }

    public function index(Request $request){
        // $data1['products'] = $this->productreportService->getProduct();
        // $data2 = $this->productreportService->productLedgerReport($request);

        // return view('reports.ledger-report.index', $data1, $data2);

        $data['categories'] = Category::get(['id','category_name']);

        $products=Product::where('product_name', '!=', null)->where('type', 'production')->where('company_id', auth()->user()->company_id)
        ->when($request->filled('category_id'), function ($q) use($request) {
            $q->where('category_id', $request->category_id);
        })
        ->when($request->filled('product_name'), function ($q) use($request) {
            $q->where("product_name","LIKE", "%{$request->product_name}%");
        })
        ->withCount(['product_stock as opening_qty'=>function($query){
            return $query->select(DB::raw('SUM(opening_quantity)'));
        }])
        ->withCount(['product_stock as available_qty'=>function($query){
            return $query->select(DB::raw('SUM(available_quantity)'));
        }])
        ->withCount(['product_stock as sold_qty'=>function($query){
            return $query->select(DB::raw('SUM(sold_quantity)'));
        }])
        ->withCount(['product_stock as purchased_qty'=>function($query){
            return $query->select(DB::raw('SUM(purchased_quantity)'));
        }])
        ->withCount(['product_stock as wastage_qty'=>function($query){
            return $query->select(DB::raw('SUM(wastage_quantity)'));
        }]);


        $products = $products->when($request->filled('warehouse_id'), function ($q) use($request) {
            $q->when($request->warehouse_id == 'all', function ($q1) use($request) {
                $q1->withCount(['product_stock as transfer_in_qty'=>function($query){
                        return $query->select(DB::raw('SUM(transfer_in)'));
                    }])
                    ->withCount(['product_stock as transfer_out_qty'=>function($query){
                        return $query->select(DB::raw('SUM(transfer_out)'));
                    }]);
                });

            $q->when($request->warehouse_id == 'central', function ($q1) use($request) {
                $q1->withCount(['product_stock as transfer_out_qty'=>function($query){
                    return $query->select(DB::raw('SUM(transfer_out)'));
                    }])
                    ->withCount(['product_stock as available_qty' => function($q2) use($request){
                        $q2->select(DB::raw('SUM(available_quantity)'));
                    }]);
                });
        });

        $data['total_product_price'] =  $products->get()->map(function ($item) {
            return ($item->available_qty ?? 0) * $item->product_cost;
        })->sum();

        $data['products'] = $products->paginate(30);
        return view('reports.ledger-report.index', $data);
    }



    public function product_ledger(Request $request){
        $data['products'] = Product::where('product_name', '!=', null)->where('type', 'production')->pluck('product_name as name', 'id');
        if ($request->filled('product_id')) {
            $data['openingQty']         = Product::find($request->product_id)->opening_quantity ?? 0;
            $data['product_ledgers']    = ProductTransaction::whereProductId($request->product_id)
            ->when(($request->filled('from') && $request->filled('to')),function($query) use ($request) {
                return $query->whereBetween('date',[$request->from,$request->to]);
            });
        }
        if(isset($data['product_ledgers']))
        {
            $data['product_ledgers'] = $data['product_ledgers']->paginate(50);
        }

        return view('reports.product-ledger.index',$data);
    }
}
