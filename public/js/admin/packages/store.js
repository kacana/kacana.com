var storePackage = {
    store:{
        indexPage: {
            page: false,
            init: function(){
                Kacana.store.indexPage.page = $('#store-index');
                Kacana.store.indexPage.bindEvent();
                Kacana.store.indexPage.generateStoreProductTable();
                Kacana.store.indexPage.searchProductForQuickImport();
            },
            bindEvent: function () {

            },
            generateStoreProductTable: function () {
                var $formInline = $('.form-inline');
                var element = '#storeProductTable';
                var storeId = $(element).data('store-id');
                $(element).parents('.box').css('overflow', 'auto');

                var columns = [
                    {
                        'title': 'Store',
                        'width':'5%'
                    },
                    {
                        'title': 'Product name',
                        'width':'20%'
                    },
                    {
                        'title': 'Product property',
                        'width':'20%'
                    },
                    {
                        'title': 'Image',
                        'sortable':false,
                        'render': function ( data, type, full, meta ) {
                            return '<img style="width: 50px" class="img-responsive" src="//image.kacana.vn'+data+'" />';
                        }
                    },
                    {
                        'title': 'Sell price',
                        'render': function ( data, type, full, meta ) {
                            return '<b>' + Kacana.utils.formatCurrency(data) + '</b>';
                        }
                    },
                    {
                        'title': 'Quantity'
                    },
                    {
                        'title': 'Campaign',
                        'render': function ( data, type, full, meta ) {
                            if(data)
                                return Kacana.utils.generateProductCampaignProductTable(data, full[0], true);
                            else
                                return 'N/A'
                        }
                    },
                    {
                        'title': 'Updated',
                        'width':'12%',
                        'render': function ( data, type, full, meta ) {
                            return data ? data.slice(0, -8) +'<br><b>' + data.slice(11, 19)+'</b>' : '';
                        }
                    },
                    {
                        'width':'4%',
                        'class':'center',
                        'sortable':false,
                        'render': function ( data, type, full, meta ) {
                            return '<a href="/store/historyDetail/?storeId='+storeId+'&productPropertyId='+full[8]+'" class="btn btn-default btn-xs"><i class="fa fa-info"></i></a>';
                        }
                    }
                ];

                var addParamsCallBack = function(oData){
                    //search name or email
                    //oData.columns[2].search.orWhere = true;
                    //oData.columns[3].search.orWhere = true;
                };

                var cacheLoadedCallBack = function(oData){
                    $formInline.find('input[name="product-name"]').val(oData.columns[1].search.search);
                    $formInline.find('select[name="product-property-name"]').val(oData.columns[2].search.search);
                };

                var datatable = Kacana.datatable.store.storeProduct(storeId, element, columns, addParamsCallBack, cacheLoadedCallBack);

                $formInline.off('submit')
                    .on('submit', function (e) {
                        e.preventDefault();

                        var api = datatable.api(true);

                        var productName = $formInline.find('input[name="product-name"]').val();
                        var productPropertyName = $formInline.find('input[name="product-property-name"]').val();

                        console.log(productName);
                        //
                        api.column(1).search(productName)
                            .column(2).search(productPropertyName);

                        api.draw();
                });
            },
            searchProductForQuickImport: function () {
                var modal = $('#modal-quick-import-product');
                modal.find('#productName').autocomplete({
                    source: function( request, response ) {

                        var callback = function(data){
                            console.log(data);
                            if(data.ok)
                                response( data.data );
                            else
                                swal({
                                    title: 'Error!',
                                    text: 'Opp!something wrong on processing.',
                                    type: 'error',
                                    confirmButtonText: 'Cool'
                                });
                        };

                        var errorCallback = function(){
                            // do something here if error
                        };

                        var data = {search: request.term};
                        Kacana.ajax.order.searchProduct(data, callback, errorCallback);
                    },
                    minLength: 2,
                    select: function( event, ui ) {
                        Kacana.order.chooseAddressDelivery(ui.item);
                        return false;
                    }
                }).autocomplete( "widget" ).addClass("search-product-add-to-order");

                modal.find('#order_search_product_to_add').autocomplete( "instance" )._renderItem = function( ul, item ) {
                    return $( "<li>" )
                        .append( '<div><a href="/order/addProductToOrder/?orderId='+$("#order_id").val()+'&productId='+item.id+'" ><img style="height: 50px;" src="'+item.image+'">' + item.name + '</a></div>' )
                        .appendTo( ul );
                };
            }
        }
    }
};

$.extend(true, Kacana, storePackage);