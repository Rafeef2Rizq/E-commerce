@extends('layout')

@section('title', 'Checkout')



@section('content')

    <div class="container">

        <h1 class="checkout-heading stylish-heading">Checkout</h1>
        @if (session()->has('success_message'))
            <div class="alert alert-success">{{ session()->get('success_message') }}</div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li> {{ $error }}</li>
                @endforeach
            </div>
        @endif
        <div class="checkout-section">
            <div>
                <form action="{{ route('checkout.store') }}" id="payment-form" method="post">
                    {{ csrf_field() }}
                    <h2>Billing Details</h2>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ old('address') }}" required>
                    </div>

                    <div class="half-form">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city"
                                value="{{ old('city') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="province">Province</label>
                            <input type="text" class="form-control" id="province" name="province"
                                value="{{ old('province') }}" required>
                        </div>
                    </div> <!-- end half-form -->

                    <div class="half-form">
                        <div class="form-group">
                            <label for="postalcode">Postal Code</label>
                            <input type="text" class="form-control" id="postalcode" name="postalcode"
                                value="{{ old('postalcode') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ old('phone') }}" required>
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

                    <button type="submit" class="button" id="complete-orde">Complete Order</button>


                </form>
            </div>

            <div class="checkout-table-container">



                <a href="{{ route('cart.index') }}" class="button"
                    style="background-color: rgb(93, 165, 189);
                position:absolute;right:10px
                  ">back
                    to cart</a>
                <h2>Your Order</h2>
                <div class="checkout-table">
                    @foreach (Cart::content() as $item)
                        <div class="checkout-table-row">
                            <div class="checkout-table-row-left">
                                <img src="{{ asset('image/products/' . $item->model->slug . '.jpg') }}" alt="item"
                                    class="checkout-table-img">
                                <div class="checkout-item-details">
                                    <div class="checkout-table-item">{{ $item->model->name }}</div>
                                    <div class="checkout-table-description">{{ $item->model->details }}</div>
                                    <div class="checkout-table-price">${{ presentPrice($item->model->price) }}</div>
                                </div>
                            </div> <!-- end checkout-table -->

                            <div class="checkout-table-row-right">
                                <div class="checkout-table-quantity">{{ $item->qty }}</div>
                            </div>
                        </div> <!-- end checkout-table-row -->
                    @endforeach

                    <div class="checkout-totals">
                        <div class="checkout-totals-left">
                            Subtotal <br>
                           @if (session()->has('coupon'))
                           Discount({{!is_null(session()->get('coupon')) ?session()->get('coupon')['name']:''}} ):
                           <form action="{{route('coupons.destroy')}}"method="post" style="display: inline">
                           @csrf
                       @method('delete')
                       <button type="submit">Remove</button>
                       </form><br>
                       <hr>
                       New subtotal <br>
                           @endif
                            Tax <br>
                            <span class="checkout-totals-total">Total</span>

                        </div>
                        
                        <div class="checkout-totals-right">
                            {{ presentPrice(Cart::subtotal()) }}<br>
                            @if (session()->has('coupon'))
                            -{{presentPrice($discount) }}<br>
                            <hr>
                            {{presentPrice($newSubtotal)}} <br>
                            @endif

                            {{ presentPrice($newTax) }} <br>
                            <span class="checkout-totals-total">${{  presentPrice($newTotal) }}</span>

                        </div>
                    </div> <!-- end checkout-totals -->

                </div>
                @if (!session()->has('coupon'))
                <a href="#" class="have-code">Have a Code?</a>
                <div class="have-code-container">
                    <form action="{{route('coupons.store')}}" method="post">
                        @csrf
                        <input type="text" name="coupon_code" id="coupon_code">
                        <button type="submit" class="button button-plain">Apply</button>
                    </form>
                </div> <!-- end have-code-container -->
                @endif
            </div> <!-- end checkout-section -->
            
        </div>
    </div>
@endsection




@section('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        window.onload = function() {

            var stripe = Stripe(
                'pk_test_51LMI2ZGGZOCQZ2zwQsePKEkIhOZe2OAMIO9ym5tNGUlZ1wOY8ga0JMtABBu4xHcPWzok4b75KbwVDFo1NazgyUBV009rK7yMqS'
                );
            var elements = stripe.elements();
            var card = elements.create('card', {
                hidePostalCode: true,
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

            card.on('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                document.addEventListener("DOMContentLoaded", function(event) {
                    document.getElementById("complete-order").disabled = true;
                });

                var options = {
                    name: document.getElementById('name_on_card').value,
                    address_line1: document.getElementById('address').value,
                    address_city: document.getElementById('city').value,
                    address_state: document.getElementById('province').value,
                    address_zip: document.getElementById('postalcode').value
                };

                stripe.createToken(card, options).then(function(result) {
                    if (result.error) {
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                        document.getElementById('complete-order').disabled = false;

                    } else {
                        stripeTokenHandler(result.token);
                    }
                });
            });

            function stripeTokenHandler(token) {
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
        };
    </script>
@endsection
