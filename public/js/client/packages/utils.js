var utilsPackage = {
    utils:{
        loading: {
            loadingContainer: $('body .main'),
            loading: function($container, $typeBg){
                if ($container) {
                    Kacana.utils.loading.loadingContainer = $container;
                }
                var $typeLoading = '#fff';
                if($typeBg)
                {
                    $typeBg = 'rgba(255,255,255,0.7)';
                    $typeLoading = '#4CAF50';
                }
                else
                {
                    $typeBg = 'rgba(0,0,0,0.7)';
                }


                Kacana.utils.loading.loadingContainer.waitMe({
                    effect : 'ios',
                    text : '',
                    bg : $typeBg,
                    color : $typeLoading,
                    maxSize : '',
                    source : ''
                });
            },
            closeLoading: function(){
                Kacana.utils.loading.loadingContainer.waitMe("hide");
                Kacana.utils.loading.loadingContainer = $('body .main');
            },
        },
        showError: function (text) {
            sweetAlert(
                'Oops...',
                text,
                'error'
            )
        },
        formatCurrency: function(n, currency){
            return currency + " " + parseFloat(n).toFixed(2).replace(/./g, function(c, i, a) {
                    return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
                });
        },
        facebook: {
            init:function(){
                // Facebook async init.
                window.fbAsyncInit = function()
                {
                    FB.init({
                        appId  : 1064427043612189,
                        status : true, // check login status
                        cookie : true, // enable cookies to allow the server to access the session
                        xfbml  : true, // parse XFBML
                        channelUrl : document.location.protocol + '//kacana.com/channel.html',
                        version: 'v2.7'
                    });
                };
                (function() {
                    var e = document.createElement('script');
                    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
                    e.async = true;
                    document.getElementById('fb-root').appendChild(e);
                }());
            },
            login : function(callback){
                FB.login(callback,{scope:'email,public_profile,user_friends'});
            },
            postToFacebook: function (callback) {
                FB.login(callback,{scope:'email,public_profile,user_friends, publish_actions, user_photos'});
            },
            me : function(callback){

                FB.api('/me', callback);
            },
            loggedInCallback:function(token,profile){
                window.opener.loggedInCallback(token,profile);
            }
        },
        google: {
            auth2: false,
            init:function(){
                // Google async init.
                window.gapiAsyncInit = Kacana.utils.google.initScript;
                window.___gcfg = {
                    lang: 'en-US'
                };
                (function() {
                    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true; po.defer = true;
                    po.src = 'https://apis.google.com/js/client:platform.js?onload=gapiAsyncInit';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                })();
            },
            initScript:function(){
                var params = {
                    'client_id': '727230078895-kn5lrk7hv3rmmrqf2b05r80iu15hsqqb.apps.googleusercontent.com',
                    'scope': 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/plus.me'
                };
                gapi.load('auth2', function() {
                    Kacana.utils.google.auth2 = gapi.auth2.init(params);
                });
            },
            login:function(callback){
                Kacana.utils.google.auth2.grantOfflineAccess({'redirect_uri': 'postmessage'}).then(callback);
            },
            me:function(callback){
                gapi.client.load('plus','v1', function(){
                    gapi.client.plus.people.get({userId: 'me'}).execute(callback);
                });
            }
        },
    }
};

$.extend(true, Kacana, utilsPackage);