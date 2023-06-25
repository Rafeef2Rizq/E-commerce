<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $products=Product::inRandomOrder()->take(12)->get();
        return view('pages.shop')->with('products',$products);
    }

 
    public function show($slug)
    {
        $product=Product::where('slug',$slug)->firstOrFail();
        $mightAlsoLike=Product::where('slug','!=',$slug)->mightAlsoLike()->get();
        return view('pages.product')->with(['product'=>$product,
    'mightAlsoLike'=>$mightAlsoLike]);
    }

    /**
     * Show the form for editing the specified resource.
     */
   
}
