<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'category_id',
        'sku',
        'description',
        'purchase_price',
        'selling_price',
        'quantity',
        'reorder_level',
        'brand',
        'model_compatibility',
        'status',
        'image_path'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
}
