<?php

namespace Module\Production\Models;

use App\Traits\AutoCreatedUpdated;
use Illuminate\Database\Eloquent\Model;
use Module\Account\Models\Category;
use Module\Account\Models\Unit;

class ManufacturedProduct extends Model
{
    use AutoCreatedUpdated;

    protected $fillable = ['name', 'category_id', 'unit_id', 'selling_price', 'opening_quantity', 'created_by', 'updated_by'];

    public function unit(){
        return $this->belongsTo(Unit::class,'unit_id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
