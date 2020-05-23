<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User;
use App\Services\Stripe\Transaction;

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

        $this->validate($request, [
            'upc' => 'required'
        ]);

        $user = Auth::user();
        $product = Product::where('upc', '=', $request->upc)->first();
        if (is_null($product)) {
            return back()->with('error', 'Product not found');
        }

        // Create a transaction
        Transaction::create($user, $product);

        return back()->with('success', 'You have bought the product');
    }


    /**
     * Create a product
     */

     public function store(Request $request)
     {
        $user = Auth::user();
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required'
        ]);

        $product = new Product();
        $product->upc = Str::uuid();
        $product->name = $request->name;
        $product->seller_id = $user->id;

        if ($request->has('description')) {
            $product->image = $request->file('image')->store('images', ['disk' => 'public']);
        }
        $product->save();

        return back()->with('success', 'Product created.');
     }

}
