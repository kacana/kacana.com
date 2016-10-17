<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 ie6" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8 ie7" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9 ie8" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml"> <!--<![endif]-->
<head>

    <!-- Basic -->
    <meta charset="utf-8">
    <title>Kacana - Túi xách cho mọi nhà</title>
    <meta name="keywords" content="tui-xach-dep" />
    <meta name="description" content="Kacana - Hệ thống túi xách chuyên nghiệp">
    <meta name="author" content="okler.net">
    <meta property="fb:app_id" content="1064427043612189" />
    <meta property="og:url" content="http://dev.kacana.com" />
    <meta property="og:title" content="kacana fashion" />
    <meta property="og:description" content="bag, fashion, loop" />
    <meta property="og:image" content="/images/client/homepage/logo.png" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Vendor CSS -->
    <!-- Bootstrap 3.3.4 -->
    <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
    {{--<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap-theme.min.css">--}}

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/lib/fontawesome/css/font-awesome.css">

    <link rel="stylesheet" href="/lib/owlcarousel/owl.carousel.min.css" media="screen">
    <link rel="stylesheet" href="/lib/owlcarousel/owl.theme.default.min.css" media="screen">
    <link rel="stylesheet" href="/lib/magnific-popup/magnific-popup.css" media="screen">

    <!-- semantic -->
    <link rel="stylesheet" href="/lib/semantic-popup/popup.min.css" media="screen">
    <link rel="stylesheet" href="/lib/semantic-transition/transition.min.css" media="screen">

    <!-- form validation -->
    <link rel="stylesheet" href="/lib/form-validation/css/formValidator.min.css" media="screen">

    <link rel="stylesheet" href="/lib/pe-icon-7-stroke/css/pe-icon-7-stroke.css" media="screen">
    <link rel="stylesheet" href="/lib/pe-icon-7-stroke/css/helper.css" media="screen">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="/lib/theme/css/theme.css">
    <link rel="stylesheet" href="/lib/theme/css/theme-elements.css">
    <link rel="stylesheet" href="/lib/theme/css/theme-blog.css">
    <link rel="stylesheet" href="/lib/theme/css/theme-shop.css">
    <link rel="stylesheet" href="/lib/theme/css/theme-animate.css">

    <!-- Current Page CSS -->
    <link rel="stylesheet" href="/lib/rs-plugin/css/settings.css" media="screen">
    <link rel="stylesheet" href="/lib/circle-flip-slideshow/css/component.css" media="screen">

    <!-- wait me CSS -->
    <link href="/lib/waitMe/waitMe.min.css" rel="stylesheet">

    <!-- sweet alert CSS -->
    <link href="/lib/sweetalert2/sweetalert2.min.css" rel="stylesheet">

    <!-- Skin CSS -->
    <link rel="stylesheet" href="/lib/theme/css/default.css">

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="/lib/theme/css/custom.css">
    <link rel="stylesheet" href="/lib/ml-menu/ml-menu.css">

    <!-- basic stylesheet -->
    <link rel="stylesheet" href="/lib/royalslider/royalslider.css">

    <!-- skin stylesheet (change it if you use another) -->
    <link rel="stylesheet" href="/lib/royalslider/skins/default/rs-default.css">

    <!-- slick library-->
    <link rel="stylesheet" href="/lib/slick/slick.css"/>
    <!--Add the new slick-theme.css if you want the default styling-->
    <link rel="stylesheet" type="text/css" href="/lib/slick/slick-theme.css"/>

    <!-- Head Libs -->
    <script src="/lib/ml-menu/ml-menu-modernizr.js"></script>

    <!--[if IE]>
    <link rel="stylesheet" href="/lib/theme/css/ie.css">
    <![endif]-->

    <!-- css owner -->
    <link rel="stylesheet" href="/css/client/client.css">

    <!--[if lte IE 8]>
    <script src="/lib/respond/respond.js"></script>
    <script src="/lib/excanvas/excanvas.js"></script>
    <![endif]-->

    <!-- codrops library-->
    <script src="/lib/codrops/text-input/js/classie.js"></script>
    <link rel="stylesheet" href="/lib/codrops/text-input/css/normalize.css">
    <link rel="stylesheet" href="/lib/codrops/text-input/css/set2.css">

    <script src="http://maps.google.com/maps/api/js?key={{GOOGLE_API_KEY}}"></script>
</head>
<body class="cbp-spmenu-push">
<div id="fb-root"></div>
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1064427043612189',
            xfbml      : true,
            version    : 'v2.7'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<div class="body">

    @include('layouts.client.header')

    <div role="main" class="main">
        @yield('top-infomation')

{{--        @include('layouts.client.home-intro')--}}

        @yield('content')

    </div>

    @include('layouts.client.footer')
</div>
@include('client.index.general-modal')
@yield('section-modal')

<!-- Vendor -->
<script charset="utf-8" type="text/javascript" src="/lib/jquery/jquery-2.1.3.js"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="/lib/jquery/jquery.appear/jquery.appear.js"></script>
<script src="/lib/jquery/jquery.easing/jquery.easing.js"></script>
<script src="/lib/jquery/jquery-cookie/jquery-cookie.js"></script>

<script charset="utf-8" type="text/javascript" src="/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="/lib/common/common.js"></script>
<script src="/lib/jquery/jquery.validation/jquery.validation.js"></script>
<script src="/lib/jquery/jquery.stellar/jquery.stellar.js"></script>
<script src="/lib/jquery/jquery.easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script src="/lib/jquery/jquery.gmap/jquery.gmap.js"></script>
<script src="/lib/isotope/jquery.isotope.js"></script>
<script src="/lib/owlcarousel/owl.carousel.js"></script>
<script src="/lib/jflickrfeed/jflickrfeed.js"></script>
<script src="/lib/magnific-popup/jquery.magnific-popup.js"></script>
<script src="/lib/semantic-popup/popup.js"></script>
<script src="/lib/semantic-transition/transition.min.js"></script>
<script src="/lib/tmpl/jquery.tmpl.min.js"></script>
<script src="/lib/tmpl/jquery.tmplPlus.min.js"></script>
<script src="/lib/sweetalert2/sweetalert2.min.js" type="text/javascript"></script>
<script src="/lib/waitMe/waitMe.min.js" type="text/javascript"></script>
<script src="/lib/form-validation/js/formValidator.min.js" type="text/javascript"></script>
<script src="/lib/vide/vide.js"></script>
<script src="/lib/ml-menu/ml-menu.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="/lib/theme/js/theme.js"></script>

<!-- Specific Page Vendor and Views -->
<script src="/lib/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script src="/lib/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<script src="/lib/circle-flip-slideshow/js/jquery.flipshow.js"></script>
<script src="/lib/theme/js/view.home.js"></script>

<!-- Theme Custom -->
<script src="/lib/theme/js/custom.js"></script>

<!-- Theme Initialization Files -->
<script src="/lib/theme/js/theme.init.js"></script>

<script type="text/javascript" src="/lib/slick/slick.min.js"></script>

<!-- js owner -->
<script src="/js/client/client.js"></script>

<!-- Main slider JS script file -->
<!-- Create it with slider online build tool for better performance. -->
<script src="/lib/royalslider/jquery.royalslider.min.js"></script>

<!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information.
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-12345678-1']);
    _gaq.push(['_trackPageview']);

    (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>
 -->
<script type="text/javascript">

    $(function() {
        @yield('javascript')

        Kacana.layout.init();
    });
</script>

</body>
</html>