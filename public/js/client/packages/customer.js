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
            },
            changeCity: function(){
                var form = $('#form_address_step');
                var districtSelect = $('select[name="districtId"]');

                var cityId = $(this).val();
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
            }
        }
    }
};

$.extend(true, Kacana, customerPackage);