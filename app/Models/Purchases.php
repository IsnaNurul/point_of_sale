<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
    protected $guarded = '';
    public function product()
    {
        return $this->belongsTo(Product::class, 'productId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
