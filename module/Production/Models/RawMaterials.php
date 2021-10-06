<?php

namespace Module\Production\Models;

use App\Models\Company;
use App\Traits\AutoCreatedUpdated;
use App\Model;

class RawMaterials extends Model
{
    use AutoCreatedUpdated;

    public function factories()
    {
        return $this->belongsTo(Factory::class, 'factory_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function materialDetails()
    {
        return $this->hasMany(RawMaterialsDetails::class, 'raw_material_id');
    }
}
