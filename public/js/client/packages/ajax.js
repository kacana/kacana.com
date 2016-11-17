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
        homepage:{
            saveProductLike: function(productId, productUrl, callBack, errorCallBack){
                var url = '/khach-hang/saveProductLike';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {
                    'productId': productId,
                    'productUrl': productUrl
                };
                var options = [];

                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            removeProductLike: function(productId, callBack, errorCallBack){
                var url = '/khach-hang/removeProductLike';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {
                    'productId': productId
                };
                var options = [];

                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            suggestSearchProduct: function(search, callBack, errorCallBack){
                var url = '/san-pham/suggestSearchProduct';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {
                    'search': search
                };
                var options = [];

                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            loadMoreProductWithType: function (typeLoadProduct, page, callBack, errorCallBack) {
                var url = '/san-pham/loadMoreProductWithType';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {
                    'type': typeLoadProduct,
                    'page': page
                };
                var options = [];

                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            }
        },
        product: {
            postProductToFacebook: function (data, callBack, errorCallBack) {
                var url = '/san-pham/postProductToFacebook';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            trackUserProductView: function (data, callBack, errorCallBack) {
                var url = '/san-pham/trackUserProductView';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            }
        },
        cart:{
            removeCart: function(id, callBack, errorCallBack){
                var url = '/cart/removeCart';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {
                    'rowId': id
                };
                var options = [];

                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            processCart: function(otherData, callBack, errorCallBack){
                Kacana.ajax.initFileUpload('/cart/processCart?'+otherData, 'post', '', callBack, errorCallBack)
            },
            addToCart: function(data, callBack, errorCallBack){
                var url = '/cart/addProductToCart';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            loadCart: function(callBack, errorCallBack){
                var url = '/cart/loadCart';
                var dataType = 'json';
                var type = 'get';
                var dataPost = [];
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            updateCart: function(rowId,quantity,callBack, errorCallBack){
                var url = '/cart/updateCart';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {
                    'rowId': rowId,
                    'quantity': quantity
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            getWardByDistrictId: function(districtId, callBack, errorCallBack){
                var url = '/cart/getWardByDistrictId?districtId='+districtId;
                var dataType = 'json';
                var type = 'get';
                var dataPost = {};
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            }
        },
        tagpage: {
            loadProduct: function(options,callBack, errorCallBack){
                Kacana.ajax.init('loadListProducts?'+options,'','post', '', callBack, errorCallBack, []);
            },
            loadFilter: function(hash, callBack, errorCallBack){
                Kacana.ajax.init('loadFilter?'+ hash, '', 'post', '', callBack, errorCallBack, []);
            }
        },
        auth: {
            login: function(data, callBack, errorCallBack){
                var url = '/auth/login';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            signup: function(data, callBack, errorCallBack){
                var url = '/auth/signup';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            socialLoginCallback: function(data, callBack, errorCallBack){
                var url = '/auth/signup/socialLoginCallback';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            facebookCallbackAllowPost: function (data, callBack, errorCallBack) {
                var url = '/auth/signup/facebookCallbackAllowPost';
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