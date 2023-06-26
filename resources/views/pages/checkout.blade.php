@extends('layout')

@section('title', 'Checkout')



@section('content')

    <div class="container">

        <h1 class="checkout-heading stylish-heading">Checkout</h1>
        <div class="checkout-section">
            <div>
                <form action="{{route('checkout.store')}}" id="payment-form" method="post">
                    @csrf
                    <h2>Billing Details</h2>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="">
                    </div>

                    <div class="half-form">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="">
                        </div>
                        <div class="form-group">
                            <label for="province">Province</label>
                            <input type="text" class="form-control" id="province" name="province" value="">
                        </div>
                    </div> <!-- end half-form -->

                    <div class="half-form">
                        <div class="form-group">
                            <label for="postalcode">Postal Code</label>
                            <input type="text" class="form-control" id="postalcode" name="postalcode" value="">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="">
                        </div>
                    </div> <!-- end half-form -->

                    <div class="spacer"></div>

                    <h2>Payment Details</h2>

                    <div class="form-group">
                        <label for="name_on_card">Name on Card</label>
                        <input type="text" class="form-control" id="name_on_card" name="name_on_card" value="">
                    </div>
                 <div class="form-group"> 
                     <div id="card-element">
                    <!-- Elements will create input elements here -->
                  </div>
                
                  <!-- We'll put the error messages in this element -->
                  <div id="card-errors" role="alert"></div>
                </div>

                  
                    <div class="spacer"></div>

                    <button type="submit" class="button">Complete Order</button>


                </form>
            </div>

            <div class="checkout-table-container">

               
               
                <a href="{{route('cart.index')}}" class="button" style="background-color: rgb(93, 165, 189);
                position:absolute;right:10px
                  ">back to cart</a>
                <h2>Your Order</h2>
                <div class="checkout-table">
                    @foreach (Cart::content() as $item)
                        
                   
                    <div class="checkout-table-row">
                        <div class="checkout-table-row-left">
                            <img src="{{asset('image/products/'.$item->model->slug.'.jpg')}}" alt="item" class="checkout-table-img">
                            <div class="checkout-item-details">
                                <div class="checkout-table-item">{{$item->model->name}}</div>
                                <div class="checkout-table-description">{{$item->model->details}}</div>
                                <div class="checkout-table-price">${{presentPrice($item->model->price)}}</div>
                            </div>
                        </div> <!-- end checkout-table -->

                        <div class="checkout-table-row-right">
                            <div class="checkout-table-quantity">{{$item->qty}}</div>
                        </div>
                    </div> <!-- end checkout-table-row -->
                    @endforeach
                    
                <div class="checkout-totals">
                    <div class="checkout-totals-left">
                        Subtotal <br>
                        {{-- Discount (10OFF - 10%) <br> --}}
                        Tax <br>
                        <span class="checkout-totals-total">Total</span>

                    </div>

                    <div class="checkout-totals-right">
                        ${{presentPrice(Cart::subtotal())}}<br>
                        {{-- -$750.00 <br> --}}
                        ${{presentPrice(Cart::tax())}} <br>
                        <span class="checkout-totals-total">${{presentPrice(Cart::total())}}</span>

                    </div>
                </div> <!-- end checkout-totals -->

            </div>

        </div> <!-- end checkout-section -->
    </div>
    
   
    <script src="https://js.braintreegateway.com/web/dropin/1.13.0/js/dropin.min.js"></script>

    <script type="text/javascript">
        (function(){
            
          var stripe = Stripe('pk_test_51LMI2ZGGZOCQZ2zwQsePKEkIhOZe2OAMIO9ym5tNGUlZ1wOY8ga0JMtABBu4xHcPWzok4b75KbwVDFo1NazgyUBV009rK7yMqS');
        var elements = stripe.elements();
        var card = elements.create('card', {
        hidePostalCode:true,
        style: {
        base: {
          iconColor: '#666EE8',
          color: '#31325F',
          lineHeight: '40px',
          fontWeight: 300,
          fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
          fontSize: '15px',
        
          '::placeholder': {
            color: '#CFD7E0',
          },
        },
        }
        });
        
        card.mount('#card-element');
        // Handle real-time validation errors from the card Element.
        card.addEventListener('change', function(event) {
                      var displayError = document.getElementById('card-errors');
                      if (event.error) {
                        displayError.textContent = event.error.message;
                      } else {
                        displayError.textContent = '';
                      }
                    });
        // Create a token or display an error when the form is submitted.
        var form = document.getElementById('payment-form');
        form.addEventListener('button', function(event) {
          event.preventDefault();
          var options = {
                        name: document.getElementById('name_on_card').value,
                        address_line1: document.getElementById('address').value,
                        address_city: document.getElementById('city').value,
                        address_state: document.getElementById('province').value,
                        address_zip: document.getElementById('postalcode').value
                      }
          stripe.createToken(card,options).then(function(result) {
            if (result.error) {
              // Inform the customer that there was an error.
              var errorElement = document.getElementById('card-errors');
              errorElement.textContent = result.error.message;
            } else {
              // Send the token to your server.
              stripeTokenHandler(result.token);
            }
          });
        });
        
        function stripeTokenHandler(token) {
          // Insert the token ID into the form so it gets submitted to the server
          var form = document.getElementById('payment-form');
          var hiddenInput = document.createElement('input');
          hiddenInput.setAttribute('type', 'hidden');
          hiddenInput.setAttribute('name', 'stripeToken');
          hiddenInput.setAttribute('value', token.id);
          form.appendChild(hiddenInput);
        
          // Submit the form
          form.submit();
        }
        // PayPal Stuff
        
        
                     
        })();
        
        
        </script>

</div>
@endsection

