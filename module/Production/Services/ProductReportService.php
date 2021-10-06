<?php

namespace Module\Production\Services;

use Module\Account\Models\Product;
use Module\Account\Models\ProductStockTransection;
use Module\Production\Models\ManufacturedProduct;

class ProductReportService
{
    public function getProduct()
    {
        // return Product::where('type', 'production')->get();
        return ManufacturedProduct::get();
    }

    public function productLedgerReport($request): array
    {
        $data['prod_qty'] = ProductStockTransection::query()
            ->where('product_id', $request->product_id)
            ->where('date', '<',  fdate($request->from ?? today()))
            ->sum('quantity');

        $data['prod_stock'] = ProductStockTransection::query()
            ->where('product_id', $request->product_id)
            ->when($request->from, function ($q) use ($request) {
                $q->where('date', '>=', $request->from);
            })
            ->when($request->to, function ($q) use ($request) {
                $q->where('date', '<=', $request->to);
            })
            ->orderBy('date');

        $data['prod_stock'] = $request->print
            ? $data['prod_stock']->get()
            : $data['prod_stock']->paginate(30);

        return $data;
    }
}
