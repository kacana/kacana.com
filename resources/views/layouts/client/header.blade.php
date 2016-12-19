<header id="header" class="single-menu flat-menu transparent semi-transparent valign font-color-light" data-plugin-options='{"stickyEnabled": true, "stickyBodyPadding": false}'>
    <div class="header-top">
        <div class="container">
            <nav class="pull-right">
                <ul class="nav nav-pills nav-top">
                    <li>
                        <a href="/contact/ban-hang-voi-chung-toi"><i class="fa fa-angle-right"></i>Bán hàng cùng Kacana</a>
                    </li>
                    <li>
                        <a href="/contact/thong-tin-lien-he"><i class="fa fa-angle-right"></i>Chăm sóc khách hàng</a>
                    </li>

                    @if(Auth::check())
                        <li>
                            <a href="/khach-hang/kiem-tra-don-hang"><i class="fa fa-angle-right"></i>Kiểm tra đơn hàng</a>
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
                            <a href="/khach-hang/kiem-tra-don-hang"><i class="fa fa-angle-right"></i>Kiểm tra đơn hàng</a>
                        </li>
                        <li>

                            <a href="#login-header-popup"><i class="fa fa-angle-right"></i>Đăng nhập</a>
                        </li>
                        <li>
                            <a href="#signup-header-popup"><i class="fa fa-angle-right"></i>Đăng ký</a>
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
                    <img alt="Porto" width="134" class="img-responsive" height="30" data-sticky-width="134" data-sticky-height="30" src="{{AWS_CDN_URL}}/images/client/christmas_logo.png">
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
                    <img alt="Porto" width="134" class="img-responsive" height="30" data-sticky-width="134" data-sticky-height="30" src="{{AWS_CDN_URL}}/images/client/christmas_logo.png">
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
                <img alt="Porto" width="134" height="30" data-sticky-width="134" data-sticky-height="30" src="{{AWS_CDN_URL}}/images/client/christmas_logo.png">
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
                            <a class="header-mobile-menu-cart" href="/thanh-toan">
                                <i class="pe-7s-cart"></i>
                                @if(Cart::count())
                                    <i class="fa fa-circle"></i>
                                @endif
                                <p>Giỏ Hàng</p>
                            </a>
                        </li>
                        <li >
                            <a href="#show-search-in-header">
                                <i class="pe-7s-search"></i>
                                <p>Tìm kiếm</p>
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
                                    <h3>Sản phẩm</h3>
                                    <ul class="nav nav-list">

                                    </ul>
                                </div>
                                <div class="tag-search-result hide">
                                    <h3>Danh sách có thể bạn thích</h3>
                                    <ul class="nav nav-list">

                                    </ul>
                                </div>
                                <div class="quick-access">
                                    <h3>Truy cập nhanh</h3>
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