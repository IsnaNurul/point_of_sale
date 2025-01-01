<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleTransaction extends Model
{
    protected $guarded = '';

    public function user()
    {
        return $this->belongsTo(User::class, 'cashierId');
    }

    public function sale_item()
    {
        return $this->hasMany(SaleItem::class, 'id');
    }
}
