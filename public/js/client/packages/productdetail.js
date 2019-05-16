var productdetailPackage = {
    productdetail:{
        page: $('#product-detail'),
        adviseBtnClass: $('.btn-advise'),
        actionSendBtn: $("#btn-create"),
        offset: 0,
        heightMainInfo: 0,
        init: function(){
            Kacana.productdetail.showPopupRequest();
            Kacana.productdetail.closeAdvisePopup();
            Kacana.productdetail.bindEvent();
            Kacana.homepage.applySlideImage();

            $.extend($.rsProto, {
                _initGlobalCaption: function() {
                    var self = this;
                    if(self.st.globalCaption) {

                        self.ev.on('rsAfterContentSet', function(e, currSlideObject) {
                            if(currSlideObject.id == 0){
                                var wrapParrent = e.target.slider;
                                var altImage = wrapParrent.data('altImage');
                                wrapParrent.find('.rsImg.rsMainSlideImage').attr('alt', altImage);
                                wrapParrent.find('.rsImg.rsMainSlideImage').attr('itemprop', 'image');
                            }
                        });
                    }
                }
            });

            $.rsModules.globalCaption = $.rsProto._initGlobalCaption;

            $('#product-detail-gallery').royalSlider({
                fullscreen: {
                    enabled: true,
                    nativeFS: true
                },
                controlNavigation: 'thumbnails',
                autoScaleSlider: true,
                autoScaleSliderWidth: 695,
                autoScaleSliderHeight: 695,
                loop: true,
                imageScaleMode: 'fit-if-smaller',
                navigateByClick: true,
                numImagesToPreload: 0,
                arrowsNav: true,
                arrowsNavAutoHide: true,
                arrowsNavHideOnTouch: false,
                keyboardNavEnabled: true,
                fadeinLoadedSlide: true,
                globalCaption: true,
                globalCaptionInside: true,
                transitionType: 'move',
                thumbs: {
                    appendSpan: true,
                    firstMargin: true,
                    paddingBottom: 4,
                    thumbArrow: true,
                    spacing: 20
                },
                imgHeight: 695
            });

            $('.product-information-detail img').lazyload();

            if(window.location.hash) {
                var colorIndex = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
                colorIndex--;
                console.log(colorIndex);
                if($.isNumeric(colorIndex))
                {
                    $('.product-colors').find('a[href="#choose-product-color"]').eq(colorIndex).click();
                }
            }
        },
        bindEvent: function(){
            var slideImageProduct = $('#slide-product-image-mobile, #slide-product-image');
            slideImageProduct.owlCarousel({
                items : 1,
                animateOut: 'fadeOut'
            });

            $('#product-detail #list-product-related').on('mousedown','img.rsMainSlideImage, .product-title a', function (e) {
                switch(e.which)
                {
                    case 1:
                        Kacana.homepage.goToDetailPage($(this), 'left');
                        break;
                    case 2:
                        Kacana.homepage.goToDetailPage($(this), 'middle');
                        break;
                    case 3:
                        //right Click
                        break;
                }
                return true;

            });

            Kacana.productdetail.page.on('click', 'a[href="#choose-product-color"]', function () {
                Kacana.productdetail.page.find('a[href="#choose-product-color"]').removeClass('active');
                $(this).addClass('active');
                var sizeId = $(this).data('size');

                for(var i=0; i<sizeId.length;i++)
                    sizeId[i] = parseInt(sizeId[i]);

                // get size by color
                Kacana.productdetail.page.find('a[href="#choose-product-size"]').each(function(){
                    if(jQuery.inArray(parseInt($(this).data('id')), sizeId)>=0)
                    {
                        $(this).removeClass('disable');
                    }
                    else
                        $(this).addClass('disable');
                });

                Kacana.productdetail.checkSizeAvailable();

                // get image by color
                var imageIndex = $(this).data('index');
                $("#product-detail-gallery").royalSlider('goTo', imageIndex);
                $("#product-detail-gallery-mobile").royalSlider('goTo', imageIndex);

                $('#quick_order_form').find('input[name="colorId"]').val($(this).data('id'));

            });
            Kacana.productdetail.page.on('click', 'a[href="#choose-product-size"]', function () {

                $('#quick_order_form').find('input[name="sizeId"]').val($(this).data('id'));

                if($(this).hasClass('disable'))
                    return false;

                Kacana.productdetail.page.find('a[href="#choose-product-size"]').removeClass('active');
                $(this).addClass('active');
            });

            Kacana.productdetail.page.find('a[href="#choose-product-color"]').hover(function(){
                Kacana.productdetail.page.find('.product-colors').popup('destroy');
            });
            Kacana.productdetail.page.find('a[href="#choose-product-size"]').hover(function(){
                Kacana.productdetail.page.find('.list-size-product').popup('destroy');
            });

            Kacana.productdetail.page.on('click', '#add-cart-btn', Kacana.productdetail.checkout);
            Kacana.productdetail.page.on('click', 'a[href="#post-to-facebook"]', Kacana.productdetail.postToFacebook);
            Kacana.productdetail.checkColorAvailable();
            Kacana.productdetail.bindEventPostToFacebook();
            Kacana.productdetail.validateQuickOrder();

            setTimeout(function() {
                var callBack = function(data) {
                    console.log('tracking product view is DONE!')
                };
                var errorCallBack = function(data){

                };
                var productId = Kacana.productdetail.page.data('id');
                var data = {productId: productId};
                Kacana.ajax.product.trackUserProductView(data, callBack, errorCallBack);

            }, 3000);

            setTimeout(function () {
                console.log($('#list-product-related-wrap #listProductPage').css('max-height'));
                if ($('#list-product-related-wrap #listProductPage').css('max-height') != 'none') {
                    // set height related product
                    $blockRelatedProductHeight = $('#product-description').innerHeight();
                    $('#list-product-related-wrap #listProductPage').css('max-height', ($blockRelatedProductHeight - 105) + 'px');
                }
            }, 2000);

            if ($('#list-product-related-wrap #listProductPage').css('max-height') == 'none') {
                var $win = $(window);
                $win.scroll(function () {
                    var scroll = $win.height() + $win.scrollTop() + 500;
                    var docummentHeight = $(document).height();
                    if (scroll >= docummentHeight && !Kacana.homepage.loadingContent) {
                        Kacana.homepage.loadingContent = true;
                        Kacana.productdetail.autoLoadMoreProductWithType();
                    }
                });
            }
        },
        autoLoadMoreProductWithType: function(){
            var block = $('#list-product-related-wrap');
            var typeLoadProduct = block.data('type');
            var page = block.data('page');
            var tagId = block.data('tag-id');
            var productIdLoaded = $('#product-id-loaded').val();

            var callBack = function(data){
                if(data.ok)
                {
                    var productItemTemplate = $('#template-product-item').html();
                    var products = data.data;
                    // if(typeLoadProduct == 'product-tag'){
                    //     products = data.data.data;
                    // }
                    var productItemTemplateGenerate = $.tmpl(productItemTemplate, {'products': products});
                    block.find('.block-tag-body .taglist').append(productItemTemplateGenerate);
                    block.data('page', page+1);
                    $('#product-id-loaded').val(data.productIdLoaded);
                    Kacana.homepage.loadingContent = false;
                }
                else{
                    Kacana.homepage.loadingContent = true;
                    Kacana.utils.loading.closeLoading();
                }

                if(data.stop_load == 1){
                    Kacana.homepage.loadingContent = true;
                }
                Kacana.utils.loading.closeLoading();
            };

            var errorCallBack = function(){};
            Kacana.utils.loading.loading(block.find('.auto-loading-icon-processing'), 'white');
            Kacana.ajax.homepage.loadMoreProductWithType(typeLoadProduct, page, tagId, productIdLoaded, callBack, errorCallBack);
        },
        validateQuickOrder: function () {
            var form = $('#quick_order_form');


            form.find('[name="phoneQuickOrderNumber"]')
                .intlTelInput({
                    utilsScript: '/lib/form-validation/intl-tel-input/build/js/utils.js',
                    autoPlaceholder: true,
                    preferredCountries: ['vn'],
                    allowDropdown: false,
                    formatOnDisplay: false
            });

            form.formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    phoneQuickOrderNumber: {
                        validators: {
                            notEmpty: {
                                message: 'Vui lòng nhập số điện thoại!'
                            },
                            callback: {
                                message: 'Số điện thoại không chính xác!',
                                callback: function(value, validator, $field) {
                                    console.log(value);
                                    console.log(value === '');
                                    console.log($field.intlTelInput('isValidNumber'));
                                    return value === '' || $field.intlTelInput('isValidNumber');
                                }
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
            });

            form.find('[name="phoneQuickOrderNumber"]').intlTelInput("setNumber", '');
            form.find('[name="phoneQuickOrderNumber"]').intlTelInput("setCountry", "vn");

            form.find('#order-product-with-phone').removeAttr('disabled');
        },
        setHeightForRightMenu: function () {
            var listProductRelated = $('#list-product-related');
            var heightElement = listProductRelated.height();
            listProductRelated.css('height', heightElement);
        },
        bindEventPostToFacebook: function () {
            var modal = $('#modal-post-to-facebook');

            modal.on('click','.item-image-post-to-facebook img', function () {
               $(this).toggleClass('active');
                if(modal.find('.item-image-post-to-facebook img.active').length)
                    modal.find('.btn-post-to-facebook').removeClass('disabled');
                else
                    modal.find('.btn-post-to-facebook').addClass('disabled');
            });

            modal.on('click', '.btn-post-to-facebook', function () {
                var images = [];
                var productId = Kacana.productdetail.page.data('id');
                var descPost = modal.find('.desc-post-to-facebook').val();
                modal.find('.item-image-post-to-facebook img.active').each(function () {
                    images.push(($(this).data('id')));
                });


                var callBack = function(data) {

                    if(data.ok){
                        sweetAlert(
                            'Hoàn thành',
                            'Kacana đã đăng một bài viết lên Facebook của bạn!',
                            'success'
                        );
                    }
                    else
                    {
                        Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                    }
                    Kacana.utils.loading.closeLoading();
                };
                var errorCallBack = function(data){
                    Kacana.utils.loading.closeLoading();

                };

                var data = {
                    productId: productId,
                    descPost: descPost,
                    images: images
                };
                modal.modal('hide');

                Kacana.utils.loading.loading();
                Kacana.ajax.product.postProductToFacebook(data, callBack, errorCallBack);

            });
        },
        showPopupPostToFacebook: function () {
            var modal = $('#modal-post-to-facebook');
            modal.find('.item-image-post-to-facebook img').removeClass('active');
            modal.find('.desc-post-to-facebook').val('');
            modal.find('.btn-post-to-facebook').addClass('disabled');
            modal.modal();
        },
        postToFacebook: function () {
            var hasSocial = $(this).data('has-social');

            if(hasSocial == 1)
            {
                Kacana.productdetail.showPopupPostToFacebook();
            }
            else if($(this).data('logged') != 0)
            {
                Kacana.utils.facebook.postToFacebook(Kacana.productdetail.facebookPostCallback);
            }
        },
        facebookPostCallback: function (response) {
            if(response.status == 'connected')
            {
                response = response.authResponse;
                var accessToken = response.accessToken;
                Kacana.productdetail.facebookCallbackAllowPost(accessToken);

            }
            else{
                Kacana.utils.showError('get access facebook failed');
            }
        },
        facebookCallbackAllowPost: function (accessToken) {
            var callBack = function(data) {

                if(data.ok){
                    Kacana.productdetail.showPopupPostToFacebook();
                }
                else
                {
                    Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                }
                Kacana.utils.loading.closeLoading();
            };
            var errorCallBack = function(data){
                Kacana.utils.loading.closeLoading();

            };

            var data = {
                accessToken: accessToken
            };

            Kacana.utils.loading.loading();
            Kacana.ajax.auth.facebookCallbackAllowPost(data, callBack, errorCallBack);
        },
        checkColorAvailable: function () {
            if(Kacana.productdetail.page.find('.product-colors a[href="#choose-product-color"]').length == 1){
                Kacana.productdetail.page.find('.product-colors a[href="#choose-product-color"]').click();
            }
            Kacana.productdetail.checkSizeAvailable();
        },
        checkSizeAvailable: function () {
            if(Kacana.productdetail.page.find('a[href="#choose-product-size"]:not(.disable)').length == 1){
                Kacana.productdetail.page.find('a[href="#choose-product-size"]:not(.disable)').click();
            }
        },
        checkout: function(){
            var $listColor = Kacana.productdetail.page.find('.product-colors');
            var $listSize = Kacana.productdetail.page.find('.list-size-product');
            var productId = Kacana.productdetail.page.data('id');
            var tagId = Kacana.productdetail.page.data('tag-id');
            var colorId = 0;
            var sizeId = 0;

            if($listColor.length)
            {
                var colorActive = Kacana.productdetail.page.find('a[href="#choose-product-color"].active');
                if(colorActive.length)
                {
                    colorId = colorActive.data('id');
                    var sizeCanChoose = colorActive.data('size');
                    if(sizeCanChoose.length && sizeCanChoose !== 'undefined' && $listSize.length)
                    {
                        var sizeActive = Kacana.productdetail.page.find('a[href="#choose-product-size"].active');
                        if(sizeActive.length && !sizeActive.hasClass('disable'))
                        {
                            sizeId = sizeActive.data('id');
                        }
                        else
                            return $listSize.popup({
                                html: '<div class="header">vui lòng chọn size</div><div class="content">hoặc<br><span class="btn btn-xs btn-success"><i class="fa fa-headphones"></i> tư vấn: 01695.393.076</span></div>',
                                position: 'top left'
                            }).popup('toggle');
                    }
                }
                else{
                    return $listColor.popup({
                        html: '<div class="header">vui lòng chọn màu</div><div class="content">hoặc<br><span class="btn btn-xs btn-success"><i class="fa fa-headphones"></i> tư vấn: 01695.393.076</span></div>',
                        position: 'top left'
                    }).popup('toggle');
                }
            }

            var dataPost = {
                productId: productId,
                colorId: colorId,
                sizeId: sizeId,
                tagId: tagId
            };

            var callBack = function(data){
                if(data.ok)
                {
                    window.location.href = "/thanh-toan";
                    return true;
                    console.log(data);
                    var item = data.item;
                    var cart = data.cart;
                    var products = data.products;
                    var modal = $('#product-add-cart');

                    var itemAddTemplate = $('#template-cart-add-item').html();
                    var itemAddTemplateGenerate = $.tmpl(itemAddTemplate, {'item': item, 'cart': cart});
                    modal.find('.modal-body').empty().append(itemAddTemplateGenerate);

                    var productRelatedTemplate = $('#template-cart-product-related').html();
                    var productRelatedTemplateGenerate = $.tmpl(productRelatedTemplate, {'products': products});
                    modal.find('.modal-footer').empty().append(productRelatedTemplateGenerate);

                    modal.modal();
                    if(!$('a.mobile-redirect.header-menu-shop').find('i.fa-circle').length)
                    {
                        $('a.mobile-redirect.header-menu-shop').append('<i class="fa fa-circle"></i>');
                        $('a.header-mobile-menu-cart').append('<i class="fa fa-circle"></i>');
                    }


                    Kacana.utils.loading.closeLoading();
                }
                else{
                    Kacana.utils.loading.closeLoading();
                    Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                }
            };
            var errorCallBack = function(){Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');};
            Kacana.utils.loading.loading();
            Kacana.ajax.cart.addToCart(dataPost, callBack, errorCallBack);
            return false;
        },
        getPopoverPlacement: function(pop, dom_el){
            var width = window.innerWidth;
            if (width<500) return 'bottom';
            var left_pos = $(dom_el).offset().left;
            if (width - left_pos > 400) return 'right';
            return 'left';
        },
        initPopover: function(id, data){
            $('#'+id).popover({
                html: 'true',
                title: 'Tư vấn <a href="#" class="close" data-dismiss="alert">&times;</a>',
                placement: Kacana.productdetail.getPopoverPlacement,
                content : data
            }).popover('show');
        },
        showPopupRequest: function(){
            Kacana.productdetail.adviseBtnClass.click(function(e){
                $(this).attr('disabled', true);
                var id = $(this).attr('id');
                var callBack = function(data){
                    $(window).on('resize', function(){
                        Kacana.productdetail.initPopover(id, data);
                        return false;
                    })
                    Kacana.productdetail.initPopover(id, data);
                };
                var errorCallBack = function(){};
                Kacana.ajax.homepage.showPopupRequest(id, callBack, errorCallBack);
            })
        },
        sendRequest: function(id){
            $(this).attr('disabled', true);
            var form_data = $("#form-create-request-info").serialize();
            var callBack = function(data) {
                data = JSON.parse(data);
                if(data.status =='ok'){
                    $('#'+id).popover('destroy').popover({content:"Yêu cầu của bạn đã được gửi thành công!"});
                }
            };
            var errorCallBack = function(data){
                json_result = JSON.parse(data.responseText);
                if(typeof(json_result['name'])!=''){
                    $("#error-name").html(json_result['name']);
                }
                if(typeof(json_result['email'])!=''){
                    $("#error-email").html(json_result['email']);
                }

                if(typeof(json_result['phone'])!=''){
                    $("#error-phone").html(json_result['phone']);
                }
                if(typeof(json_result['message'])!=''){
                    $("#error-message").html(json_result['message']);
                }
                $("#btn-create").attr('disabled', false);
            };
            Kacana.ajax.homepage.sendRequest(form_data, callBack, errorCallBack);
        },
        closeAdvisePopup: function(){
            $(document).on("click", ".popover .close" , function(){
                $(this).parents(".popover").popover('hide');
            });
            $('body').on('click', function (e) {
                Kacana.productdetail.adviseBtnClass.each(function () {
                    if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                        $(this).popover('hide');
                    }
                });
                Kacana.productdetail.adviseBtnClass.attr('disabled', false);
            });
        }
    }

};

$.extend(true, Kacana, productdetailPackage);