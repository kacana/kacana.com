<?php
$controller = getControllerName(class_basename(Route::currentRouteAction()));
$action = getActionName(class_basename(Route::currentRouteAction()));
?>
<section class="sidebar">
    <ul class="sidebar-menu">
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