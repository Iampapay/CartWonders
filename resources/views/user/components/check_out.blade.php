<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="/"><i class="fa fa-home"></i> Home</a>
                    <span>checkout</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        {{-- <div class="row">
            <div class="col-lg-12">
                <h6 class="coupon__link"><span class="icon_tag_alt"></span> <a href="#">Have a coupon?</a> Click
                    here to enter your code.</h6>
            </div>
        </div> --}}
        <form id="orderForm" class="checkout__form" autocomplete="off">
            @csrf
            <input type="hidden" name="prodIds" value="{{$ids_string}}">
            <div class="row">
                <div class="col-lg-8">
                    <h5>Billing detail</h5>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Name <span>*</span></p>
                                <input type="text" name="name" id="Name" placeholder="Name (Required)*">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Email <span>*</span></p>
                                <input type="text" name="email" id="eId" placeholder="Email Id (Required)*">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Phone <span>*</span></p>
                                <input type="text" name="phone" id="phNumber" placeholder="Phone Number (Required)*">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Get Your Current Location<span></span></p>
                                <a href="javascript:void(0);" class="btn btn-primary" id="usemyLoc"><span class="icon_pin"></span> use my location</a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Country <span>*</span></p>
                                <input type="text" name="country" id="country" placeholder="Country (Required)*">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>State <span>*</span></p>
                                <input type="text" name="state" id="state" placeholder="State (Required)*">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>Address 1<span>*</span></p>
                                <input type="text" name="address1" id="addrs1" placeholder="House No, Building Name (Required)*">
                            </div>
                            <div class="checkout__form__input">
                                <p>Address 2 <span>*</span></p>
                                <input type="text" name="address2" id="addrs2" placeholder="Road name, Area, Colony (Required)*">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="checkout__form__input">
                                <p>City <span>*</span></p>
                                <input type="text" name="city" id="city" placeholder="City (Required)*">
                            </div>
                            <div class="checkout__form__input">
                                <p>Pin Code<span>*</span></p>
                                <input type="number" name="pin" id="pinCode" placeholder="Pin Code (Required)*">
                            </div>
                        </div>
                        {{-- <div class="col-lg-12">
                            <div class="checkout__form__checkbox">
                                <label for="acc">
                                    Create an acount?
                                    <input type="checkbox" id="acc">
                                    <span class="checkmark"></span>
                                </label>
                                <p>Create am acount by entering the information below. If you are a returing
                                    customer login at the <br />top of the page</p>
                            </div>
                            <div class="checkout__form__input">
                                <p>Account Password <span>*</span></p>
                                <input type="text">
                            </div>
                            <div class="checkout__form__checkbox">
                                <label for="note">
                                    Note about your order, e.g, special noe for delivery
                                    <input type="checkbox" id="note">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__form__input">
                                <p>Oder notes <span>*</span></p>
                                <input type="text"
                                    placeholder="Note about your order, e.g, special noe for delivery">
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="checkout__order">
                        <h5>Your order</h5>
                        <div class="checkout__order__product">
                            <ul>
                                <li>
                                    <span class="top__text">Product</span>
                                    <span class="top__text__right">Total</span>
                                </li>
                                @foreach ($cartItems as $c_item)
                                    <li>{{ $loop->index + 1 }}. {{ $c_item->product_title }}
                                        ({{ $c_item->quantity }})<span>₹ {{ $c_item->price }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="checkout__order__total">
                            <ul>
                                <li>Total Item <span>{{ $total_item }}</span></li>
                                <li>Total Price <span>₹ {{ $total_price }}</span></li>
                            </ul>
                        </div>
                        <div class="checkout__order__widget">
                            {{-- <label for="o-acc">
                                Create an acount?
                                <input type="checkbox" id="o-acc">
                                <span class="checkmark"></span>
                            </label>
                            <p>Create am acount by entering the information below. If you are a returing customer
                                login at the top of the page.</p> --}}
                            {{-- <div class="form-check">
                                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    UPI <span class="icon_currency">
                                </label>
                            </div> --}}
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pay_method" id="cod" value="cod" data-rule-required="true" data-msg-required="Please select a gender" checked>
                                <label class="form-check-label" for="cod">
                                    Cash on delivery <span class="icon_wallet">
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pay_method" id="online" value="online">
                                <label class="form-check-label" for="online">
                                    Pay with Razorpay <span class="icon_creditcard">
                                </label>
                            </div>
                            {{-- <label for="check-payment">
                                Cheque payment
                                <input type="checkbox" id="check-payment">
                                <span class="checkmark"></span>
                            </label>
                            <label for="paypal">
                                PayPal
                                <input type="checkbox" id="paypal">
                                <span class="checkmark"></span>
                            </label> --}}
                        </div>
                        <button type="submit" class="btn btn-danger site-btn" id="placeOrder">Place oder</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Checkout Section End -->
