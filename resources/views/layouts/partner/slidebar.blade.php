<?php $controller = getControllerName(class_basename(Route::currentRouteAction()));?>
<section class="sidebar">
    <ul class="sidebar-menu">
        <li class="header">Quản lý kho</li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
        </li>

        <li class="{{in_array($controller, array('BranchController', 'ProductController', 'TagController')) ? 'active' : ''}} treeview">
            <a href="#">
                <i class="fa fa-pie-chart"></i>
                <span>Quản lý sản phẩm</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="{{($controller == 'BranchController') ? 'active':''}}"><a href="{{URL::to('/product/branch')}}"><i class="fa fa-circle-o"></i>Thương Hiệu</a></li>
                <li class="{{($controller == 'ProductController') ? 'active':''}}"><a href="{{URL::to('/product')}}"><i class="fa fa-circle-o"></i> Sản Phẩm</a></li>
                <li class="{{($controller == 'TagController') ? 'active':''}}"><a href="{{URL::to('/product/tag')}}"><i class="fa fa-circle-o"></i> Tag Sản Phẩm</a></li>
            </ul>
        </li>

        <li class="header">Admin</li>
        <li class="treeview {{($controller == 'UserController')?'active':''}}"><a href="{{URL::to('/user')}}"><i class="fa fa-user"></i><span>Người dùng</span></a>
        </li>

        <li class="header">Quản Lý Đơn Hàng</li>
        <li class="treeview {{($controller == 'AdvisoryController')?'active':''}}"><a href="{{URL::to('/advisory')}}"><i class="fa fa-info-circle"></i><span>Tư vấn</span></a>
        </li>
        <li class="treeview {{($controller == 'OrderController')?'active':''}}"><a href="{{URL::to('/order')}}"><i class="fa fa-opencart fa-6"></i><span>Đơn hàng</span></a>
        </li>

        {{--<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>--}}
        {{--<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>--}}
        {{--<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>--}}
    </ul>
</section>