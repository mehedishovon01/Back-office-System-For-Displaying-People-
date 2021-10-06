<?php


namespace Module\Account\Models;


use App\Traits\AutoCreatedUpdatedWithCompany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voucher extends Model
{
    use AutoCreatedUpdatedWithCompany;

    public function details(): HasMany
    {
        return $this->hasMany(VoucherDetail::class, 'voucher_id');
    }
}
