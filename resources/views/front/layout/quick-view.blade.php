<?php
$product = empty($product_real) ? null : $product_real;

use App\Models\ProductsImage;
use App\Models\Product;

if (!empty($product)):
    $id = $product['id'];
    $breadCrumbs = Product::breadCrumb($id);
    $product_images = ProductsImage::getProductImages($product['id']);
endif;
?>
@if(!empty($product))
<style>
        .zoom-area {
            position: relative;
        }

        .zoom-image-container {
            position: relative;
            overflow: hidden;
            cursor: zoom-in;
        }

        .zoom-image-container img {
            display: block;
            max-width: 100%;
            height: auto;
        }

        .magnifying-glass {
            position: absolute;
            display: none;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 2px solid #000;
            pointer-events: none;
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }

        .quantity-wrapper {
        display: flex;
        align-items: center;
        }

        .quantity {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
            width: 120px;
            height: 38px;
            position: relative;
        }

        .quantity-text-field {
            width: 60px;
            height: 100%;
            border: none;
            text-align: center;
            font-size: 16px;
            padding: 0 10px;
            box-sizing: border-box;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 100%;
            background-color: #f9f9f9;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .quantity-control:hover {
            background-color: #e1e1e1;
        }

        .quantity-control i {
            font-size: 18px;
            color: #555;
        }

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/3.0.8/jquery.elevatezoom.min.css">
<div id="quick-view">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button id="close_quick" type="button" class="button dismiss-button ion ion-ios-close" data-dismiss="modal"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="zoom-area">
                            <div class="zoom-image-container">
                                <img id="zoomed-image" class="img-fluid" src="{{ asset('front/images/product_images/large/'.$product['product_image']) }}" alt="Zoom Image">
                                <div class="magnifying-glass"></div>
                            </div>
                            <div id="gallery-quick-view" class="image-thumbnails">
                                @if (!empty($product_images))
                                    @foreach ($product_images as $image)
                                        <a class="image-thumbnail">
                                            <img src="{{ asset('front/images/product_images/'.$product['id'].'/small/'.$image['image']) }}" alt="Thumbnail 1" data-large-image="{{ asset('front/images/product_images/'.$product['id'].'/large/'.$image['image']) }}">
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <!-- Product-details -->
                        <div class="all-information-wrapper">
                            <div class="section-1-title-breadcrumb-rating">
                                <div class="product-title">
                                    <h1>
                                        <a href="single-product.html">@if(!empty($product_real)) {{ $product_real['product_name'] }} @endif</a>
                                    </h1>
                                </div>
                                <ul class="bread-crumb">
                                    @if (!empty($breadCrumbs))
                                        @foreach ($breadCrumbs as $key => $bread)
                                            @if (!empty($bread))
                                                <li class="has-separator">
                                                    <a href="{{ url('/'.$bread) }}">{{ $bread }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="product-rating">
                                    <div class='star' title="4.5 out of 5 - based on 23 Reviews">
                                        <span style='width:67px'></span>
                                    </div>
                                    <span>(23)</span>
                                </div>
                            </div>
                            <div class="section-2-short-description u-s-p-y-14">
                                <h6 class="information-heading u-s-m-b-8">Açıklama:</h6>
                                <p>
                                    {{ $product['description'] }}
                                </p>
                            </div>
                            <?php $discountPrice = Product::getDiscountPrice($product['id']); $save = ($product['product_price'] - $discountPrice);?>
                            <div class="section-3-price-original-discount u-s-p-y-14">
                                @if ($product['product_discount'] > 0)
                                    <div class="price">
                                        <h4>{{ $discountPrice }}</h4>
                                    </div>
                                    <div class="original-price">
                                        <span>Original Price:</span>
                                        <span>{{ $product['product_price'] }}</span>
                                    </div>
                                    <div class="discount-price">
                                        <span>İndirim:</span>
                                        <span>{{ $product['product_discount'] }}%</span>
                                    </div>
                                    <div class="total-save">
                                        <span>Kurtarılan:</span>
                                        <span>{{ $save }}</span>
                                    </div>
                                @else
                                    <div class="price">
                                        <h4>{{ $product['product_price'] }}</h4>
                                    </div>
                                @endif
                            </div>
                            <div class="section-4-sku-information u-s-p-y-14">
                                <?php $stock = Product::inStock($product['id']); $in_stock = Product::select('in_stock')->where(['id' => $product['id'], 'status' => 1])->first(); ?>
                                <h6 class="information-heading u-s-m-b-8">Sku Bilgileri:</h6>
                                @if ($in_stock['in_stock'] == "Yes")
                                    <div class="availability">
                                        <span>Durum:</span>
                                        <span>Stokta var</span>
                                    </div>
                                    <div class="left">
                                        <span>Kalan:</span>
                                        <span>{{ $stock }}</span>
                                    </div>
                                @else
                                    <div class="availability">
                                        <span>Durum:</span>
                                        <span style="color:red">Stokta yok</span>
                                    </div>
                                @endif
                            </div>
                            <div class="section-6-social-media-quantity-actions u-s-p-y-14">
                                <form action="#" class="post-form">
                                    <div class="quick-social-media-wrapper u-s-m-b-22">
                                        <span>Share:</span>
                                        <ul class="social-media-list">
                                            <li>
                                                <a href="#">
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fab fa-twitter"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fab fa-google-plus-g"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fas fa-rss"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fab fa-pinterest"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="quantity-wrapper u-s-m-b-22">
                                        <span>Miktar:</span>
                                        <div class="quantity">
                                            <input type="text" class="quantity-text-field" value="1">
                                            <div class="quantity-control minus-control">
                                                <i class="fas fa-minus"></i>
                                            </div>
                                            <div class="quantity-control plus-control">
                                                <i class="fas fa-plus"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="button button-outline-secondary" type="submit">Add to cart</button>
                                        <button class="button button-outline-secondary far fa-heart u-s-m-l-6"></button>
                                        <button class="button button-outline-secondary far fa-envelope u-s-m-l-6"></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/3.0.8/jquery.elevatezoom.min.js"></script>
    <script>
        $(document).ready(function() {

            $('.minus-control').click(function() {
                var $quantityField = $(this).siblings('.quantity-text-field');
                var value = parseInt($quantityField.val());

                if (value > 1) {
                    $quantityField.val(value - 1);
                }
            });

            $('.plus-control').click(function() {
                var $quantityField = $(this).siblings('.quantity-text-field');
                var value = parseInt($quantityField.val());
                var max = parseInt($quantityField.data('max'));

                if (isNaN(max) || value < max) {
                    $quantityField.val(value + 1);
                }
            });

            var $zoomContainer = $('.zoom-image-container');
            var $zoomedImage = $('#zoomed-image');
            var $magnifyingGlass = $('.magnifying-glass');

            function updateZoom() {
                var containerWidth = $zoomContainer.width();
                var containerHeight = $zoomContainer.height();
                var zoomedImageWidth = $zoomedImage.width();
                var zoomedImageHeight = $zoomedImage.height();

                $zoomedImage.css({
                    'left': '0',
                    'top': '0',
                    'width': '100%',
                    'height': 'auto'
                });

                var zoomedWidth = $zoomedImage.width();
                var zoomedHeight = $zoomedImage.height();

                $zoomedImage.css({
                    'width': '',
                    'height': ''
                });

                var bgPosX = -($magnifyingGlass.width() / 2) * (zoomedWidth / containerWidth);
                var bgPosY = -($magnifyingGlass.height() / 2) * (zoomedHeight / containerHeight);

                $zoomContainer.off('mousemove').on('mousemove', function(e) {
                    var offsetX = e.pageX - $zoomContainer.offset().left;
                    var offsetY = e.pageY - $zoomContainer.offset().top;
                    var zoomX = offsetX / containerWidth;
                    var zoomY = offsetY / containerHeight;

                    var bgPosX = -zoomX * (zoomedWidth - containerWidth);
                    var bgPosY = -zoomY * (zoomedHeight - containerHeight);

                    $zoomedImage.css({
                        'left': bgPosX + 'px',
                        'top': bgPosY + 'px'
                    });

                    var glassPosX = offsetX - $magnifyingGlass.width() / 2;
                    var glassPosY = offsetY - $magnifyingGlass.height() / 2;

                    $magnifyingGlass.css({
                        'left': glassPosX + 'px',
                        'top': glassPosY + 'px',
                        'background-image': 'url(' + $zoomedImage.attr('src') + ')',
                        'background-position': -bgPosX + 'px ' + -bgPosY + 'px',
                        'background-repeat': 'no-repeat',
                        'background-size': (containerWidth * zoomedWidth / containerWidth) + 'px ' + (containerHeight * zoomedHeight / containerHeight) + 'px'
                    });
                });
            }

            function initializeZoom() {
                var largeImageSrc = $('.image-thumbnail:first-child img').data('large-image');
                $zoomedImage.attr('src', largeImageSrc);
                updateZoom();
            }

            $('.image-thumbnail').click(function() {
                var largeImageSrc = $(this).find('img').data('large-image');
                $zoomedImage.attr('src', largeImageSrc);
                updateZoom();
            });

            $zoomContainer.hover(
                function() {
                    $magnifyingGlass.fadeIn();
                },
                function() {
                    $magnifyingGlass.fadeOut();
                }
            );

            $(window).on('resize', function() {
                updateZoom();
            });

            initializeZoom();
        });
    </script>

@endif

