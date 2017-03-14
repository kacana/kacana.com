<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="UTF-8">
    <meta name="description" content="kacana - Tui xach da - 2015">
    <meta name="keywords" content="kacana, tui xach, Comming Soon, vi, clutch, cap, balo, thoi trang ">
    <meta name="author" content="kacana co.ltd">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- SITE TITLE -->
    <title>kacana - thời trang nữ</title>

    <!-- =========================
          FAV AND TOUCH ICONS  
    ============================== -->
    <link rel="icon" href="/images/client/favicons/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/client/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/images/client/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/images/client/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/images/client/favicons/manifest.json">
    <link rel="mask-icon" href="/images/client/favicons/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    <!-- =========================
         GOOGLE FONTS   
    ============================== -->
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic' rel='stylesheet'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,400italic,700' rel='stylesheet'>

    <!-- =========================
        STYLESHEETS   
    ============================== -->
    <link href="/lib/coming/css/bootstrap.min.css" rel="stylesheet">
    <link href="/lib/coming/css/font-awesome.min.css" rel="stylesheet">
    <link href="/lib/coming/css/style.css" rel="stylesheet">
    <link href="/lib/coming/css/responsive.css" rel="stylesheet">


    <!-- COLORS -->
    <link rel="stylesheet" href="/lib/coming/css/colors/blue.css"> <!-- DEFAULT COLOR/ CURRENTLY USING -->
    <!-- <link rel="stylesheet" href="css/colors/red.css"> -->
    <!-- <link rel="stylesheet" href="css/colors/green.css"> -->
    <!-- <link rel="stylesheet" href="css/colors/purple.css"> -->
    <!-- <link rel="stylesheet" href="css/colors/orange.css"> -->
    <!-- <link rel="stylesheet" href="css/colors/blue-munsell.css"> -->
    <!-- <link rel="stylesheet" href="css/colors/slate.css"> -->
    <!-- <link rel="stylesheet" href="css/colors/yellow.css"> -->

    <!-- FOOTER COLOR -->
    <!-- <link href="css/colors/footer-color.css" rel="stylesheet"> -->


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

      <!-- google analytic -->

      <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-82621615-1', 'auto');
          ga('require', 'displayfeatures');
          ga('require', 'linkid', 'linkid.js');
          ga('send', 'pageview');
      </script>
  </head>

  <body data-spy="scroll" data-target=".navbar-default" data-offset="100">

    <!-- =========================
         PRE LOADER       
    ============================== -->
    <div class="preloader">
      <div class="status">&nbsp;</div>
    </div>

    
    <!-- ==========================
        HOME SECTION 
    =========================== -->
    <header id="home" class="home text-center">



        <div class="over-bg">

            <!-- Video from YouTube. Have Questions? How To: https://github.com/pupunzi/jquery.mb.YTPlayer/wiki -->
            <a id="bgndVideo" class="player" data-property="{videoURL:'https://youtu.be/lyaAQqJqMso', containment:'.home', autoPlay:true, loop:true, mute:true, startAt:0, stopAt: 0, quality:'hd1080', opacity:1, showControls: false, showYTLogo:false, vol:25}"></a>

            <!-- NAVIGATION START -->
            <div class="navigation-header">
                
                <!-- STICKY NAVIGATION -->
                <div class="navbar navbar-default navbar-fixed-top" role="navigation" data-spy="affix" data-offset-top="50">
                    <div class="container">
                        <div class="navbar-header">
                            
                            <!-- LOGO ON STICKY NAV BAR -->
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#GraphX-navigation">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="#"><img src="/images/client/homepage/logo.png" alt=""></a>
                            
                        </div>
                        
                        <!-- NAVIGATION LINKS -->
                        <div class="navbar-collapse collapse" id="GraphX-navigation">
                            <ul class="nav navbar-nav navbar-right main-navigation">
                                <li><a data-scroll href="#home">trang chủ</a></li>
                                <li><a data-scroll href="#contact-area">Liên hệ</a></li>
                            </ul>
                        </div>
                        
                    </div>
                    <!-- //END CONTAINER -->
                    
                </div>
                <!-- //END STICKY NAVIGATION -->
                
                
            </div>
            <!-- //END NAVIGATION -->


            <!-- //INTRO CONTENT -->
            <div id="intro">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1 class="text-white">we come back soon</h1>
                        </div>

                    </div>
                </div>
            </div>
            
            <!-- //MOUSE ICON -->
            <div class="intro-scroll-down">
                <a data-scroll class="scroll-down" href="#about">
                    <span class="mouse">
                        <span class="mouse-dot"></span>
                    </span>
                </a>
            </div>

            <div class="video-controls">
                <a href="#"> <i id="video-play" class="fa fa-pause text-white"></i> </a>  &nbsp;
                <a href="#"> <i id="video-volume" class="fa fa-volume-off text-white"></i> </a>
            </div>

        </div> <!-- //OVER-BG -->
    </header> <!-- //END HEADER -->

    <!-- ==========================
        CONTACT SECTION 
    =========================== -->
    <section id="contact-area" class="contact section-padding">
        <div class="container">

            <div class="row">

                <!--//SECTION INTRO-->
                <div class="section-intro">
                    <div class="col-md-8 col-md-offset-2 text-center">

                        <h2 class="section-intro-heading"> Liên hệ  </h2>

                        <img src="/lib/coming/images/devider-black.png" class="img-responsive center-block devider" alt="devider">

                        <p class="section-intro-description">
                            kacana đang hoàn thành trang web để đem lại trải nghiệm tốt nhất dành cho bạn!
                        </p>

                    </div>
                </div>
                <!--//END SECTION INTRO-->

            </div> 
            <!-- //END ROW -->            



            <!--//CONTACT INTRO-->
            <div class="contact-info row">
                <div class="col-md-10 col-md-offset-1 text-center">
                    <div class="col-md-4 single-contact-info">
                        <i class="fa fa-envelope-o"></i>
                        <h5> <a href="mailto:info@kacana.com">info@kacana.com</a> </h5>
                    </div>                        

                    <div class="col-md-4 single-contact-info">
                        <i class="fa fa-map-marker"></i>
                        <h5> <a href="">60/36 Trần Hưng Đạo, phường 7, quận 5, Hồ Chí Minh</a> </h5>
                    </div>                        

                    <div class="col-md-4 single-contact-info">
                        <i class="fa fa-whatsapp"></i>
                        <h5> <a href="">+84-906-054-206</a> </h5>
                    </div>
                </div>
            </div>
            <!--//END CONTACT INTRO-->





            <!--//SECTION CONTENT CONTAINER-->
            <div class="section-content-container">
                <div class="container">

                    <div class="col-md-10 col-md-offset-1 text-center">

                        <form id="contact" role="form" >

                            <!-- IF MAIL SENT SUCCESSFULLY -->
                            <h6 class="success"><i class="fa fa-check"></i> cảm ơn bạn đã liên hệ với kacana - chúng tôi sẽ liên lạc với bạn sớm nhất</h6>
                            
                            <!-- IF MAIL SENDING UNSUCCESSFULL -->
                            <h6 class="error"><i class="fa fa-times"></i> vui lòng nhập đúng email. </h6>

                            <div class="row">

                                <div class="col-lg-6">
                                    
                                    <!-- NAME -->
                                    <div class="form-group">
                                        <label for="cf-name" class="control-label hide">Tên</label>
                                        <input class="form-control input-box" id="cf-name" type="text" name="cf-name" placeholder="Tên" />
                                    </div>
                                    
                                    <!-- EMAIL -->
                                    <div class="form-group">
                                        <label for="cf-email" class="control-label hide">Email</label>
                                        <input class="form-control input-box" id="cf-email" type="email" name="cf-email" placeholder="Email" />
                                    </div>

                                    <!-- SUBJECT -->
                                    <div class="form-group">
                                        <label for="cf-subject" class="control-label hide">Tiêu đề</label>
                                        <input class="form-control input-box" id="cf-subject" type="text" name="cf-subject" placeholder="Tiêu đề" />
                                    </div>
                                    
                                </div>

                                <div class="col-lg-6">

                                    <!-- MASSAGE -->
                                    <div class="form-group">
                                        <label for="cf-message" class="control-label hide">Lời nhắn</label>
                                        <textarea class="form-control textarea-box" id="cf-message" rows="8" name="cf-message" placeholder="Lời nhắn......"></textarea>
                                    </div>
                                    
                                    <!-- BUTTON -->
                                    <div class="form-group text-right">
                                        <button type="submit" id="cf-submit" name="submit" class="btn primary-button default-button">Gửi</button>
                                    </div>

                                </div>

                            </div>

                        </form>

                    </div>
                    
                </div>
                <!--//END CONTAINER-->            
            </div>
            <!--//END SECTION CONTENT CONTAINER-->


        </div>
        <!--//END CONTAINER-->
    </section>
    <!--//END CONTACT SECTION-->





    <!-- ==========================
        FOOTER SECTION 
    =========================== -->
    <footer class="footer section-padding"> 
        <div class="container">

            <div class="row">

                <!--//SECTION INTRO-->
                <div class="section-intro">
                    <div class="col-md-8 col-md-offset-2 text-center">

                        <h2 class="section-intro-heading"> kết nối với kacana </h2>

                    </div>
                </div>
                <!--//END SECTION INTRO-->

            </div> 
            <!--//END ROW --> 




            <div class="row text-center">
                
                <!--//SINGLE ITEM-->
                <div class="col-md-4 social-footer">
                    <i class="fa fa-phone"></i> <br>
                    <span>Chăm sóc khách hàng</span> <br>
                    <h4><a href="#">84 (1695) 393-076</a></h4>
                </div>
                <!--//END SINGLE ITEM-->                
                
                <!--//SINGLE ITEM-->
                <div class="col-md-4 social-footer">
                    <i class="fa fa-comments-o"></i> <br>
                    <span>Đổi trả hàng</span> <br>
                    <h4><a href="mailto:info@kacana.com">info@kacana.com</a></h4>
                </div>
                <!--//END SINGLE ITEM-->
                
                <!--//SINGLE ITEM-->
                <div class="col-md-4 social-footer">
                    <i class="fa fa-facebook"></i> <br>
                    <span>facebook</span> <br>
                    <h4><a target="_blank" href="https://www.facebook.com/kacanafashion">@facebook</a></h4>
                </div>
                <!--//END SINGLE ITEM-->

            </div>

            <hr class="footer-line">

            <div class="copyright text-center"> &copy; 2016 kacana.com co.ltd</div>

        </div>
    </footer>
    <!--//END FOOTER SECTION-->



    <!-- ==========================
        JAVASCRIPT 
    =========================== -->
    <script src="/lib/coming/js/jquery.min.js"></script>
    <script src="/lib/coming/js/bootstrap.min.js"></script>
    <script src="/lib/coming/js/smooth-scroll.js"></script>
    <script src="/lib/coming/js/jquery.ajaxchimp.min.js"></script>
    <script src="/lib/coming/js/script.js"></script>
    <script src="/lib/coming/js/jquery.plugin.min.js"></script>
    <script src="/lib/coming/js/jquery.countdown.min.js"></script>
    <script>
        $(function () {
            var austDay = new Date();
            austDay = new Date(2016, 8, 1);
            $('#countdown').countdown({until: austDay});
        });
    </script>


    <script src="/lib/coming/js/jquery.mb.YTPlayer.min.js"></script>
    <script src="/lib/coming/js/device.min.js"></script>



  </body>
</html>