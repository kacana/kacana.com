var orderPackage = {
    order:{
        pageDetail: $("#content-edit-order"),
        init: function(){
            Kacana.order.setupDatatableForOrder();
        },
        setupDatatableForOrder: function () {
            var $formInline = $('.form-inline');
            var element = '#orderTable';
            $(element).parents('.box').css('overflow', 'auto');
            var columns = [
                {
                    'title': 'ID',
                    'width':'5%'
                },
                {
                    'title': 'guess'
                },
                {
                    'title': 'phone'
                },
                {
                    'title': 'total'
                },
                {
                    'title': 'quantity'
                },
                {
                    'title': 'status',
                },
                {
                    'title': 'created',
                    'width':'12%',
                    'render': function ( data, type, full, meta ) {
                        return data ? data.slice(0, -8) : '';
                    }
                },
                {
                    'title': 'Updated',
                    'width':'12%',
                    'render': function ( data, type, full, meta ) {
                        return data ? data.slice(0, -8) : '';
                    }
                },
                {
                    'width':'4%',
                    'class':'center',
                    'sortable':false,
                    'render': function ( data, type, full, meta ) {
                        return '<a href="/order/edit/'+full[0]+'" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>';
                    }
                }
            ];

            var addParamsCallBack = function(oData){
                //search name or email
                //oData.columns[2].search.orWhere = true;
                //oData.columns[3].search.orWhere = true;
            };

            var cacheLoadedCallBack = function(oData){
                $formInline.find('input[name="name"]').val(oData.columns[1].search.search);
                $formInline.find('input[name="phone"]').val(oData.columns[2].search.search);
                $formInline.find('select[name="searchStatus"]').val(oData.columns[5].search.search);
            };

            var datatable = Kacana.datatable.order(element, columns, addParamsCallBack, cacheLoadedCallBack);

            $formInline.off('submit')
                .on('submit', function (e) {
                    e.preventDefault();

                    var api = datatable.api(true);

                    var name = $formInline.find('input[name="name"]').val();
                    var phone = $formInline.find('input[name="phone"]').val();
                    var status = $formInline.find('select[name="searchStatus"]').val();

                    api.column(1).search(name)
                        .column(2).search(phone)
                        .column(5).search(status, true);

                    api.draw();
                });
        },
        detail: {
            init: function(){
                Kacana.order.detail.bindEvent();
            },
            bindEvent: function(){
                $("#content-edit-order").on('click','a[href="#update-order-service-id"]',function(){
                    var that = $(this);
                    var wrap = $(this).parents('.order-detail-service');
                    swal({
                        title: 'đặt hàng',
                        html: '<div>sản phẩm: <i>'+wrap.data('name')+'</i></div><div> <img style="width: 30%" src="'+wrap.data('image')+'"/> </div><div> mã đặt hàng: <b>'+ wrap.find('input[name="order-service-id"]').val()+'</b></div>',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'confirm'
                    }).then(function() {
                        Kacana.order.detail.updateOrderService(that);
                    });
                });

                $("#content-edit-order").on('click','a[href="#update-order-sold-out"]',function(){
                    var that = $(this);
                    var wrap = $(this).parents('.order-detail-service');
                    swal({
                        title: 'hết hàng',
                        html: '<div>sản phẩm: <i>'+wrap.data('name')+'</i></div><div> <img style="width: 30%" src="'+wrap.data('image')+'"/> </div><div> <b>đã hết hàng</b></div>',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'confirm'
                    }).then(function() {
                        Kacana.order.detail.updateOrderService(that);
                    });
                });

                $("#content-edit-order").on('change','#city_id',function(){
                    var cityId = $(this).val();
                    $("#content-edit-order").find('#district option[data-city-id="'+cityId+'"]').eq(0).attr('selected', 'selected');
                    $("#content-edit-order").find('#district option').each(function(){
                        if($(this).data('city-id') == cityId)
                            $(this).removeClass('hidden');
                        else
                            $(this).addClass('hidden');
                    });
                });

                $('#content-edit-order').on('click', 'button[data-target="#modal-shipping-order"]', Kacana.order.detail.openModalShipping);

                $('#modal-shipping-order').on('click', '#btn-check-fee-ship', Kacana.order.detail.checkFeeShipping);
            },
            checkFeeShipping: function () {
                var weight = $('#form-shipping-order').find('#Weight').val();
                var length = $('#form-shipping-order').find('#Length').val();
                var width = $('#form-shipping-order').find('#Width').val();
                var height = $('#form-shipping-order').find('#Height').val();
                var orderId = $('#order_id').val();
                var pickDistrictCode = $('#pickHubId').find('option:selected').data('district-code');
                var modal = $('#modal-shipping-order');

                var callback = function(data){
                    if(data.ok){
                        var listShippingFeeTemplate = $('#template-shipping-fee');
                        var listShippingFeeGenerate = $.tmpl(listShippingFeeTemplate, {'listFee': data.data});
                        modal.find('#list-shipping-fee').empty().append(listShippingFeeGenerate);
                    }
                    Kacana.utils.closeLoading();

                };

                var errorCallback = function(){
                    // do something here if error
                };

                var dataPost = {
                    weight: weight,
                    length : length,
                    width : width,
                    height : height,
                    pickDistrictCode: pickDistrictCode,
                    orderId: orderId
                };
                Kacana.utils.loading($('#list-shipping-fee'));
                Kacana.ajax.order.checkFeeShipping(dataPost, callback, errorCallback);
                return false;
            },
            openModalShipping: function(){
                var modal = $('#modal-shipping-order');

                var orderId = $('#order-id').val();
                var addressId = $('#order_address_id').val();

                var callback = function(data){
                    if(data.ok){
                        var shippingOrderTemplate = $('#template-shipping-order');
                        if(!data.data.length)
                            data.data = '';
                        var shippingOrderGenerate = $.tmpl(shippingOrderTemplate, {'orderDetails': data.data, 'addressReceive': data.addressReceive});
                        modal.find('.modal-dialog').empty().append(shippingOrderGenerate);
                    }
                };

                var errorCallback = function(){
                    // do something here if error
                };
                var dataPost = {
                    orderId: orderId,
                    addressId : addressId
                };

                Kacana.ajax.order.getOrderDetailisOrdered(dataPost, callback, errorCallback);

            },
            updateOrderService: function(obj){
                var wrap = obj.parents('.order-detail-service');

                var detailOrderId = wrap.data('order-detail-id');
                var orderServiceId = wrap.find('input[name="order-service-id"]').val();
                var status = obj.data('status');

                var callback = function(data){
                    if(data.ok){
                        var orderDetail = data.data;
                        wrap.find('a[href="#update-order-service-id"], a[href="#update-order-sold-out"]').addClass('hidden');
                        if(orderDetail.order_service_status == 1)
                            wrap.find('input[name="order-service-id"]').attr('disabled', true);
                        else if(orderDetail.order_service_status == 2)
                        {
                            wrap.find('input[name="order-service-id"]').addClass('hidden');
                            wrap.find('.label-sold-out').removeClass('hidden');
                        }
                    }
                };

                var errorCallback = function(){
                    // do something here if error
                };
                var dataPost = {
                    id: detailOrderId,
                    order_service_id : orderServiceId,
                    order_service_status: status
                };
                Kacana.ajax.order.updateOrderService(dataPost, callback, errorCallback);
            },
            deleteOrderDetail: function(){
                $(document).on("click", '.delete',function(){
                    id = $(this).data('id');
                    $('#confirm').modal('show');
                    var callBack = function(data){
                        window.location.reload();
                    };
                    var errorCallBack = function(){};
                    $('#delete').click(function (e) {
                        Kacana.ajax.order.deleteOrderDetail(id, callBack, errorCallBack);
                    });
                })
            }
        },
    }
};

$.extend(true, Kacana, orderPackage);