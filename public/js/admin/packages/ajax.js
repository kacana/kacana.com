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
        admin:{
            changeStatus: function(id, value, field, $tableName, callback, errorCallback){
              var url = '/base/changeStatus';
              var dataType = 'json';
              var type = 'post';
              var dataPost = {
                  'id': id,
                  'value': value,
                  'tableName': $tableName,
                  'field': field
              };
              var options = [];
              Kacana.ajax.init(url, dataType, type, dataPost, callback, errorCallback, options);
            },
            getReportChart: function (url, data, callback, errorCallback) {
                var url = url;
                var dataType = 'json';
                var type = 'post';
                var dataPost = data
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callback, errorCallback, options);
            },
            updateField: function (id, content, field, table, callback, errorCallback) {
                var url = '/base/updateField';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {
                    'id': id,
                    'content': content,
                    'table': table,
                    'field': field
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callback, errorCallback, options);
            }
        },
        /*****************************************************************************
         *
         *          FUNCTION AJAX FOR USER MANAGEMENT
         *
         * ***************************************************************************/
        user:{
            showFormCreateUser: function(callBack,errorCallBack){
                Kacana.ajax.init('/user/showCreateForm', '', 'get', '', callBack, errorCallBack, []);
            },
            createUser: function(otherData, dataPost, callBack, errorCallBack){
                Kacana.ajax.initFileUpload('/user/create?'+otherData, 'post', dataPost, callBack, errorCallBack);
            },
            removeUser: function(id, callBack, errorCallBack){
                Kacana.ajax.init('/user/remove/'+id, '', 'get', '', callBack, errorCallBack, []);
            },
            setStatus: function(id, status, callBack, errorCallBack){
                Kacana.ajax.init('/user/setStatus/'+id+'/'+status, '', 'get', '', callBack, errorCallBack, []);
            },
            getTrackingMessageInfo: function (data, callBack, errorCallBack) {
                var url = '/user/get-tracking-message-info';
                var dataType = 'json';
                var type = 'get';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            }
        },
        /*****************************************************************************
         *
         *          FUNCTION AJAX FOR BRANCH MANAGEMENT
         *
         * ***************************************************************************/
        branch:{
            createBranch: function(otherData, dataPost, callBack, errorCallBack){
                Kacana.ajax.initFileUpload('/branch/createBranch?'+otherData, 'post',dataPost, callBack, errorCallBack);
            },
            showEditBranchForm: function(idBranch, callBack, errorCallBack){
                Kacana.ajax.init('/branch/showEditFormBranch/'+idBranch,'', 'get', '', callBack, errorCallBack, []);
            },
            editBranch: function(otherData, dataPost, callBack, errorCallBack){
                Kacana.ajax.initFileUpload('/branch/editBranch?'+ otherData, 'post', dataPost, callBack, errorCallBack);
            },
            setStatusBranch: function(id, status, callBack, errorCallBack){
                Kacana.ajax.init('/branch/setStatusBranch/'+id+'/'+status,'', 'get', '', callBack, errorCallBack, []);
            },
            removeBranch: function(id,callBack, errorCallBack){
                Kacana.ajax.init('/branch/removeBranch/'+id, '', 'get', '', callBack, errorCallBack, []);
            }
        },
        /*****************************************************************************
         *
         *          FUNCTION AJAX FOR PRODUCT MANAGEMENT
         *
         * ***************************************************************************/
        product: {
            removeProduct: function(id,callBack, errorCallBack){
                Kacana.ajax.init('/product/removeProduct/'+id, '', 'get', '', callBack, errorCallBack, []);
            },
            setStatus: function(id, status, callBack, errorCallBack){
                Kacana.ajax.init('/product/setStatus/'+id+'/'+status, '', 'get', '', callBack, errorCallBack, []);
            },
            addProductImage: function(data,callBack, errorCallBack){
                var url = '/product/addProductImage';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            updateProductImageType: function(data, callBack, errorCallBack){
                var url = '/product/updateProductImageType';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            updateImage: function(data, callBack, errorCallBack){
                var url = '/product/updateImage';
                var dataType = 'json';
                var type = 'post';
                var dataPost =data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            countSearchProductByTagId: function(tagId, callBack, errorCallBack){
                var url = '/product/countSearchProductByTagId';
                var dataType = 'json';
                var type = 'post';
                var dataPost ={
                    tagId: tagId
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            createCSVForRemarketing: function (callBack, errorCallBack) {
                var url = '/product/createCSVForRemarketing';
                var dataType = 'json';
                var type = 'post';
                var dataPost ={};
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            sortProductGallery: function (imageIds, productId, callBack, errorCallBack) {
                var url = '/product/sortProductGallery';
                var dataType = 'json';
                var type = 'post';
                var dataPost ={
                    imageIds: imageIds,
                    productId: productId
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            deleteProductProperty: function (propertyId, callBack, errorCallBack) {
                var url = '/product/deleteProductProperty';
                var dataType = 'json';
                var type = 'post';
                var dataPost ={
                    propertyId: propertyId
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            getProductInfoByPropertyId: function (propertyId, callBack, errorCallBack) {
                var url = '/product/getProductInfoByPropertyId';
                var dataType = 'json';
                var type = 'post';
                var dataPost ={
                    propertyId: propertyId
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            importProduct: function (propertyId, quantity, price, callBack, errorCallBack) {
                var url = '/product/importProduct';
                var dataType = 'json';
                var type = 'post';
                var dataPost ={
                    propertyId: propertyId,
                    price: price,
                    quantity: quantity
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            deleteImportProduct: function (propertyId) {
                var url = '/product/deleteImportProduct';
                var dataType = 'json';
                var type = 'post';
                var dataPost ={
                    propertyId: propertyId
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            updateImport: function (id, currentQuantity, quantity, price, callBack, errorCallBack) {
                var url = '/product/updateImportProduct';
                var dataType = 'json';
                var type = 'post';
                var dataPost ={
                    importId: id,
                    currentQuantity: currentQuantity,
                    quantity: quantity,
                    price: price
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            getProductAjax: function (id, callBack, errorCallBack) {
                var url = '/product/getProductAjax';
                var dataType = 'json';
                var type = 'get';
                var dataPost ={
                    product_id: id
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            }
        },
        /*****************************************************************************
         *
         *          FUNCTION AJAX FOR TAG MANAGEMENT
         *
         * ***************************************************************************/
        tag: {
            showCreateForm: function(id, callBack, errorCallBack){
                Kacana.ajax.init('/tag/showFormCreate/'+id, '', 'get', '', callBack, errorCallBack, []);
            },
            createTag: function(name, callBack, errorCallBack){
                var url = '/tag/createTag';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {
                    'name': name
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            createTagWithType: function(tagName, typeId, parentId, callBack, errorCallBack){
                var url = '/tag/createTag';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {
                    'name': tagName,
                    'typeId': typeId,
                    'parentId': parentId
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            showEditForm: function(id, callBack, errorCallBack){
                Kacana.ajax.init('/tag/showEditFormTag/'+id, '', 'get', '', callBack, errorCallBack, []);
            },
            editTag: function(id, name, nameSEO, shortTagDescription, callBack, errorCallBack){
                var url = '/tag/editTag';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {
                    name: name,
                    name_seo: nameSEO,
                    id: id,
                    shortTagDescription: shortTagDescription
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            removeTagRelation: function(id, typeId, parentId, callBack, errorCallBack){
                var url = '/tag/removeTagRelation';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {
                    'typeId': typeId,
                    'id': id,
                    'parentId': parentId
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            setType: function(id, type, callBack, errorCallBack){
                Kacana.ajax.init('/tag/setType/'+id+'/'+type,'json', 'get','',callBack, errorCallBack, []);
            },
            updateImage: function(data, callBack, errorCallBack){
                var url = '/tag/updateImage';
                var dataType = 'json';
                var type = 'post';
                var dataPost =data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            processTagMove: function(movedTagId, targetTagId, position, movedTagParentId, typeId, callBack, errorCallBack)
            {
                var url = '/tag/processTagMove';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {
                    movedTagId: movedTagId,
                    targetTagId: targetTagId,
                    position: position,
                    movedTagParentId: movedTagParentId,
                    typeId: typeId
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            searchTagRelation : function(name, typeId, callBack, errorCallBack){
                var url = '/tag/searchTagRelation';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {
                    name: name,
                    typeId: typeId
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            addTagToRoot: function(tagId, typeId, callBack, errorCallBack){
                var url = '/tag/addTagToRoot';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {
                    tagId: tagId,
                    typeId: typeId
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            addTagToParent: function(tagId, parentId, typeId, callBack, errorCallBack){
                var url = '/tag/addTagToParent';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {
                    tagId: tagId,
                    parentId: parentId,
                    typeId: typeId
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            getTag: function(tagId, callBack, errorCallBack){
                var url = '/tag/getTag';
                var dataType = 'json';
                var type = 'get';
                var dataPost = {
                    tagId: tagId
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            searchTag: function(name, callBack, errorCallBack){
                var url = '/tag/searchTag';
                var dataType = 'json';
                var type = 'get';
                var dataPost = {
                    name: name
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            getGroupTag: function (tagIds, callBack, errorCallBack) {
                var url = '/tag/getGroupTag';
                var dataType = 'json';
                var type = 'post';
                var dataPost ={
                    tagIds: tagIds
                };
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            changeTagStatusRelation: function (sendData, callBack, errorCallBack) {
                var url = '/tag/changeTagStatusRelation';
                var dataType = 'json';
                var type = 'post';
                var dataPost =sendData;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
        },
        /*****************************************************************************
         *
         *          FUNCTION AJAX FOR USER ADDRESS MANAGEMENT
         *
         * ***************************************************************************/
        userAddress:{
            showFormEdit: function(id, callBack, errorCallBack){
                Kacana.ajax.init('/user/showFormEditUserAddress/'+id, '', 'get', '', callBack, errorCallBack, []);
            },
            edit: function(data, callBack, errorCallBack){
                Kacana.ajax.initFileUpload('/user/editUserAddress?'+data, 'post', '', callBack, errorCallBack);
            },
            changeCity: function(id, callBack, errorCallBack){
                Kacana.ajax.init('/user/showListWards/'+id, '', 'get', '', callBack, errorCallBack, []);
            }
        },
        /*****************************************************************************
         *
         *          FUNCTION AJAX FOR ORDER MANAGEMENT
         *
         * ***************************************************************************/
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
            },
            exportProductAtStore: function (orderId, callBack, errorCallBack) {
                var url = '/order/exportProductAtStore?orderId='+orderId;
                var dataType = 'json';
                var type = 'get';
                var dataPost = {};
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            }
        },
        chat: {
            createNewThread: function(data, callBack, errorCallBack){
                var url = '/chat/sendMessage';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            getNewMessage: function(data, callBack, errorCallBack){
                var url = '/chat/getNewMessage';
                var dataType = 'json';
                var type = 'get';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            getOldThread: function(data, callBack, errorCallBack){
                var url = '/chat/getOldThread';
                var dataType = 'json';
                var type = 'get';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            createNewMessage: function (data, callBack, errorCallBack) {
                var url = '/chat/createNewMessage';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            updateLastRead: function (data, callBack, errorCallBack) {
                var url = '/chat/updateLastRead';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            getUserMessage: function (data, callBack, errorCallBack) {
                var url = '/chat/getUserMessage';
                var dataType = 'json';
                var type = 'post';
                var dataPost = data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            }
        },
        blog: {
            updatePostMainImage: function(data, callBack, errorCallBack){
                var url = '/blog/updatePostMainImage';
                var dataType = 'json';
                var type = 'post';
                var dataPost =data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            addPostImage: function(data, callBack, errorCallBack){
                var url = '/blog/addPostImage';
                var dataType = 'json';
                var type = 'post';
                var dataPost =data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            }
        },
        campaign: {
            validateTimeCampaign: function (data, callBack, errorCallBack){
                var url = '/campaign/validateTimeCampaign';
                var dataType = 'json';
                var type = 'post';
                var dataPost =data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            updateCampaignImage: function(data, callBack, errorCallBack){
                var url = '/campaign/updateCampaignImage';
                var dataType = 'json';
                var type = 'post';
                var dataPost =data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            searchProduct: function(data, callBack, errorCallBack){
                var url = '/campaign/searchProduct';
                var dataType = 'json';
                var type = 'get';
                var dataPost =data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            addProductCampaign: function (data, callBack, errorCallBack) {
                var url = '/campaign/addProductCampaign';
                var dataType = 'json';
                var type = 'post';
                var dataPost =data;
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            },
            removeCampaignProduct: function (campaignProductId, callBack, errorCallBack) {
                var url = '/campaign/removeCampaignProduct';
                var dataType = 'json';
                var type = 'post';
                var dataPost = {'campaignProductId': campaignProductId};
                var options = [];
                Kacana.ajax.init(url, dataType, type, dataPost, callBack, errorCallBack, options);
            }
        }
     }
};

$.extend(true, Kacana, ajaxPackage);