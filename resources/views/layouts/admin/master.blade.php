<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Kacana - @yield('title')</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/lib/fontawesome/css/font-awesome.css">
        <link rel="stylesheet" href="/lib/jquery/jquery-ui-1.11.4/jquery-ui.min.css">
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="/lib/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <link href="/lib/adminLTE/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <link href="/lib/adminLTE/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
        <link href="/css/admin/admin.css" rel="stylesheet" type="text/css" />
        <link href="/lib/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="/lib/cropper/cropper.min.css" rel="stylesheet" type="text/css"/>
        <link href="/lib/summernote/summernote.css" rel="stylesheet">
        <link href="/lib/jqTree/1.3.5/jqtree.css" rel="stylesheet">
        <link href="/lib/sweetalert2/sweetalert2.min.css" rel="stylesheet">
        <link href="/lib/waitMe/waitMe.min.css" rel="stylesheet">
        <link href="/lib/select2/select2.min.css" rel="stylesheet">
        <link href="/lib/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
        <link href="/lib/morris/morris.css" rel="stylesheet">
        <link href="/lib/daterangepicker/daterangepicker.css" rel="stylesheet">

        <script src="/lib/jquery/jquery-2.1.3.js" charset="utf-8" type="text/javascript"></script>
        <script src="/lib/raphael/raphael.js" charset="utf-8" type="text/javascript"></script>
        <script src="/lib/jquery/jquery-ui-1.11.4/jquery-ui.min.js" charset="utf-8" type="text/javascript"></script>
        <script src="/lib/bootstrap/js/bootstrap.min.js" charset="utf-8" type="text/javascript"></script>
        <script src='/lib/fastclick/fastclick.min.js'></script>
        <script src="/lib/adminLTE/js/app.min.js" type="text/javascript"></script>
        <script src="/lib/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="/lib/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="/lib/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <script src="/lib/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="/lib/chartjs/Chart.min.js" type="text/javascript"></script>
        <script src="/lib/adminLTE/js/demo.js" type="text/javascript"></script>
        <script src="/lib/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="/lib/datatables/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script src="/js/admin/admin.js" type="text/javascript"></script>
        <script src="/lib/summernote/summernote.js"></script>
        <script src="/lib/plupload/js/plupload.full.min.js" type="text/javascript"></script>
        <script src="/lib/cropper/cropper.min.js" type="text/javascript"></script>
        <script src="/lib/jqTree/1.3.5/tree.jquery.js" type="text/javascript"></script>
        <script src="/lib/sweetalert2/sweetalert2.min.js" type="text/javascript"></script>
        <script src="/lib/waitMe/waitMe.min.js" type="text/javascript"></script>
        <script src="/lib/select2/select2.full.js" type="text/javascript"></script>
        <script src="/lib/colorpicker/bootstrap-colorpicker.min.js" type="text/javascript"></script>
        <script src="/lib/tmpl/jquery.tmpl.min.js"></script>
        <script src="/lib/tmpl/jquery.tmplPlus.min.js"></script>
        <script src="/lib/morris/morris.min.js"></script>
        <script src="/lib/daterangepicker/moment.min.js"></script>
        <script src="/lib/daterangepicker/daterangepicker.js"></script>
        <script src="/lib/pusher/pusher.min.js"></script>
        <script src="/lib/scannerdetection/scannerdetection.js"></script>

        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script type="text/javascript">

            $(function() {
                Kacana.utils.init();
                Kacana.layout.init();
                Kacana.chat.init();
                @yield('javascript')
            });
        </script>

    </head>
    <body class="skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">

                @include('layouts.admin.header')

            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                @include('layouts.admin.slidebar')
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div id="@yield('section-content-id')" class="content-wrapper">

                @yield('content')

            </div><!-- /.content-wrapper -->

            <footer class="main-footer">
                @include('layouts.admin.footer')
            </footer>

            <!-- Control Sidebar -->
            <aside id="slidebar-right-side" class="control-sidebar control-sidebar-dark">
                @include('layouts.admin.control-slidebar')
            </aside><!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class='control-sidebar-bg'></div>

        </div><!-- ./wrapper -->
    </body>
</html>