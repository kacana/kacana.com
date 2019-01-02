<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 ie6" lang="vi"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8 ie7" lang="vi"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9 ie8" lang="vi" xmlns:fb="http://www.facebook.com/2008/fbml"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="vi" xmlns:fb="http://www.facebook.com/2008/fbml"> <!--<![endif]-->
<!-- Đánh dấu siêu dữ liệu đã được thêm bởi Trình trợ giúp đánh dấu dữ liệu có cấu trúc của Google. -->
<head>

    <!-- Basic -->
    <meta charset="utf-8">

    <!-- GOOGLE META AND SEO -->
    <title>@yield('meta-title', 'Chuyên bán túi xách, ví, balo thời trang')</title>
    <meta name="description" content="@yield('meta-description', 'Shop online tphcm mua bán túi xách đeo chéo, ví cầm tay, balo nam, ba lô nữ và cặp cho trẻ em✅Hàng hiệu chính hãng✅Chất tốt, da bò thật cao cấp✅Thời trang cá tính hàn quốc giá rẻ✅Mẫu hot, độc đẹp, dễ thương và cute✅Size to lớn đến mini nhỏ xinh✅Phù hợp công sở, đi chơi, du lịch✅Có giá sỉ cho đại lý')" />
    <meta name="keywords" content="@yield('meta-keyword', 'túi xách đẹp, túi xách nữ, túi xách du lịch, túi xách đeo chéo, túi đeo chéo nữ, túi xách nữ giá rẻ, túi xách giá rẻ, túi xách hàng hiệu, túi xách nữ hàng hiệu, túi đẹp, túi xách nữ đẹp, balo mini, balo đẹp, balo thời trang, balo hàng hiệu, balo hàn quốc, ví nam, ví nữ, ví cầm tay, ví đẹp, túi xinh')" />

    <link rel="alternate" href="http://kacana.vn" hreflang="vn" />
    <link rel="canonical" href="{{Request::url()}}" />
    <!-- =========================
          FAV AND TOUCH ICONS
    ============================== -->
    <link rel="icon" href="/images/client/favicons/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/client/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/images/client/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/images/client/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/images/client/favicons/manifest.json">
    <link rel="mask-icon" href="/images/client/favicons/safari-pinned-tab.svg" color="#5bbad5">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="Kacana">
    <meta name="twitter:title" content="Kacana | @yield('meta-title', 'Chuyên bán túi xách, ví, balo thời trang')">
    <meta name="twitter:description" content="@yield('meta-description', 'Shop online tphcm mua bán túi xách đeo chéo, ví cầm tay, balo nam, ba lô nữ và cặp cho trẻ em✅Hàng hiệu chính hãng✅Chất tốt, da bò thật cao cấp✅Thời trang cá tính hàn quốc giá rẻ✅Mẫu hot, độc đẹp, dễ thương và cute✅Size to lớn đến mini nhỏ xinh✅Phù hợp công sở, đi chơi, du lịch✅Có giá sỉ cho đại lý') - Kacana.vn">
    <meta name="twitter:creator" content="@kacana">
    <meta name="twitter:image" content="@yield('meta-image', 'http:'.AWS_CDN_URL.'/images/client/short_logo.png')">

    <meta property="fb:admins" content="cuong.nguyen.it" />
    <meta property="fb:app_id" content="{{KACANA_SOCIAL_FACEBOOK_KEY}}" />

    <!-- Open Graph data -->
    <meta property="og:url" content="{{Request::url()}}"/>
    <meta property="og:title" content="@yield('meta-title', 'Chuyên bán túi xách, ví, balo thời trang') - Kacana.vn" />
    <meta property="og:type" content="product" />

    <!-- If landing page -->
    <meta property="og:image" content="@yield('meta-image', 'http:'.AWS_CDN_URL.'/images/client/short_logo.png')" />
    <!--  <meta property="og:description" content="" /> -->
    <meta property="og:description" content="@yield('meta-description', 'Shop online tphcm mua bán túi xách đeo chéo, ví cầm tay, balo nam, ba lô nữ và cặp cho trẻ em✅Hàng hiệu chính hãng✅Chất tốt, da bò thật cao cấp✅Thời trang cá tính hàn quốc giá rẻ✅Mẫu hot, độc đẹp, dễ thương và cute✅Size to lớn đến mini nhỏ xinh✅Phù hợp công sở, đi chơi, du lịch✅Có giá sỉ cho đại lý') - Kacana.vn">
    <meta property="og:site_name" content="Kacana" />

    <link rel="alternate" href="https://www.kacana.vn/" hreflang="vi-vn" />

    <meta name="author" content="Kacana.vn">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width,height=device-height, user-scalable=no, initial-scale=1.0">

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
    <link rel="stylesheet" href="/lib/pe-icon-7-stroke/css/helper.min.css" media="screen">

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

    <link rel="stylesheet" href="/lib/nivo-slider/nivo-slider.css" media="screen">
    <link rel="stylesheet" href="/lib/nivo-slider/default/default.css" media="screen">

    <link rel="stylesheet" href="/lib/form-validation/intl-tel-input/build/css/intlTelInput.css" />

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
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-938027284"></script>

    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1663284040549863');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=1663284040549863&ev=PageView&noscript=1"
        /></noscript>

    <!-- End Facebook Pixel Code -->


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

        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-82621615-2', 'auto');
        ga('require', 'displayfeatures');
        ga('require', 'linkid', 'linkid.js');
        ga('send', 'pageview');

        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'AW-938027284');
    </script>
</head>
<body class="cbp-spmenu-push">
<div id="fb-root"></div>

<div class="body">

    @include('layouts.client.header')

    <div role="main" class="main">
        @yield('top-infomation')

        @yield('content')

        @include('layouts.client.chat')
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
<script src="/lib/lazyload-2/lazyload.min.js"></script>
<script src="/lib/nivo-slider/jquery.nivo.slider.js"></script>

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
<script src="/lib/pusher/pusher.min.js"></script>
<script src="/lib/lockr/lockr.min.js"></script>
<script src="/lib/form-validation/intl-tel-input/build/js/intlTelInput.js"></script>

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

        Kacana.chat.init();
        Kacana.layout.init();
    });
</script>
<script type="text/javascript">
    var google_tag_params = {
        'send_to': 'AW-938027284',
        'dynx_itemid': [@yield('google-param-prodid', 0)],
        'dynx_itemid2': '1',
        'dynx_pagetype': '@yield("google-param-pagetype", "home")',
        'ecomm_pagetype': '@yield("google-param-pagetype", "home")',
        'ecomm_prodid': [@yield('google-param-prodid', 0)]
    };

    gtag('event', 'page_view', google_tag_params);

</script>
<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 938027284;
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
    <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/938027284/?guid=ON&amp;script=0"/>
    </div>
</noscript>
</body>
</html>