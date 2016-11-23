var ajaxPackage = {
    ajax: {
        init:function(url, dataType, type, dataPost, callBack, errorCallBack, options){

            //todo will re-change solution for option on this

            var cache = true;
            if(options.cache)
                cache = false;

            var async = true;
            if(options.async)
                async = false;

            $.ajax({
                url: url,
                dataType: dataType,
                type: type,
                cache: cache,
                async: async,
                data: dataPost,
                headers: {
                    'x-csrf-token':$('meta[name="csrf-token"]').attr('content')
                }
            }).done(function(data) {
                callBack(data);

            }).error(function() {
                errorCallBack();

            });

        },
        initFileUpload:function(url, type, dataPost, callBack, errorCallBack){
            $.ajax({
                url: url,
                type: type,
                data: dataPost,
                processData: false,
                contentType: false
            }).done(function(data)
            {
                callBack(data);

            }).fail(function(data, textStatus, errorThrown)
            {
                errorCallBack(data);

            });

        },
        checkStatus: function(url, callback){
            $.ajax(url, { type: 'HEAD'}).done(
                function (data, textStatus, jqXHR) {
                    callback(jqXHR.status);
                }
            );
        },
        /*****************************************************************************
         *
         *          FUNCTION AJAX FOR HOME PAGE
         *
         * ***************************************************************************/
        social:{
            addFacebookAccount: function(data, callBack, errorCallBack){
                var url = '/social_account/addFacebookAccount';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];

                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            changeNameSocialItem: function(data, callBack, errorCallBack){
                var url = '/social_account/changeNameSocialItem';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];

                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            deleteSocialItem: function(data, callBack, errorCallBack){
                var url = '/social_account/deleteSocialItem';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];

                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            }
        }
    }
};

$.extend(true, Kacana, ajaxPackage);