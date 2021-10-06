<?php

namespace Module\Production\Services;

use Module\Account\Models\Product;
use Module\PosErp\Models\ProductStock;
use Module\Production\Models\ManufacturedProduct;

class ManufactureService
{
    public function manufactureProductStore($data)
    {
        return Product::query()->create($data);
    }

    public function getManufactureProduct($id)
    {
        return Product::find($id);
    }

    public function manufactureProd($manufac_prod, $value, $type)
    {
        $data['company_id']             = $value->company_id;
        $data['factory_id']             = $value->factory_id;
        $data['category_id']            = $value->category_id;
        $data['unit_id']                = $value->unit;
        $data['brand_id']               = $value->brand_id;
        $data['product_alert_quantity'] = $value->available_quantity;
        $data['product_price']          = $manufac_prod->selling_price;
        $data['product_cost']           = $manufac_prod->selling_price;
        $data['opening_quantity']           = $manufac_prod->opening_quantity;
        $data['product_name']           = $manufac_prod->name;
        $data['type']                   = $type;
        
        return $data;
    }

    public function getProduction()
    {
        $data = Product::where('type', 'production')
                        ->where('company_id', auth()->user()->company_id)
                        ->select('id', 'category_id', 'unit_id', 'product_name', 'is_approved', 'product_price', 'opening_quantity', 'current_stock', 'type', 'company_id', 'factory_id', 'production_date', 'created_by', 'updated_by', 'created_at', 'created_at')
                        ->latest()
                        ->get();
        return $data;
    }

    public function productStockCheck($id){
        return  ProductStock::companies()->where('product_id', $id)->first();
    }
    public function productStockUpdate($productStock, $qty){
        ProductStock::query()->update([
            'opening_quantity'      => $qty,
            'available_quantity'    => ($productStock->available_quantity - $productStock->opening_quantity) + $qty,
        ]);
    }
    public function productStockStore($id, $qty){
        ProductStock::create([
            'opening_quantity'      => $qty,
            'purchased_quantity'    => 0,
            'available_quantity'    => $qty,
            'sold_quantity'         => 0,
            'product_id'            => $id
        ]);
    }
}
