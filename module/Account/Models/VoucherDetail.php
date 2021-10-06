<?php


namespace Module\Account\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class VoucherDetail extends Model
{
    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class);
    }

    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    public function account() : BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
