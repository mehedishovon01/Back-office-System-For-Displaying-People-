<?php

namespace Module\Production\Models;

use App\Model;
use App\Models\Company;
use App\Traits\AutoCreatedUpdated;
use Module\GeneralStore\Models\PurchaseDetails;
use Module\GeneralStore\Models\PurchaseReceive;

class RequsitionPurchase extends Model
{
    use AutoCreatedUpdated;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function purchase_details()
    {
        return $this->hasMany(RequsitionPurchaseDetails::class, 'requsition_purchases_id');
    }

}
