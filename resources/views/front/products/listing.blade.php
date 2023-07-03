<?php use App\Models\Product; use App\Models\Category; use App\Models\Section; $pagination=session('pagination'); $value_2=session('value_2')?>
@extends('front.layout.layout')
@section('content')
        <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Shop</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="index.html">Ana Sayfa</a>
                    </li>
                    <li class="is-marked">
                        <a href="listing.html">Mağaza</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Shop-Page -->
    <div class="page-shop u-s-p-t-80">
        <div class="container">
            <!-- Shop-Intro -->
            <div class="shop-intro">
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <a href="index.html">Ana Sayfa</a>
                    </li>
                    @if(!empty($section_name))
                    <li class="has-separator">
                        <a href="shop-v1-root-category.html">{{ $section_name }}</a>
                    </li>
                    @elseif(empty($categoryDetails) && !is_array($categoryDetails))
                    <?php $section_1 = Section::getSection($categoryDetails['categoryDetails']['section_id'])?>
                    <li class="has-separator">
                        <a href="shop-v1-root-category.html">{{ $section_1['name'] }}</a>
                    </li>
                    @elseif(!empty($categoryDetails) && is_array($categoryDetails))
                    <li class="is-marked">
                        <a href="listing.html">{{ $categoryDetails['categoryDetails']['category_name'] }}</a>
                    </li>
                    @endif
                </ul>
            </div>
            <!-- Shop-Intro /- -->
            <div class="row">
                <!--Filters Page-->
                @include('front.products.filters')
                <!--Filters Page-->
                <!-- Shop-Right-Wrapper -->
                <div class="col-lg-9 col-md-9 col-sm-12">
                    <!-- Page-Bar -->
                    <div class="page-bar clearfix">
                        <div class="shop-settings">
                            <a id="list-anchor">
                                <i class="fas fa-th-list"></i>
                            </a>
                            <a id="grid-anchor" class="active">
                                <i class="fas fa-th"></i>
                            </a>
                        </div>
                        <!-- Toolbar Sorter 1  -->
                        <div class="toolbar-sorter">
                            <div class="select-box-wrapper">
                                <label class="sr-only" for="sort-by">Sırala</label>
                                <select class="select-box" id="sort-by" url="{{ $url }}">
                                    <option @if($value_2 == "en_satan")selected="selected"@endif value="en_satan">Sırala: En Çok Satanlar</option>
                                    <option @if($value_2 == "en_son")selected="selected"@endif value="en_son">Sırala: En Son</option>
                                    <option @if($value_2 == "en_dusuk_ucret")selected="selected"@endif value="en_dusuk_ucret">Sırala: En Düşük Ücret</option>
                                    <option @if($value_2 == "en_yuksek_ucret")selected="selected"@endif value="en_yuksek_ucret">Sırala: En Yüksek Ücret</option>
                                    <option @if($value_2 == "en_yuksek_degerlendirme")selected="selected"@endif value="en_yuksek_degerlendirme">Sırala: En Yüksek Değerlendirme</option>
                                </select>
                            </div>
                        </div>
                        <!-- //end Toolbar Sorter 1  -->
                        <!-- Toolbar Sorter 2  -->
                        <div class="toolbar-sorter-2">
                            <div class="select-box-wrapper">
                                <label class="sr-only" for="show-records">Show Records Per Page</label>
                                <select class="select-box" id="show-records" url="{{ $url }}">
                                    <option @if($pagination == 8)selected="selected"@endif value="8">Show: 8</option>
                                    <option @if($pagination == 16)selected="selected"@endif  value="16">Show: 16</option>
                                    <option @if($pagination == 28)selected="selected"@endif  value="28">Show: 28</option>
                                </select>
                            </div>
                        </div>
                        <!-- //end Toolbar Sorter 2  -->
                    </div>
                    <!-- Page-Bar /- -->
                    <!-- Row-of-Product-Container -->
                    <div class="row product-container list-style">
                        @foreach ($categoryProducts as $key => $product)
                            <?php
                            $getDiscountPrice = Product::getDiscountPrice($product['id']);
                            $image_path = "front/images/product_images/small/" . $product['product_image'];
                            ?>
                            <div class="product-item col-lg-4 col-md-6 col-sm-6">
                                <div class="item">
                                    <div class="image-container">
                                        <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                            @if (file_exists(public_path($image_path)) && !empty($product['product_image']))
                                                <img class="img-fluid" src="{{ asset($image_path) }}" alt="{{ $product['meta_title'] }}">
                                            @else
                                                <img class="img-fluid" src="{{ asset('front/images/product_images/small/no-image.png') }}" alt="{{ $product['meta_title'] }}">
                                            @endif
                                        </a>
                                        <div class="item-action-behaviors">
                                            <a id="goruntule" class="item-quick-look" data-toggle="modal" data-product-id="{{ $product['id'] }}">Quick Look</a>
                                            <a class="item-mail" href="javascript:void(0)">Mail</a>
                                            <a class="item-addwishlist" href="javascript:void(0)">Favorilere Ekle</a>
                                            <a class="item-addCart" href="javascript:void(0)">Sepete Ekle</a>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        <div class="what-product-is">
                                            <ul class="bread-crumb">
                                                <li class="has-separator">
                                                    <a href="shop-v1-root-category.html">{{ $product['product_code'] }}</a>
                                                </li>
                                                <?php $resp = Category::getCategory($product['category_id']); ?>
                                                @if (is_array($resp))
                                                <li class="has-separator">
                                                    <a href="{{ url($resp['parent_category']['url']) }}">{{ $resp['parent_category']['url'] }}</a>
                                                </li>
                                                <li>
                                                    <a href="{{ url($resp['category']['url']) }}">
                                                        {{ $resp['category']['url'] }}
                                                    </a>
                                                </li>
                                                @elseif(!empty($categoryDetails) && is_array($categoryDetails))
                                                <li class="has-separator">
                                                    <a href="{{ url($categoryDetails['categoryDetails']['url']) }}">{{ $categoryDetails['categoryDetails']['url'] }}</a>
                                                </li>
                                                @endif
                                            </ul>
                                            <h6 class="item-title">
                                                <a href="{{ url('product/'.$product['id']) }}">{{ $product['product_name'] }}</a>
                                            </h6>
                                            <div class="item-description">
                                                <p>
                                                    {{ $product['description'] }}
                                                </p>
                                            </div>
                                            <div class="item-stars">
                                                <div class='star' title="4.5 out of 5 - based on 23 Reviews">
                                                    <span style='width:67px'></span>
                                                </div>
                                                <span>(23)</span>
                                            </div>
                                        </div>
                                        <?php $discountPrice = Product::getDiscountPrice($product['id']);?>
                                        @if ($product['product_discount']>0)
                                        <div class="price-template">
                                            <div class="item-new-price">
                                                {{ $discountPrice }}
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
                                @if ($product['product_discount']>0)
                                <div class="tag sale">
                                    <span style="font-size:15px">
                                        -%{{ $product['product_discount'] }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <!-- Row-of-Product-Container /- -->
                </div>
                <!-- Shop-Right-Wrapper /- -->
                <!-- Shop-Pagination -->
                <div class="pagination-area">
                    <div class="pagination-number">
                        <ul>
                            @if ($categoryProducts->currentPage() > 1)
                                <li>
                                    <a href="{{ $categoryProducts->previousPageUrl() }}" title="Previous">
                                        <i class="fa fa-angle-left"></i>
                                    </a>
                                </li>
                            @else
                                <li style="display: none">
                                    <a href="#" title="Previous">
                                        <i class="fa fa-angle-left"></i>
                                    </a>
                                </li>
                            @endif

                            @foreach ($categoryProducts->getUrlRange(1, $categoryProducts->lastPage()) as $page => $url)
                                <li class="{{ $categoryProducts->currentPage() === $page ? 'active' : '' }}">
                                    <a href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            @if ($categoryProducts->currentPage() < $categoryProducts->lastPage())
                                <li>
                                    <a href="{{ $categoryProducts->nextPageUrl() }}" title="Next">
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            @else
                                <li style="display: none">
                                    <a href="#" title="Next">
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <!-- Shop-Pagination /- -->
            </div>
        </div>
        
    </div>
    <!-- Shop-Page /- -->
@endsection
