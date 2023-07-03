<?php 
use App\Models\Product;
?>
@extends('front.layout.layout')
@section('content')
<!-- Main-Slider -->
    <div class="default-height ph-item">
        <div class="slider-main owl-carousel">
            @foreach ($sliderBanners as $sliderBanner)

                <div class="bg-image">
                    <div class="slide-content">
                        <h1><a @if(!empty($sliderBanner['link'])) href="{{ url($sliderBanner['link']) }}" @else href="javascript:;" @endif><img src="{{ asset('front/images/banner_images/'.$sliderBanner['image']) }}" alt="{{ $sliderBanner['alt'] }}"></a></h1>
                        <h2>{{ $sliderBanner['title'] }}</h2>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
    <!-- Main-Slider /- -->
    @if(isset($fixBanners[0]['image']))
    <!-- Banner-Layer -->
    <div class="banner-layer">
        <div class="container">
            <div class="image-banner">
                <a target="_blank" rel="nofollow" href="{{ url($fixBanners[0]['link']) }}" class="mx-auto banner-hover effect-dark-opacity">
                    <img class="img-fluid" src="{{ asset('front/image/banner_images/'.$fixBanners[0]['image']) }}" alt="{{ $fixBanners[0]['alt'] }}" title="{{ $fixBanners[0]['title'] }}">
                </a>
            </div>
        </div>
    </div>
    <!-- Banner-Layer /- -->
    @endif
    <!-- Top Collection -->
    <section class="section-maker">
        <div class="container">
            <div class="sec-maker-header text-center">
                <h3 class="sec-maker-h3">Favori Kategoriler</h3>
                <ul class="nav tab-nav-style-1-a justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#men-latest-products">Yeni Gelenler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#men-best-selling-products">En Çok Satanlar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#discounted-products">İndirimdeki Ürünler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#men-featured-products">Tavsiye Ürünler</a>
                    </li>
                </ul>
            </div>
            <div class="wrapper-content">
                <div class="outer-area-tab">
                    <div class="tab-content">
                        <div class="tab-pane active show fade" id="men-latest-products">
                            <div class="slider-fouc">
                                <div class="products-slider owl-carousel" data-item="4">
                                    @foreach ($newProducts as $product)
                                        <?php $product_image_path = 'front/images/product_images/small/'.$product['product_image']; ?>
                                    <div class="item">
                                        <div class="image-container">
                                            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                @if(!empty($product['product_image']) && file_exists($product_image_path))
                                                    <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Product">
                                                @else
                                                    <img class="img-fluid" src="{{ asset('front/images/product_images/small/no-image.png') }}" alt="Product">
                                                @endif
                                            </a>
                                            <div class="item-action-behaviors">
                                                <a class="item-quick-look" data-toggle="modal" href="#quick-view">Göz at
                                                </a>
                                                <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                <a class="item-addwishlist" href="javascript:void(0)">Favorilere ekle</a>
                                                <a class="item-addCart" href="javascript:void(0)">Sepete ekle</a>
                                            </div>
                                        </div>
                                        <div class="item-content">
                                            <div class="what-product-is">
                                                <ul class="bread-crumb">
                                                    <li>
                                                        <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_code'] }}</a>
                                                    </li>
                                                </ul>
                                                <h6 class="item-title">
                                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                                </h6>
                                                <div class="item-stars">
                                                    <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                        <span style='width:0'></span>
                                                    </div>
                                                    <span>(0)</span>
                                                </div>
                                            </div>
                                            <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
                                            @if($getDiscountPrice>0)
                                                <div class="price-template">
                                                    <div class="item-new-price">
                                                        {{ $getDiscountPrice }}
                                                    </div>
                                                    <div class="item-old-price">
                                                        {{ $product['product_price'] }}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="price-template">
                                                    <div class="item-new-price">
                                                        {{ $product['product_price'] }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="tag new">
                                            <span>Yeni</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane show fade" id="men-best-selling-products">
                            <div class="slider-fouc">
                                <div class="products-slider owl-carousel" data-item="4">
                                    @foreach ($bestSellers as $product)
                                    <div class="item">
                                        <div class="image-container">
                                            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                <img class="img-fluid" src="{{ asset('front/images/product_images/small/'.$product['product_image']) }}" alt="{{ $product['description'] }}">
                                            </a>
                                            <div class="item-action-behaviors">
                                                <a class="item-quick-look" data-toggle="modal" href="#quick-view">Göz t
                                                </a>
                                                <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                <a class="item-addwishlist" href="javascript:void(0)">Favorilere ekle</a>
                                                <a class="item-addCart" href="javascript:void(0)">Sepete ekle</a>
                                            </div>
                                        </div>
                                        <div class="item-content">
                                            <div class="what-product-is">
                                                <ul class="bread-crumb">
                                                    <li>
                                                        <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_code'] }}</a>
                                                    </li>
                                                </ul>
                                                <h6 class="item-title">
                                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                                </h6>
                                                <div class="item-stars">
                                                    <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                        <span style='width:0'></span>
                                                    </div>
                                                    <span>(0)</span>
                                                </div>
                                            </div>
                                            <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
                                            @if($getDiscountPrice>0)
                                                <div class="price-template">
                                                    <div class="item-new-price">
                                                        {{ $getDiscountPrice }}
                                                    </div>
                                                    <div class="item-old-price">
                                                        {{ $product['product_price'] }}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="price-template">
                                                    <div class="item-new-price">
                                                        {{ $product['product_price'] }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="discounted-products">
                            <div class="slider-fouc">
                                <div class="products-slider owl-carousel" data-item="4">
                                    @foreach ($discountProducts as $product)
                                    <?php $image_path = "front/images/product_images/small/".$product['product_image']; ?>
                                        <div class="item">
                                        <div class="image-container">
                                            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                @if ($product['product_image'] && file_exists($image_path))
                                                    <img class="img-fluid" src="{{ asset('front/images/product_images/small/'.$product['product_image']) }}" alt="{{ $product['description'] }}">
                                                @else
                                                    <img class="img-fluid" src="{{ asset('front/images/product_images/small/no-image.png') }}" alt="{{ $product['description'] }}">
                                                @endif
                                            </a>
                                            <div class="item-action-behaviors">
                                                <a class="item-quick-look" data-toggle="modal" href="#quick-view">Göz at
                                                </a>
                                                <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                <a class="item-addwishlist" href="javascript:void(0)">Favorilere ekle</a>
                                                <a class="item-addCart" href="javascript:void(0)">Sepete ekle</a>
                                            </div>
                                        </div>
                                        <div class="item-content">
                                            <div class="what-product-is">
                                                <ul class="bread-crumb">
                                                    <li>
                                                        <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_code'] }}</a>
                                                    </li>
                                                </ul>
                                                <h6 class="item-title">
                                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                                </h6>
                                                <div class="item-stars">
                                                    <div class='star' title="4.5 out of 5 - based on 23 Reviews">
                                                        <span style='width:67px'></span>
                                                    </div>
                                                    <span>(23)</span>
                                                </div>
                                            </div>
                                            <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
                                            @if($getDiscountPrice>0)
                                                <div class="price-template">
                                                    <div class="item-new-price">
                                                        {{ $getDiscountPrice }}
                                                    </div>
                                                    <div class="item-old-price">
                                                        {{ $product['product_price'] }}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="price-template">
                                                    <div class="item-new-price">
                                                        {{ $product['product_price'] }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="tag sale">
                                            <span style="font-size:15px">
                                                -%{{ $product['product_discount'] }}
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="men-featured-products">
                            <div class="slider-fouc">
                                <div class="products-slider owl-carousel" data-item="4">
                                    @foreach ($featuredProducts as $product)
                                        <div class="item">
                                        <div class="image-container">
                                            <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                                @if ($product['product_image'] && file_exists($image_path))
                                                    <img class="img-fluid" src="{{ asset('front/images/product_images/small/'.$product['product_image']) }}" alt="{{ $product['description'] }}">
                                                @else
                                                    <img class="img-fluid" src="{{ asset('front/images/product_images/small/no-image.png') }}" alt="{{ $product['description'] }}">
                                                @endif
                                            </a>
                                            <div class="item-action-behaviors">
                                                <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look
                                                </a>
                                                <a class="item-mail" href="javascript:void(0)">Mail</a>
                                                <a class="item-addwishlist" href="javascript:void(0)">Favorilere ekle</a>
                                                <a class="item-addCart" href="javascript:void(0)">Sepete ekle</a>
                                            </div>
                                        </div>
                                        <div class="item-content">
                                            <div class="what-product-is">
                                                <ul class="bread-crumb">
                                                    <li>
                                                        <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_code'] }}</a>
                                                    </li>
                                                </ul>
                                                <h6 class="item-title">
                                                    <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                                </h6>
                                                <div class="item-stars">
                                                    <div class='star' title="4.5 out of 5 - based on 23 Reviews">
                                                        <span style='width:67px'></span>
                                                    </div>
                                                    <span>(23)</span>
                                                </div>
                                            </div>
                                            <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
                                            @if($getDiscountPrice>0)
                                                <div class="price-template">
                                                    <div class="item-new-price">
                                                        {{ $getDiscountPrice }}
                                                    </div>
                                                    <div class="item-old-price">
                                                        {{ $product['product_price'] }}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="price-template">
                                                    <div class="item-new-price">
                                                        {{ $product['product_price'] }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="tag sale">
                                            <span>ÖNERİLEN</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Top Collection /- -->
    @if(isset($fixBanners[1]['image']))
    <!-- Banner-Layer -->
    <div class="banner-layer">
        <div class="container">
            <div class="image-banner">
                <a target="_blank" rel="nofollow" href="{{ url($fixBanners[1]['link']) }}" class="mx-auto banner-hover effect-dark-opacity">
                    <img class="img-fluid" src="{{ asset('front/images/banner_images/'.$fixBanners[1]['image']) }}" alt="{{ $fixBanners[1]['alt'] }}" title="{{ $fixBanners[1]['title'] }}">
                </a>
            </div>
        </div>
    </div>
    <!-- Banner-Layer /- -->
    @endif
    <!-- Site-Priorities -->
    <section class="app-priority">
        <div class="container">
            <div class="priority-wrapper u-s-p-b-80">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="single-item-wrapper">
                            <div class="single-item-icon">
                                <i class="ion ion-md-star"></i>
                            </div>
                            <h2>
                                Mükemmel Değer
                            </h2>
                            <p>Size en iyi teklifleri sunuyoruz</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="single-item-wrapper">
                            <div class="single-item-icon">
                                <i class="ion ion-md-cash"></i>
                            </div>
                            <h2>
                                Özgürce Alışveriş yap
                            </h2>
                            <p>En iyi hizmet üstün güvenlik</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="single-item-wrapper">
                            <div class="single-item-icon">
                                <i class="ion ion-ios-card"></i>
                            </div>
                            <h2>
                                Güvenli ödeme
                            </h2>
                            <p>Dünyanın en güvenilir ödeme teknolojileri ile alışveriş yap</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <div class="single-item-wrapper">
                            <div class="single-item-icon">
                                <i class="ion ion-md-contacts"></i>
                            </div>
                            <h2>
                                24/7 Destek
                            </h2>
                            <p>Bizimle istediğiniz zaman iletişime geçebilirsiniz</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Site-Priorities /- -->
    @endsection()