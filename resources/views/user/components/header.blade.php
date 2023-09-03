<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Offcanvas Menu Begin -->
<div class="offcanvas-menu-overlay"></div>
<div class="offcanvas-menu-wrapper">
    <div class="offcanvas__close">+</div>
    <ul class="offcanvas__widget">
        <li><span class="icon_search search-switch"></span></li>
        <li>
            <a href="{{ url('wishlist') }}"><span class="icon_heart"></span>
                <div class="total_item_in_wish">
                    {{-- <div class="tip">2</div> --}}
                </div>
            </a>
        </li>
        <li>
            <a href="{{ url('cart') }}"><span class="icon_cart">
                    <div class="total_item_in_cart">
                        {{-- <p class="tip">1</p> --}}
                    </div>
            </a>
        </li>
    </ul>
    <div class="offcanvas__logo">
        <a href="/"><img src="{{ asset('user/assets/img/logo.png') }}" alt=""></a>
    </div>
    <div id="mobile-menu-wrap"></div>
    <div class="offcanvas__auth">
        @if (Route::has('login'))
            @auth
                <x-app-layout>

                </x-app-layout>
            @else
                <a href="{{ route('login') }}">login</a>

                <a href="{{ route('register') }}">Register</a>
            @endauth
        @endif
    </div>
</div>
<!-- Offcanvas Menu End -->

<!-- Header Section Begin -->
<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 col-lg-2">
                <div class="header__logo">
                    <a href="/"><img src="{{ asset('user/assets/img/logo.png') }}" alt=""></a>
                </div>
            </div>
            <div class="col-xl-6 col-lg-7">
                <nav class="header__menu">
                    <ul>
                        <li class=""><a href="/">Home</a></li>
                        <li><a href="shop">Women’s</a></li>
                        <li><a href="shop">Men’s</a></li>
                        <li><a href="shop">Kid’s</a></li>
                        <li><a href="shop">Electronics</a>
                            {{-- <ul class="dropdown">
                                <li><a href="./product-details.html">Product Details</a></li>
                                <li><a href="./shop-cart.html">Shop Cart</a></li>
                                <li><a href="./checkout.html">Checkout</a></li>
                                <li><a href="./blog-details.html">Blog Details</a></li>
                            </ul> --}}
                        </li>
                        <li><a href="shop">Mobiles</a></li>
                        <li><a href="contact">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__right">
                    <div class="header__right__auth">
                        @if (Route::has('login'))
                            @auth
                                <x-app-layout>

                                </x-app-layout>
                            @else
                                <a href="{{ route('login') }}">Login</a>

                                <a href="{{ route('register') }}">Register</a>
                            @endauth
                        @endif
                    </div>
                    <ul class="header__right__widget">
                        <li><span class="icon_search search-switch"></span></li>
                        <li><a href="{{ url('wishlist') }}"><span class="icon_heart_alt"></span>
                                <div class="total_item_in_wish">
                                    {{-- <div class="tip">2</div> --}}
                                </div>
                            </a></li>
                        <li><a href="{{ url('cart') }}"><span class="icon_cart_alt">
                                    <div class="total_item_in_cart">
                                        {{-- <p class="tip">1</p> --}}
                                    </div>
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="canvas__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->
