<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wishlist</title>
    @include('user.css')
<style>
    #add_cart {
        position: absolute;
        top: 200px;
        left: 265px;
        z-index: 1;
    }
    #remove_wish {
        position: absolute;
        top: 3px;
        left: 340px;
        z-index: 1;
    }
</style>
</head>

<body>
    <!-- Header Section Begin -->
    @include('user.components.header')
    <!-- Header Section End -->

    <!-- Wishlist Section Begin -->
    @include('user.components.wish_list')
    <!-- Wishlist Section End -->

    <!-- Instagram Begin -->
    {{-- @include('user.components.instagram') --}}
    <!-- Instagram End -->

    <!-- Footer Section Begin -->
    @include('user.components.footer')
    <!-- Footer Section End -->

    <!-- Search Begin -->
    @include('user.components.search')
    <!-- Search End -->

    <!-- Js Plugins -->
    @include('user.js')
    <script src="{{ asset('user/assets/user_interface_assets/js/wishlist.js') }}"></script>

</body>

</html>
