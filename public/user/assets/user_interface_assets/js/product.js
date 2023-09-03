var baseUrl = window.location.origin + '/';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.owl-carousel').owlCarousel({
    autoplay: true,
    autoplayTimeout: 3000,
    autoplayHoverPause: false,
    items: 1,
    stagePadding: 20,
    center: true,
    nav: false,
    navText: ["<i class='arrow_carrot-left'></i>","<i class='arrow_carrot-right'></i>"],
    margin: 50,
    dots: false,
    loop: true,
    responsive: {
        0: { items: 1 },
        480: { items: 2 },
        575: { items: 2 },
        768: { items: 2 },
        991: { items: 3 },
        1200: { items: 4 }
    }
})

$(document).ready(function() {
    countWishCartItem();

    function countWishCartItem() {
        $.ajax({
            url: baseUrl+'count_wish_cart_item',
            type: "GET",
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

    // for add to cart button //
    $(document).on('click', '#add_cart', function(e){
        e.preventDefault();
        var p_id = $(this).val();
        $.ajax({
            type: 'GET',
            url: baseUrl+'add_to_cart',
            data: {
                prod_id: p_id
            },
            dataType: 'json',
            success: function(response) {
                // console.log(response);
                    if(response.status == 404){
                        toastr.options.closeButton = true;
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.options.closeDuration = 200;
                        toastr.options.showMethod = 'slideDown';
                        toastr.options.hideMethod = 'slideUp';
                        toastr.options.closeMethod = 'slideUp';
                        toastr.options.progressBar = true;
                        toastr.error(response.message);
                        setTimeout(function() {
                            window.location.href = baseUrl+'login';
                        }, 1000);
                    }else if(response.status == 202){
                        toastr.options.closeButton = true;
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.options.closeDuration = 200;
                        toastr.options.showMethod = 'slideDown';
                        toastr.options.hideMethod = 'slideUp';
                        toastr.options.closeMethod = 'slideUp';
                        toastr.options.progressBar = true;
                        toastr.error(response.message);
                    } else{
                        toastr.options.closeButton = true;
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.options.closeDuration = 200;
                        toastr.options.showMethod = 'slideDown';
                        toastr.options.hideMethod = 'slideUp';
                        toastr.options.closeMethod = 'slideUp';
                        toastr.options.progressBar = true;
                        toastr.success(response.message);
                        countWishCartItem();
                    }
            },
            error: function(error) {
                console.log(error.responseText);
            }
        });
    });

    // for add to wishlist button //
    $(document).on('click', '#add_wish', function(e){
        e.preventDefault();
        var p_id = $(this).val();
        $.ajax({
            type: 'GET',
            url: baseUrl+'add_to_wishlist',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            },
            data: {
                prod_id: p_id
            },
            dataType: 'json',
            success: function(response) {
                // console.log(response);
                if(response.status == 404){
                    toastr.options.closeButton = true;
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.closeDuration = 200;
                    toastr.options.showMethod = 'slideDown';
                    toastr.options.hideMethod = 'slideUp';
                    toastr.options.closeMethod = 'slideUp';
                    toastr.options.progressBar = true;
                    toastr.error(response.message);
                    setTimeout(function() {
                        window.location.href = baseUrl+'login';
                    }, 1000);
                }else if(response.status == 202){
                    toastr.options.closeButton = true;
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.closeDuration = 200;
                    toastr.options.showMethod = 'slideDown';
                    toastr.options.hideMethod = 'slideUp';
                    toastr.options.closeMethod = 'slideUp';
                    toastr.options.progressBar = true;
                    toastr.error(response.message);
                } else{
                    toastr.options.closeButton = true;
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.closeDuration = 200;
                    toastr.options.showMethod = 'slideDown';
                    toastr.options.hideMethod = 'slideUp';
                    toastr.options.closeMethod = 'slideUp';
                    toastr.options.progressBar = true;
                    toastr.success(response.message);
                    countWishCartItem()
                }
            },
            error: function(error) {
                console.log(error.responseText);
            }
        });
    });

    // for product details button //
    $(document).on('click', '.pro_details', function(){
        var p_id = $(this).val();
        $("#view_details").modal('show');
        $.ajax({
            type: 'GET',
            url: baseUrl+'fetch_product_for_user',
            data: {
                prod_id: p_id
            },
            dataType: 'json',
            success: function(response) {
                // console.log(response.prod_details[0]);
                $(".p_title").val(response.prod_details[0].id);
                $(".p_title").html(response.prod_details[0].title);
                var p_image = '/product-Image/' + response.prod_details[0].image;
                $('.p_image').attr("src", p_image);
            },
            error: function(error) {
                console.log(error.responseText);
            }
        });
    });

    // for view product details on new page //
    $(document).on('click', '#view_prod', function(){
        var prd_id = $(this).val();
        $.ajax({
            type: 'GET',
            url: baseUrl+'product',
            data: {
                prd_id: prd_id
            },
            dataType: 'json',
            success: function(response) {
                // console.log(response.prod_data[0]);
                let encryptedData = btoa(response.prod_data[0].id);
                window.open(
                    baseUrl+'product' + "/?h7khde4rr45c9h=" + encryptedData,
                );
            },
            error: function(error) {
                console.log(error.responseText);
            }
        });
    });
});
