<?php
$controller = getControllerName(class_basename(Route::currentRouteAction()));
$action = getActionName(class_basename(Route::currentRouteAction()));
?>
<section class="sidebar">
    <ul class="sidebar-menu">
        <li class="header">Thống kê</li>
        <li class="treeview">
            <a href="/">
                <i class="fa fa-dashboard"></i> <span>Kacana Dashboard</span></i>
            </a>
        </li>

        <li class="header">Quản lý kho</li>
        <li class="{{in_array($controller, array('BranchController', 'ProductController')) ? 'active' : ''}} treeview">
            <a href="#">
                <i class="fa fa-product-hunt"></i>
                <span>Quản lý sản phẩm</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="{{($controller == 'ProductController' && ($action == 'index' || $action == 'editProduct' )) ? 'active':''}}"><a href="{{URL::to('/product')}}"><i class="fa fa-circle-o"></i> Sản Phẩm</a></li>
            </ul>
            <ul class="treeview-menu">
                <li class="{{($controller == 'ProductController' && $action == 'imProduct') ? 'active':''}}"><a href="{{URL::to('/product/imProduct')}}"><i class="fa fa-download"></i> Nhập hàng</a></li>
            </ul>
            <ul class="treeview-menu">
                <li class="{{($controller == 'ProductController' && $action == 'exProduct') ? 'active':''}}"><a href="{{URL::to('/product/exProduct')}}"><i class="fa fa-upload"></i> Bán hàng</a></li>
            </ul>
        </li>

        <li class="{{in_array($controller, array('TagController')) ? 'active' : ''}} treeview">
            <a href="#">
                <i class="fa fa-pie-chart"></i>
                <span>Hệ thống TAG</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="{{($controller == 'TagController' && $action == 'index') ? 'active':''}}"><a href="{{URL::to('/product/tag')}}"><i class="fa fa-circle-o"></i> Danh sách Tag</a></li>
                <li class=""><a href="{{URL::to('/tag/relation/'.TAG_RELATION_TYPE_GROUP)}}"><i class="fa fa-circle-o"></i> Group Tag</a></li>
                <li class=""><a href="{{URL::to('/tag/relation/'.TAG_RELATION_TYPE_COLOR)}}"><i class="fa fa-circle-o"></i> Tag màu</a></li>
                <li class=""><a href="{{URL::to('/tag/relation/'.TAG_RELATION_TYPE_SIZE)}}"><i class="fa fa-circle-o"></i> Tag Size</a></li>
                <li class=""><a href="{{URL::to('/tag/relation/'.TAG_RELATION_TYPE_STYLE)}}"><i class="fa fa-circle-o"></i> Tag Style</a></li>
                <li class="{{($controller == 'TagController' && $action == 'relation') ? 'active':''}}"><a href="{{URL::to('/tag/relation/'.TAG_RELATION_TYPE_MENU)}}"><i class="fa fa-circle-o"></i> Tag Sản Phẩm</a></li>
            </ul>
        </li>

        <li class="{{in_array($controller, array('TagController')) ? 'active' : ''}} treeview">
            <a href="#">
                <i class="fa fa-map-o"></i>
                <span>Hệ thống cửa hàng</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @foreach($kacanaStores as $store)
                    <li><a href="{{URL::to('/store/index/'.$store->id)}}"><i class="fa fa-map-marker"></i> {{$store->name}}</a></li>
                @endforeach
             </ul>
        </li>

        <li class="header">Quản lý marketing</li>
        <li class="treeview {{($controller == 'PromotionController')?'active':''}}"><a href="{{URL::to('/campaign')}}"><i class="fa fa-rocket"></i><span>Chiến dịch khuyến mãi</span></a>

        <li class="header">Admin</li>
        <li class="treeview {{($controller == 'UserController')?'active':''}}"><a href="{{URL::to('/user')}}"><i class="fa fa-user"></i><span>Người dùng</span></a>

        <li class="{{($controller == 'ChatController')?'active':''}}">
            <a href="{{URL::to('/chat')}}">
                <i class="fa fa-comments-o"></i>
                <span>Chat</span>
                <span class="pull-right-container">
                </span>
            </a>
         </li>

        <li class="{{($controller == 'UserController' && $action == 'trackingUser')?'active':''}}">
            <a href="{{URL::to('/user/trackingUser')}}">
                <i class="fa fa-eye"></i>
                <span>Theo dõi người dùng</span>
                <span class="pull-right-container">
                </span>
            </a>
        </li>

        <li class="{{($controller == 'UserController' && $action == 'trackingUser')?'active':''}}">
            <a href="{{URL::to('/user/facebookComment')}}">
                <i class="fa fa-comment"></i>
                <span>Facebook Comment</span>
                <span class="pull-right-container">
                </span>
            </a>
        </li>

        <li class="header">Quản Lý Đơn Hàng</li>
        <li class="treeview {{($controller == 'OrderController')?'active':''}}">
            <a href="{{URL::to('/order')}}">
                <i class="fa fa-shopping-cart fa-6"></i>
                <span>Đơn hàng</span>
            </a>
        </li>
        <li class="treeview {{($controller == 'ShippingController')?'active':''}}">
            <a href="{{URL::to('/shipping')}}">
                <i class="fa fa-plane fa-6"></i>
                <span>Shipping</span>
            </a>
        </li>
        <li class="treeview {{($controller == 'OrderFromController')?'active':''}}">
            <a href="{{URL::to('/orderFrom')}}">
                <i class="fa fa-link fa-6"></i>
                <span>Quản lý Order From</span>
            </a>
        </li>

        <li class="header">Quản Lý Partner</li>
        <li class="treeview {{($controller == 'PartnerController' && $action == 'index')?'active':''}}">
            <a href="{{URL::to('/partner')}}">
                <i class="fa fa-dollar fa-6"></i>
                <span>Danh sách chờ chuyển</span>
            </a>
        </li>
        <li class="treeview {{($controller == 'PartnerController' && $action == 'historyTransfer')?'active':''}}">
            <a href="{{URL::to('/partner/historyTransfer')}}">
                <i class="fa fa-money fa-6"></i>
                <span>Lịch sử chuyển tiền</span>
            </a>
        </li>

        <li class="header">Quản Lý Blog</li>
        <li class="treeview {{($controller == 'BlogController' && $action == 'index')?'active':''}}">
            <a href="{{URL::to('/blog')}}">
                <i class="fa fa-clipboard"></i>
                <span>Danh sách Post</span>
            </a>
        </li>
        <li class="treeview {{($controller == 'BlogController' && $action == 'relation')?'active':''}}">
            <a href="{{URL::to('/blog/relation/'.TAG_RELATION_TYPE_POST)}}">
                <i class="fa fa-align-center"></i>
                <span>Chuyên mục</span>
            </a>
        </li>
    </ul>
</section>