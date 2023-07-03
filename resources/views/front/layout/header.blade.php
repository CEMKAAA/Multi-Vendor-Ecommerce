<?php 
use App\Models\Section;
$sections = Section::sections();
/*echo "<pre>"; print_r($sections); die;*/
?>
<!-- Header -->
    <header>
        <!-- Top-Header -->
        <div class="full-layer-outer-header">
            <div class="container clearfix">
                <nav>
                    <ul class="primary-nav g-nav">
                        <li>
                            <a href="tel:+111222333">
                                <i class="fas fa-phone u-c-brand u-s-m-r-9"></i>
                                Telefon: +90 551 055 15 23</a>
                        </li>
                        <li>
                            <a href="mailto:info@sitemakers.in">
                                <i class="fas fa-envelope u-c-brand u-s-m-r-9"></i>
                                E-mail: bereketbarkod@gmail.com
                            </a>
                        </li>
                    </ul>
                </nav>
                <nav>
                    <ul class="secondary-nav g-nav">
                        <li>
                            <a>Hesabım
                                <i class="fas fa-chevron-down u-s-m-l-9"></i>
                            </a>
                            <ul class="g-dropdown" style="width:200px">
                                <li>
                                    <a href="cart.html">
                                        <i class="fas fa-cog u-s-m-r-9"></i>
                                        Sepetim</a>
                                </li>
                                <li>
                                    <a href="wishlist.html">
                                        <i class="far fa-heart u-s-m-r-9"></i>
                                        Favorilerim</a>
                                </li>
                                <li>
                                    <a href="checkout.html">
                                        <i class="far fa-check-circle u-s-m-r-9"></i>
                                        Ödeme</a>
                                </li>
                                <li>
                                    <a href="account.html">
                                        <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                        Müşteri girişi</a>
                                </li>
                                <li>
                                    <a href="account.html">
                                        <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                        Satıcı girişi</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a>TL
                                <i class="fas fa-chevron-down u-s-m-l-9"></i>
                            </a>
                            <ul class="g-dropdown" style="width:90px">
                                <li>
                                    <a href="#" class="u-c-brand">(₺) TL</a>
                                </li>
                                <li>
                                    <a href="#">($) USD</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a>TUR
                                <i class="fas fa-chevron-down u-s-m-l-9"></i>
                            </a>
                            <ul class="g-dropdown" style="width:70px">
                                <li>
                                    <a href="#" class="u-c-brand">ENG</a>
                                </li>
                                <li>
                                    <a href="#">ARB</a>
                                </li>
                            </ul>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Top-Header /- -->
        <!-- Mid-Header -->
        <div class="full-layer-mid-header">
            <div class="container">
                <div class="row clearfix align-items-center">
                    <div class="col-lg-3 col-md-9 col-sm-6">
                        <div class="brand-logo text-lg-center">
                            <a href="index.html">
                                <img src="{{ asset('') }}" alt="bereket barkod" class="app-brand-logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 u-d-none-lg">
                        <form class="form-searchbox">
                            <label class="sr-only" for="search-landscape">Ara</label>
                            <input id="search-landscape" type="text" class="text-field" placeholder="Search everything">
                            <div class="select-box-position">
                                <div class="select-box-wrapper select-hide">
                                    <label class="sr-only" for="select-category">Kategori seç</label>
                                    <select class="select-box" id="select-category">
                                        <option selected="selected" value="">
                                            Hepsi
                                        </option>
                                        @foreach($sections as $section)
                                            <option value="">{{ $section['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button id="btn-search" type="submit" class="button button-primary fas fa-search"></button>
                        </form>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <nav>
                            <ul class="mid-nav g-nav">
                                <li class="u-d-none-lg">
                                    <a href="index.html">
                                        <i class="ion ion-md-home u-c-brand"></i>
                                    </a>
                                </li>
                                <li class="u-d-none-lg">
                                    <a href="wishlist.html">
                                        <i class="far fa-heart"></i>
                                    </a>
                                </li>
                                <li>
                                    <a id="mini-cart-trigger">
                                        <i class="ion ion-md-basket"></i>
                                        <span class="item-counter">4</span>
                                        <span class="item-price">₺220.00</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mid-Header /- -->
        <!-- Responsive-Buttons -->
        <div class="fixed-responsive-container">
            <div class="fixed-responsive-wrapper">
                <button type="button" class="button fas fa-search" id="responsive-search"></button>
            </div>
            <div class="fixed-responsive-wrapper">
                <a href="wishlist.html">
                    <i class="far fa-heart"></i>
                    <span class="fixed-item-counter">4</span>
                </a>
            </div>
        </div>
        <!-- Responsive-Buttons /- -->
        <!-- Mini Cart -->
        <div class="mini-cart-wrapper">
            <div class="mini-cart">
                <div class="mini-cart-header">
                    SEPETİN
                    <button type="button" class="button ion ion-md-close" id="mini-cart-close"></button>
                </div>
                <ul class="mini-cart-list">
                    <li class="clearfix">
                        <a href="single-product.html">
                            <img src="{{ asset('front/images/product/product@1x.jpg') }}" alt="Product">
                            <span class="mini-item-name">Ürün adı</span>
                            <span class="mini-item-price">₺100.00</span>
                            <span class="mini-item-quantity"> x 1 </span>
                        </a>
                    </li>
                    <li class="clearfix">
                        <a href="single-product.html">
                            <img src="{{ asset('front/images/product/product@1x.jpg') }}" alt="Product">
                            <span class="mini-item-name">Ürün adı</span>
                            <span class="mini-item-price">₺100.00</span>
                            <span class="mini-item-quantity"> x 1 </span>
                        </a>
                    </li>
                </ul>
                <div class="mini-shop-total clearfix">
                    <span class="mini-total-heading float-left">Total:</span>
                    <span class="mini-total-price float-right">₺200.00</span>
                </div>
                <div class="mini-action-anchors">
                    <a href="cart.html" class="cart-anchor">Sepeti görüntüle</a>
                    <a href="checkout.html" class="checkout-anchor">Ödemeye git</a>
                </div>
            </div>
        </div>
        <!-- Mini Cart /- -->
        <!-- Bottom-Header -->
        <div class="full-layer-bottom-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <div class="v-menu v-close">
                            <span class="v-title">
                                <i class="ion ion-md-menu"></i>
                                Tüm Kategoriler
                                <i class="fas fa-angle-down"></i>
                            </span>
                            <nav>
                                <div class="v-wrapper">
                                    <ul class="v-list animated fadeIn">
                                        @foreach($sections as $section)
                                        @if (count($section['categories'])>0)
                                        <li class="js-backdrop">
                                            <a href="{{ url($section['name']) }}">
                                                <i class="ion-ios-add-circle"></i>
                                                {{ $section['name'] }}
                                                <i class="ion ion-ios-arrow-forward"></i>
                                            </a>
                                            <button class="v-button ion ion-md-add"></button>
                                            <div class="v-drop-right" style="width: 700px;">
                                                <div class="row">
                                                    @foreach($section['categories'] as $category)
                                                    <div class="col-lg-4">
                                                        <ul class="v-level-2">
                                                            <li>
                                                                <a href="{{ url($category['url']) }}">{{ $category['category_name'] }}</a>
                                                                <ul>
                                                                    @foreach($category['subcategories'] as $subcategory)
                                                                    <li>
                                                                        <a href="{{ url($subcategory['url']) }}">{{ $subcategory['category_name'] }}</a>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </li>
                                        @endif
                                        @endforeach
                                        <li>
                                            <a class="v-more">
                                                <i class="ion ion-md-add"></i>
                                                <span>Daha fazla</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <ul class="bottom-nav g-nav u-d-none-lg">
                            <li>
                                <a href="listing-without-filters.html">Yeni ürünler
                                    <span class="superscript-label-new">Yeni</span>
                                </a>
                            </li>
                            <li>
                                <a href="listing-without-filters.html">En çok satanler
                                    <span class="superscript-label-hot">Fırsat</span>
                                </a>
                            </li>
                            <li>
                                <a href="listing-without-filters.html">Tavsiye edilen
                                </a>
                            </li>
                            <li>
                                <a href="listing-without-filters.html">İndirimli
                                    <span class="superscript-label-discount">-30%</span>
                                </a>
                            </li>
                            <li class="mega-position">
                                <a>Daha fazla
                                    <i class="fas fa-chevron-down u-s-m-l-9"></i>
                                </a>
                                <div class="mega-menu mega-3-colm">
                                    <ul>
                                        <li class="menu-title">ŞİRKET</li>
                                        <li>
                                            <a href="about.html" class="u-c-brand">Hakkımızda</a>
                                        </li>
                                        <li>
                                            <a href="contact.html">İleşim</a>
                                        </li>
                                        <li>
                                            <a href="faq.html">FAQ</a>
                                        </li>
                                    </ul>
                                    <ul>
                                        <li class="menu-title">Koleksiyonlar</li>
                                        <li>
                                            <a href="cart.html">Adam giyimi</a>
                                        </li>
                                        <li>
                                            <a href="checkout.html">Bayan giyimi</a>
                                        </li>
                                        <li>
                                            <a href="account.html">Çocuk giyimi</a>
                                        </li>
                                    </ul>
                                    <ul>
                                        <li class="menu-title">Hesap</li>
                                        <li>
                                            <a href="shop-v1-root-category.html">Benim hesabım</a>
                                        </li>
                                        <li>
                                            <a href="shop-v1-root-category.html">Profilim</a>
                                        </li>
                                        <li>
                                            <a href="listing.html">Siparişlerim</a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bottom-Header /- -->
    </header>
    <!-- Header /- -->