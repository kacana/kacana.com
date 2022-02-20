var customerPackage = {
    customer:{
        init: function(){

        },
        trackingOrder: {
            validateForTracking: function(){
                var form = $('#form-checking-tracking-order');
                // form validate before submit
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
                                    regexp: {
                                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                                        message: 'Vui lòng nhập địa chỉ email của bạn'
                                    }
                                }
                            },
                            orderCode: {
                                validators: {
                                    notEmpty: {
                                        message: 'Vui lòng nhập mã đơn hàng'
                                    },
                                    integer: {
                                        message: 'Mã đơn hàng không đúng định dạng',
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
                    })
                    .on('success.form.fv', function(){

                    });
            }
        },
        account:{
            init: function(){
                var page = $('#customer-account-page');
                page.on('click', '#btn-change-account-information, #btn-change-account-password', function(){
                    var form = $(this).parents('form');
                    form.find('input').removeAttr('readonly');
                    form.removeClass('view-type');
                });

                page.on('click', '#btn-cancel-account-information, #btn-cancel-account-password', function(){
                    var form = $(this).parents('form');
                    var formId = form.attr('id');
                    form.find('input').each(function () {
                        $(this).attr('readonly', true);
                        var name = $(this).attr('name');
                        form.formValidation('resetField', name);
                        if(formId == 'form-update-account-information'){
                            $(this).val($(this).data('value'));
                        }
                        else{
                            $(this).val('');
                        }
                    });
                    form.addClass('view-type');
                });
                setTimeout(function(){
                    page.find('.alert').fadeOut('300');
                }, 5000);
                Kacana.customer.account.validateAccoutInformation();
                Kacana.customer.account.validateAccoutPassword();
            },
            validateAccoutInformation: function(){
                var form = $('#form-update-account-information');

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
                                regexp: {
                                    regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                                    message: 'Vui lòng nhập địa chỉ email của bạn'
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
            validateAccoutPassword: function(){
                var form = $('#form-change-password');

                form.formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        currentPassword: {
                            validators: {
                                notEmpty: {
                                    message: 'Vui lòng nhập mật khẩu hiện tại của bạn'
                                }
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
                });
            }
        },
        forgot:{
            init: function () {
                Kacana.customer.forgot.validateForgot();
            },
            validateForgot: function(){
                var form = $('#form-forgot-password');

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
                                regexp: {
                                    regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                                    message: 'Vui lòng nhập địa chỉ email của bạn'
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
            }
        },
        newPassword: {
            init: function () {
                Kacana.customer.newPassword.validateNewPassword();
                $('input[name="password"]').val();
            },
            validateNewPassword: function(){

                var form = $('#form-new-password');

                form.formValidation({
                    framework: 'bootstrap',
                    icon: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
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
                });
            }
        },
        address:{
            init: function(){
                setTimeout(function(){
                    $('body').find('.alert.alert-success').fadeOut('300');
                }, 5000);
                $('#customer-page').on('click', '.delete-address-receive', function(){
                    var addressName = $(this).data('name');
                    var href = $(this).attr('href');
                    swal({
                        title: 'Bạn có chắc?',
                        text: "Muốn xoá địa chỉ ["+addressName+"]!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Tiếp tục!'
                    }).then(function() {
                        window.location.href = href;
                    });
                    return false;
                });
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
                        street: {
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
                        wardId: {
                            validators: {
                                notEmpty: {
                                    message: 'Vui lòng chọn phường/xã'
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

                form.on('change', 'select[name="cityId"]', Kacana.customer.address.changeCity);
                form.on('change', 'select[name="districtId"]', Kacana.customer.address.changeDistrict);
            },
            changeCity: function(){
                var form = $('#form_address_step');
                var districtSelect = $('select[name="districtId"]');
                var wardSelect = $('select[name="wardId"]');

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
                    districtSelect.removeAttr('disabled')
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
                    var callBack = function(data){
                        if(data.ok){
                            var items = data.data;
                            var strOption = '<option value="">Chọn phường/xã</option>';
                            for(var i = 0; i < items.length; i++){
                                strOption += '<option value="'+items[i].id+'">'+items[i].name+'</option>'
                            }
                            form.find('select[name="wardId"]').html(strOption);
                            Kacana.utils.loading.closeLoading();
                            wardSelect.removeAttr('disabled').show();
                        }
                        else
                            Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0399.761.768');
                    };
                    var errorCallBack = function(data){
                        Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0399.761.768');
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
    }
};

$.extend(true, Kacana, customerPackage);