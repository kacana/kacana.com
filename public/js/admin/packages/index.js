var myChart;
var check = false;
var indexPackage = {
    index:{
        page: false,
        init: function(){
            Kacana.index.page = $('#content-dashboard-page');
            Kacana.index.bindEvent();
            Kacana.index.parseTable();
            $('#report-duration').daterangepicker({
                startDate: moment().subtract(7, 'days'),
                endDate: moment(),
                maxDate: moment(),
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });
        },
        bindEvent: function () {
            Kacana.index.page.on('click', '.item-report', Kacana.index.addParamToChart);
            Kacana.index.page.on('click', '#btn-show-report', Kacana.index.parseChart);
            Kacana.index.page.find('.item-report').eq(0).click();
        },
        addParamToChart: function () {
            var url = $(this).data('url');
            var typeReport = $(this).data('type-report');
            var xkey = $(this).data('xkey');
            var ykey = $(this).data('ykey');
            var color = $(this).data('color');
            $('#revenue-chart').data('url', url).data('xkey', xkey).data('ykey', ykey).data('color', color).data('type-report', typeReport);

            $('#btn-show-report').click();
        },
        parseChart: function () {
            var url = $('#revenue-chart').data('url');
            var xkey = $('#revenue-chart').data('xkey');
            var ykey = $('#revenue-chart').data('ykey');
            var color = $('#revenue-chart').data('color');
            var type = $('#report-type').val();
            var dateRange = $('#report-duration').val();
            $('#revenue-chart').html('');
            Kacana.utils.loading($('#revenue-chart'));
            var callBack = function(data){
                if(data.ok){
                    // console.log(data.data);
                    myChart = Morris.Line({
                        element: 'revenue-chart',
                        data: data.data,
                        xkey: 'date',
                        xLabels: type,
                        ykeys: ['item'],
                        labels: ['Số lượng'],
                        resize: true,
                        hideHover: false,
                        lineColors: ['#'+color]
                    });
                }
                Kacana.utils.closeLoading();
            };
            var errorCallBack = function(){};



            var dataPost = {
                type: type,
                dateRange: dateRange
            };
            Kacana.ajax.admin.getReportChart(url, dataPost, callBack, errorCallBack);
        },
        parseTable: function () {
            $("#revenue-chart").on('click', function(i, row){

                var typeReport = $('#revenue-chart').data('type-report');
                var dateSelected = $('.morris-hover.morris-default-style .morris-hover-row-label').text();

                var type = $('#report-type').val();
                var $formInline = $('.form-inline');
                var element = '#detailTable';
                $(element).parents('.box').css('overflow', 'auto');
                if (check==true) {
                    detailTable = $('#detailTable').DataTable({
                        paging: false,
                        retrieve: true
                    });
                    detailTable.destroy();
                    $('#detailTable').html('');
                }
                else check=true;


                if (typeReport == 'User') {
                    $('.table-title-report').html('Detail Table User');
                    var columns = [
                        {
                            'title': 'User ID',
                            'width':'5%'
                        },
                        {
                            'title': 'name'
                        },
                        {
                            'title': 'email'
                        },
                        {
                            'title': 'phone'
                        },
                        {
                            'title': 'role',
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
                        }
                        // {
                        //     'width':'4%',
                        //     'class':'center',
                        //     'sortable':false,
                        //     'render': function ( data, type, full, meta ) {
                        //         return '<a href="/product/editProduct/'+full[0]+'" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>';
                        //     }
                        // }
                    ];

                    var cacheLoadedCallBack = function(oData){
                        // $formInline.find('input[name="name"]').val(oData.columns[1].search.search);
                        // $formInline.find('input[name="email"]').val(oData.columns[2].search.search);
                        // $formInline.find('input[name="phone"]').val(oData.columns[3].search.search);
                        // $formInline.find('select[name="searchRole"]').val(oData.columns[4].search.search);
                        // $formInline.find('select[name="searchStatus"]').val(oData.columns[5].search.search);
                    };
                }
                else if (typeReport == 'Order') {
                    $('.table-title-report').html('Detail Table Order');
                    var columns = [
                        {
                            'title': 'Order ID',
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
                        }
                        // {
                        //     'width':'4%',
                        //     'class':'center',
                        //     'sortable':false,
                        //     'render': function ( data, type, full, meta ) {
                        //         return '<a href="/order/edit/'+full[0]+'" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>';
                        //     }
                        // }
                    ];

                    var cacheLoadedCallBack = function(oData){
                        // $formInline.find('input[name="name"]').val(oData.columns[1].search.search);
                        // $formInline.find('input[name="phone"]').val(oData.columns[2].search.search);
                        // $formInline.find('select[name="searchStatus"]').val(oData.columns[5].search.search);
                    };
                }
                else if (typeReport == 'ProductLike') {
                    $('.table-title-report').html('Detail Table Product Like');
                    var columns = [
                        {
                            'title': 'User ID',
                            'width':'5%'
                        },
                        {
                            'title': 'User Name'
                        },
                        {
                            'title': 'Product ID',
                            'width':'5%'
                        },
                        {
                            'title': 'Product URL',
                            "render": function ( data, type, full, meta ) {
                                return '<a href="' + data + '">'+data+'</a>';
                            }
                        },
                        // {
                        //     'title': 'Product Image'
                        // },
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
                        }
                        // {
                        //     'width':'4%',
                        //     'class':'center',
                        //     'sortable':false,
                        //     'render': function ( data, type, full, meta ) {
                        //         return '<a href="/product/editProduct/'+full[0]+'" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>';
                        //     }
                        // }
                    ];

                    var cacheLoadedCallBack = function(oData){

                    };
                }
                else if (typeReport == 'ProductView') {
                    $('.table-title-report').html('Detail Table Product View');
                    var columns = [
                        {
                            'title': 'User ID',
                            'width':'5%'
                        },
                        {
                            'title': 'User name'
                        },
                        {
                            'title': 'Product ID'
                        },
                        {
                            'title': "User's IP"
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
                        }
                        // {
                        //     'width':'4%',
                        //     'class':'center',
                        //     'sortable':false,
                        //     'render': function ( data, type, full, meta ) {
                        //         return '<a href="/product/editProduct/'+full[0]+'" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>';
                        //     }
                        // }
                    ];

                    var cacheLoadedCallBack = function(oData){
                        // $formInline.find('input[name="name"]').val(oData.columns[1].search.search);
                        // $formInline.find('input[name="email"]').val(oData.columns[2].search.search);
                        // $formInline.find('input[name="phone"]').val(oData.columns[3].search.search);
                        // $formInline.find('select[name="searchRole"]').val(oData.columns[4].search.search);
                        // $formInline.find('select[name="searchStatus"]').val(oData.columns[5].search.search);
                    };
                }
                else if (typeReport == 'TrackingSearch') {
                    $('.table-title-report').html('Detail Table Tracking Search');

                    var columns = [
                        {
                            'title': 'ID',
                            'width':'5%'
                        },
                        {
                            'title': 'Keyword'
                        },
                        {
                            'title': 'User ID'
                        },
                        {
                            'title': 'User Name'
                        },
                        {
                            'title': "User's IP"
                        },
                        {
                            'title': 'Type'
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
                        }
                        // {
                        //     'width':'4%',
                        //     'class':'center',
                        //     'sortable':false,
                        //     'render': function ( data, type, full, meta ) {
                        //         return '<a href="/product/editProduct/'+full[0]+'" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>';
                        //     }
                        // }
                    ];

                    var cacheLoadedCallBack = function(oData){
                        // $formInline.find('input[name="name"]').val(oData.columns[1].search.search);
                        // $formInline.find('input[name="email"]').val(oData.columns[2].search.search);
                        // $formInline.find('input[name="phone"]').val(oData.columns[3].search.search);
                        // $formInline.find('select[name="searchRole"]').val(oData.columns[4].search.search);
                        // $formInline.find('select[name="searchStatus"]').val(oData.columns[5].search.search);
                    };
                }

                var addParamsCallBack = function(oData){
                    oData.dateSelected = dateSelected;
                    oData.type = type;
                };

                var datatable = Kacana.datatable.detailTable(element, columns, typeReport, addParamsCallBack, cacheLoadedCallBack);

                $formInline.off('submit').on('submit', function (e) {
                    e.preventDefault();

                    var api = datatable.api(true);

                    var name = $formInline.find('input[name="name"]').val();
                    var email = $formInline.find('input[name="email"]').val();
                    var phone = $formInline.find('input[name="phone"]').val();
                    var role = $formInline.find('select[name="searchRole"]').val();
                    var status = $formInline.find('select[name="searchStatus"]').val();

                    api.column(1).search(name)
                        .column(2).search(email)
                        .column(3).search(phone)
                        .column(4).search(role)
                        .column(5).search(status, true);

                    api.draw();
                });
            });
        },
        user:{
            reportChart: function () {

            },
            listUser: function () {

            }
        }
    }
};

$.extend(true, Kacana, indexPackage);