var baseUrl = window.location.origin + '/';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    // for use my location button //
    $(document).on('click', '#usemyLoc', function () {
        // alert('ok');
        getLocation();
    });

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(sendLocation);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function sendLocation(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        $.ajax({
            url: '/get-address',
            type: 'POST',
            data: { latitude: latitude, longitude: longitude },
            success: function (response) {
                console.log(response);
                // Use the response to pre-fill the address form fields
                var results = response.result;
                if (response.status == 200) {
                    $('#country').val(response.data.address.country);
                    $('#state').val(response.data.address.state);
                    $('#city').val(response.data.address.suburb);
                    $('#pinCode').val(response.data.address.postcode);
                    $('#addrs2').val(response.data.address.road);
                }
                if(response.status == 404){
                    console.log('error');
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    // for count wishlist & cart items
    function countWishCartItem() {
        $.ajax({
            type: "GET",
            url: baseUrl+'count_wish_cart_item',
            dataType: "json",
            success: function(response) {
                // console.log(response);
                if (response.status == 404) {
                    $('.total_item_in_wish').html("");
                    $('.total_item_in_wish').append('<p class="tip">'+response.total_wish_item+'</p>');
                    $('.total_item_in_cart').html("");
                    $('.total_item_in_cart').append('<p class="tip">'+response.total_cart_item+'</p>');
                } else {
                    $('.total_item_in_wish').html("");
                    $('.total_item_in_wish').append('<p class="tip">'+response.total_wish_item+'</p>');
                    $('.total_item_in_cart').html("");
                    $('.total_item_in_cart').append('<p class="tip">'+response.total_cart_item+'</p>');
                }
            }
        });
    }

    $("#orderForm").validate({
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                minlength: 10,
                maxlength: 10,
                number: true
            },
            country: {
                required: true
            },
            state: {
                required: true
            },
            address1: {
                required: true
            },
            address2: {
                required: true
            },city: {
                required: true
            },
            pin: {
                required: true,
                minlength: 6,
                maxlength: 6,
                digits: true
            }
        },
        messages: {
            email: {
                required: "Please enter your email address.",
                email: "Please enter a valid email address."
            },
            phone: {
                required: "Please enter your phone number",
                minlength: "Phone number should be 10 digits long",
                maxlength: "Phone number should be 10 digits long",
                number: "Please enter a valid phone number"
            },
            pin: {
                required: "Please enter your PIN code",
                minlength: "PIN code must be at least 6 digits",
                maxlength: "PIN code must be no more than 6 digits",
                digits: "PIN code must contain only digits"
            }
        },
        highlight: function(element) {
            $(element).parent().addClass('error');
            $(element).addClass('error');
        },
        unhighlight: function(element) {
            $(element).parent().removeClass('error');
            $(element).removeClass('error');
        },
        submitHandler: function(form) {
            var formData = new FormData($(form)[0]);

            $.ajax({
                type: 'POST',
                url: baseUrl+'place-order',
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    countWishCartItem();
                    // var options = {
                    //     "key": "YOUR_KEY_ID", // Enter the Key ID generated from the Dashboard
                    //     "amount": "50000", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                    //     "currency": "INR",
                    //     "name": "Acme Corp", //your business name
                    //     "description": "Test Transaction",
                    //     "image": "https://example.com/your_logo",
                    //     "order_id": "order_9A33XWu170gUtm", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                    //     "handler": function (response){
                    //         alert(response.razorpay_payment_id);
                    //         alert(response.razorpay_order_id);
                    //         alert(response.razorpay_signature)
                    //     },
                    //     "prefill": {
                    //         "name": "Gaurav Kumar", //your customer's name
                    //         "email": "gaurav.kumar@example.com",
                    //         "contact": "9000090000"
                    //     },
                    //     "notes": {
                    //         "address": "Razorpay Corporate Office"
                    //     },
                    //     "theme": {
                    //         "color": "#3399cc"
                    //     }
                    // };
                    // var rzp1 = new Razorpay(options);
                    // rzp1.on('payment.failed', function (response){
                    //         alert(response.error.code);
                    //         alert(response.error.description);
                    //         alert(response.error.source);
                    //         alert(response.error.step);
                    //         alert(response.error.reason);
                    //         alert(response.error.metadata.order_id);
                    //         alert(response.error.metadata.payment_id);
                    // });
                    // document.getElementById('rzp-button1').onclick = function(e){
                        // rzp1.open();
                    //     e.preventDefault();
                    // }
                },
                error: function(error) {
                    console.log(error.responseText);
                },
            });
        }
    });
})
