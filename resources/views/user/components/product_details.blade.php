<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="/"><i class="fa fa-home"></i> Home</a>
                    <span>Product Details</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->
<section class="product-details spad">
    <div class="container">
        <div class="row">
            @foreach ($selected_prod_data as $spd)
                <div class="col-lg-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__left product__thumb nice-scroll">
                            <a class="pt active" href="#product-1">
                                <img src="{{ asset("product-Image/$spd->image") }}" alt="">
                            </a>
                            <a class="pt" href="#product-2">
                                <img src="{{ asset("product-Image/$spd->image") }}" alt="">
                            </a>
                            <a class="pt" href="#product-3">
                                <img src="{{ asset("product-Image/$spd->image") }}" alt="">
                            </a>
                            <a class="pt" href="#product-4">
                                <img src="{{ asset("product-Image/$spd->image") }}" alt="">
                            </a>
                        </div>
                        <div class="product__details__slider__content">
                            <div class="product__details__pic__slider owl-carousel">
                                <img data-hash="product-1" class="product__big__img"
                                    src="{{ asset("product-Image/$spd->image") }}" alt="">
                                <img data-hash="product-2" class="product__big__img"
                                    src="{{ asset("product-Image/$spd->image") }}" alt="">
                                <img data-hash="product-3" class="product__big__img"
                                    src="{{ asset("product-Image/$spd->image") }}" alt="">
                                <img data-hash="product-4" class="product__big__img"
                                    src="{{ asset("product-Image/$spd->image") }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product__details__text">
                        <h3>{{ $spd->title }} <span>{{ $spd->category }}</span></h3>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <span>( 138 reviews )</span>
                        </div>
                        @if ($spd->discount_price == null)
                            <div class="product__details__price"><div class="product__curr__price"> ₹ {{ $spd->price }} </div></div>
                        @endif
                        @if ($spd->discount_price != null)
                            <div class="product__details__price"><div class="product__curr__price"> ₹ {{ $spd->discount_price }} </div><span class="product__actual__price">₹
                                    {{ $spd->price }}</span></div>
                        @endif
                        <p>{{ $spd->description }}</p>
                        <div class="product__details__button">
                            <div class="quantity">
                                <span>Quantity:</span>
                                <div class="pro-qty">
                                    <input type="number" name="select_qty" value="1" disabled>
                                    <input type="hidden" name="avl_qty" value="{{ $spd->quantity }}">
                                    @if ($spd->discount_price == null)
                                        <input type="hidden" name="itm_prc" value="{{ $spd->price }}">
                                    @endif
                                    @if ($spd->discount_price != null)
                                        <input type="hidden" name="itm_prc" value="{{ $spd->discount_price }}">
                                        <input type="hidden" name="ict_prc" value="{{ $spd->price }}">
                                    @endif
                                </div>
                            </div>
                            <ul>
                                <li><button title="Add to wishlist" id="add_wish" value="{{ $spd->id }}"><span
                                            class="icon_heart_alt"></span></button></li>
                                <li><button title="Add to cart" class="cart-btn" id="add_cart" value="{{ $spd->id }}"><span
                                            class="icon_cart_alt"></span></button></li>
                                <li><button href="#"><span class="icon_adjust-horiz"></span></button></li>
                            </ul>
                        </div>
                        <div class="product__details__widget">
                            <ul>
                                <li>
                                    <span>Availability:</span>
                                    <div class="stock__checkbox">
                                        <label for="stockin">
                                            In Stock
                                            <input type="checkbox" id="stockin">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <span>Available color:</span>
                                    <div class="color__checkbox">
                                        <label for="red">
                                            <input type="radio" name="color__radio" id="red" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label for="black">
                                            <input type="radio" name="color__radio" id="black">
                                            <span class="checkmark black-bg"></span>
                                        </label>
                                        <label for="grey">
                                            <input type="radio" name="color__radio" id="grey">
                                            <span class="checkmark grey-bg"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <span>Available size:</span>
                                    <div class="size__btn">
                                        <label for="xs-btn" class="active">
                                            <input type="radio" id="xs-btn">
                                            xs
                                        </label>
                                        <label for="s-btn">
                                            <input type="radio" id="s-btn">
                                            s
                                        </label>
                                        <label for="m-btn">
                                            <input type="radio" id="m-btn">
                                            m
                                        </label>
                                        <label for="l-btn">
                                            <input type="radio" id="l-btn">
                                            l
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <span>Promotions:</span>
                                    <p>Free shipping</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1"
                                    role="tab">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2"
                                    role="tab">Specification</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Reviews ( 2
                                    )</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <h6>Description</h6>
                                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                                    quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                                    Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                                    voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                                    consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                                    consequat massa quis enim.</p>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                    dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                    nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                    quis, sem.</p>
                            </div>
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <h6>Specification</h6>
                                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                                    quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                                    Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                                    voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                                    consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                                    consequat massa quis enim.</p>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                    dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                    nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                    quis, sem.</p>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <h6>Reviews ( 2 )</h6>
                                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                                    quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                                    Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                                    voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                                    consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                                    consequat massa quis enim.</p>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                    dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                    nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                    quis, sem.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row" style="justify-content: center;">
            <div class="col-lg-12 text-center">
                <div class="related__title">
                    <h5>RELATED PRODUCTS</h5>
                </div>
            </div>
            @if ($related_prod_count > 4)
                <div class="owl-carousel owl-theme">
                    @foreach ($related_prod_data as $rpd)
                        <div class="item">
                            <div class="product__item">
                                <div class="product__item__pic set-bg"
                                    data-setbg="{{ asset("product-Image/$rpd->image") }}">
                                    @if ($rpd->discount_price == null)
                                        <div class="label new">New</div>
                                    @endif
                                    @if ($rpd->discount_price != null)
                                        <div class="label sale">Sale</div>
                                    @endif
                                    <ul class="product__hover">
                                        <li><button class="pro_details" value="{{ $rpd->id }}"
                                                title="View Details"><span class="arrow_expand"></span></button></li>
                                        <li><button id="add_wish" value="{{ $rpd->id }}"
                                                title="Add to wishlist"><span class="icon_heart_alt"></span></button>
                                        </li>
                                        <li><button id="add_cart" value="{{ $rpd->id }}"
                                                title="Add to Cart"><span class="icon_cart"></span></button></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><button id="view_prod"
                                            value="{{ $rpd->id }}">{{ $rpd->title }}</button>
                                    </h6>
                                    <div class="rating">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    @if ($rpd->discount_price == null)
                                        <div class="product__price">₹ {{ $spd->price }} </div>
                                    @endif
                                    @if ($rpd->discount_price != null)
                                        <div class="product__price" style="text-decoration: line-through;">₹
                                            {{ $rpd->price }}</div>
                                        <div class="product__price">₹ {{ $rpd->discount_price }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if ($related_prod_count < 4)
                @foreach ($related_prod_data as $rpd)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg"
                                data-setbg="{{ asset("product-Image/$rpd->image") }}">
                                @if ($rpd->discount_price == null)
                                    <div class="label new">New</div>
                                @endif
                                @if ($rpd->discount_price != null)
                                    <div class="label sale">Sale</div>
                                @endif
                                <ul class="product__hover">
                                    <li><button class="pro_details" value="{{ $rpd->id }}"
                                            title="View Details"><span class="arrow_expand"></span></button></li>
                                    <li><button id="add_wish" value="{{ $rpd->id }}"
                                            title="Add to wishlist"><span class="icon_heart_alt"></span></button></li>
                                    <li><button id="add_cart" value="{{ $rpd->id }}" title="Add to Cart"><span
                                                class="icon_cart"></span></button></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><button id="view_prod" value="{{ $rpd->id }}">{{ $rpd->title }}</button>
                                </h6>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                @if ($rpd->discount_price == null)
                                    <div class="product__price">₹ {{ $spd->price }} </div>
                                @endif
                                @if ($rpd->discount_price != null)
                                    <div class="product__price" style="text-decoration: line-through;">₹
                                        {{ $rpd->price }}</div>
                                    <div class="product__price">₹ {{ $rpd->discount_price }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            @if ($related_prod_count == null)
                <div class="col-md-12 alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>not found</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        <div class="modal fade bd-example-modal-lg" id="view_details" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <strong>
                            <h5 class="modal-title p_title"></h5>
                        </strong>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="product__details__pic">
                                        <div class="product__details__pic__left product__thumb nice-scroll">
                                            <a class="pt active" href="#product-1">
                                                <img class="p_image" src="" alt="">
                                            </a>
                                            <a class="pt" href="#product-2">
                                                <img class="p_image" src="" alt="">
                                            </a>
                                            <a class="pt" href="#product-3">
                                                <img class="p_image" src="" alt="">
                                            </a>
                                            <a class="pt" href="#product-4">
                                                <img class="p_image" src="" alt="">
                                            </a>
                                        </div>
                                        <div class="product__details__slider__content">
                                            <div class="product__details__pic__slider owl-carousel">
                                                <img data-hash="product-1" class="product__big__img p_image"
                                                    src="" alt="">
                                                <img data-hash="product-2" class="product__big__img p_image"
                                                    src="" alt="">
                                                <img data-hash="product-3" class="product__big__img p_image"
                                                    src="" alt="">
                                                <img data-hash="product-4" class="product__big__img p_image"
                                                    src="" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
