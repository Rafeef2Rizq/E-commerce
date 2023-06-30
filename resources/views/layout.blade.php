<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel Ecommerce | @yield('title', '')</title>
 

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat%7CRoboto:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Styles -->
        @vite(['resources/assert/sass/pages/shop.scss',
        'resources/assert/sass/pages/product.scss',
         'resources/js/app.js',
        'resources/sass/app.scss',
        'resources/assert/sass/pages/breadcrumbs.scss'
        ,'resources/assert/sass/pages/might-like.scss',
        'resources/assert/sass/pages/sidebar.scss',
        'resources/assert/sass/pages/cart.scss',
        'resources/assert/sass/pages/header.scss',
        'resources/assert/sass/pages/alert.scss',
        'resources/assert/sass/pages/checkout.scss',
        'resources/assert/sass/pages/form.scss',
        'resources/assert/sass/pages/thankyou.scss',
        'resources/assert/sass/pages/buttons.scss',
        'resources/assert/sass/pages/pagination.scss'
        ])


      
    </head>


<body class="@yield('body-class', '')">
    @include('partials.nav')

    @yield('content')

    @include('partials.footer')


    @yield('extra-js')
    @yield('script')
</body>
</html>