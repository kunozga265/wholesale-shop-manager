<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'item'          => 'required',
            'category_id'   => 'required',
            'buying'        => 'required',
            'selling'       => 'required',
        ]);

        $product=Product::create([
            'item'          => $request->item,
            'category_id'   => $request->category_id,
            'buying'        => $request->buying,
            'selling'       => $request->selling,
        ]);

        return response()->json($product);
    }


    public function seeder(Request $request)
    {
        $request->validate([
           'products'   => 'required'
        ]);

        foreach ($request->products as $product){
            Product::create([
                'item'          => $product["item"],
                'category_id'   => $product["group"],
                'buying'        => $product["buying"],
                'selling'       => $product["selling"],
            ]);
        }

        dd("Products seeded!");
    }
}
