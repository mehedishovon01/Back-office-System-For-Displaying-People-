<?php


namespace Module\Account\Models;


use Illuminate\Database\Eloquent\Relations\MorphMany;

class PurchaseDetail extends Model
{
    // use AutoCreatedUpdatedWithCompany;

    protected $table = 'acc_purchase_details'; 

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
