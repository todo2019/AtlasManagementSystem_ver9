<?php

namespace App\Models\Categories;
use App\MOdels\Categories\SubCategory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category'
    ];

    public function subCategories(){
        return $this->belongsTo(SubCategory::class);
    }

}
