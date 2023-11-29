<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    public function inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function summaries()
    {
        return $this->hasMany(Summary::class);
    }

    protected $fillable=[
        "name",
        "location",
    ];

    protected $hidden=[
        'created_at',
        'updated_at',
    ];
}
