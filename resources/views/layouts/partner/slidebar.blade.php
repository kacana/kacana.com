<?php $controller = getControllerName(class_basename(Route::currentRouteAction()));?>
<section class="sidebar">
    <ul class="sidebar-menu">
        <li class="header">Thông tin</li>
        <li class="treeview {{($controller == 'IndexController')?'active':''}}">
            <a href="/">
                <i class="fa fa-info"></i>
                <span>Hướng dẫn</span>
            </a>
        </li>

        <li class="header">Công cụ Kacana</li>
        <li class="treeview {{($controller == 'ProductController')?'active':''}}">
            <a href="{{URL::to('/product')}}">
                <i class="fa fa-rocket text-red"></i>
                <span class="text-red" ><b>Product boot</b></span>
            </a>
        </li>
        <li class="treeview {{($controller == 'SocialController')?'active':''}}">
            <a href="{{URL::to('/social_account')}}">
                <i class="fa fa-globe"></i>
                <span>Tài khoản facebook</span>
            </a>
        </li>
        <li class="treeview {{($controller == 'CustomerController')?'active':''}}">
            <a href="{{URL::to('/customer')}}">
                <i class="fa fa-user"></i>
                <span>khách hàng</span>
            </a>
        </li>

        <li class="header">Quản lý đơn hàng</li>
        <li class="treeview {{($controller == 'OrderController')?'active':''}}">
            <a href="{{URL::to('/order')}}">
                <i class="fa fa-plane"></i>
                <span>Đơn hàng</span>
            </a>
        </li>
        <li class="treeview {{($controller == 'CommissionController')?'active':''}}">
            <a href="{{URL::to('/commission')}}">
                <i class="fa fa-dollar"></i>
                <span>Chiết khấu<span>
            </a>
        </li>

        {{--<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>--}}
        {{--<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>--}}
        {{--<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>--}}
    </ul>
</section>