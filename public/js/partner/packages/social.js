var socialPackage = {
    social:{
        page: false,
        init: function(){
            Kacana.social.page = $('#page-content-social-account');
            Kacana.utils.facebook.init();
            Kacana.social.bindEvent();
        },
        bindEvent: function () {
            Kacana.social.page.on('click', 'a[href="#add-new-facebook-account"]', function () {
                Kacana.utils.facebook.postToFacebook(Kacana.social.addFacebookAccount);
            });

            Kacana.social.page.on('click', 'a[href="#edit-name-social-item"]', Kacana.social.editSocialName);
            Kacana.social.page.on('click', 'a[href="#delete-social-item"]', Kacana.social.deleteSocialItem);
            Kacana.social.page.on('click', 'a[href="#change-name-social-item"]', Kacana.social.changeNameSocialItem);
        },
        deleteSocialItem: function () {
            var item = $(this).parents('.social-item');

            var name = item.data('name');
            var socialId = item.data('social-id');
            var image = item.data('image');
            var type = item.data('type');

            swal({
                title: 'Xoá tài khoản?',
                text: "bạn có chắc chắn xoá tài khoản "+name+"!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có',
                showLoaderOnConfirm: true,
                preConfirm: function (email) {
                    return new Promise(function (resolve, reject) {
                        var callBack = function(data) {

                            if(data.ok){
                                resolve();
                                var socialItem = $('#social-item-'+socialId+'-'+type);
                                socialItem.remove();
                            }
                            else
                            {
                                Kacana.utils.showError(data.error_message);
                            }
                            Kacana.utils.loading.closeLoading();
                        };
                        var errorCallBack = function(data){
                            Kacana.utils.loading.closeLoading();

                        };

                        var data = {
                            socialId: socialId,
                            type: type
                        };

                        Kacana.ajax.social.deleteSocialItem(data, callBack, errorCallBack);
                    });
                }
            }).then(function () {

                swal(
                    'Đã xoá!',
                    'Tài khoản social '+name+' đã được xoá khỏi hệ thống',
                    'success'
                )
            })
        },
        editSocialName: function () {
            var modal = $('#modal-edit-name-social-item');
            var item = $(this).parents('.social-item');

            var name = item.data('name');
            var socialId = item.data('social-id');
            var image = item.data('image');
            var type = item.data('type');

            modal.find('.social-item-image-modal').attr('src', image);
            modal.find('.social-item-name-modal').val(name);

            modal.data('social-id', socialId);
            modal.data('type', type);

            modal.modal();
        },
        changeNameSocialItem: function () {
            var modal = $('#modal-edit-name-social-item');
            var name =  modal.find('.social-item-name-modal').val();
            var socialId = modal.data('social-id');
            var type = modal.data('type');

            if(!name)
                return modal.find('.social-item-name-modal').focus();
            else{
                var callBack = function(data) {

                    if(data.ok){
                        var socialItem = $('#social-item-'+socialId+'-'+type);
                        socialItem.find('.social-item-name').html(name);
                    }
                    else
                    {
                        Kacana.utils.showError(data.error_message);
                    }
                    Kacana.utils.loading.closeLoading();
                };
                var errorCallBack = function(data){
                    Kacana.utils.loading.closeLoading();

                };

                var data = {
                    name: name,
                    socialId: socialId,
                    type: type
                };
                modal.modal('hide');
                Kacana.utils.loading.loading();

                Kacana.ajax.social.changeNameSocialItem(data, callBack, errorCallBack);
            }


        },
        addFacebookAccount: function (response) {
            if(response.status == 'connected')
            {
                response = response.authResponse;
                var accessToken = response.accessToken;

                var callBack = function(data) {

                    if(data.ok){
                        location.reload();
                    }
                    else
                    {
                        Kacana.utils.showError(data.error_message);
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

                Kacana.ajax.social.addFacebookAccount(data, callBack, errorCallBack);
            }
            else{
                Kacana.utils.showError('get access facebook failed');
            }
        },

    }
};

$.extend(true, Kacana, socialPackage);