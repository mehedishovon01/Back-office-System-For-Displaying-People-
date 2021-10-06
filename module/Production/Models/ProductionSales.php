<?php

namespace Module\Production\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;
use Module\Account\Models\Customer;

class ProductionSales extends Model
{
    use AutoCreatedUpdated;
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function productionSaleDetails()
    {
        return $this->hasMany(ProductionSaleDetails::class, 'production_sales_id');
    }
}
