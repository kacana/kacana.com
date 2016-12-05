<?php $controller = getControllerName(class_basename(Route::currentRouteAction()));?>
<section class="sidebar">
    <ul class="sidebar-menu">
        <li class="header">Statistical</li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="header">Kacana Tool</li>
        <li class="treeview {{($controller == 'ProductController')?'active':''}}">
            <a href="{{URL::to('/product')}}">
                <i class="fa fa-rocket text-red"></i>
                <span class="text-red" ><b>Product boot</b></span>
            </a>
        </li>
        <li class="treeview {{($controller == 'ProductController')?'active':''}}">
            <a href="{{URL::to('/social_account')}}">
                <i class="fa fa-globe"></i>
                <span>Social account</span>
            </a>
        </li>
        <li class="treeview {{($controller == 'ProductController')?'active':''}}">
            <a href="{{URL::to('/user')}}">
                <i class="fa fa-user"></i>
                <span>My customer</span>
            </a>
        </li>

        <li class="header">Order Manager</li>
        <li class="treeview {{($controller == 'AdvisoryController')?'active':''}}">
            <a href="{{URL::to('/order')}}">
                <i class="fa fa-plane"></i>
                <span>My order</span>
            </a>
        </li>
        <li class="treeview {{($controller == 'OrderController')?'active':''}}">
            <a href="{{URL::to('/order')}}">
                <i class="fa fa-dollar"></i>
                <span>My cash</span>
            </a>
        </li>

        {{--<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>--}}
        {{--<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>--}}
        {{--<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>--}}
    </ul>
</section>