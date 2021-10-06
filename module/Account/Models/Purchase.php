<?php


namespace Module\Account\Models;


use App\Traits\AutoCreatedUpdatedWithCompany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Purchase extends Model
{
    use AutoCreatedUpdatedWithCompany;

    protected $table = 'acc_purchases'; 

    public function details()
    {
        return $this->hasMany(PurchaseDetail::class, 'purchase_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    
    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
