<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="section-title">
                    <h4>New product</h4>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">All</li>
                    <li data-filter=".women">Women’s</li>
                    <li data-filter=".men">Men’s</li>
                    <li data-filter=".kid">Kid’s</li>
                    <li data-filter=".accessories">Accessories</li>
                    <li data-filter=".cosmetic">Cosmetics</li>
                </ul>
            </div>
        </div>
        <div class="row property__gallery" id="product_gallery">

        </div>
        <div class="mt-3 text-center">
            <button class="btn btn-sm btn-outline-primary" style="padding: 10px;border-radius: 30px;" value="4"
                id="load_more">
                View More Products
            </button>
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
