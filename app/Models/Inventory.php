<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    protected $fillable=[
        "shop_id",
        "product_id",
        "stock",
    ];

    protected $hidden=[
        'created_at',
        'updated_at',
    ];
}
