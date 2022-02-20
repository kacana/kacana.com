<header id="header" class="single-menu flat-menu transparent semi-transparent valign font-color-light" data-plugin-options='{"stickyEnabled": true, "stickyBodyPadding": false}'>
    <div class="header-top">
        <div class="container">
            <nav class="pull-right">
                <ul class="nav nav-pills nav-top">
                    <li>
                        <a href="tel:0399761768"><i class="fa fa-phone"></i> 0399.761.768</a>
                    </li>
                    <li>
                        <a target="_blank" href="/contact/thong-tin-lien-he"><i class="fa fa-map-marker"></i> Cửa hàng</a>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" id="btn-header-policy-info-shop" data-toggle="dropdown" href="#">Chính sách & quy định<i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu" id="dropdown-header-policy-info-shop" aria-labelledby="btn-header-policy-info-shop">
                            <li><a title="Giới thiệu" href="/contact/gioi-thieu">Giới thiệu</a></li>
                            <li><a title="Thông tin liên hệ" href="/contact/thong-tin-lien-he">Thông tin liên hệ</a></li>
                            <li><a title="Chế độ bảo hành" href="/contact/che-do-bao-hanh">Chính sách đổi/trả hàng và hoàn tiền</a></li>
                            <li><a title="Hướng dẫn mua hàng" href="/contact/huong-dan-mua-hang">Hướng dẫn mua hàng</a></li>
                            <li><a title="Chính sách & Quy định chung" href="/contact/quy-dinh-chung">Chính sách & Quy định chung</a></li>
                            <li><a title="Quy định và hình thức thanh toán" href="/contact/hinh-thuc-thanh-toan">Quy định và hình thức thanh toán</a></li>
                            <li><a title="Chính sách vận chuyển/giao nhận/cài đặt" href="/contact/chinh-sach-van-chuyen">Chính sách vận chuyển/giao nhận/cài đặt</a></li>
                            <li><a title="Chính sách bảo mật thông tin" href="/contact/chinh-sach-bao-mat">Chính sách bảo mật thông tin</a></li>
                            <li><a title="Chính sách tích luỹ cho thành viên" href="/contact/chinh-sach-khach-hang">Chính sách tích luỹ cho thành viên</a></li>
                            <li><a title="Kiếm tiền với chúng tôi" href="/contact/kiem-tiem-voi-chung-toi">Kiếm tiền với chúng tôi</a></li>
                        </ul>
                    </li>

                    @if(Auth::check())
                        <li>
                            <a href="/khach-hang/kiem-tra-don-hang">Kiểm tra đơn hàng</a>
                        </li>
                        <li class="ui menu">
                            <a class="item" href="#my-account-header">
                                <i class="fa fa-angle-right"></i>
                                {{Auth::user()->name}}
                            </a>
                            <ul class="ui popup hidden" id="my-account-header-content">
                                <li><a href="/khach-hang/tai-khoan"><i class="pe-7s-config"></i>Quản lý tài khoản</a></li>
                                <li><a href="/khach-hang/don-hang-cua-toi"><i class="pe-7s-ribbon"></i>Đơn hàng của tôi</a></li>
                                <li><a href="/khach-hang/danh-sach-yeu-thich"><i class="pe-7s-like"></i>Danh sách yêu thích</a></li>
                                <li><a href="/khach-hang/so-dia-chi"><i class="pe-7s-map-marker"></i>Sổ địa chỉ</a></li>
                                <li><a href="/auth/sign-out"><i class="pe-7s-angle-right-circle"></i>Đăng xuất</a></li>
                            </ul>
                        </li>
                    @else
                        <li>
                            <a href="/khach-hang/kiem-tra-don-hang">Kiểm tra đơn hàng</a>
                        </li>
                        <li class="color-white auth-menu-block">
                            <a href="/auth/login">Đăng nhập</a> | <a href="/auth/signup">Đăng ký</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
    <div class="nav-mobile" >
        <nav id="mobile-product-left-nav" class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left">
            <div class="sidebar-logo" >
                <a id="back-to-page-from-side-bar-left" >
                    <i href="#" class="pe-7s-angle-left-circle pe-3x" ></i>
                </a>
                <a href="/">
                    <img alt="KACANA.VN" width="134" class="img-responsive" height="30" data-sticky-width="134" data-sticky-height="30" src="{{AWS_CDN_URL}}/images/client/logo.png">
                </a>
            </div>
            <div id="menu-mobile-product-left-nav" class="menu-side-bar-mobile">

                <div class="menu__wrap">
                    <ul data-menu="m" class="menu__level">
                        <li class="menu__item">
                            <a class="menu__link"></a>
                            <a href="/" class="menu__link__redirect">Trang Chủ</a>
                        </li>
                        @foreach($menu_items as $item)
                            <li class="menu__item">
                                <a class="menu__link" @if(isset($item->childs) && sizeof($item->childs) > 0) data-submenu="mobile-menu-product-left-{{$item->id}}" @endif href="#"></a>
                                <a href="{{urlTag($item)}}" class="menu__link__redirect">{{$item->name}}</a>
                            </li>
                        @endforeach
                        <li class="menu__item">
                            <a class="menu__link"></a>
                            <a href="/tin-tuc" class="menu__link__redirect color-green">Tín đồ  túi xách</a>
                        </li>
                    </ul>
                    @foreach($menu_items as $item)
                        @if(isset($item->childs) && sizeof($item->childs) > 0)
                            <ul data-menu="mobile-menu-product-left-{{$item->id}}" class="menu__level">
                                @foreach($item->childs as $child)
                                    <li class="menu__item">
                                        <a class="menu__link" href="#"></a>
                                        <a href="{{urlTag($child)}}" class="menu__link__redirect">{{ $child->name }}</a>
                                    </li>
                                @endforeach

                            </ul>
                        @endif
                    @endforeach
                </div>
            </div>
        </nav>
        <nav id="mobile-account-right-nav" class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right">
            <div class="sidebar-logo" >
                <a id="back-to-page-from-side-bar-right" >
                    <i href="#" class="pe-7s-angle-right-circle pe-3x" ></i>
                </a>
                <a href="/">
                    <img alt="KACANA.VN" width="134" class="img-responsive" height="30" data-sticky-width="134" data-sticky-height="30" src="{{AWS_CDN_URL}}/images/client/logo.png">
                </a>
            </div>
            <div id="menu-mobile-account-right-nav" class="menu-side-bar-mobile">

                <div class="menu__wrap">
                    <ul data-menu="main" class="menu__level">
                        @if(Auth::check())
                            <li class="menu__item" >
                                <a class="menu__link"></a>
                                <a href="/khach-hang/tai-khoan" class="menu__link__redirect"><i class="pe-7s-config"></i>Quản lý tài khoản</a>
                            </li>
                            <li class="menu__item" >
                                <a class="menu__link"></a>
                                <a href="/khach-hang/don-hang-cua-toi" class="menu__link__redirect"><i class="pe-7s-ribbon"></i>Đơn hàng của tôi</a>
                            </li>
                            <li class="menu__item" >
                                <a class="menu__link"></a>
                                <a href="/khach-hang/danh-sach-yeu-thich" class="menu__link__redirect"><i class="pe-7s-like"></i>Danh sách yêu thích</a>
                            </li>
                            <li class="menu__item" >
                                <a class="menu__link"></a>
                                <a href="/khach-hang/so-dia-chi" class="menu__link__redirect"><i class="pe-7s-map-marker"></i>Sổ địa chỉ</a>
                            </li>
                            <li class="menu__item" >
                                <a class="menu__link"></a>
                                <a href="/auth/sign-out" class="menu__link__redirect"><i class="pe-7s-angle-right-circle"></i>Đăng xuất</a>
                            </li>
                        @else
                            <li class="menu__item">
                                <a class="menu__link"></a>
                                <a href="#login-header-popup" class="menu__link__redirect">Đăng Nhập</a>
                            </li>
                            <li class="menu__item">
                                <a class="menu__link"></a>
                                <a href="#signup-header-popup" class="menu__link__redirect">Đăng Kí</a>
                            </li>
                        @endif

                        <li class="type-menu-item" >
                            <a >Chăm sóc khách hàng</a>
                        </li>
                        <li class="menu__item">
                            <a class="menu__link"></a>
                            <a  class="menu__link__redirect color-red" href="/khach-hang/kiem-tra-don-hang"><i class="pe-7s-plane"></i><b>Kiểm tra đơn hàng</b></a>
                        </li>
                        <li class="menu__item">
                            <a class="menu__link"></a>
                            <a  class="menu__link__redirect" href="/contact/thong-tin-lien-he"><i class="pe-7s-info"></i>Thông tin liên hệ</a>
                        </li>
                        <li class="menu__item">
                            <a class="menu__link"></a>
                            <a  class="menu__link__redirect" href="/contact/ban-hang-voi-chung-toi"><i class="pe-7s-cash"></i>bán hàng cùng KACANA</a>
                        </li>
                        <li class="menu__item">
                            <a class="menu__link"></a>
                            <a  class="menu__link__redirect" href="/contact/chinh-sach-doi-hang"><i class="pe-7s-repeat"></i>Chính sách đổi hàng</a>
                        </li>
                        <li class="menu__item">
                            <a class="menu__link"></a>
                            <a  class="menu__link__redirect" href="/contact/chinh-sach-khach-hang"><i class="pe-7s-add-user"></i>Giảm giá thành viên</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="container">
        <div class="logo">
            <a href="/">
                <img alt="KACANA.VN" width="170" data-sticky-width="120" src="{{AWS_CDN_URL}}/images/client/logo.png">
            </a>
        </div>
    </div>
    <div class="nav-main-collapse">
        <div class="container">
            <nav class="nav-main mega-menu">
                @if(count($menu_items)>0)
                    <ul class="nav nav-pills nav-main" id="mainMenu">
                        <li class="">
                            <a class="dropdown-toggle" href="/">Trang chủ</a>
                        </li>
                        @foreach($menu_items as $item)
                            @if(isset($item->childs) && sizeof($item->childs) > 0)
                                <li class="dropdown" >
                                    <a class="dropdown-toggle" href="{{urlTag($item)}}">
                                        {{ $item->name }}
                                        <i class="fa fa-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        @foreach($item->childs as $child)
                                            <li><a href="{{urlTag($child)}}">{{ $child->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li>
                                    <a href="">{{ $item->name }}</a>
                                </li>
                            @endif
                        @endforeach
                        <li class="">
                            <a class="dropdown-toggle color-green" href="/tin-tuc">Tín đồ  túi xách</a>
                        </li>
                        <li class="mega-menu-item search-icon-header">
                            <a class="mobile-redirect" href="#show-search-in-header">
                                <i class="pe-7s-search pe-2x pe-va"></i>
                            </a>
                        </li>
                        <li class="mega-menu-item">
                            <a class="mobile-redirect header-menu-shop" href="#show_cart_in_header">
                                <i class="pe-7s-cart pe-2x pe-va"></i>
                                @if(Cart::count())
                                    <i class="fa fa-circle"></i>
                                @endif
                            </a>
                        </li>
                        <li class="mega-menu-item close-search-icon-header">
                            <a class="mobile-redirect" href="#close-search-in-header">
                                <i class="pe-7s-close pe-va"></i>
                            </a>
                        </li>
                        <!-- cart -->
                    </ul>
                    <ul id="mobileMenu" class="nav nav-pills nav-top">
                        <li >
                            <a href="#btn-mobile-product-left-nav">
                                <i class="pe-7s-menu"></i>
                                <p>Sản phẩm</p>
                            </a>
                        </li>
                        <li >
                            <a href="#show-search-in-header">
                                <i class="pe-7s-search"></i>
                                <p>Tìm kiếm</p>
                            </a>
                        </li>
                        <li >
                            <a class="header-mobile-menu-cart" href="/thanh-toan">
                                <i class="pe-7s-cart"></i>
                                @if(Cart::count())
                                    <i class="fa fa-circle"></i>
                                @endif
                                <p>Giỏ Hàng</p>
                            </a>
                        </li>
                        <li >
                            <a href="/contact/thong-tin-lien-he">
                                <i class="pe-7s-map-marker"></i>
                                <p>Cửa hàng</p>
                            </a>
                        </li>
                        <li >
                            <a href="#btn-mobile-account-right-nav">
                                <i class="pe-7s-users"></i>
                                <p>Khách Hàng</p>
                            </a>
                        </li>
                    </ul>
                    <aside id="ac-gn-searchview" class="ac-gn-searchview" role="search" data-analytics-region="search">
                        <div class="ac-gn-searchview-content">
                            <input id="ac-gn-searchform-input" class="ac-gn-searchform-input" aria-label="Tìm kiếm trên kacana.com" placeholder="Tìm kiếm trên kacana.com" data-placeholder-long="Search for Products, Stores, and Help" autocorrect="off" autocapitalize="off" autocomplete="off" spellcheck="false" type="text">
                            <a href="#search-icon-btn-search-product" id="search-icon-btn-search-product" >
                                <i class="pe-7s-search pe-2x pe-va" ></i>
                            </a>
                            <a href="#close-search-in-header" id="close-icon-btn-search-product" >
                                <i class="pe-7s-close pe-2x pe-va" ></i>
                            </a>
                            <aside id="ac-gn-searchresults" class="ac-gn-searchresults with-content" data-string-quicklinks="Quick Links" data-string-suggestions="Suggested Searches" data-string-noresults="Hit enter to search.">
                                <div class="product-search-result hide">
                                    <p class="head-title-search">Sản phẩm</p>
                                    <ul class="nav nav-list">

                                    </ul>
                                </div>
                                <div class="tag-search-result hide">
                                    <p  class="head-title-search">Danh sách có thể bạn thích</p>
                                    <ul class="nav nav-list">

                                    </ul>
                                </div>
                                <div class="quick-access">
                                    <p  class="head-title-search">Truy cập nhanh</p>
                                    <ul class="nav nav-list">

                                        @foreach($menu_items as $item)
                                            <li>
                                                <a href="{{urlTag($item)}}">{{$item->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </aside>
                        </div>
                    </aside>
                @endif
            </nav>
        </div>
    </div>
</header>