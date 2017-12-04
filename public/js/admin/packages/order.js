var orderPackage = {
    order:{
        page: $("#content-list-order"),
        pageDetail: $("#content-edit-order"),
        init: function(){
            Kacana.order.pageDetail = $("#content-edit-order");
            Kacana.order.page = $("#content-list-order");
            Kacana.order.setupDatatableForOrder();
            Kacana.order.createBaseOrder();
            $('#modal-create-order').on('change', 'select[name="cityId"]', Kacana.order.changeCity);
            $('#modal-create-order').on('change', 'select[name="districtId"]', Kacana.order.changeDistrict);

            $('#modal-create-order').on('click', '#create-new-address-delivery', function () {
                var modal = $('#modal-create-order');
                modal.find('#deliveryName').removeAttr('disabled');
                modal.find('#deliveryPhone').removeAttr('disabled');
                modal.find('select[name="cityId"]').removeAttr('disabled');
                modal.find('select[name="districtId"]').removeAttr('disabled');
                modal.find('select[name="wardId"]').removeAttr('disabled');
                modal.find('#deliveryId').val(0);
                modal.find('#deliveryStreet').removeAttr('disabled');
                modal.find('#deliveryEmail').removeAttr('disabled');
                modal.find('#create-new-address-delivery').hide();
            });
            Kacana.order.page.on('click', 'button[data-target="#modal-create-order"]', function () {
                var modal = $('#modal-create-order');
                modal.find('#deliveryName').val('').removeAttr('disabled');
                modal.find('#deliveryPhone').val('').removeAttr('disabled');
                modal.find('select[name="cityId"]').val('').trigger('change').removeAttr('disabled');
                modal.find('#deliveryStreet').val('').removeAttr('disabled');
                modal.find('#deliveryId').val(0);
                modal.find('#deliveryEmail').val('').removeAttr('disabled');
                modal.find('#create-new-address-delivery').hide();
            });
        },
        createBaseOrder: function () {
            $('#modal-create-order').find('#deliveryName').autocomplete({
                source: function( request, response ) {

                    var callback = function(data){
                        console.log(data);
                        if(data.ok)
                            response( data.items );
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

                    var data = {search: request.term, type: 'name'};
                    Kacana.ajax.order.searchAddressDelivery(data, callback, errorCallback);
                },
                minLength: 2,
                select: function( event, ui ) {
                    Kacana.order.chooseAddressDelivery(ui.item);
                    return false;
                }
            }).autocomplete( "widget" ).addClass("search-address-delivery");

            $('#modal-create-order').find('#deliveryName').autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
                .append( "<div>" + item.name + " - " + item.phone + " - " + item.city.name + "</div>" )
                .appendTo( ul );
            };

            $('#modal-create-order').find('#deliveryPhone').autocomplete({
                source: function( request, response ) {

                    var callback = function(data){
                        console.log(data);
                        if(data.ok)
                            response( data.items );
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

                    var data = {search: request.term, type: 'phone'};
                    Kacana.ajax.order.searchAddressDelivery(data, callback, errorCallback);
                },
                minLength: 2,
                select: function( event, ui ) {
                    Kacana.order.chooseAddressDelivery(ui.item);
                    return false;
                }
            }).autocomplete( "widget" ).addClass("search-address-delivery");

            $('#modal-create-order').find('#deliveryPhone').autocomplete( "instance" )._renderItem = function( ul, item ) {
                return $( "<li>" )
                    .append( "<div>" + item.name + " - " + item.phone + " - " + item.city.name + "</div>" )
                    .appendTo( ul );
            };
        },
        changeCity: function () {
            var form = $('#modal-create-order');
            var districtSelect = $('select[name="districtId"]');
            var wardSelect = $('select[name="wardId"]');

            var cityId = $(this).val();

            // form.formValidation('enableFieldValidators', 'wardId', false).formValidation('resetField', 'wardId');
            wardSelect.val('').attr('disabled', true);

            // form.formValidation('enableFieldValidators', 'districtId', true).formValidation('resetField', 'districtId');
            districtSelect.val('');

            if(parseInt(cityId))
            {
                var listDistrict = districtSelect.data('district');
                var listOptionDistrict = '<option value="" style="display: block;">Chọn quận/huyện</option>';

                for(var i =0 ; i <  listDistrict.length ; i++){
                    if(listDistrict[i].city_id == parseInt(cityId))
                        listOptionDistrict +='<option data-city-id="'+listDistrict[i].city_id+'" value="'+listDistrict[i].id+'">'+listDistrict[i].name+'</option>';
                }

                districtSelect.html(listOptionDistrict);
                districtSelect.removeAttr('disabled')
            }
            else
            {
                // form.formValidation('enableFieldValidators', 'districtId', false).formValidation('resetField', 'districtId');
                districtSelect.val('').attr('disabled', true).find('option[value=""]').show();
            }
        },
        changeDistrict: function () {
            var form = $('#modal-create-order');
            var districtId = $(this).val();
            var wardSelect = $('select[name="wardId"]');
            // form.formValidation('enableFieldValidators', 'wardId', true).formValidation('resetField', 'wardId');
            wardSelect.val('');

            if(parseInt(districtId))
            {
                var callBack = function(data){
                    if(data.ok){
                        var items = data.data;
                        var strOption = '<option value="">Chọn phường/xã</option>';
                        for(var i = 0; i < items.length; i++){
                            strOption += '<option value="'+items[i].id+'">'+items[i].name+'</option>'
                        }
                        form.find('select[name="wardId"]').html(strOption);
                        Kacana.utils.closeLoading();
                        wardSelect.removeAttr('disabled').show();
                    }
                    else
                        Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                };
                var errorCallBack = function(data){
                    Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                    Kacana.utils.closeLoading();
                };

                Kacana.utils.loading($('#modal-create-order'));
                Kacana.ajax.order.getWardByDistrictId(districtId, callBack, errorCallBack);
            }
            else{
                wardSelect.val('').attr('disabled', true);
            }
        },
        chooseAddressDelivery: function ($item) {
            var modal = $('#modal-create-order');
            modal.find('#deliveryName').val($item.name).attr('disabled', true);
            modal.find('#deliveryPhone').val($item.phone).attr('disabled', true);
            modal.find('select[name="cityId"]').val($item.city_id).trigger('change').attr('disabled', true);
            modal.find('select[name="districtId"]').val($item.district_id).attr('disabled', true);
            var ward = '<option value="">Chọn phường/xã</option>';
            if($item.ward_id)
                ward = '<option selected value="'+$item.ward_id+'">'+$item.ward.name+'</option>';

            modal.find('select[name="wardId"]').html(ward);

            modal.find('#deliveryStreet').val($item.street).attr('disabled', true);
            modal.find('#deliveryId').val($item.id);
            modal.find('#deliveryEmail').val($item.email).attr('disabled', true);
            modal.find('#create-new-address-delivery').show();
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
                    'title': 'code'
                },
                {
                    'title': 'by'
                },
                {
                    'title': 'name'
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
                    'title': 'type',
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
                $formInline.find('input[name="code"]').val(oData.columns[1].search.search);
                $formInline.find('input[name="name"]').val(oData.columns[3].search.search);
                $formInline.find('input[name="phone"]').val(oData.columns[4].search.search);
                $formInline.find('select[name="searchStatus"]').val(oData.columns[7].search.search);
            };

            var datatable = Kacana.datatable.order(element, columns, addParamsCallBack, cacheLoadedCallBack);

            $formInline.off('submit')
                .on('submit', function (e) {
                    e.preventDefault();

                    var api = datatable.api(true);

                    var name = $formInline.find('input[name="name"]').val();
                    var code = $formInline.find('input[name="code"]').val();
                    var phone = $formInline.find('input[name="phone"]').val();
                    var status = $formInline.find('select[name="searchStatus"]').val();

                    api.column(1).search(code)
                        .column(3).search(name)
                        .column(4).search(phone)
                        .column(7).search(status, true);

                    api.draw();
                });
        },
        detail: {
            page: false,
            init: function(){
                Kacana.order.detail.page = $('#content-edit-order');
                Kacana.order.detail.bindEvent();
                Kacana.order.detail.barcodeScanner();
            },
            bindEvent: function(){
                Kacana.order.detail.page.on('click', 'a[href="#edit-detail-item"]', function () {
                    var form = $(this).parents('form');
                    form.find('.product-properties, .product-discount, .product-quantity, .order-from-id').prop('disabled', false);
                    form.find('a[href="#submit-edit-detail-item"], a[href="#cancel-edit-detail-item"]').removeClass('hidden');
                    form.find('a[href="#edit-detail-item"]').addClass('hidden');
                    form.find('.product-discount').val(form.find('.product-discount').data('value'));
                });

                Kacana.order.detail.page.on('click','a[href="#cancel-order"]', function () {
                    var orderId = $(this).data('order-id');

                    swal({
                        title: 'Bạn có chắc huỷ đơn hàng?',
                        text: "Đơn hàng này sẽ bị huỷ và không thể khôi phục!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Huỷ đơn hàng!'
                    }).then(function () {
                        window.location.href = "/order/cancelOrder?orderId="+orderId;
                    })
                });

                Kacana.order.detail.page.on('click','a[href="#export-product-store"]', function () {
                    var orderQuantity = $('#order-quantity').val();
                    var orderTotal = $('#order-total').val();
                    swal({
                        title: 'Xuất Hàng',
                        text: "Đơn hàng gồm "+orderQuantity+" sản phẩm và tổng giá trị đơn hàng là: "+orderTotal,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Xuất hàng!'
                    }).then(function () {
                        Kacana.order.detail.exportProductAtStore();
                    });
                });

                Kacana.order.detail.page.on('click','a[href="#show-invoice-at-store"]', Kacana.order.detail.showInvoiceWithOrderStore);

                Kacana.order.detail.page.on('click', 'a[href="#cancel-edit-detail-item"]', function () {
                    var form = $(this).parents('form');
                    form.trigger("reset");
                    form.find('.product-properties, .product-discount, .product-quantity, .order-from-id').prop('disabled', true);
                    form.find('a[href="#submit-edit-detail-item"], a[href="#cancel-edit-detail-item"]').addClass('hidden');
                    form.find('a[href="#edit-detail-item"]').removeClass('hidden');

                });
                Kacana.order.detail.page.on('click', 'a[href="#submit-edit-detail-item"]', function () {
                    var form = $(this).parents('form');
                    form.submit();
                });

                Kacana.order.detail.page.on('click','a[href="#update-order-service-id"]',function(){
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
                    var form = ("#content-edit-order");
                    var districtSelect = $("#content-edit-order").find('select[name="district_id"]');
                    var wardSelect = $("#content-edit-order").find('select[name="ward_id"]');

                    var cityId = $(this).val();

                    wardSelect.val('').attr('disabled', true);

                    districtSelect.val('');

                    if(parseInt(cityId))
                    {
                        var listDistrict = districtSelect.data('district');
                        var listOptionDistrict = '<option value="" style="display: block;">Chọn quận/huyện</option>';

                        for(var i =0 ; i <  listDistrict.length ; i++){
                            if(listDistrict[i].city_id == parseInt(cityId))
                                listOptionDistrict +='<option data-city-id="'+listDistrict[i].city_id+'" value="'+listDistrict[i].id+'">'+listDistrict[i].name+'</option>';
                        }

                        districtSelect.html(listOptionDistrict);
                        districtSelect.removeAttr('disabled')
                    }
                    else
                    {
                        districtSelect.val('').attr('disabled', true).find('option[value=""]').show();
                    }

                });

                $("#content-edit-order").on('change','#district',function(){
                    var form = $("#content-edit-order");
                    var districtId = $(this).val();
                    var wardSelect = $('select[name="ward_id"]');
                    // form.formValidation('enableFieldValidators', 'wardId', true).formValidation('resetField', 'wardId');
                    wardSelect.val('');

                    if(parseInt(districtId))
                    {
                        var callBack = function(data){
                            if(data.ok){
                                var items = data.data;
                                var strOption = '<option value="">Chọn phường/xã</option>';
                                for(var i = 0; i < items.length; i++){
                                    strOption += '<option value="'+items[i].id+'">'+items[i].name+'</option>'
                                }
                                form.find('select[name="ward_id"]').html(strOption);
                                Kacana.utils.closeLoading();
                                wardSelect.removeAttr('disabled').show();
                            }
                            else
                                Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                        };
                        var errorCallBack = function(data){
                            Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                            Kacana.utils.closeLoading();
                        };

                        Kacana.utils.loading($("#content-edit-order"));
                        Kacana.ajax.order.getWardByDistrictId(districtId, callBack, errorCallBack);
                    }
                    else{
                        wardSelect.val('').attr('disabled', true);
                    }
                });

                $('#content-edit-order').on('click', 'button[data-target="#modal-shipping-order"]', Kacana.order.detail.openModalShipping);

                $('#modal-shipping-order').on('click', '#btn-check-fee-ship', Kacana.order.detail.checkFeeShipping);
                $('#modal-shipping-order').on('click', 'input[name="orderDetailId[]"]', Kacana.order.detail.checkTotalCOD);
                $('#modal-shipping-order').on('click', 'input[name="shippingServiceTypeId"]', Kacana.order.detail.checkOriginShipFee);

                Kacana.order.detail.addProductModal();
            },
            exportProductAtStore: function () {
                var orderId = $('#order-id').val();

                var callBack = function(data){
                    Kacana.utils.closeLoading();
                    if(data.ok){
                        $('a[href="#export-product-store"]').attr('disabled', true).html('Đơn hàng đã hoàn thành!');
                        $('a[href="#export-product-store"]').attr('class', 'btn btn-success btn-sm');
                        $('a[href="#export-product-store"]').after(' <a href="#show-invoice-at-store" data-toggle="modal" data-order-id="50" class="btn btn-primary btn-sm"> <i class="fa fa-eye"></i> xem hoá đơn </a>')
                        $('a[href="#cancel-order"]').remove();
                        window.open('/shipping/printOrderStore/?id='+orderId, 'Receipt Information', 'height=900,width=940');

                        return true;
                    }
                    else
                        Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                };

                var errorCallBack = function(data){
                    Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                    Kacana.utils.closeLoading();
                };
                Kacana.utils.loading();
                Kacana.ajax.order.exportProductAtStore(orderId, callBack, errorCallBack);
            },
            showInvoiceWithOrderStore: function () {
                var orderId = $('#order-id').val();
                window.open('/shipping/printOrderStore/?id='+orderId, 'Receipt Information', 'height=900,width=940');
                return true;
            },
            addProductModal: function () {
                var modal = $('#modal-add-product-order');

                modal.find('#order_search_product_to_add').autocomplete({
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
                        var listShippingFeeGenerate = $.tmpl(listShippingFeeTemplate, {'listFee': data.data.serviceGhn});
                        modal.find('#list-shipping-ghn-fee').empty().append(listShippingFeeGenerate);

                        var listShippingFeeTemplate = $('#template-shipping-ghtk-fee');
                        var listShippingFeeGenerate = $.tmpl(listShippingFeeTemplate, {'ghtkFee': data.data.serviceGhtk});
                        modal.find('#list-shipping-ghtk-fee').empty().append(listShippingFeeGenerate);
                        Kacana.order.detail.checkOriginShipFee();
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
            checkTotalCOD: function (changeFeeShip) {
                var modal = $('#modal-shipping-order');
                var total = 0;
                modal.find('input[name="orderDetailId[]"]:checked').each(function () {
                    total += parseInt($(this).data('total'));
                });

                modal.find('#total_cod').val(total);
                if(changeFeeShip)
                {
                    if(total>500)
                    {
                        modal.find('#ship_fee').val(0);
                    }
                }

            },
            checkOriginShipFee: function () {
                var modal = $('#modal-shipping-order');
                var total = 0;
                modal.find('input[name="shippingServiceTypeId"]:checked').each(function () {
                    total = parseInt($(this).data('value'));
                });

                modal.find('#origin-ship-fee').val(total);
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
                        Kacana.order.detail.checkTotalCOD(true);
                        Kacana.order.detail.checkOriginShipFee();
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
                var orderId = $("#order_id").val();

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
                    order_service_status: status,
                    order_id: orderId
                };
                Kacana.ajax.order.updateOrderService(dataPost, callback, errorCallback);
            },
            deleteOrderDetail: function(){
                $(document).on("click", '.delete',function(){
                    var id = $(this).data('id');
                    $('#confirm').modal('show');
                    var callBack = function(data){
                        window.location.reload();
                    };
                    var errorCallBack = function(){};
                    $('#delete').click(function (e) {
                        Kacana.ajax.order.deleteOrderDetail(id, callBack, errorCallBack);
                    });
                })
            },
            barcodeScanner: function () {
                $(document).scannerDetection({
                    timeBeforeScanTest: 200, // wait for the next character for upto 200ms
                    avgTimeByChar: 40, // it's not a barcode if a character takes longer than 100ms
                    preventDefault: false,
                    endChar: [13],
                    onComplete: function(barcode, qty){
                        var propertyId = barcode.substring(0, 11);
                        console.log(propertyId);
                        var orderId = $('#order-id').val();
                        window.location.href = "/order/addProductToOrder/?orderId="+orderId+"&propertyId="+propertyId;
                    }
                });
            },
        },
    }
};

$.extend(true, Kacana, orderPackage);