<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $guarded = '';
    public function product()
    {
        return $this->hasMany(Product::class, 'unitId');
    }
}
