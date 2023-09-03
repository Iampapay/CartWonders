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

    fetchCartItem();

    function fetchCartItem() {
        var item_id = [];
        $.ajax({
            type: "GET",
            url: baseUrl+'fetch_cart_item',
            dataType: "json",
            success: function(response) {
                // console.log(response);
                if (response.status == 404) {
                    window.location.href = "login";
                    toastr.options.closeButton = true;
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.closeDuration = 200;
                    toastr.options.showMethod = 'slideDown';
                    toastr.options.hideMethod = 'slideUp';
                    toastr.options.closeMethod = 'slideUp';
                    toastr.options.progressBar = true;
                    toastr.error(response.message);
                } else if(response.status == 400){
                    $('#cart_empty').html("");
                    $('#cart_empty').append('<div class="col-md-12 alert alert-danger" role="alert">\
                                                <strong>'+response.message+'</strong>\
                                            </div>\
                                            <div class="col-md-6">\
                                                <a href="/" class="btn btn-info float-right mb-2">shop now</a>\
                                            </div>');
                } else {
                    var total_item = 0;
                    var total_price = 0;
                    $('tbody').html("");
                    for (var i=0; i < response.cart_details.length; i++) {
                        item_id.push(btoa(response.cart_details[i].product_id));
                    }
                    $.each(response.cart_details, function(key, item) {
                        // item_id = parseInt(item.product_id);
                        total_item = total_item+parseInt(item.quantity);
                        total_price = total_price+parseInt(item.price);
                        $('tbody').append(' <tr>\
                                                <td class="cart__product__item">\
                                                    <a href="#"><img src="/product-Image/' + item.image + '" style="width: 75px;height: 55px; " alt="">\
                                                    <div class="cart__product__item__title mt-2">\
                                                        <h6>' + item.product_title + '</h6></a>\
                                                    </div>\
                                                </td>\
                                                <td class="cart__quantity">\
                                                    <div class="pro-qty">\
                                                        <input type="hidden" id="in_cart_itm_id" value="'+ item.id +'">\
                                                        <input type="hidden" id="cart_itm_price" value="'+ item.price +'">\
                                                        <input type="hidden" id="cart_prod_id" value="'+ item.product_id +'">\
                                                        <button class="mr-3 decr" style="line-height: 50px;">-</button>\
                                                        <button class="mr-3" min="1" id="cart_itm_qty" value="'+ item.quantity +'" disabled>'+ item.quantity +'</button>\
                                                        <button class="incr">+</button>\
                                                    </div>\
                                                </td>\
                                                <td class="cart__total">₹ ' + item.price + '</td>\
                                                <td><button class="btn btn-outline-warning text-dark move_wish" data-remove_id="'+item.id+'" value="'+item.product_id+'"><span title="move to wishlist" class="icon_heart_alt"></span></button></td>\
                                                <td><button class="btn btn-outline-danger text-dark removebtn" value="'+item.id+'"><span title="Delete" class="icon_trash_alt"></span></button></td>\
                                            \</tr>');
                    });
                    $('#CartTotal').html("");
                    $('#CartTotal').append('<div class="col-lg-6">\
                                                <div class="discount__content">\
                                                    <h6>Discount codes</h6>\
                                                    <form action="#">\
                                                        <input type="text" placeholder="Enter your coupon code">\
                                                        <button type="submit" class="btn btn-info text-dark" style="border-radius: 50px;padding: 9px 20px;">Apply</button>\
                                                    </form>\
                                                </div>\
                                            </div>\
                                            <div class="col-lg-4 offset-lg-2">\
                                                <div class="cart__total__procced">\
                                                    <h6>Cart total</h6>\
                                                    <ul>\
                                                        <li>Total Item<span><button class="total-itm" value="0" disabled> '+total_item+'</button></span></li>\
                                                        <li>Total Price<span><button class="total-prc" value="0" disabled>₹ '+total_price+'</button></span></li>\
                                                    </ul>\
                                                    <form action="checkout" method="get">\
                                                        <input type="hidden" name="hg67ghcf" value="'+item_id+'">\
                                                        <input type="hidden" name="shdyw2ji" value="'+btoa(total_item)+'">\
                                                        <input type="hidden" name="hd53wsdp" value="'+btoa(total_price)+'">\
                                                        <a href="JavaScript:Void(0);" class="primary-btn btn-outline-success" onclick="this.parentNode.submit()">Proceed to checkout</a>\
                                                    </form>\
                                                </div>\
                                            \</div>');
                }
            }
        });
    }


    // for changing (+) Quantity & price in cart //
    $(document).on('click', '.incr', function(e) {
        e.preventDefault();
        var req_type = 'inc';
        var cart_itm_id = $(this).closest('.pro-qty').find('#in_cart_itm_id').val();
        var prod_id = $(this).closest('.pro-qty').find('#cart_prod_id').val();
        var present_val = $(this).closest('.pro-qty').find('#cart_itm_qty').val();
        var present_price = $(this).closest('.pro-qty').find('#cart_itm_price').val();
        $.ajax({
            type: 'POST',
            url: baseUrl+'update_cart_details',
            data: {
                req_type: req_type,
                cart_itm_id: cart_itm_id,
                productid: prod_id,
                presentval: present_val,
                presentprice: present_price,
            },
            dataType: 'json',
            success: function(response) {
                // console.log(response);
                if(response.status == 200){
                    fetchCartItem();
                }else{
                    toastr.options.closeButton = true;
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.closeDuration = 200;
                    toastr.options.showMethod = 'slideDown';
                    toastr.options.hideMethod = 'slideUp';
                    toastr.options.closeMethod = 'slideUp';
                    toastr.options.progressBar = true;
                    toastr.error(response.message);
                }
            },
            error: function(error) {
                console.log(error.responseText);
            },
        });
    });

    // for changing (-) Quantity & price in cart //
    $(document).on('click', '.decr', function(e) {
        e.preventDefault();
        var req_type = 'dec';
        var cart_itm_id = $(this).closest('.pro-qty').find('#in_cart_itm_id').val();
        var prod_id = $(this).closest('.pro-qty').find('#cart_prod_id').val();
        var present_val = $(this).closest('.pro-qty').find('#cart_itm_qty').val();
        var present_price = $(this).closest('.pro-qty').find('#cart_itm_price').val();
        $.ajax({
            type: 'POST',
            url: baseUrl+'update_cart_details',
            data: {
                req_type: req_type,
                cart_itm_id: cart_itm_id,
                productid: prod_id,
                presentval: present_val,
                presentprice: present_price,
            },
            dataType: 'json',
            success: function(response) {
                // console.log(response);
                if(response.status == 200){
                    fetchCartItem();
                }else{
                    toastr.options.closeButton = true;
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.options.closeDuration = 200;
                    toastr.options.showMethod = 'slideDown';
                    toastr.options.hideMethod = 'slideUp';
                    toastr.options.closeMethod = 'slideUp';
                    toastr.options.progressBar = true;
                    toastr.error(response.message);
                }
            },
            error: function(error) {
                console.log(error.responseText);
            },
        });
    });

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

    // for select item in cart //
    // $(document).on('click', '#is_select', function() {
    //     // var is_checked = event.target.checked;
    //     var req_type = 'selct-itm'
    //     var itm_id = $(this).data('prod_auto_id');
    //     var present_btn = $('.total-btn').val();
    //     var present_qty = $('.total-itm').val();
    //     var present_prc = $('.total-prc').val();
    //     var itm_qty = $(this).closest('.select-item').find('#cart_itm_qty').val();
    //     var itm_price = $(this).data('prod_auto_prc');
    //     if ($(this).is(':checked')) {
    //         // $(this).prop('checked',false);
    //         var chk_typ = 'checked';
    //     } else {
    //         // $(this).prop('checked',true);
    //         var chk_typ = 'unchecked';
    //     }
    //     $.ajax({
    //         type: 'POST',
    //         url: "update_cart_details",
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
    //                 'content')
    //         },
    //         data: {
    //             req_type: req_type,
    //             chk: chk_typ,
    //             itm_id: itm_id,
    //             present_btn: present_btn,
    //             present_qty: present_qty,
    //             present_prc: present_prc,
    //             itm_qty: itm_qty,
    //             itm_price: itm_price,
    //         },
    //         dataType: 'json',
    //         success: function(response) {
    //             console.log(response);
    //             if(response.status == 200){
    //                 $('.total-btn').val(response.itm_id);
    //                 $('.total-itm').val(response.total_quantity);
    //                 $('.total-prc').val(response.total_price);
    //                 $('.total-itm').html(response.total_quantity);
    //                 $('.total-prc').html(response.total_price);
    //             }else{
    //                 toastr.options.closeButton = true;
    //                 toastr.options.positionClass = 'toast-top-right';
    //                 toastr.options.closeDuration = 200;
    //                 toastr.options.showMethod = 'slideDown';
    //                 toastr.options.hideMethod = 'slideUp';
    //                 toastr.options.closeMethod = 'slideUp';
    //                 toastr.options.progressBar = true;
    //                 toastr.error('Something went wrong!');
    //             }
    //         },
    //         error: function(error) {
    //             console.log(error.responseText);
    //         },
    //     });
    // });

    // for move to wishlist //
    $(document).on('click', '.move_wish', function(e) {
        e.preventDefault();
        var mId = $(this).val();
        var rId = $(this).data('remove_id')
        swal({
                title: "Are you sure ?",
                text: "Item will be moved to wishlist !",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, move it !",
                cancelButtonText: "No, cancel plx !",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: 'GET',
                        url: baseUrl+'add_to_wishlist',
                        data: {
                            mId: mId,
                            rId: rId
                        },
                        dataType: 'json',
                        success: function(response) {
                            // console.log(response);
                            if (response.status == 200) {
                                swal("Moved !", response.message, "success");
                                fetchCartItem();
                                countWishCartItem()
                            } else if(response.status == 202){
                                swal("Sorry !", response.message, "error");
                            }
                        },
                        error: function(error) {
                            console.log(error.responseText);
                        },
                    });
                } else {
                    swal("Cancelled", "Item is safe in cart:)", "error");
                }
            }
        );
    });

    // for delete cart data //
    $(document).on('click', '.removebtn', function(e) {
        e.preventDefault();
        var id = $(this).val();
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: 'POST',
                        url: baseUrl+'remove_from_cart/' + id,
                        dataType: 'json',
                        success: function(response) {
                            // console.log(response);
                            if (response.status == 200) {
                                fetchCartItem();
                                countWishCartItem()
                            }
                        },
                        error: function(error) {
                            console.log(error.responseText);
                        },
                    });
                    swal("Deleted!", "Item has been deleted.", "success");
                } else {
                    swal("Cancelled", "Item is safe :)", "error");
                }
            }
        );
    });
});
