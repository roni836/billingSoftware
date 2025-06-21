<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $guarded = [];

    /**
     * Get the sale associated with the sale item.
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Get the product associated with the sale item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
