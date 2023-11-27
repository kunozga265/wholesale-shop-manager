<?php

namespace Database\Seeders;

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
            "name"      => "Chinsapo Corner Shop",
            "location"  => "Chinsapo, Lilongwe",
        ]);
        $this->seedProducts($shop);

        $shop = Shop::create([
            "name"      => "Area 23 Shop",
            "location"  => "Area 23, Lilongwe",
        ]);
        $this->seedProducts($shop);

        $shop = Shop::create([
            "name"      => "Quick Stop",
            "location"  => "Bunda, Lilongwe",
        ]);
        $this->seedProducts($shop);



    }

    private function seedProducts (Shop $shop)
    {
        $products = Product::all();
        foreach ($products as $product){
            Inventory::create([
                "shop_id"       =>  $shop->id,
                "product_id"    =>  $product->id,
                "stock"         =>  0,
            ]);
        }
    }
}
