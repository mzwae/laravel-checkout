<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(5);
        return view('product.index')->with('products', $products);
    }

    /**
     * Purchase a product
     */

    public function purchase(Request $request)
    {

    }


    /**
     * Create a product
     */

     public function store(Request $request)
     {

     }

}
