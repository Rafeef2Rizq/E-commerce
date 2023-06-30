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
  public function index()
  {
    $pagination=9;
    $categories = Category::all();
    
    if (request()->category) {
      //wherehas for fillering with condition inside it's function
      $products = Product::with('categories')->whereHas('categories', function ($query) {
        $query->where('slug', request()->category);
      });
     
      $categoryName = optional($categories->where('slug', request()->category)->first())->name;
    } else {
      $products = Product::where('featured',true);
     
      $categoryName = 'Featured';
    }
    if (request()->sort == 'low_heigh') {
      $products = $products->orderBy('price')->paginate($pagination);
    } else if (request()->sort == 'heigh_low') {
      $products = $products->orderBy('price', 'desc')->paginate($pagination);
    } else {
      $products = $products->paginate($pagination);
    }

    return view('pages.shop', [
      'products' => $products,
      'categories' => $categories,
      'categoryName' => $categoryName
    ]);
  }


  public function show($slug)
  {
    $product = Product::where('slug', $slug)->firstOrFail();
    $mightAlsoLike = Product::where('slug', '!=', $slug)->mightAlsoLike()->get();
    return view('pages.product')->with([
      'product' => $product,
      'mightAlsoLike' => $mightAlsoLike
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
}
