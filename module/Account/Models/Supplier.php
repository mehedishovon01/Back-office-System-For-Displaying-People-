<?php


namespace Module\Account\Models;


use App\Traits\AutoCreatedUpdatedWithCompany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Supplier extends Model
{
    use AutoCreatedUpdatedWithCompany;

    protected $table = 'acc_suppliers';

    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
