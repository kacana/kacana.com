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
        },
        product: {
            generateProductBootTable: function(data, callBack, errorCallBack){
                var url = '/product/generateProductBootTable';
                var dataType = 'json';
                var type = 'get';
                var dataPost = data;
                var options = [];

                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            productSupperBoot: function(productIds, callBack, errorCallBack){
                var url = '/product/productSupperBoot';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {
                    productIds: productIds
                };
                var options = [];

                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            postToSocial: function (data, callBack, errorCallBack) {
                var url = '/product/postToSocial';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];

                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            postToLazada: function (data, callBack, errorCallBack) {
                var url = '/product/postToLazada';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];

                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            }
        },
        order:{
            changeCity: function(id, callBack, errorCallBack){
                Kacana.ajax.init('/user/showListWards/'+id, '', 'get', '', callBack, errorCallBack, []);
            },
            deleteOrderDetail: function(id, callBack, errorCallBack){
                Kacana.ajax.init('/order/deleteOrderDetail/'+id,'', 'get', '', callBack, errorCallBack, []);
            },
            updateOrderService: function(data, callBack, errorCallBack){
                var url = '/order/updateOrderService';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            getOrderDetailisOrdered: function(data, callBack, errorCallBack){
                var url = '/order/getOrderDetailisOrdered';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            checkFeeShipping: function(data, callBack, errorCallBack){
                var url = '/order/checkFeeShipping';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            searchAddressDelivery: function (data, callBack, errorCallBack) {
                var url = '/order/searchAddressDelivery';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            searchProduct: function (data, callBack, errorCallBack) {
                var url = '/order/searchProduct';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            getWardByDistrictId: function(districtId, callBack, errorCallBack){
                var url = '/order/getWardByDistrictId?districtId='+districtId;
                var dataType = 'json';
                var type = 'get';
                var dataPost = {};
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            }
        }
    }
};

$.extend(true, Kacana, ajaxPackage);