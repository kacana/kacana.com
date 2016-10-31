var productdetailPackage = {
    productdetail:{
        page: $('#product-detail'),
        adviseBtnClass: $('.btn-advise'),
        actionSendBtn: $("#btn-create"),
        init: function(){
            Kacana.productdetail.showPopupRequest();
            Kacana.productdetail.closeAdvisePopup();
            Kacana.productdetail.bindEvent();

            $('#product-detail-gallery, #product-detail-gallery-mobile').royalSlider({
                fullscreen: {
                    enabled: true,
                    nativeFS: false
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
                arrowsNavAutoHide: false,
                arrowsNavHideOnTouch: false,
                keyboardNavEnabled: true,
                fadeinLoadedSlide: true,
                globalCaption: false,
                globalCaptionInside: false,
                transitionType: 'fade',
                thumbs: {
                    appendSpan: true,
                    firstMargin: true,
                    paddingBottom: 4,
                    thumbArrow: true,
                    spacing: 20

                },
                imgHeight: 695
            });

            $('.list-color-product').slick({
                dots: false,
                infinite: false,
                speed: 300,
                slidesToShow: 5,
                slidesToScroll: 3,
                arrows: true,
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 3,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 3
                        }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });

            $('.product-information-detail img').lazyload();

            if(window.location.hash) {
                var colorIndex = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
                colorIndex--;
                $('.list-color-product').slick('slickGoTo', colorIndex, true);
                $('.list-color-product').find('.slick-track .slick-slide').eq(colorIndex).find('a').click();
            }
        },
        bindEvent: function(){
            var slideImageProduct = $('#slide-product-image-mobile, #slide-product-image');
            slideImageProduct.owlCarousel({
                items : 1,
                animateOut: 'fadeOut'
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

            });
            Kacana.productdetail.page.on('click', 'a[href="#choose-product-size"]', function () {
                if($(this).hasClass('disable'))
                    return false;

                Kacana.productdetail.page.find('a[href="#choose-product-size"]').removeClass('active');
                $(this).addClass('active');
            });

            Kacana.productdetail.page.find('a[href="#choose-product-color"]').hover(function(){
                Kacana.productdetail.page.find('.list-color-product').popup('destroy');
            });
            Kacana.productdetail.page.find('a[href="#choose-product-size"]').hover(function(){
                Kacana.productdetail.page.find('.list-size-product').popup('destroy');
            });

            Kacana.productdetail.page.on('click', '#add-cart-btn', Kacana.productdetail.checkout);
            Kacana.productdetail.checkColorAvailable();
        },
        checkColorAvailable: function () {
            if(Kacana.productdetail.page.find('a[href="#choose-product-color"]').length == 1){
                Kacana.productdetail.page.find('a[href="#choose-product-color"]').click();
            }
            Kacana.productdetail.checkSizeAvailable();
        },
        checkSizeAvailable: function () {
            if(Kacana.productdetail.page.find('a[href="#choose-product-size"]:not(.disable)').length == 1){
                Kacana.productdetail.page.find('a[href="#choose-product-size"]:not(.disable)').click();
            }
        },
        checkout: function(){
            var $listColor = Kacana.productdetail.page.find('.list-color-product');
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