<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>css grid example</title>
    {{-- icons --}}
        <script src="https://kit.fontawesome.com/8e6b99adf7.js" crossorigin="anonymous"></script>
       {{-- <link rel="stylesheet" href="{{asset('css/app.css')}}"> --}}
              {{-- <link rel="stylesheet" href="{{asset('css/resonsive.css')}}"> --}}
           
            @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/assert/sass/pages/header.scss',])
                </head>
    <body class="antialiased">
        <header>
            <div class="top-nav container">
                <div class="logo">CSS Grid Example</div>
                <ul>
                    <li><a href="{{route('shop.index')}}">Shop</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="{{route('cart.index')}}">Cart</a>
                            @if (Cart::instance('default')->count() >0)
                            <span class="cart-count"><span>{{Cart::instance('default')->count()}}</span></span>
                
                            @endif    
                    
                    
                    </li>
                </ul>
            </div> <!-- end top-nav -->
        
            <div class="hero container">
                <div class="hero-copy">
                    <h1>CSS Grid Example</h1>
                    <p>A practical example of using CSS Grid for a typical website layout.</p>
                    <div class="hero-buttons">
                        <a href="#" class="button button-white">Button 1</a>
                        <a href="#" class="button button-white">Button 2</a>
                    </div>
                </div> <!-- end hero-copy -->
        
                <div class="hero-image">
                    <img src="image/macbook-pro-laravel.png" alt="hero image">
                </div>
            </div> <!-- end hero -->
        </header>
        
        <div class="featured-section">
            <div class="container">
                <h1 class="text-center">CSS Grid Example</h1>
        
                <p class="section-description text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquid earum fugiat debitis nam, illum vero, maiores odio exercitationem quaerat. Impedit iure fugit veritatis cumque quo provident doloremque est itaque.</p>
        
                <div class="text-center button-container">
                    <a href="#" class="button">Featured</a>
                    <a href="#" class="button">On Sale</a>
                </div>
        
        
                <div class="products text-center">
                    @foreach($products as $product)
                    <div class="product">
                        <a href="{{route('shop.show',$product->slug)}}"><img src="
                            {{asset('image/products/'.$product->slug.'.jpg')}}" alt="product"></a>
                        <a href="{{route('shop.show',$product->slug)}}"><div class="product-name">{{$product->name}}</div></a>
                        <div class="product-price">${{$product->presentPrice()}}</div>
                    </div>
                @endforeach
                </div> <!-- end products -->
        
                <div class="text-center button-container">
                    <a href="{{route('shop.index')}}" class="button">View more products</a>
                </div>
        
            </div> <!-- end container -->
        
        </div> <!-- end featured-section -->
        
        <div class="blog-section">
            <div class="container">
                <h1 class="text-center">From Our Blog</h1>
        
                <p class="section-description text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et sed accusantium maxime dolore cum provident itaque ea, a architecto alias quod reiciendis ex ullam id, soluta deleniti eaque neque perferendis.</p>
        
                <div class="blog-posts">
                    <div class="blog-post" id="blog1">
                        <a href="#"><img src="image/blog1.png" alt="blog image"></a>
                        <a href="#"><h2 class="blog-title">Blog Post Title 1</h2></a>
                        <div class="blog-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est ullam, ipsa quasi?</div>
                    </div>
                    <div class="blog-post" id="blog2">
                        <a href="#"><img src="image/blog1.png" alt="blog image"></a>
                        <a href="#"><h2 class="blog-title">Blog Post Title 2</h2></a>
                        <div class="blog-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est ullam, ipsa quasi?</div>
                    </div>
                    <div class="blog-post" id="blog3">
                        <a href="#"><img src="image/blog1.png" alt="blog image"></a>
                        <a href="#"><h2 class="blog-title">Blog Post Title 3</h2></a>
                        <div class="blog-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est ullam, ipsa quasi?</div>
                    </div>
                </div> <!-- end blog-posts -->
            </div> <!-- end container -->
        </div> <!-- end blog-section -->
        
        @include('partials.footer')
        
        
    </body>
</html>
