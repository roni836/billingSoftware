<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = [];

    /**
     * Get the product associated with the sale.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the customer associated with the sale.
     */

    /**
     * Get the items associated with the sale.
     */
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
