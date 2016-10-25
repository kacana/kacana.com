var homepagePackage = {
    homepage:{
        homePageId: $('#homepage, #listProductPage'),
        adviseBtn: $(".btn-advise"),
        actionSendBtn: $("#btn-create"),
        init: function(){
            Kacana.homepage.applySlideImage();
            Kacana.homepage.showPopupRequest();
            Kacana.homepage.closeAdvisePopup();
            Kacana.homepage.bindEvent();
        },
        bindEvent: function () {
            Kacana.homepage.homePageId.on('click','a[href="#load-more-product-with-type"]', Kacana.homepage.loadMoreProductWithType);
            Kacana.homepage.homePageId.on('mousedown','img.rsMainSlideImage, .product-title a', function (e) {
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
        },
        goToDetailPage: function (obj, typeClick) {
            var productItem = obj.parents('.product-item');

            var href = productItem.find('.product-info .product-title a').attr('href');
            var colorIndex = productItem.data('color-index');
            if(colorIndex !== undefined)
            {
                var url = href+'#'+colorIndex;
            }
            else
                var url = href;

            if(typeClick == 'left')
                window.location.href = url;
            else if(typeClick == 'middle')
                window.open(url);

        },
        loadMoreProductWithType: function () {
            var typeLoadProduct = $(this).data('type');
            var page = $(this).data('page');
            var that = $(this);

            var callBack = function(data){
                if(data.ok)
                {
                    console.log(data.data);
                    var productItemTemplate = $('#template-product-item').html();
                    var productItemTemplateGenerate = $.tmpl(productItemTemplate, {'products': data.data});
                    that.parents('.block-tag').find('.block-tag-body .row').append(productItemTemplateGenerate);
                    Kacana.homepage.applySlideImage();
                    that.data('page', page+1);
                }
                else{
                    that.remove();
                }

                if(data.stop_load == 1){
                    that.remove();
                }
                that.find('i').removeClass('pe-spin');
            };
            var errorCallBack = function(){};
            $(this).find('i').addClass('pe-spin');
            Kacana.ajax.homepage.loadMoreProductWithType(typeLoadProduct, page, callBack, errorCallBack);
        },
        applySlideImage: function(){

            $.extend($.rsProto, {
                _initGlobalCaption: function() {
                    var self = this;
                    if(self.st.globalCaption) {

                        self.ev.on('rsAfterContentSet', function(e, currSlideObject) {
                            if(currSlideObject.id == 0){
                                var productItem = e.target.slider.parents('.product-item');
                                var firstImage = productItem.find('.product-image-inside').data('firstImage');
                                productItem.find('.rsImg.rsMainSlideImage').attr('data-original', firstImage);
                                productItem.find('.rsImg.rsMainSlideImage').lazyload();
                            }
                        });

                        self.ev.on('rsAfterSlideChange', function(e) {
                            var id = e.target.currSlideId;
                            var productItem = e.target.slider.parents('.product-item');
                            productItem.data('color-index', id);
                        });
                    }
                }
            });
            $.rsModules.globalCaption = $.rsProto._initGlobalCaption;

            $('.product-image-inside').royalSlider({
                fullscreen: {
                    enabled: true,
                    nativeFS: false
                },
                controlNavigation: 'none',
                autoScaleSlider: true,
                autoScaleSliderWidth: 2000,
                autoScaleSliderHeight: 2000,
                loop: true,
                imageScaleMode: 'fit',
                navigateByClick: false,
                numImagesToPreload: 0,
                arrowsNav: false,
                arrowsNavAutoHide: true,
                arrowsNavHideOnTouch: true,
                keyboardNavEnabled: true,
                fadeinLoadedSlide: true,
                globalCaption: true,
                globalCaptionInside: false,
                transitionType: 'fade',
                thumbs: {
                    appendSpan: true,
                    firstMargin: false,
                    paddingBottom: 4,
                    thumbArrow: true,
                    spacing: 20,
                    arrowsAutoHide: true,
                    autoCenter: false
                },
                imgHeight: 200
            });

            $('.list-color-product:not(.slick-initialized)').on('init', function(event, slick){
                    $(this).css('opacity', 1);
                    $(this).find('img').lazyload();

                }).slick({
                dots: false,
                infinite: false,
                speed: 300,
                slidesToShow: 5,
                slidesToScroll: 3,
                arrows: true,
                lazyLoad: 'ondemand'
            }).on('click', 'a[href="#choose-product-color"]', function () {
                var idSlide = $(this).parents().index() + 1;
                console.log(idSlide);
                $(this).parents('.product-item').find('.product-image-inside').royalSlider('goTo', idSlide);
            });
        },
        getPopoverPlacement: function(pop, dom_el){
                var width = window.innerWidth;
                if (width<500) return 'bottom';
                var left_pos = $(dom_el).offset().left;
                if (width - left_pos > 400) return 'right';
                return 'left';
        },
        initPopover: function(id, data){
            $('#_btn_'+id).popover({
                html: 'true',
                title:'Tư vấn <a href="#" class="close" data-dismiss="alert">&times;</a>',
                placement: Kacana.homepage.getPopoverPlacement,
                content : data
            }).popover('show');
        },
        showPopupRequest: function(){
            Kacana.homepage.adviseBtn.click(function(){
                Kacana.homepage.adviseBtn.popover('destroy');
                var id = $(this).attr('id').substr(5);
                var callBack = function(data){
                    $(window).on('resize', function(){
                        $('.btn-advise').popover('destroy');
                        Kacana.homepage.initPopover(id, data);
                    })
                    Kacana.homepage.initPopover(id, data);
                };
                var errorCallBack = function(){};
                Kacana.ajax.homepage.showPopupRequest(id, callBack, errorCallBack);
            })
        },
        sendRequest: function(){
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
        }
    }
};

$.extend(true, Kacana, homepagePackage);