$(document).ready(function() {

    fetch_product_for_user();

    function fetch_product_for_user() {
        $.ajax({
            type: "GET",
            url: "fetch_product_for_user",
            dataType: "json",
            success: function(response) {
                // console.log(response);
                if (response.status == 404) {
                    toastr.options.closeButton = true;
                    toastr.options.positionClass = 'toast-top-center';
                    toastr.options.closeDuration = 200;
                    toastr.options.showMethod = 'slideDown';
                    toastr.options.hideMethod = 'slideUp';
                    toastr.options.closeMethod = 'slideUp';
                    toastr.options.progressBar = true;
                    toastr.error(response.message);
                } else {
                    $('#product_gallery').html("");
                    $.each(response.prod_details, function(key, item) {
                        // console.log(item);
                        if(item.discount_price != null){
                            var has_discount = '';
                            var text_deco = 'text-decoration: line-through;';
                            var sale = '';
                            var new_prod = 'd-none';
                        }else{
                            var has_discount = 'd-none';
                            var text_deco = '';
                            var sale = 'd-none';
                            var new_prod = '';
                        }
                        $('#product_gallery').append(
                            '<div class="col-lg-3 col-md-4 col-sm-6 mix women">\
                               <div class="product__item">\
                                    <div class="product__item__pic set-bg" data-setbg="/product-Image/'+ item.image + '"style="background-image: url(/product-Image/'+ item.image +')">\
                                        <div class="label '+new_prod+' new">New</div>\
                                        <div class="label '+sale+' sale">Sale</div>\
                                        <ul class="product__hover">\
                                            <li><button class="pro_details" value="'+ item.id +'" title="View Details"><span class="arrow_expand"></span></button></li>\
                                            <li><button id="add_wishlist" value="'+ item.id +'" title="Add to wishlist"><span class="icon_heart_alt"></span></button></li>\
                                            <li><button id="add_cart" value="'+ item.id +'" title="Add to Cart"><span class="icon_cart"></span></button></li>\
                                        </ul>\
                                    </div>\
                                    <div class="product__item__text">\
                                        <h6><button id="view_prod" value="'+ item.id +'">'+item.title+'</button></h6>\
                                        <div class="rating">\
                                            <i class="fa fa-star"></i>\
                                            <i class="fa fa-star"></i>\
                                            <i class="fa fa-star"></i>\
                                            <i class="fa fa-star"></i>\
                                            <i class="fa fa-star"></i>\
                                        </div>\
                                        <div class="product__price" style="'+text_deco+'">₹ '+item.price+'</div>\
                                        <div class="product__price ' + has_discount + '">₹ '+item.discount_price+'</div>\
                                    </div>\
                                </div>\
                            \</div>'
                        );
                    });
                }
            }
        });
    }

    function countWishCartItem() {
        $.ajax({
            url: 'count_wish_cart_item',
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

    // for load more button //
   $(document).on('click', '#load_more', function(){
        var num_of_prod = $(this).val();
        $('#load_more').html("Loading...");
        $.ajax({
            type: 'GET',
            url: "fetch_product_for_user",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            },
            data:{
                num_of_prod : num_of_prod,
            },
            dataType:"json",
            success:function(response){
                console.log(response);
                if(response.status != 604){
                    $('#load_more').html("View More products");
                    $('#load_more').val(response.prod_count);
                    $('#product_gallery').html("");
                    $.each(response.prod_details, function(key, item) {
                        // console.log(item);
                        if(item.discount_price != null){
                            var has_discount = '';
                            var text_deco = 'text-decoration: line-through;';
                            var sale = '';
                            var new_prod = 'd-none';
                        }else{
                            var has_discount = 'd-none';
                            var text_deco = '';
                            var sale = 'd-none';
                            var new_prod = '';
                        }
                        $('#product_gallery').append(
                            '<div class="col-lg-3 col-md-4 col-sm-6 mix women">\
                                <div class="product__item">\
                                    <div class="product__item__pic set-bg" data-setbg="/product-Image/'+ item.image + '"style="background-image: url(/product-Image/'+ item.image +')">\
                                        <div class="label '+new_prod+' new">New</div>\
                                        <div class="label '+sale+' sale">Sale</div>\
                                        <ul class="product__hover">\
                                            <li><button class="pro_details" value="'+ item.id +'" title="View Details"><span class="arrow_expand"></span></button></li>\
                                            <li><button id="add_wishlist" value="'+ item.id +'" title="Add to wishlist"><span class="icon_heart_alt"></span></button></li>\
                                            <li><button id="add_cart" value="'+ item.id +'" title="Add to Cart"><span class="icon_cart"></span></button></li>\
                                        </ul>\
                                    </div>\
                                    <div class="product__item__text">\
                                        <h6><button id="view_prod" value="'+ item.id +'" target="_blank">'+item.title+'</button></h6>\
                                        <div class="rating">\
                                            <i class="fa fa-star"></i>\
                                            <i class="fa fa-star"></i>\
                                            <i class="fa fa-star"></i>\
                                            <i class="fa fa-star"></i>\
                                            <i class="fa fa-star"></i>\
                                        </div>\
                                        <div class="product__price" style="'+text_deco+'">₹ '+item.price+'</div>\
                                        <div class="product__price ' + has_discount + '">₹ '+item.discount_price+'</div>\
                                    </div>\
                                </div>\
                            \</div>'
                        );
                    });
                }
                else
                {
                    $('#load_more').html(response.message);
                }
            }
        });
    });

    // for product details button //
    $(document).on('click', '.pro_details', function(){
        var p_id = $(this).val();
        $("#view_details").modal('show');
        $.ajax({
            type: 'GET',
            url: "fetch_product_for_user",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            },
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
            url: "product",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            },
            data: {
                prd_id: prd_id
            },
            dataType: 'json',
            success: function(response) {
                // console.log(response.prod_data[0]);
                let encryptedData = btoa(response.prod_data[0].id);
                window.open(
                'product' + "/?h7khde4rr45c9h=" + encryptedData,
                );
            },
            error: function(error) {
                console.log(error.responseText);
            }
        });
    });

    // for add to cart button //
    $(document).on('click', '#add_cart', function(){
        var p_id = $(this).val();
        $.ajax({
            type: 'GET',
            url: "add_to_cart",
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
                            window.location.href = "login";
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
    $(document).on('click', '#add_wishlist', function(){
        var p_id = $(this).val();
        $.ajax({
            type: 'GET',
            url: "add_to_wishlist",
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
                            window.location.href = "login";
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
});
