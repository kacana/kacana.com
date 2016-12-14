/**
 * Created with JetBrains PhpStorm.
 * User: visualeyez
 * Date: 7/8/13 AD
 * Time: 9:40 AM
 * To change this template use File | Settings | File Templates.
 */
var datatablePackage = {

    datatable: {
        init:function(element, url, columns, defaultSearchColumns, addParamsCallBack, cacheParamsCallBack, rowCallBack, drawCallBack, cacheLoadedCallBack, options){
         console.log(options.order);
            var dataTable = $(element).dataTable( {
                'dom': (options.dom) ? options.dom : '<"top">rt<"bottom"<"col-xs-6"i><"col-xs-6"p>><"clear">',
                'serverSide': true,
                'ajax': url,
                'stateSave': (options.noCache)?false:true,
                'order': (options.order)?[options.order]:[],
                'lengthChange': false,
                'displayLength': (options.displayLength)?options.displayLength:10,
                'autoWidth': false,
                'language': {
                    'info': '_START_ - _END_ of _TOTAL_',
                    'infoFiltered': (options.hideInfoFiltered) ? '' : '(filtered from _MAX_)',
                    'infoEmpty': '0 of 0'
                },
                'columns': columns,
                'searchCols': defaultSearchColumns,
                'serverParams': function(oData){
                    addParamsCallBack(oData);
                },
                "rowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    rowCallBack(nRow, aData);
                },
                'preDrawCallback': function(oSettings){
                    Kacana.utils.loading.loading($(element));
                },
                'drawCallback':function(oSettings){
                    drawCallBack(oSettings);
                    Kacana.utils.loading.closeLoading();
                    var currentPage = oSettings._iDisplayStart / oSettings._iDisplayLength + 1;

                    $(element + '_paginate').append('<div class="paging_jump_number"><label><input type="text" value="' + currentPage + '"/></label></div>');

                    //go to page
                    $(element + '_wrapper .paging_jump_number input').on('keyup',function(){
                        var number = $(this).val();

                        if(number > 0){
                            var page = number - 1;

                            dataTable.fnPageChange(page);
                        }
                    });

                    //Binumi.utils.loadingAnimation('close', 'JS/ANIMATION/LOADING');
                },
                'stateSaveParams': function (oSettings, oData) {
                    cacheParamsCallBack(oData);
                },
                'stateLoaded': function (oSettings, oData) {
                    cacheLoadedCallBack(oData);
                },
                'initComplete': function (oSettings, oData) {

                    $(element).show();
                },
                'retrieve': true,
                'destroy': true
            });

            return dataTable;
        },
        productBoot: function(element, columns, addParamsCallBack, cacheLoadedCallBack){
            var url = '/product/generateProductBootTable';
            var options = {
                'order': [1, "desc"],
                displayLength: 10
            };
            var defaultSearchColumns = [];

            var cacheParamsCallBack = function(oData){
                //do something
            };

            var drawCallBack = function(e){
            };

            var rowCallBack = function(){
                //do something
            };

            return Kacana.datatable.init(element, url, columns, defaultSearchColumns, addParamsCallBack, cacheParamsCallBack, rowCallBack, drawCallBack, cacheLoadedCallBack, options);
        },
        order: function(element, columns, addParamsCallBack, cacheLoadedCallBack){
            var url = '/order/generateOrderTable';
            var options = {
                'order': [6, "desc"],
                displayLength: 50
            };
            var defaultSearchColumns = [];

            var cacheParamsCallBack = function(oData){
                //do something
            };

            var drawCallBack = function(e){

            };

            var rowCallBack = function(){
                //do something
            };

            return Kacana.datatable.init(element, url, columns, defaultSearchColumns, addParamsCallBack, cacheParamsCallBack, rowCallBack, drawCallBack, cacheLoadedCallBack, options);
        },
        generateAllCommissionByUserTable: function (element, columns, addressReceiveId, addParamsCallBack, cacheLoadedCallBack) {
            var url = '/customer/generateAllCommissionByUserTable/'+addressReceiveId;
            var options = {
                'order': [5, "desc"],
                displayLength: 10
            };
            var defaultSearchColumns = [];

            var cacheParamsCallBack = function(oData){
                //do something
            };

            var drawCallBack = function(e){

            };

            var rowCallBack = function(){
                //do something
            };

            return Kacana.datatable.init(element, url, columns, defaultSearchColumns, addParamsCallBack, cacheParamsCallBack, rowCallBack, drawCallBack, cacheLoadedCallBack, options);
        },
        generateAllCommissionTable: function (element, columns, addParamsCallBack, cacheLoadedCallBack) {
            var url = '/commission/generateAllCommissionTable';
            var options = {
                'order': [5, "desc"],
                displayLength: 10
            };
            var defaultSearchColumns = [];

            var cacheParamsCallBack = function(oData){
                //do something
            };

            var drawCallBack = function(e){

            };

            var rowCallBack = function(){
                //do something
            };

            return Kacana.datatable.init(element, url, columns, defaultSearchColumns, addParamsCallBack, cacheParamsCallBack, rowCallBack, drawCallBack, cacheLoadedCallBack, options);
        },
        generateTempCommissionTable: function (element, columns, addParamsCallBack, cacheLoadedCallBack) {
            var url = '/commission/generateTempCommissionTable';
            var options = {
                'order': [5, "desc"],
                displayLength: 10
            };
            var defaultSearchColumns = [];

            var cacheParamsCallBack = function(oData){
                //do something
            };

            var drawCallBack = function(e){

            };

            var rowCallBack = function(){
                //do something
            };

            return Kacana.datatable.init(element, url, columns, defaultSearchColumns, addParamsCallBack, cacheParamsCallBack, rowCallBack, drawCallBack, cacheLoadedCallBack, options);
        },
        generateValidCommissionTable: function (element, columns, addParamsCallBack, cacheLoadedCallBack) {
            var url = '/commission/generateValidCommissionTable';
            var options = {
                'order': [5, "desc"],
                displayLength: 10
            };
            var defaultSearchColumns = [];

            var cacheParamsCallBack = function(oData){
                //do something
            };

            var drawCallBack = function(e){

            };

            var rowCallBack = function(){
                //do something
            };

            return Kacana.datatable.init(element, url, columns, defaultSearchColumns, addParamsCallBack, cacheParamsCallBack, rowCallBack, drawCallBack, cacheLoadedCallBack, options);
        },
        generatePaymentCommissionTable: function (element, columns, addParamsCallBack, cacheLoadedCallBack) {
            var url = '/commission/generatePaymentCommissionTable';
            var options = {
                'order': [5, "desc"],
                displayLength: 10
            };
            var defaultSearchColumns = [];

            var cacheParamsCallBack = function(oData){
                //do something
            };

            var drawCallBack = function(e){

            };

            var rowCallBack = function(){
                //do something
            };

            return Kacana.datatable.init(element, url, columns, defaultSearchColumns, addParamsCallBack, cacheParamsCallBack, rowCallBack, drawCallBack, cacheLoadedCallBack, options);
        },
        generatePaymentHistoryTable: function (element, columns, addParamsCallBack, cacheLoadedCallBack) {
            var url = '/commission/generatePaymentHistoryTable';
            var options = {
                'order': [3, "desc"],
                displayLength: 5,
                dom: '<"top">rt<"bottom"<"col-xs-3"i><"col-xs-9"p>><"clear">'
            };
            var defaultSearchColumns = [];

            var cacheParamsCallBack = function(oData){
                //do something
            };

            var drawCallBack = function(e){

            };

            var rowCallBack = function(){
                //do something
            };

            return Kacana.datatable.init(element, url, columns, defaultSearchColumns, addParamsCallBack, cacheParamsCallBack, rowCallBack, drawCallBack, cacheLoadedCallBack, options);
        },
        generateCustomerTable: function (element, columns, addParamsCallBack, cacheLoadedCallBack) {
            var url = '/customer/generateCustomerTable';
            var options = {
                'order': [3, "desc"],
                displayLength: 10,
                dom: '<"top">rt<"bottom"<"col-xs-3"i><"col-xs-9"p>><"clear">'
            };
            var defaultSearchColumns = [];

            var cacheParamsCallBack = function(oData){
                //do something
            };

            var drawCallBack = function(e){

            };

            var rowCallBack = function(){
                //do something
            };

            return Kacana.datatable.init(element, url, columns, defaultSearchColumns, addParamsCallBack, cacheParamsCallBack, rowCallBack, drawCallBack, cacheLoadedCallBack, options);
        }
    }
};
$.extend(true, Kacana, datatablePackage);