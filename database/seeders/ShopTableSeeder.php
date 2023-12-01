<?php

namespace Database\Seeders;

use App\Http\Controllers\AppController;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shop = Shop::create([
            "name"              => "Chinsapo Corner Shop",
            "location"          => "Chinsapo, Lilongwe",
            "account_balance"   => 50000,
        ]);
        (new AppController())->seedProducts($shop);

        $shop = Shop::create([
            "name"              => "Area 23 Shop",
            "location"          => "Area 23, Lilongwe",
            "account_balance"   => 60000,
        ]);
        (new AppController())->seedProducts($shop);

        $shop = Shop::create([
            "name"              => "Quick Stop",
            "location"          => "Bunda, Lilongwe",
            "account_balance"   => 70000,
        ]);
        (new AppController())->seedProducts($shop);



    }


}
