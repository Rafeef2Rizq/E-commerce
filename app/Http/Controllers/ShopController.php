<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        if(request()->category){
            //wherehas for fillering with condition inside it's function
$products=Product::with('categories')->whereHas('categories',function($query){
$query->where('slug',request()->category);
})->get();
    $categories=Category::all();
      $categoryName=$categories->where('slug',request()->category)->first()->name;  
}
        else{
            $products=Product::inRandomOrder()->take(12)->paginate(9);
            $categories=Category::all();
            $categoryName='Featured';
        }
      if(request()->sort =='low_heigh'){
 $products=$products->sortBy('price');
      }else if(request()->sort =='heigh_low'){
        $products=$products->sortByDesc('price');
      }

        return view('pages.shop',['products'=>$products,
        'categories'=>$categories,
        'categoryName'=>$categoryName
        ]);
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
