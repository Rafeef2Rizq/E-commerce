<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CouponsController extends Controller
{


   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $coupon=Coupon::where('code',$request->coupon_code)->first();
    if(!$coupon){
        return redirect()->route('checkout.index')->withErrors('Invalid coupons . please try again!');
    }
   Session()->put('coupon',[
    'name'=>$coupon->code,
    'discount'=>$coupon->discount(Cart::subtotal()),
    'total'=>$coupon->discount(Cart::total()),
   ]);
   return redirect()->route('checkout.index')->with('success_message','coupon applied successfully');

    }


  

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
      session()->forget('coupon');
      return redirect()->route('checkout.index')->with('success_message','coupon removed successfully');

    }
}
