<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Customer</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Bootstrap 3.3.4 -->
        <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap-theme.min.css">

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="/lib/fontawesome/css/font-awesome.css">
        <!-- Ionicons -->
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="/lib/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="/lib/adminLTE/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link href="/lib/adminLTE/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
        <link href="/css/admin/admin.css" rel="stylesheet" type="text/css" />
        <link href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.datatables.net/select/1.0.1/css/select.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="/lib/cropper/cropper.min.css" rel="stylesheet" type="text/css"/>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <script charset="utf-8" type="text/javascript" src="/lib/jquery/jquery-2.1.3.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script charset="utf-8" type="text/javascript" src="/lib/bootstrap/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src='/lib/fastclick/fastclick.min.js'></script>
        <!-- AdminLTE App -->
        <script src="/lib/adminLTE/js/app.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="/lib/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="/lib/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="/lib/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- SlimScroll 1.3.0 -->
        <script src="/lib/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!-- ChartJS 1.0.1 -->
        <script src="/lib/chartjs/Chart.min.js" type="text/javascript"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        {{--<script src="/lib/adminLTE/js/pages/dashboard2.js" type="text/javascript"></script>--}}

        <!-- AdminLTE for demo purposes -->
        <script src="/lib/adminLTE/js/demo.js" type="text/javascript"></script>

        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.js" type="text/javascript"></script>
        <script src="/js/admin/admin.js" type="text/javascript"></script>
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- include summernote css/js-->
        <link href="/lib/summernote/summernote.css" rel="stylesheet">
        <script src="/lib/summernote/summernote.js"></script>

        <script src="/lib/plupload/js/plupload.full.min.js" type="text/javascript"></script>
        <script src="/lib/cropper/cropper.min.js" type="text/javascript"></script>

        {!! Html::style('/lib/jqTree/jqtree.css') !!}
        {!! Html::script('/lib/jqTree/tree.jquery.js') !!}

        <script type="text/javascript">

            $(function() {
                @yield('javascript')
            });
        </script>

    </head>
    <body class="skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">

                @include('layouts.partner.header')

            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                @include('layouts.partner.slidebar')
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                @yield('content')

            </div><!-- /.content-wrapper -->

            <footer class="main-footer">
                @include('layouts.partner.footer')
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                @include('layouts.partner.control-slidebar')
            </aside><!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class='control-sidebar-bg'></div>

        </div><!-- ./wrapper -->
    </body>
</html>