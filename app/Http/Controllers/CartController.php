<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $mightAlsoLike=Product::mightAlsoLike()->get();

        return view('pages.cart',['mightAlsoLike'=>$mightAlsoLike]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $duplicates=Cart::search(function($cartItem,$rowId) use($request){
         return $cartItem->id ===$request->id;
        });
        if($duplicates->isNotEmpty()){
            return redirect()->route('cart.index')->with('success_message','item is aready in your cart!');
        }
        Cart::add($request->id,$request->name,1,$request->price)->associate('App\Models\Product');
        return redirect()->route('cart.index')->with('success_message','Item added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cart::remove( $id);
        return back()->with('success_message',"item deleted successfully");
    }
    public function switchForLater($id){
       
  $itemId=Cart::instance('default')->get($id);
  //if click two time error so let's make conditin
  
  Cart::instance('default')->remove($id);
  $duplicates=Cart::instance('saveForLater')->search(function($cartItem,$rowId) use($id){
    return $rowId ===$id;
   });
   if($duplicates->isNotEmpty()){

    return redirect()->route('cart.index')->with('success_message','item is aready in saved for later!');
}

  Cart::instance('saveForLater')->add($itemId->id,$itemId->name,1,$itemId->price)->associate('App\Models\Product');
  return redirect()->route('cart.index')->with('success_message','Item added for save later successfully');
    }
}
