<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = '';

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unitId');
    }
    public function purchases()
    {
        return $this->hasMany(Purchases::class, 'productId');
    }
}
