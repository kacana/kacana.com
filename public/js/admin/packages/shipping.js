var shippingPackage = {
    shipping:{
        pageDetail: $("#content-detail-shipping"),
        init: function(){
            Kacana.shipping.pageDetail = $("#content-detail-shipping");
            Kacana.shipping.setupDatatableForShipping();
            Kacana.shipping.pageDetail.on('click', 'button[data-target="#modal-print-order"]', function () {
                var shippingId = $('#shipping_id').val();
                console.log(shippingId);
                window.open('/shipping/printOrder/?id='+shippingId, 'Receipt Information', 'height=900,width=940');
                return true;
            });
        },
        setupDatatableForShipping: function () {
            var $formInline = $('.form-inline');
            var element = '#shippingTable';
            $(element).parents('.box').css('overflow', 'auto');
            var columns = [
                {
                    'title': 'mã đặt hàng'
                },
                {
                    'title': 'Người nhận'
                },
                {
                    'title': 'Tổng'
                },
                {
                    'title': 'Phí'
                },
                {
                    'title': 'dự kiến'
                },
                {
                    'title': 'status',
                    'width':'5%',
                },
                {
                    'title': 'created',
                    'width':'12%',
                    'render': function ( data, type, full, meta ) {
                        return data ? data.slice(0, -8) +'<br><b>' + data.slice(11, 19)+'</b>' : '';
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
                        return '<a href="/shipping/detail/?id='+full[0]+'" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></a>';
                    }
                }
            ];

            var addParamsCallBack = function(oData){
                //search name or email
                //oData.columns[2].search.orWhere = true;
                //oData.columns[3].search.orWhere = true;
            };

            var cacheLoadedCallBack = function(oData){
                $formInline.find('input[name="orderCode"]').val(oData.columns[0].search.search);
                $formInline.find('input[name="receiveUser"]').val(oData.columns[1].search.search);
                $formInline.find('select[name="searchStatus"]').val(oData.columns[5].search.search);
            };

            var datatable = Kacana.datatable.shipping(element, columns, addParamsCallBack, cacheLoadedCallBack);

            $formInline.off('submit')
                .on('submit', function (e) {
                    e.preventDefault();

                    var api = datatable.api(true);

                    var orderCode = $formInline.find('input[name="orderCode"]').val();
                    var receiveUser = $formInline.find('input[name="receiveUser"]').val();
                    var status = $formInline.find('select[name="searchStatus"]').val();

                    api.column(0).search(orderCode)
                        .column(1).search(receiveUser)
                        .column(5).search(status, true);

                    api.draw();
                });
        },
        detail: {

        },
    }
};

$.extend(true, Kacana, shippingPackage);