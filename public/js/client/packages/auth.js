var authPackage = {
    auth: {
        login: function(){
            var form = $('#login-signup-form');
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
        signup: function(){
            var form = $('#login-signup-form');

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
            });
        },
        socialLoginCallback: function(type, accessToken, userId, expiresIn){
            var callBack = function(data) {

                if(data.ok){
                    window.location.reload();
                }
                else
                {
                    Kacana.utils.showError(data.error_message);
                }

                Kacana.utils.loading.closeLoading();
            };
            var errorCallBack = function(data){
                Kacana.utils.loading.closeLoading();
                Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
            };

            var data = {
                            type: type,
                            accessToken: accessToken,
                            userId: userId,
                            expiresIn: expiresIn
                        };

            Kacana.utils.loading.loading($('#btn-facebook-login-popup').parents('.login-form-wrap'));
            Kacana.ajax.auth.socialLoginCallback(data, callBack, errorCallBack);
        },
        socialLogin: {
            init: function(){

            },
            facebook: function(){
                Kacana.utils.facebook.login(Kacana.auth.socialLogin.facebookLoginCallback);
            },
            facebookLoginCallback: function(response){
               if(response.status == 'connected')
               {
                   response = response.authResponse;
                   var accessToken = response.accessToken;
                   Kacana.auth.socialLoginCallback(1, accessToken);

               }
               else{
                    Kacana.utils.showError('login facebook failed');
               }
            },
            google: function(){
                Kacana.utils.google.login(Kacana.auth.socialLogin.googleLoginCallback);
            },
            googleLoginCallback: function(data){
                if(data.code){
                    var code = data.code;
                    Kacana.auth.socialLoginCallback(2, code);
                }
                else{
                    Kacana.utils.showError('login google failed');
                }
            }
        }
    }
};

$.extend(true, Kacana, authPackage);