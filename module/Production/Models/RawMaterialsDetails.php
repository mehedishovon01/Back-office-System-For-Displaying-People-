<?php

namespace Module\Production\Models;

use App\Model;
use Module\Account\Models\Product;
use Module\Account\Models\Unit;

class RawMaterialsDetails extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unitName()
    {
        return $this->belongsTo(Unit::class, 'unit');
    }
}
