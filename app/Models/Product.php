<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    protected $fillable=[
        "item",
        "category_id",
        "selling",
        "buying",
    ];

    protected $hidden=[
        'created_at',
        'updated_at',
    ];
}
