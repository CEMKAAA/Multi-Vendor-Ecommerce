<!DOCTYPE html>
<html class="no-js" lang="en-US">

<head>
    <meta charset="UTF-8">
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Laravel Multi Vendor E-commerce Template - By Stack Developers Youtube Channel</title>
    <!-- Standard Favicon -->
    <link href="favicon.ico" rel="shortcut icon">
    <!-- Base Google Font for Web-app -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <!-- Google Fonts for Banners only -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,800" rel="stylesheet">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="{{ url('front/css/bootstrap.min.css') }}">
    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="{{ url('front/css/fontawesome.min.css') }}">
    <!-- Ion-Icons 4 -->
    <link rel="stylesheet" href="{{ url('front/css/ionicons.min.css') }}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ url('front/css/animate.min.css') }}">
    <!-- Owl-Carousel -->
    <link rel="stylesheet" href="{{ url('front/css/owl.carousel.min.css') }}">
    <!-- Jquery-Ui-Range-Slider -->
    <link rel="stylesheet" href="{{ url('front/css/jquery-ui-range-slider.min.css') }}">
    <!-- Utility -->
    <link rel="stylesheet" href="{{ url('front/css/utility.css') }}">
    <!--goruntule-->
    <!--Elevate zoom-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/3.0.8/jquery.elevatezoom.min.css">
    <style>
        .goruntule {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 33px;
            height: 33px;
            border: none;
            border-radius: 50%;
            transition: background-color 0.3s;
        }

        .goruntule:hover {
            background-color: #f1f1f1;
        }

        .goruntule i {
            position: relative;
            font-size: 20px;
            transition: transform 0.3s;
        }

        .goruntule:hover i {
            transform: scale(1.2);
        }

        
        #quick-view {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50%;
            max-width: 800px;
            height: 85%;
            max-height: 800px;
            background-color: #ffffff; /* Set the background color to a solid color */
            z-index: 9999;
            align-items: center;
            justify-content: center;
            overflow-y: auto; /* Enable vertical scrolling */
        }trans

        #quick-view .modal-dialog {
        width: 100%;
        height: 100%;
        margin: 0;
        }

        #quick-view .modal-content {
        border-radius: 0;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        height: 100%;
        }

        #quick-view .modal-body {
        padding: 30px;
        overflow: auto;
        }

        #quick-view .modal-dialog .row {
        margin-right: 0;
        margin-left: 0;
        }

        #quick-view .modal-dialog .col-lg-6,
        #quick-view .modal-dialog .col-md-6,
        #quick-view .modal-dialog .col-sm-12 {
        padding-right: 5px;
        padding-left: 5px;
        }

        #quick-view .modal-dialog .zoom-area {
        position: relative;
        margin-bottom: 20px;
        }

        #quick-view .modal-dialog .zoom-area img {
        display: block;
        width: 100%;
        height: auto;
        }

        #quick-view .modal-dialog .zoom-area #gallery-quick-view {
        display: flex;
        flex-wrap: wrap;
        }

        #quick-view .modal-dialog .zoom-area #gallery-quick-view a {
        display: block;
        width: 25%;
        padding: 5px;
        }

        #quick-view .modal-dialog .zoom-area #gallery-quick-view img {
        width: 100%;
        height: auto;
        }

        #quick-view .modal-dialog .all-information-wrapper {
        height: 100%;
        }

        #quick-view .modal-dialog .product-title {
        margin-bottom: 15px;
        }

        #quick-view .modal-dialog .product-rating {
        margin-top: 10px;
        }

        #quick-view .modal-dialog .section-2-short-description {
        margin-bottom: 20px;
        }

        #quick-view .modal-dialog .section-3-price-original-discount {
        margin-bottom: 20px;
        }

        #quick-view .modal-dialog .section-4-sku-information {
        margin-bottom: 20px;
        }

        #quick-view .modal-dialog .section-5-product-variants {
        margin-bottom: 20px;
        }

        #quick-view .modal-dialog .section-6-social-media-quantity-actions {
        margin-bottom: 20px;
        }

        #quick-view .modal-dialog .quick-social-media-wrapper {
        margin-bottom: 10px;
        }

        #quick-view .modal-dialog .quantity-wrapper {
        margin-bottom: 10px;
        }

        #quick-view .modal-dialog .quantity {
        display: flex;
        align-items: center;
        }

        #quick-view .modal-dialog .quantity-text-field {
        width: 60px;
        height: 40px;
        padding: 0 10px;
        text-align: center;
        font-size: 14px;
        }

        #quick-view .modal-dialog .plus-a,
        #quick-view .modal-dialog .minus-a {
        display: inline-block;
        width: 30px;
        height: 30px;
        line-height: 30px;
        text-align: center;
        cursor: pointer;
        }

        #quick-view .modal-dialog .plus-a:hover,
        #quick-view .modal-dialog .minus-a:hover {
        background-color: #ddd;
        }

        #quick-view .modal-dialog .button {
        margin-right: 6px;
        }

        #quick-view .modal-dialog .far.fa-heart,
        #quick-view .modal-dialog .far.fa-envelope {
        font-size: 18px;
        color: #888;
        padding: 8px;
        background-color: #ffffff
        cursor: pointer;
        }

        #quick-view .modal-dialog .far.fa-heart:hover,
        #quick-view .modal-dialog .far.fa-envelope:hover {
        color: #333;
        }

    </style>
    <!-- Main -->
    <link rel="stylesheet" href="{{ url('front/css/bundle.css') }}">
    <!--CSFR TOKEN SECURITY-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

<!-- app -->
<div id="app">
    <div id="product-listing">
        <!-- Header -->
        @include('front.layout.header')
        <!-- Header /- -->
        <!--Index-->
        @yield('content')
        <!--Index-->
        <!--Footer-->
        @include('front.layout.footer')
        <!--Footer-->
        <!--Modals-->
        @include('front.layout.modals')
        <!--Modals-->
        <!--quick view-->
        <div id="quick-look">
            @include('front.layout.quick-view')
        </div>
        <!--quick view-->
    </div>
</div>
<!-- app /- -->
<!--[if lte IE 9]>
<div class="app-issue">
    <div class="vertical-center">
        <div class="text-center">
            <h1>You are using an outdated browser.</h1>
            <span>This web app is not compatible with following browser. Please upgrade your browser to improve your security and experience.</span>
        </div>
    </div>
</div>
<style> #app {
    display: none;
} </style>
<![endif]-->
<!-- NoScript -->
<noscript>
    <div class="app-issue">
        <div class="vertical-center">
            <div class="text-center">
                <h1>JavaScript is disabled in your browser.</h1>
                <span>Please enable JavaScript in your browser or upgrade to a JavaScript-capable browser.</span>
            </div>
        </div>
    </div>
    <style>
    #app {
        display: none;
    }
    </style>
</noscript>
<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<script>
window.ga = function() {
    ga.q.push(arguments)
};
ga.q = [];
ga.l = +new Date;
ga('create', 'UA-XXXXX-Y', 'auto');
ga('send', 'pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async defer></script>
<!-- Modernizr-JS -->
<script type="text/javascript" src="{{ url('front/js/vendor/modernizr-custom.min.js') }}"></script>
<!-- NProgress -->
<script type="text/javascript" src="{{ url('front/js/nprogress.min.js') }}"></script>
<!-- jQuery -->
<script type="text/javascript" src="{{ url('front/js/jquery.min.js') }}"></script>
<!-- Bootstrap JS -->
<script type="text/javascript" src="{{ url('front/js/bootstrap.min.js') }}"></script>
<!-- Popper -->
<script type="text/javascript" src="{{ url('front/js/popper.min.js') }}"></script>
<!-- ScrollUp -->
<script type="text/javascript" src="{{ url('front/js/jquery.scrollUp.min.js') }}"></script>
<!-- Elevate Zoom -->
<script type="text/javascript" src="{{ url('front/js/jquery.elevatezoom.min.js') }}"></script>
<!-- jquery-ui-range-slider -->
<script type="text/javascript" src="{{ url('front/js/jquery-ui.range-slider.min.js') }}"></script>
<!-- jQuery Slim-Scroll -->
<script type="text/javascript" src="{{ url('front/js/jquery.slimscroll.min.js') }}"></script>
<!-- jQuery Resize-Select -->
<script type="text/javascript" src="{{ url('front/js/jquery.resize-select.min.js') }}"></script>
<!-- jQuery Custom Mega Menu -->
<script type="text/javascript" src="{{ url('front/js/jquery.custom-megamenu.min.js') }}"></script>
<!-- jQuery Countdown -->
<script type="text/javascript" src="{{ url('front/js/jquery.custom-countdown.min.js') }}"></script>
<!-- Owl Carousel -->
<script type="text/javascript" src="{{ url('front/js/owl.carousel.min.js') }}"></script>
<!-- Main -->
<script type="text/javascript" src="{{ url('front/js/app.js') }}"></script>
<!--CEM.JS-->
<script type="text/javascript" src="{{ url('front/js/cem.js') }}"></script>
<!--Product Filtering-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--csfr token security-->
<script>
    window.csrfToken = '{{ csrf_token() }}';
</script>
<!--Font Awesome Fonts-->
<script src="https://kit.fontawesome.com/02e5acc6db.js" crossorigin="anonymous"></script>
<!-- Add the Bootstrap JavaScript file -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
