var customerPackage = {
    customer:{
        page: false,
        init: function () {
            Kacana.customer.generateCustomerTable();

        },
        generateCustomerTable: function () {

            var $formInline = $('.form-inline');
            var element = '#customerTable';

            $(element).parents('.box').css('overflow', 'auto');
            var columns = [
                {
                    'title': 'tên',
                    'sortable':false,
                },
                {
                    'title': 'số đt',
                    'sortable':false,
                },
                {
                    'title': 'email',
                    'sortable':false,
                },
                {
                    'title': 'thành phố'
                },
                {
                    'title': 'ngày tạo',
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
                        return '<a href="/customer/edit/'+full[5]+'" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>';
                    }
                }
            ];

            var addParamsCallBack = function(oData){
                //search name or email
                //oData.columns[2].search.orWhere = true;
                //oData.columns[3].search.orWhere = true;
            };

            var cacheLoadedCallBack = function(oData){
                $formInline.find('input[name="name"]').val(oData.columns[0].search.search);
                $formInline.find('input[name="phone"]').val(oData.columns[1].search.search);
            };

            var datatable = Kacana.datatable.generateCustomerTable(element, columns, addParamsCallBack, cacheLoadedCallBack);

            $formInline.off('submit')
                .on('submit', function (e) {
                    e.preventDefault();

                    var api = datatable.api(true);

                    var order_code = $formInline.find('input[name="name"]').val();
                    var order_detail_name = $formInline.find('input[name="phone"]').val();

                    api.column(0).search(order_code)
                        .column(1).search(order_detail_name);

                    api.draw();
            });
        },
        detail: {
            page: false,
            init: function () {
                Kacana.customer.detail.page = $('#content-edit-customer');
                console.log('asdassa');
                Kacana.customer.detail.page.on('change','#city_id',function(){
                    var form = ("#content-edit-order");
                    var districtSelect = Kacana.customer.detail.page.find('select[name="district_id"]');
                    var wardSelect = Kacana.customer.detail.page.find('select[name="ward_id"]');

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

                Kacana.customer.detail.page.on('change','#district',function(){
                    var form = Kacana.customer.detail.page;
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
                                Kacana.utils.loading.closeLoading();
                                wardSelect.removeAttr('disabled').show();
                            }
                            else
                                Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                        };
                        var errorCallBack = function(data){
                            Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                            Kacana.utils.loading.closeLoading();
                        };

                        Kacana.utils.loading.loading(Kacana.customer.detail.page);
                        Kacana.ajax.order.getWardByDistrictId(districtId, callBack, errorCallBack);
                    }
                    else{
                        wardSelect.val('').attr('disabled', true);
                    }
                });

                Kacana.customer.detail.generateAllCommissionByUserTable();
            },
            generateAllCommissionByUserTable: function () {
                var $formInline = $('.form-inline-all');
                var element = '#productSendTable';

                $(element).parents('.box').css('overflow', 'auto');
                var columns = [
                    {
                        'title': 'mã đh',
                        'render': function ( data, type, full, meta ) {
                            return '<a href="/order/edit/'+data+'" target="_blank" >'+data+'</a>';
                        }
                    },
                    {
                        'title': 'sản phẩm',
                        'sortable':false,
                        'width':'30%',
                    },
                    {
                        'title': 'hình',
                        'sortable':false,
                        'render': function ( data, type, full, meta ) {
                            return '<img style="width: 50px" class="img-responsive" src="'+data+'" />';
                        }
                    },
                    {
                        'title': 'tình trạng'
                    },
                    {
                        'title': 'chiết khấu'
                    },
                    {
                        'title': 'cập  nhật',
                        'width':'12%',
                        'render': function ( data, type, full, meta ) {
                            return data ? data.slice(0, -8) +'<br><b>' + data.slice(11, 19)+'</b>' : '';
                        }
                    }
                ];

                var addParamsCallBack = function(oData){
                    //search name or email
                    //oData.columns[2].search.orWhere = true;
                    //oData.columns[3].search.orWhere = true;
                };

                var cacheLoadedCallBack = function(oData){
                    $formInline.find('input[name="order_code"]').val(oData.columns[0].search.search);
                    $formInline.find('input[name="order_detail_name"]').val(oData.columns[1].search.search);
                };
                var addressReceiveId = $('#address-receive-id').val();
                var datatable = Kacana.datatable.generateAllCommissionByUserTable(element, columns, addressReceiveId, addParamsCallBack, cacheLoadedCallBack);

                $formInline.off('submit')
                    .on('submit', function (e) {
                        e.preventDefault();

                        var api = datatable.api(true);

                        var order_code = $formInline.find('input[name="order_code"]').val();
                        var order_detail_name = $formInline.find('input[name="order_detail_name"]').val();

                        api.column(0).search(order_code)
                            .column(1).search(order_detail_name);

                        api.draw();
                });
            }
        }
    }
};

$.extend(true, Kacana, customerPackage);