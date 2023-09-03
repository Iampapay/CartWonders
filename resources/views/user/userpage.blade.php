<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E Shop</title>
    @include('user.css')
</head>

<body>
    <!-- Header Section Begin -->
    @include('user.components.header')
    <!-- Header Section End -->

    <!-- Categories Section Begin -->
    @include('user.components.categories')
    <!-- Categories Section End -->

    <!-- Product Section Begin -->
    @include('user.components.product_view')
    <!-- Product Section End -->

    <!-- Banner Section Begin -->
    @include('user.components.banner')
    <!-- Banner Section End -->

    <!-- Trend Section Begin -->
    @include('user.components.trend')
    <!-- Trend Section End -->

    <!-- Discount Section Begin -->
    @include('user.components.discount')
    <!-- Discount Section End -->

    <!-- Services Section Begin -->
    @include('user.components.services')
    <!-- Services Section End -->

    <!-- Instagram Begin -->
    @include('user.components.instagram')
    <!-- Instagram End -->

    <!-- Footer Section Begin -->
    @include('user.components.footer')
    <!-- Footer Section End -->

    <!-- Search Begin -->
    @include('user.components.search')
    <!-- Search End -->

    <!-- Js Plugins -->
    @include('user.js')
    <script src="{{ asset('user/assets/user_interface_assets/js/userpage.js') }}"></script>
</body>

</html>
