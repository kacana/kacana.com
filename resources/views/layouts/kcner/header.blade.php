<!-- Logo -->
<a href="/" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>K</b>CN</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>KACANAER</b> KaCaNa</span>
</a>

<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?= $user->image;?>" class="user-image" alt="User Image"/>
                    <span class="hidden-xs"><?= $user->name;?></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img src="<?= $user->image;?>" class="img-circle" alt="User Image" />
                        <p>
                            <?= $user->name;?> - <?= $user->role;?>
                            <small><?= $user->created_at;?></small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    {{--<li class="user-body">--}}
                        {{--<div class="col-xs-4 text-center">--}}
                            {{--<a href="#">Followers</a>--}}
                        {{--</div>--}}
                        {{--<div class="col-xs-4 text-center">--}}
                            {{--<a href="#">Sales</a>--}}
                        {{--</div>--}}
                        {{--<div class="col-xs-4 text-center">--}}
                            {{--<a href="#">Friends</a>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        {{--<div class="pull-left">--}}
                            {{--<a href="#" class="btn btn-default btn-flat">Profile</a>--}}
                        {{--</div>--}}
                        <div class="pull-right">
                            <a href="/auth/sign-out" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                    </li>
                </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
                <a href="#" id="btn-show-list-chat-right-side" data-toggle="control-sidebar"><i class="fa fa-comments-o"></i>
                    <span class="label label-success"></span>
                </a>
            </li>
        </ul>
    </div>

</nav>