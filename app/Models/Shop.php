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

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    protected $fillable=[
        "name",
        "location",
        "account_balance",
    ];

    protected $hidden=[
        'created_at',
        'updated_at',
    ];
}
