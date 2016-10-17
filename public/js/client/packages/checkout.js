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
            // Kacana.checkout.page.on('change', 'select[name="districtId"]', Kacana.checkout.changeDistrict);
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
                    // wardId: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Vui lòng chọn phường/xã'
                    //         },
                    //     }
                    // },
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
            // var wardSelect = $('select[name="wardId"]');

            var cityId = $(this).val();

            // form.formValidation('enableFieldValidators', 'wardId', false).formValidation('resetField', 'wardId');
            // wardSelect.val('').attr('disabled', true).find('option[value=""]').show();

            form.formValidation('enableFieldValidators', 'districtId', true).formValidation('resetField', 'districtId');
            districtSelect.val('');

            if(parseInt(cityId))
            {
                districtSelect.find('option').hide();
                districtSelect.find('option[data-city-id="'+cityId+'"]').show();
                districtSelect.removeAttr('disabled').find('option[value=""]').show();
            }
            else
            {
                form.formValidation('enableFieldValidators', 'districtId', false).formValidation('resetField', 'districtId');
                districtSelect.val('').attr('disabled', true).find('option[value=""]').show();
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
                wardSelect.find('option').hide();
                wardSelect.find('option[data-district-id="'+districtId+'"]').show();
                wardSelect.removeAttr('disabled').find('option[value=""]').show();
            }
            else{
                wardSelect.val('').attr('disabled', true).find('option[value=""]').show();
                form.formValidation('enableFieldValidators', 'ward', false).formValidation('resetField', 'wardId');
            }
        }
    }

};

$.extend(true, Kacana, checkoutPackage);