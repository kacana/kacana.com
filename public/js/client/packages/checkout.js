var checkoutPackage = {
    checkout: {
        page: $('#checkout-page'),
        init: function () {
            Kacana.checkout.bindEvent();
            Kacana.checkout.validationLoginStep();
            Kacana.checkout.validationAddressStep();
        },
        bindEvent: function(){
            Kacana.checkout.page.on('click', 'input[name="optionSignup"]', Kacana.checkout.checkOptionOrder);
            Kacana.checkout.page.on('change', 'select[name="cityId"]', Kacana.checkout.changeCity);
            Kacana.checkout.page.on('change', 'select[name="districtId"]', Kacana.checkout.changeDistrict);
            Kacana.checkout.page.on('click', '.checkout-address-item', Kacana.checkout.changeAddressUser);
            Kacana.checkout.changeShipFeeByDefaultAddress();
        },
        changeAddressUser: function () {
            Kacana.checkout.changeShippingFee($(this).data('cityId'));
        },
        changeShipFeeByDefaultAddress: function () {
            var addressDefault = Kacana.checkout.page.find('#checkout-choose-address-step .checkout-address-item input[name="checkout-address-id"]:checked');

            if(addressDefault.length)
            {
                Kacana.checkout.changeShippingFee(addressDefault.parent('.checkout-address-item').data('city-id'));
            }
        },
        checkOptionOrder: function(){
            var inputPassword = $('#password');
            if(parseInt($(this).val()))
            {
                inputPassword.attr('disabled', true);
            }
            else
                inputPassword.removeAttr('disabled');
        },
        validationAddressStep: function(){
            var form = $('#form_address_step');
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
                    address: {
                        validators: {
                            notEmpty: {
                                message: 'Vui lòng nhập địa chỉ'
                            },
                            regexp: {
                                regexp: /^[\w\xC0-\uFFFF \/,.()-]*(?=(\S+\s\S+)+)(?=(.*\d)+)(?=(.*[a-zA-Z\xC0-\uFFFF]){2})[\w\xC0-\uFFFF \/,.()-]*$/,
                                message: 'Địa chỉ giao hàng cần có ít nhất 4 kí tự (cả số và chữ)'
                            }
                        }
                    },
                    cityId: {
                        validators: {
                            notEmpty: {
                                message: 'Vui lòng chọn tỉnh/thành phố'
                            },
                        }
                    },
                    districtId: {
                        validators: {
                            notEmpty: {
                                message: 'Vui lòng chọn quận/huyện'
                            },
                        }
                    },
                    wardId: {
                        validators: {
                            notEmpty: {
                                message: 'Vui lòng chọn phường/xã'
                            },
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
                    }
                }
            })
            .on('err.field.fv', function(e, data) {
                data.fv.disableSubmitButtons(false);
            })
            .on('success.field.fv', function(e, data) {
                data.fv.disableSubmitButtons(false);
            });

        },
        validationLoginStep: function(){
            var form = $('#form_login_step');
            form.formValidation({
                framework: 'bootstrap',
                icon: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
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
                                    // Registry a Mailgun account and get a free API key
                                    // at https://mailgun.com/signup
                                    api_key: 'pubkey-83a6-sl6j2m3daneyobi87b3-ksx3q29'
                                },
                                dataType: 'jsonp',
                                validKey: 'is_valid',
                                message: 'Email không đúng định dạng'
                            }
                        }
                    },
                    password: {
                        enabled: false,
                        validators: {
                            notEmpty: {
                                message: 'Vui lòng nhập mật khẩu của bạn'
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
            .on('click', 'input[name="optionSignup"]', function(){
                if(parseInt($(this).val()))
                {
                    form.formValidation('enableFieldValidators', 'password', false).formValidation('resetField', 'password');
                    form.find('#password').val('');
                }
                else
                    form.formValidation('enableFieldValidators', 'password', true);
            });
            form.find('input[name="optionSignup"]').eq(0).click();
            $('#next-step').removeAttr('disabled');
        },
        changeCity: function(){
            var form = $('#form_address_step');
            var districtSelect = $('select[name="districtId"]');
            var wardSelect = $('select[name="wardId"]');
            var cartTotal = parseInt($('#cart-information').data('cart-total'));
            var cartTotalShow = Kacana.utils.formatCurrency(cartTotal);
            var cityId = $(this).val();

            form.formValidation('enableFieldValidators', 'wardId', false).formValidation('resetField', 'wardId');
            wardSelect.val('').attr('disabled', true).find('option[value=""]').show();
            form.formValidation('enableFieldValidators', 'districtId', true).formValidation('resetField', 'districtId');
            districtSelect.val('');

            if(parseInt(cityId))
            {
                var listDistrict = districtSelect.data('district');
                var listOptionDistrict = '<option value="" style="display: block;">Chọn quận/huyện</option>';

                for(var i =0 ; i <  listDistrict.length ; i++){
                    if(listDistrict[i].city_id == parseInt(cityId))
                        listOptionDistrict +='<option data-city-id="'+listDistrict[i].city_id+'" value="'+listDistrict[i].id+'">'+listDistrict[i].name+'</option>';
                }

                districtSelect.html(listOptionDistrict);
                districtSelect.removeAttr('disabled');
                Kacana.checkout.changeShippingFee(cityId);
            }
            else
            {
                $('#checkout-label-ship-fee').html('Hồ Chí Minh: 15.000 đ <br> Khác: 30.000 đ');
                $('#checkout-cart-total').html(cartTotalShow +'<small class="text-red">+ Ship</small>')
                form.formValidation('enableFieldValidators', 'districtId', false).formValidation('resetField', 'districtId');
                districtSelect.val('').attr('disabled', true).find('option[value=""]').show();
            }
        },
        changeShippingFee: function (cityId) {
            var cartTotal = parseInt($('#cart-information').data('cart-total'));
            if(cartTotal < 500000)
            {
                if(parseInt(cityId) == 29)
                {
                    $('#checkout-label-ship-fee').html('15.000 đ');
                    $('#checkout-cart-total').html(Kacana.utils.formatCurrency(cartTotal+15000));
                }
                else{
                    $('#checkout-label-ship-fee').html('30.000 đ');
                    $('#checkout-cart-total').html(Kacana.utils.formatCurrency(cartTotal+30000))
                }
            }
        },
        changeDistrict: function(){

            var form = $('#form_address_step');
            var districtId = $(this).val();
            var wardSelect = $('select[name="wardId"]');
            form.formValidation('enableFieldValidators', 'wardId', true).formValidation('resetField', 'wardId');
            wardSelect.val('');

            if(parseInt(districtId))
            {
                var callBack = function(data){
                    if(data.ok){
                        var items = data.data;
                        var strOption = '<option value="">Chọn phường/xã</option>';
                        for(var i = 0; i < items.length; i++){
                            strOption += '<option value="'+items[i].id+'">'+items[i].name+'</option>'
                        }
                        Kacana.checkout.page.find('select[name="wardId"]').html(strOption);
                        Kacana.utils.loading.closeLoading();
                        wardSelect.removeAttr('disabled').show();
                    }
                    else
                        Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                };
                var errorCallBack = function(data){
                    Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                    Kacana.utils.loading.closeLoading();
                };

                Kacana.utils.loading.loading($('#form_address_step').parents('.panel-heading'));
                Kacana.ajax.cart.getWardByDistrictId(districtId, callBack, errorCallBack);
            }
            else{
                wardSelect.val('').attr('disabled', true);
            }
        }
    }

};

$.extend(true, Kacana, checkoutPackage);