<?php

namespace Module\Production\Services;

use App\Models\Company;
use Module\Production\Models\RawMaterials;
use Module\Account\Models\Product;

class IndexDataServices
{
    public function getCompany(){
        if (auth()->user()->id == 1) {
            $company = Company::get();
        } else {
            $company = Company::where('id', auth()->user()->company_id)->get();
        }
        return $company;
    }

    public function getRawMaterialsData()
    {
        if(auth()->user()->company_id == 1){
            return RawMaterials::query()
            ->latest()
            ->paginate(20);
        }else{
            return RawMaterials::query()
            ->where('company_id', auth()->user()->company_id)
            ->latest()
            ->paginate(20);
        }
    }

    public function getProdforMaterials(){
        $products = Product::where('name', '!=', null)->where('type', '=', null)->get();
        $array = [];
        $i = 0;
        foreach($products as $prod){
            $array[$i]['id'] = $prod->id;
            $array[$i]['name'] = $prod->name;
            $array[$i]['unitId'] = $prod->unit->id;
            $array[$i]['unitName'] = $prod->unit->name;
            $array[$i]['qty'] = $prod->purchaseDetails->sum('quantity') - $prod->rawMaterialsDetails->sum('assign_qty');
            $i++;
        }
        return $array;
    }

    public function getManufacturedProdforSales(){
        $products = Product::where('type', 'manufactured')->get();
        $array = [];
        $i = 0;
        foreach($products as $prod){
            $array[$i]['id'] = $prod->id;
            $array[$i]['name'] = $prod->name;
            $array[$i]['unitId'] = $prod->unit->id;
            $array[$i]['unitName'] = $prod->unit->name;
            $array[$i]['qty'] = $prod->opening_quantity;
            $array[$i]['price'] = $prod->selling_price;
            $i++;
        }
        return $array;
    }
}
