<?php

namespace Module\Production\Models;

use App\Model;
use App\Traits\AutoCreatedUpdated;
use Module\Account\Models\Product;

class RequsitionPurchaseDetails extends Model
{
    use AutoCreatedUpdated;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
