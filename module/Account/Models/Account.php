<?php


namespace Module\Account\Models;

use App\Traits\AutoCreatedUpdatedWithCompany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    use AutoCreatedUpdatedWithCompany;

    public function accountGroup(): BelongsTo
    {
        return $this->belongsTo(AccountGroup::class, 'account_group_id');
    }

    public function accountControl(): BelongsTo
    {
        return $this->belongsTo(AccountControl::class, 'account_control_id');
    }

    public function accountSubsidiary(): BelongsTo
    {
        return $this->belongsTo(AccountSubsidiary::class, 'account_subsidiary_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'account_id', 'id');
    }

    public function scopeCompanies($query)
    {
        return $query->where('company_id', auth()->user()->company_id);
    }
}
