var layoutPackage = {
    layout:{
        suggestSearchProductProcessing: false,
        suggestSearchProductTimeout: false,
        init: function(){
            Kacana.layout.initConfig();
            Kacana.layout.initLoginPopup();
            Kacana.utils.facebook.init();
            Kacana.utils.google.init();
        },
        initConfig: function(){
            Kacana.layout.initLayoutMobile();
            // tootip config for easy config
            $('[data-popup-kacana]').each(function(){
                if($(this).data('popup-kacana') == 'title')
                {
                    // customize for get all setting in element when use semantic popup
                    var data = JSON.parse(JSON.stringify($(this).data()));
                    data.delay ={
                        show: 0,
                        hide: 0
                    }
                    $(this).popup(data);
                }
                else if($(this).data('popup-kacana') == 'inline')
                {
                    $(this).popup({
                        inline     : true,
                        hoverable  : true,
                        position   : 'bottom right',
                        on : 'click'
                    });
                }
            });
            // tootip for my account
            $('body a[href="#my-account-header"]').popup({
                inline     : true,
                hoverable  : true,
                position   : 'bottom right',
                on : 'click'
            });

            //Add csrf token for any submit
            $('body').on('submit', 'form', function(){
                $(this).append('<input name="_token" class="hide" value="'+$('meta[name="csrf-token"]').attr('content')+'">');
            });

            // Show Cart in header

            $('body a[href="#show_cart_in_header"]').popup({
                html: '<div id="cart_in_header"></div>',
                position: 'bottom right',
                on: 'click',
                onCreate: function(){
                    Kacana.utils.loading.loading($('#cart_in_header'), 'white');
                    $('.waitMe_content').css('margin-top','-20px');
                }
            });

            $('body a[href="#show_cart_in_header_mobile"]').popup({
                html: '<div id="cart_in_header"></div>',
                position: 'bottom center',
                on: 'click',
                offset: 0,
                onCreate: function(){
                    Kacana.utils.loading.loading($('#cart_in_header'), 'white');
                    $('.waitMe_content').css('margin-top','-20px');
                }
            });

            $('body').on('click', 'a[href="#show_cart_in_header"], a[href="#show_cart_in_header_mobile"]', function(){
                var callBack = function(data) {
                    if(data.ok){
                        var cart = data.cart;
                        if(cart.quantity){
                            var cartHeaderTemplate = $('#template-cart-popup-header').html();
                            var cartHeaderTemplateGenerate = $.tmpl(cartHeaderTemplate, {'cart': cart});
                            $('#cart_in_header').empty().append(cartHeaderTemplateGenerate);
                        }
                        else{
                            $('#cart_in_header').html('<div class="text-center" >giỏ hàng bạn chưa có sản phẩm!</div>')
                        }
                        Kacana.utils.loading.closeLoading();
                    }
                    else
                        Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                };
                var errorCallBack = function(data){
                    Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                };

                Kacana.ajax.cart.loadCart(callBack, errorCallBack);
            });

            $('body').on('click', 'a[href="#show-more-short-desc"]', Kacana.layout.showMoreShortDescProduct);
            $('body').on('click', 'a[href="#show-less-short-desc"]', Kacana.layout.showLessShortDescProduct);
            $('body').on('click', 'a[href="#save-product-like"]', Kacana.layout.saveProductLike);
            $('body').on('click', 'a[href="#remove-product-like"]', Kacana.layout.removeProductLike);
            $('body').on('click', '#btn-facebook-login-popup',  Kacana.auth.socialLogin.facebook);
            $('body').on('click', '#btn-google-login-popup',  Kacana.auth.socialLogin.google);
            $('body').on('click', 'a[href="#show-search-in-header"]',  Kacana.layout.showSearch);
            $('body').on('click', 'a[href="#close-search-in-header"]',  Kacana.layout.closeSearch);

            $('body').bind('click touchstart', function (e) {
                if($(e.target).closest('.nav-main.mega-menu.search-open').length === 0 && $('body').find('.nav-main.mega-menu.search-open').length !== 0)
                {
                    Kacana.layout.closeSearch();
                }
                if($('body').find('.cbp-spmenu-open').length !== 0 && (($(e.target).closest('.nav-mobile').length === 0 &&
                    $(e.target).closest('a[href="#btn-mobile-product-left-nav"]').length === 0 &&
                    $(e.target).closest('a[href="#btn-mobile-account-right-nav"]').length === 0
                ) || ($(e.target).closest('.nav-mobile').length &&
                        ($(e.target).closest('#back-to-page-from-side-bar-left').length ||
                         $(e.target).closest('#back-to-page-from-side-bar-right').length ||
                            $(e.target).closest('a.menu__link__redirect').length ||
                            $(e.target).is('a.menu__link__redirect')
                        )

                    )))
                {
                    if( !$(e.target).closest('a.menu__link__redirect').length && !$(e.target).is('a.menu__link__redirect'))
                    {
                        e.preventDefault();
                        e.stopPropagation();
                        $(this).off('click');
                    }
                    Kacana.layout.closeMobileMenu();
                }

            });

            $('body').on('keyup', '#header #ac-gn-searchform-input', Kacana.layout.suggestSearchProduct);

        },
        suggestSearchProduct: function (e) {
            var search = $(this).val();
            clearTimeout(Kacana.layout.suggestSearchProductTimeout);
            var keyCode = e.keyCode || e.which;

            var callBack = function (data) {
                console.log(data);
                if(data.ok)
                {
                    var products = data.data.products;
                    var tags = data.data.tags;

                    if(products.length)
                    {
                        var htmlString = '';
                        for(var i = 0; i < products.length; i++)
                        {
                            htmlString +='<li>';
                            htmlString +=   '<a href="/san-pham/'+products[i].slug+'--'+products[i].id+'--'+products[i].tag_id+'" >';
                            htmlString +=       '<img src="'+products[i].image+'">';
                            htmlString +=       '<span title="'+products[i].name+'" >'+products[i].name+'</span>';
                            htmlString +=       '<span class="color-green">'+products[i].priceShow+'</span>';
                            htmlString +=   '</a>';
                            htmlString +='</li>';
                        }
                        $('#ac-gn-searchresults').find('.product-search-result').removeClass('hide').find('.nav.nav-list').html(htmlString);
                    }
                    else{
                        $('#ac-gn-searchresults').find('.product-search-result').addClass('hide');
                    }

                    if(tags.length)
                    {
                        var htmlString = '';
                        for(var i = 0; i < tags.length; i++)
                        {
                            htmlString +='<li><a href="/'+tags[i].slug+'--'+tags[i].id+'" >'+tags[i].name+'</a></li>'
                        }
                        $('#ac-gn-searchresults').find('.tag-search-result').removeClass('hide').find('.nav.nav-list').html(htmlString);
                    }
                    else{
                        $('#ac-gn-searchresults').find('.tag-search-result').addClass('hide')
                    }



                }

                Kacana.utils.loading.closeLoading();
                Kacana.layout.suggestSearchProductProcessing = false;
                $('#ac-gn-searchresults').removeAttr('disabled');
            };

            var errorCallback = function () {

            };
            if(keyCode == 13 && search.length >= 2)
            {
                window.location.href = "/tim-kiem/"+search;
            }
            Kacana.layout.suggestSearchProductTimeout = setTimeout(function () {
                if(search.length >= 2 && !Kacana.layout.suggestSearchProductProcessing)
                {
                    Kacana.layout.suggestSearchProductProcessing = true;
                    $('#ac-gn-searchresults').attr('disabled', 'disabled');
                    Kacana.utils.loading.loading($('#ac-gn-searchresults'));
                    Kacana.ajax.homepage.suggestSearchProduct(search, callBack, errorCallback);
                }
            }, 500);

        },
        showSearch: function () {
            var header = $('#header');
            var searchString = $('#ac-gn-searchform-input').val();
            if(header.find('.nav-main.mega-menu').hasClass('search-open') && searchString.length > 3)
            {
                window.location.href = "/tim-kiem/"+searchString;
            }
            else{
                header.find('.nav-main.mega-menu').addClass('search-open');
                header.find('#ac-gn-searchform-input').focus();
                header.find('#ac-gn-searchresults').find('.product-search-result, .tag-search-result').addClass('hide');
                $('body .main').addClass('white-cover');
            }

        },
        closeSearch: function () {
            var header = $('#header');
            header.find('.nav-main.mega-menu').addClass('search-hide');
            $('#ac-gn-searchform-input').val('');
            var timeOutHideSearch = window.setTimeout(function () {
                header.find('.nav-main.mega-menu').removeClass('search-open').removeClass('search-hide');
                $('body .main').removeClass('white-cover');
            },600);
        },
        closeMobileMenu: function () {
            $('body').removeClass('cbp-spmenu-push-toright').removeClass('cbp-spmenu-push-toleft');
            $('#mobile-product-left-nav').removeClass('cbp-spmenu-open');
            $('#mobile-account-right-nav').removeClass('cbp-spmenu-open');
            $('body .main').removeClass('white-cover');
            setTimeout(function () {
                $('body').removeClass('cbp-spmenu-push-open');
            }, 300);
        },
        initLayoutMobile: function(){
            var topNavMobile = $('#header');
            var menuMobileLeft = document.getElementById('mobile-product-left-nav'),
                menuMobileRight = document.getElementById('mobile-account-right-nav');
            var body = document.body;

            topNavMobile.on('click', 'a[href="#btn-mobile-product-left-nav"]',function() {
                classie.toggle( this, 'active' );
                classie.toggle( body, 'cbp-spmenu-push-toright' );
                classie.toggle( body, 'cbp-spmenu-push-open' );
                classie.toggle( menuMobileLeft, 'cbp-spmenu-open' );
                $('body .main').addClass('white-cover');
            });

            topNavMobile.on('click', 'a[href="#btn-mobile-account-right-nav"]',function() {
                classie.toggle( this, 'active' );
                classie.toggle( body, 'cbp-spmenu-push-toleft' );
                classie.toggle( body, 'cbp-spmenu-push-open' );
                classie.toggle( menuMobileRight, 'cbp-spmenu-open' );
                $('body .main').addClass('white-cover')
            });

            var menuElLeft = document.getElementById('menu-mobile-product-left-nav'),
            mlmenuLeft = new MLMenu(menuElLeft, {
                    initialBreadcrumb : 'sản phẩm', // initial breadcrumb text
                    backCtrl : false, // show back button
                    onItemClick: loadDummyData // callback: item that doesn´t have a submenu gets clicked - onItemClick([event], [inner HTML of the clicked item])
                });

            var menuElRight = document.getElementById('menu-mobile-account-right-nav'),
                mlmenuRight = new MLMenu(menuElRight, {
                    initialBreadcrumb : 'Tài khoản', // initial breadcrumb text
                    backCtrl : false, // show back button
                    onItemClick: loadDummyData // callback: item that doesn´t have a submenu gets clicked - onItemClick([event], [inner HTML of the clicked item])
                });

            function loadDummyData(ev, itemName) {
                console.log(itemName);
                ev.preventDefault();
            }

        },
        showMoreShortDescProduct: function () {
            var parent = $(this).parents('.product-short-description-wrap');
            parent.addClass('show-short-desc');
            Kacana.layout.bindOutClickShortDesc('#'+parent.attr('id'));
        },
        showLessShortDescProduct: function () {
            var parent = $(this).parents('.product-short-description-wrap');
            parent.removeClass('show-short-desc');
        },
        saveProductLike: function(){
            var that = $(this);
            var productId = $(this).data('productId');
            var productUrl = $(this).data('productUrl');

            var callBack = function(data){
                if(data.ok){
                    that.parents('.save-product-wrap').addClass('active');
                    that.attr('href', '#remove-product-like');
                    that.data('title', 'Lưu sản phẩm này');
                }

                Kacana.utils.loading.closeLoading();
            };
            Kacana.utils.loading.loading($(this).parents('.save-product-wrap'), true);
            var errorCallBack = function(){

            };

            Kacana.ajax.homepage.saveProductLike(productId, productUrl, callBack, errorCallBack);
        },
        removeProductLike: function(){
            var that = $(this);
            var productId = $(this).data('productId');

            var callBack = function(data){
                if(data.ok){
                    that.parents('.save-product-wrap').removeClass('active');
                    that.attr('href', '#save-product-like');
                    that.data('title', 'Bỏ lưu sản phẩm này');
                }

                Kacana.utils.loading.closeLoading();
            };

            Kacana.utils.loading.loading($(this).parents('.save-product-wrap'), true);
            var errorCallBack = function(){

            };

            Kacana.ajax.homepage.removeProductLike(productId, callBack, errorCallBack);
        },
        bindOutClickShortDesc: function(id){
            $(document).click(function(event) {
                if(!$(event.target).closest(id).length &&
                    !$(event.target).is(id)) {
                    if($(id).hasClass('show-short-desc')) {
                        $(id).removeClass('show-short-desc');
                    }
                }
            });
        },
        initLoginPopup: function(){
            var modal = $('#login-signup-header-popup');
            var form = $('#login-signup-form-popup');

            $('body').on('click', 'a[href="#login-header-popup"], a[href="#signup-header-popup"]', function () {
                if($(this).attr('href')=='#signup-header-popup')
                    modal.find('.tab-signup').click();
                else
                    modal.find('.tab-login').click();
                modal.modal();
            });

            modal.on('hide.bs.modal', function(){
                resetForm();
            });

            modal.on('click','.tab-login', function () {
                modal.find('.form-group.for-signup').hide();
                modal.find('#submit-login-form-popup').text('Đăng Nhập');
                modal.find('#submit-login-form-popup').next().show();
                $(this).addClass('active').siblings().removeClass('active');
                form.removeClass('signup-form-popup').addClass('login-form-popup');
                resetForm();
            });

            modal.on('click','.tab-signup', function () {
                $(this).addClass('active').siblings().removeClass('active');
                modal.find('.form-group.for-signup').show();
                modal.find('#submit-login-form-popup').text('Đăng kí');
                modal.find('#submit-login-form-popup').next().hide();
                form.addClass('signup-form-popup').removeClass('login-form-popup');
                resetForm();
            });

            var resetForm = function(){
                form.find('input').each(function(){
                    var name = $(this).attr('name');
                    form.formValidation('resetField', name);
                    $(this).val('');
                });
                modal.find('.alert').addClass('hidden');
            };

            // form validate before submit
            form.formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Vui lòng tên bạn'
                            },
                            stringLength: {
                                min: 2,
                                max: 30,
                                message: 'Vui lòng nhập tên '
                            },
                            regexp: {
                                regexp: /^[a-zA-Z\xC0-\uFFFF 0-9\.\'\-\,]+$/,
                                message: 'Tên không thể chứ kí tự đặc biệt'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Vui lòng nhập địa chỉ email của bạn'
                            },
                            remote: {
                                type: 'GET',
                                url: 'https://api.mailgun.net/v2/address/validate?callback=?',
                                crossDomain: true,
                                name: 'address',
                                data: {
                                    api_key: 'pubkey-83a6-sl6j2m3daneyobi87b3-ksx3q29'
                                },
                                dataType: 'jsonp',
                                validKey: 'is_valid',
                                message: 'Email không đúng định dạng'
                            }
                        }
                    },
                    phone: {
                        validators: {
                            notEmpty: {
                                message: 'Vui lòng nhập số điện thoại'
                            },
                            regexp: {
                                regexp: '0+[0-9]{7,12}',
                                message: 'Vui lòng nhập vào số điện thoại hợp lệ'
                            },
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Vui lòng nhập mật khẩu của bạn'
                            },
                            stringLength: {
                                min: 6,
                                max: 80,
                                message: 'Mật khẩu có ít nhất 6 kí tự'
                            }
                        }
                    },
                    confirmPassword: {
                        validators: {
                            notEmpty: {
                                message: 'Vui lòng nhập mật khẩu của bạn'
                            },
                            identical: {
                                field: 'password',
                                message: 'Mật khẩu không trùng khớp'
                            }
                        }
                    }
                }
            })
            .on('err.field.fv', function(e, data) {
                data.fv.disableSubmitButtons(false);
            })
            .on('success.field.fv', function(e, data) {
                data.fv.disableSubmitButtons(false);
            })
            .on('success.form.fv', function(){
                var data = form.serialize();
                Kacana.utils.loading.loading($('#submit-login-form-popup'));
                if($(this).hasClass('signup-form-popup'))
                {
                    var callBack = function(data){
                        if(data.ok){
                            window.location.reload();
                        }
                        else{
                            modal.find('.alert').html(data.error_message).removeClass('hidden');
                        }
                        Kacana.utils.loading.closeLoading();
                        form.find('#submit-login-form-popup').removeClass('disabled').removeAttr('disabled');
                    };

                    var errorCallBack = function(){

                    };

                    Kacana.ajax.auth.signup(data, callBack, errorCallBack);
                }
                else if($(this).hasClass('login-form-popup'))
                {
                    var callBack = function(data){
                        if(data.ok){
                            window.location.reload();
                        }
                        else{
                            modal.find('.alert').html(data.error_message).removeClass('hidden');
                        }
                        Kacana.utils.loading.closeLoading();
                        form.find('#submit-login-form-popup').removeClass('disabled').removeAttr('disabled');
                    };

                    var errorCallBack = function(){

                    };

                    Kacana.ajax.auth.login(data, callBack, errorCallBack);
                }
                return false;
            });
        }
    }
};

$.extend(true, Kacana, layoutPackage);