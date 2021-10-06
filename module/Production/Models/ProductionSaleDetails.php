<?php

namespace Module\Production\Models;

use App\Model;
use Module\Account\Models\Product;

class ProductionSaleDetails extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
