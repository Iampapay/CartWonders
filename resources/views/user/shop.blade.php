<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping</title>
    @include('user.css')
</head>

<body>
    <!-- Header Section Begin -->
    @include('user.components.header')
    <!-- Header Section End -->

    <!-- shopping Section Begin -->
    @include('user.components.shopbyCategory')
    <!-- shopping Section End -->

    <!-- Footer Section Begin -->
    @include('user.components.footer')
    <!-- Footer Section End -->

    <!-- Search Begin -->
    @include('user.components.search')
    <!-- Search End -->

    <!-- Js Plugins -->
    @include('user.js')
    {{-- <script src="{{ asset('user/assets/user_interface_assets/js/checkout.js') }}"></script> --}}
</body>

</html>
