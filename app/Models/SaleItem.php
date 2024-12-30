<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $guarded = '';

    public function sale_transaction()
    {
        return $this->belongsTo(SaleTransaction::class, 'saleId');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId');
    }
}
