var salePackage = {
    sale:{
        page: false,
        init: function(){
            Kacana.sale.page = $('#product-ex-page');
            Kacana.sale.bindEvent();
        },
        bindEvent: function () {
            Kacana.sale.page.find('#barcode-product').keypress(function (e) {
                console.log($(this).val());
                if(e.which == 13) {
                    var propertyId = $(this).val();
                    Kacana.sale.addProduct(propertyId);
                }
            });
        },
        addProduct: function (propertyId) {

            var callBack = function(data){
                if(data.ok){
                    console.log(data);
                }
            };

            var errorCallBack = function(){

            };

            Kacana.ajax.product.getProductInfoByPropertyId(propertyId, callBack, errorCallBack);

        },
        generateRow: function (data) {
            
        }
    }
};

$.extend(true, Kacana, salePackage);