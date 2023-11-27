<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            "name" => "Accessories"
        ]);

        Category::create([
            "name" => "Beauty Soap"
        ]);

        Category::create([
            "name" => "Drinks"
        ]);

        Category::create([
            "name" => "Drugs"
        ]);

        Category::create([
            "name" => "Food"
        ]);

        Category::create([
            "name" => "Laundry Soap"
        ]);
    }
}
