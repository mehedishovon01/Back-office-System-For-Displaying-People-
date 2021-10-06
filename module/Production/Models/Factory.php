<?php

namespace Module\Production\Models;

use App\Models\Company;
use App\Traits\AutoCreatedUpdated;
use App\Model;

class Factory extends Model
{
    use AutoCreatedUpdated;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
