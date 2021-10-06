<?php


namespace Module\Account\Models;

use App\Traits\AutoCreatedUpdatedWithCompany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
    'Voucher Detail'    => VoucherDetail::class,
    'Account Opening'   => Account::class,
    'Fund Transfer'     => FundTransfer::class,
    'Customer Opening'  => Customer::class,
    'Supplier Opening'  => Supplier::class,
    'Purchase'          => Purchase::class,
    'Payment'           => Payment::class,
    'Sale'              => Sale::class,
    'Collection'        => Collection::class,
]);

class Transaction extends Model
{
    use AutoCreatedUpdatedWithCompany;

    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function scopeCompanies($query)
    {
        return $query->where('company_id', auth()->user()->company_id);
    }

    public function getDescription()
    {
        return $this->transactionable_type == 'Voucher Detail'
            ? $this->transactionable->particular
            : ($this->description ?? optional($this->transactionable)->description);
    }
}
