var cartPackage = {
    cart: {
        page: $('#cart-page'),
        classQty: $(".qty"),
        classRemove: $('.remove-cart'),
        init: function () {
            Kacana.cart.loadCart();
            Kacana.cart.initQuantity();
            Kacana.cart.page.on('click', 'a[href="#remove-cart-item"]', Kacana.cart.removeCart);
            $('#header .nav-main.mega-menu').remove();
        },
        initQuantity: function(){
            Kacana.cart.page.on('click', '.btn-number', function(e){
                e.preventDefault();
                fieldName = $(this).attr('data-field');
                type      = $(this).attr('data-type');
                var input = $("input[name='"+fieldName+"']");
                var currentVal = parseInt(input.val());
                if (!isNaN(currentVal)) {
                    if(type == 'minus') {

                        if(currentVal > input.attr('min')) {
                            input.val(currentVal - 1).change();
                            input.data('old-value', input.val());
                            Kacana.cart.updateCart(input.data('id'), input.val());
                        }
                        if(parseInt(input.val()) == input.attr('min')) {
                            $(this).attr('disabled', true);
                        }

                    } else if(type == 'plus') {

                        if(currentVal < input.attr('max')) {
                            input.val(currentVal + 1).change();
                            input.data('old-value', input.val());
                            Kacana.cart.updateCart(input.data('id'), input.val());
                        }
                        if(parseInt(input.val()) == input.attr('max')) {
                            $(this).attr('disabled', true);
                        }

                    }
                } else {
                    input.val(0);
                }
            });

            Kacana.cart.page.on('change', '.input-number',function() {

                minValue =  parseInt($(this).attr('min'));
                maxValue =  parseInt($(this).attr('max'));
                valueCurrent = parseInt($(this).val());

                name = $(this).attr('name');
                if(valueCurrent >= minValue) {
                    $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
                } else {
                    Kacana.utils.showError('nhập số lượng sản phẩm bị sai!');
                    return $(this).val($(this).data('old-value'));
                }

                if(valueCurrent <= maxValue) {
                    $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
                } else {
                    Kacana.utils.showError('nhập số lượng sản phẩm bị sai!');
                    return $(this).val($(this).data('old-value'));
                }

                Kacana.cart.updateCart($(this).data('id'), $(this).val());
            });

            Kacana.cart.page.on('keydown', '.input-number',function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                        // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                        // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });

        },
        removeCart: function(){
            var id = $(this).data('id');

            var callBack = function(data){
                if(data.ok){
                    Kacana.cart.generateCart(data.cart);
                    Kacana.utils.loading.closeLoading();
                }
                else
                    Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
            };
            var errorCallBack = function(data){
                Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                Kacana.utils.loading.closeLoading();
            };
            Kacana.ajax.cart.removeCart(id, callBack, errorCallBack);
        },
        updateCart: function(rowId, quantity){

                var callBack = function(data){
                    if(data.ok){
                        Kacana.cart.generateCart(data.cart);
                        Kacana.utils.loading.closeLoading();
                    }
                    else
                        Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                };

                var errorCallBack = function(data){
                    Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                    Kacana.utils.loading.closeLoading();
                };
                Kacana.utils.loading.loading();
                Kacana.ajax.cart.updateCart(rowId, quantity, callBack, errorCallBack);
        },
        changeCity: function(){
            var id = $("#city_id").val();
            var token = $("input[name='_token']").val();
            var callBack = function(data){
                $("#ward-area").html(data);
            };
            var errorCallback = function(data){};
            Kacana.ajax.cart.changeCity('id='+id+"&_token="+token, callBack, errorCallback);
        },
        processCart: function(){
            $("#process").attr('disabled', true);
            $("#ward_id").val($("#ward").val());
            var other_data = $("#form-user-info").serialize();
            var callBack = function(data){
                json_result = JSON.parse(data);
                if(json_result.status==='ok'){
                    window.location.href= '/cart/don-dat-hang/'+json_result.id;
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
                if(typeof(json_result['name_2'])!=''){
                    $("#error-name_2").html(json_result['name_2']);
                }
                if(typeof(json_result['phone_2'])!=''){
                    $("#error-phone_2").html(json_result['phone_2']);
                }
                if(typeof(json_result['street'])!=''){
                    $("#error-street").html(json_result['street']);
                }
                if(typeof(json_result['city_id'])!=''){
                    $("#error-city").html(json_result['city_id']);
                }
                if(typeof(json_result['ward_id'])!=''){
                    $("#error-ward").html(json_result['ward_id']);
                }
                $("#process").attr('disabled', false);
            };
            Kacana.ajax.cart.processCart(other_data, callBack, errorCallBack);
        },
        loadCart: function () {
            var callBack = function(data) {
                if(data.ok){
                    Kacana.cart.generateCart(data.cart);
                    Kacana.utils.loading.closeLoading();
                }
                else
                    Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
            };
            var errorCallBack = function(data){
                Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
            };
            Kacana.utils.loading.loading();
            Kacana.ajax.cart.loadCart(callBack, errorCallBack);
        },
        generateCart: function(cart){
            var listCartItemTemplate = $('#list-cart-item-template');
            var cartInformationTemplate = $('#cart-information-template');

            if(cart){
                Kacana.cart.page.find('#cart-empty-error').hide();
                var cart = cart;
                var items = cart.items;

                var listCartItemTemplateGenerate = $.tmpl(listCartItemTemplate, {'items': items, 'cart': cart});
                Kacana.cart.page.find('#list-cart-item').empty().append(listCartItemTemplateGenerate);

                var cartInformationTemplateGenerate = $.tmpl(cartInformationTemplate, {'items': items, 'cart': cart});
                Kacana.cart.page.find('#cart-information').empty().append(cartInformationTemplateGenerate);
            }
            else
            {
                Kacana.cart.page.find('#list-cart-item, #cart-information').hide();
                Kacana.cart.page.find('#cart-empty-error').show();
            }
            Kacana.cart.checkButtonQuantity();
        },
        checkButtonQuantity: function(){
            Kacana.cart.page.find('.input-number').each(function() {

                minValue =  parseInt($(this).attr('min'));
                maxValue =  parseInt($(this).attr('max'));
                valueCurrent = parseInt($(this).val());

                name = $(this).attr('name');
                if(valueCurrent >= minValue) {
                    $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
                }

                if(valueCurrent <= maxValue) {
                    $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
                }
            });
        }
    }

};

$.extend(true, Kacana, cartPackage);