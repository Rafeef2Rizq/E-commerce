<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class SaveForLaterController extends Controller
{

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cart::instance('saveForLater')->remove( $id);
        return back()->with('success_message',"item deleted successfully");
    }
    public function switchToCar($id){
       
        $itemId=Cart::instance('saveForLater')->get($id);
        Cart::instance('saveForLater')->remove($id);
        $duplicates=Cart::instance('default')->search(function($cartItem,$rowId) use($id){
          return $rowId ===$id;
         });
         if($duplicates->isNotEmpty()){
      
          return redirect()->route('cart.index')->with('success_message','item is aready Cart!');
      }
     

        Cart::instance('default')->add($itemId->id,$itemId->name,1,$itemId->price)->associate('App\Models\Product');
        return redirect()->route('cart.index')->with('success_message','Item added successfully');
          }
}
