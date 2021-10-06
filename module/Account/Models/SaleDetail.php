<?php


namespace Module\Account\Models;


use App\Traits\AutoCreatedUpdatedWithCompany;

class SaleDetail extends Model
{
    use AutoCreatedUpdatedWithCompany;

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }
}
