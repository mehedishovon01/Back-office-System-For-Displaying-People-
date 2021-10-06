<?php

namespace Module\Production\Services;

use Module\Account\Models\Product;
use Module\Account\Models\ProductStockTransection;

class ProductStockService
{
    public function productStock($model, $detail, $price, $source_type, $stock_type)
    {
        $this->storeProduct($model, $detail, $price, $source_type, $stock_type);
        $this->updateProduct($detail->product_id, $detail->assign_qty);
    }

    private function storeProduct($model, $detail, $price, $source_type, $stock_type)
    {
        ProductStockTransection::query()->updateOrCreate(
        [
            'source_type' => $source_type,
            'source_id' => $detail->id,
            'invoice_no' => $model->invoice_no,
            'company_id' => $model->company_id,
            'factory_id' => $model->factory_id,
        ],
        [
            'date' => $model->date,
            'product_id' => $detail->product_id,
            'quantity' => $detail->assign_qty,
            'price' => $price,
            'warehouse_id' => 1, //Manual Entry
            'stock_type' => $stock_type
        ]);
    }

    public function updateProduct($prod, $quantity)
    {
        $prodQty = Product::find($prod);
        $prodQty->opening_quantity -= $quantity;
        $prodQty->update();
    }
}
