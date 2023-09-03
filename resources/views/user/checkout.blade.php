<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout</title>
    @include('user.css')
</head>

<body>
    <!-- Header Section Begin -->
    @include('user.components.header')
    <!-- Header Section End -->

    <!-- checkout Section Begin -->
    @include('user.components.check_out')
    <!-- checkout Section End -->

    <!-- Footer Section Begin -->
    @include('user.components.footer')
    <!-- Footer Section End -->

    <!-- Search Begin -->
    @include('user.components.search')
    <!-- Search End -->

    <!-- Js Plugins -->
    @include('user.js')
    <script src="{{ asset('user/assets/user_interface_assets/js/checkout.js') }}"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</body>

</html>
