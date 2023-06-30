<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('pages.checkout')->with([
            'discount'=>$this->getNumbers()->get('discount'),
            'newSubtotal'=>$this->getNumbers()->get('newSubtotal'),
            'newTax'=>$this->getNumbers()->get('newTax'),
            'newTotal'=>$this->getNumbers()->get('newTotal'),
        ]);
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
    public function store(CheckoutRequest $request)
    {
        $contents=Cart::content()->map(function($item){
            return $item->model->slug.','.$item->qty;
        })->values()->toJson();
     
     try{
        $charge = Stripe::charges()->create([
            'amount' => $this->getNumbers()->get('newTotal') / 100,
            'currency' => 'CAD',
            'source' =>'tok_visa',
            'description' => 'Order',
            'receipt_email' => $request->email,
            'metadata'=>
            [
        'contents'=>$contents,
        'quantity'=>Cart::instance('default')->count(),
        'discount'=>collect(session()->get('coupon'))->toJson()
    ],
           
        ]);
       Cart::instance('default')->destroy();
       session()->forget('coupon');
      return redirect()->route('thankyou.index')->with('success_message','thank you! Your payment has been successfully updated');

     }catch(CardErrorException $e){
   return back()->withErrors('Error !'.$e->getMessage());
     }
      

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
        //
    }
    private function getNumbers(){
        $tax=config('cart.tax')/100;
        $discount=session()->get('coupon')['discount']?? 0;
$newSubtotal=(Cart::subtotal() - $discount);
$newTax=$newSubtotal * $tax;
$newTotal=$newSubtotal*(1+$tax);
        return collect([
            'discount'=>$discount,
            'newSubtotal'=>$newSubtotal,
            'newTax'=>$newTax,
            'newTotal'=>$newTotal,
        ]);   
    }
}
