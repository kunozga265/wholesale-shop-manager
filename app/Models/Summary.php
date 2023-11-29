<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    protected $fillable=[
        "amount",
        "date",
        "user_id",
        "shop_id",
        "type",
        "products",
    ];

    protected $hidden=[
        'created_at',
        'updated_at',
    ];
}
