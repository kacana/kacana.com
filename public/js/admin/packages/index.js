var indexPackage = {
    index:{
        page: false,
        init: function(){
            Kacana.index.page = $('#content-dashboard-page');
            Kacana.index.bindEvent();
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
            var xkey = $(this).data('xkey');
            var ykey = $(this).data('ykey');
            var color = $(this).data('color');
            $('#revenue-chart').data('url', url).data('xkey', xkey).data('ykey', ykey).data('color', color);

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
                    console.log(data.data);
                    Morris.Line({
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
        user:{
            reportChart: function () {

            },
            listUser: function () {
                
            }
        }
    }
};

$.extend(true, Kacana, indexPackage);