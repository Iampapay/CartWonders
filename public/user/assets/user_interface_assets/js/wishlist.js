var baseUrl = window.location.origin + '/';
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function(){

    fetchWishlitItem();

    function fetchWishlitItem() {
        $.ajax({
            type: "GET",
            url: baseUrl+'fetch_wishlist_item',
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
                    $('#wishlist_empty').html("");
                    $('#wishlist_empty').append('<div class="alert alert-danger alert-dismissible fade show" role="alert">\
                                                <strong>'+response.message+'</strong>\
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                                                <span aria-hidden="true">&times;</span>\
                                                </button>\
                                            \</div>');
                } else {
                    $('#wishlist_itm').html("");
                    $.each(response.wishlist_details, function(key, item) {
                        var dateString = item.created_at;
                        var date = new Date(dateString);
                        var options = { year: 'numeric', month: 'short', day: 'numeric' };
                        var formattedDate = date.toLocaleString('en-US', options);
                        formattedDate = formattedDate.replace(',','');
                        $('#wishlist_itm').append('<div class="col-lg-4 col-md-4 col-sm-6">\
                                                        <div class="blog__item">\
                                                            <div class="image-container">\
                                                                <div class="blog__item__pic set-bg" data-setbg="/product-Image/'+ item.image +'" style="background-image: url(/product-Image/'+ item.image +')"></div>\
                                                                <button id="add_cart" class="btn btn-outline-primary" value="'+ item.product_id +'" title="Add to cart"><span class="icon_cart"></span></button>\
                                                                <button id="remove_wish" class="btn btn-sm btn-outline-danger" value="'+ item.id +'" title="Remove from wishlist"><span class="icon_trash_alt"></span></button>\
                                                            </div>\
                                                            <div class="blog__item__text">\
                                                                <h6><a href="#">'+ item.title +'</a></h6>\
                                                                <ul>\
                                                                    <li><span>'+ item.category +'</span></li>\
                                                                    <li>'+ formattedDate +'</li>\
                                                                </ul>\
                                                            </div>\
                                                        </div>\
                                                    \</div>');
                    });
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
                        countWishCartItem();
                        toastr.options.closeButton = true;
                        toastr.options.positionClass = 'toast-top-right';
                        toastr.options.closeDuration = 200;
                        toastr.options.showMethod = 'slideDown';
                        toastr.options.hideMethod = 'slideUp';
                        toastr.options.closeMethod = 'slideUp';
                        toastr.options.progressBar = true;
                        toastr.success(response.message);
                    }
            },
            error: function(error) {
                console.log(error.responseText);
            }
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

    // for delete wishlist data //
    $(document).on('click', '#remove_wish', function(e) {
        e.preventDefault();
        let id = $(this).val();
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
                        url: baseUrl+'remove_from_wishlist/' + id,
                        dataType: 'json',
                        success: function(response) {
                            // console.log(response);
                            if (response.status == 200) {
                                swal("Deleted!", "Item has been removed.", "success");
                                fetchWishlitItem();
                                countWishCartItem();
                            }
                        },
                        error: function(error) {
                            console.log(error.responseText);
                        },
                    });
                } else {
                    swal("Cancelled", "Item is safe :)", "error");
                }
            }
        );
    });
});
