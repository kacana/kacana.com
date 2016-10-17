$(document).ready(function () {

    "use strict";
    
    /*=================================*/
    /* PRE LOADER  */
    /*=================================*/    
    $(window).load(function() {
        $('.status').delay(100).fadeOut('slow');
        $('.preloader').delay(500).fadeOut('slow');
        $('body').delay(500).css({
            'overflow': 'visible'
        });
    })


    /*=================================*/
    /* Intro Height  */
    /*=================================*/

    function introHeight() {
        var wh = $(window).height();
        $('#home').css({height: wh});
    }

    introHeight();
    $(window).on('resize',function () {
        //Update slider height on resize
        introHeight();
    });


    /*=================================*/
    /* Mailchimp Subcription Form  */
    /*=================================*/
    $('.mailchimp').ajaxChimp({
    callback: mailchimpCallback,
    url: "http://facebook.us9.list-manage.com/subscribe/post?u=871e23fca46271588db005bf1&amp;id=677ca45e6b" //Replace this with your own mailchimp post URL. Don't remove the "". Just paste the url inside "".  
});

function mailchimpCallback(resp) {
        if (resp.result === 'success') {
            $('.subscription-success').html('<i class="fa fa-check-circle-o fa-2x"></i><br/>' + resp.msg).fadeIn(1000);
            $('.subscription-error').fadeOut(500);
        } else if (resp.result === 'error') {
            $('.subscription-error').html('<i class="fa fa-times-circle-o fa-2x"></i><br/>' + resp.msg).fadeIn(1000);
        }
    }


    /*=================================*/
    /* CONTACT FORM  */
    /*=================================*/    
    $("#contact").submit(function (e) {
        e.preventDefault();
        var name = $("#cf-name").val();
        var email = $("#cf-email").val();
        var subject = $("#cf-subject").val();
        var message = $("#cf-message").val();
        var dataString = 'name=' + name + '&email=' + email + '&subject=' + subject + '&message=' + message;

        function isValidEmail(emailAddress) {
            var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
            return pattern.test(emailAddress);
        };
        if (isValidEmail(email) && (message.length > 1) && (name.length > 1)) {
            $.ajax({
                type: "POST",
                url: "sendmail.php",
                data: dataString,
                success: function () {
                    $('.success').fadeIn(1000);
                    $('.error').fadeOut(500);
                }
            });
        }
        else {
            $('.error').fadeIn(1000);
            $('.success').fadeOut(500);
        }
        return false;
    });



    /*=================================*/
    /* SMOOTH SCROLL  */
    /*=================================*/
    smoothScroll.init({
        speed: 500, // Integer. How fast to complete the scroll in milliseconds
        easing: 'easeInOutCubic', // Easing pattern to use
        updateURL: true, // Boolean. Whether or not to update the URL with the anchor hash on scroll
        offset: 0, // Integer. How far to offset the scrolling anchor location in pixels
        callbackBefore: function ( toggle, anchor ) {}, // Function to run before scrolling
        callbackAfter: function ( toggle, anchor ) {} // Function to run after scrolling
    });



    /*================================================================================*/
    /* Bootstrap Internet Explorer 10 in Windows 8 and Windows Phone 8 FIX  */
    /*================================================================================*/
    if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
        var msViewportStyle = document.createElement('style')
        msViewportStyle.appendChild(
        document.createTextNode('@-ms-viewport{width:auto!important}'))
        document.querySelector('head').appendChild(msViewportStyle)
    }




});



$(window).resize(function () {

    "use strict";

    var ww = $(window).width();
    
    /* COLLAPSE NAVIGATION ON MOBILE AFTER CLICKING ON LINK */
    
    if (ww < 480) {
        $('.main-navigation a').on('click', function () {
            $(".navbar-toggle").click();
        });
    }
});



// VIDEO BACKGROUND
$(document).ready(function() {
    $(".player").mb_YTPlayer();
    $(document).ready(function() {
        if (!device.tablet() && !device.mobile()) {
            $('.video-controls').addClass(
                'video-controls-visible');
        }
    });

    $('#video-play').click(function(event) {
        event.preventDefault();
        if ($(this).hasClass('fa-play')) {
            $('.player').playYTP();
        } else {
            $('.player').pauseYTP();
        }
        $(this).toggleClass('fa-pause fa-play');
        return false;
    });

    $('#video-volume').click(function(event) {
        event.preventDefault();
        $('.player').toggleVolume();
        $(this).toggleClass('fa-volume-off fa-volume-up');
        return false;
    });

});