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
                <i class="fa fa-pie-chart"></i>
                <span>Quản lý sản phẩm</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="{{($controller == 'ProductController') ? 'active':''}}"><a href="{{URL::to('/product')}}"><i class="fa fa-circle-o"></i> Sản Phẩm</a></li>
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

        <li class="header">Admin</li>
        <li class="treeview {{($controller == 'UserController')?'active':''}}"><a href="{{URL::to('/user')}}"><i class="fa fa-user"></i><span>Người dùng</span></a>
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
    </ul>
</section>