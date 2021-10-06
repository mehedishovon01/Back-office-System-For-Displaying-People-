<?php


namespace Module\Account\Models;


use App\Traits\AutoCreatedUpdatedWithCompany;
use Module\Account\Models\PurchaseDetail;
use Module\Production\Models\Factory;
use Module\Production\Models\RawMaterialsDetails;

class Product extends Model
{
    use AutoCreatedUpdatedWithCompany;

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class, 'factory_id', 'id');
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class, 'product_id', 'id');
    }

    public function rawMaterialsDetails()
    {
        return $this->hasMany(RawMaterialsDetails::class, 'product_id', 'id');
    }
}
