@extends('layout')

@section('title', 'Shopping Cart')



@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <a href="/">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Shopping Cart</span>
        </div>
    </div> <!-- end breadcrumbs -->

    <div class="cart-section container">
        <div>

        @if (session()->has('success_message'))
            <div class="alert alert-success">{{session()->get('success_message')}}</div>
        @endif
        @if (count($errors)>0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
      
        </div>
            
        @endif
        <div>
            @if (Cart::count()>0)
                
           
            <h2>{{Cart::count()}} item(s) in Shopping Cart</h2>

            <div class="cart-table">
                @foreach(Cart::content() as $item)

              
                <div class="cart-table-row">
                    <div class="cart-table-row-left">
                        <a href="{{route('shop.show',$item->model->slug)}}">
                            <img src="{{asset('image/products/'.$item->model->slug.'.jpg')}}" alt="item" class="cart-table-img"></a>
                        <div class="cart-item-details">
                            <div class="cart-table-item">
                                <a href="{{route('shop.show',$item->model->slug)}}">{{$item->model->name}}</a></div>
                            <div class="cart-table-description">{{$item->model->details}}</div>
                        </div>
                    </div>
                    <div class="cart-table-row-right">
                        <div class="cart-table-actions">
                            {{-- <a href="#">Remove</a> --}}
                            <form action="{{route('cart.destroy',$item->rowId)}}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="cart-options">Remove</button>
                            </form>
                            <br>
                            <form action="{{route('cart.switchForLater',$item->rowId)}}" method="POST">
                                @csrf
                               
                                <button type="submit" class="cart-options">Save for Later</button>
                                </form>
                             {{-- <a href="{{}}">Save for Later</a> --}}
                        </div>
                        <div>
                            <select class="quantity" data-id="{{$item->rowId}}">
                            @for ($i = 1; $i <= 5; $i++)
                            <option {{$item->qty ==$i ?'selected' :''}}>{{$i}}</option> 
                            @endfor
                            </select>
                        </div>
                        <div>${{presentPrice($item->subtotal())}}</div>
                    </div>
                </div> <!-- end cart-table-row -->
                @endforeach
               

            </div> <!-- end cart-table -->

          

            <div class="cart-totals">
                <div class="cart-totals-left">
                    Shipping is free because we’re awesome like that. Also because that’s additional stuff I don’t feel like figuring out :).
                </div>

                <div class="cart-totals-right">
                    <div>
                        Subtotal <br>
                        Tax(13%)<br>
                        <span class="cart-totals-total">Total</span>
                    </div>
                    <div class="cart-totals-subtotal">
                       ${{presentPrice(Cart::subtotal())}}  <br>
                       ${{presentPrice(Cart::tax())}} <br>
                        <span class="cart-totals-total">${{presentPrice(Cart::total())}}</span>
                    </div>
                </div>
            </div> <!-- end cart-totals -->

            <div class="cart-buttons">
               
                <a href="{{route('shop.index')}}" class="button">Continue Shopping</a>
            
                <a href="{{route('checkout.index')}}" class="button" style="background-color: rgb(164, 223, 164)">Proceed to Checkout</a>
            </div>
        @else
        <h2 class="alert alert-danger">No item in cart!</h2>
      
        @endif
        @if (Cart::instance('saveForLater')->count()>0)
                
           
        <h2>{{Cart::instance('saveForLater')->count()}} item(s) Saved For Later</h2>
         

            <div class="saved-for-later cart-table">
                @foreach(Cart::instance('saveForLater')->content() as $item)
                <div class="cart-table-row">
                    <div class="cart-table-row-left">
                        <a href="{{route('shop.show',$item->model->slug)}}"><img src="{{asset('image/products/'.$item->model->slug.'.jpg')}}" alt="item" class="cart-table-img"></a>
                        <div class="cart-item-details">
                            <div class="cart-table-item"><a href="{{route('shop.show',$item->model->slug)}}">{{$item->model->name}}</a></div>
                            <div class="cart-table-description">{{$item->model->details}}</div>
                        </div>
                    </div>
                    <div class="cart-table-row-right">
                        <div class="cart-table-actions">
                            <form action="{{route('saveForLater.destroy',$item->rowId)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="cart-options">Remove</button>
                                </form>
                                <form action="{{route('saveForLater.switchForLater',$item->rowId)}}" method="POST">
                                    @csrf
                                   
                                    <button type="submit" class="cart-options">move to cart</button>
                                    </form>
                            {{-- <a href="#">move to cart</a> --}}
                        </div>
                       
                        <div>${{presentPrice($item->model->price)}}</div>
                    </div>
                </div> <!-- end cart-table-row -->
                      @endforeach
             

            </div> <!-- end saved-for-later -->
            @else
            <h2 class="alert alert-danger">No item  saved for later!</h2>
          
            @endif
        </div>
    </div>
    </div> <!-- end cart-section -->

    @include('partials.might-like')


@endsection
<script src="{{assert('js/app.js')}}"></script>
@section('extra-js')
<script>
  
    (function(){
       
        const classname = document.querySelectorAll('.quantity')
        Array.from(classname).forEach(function(element) {
            element.addEventListener('change', function() {
                const id = element.getAttribute('data-id')
                axios.patch(`/cart/${id}`, {
                    quantity: this.value
})
.then(function (response) {
// console.log(response);
window.location.href = '{{ route('cart.index') }}';
})
.catch(function (error) {
console.log(error);
window.location.href = '{{ route('cart.index') }}';
});
            })
        })
    
    })();
</script>
@endsection