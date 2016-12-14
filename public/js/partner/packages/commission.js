var commissionPackage = {
    commission:{
        page: false,
        init: function () {
            Kacana.commission.generateAllCommissionTable();
            Kacana.commission.generateTempCommissionTable();
            Kacana.commission.generateValidCommissionTable();
            Kacana.commission.generatePaymentCommissionTable();
            Kacana.commission.generatePaymentHistoryTable();

            Kacana.commission.page = $('#content-commission');

            Kacana.commission.page.on('click', 'a[href="#allCommission"]', function () {
                $("#productSendTable").parents('.commission-box').removeClass('hidden').siblings('.commission-box').addClass('hidden');
                var table = $("#productSendTable").DataTable();
                table.draw('full-reset');
            });

            Kacana.commission.page.on('click', 'a[href="#tempCommission"]', function () {
                $("#productTempTable").parents('.commission-box').removeClass('hidden').siblings('.commission-box').addClass('hidden');
                var table = $("#productTempTable").DataTable();
                table.draw('full-reset');
            });

            Kacana.commission.page.on('click', 'a[href="#validCommission"]', function () {
                $("#productValidTable").parents('.commission-box').removeClass('hidden').siblings('.commission-box').addClass('hidden');
                var table = $("#productValidTable").DataTable();
                table.draw('full-reset');
            });

            Kacana.commission.page.on('click', 'a[href="#paymentCommission"]', function () {
                $("#productPaymentTable").parents('.commission-box').removeClass('hidden').siblings('.commission-box').addClass('hidden');
                var table = $("#productPaymentTable").DataTable();
                table.draw('full-reset');
            });
        },
        generateAllCommissionTable: function () {

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

            var datatable = Kacana.datatable.generateAllCommissionTable(element, columns, addParamsCallBack, cacheLoadedCallBack);

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
        },
        generateTempCommissionTable: function () {
            var $formInline = $('.form-inline-temp');
            var element = '#productTempTable';

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

            var datatable = Kacana.datatable.generateTempCommissionTable(element, columns, addParamsCallBack, cacheLoadedCallBack);

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
        },
        generateValidCommissionTable: function () {
            var $formInline = $('.form-inline-valid');
            var element = '#productValidTable';

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

            var datatable = Kacana.datatable.generateValidCommissionTable(element, columns, addParamsCallBack, cacheLoadedCallBack);

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
        },
        generatePaymentCommissionTable: function () {
            var $formInline = $('.form-inline-payment');
            var element = '#productPaymentTable';

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

            var datatable = Kacana.datatable.generatePaymentCommissionTable(element, columns, addParamsCallBack, cacheLoadedCallBack);

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
        },
        generatePaymentHistoryTable: function () {
            var element = '#paymentHistory';

            $(element).parents('.box').css('overflow', 'auto');
            var columns = [
                {
                    'title': 'mã',
                    'render': function ( data, type, full, meta ) {
                        return '<a class="text-red" href="#" >'+data+'</a>';
                    },
                    'sortable':false
                },
                {
                    'title': 'tổng',
                    'render': function ( data, type, full, meta ) {
                        return Kacana.utils.formatCurrency(data);
                    }
                },
                {
                    'title': 'đơn',
                    'sortable':false
                },
                {
                    'title': 'ngày',
                    'render': function ( data, type, full, meta ) {
                        return data ? data.slice(0, -8) +'<br><b>' + data.slice(11, 19)+'</b>' : '';
                    }
                },
                {
                    'width':'10px',
                    'class':'center',
                    'sortable':false,
                    'render': function ( data, type, full, meta ) {
                        return '<a target="_blank" href="/commission/detailTransfer/'+data+'" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></a>';
                    }
                }
            ];

            var addParamsCallBack = function(oData){

            };

            var cacheLoadedCallBack = function(oData){

            };

            var datatable = Kacana.datatable.generatePaymentHistoryTable(element, columns, addParamsCallBack, cacheLoadedCallBack);
        }
    }
};

$.extend(true, Kacana, commissionPackage);