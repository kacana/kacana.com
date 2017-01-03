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
                'displayLength': (options.displayLength)?options.displayLength:50,
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
                    Kacana.utils.loading($(element));
                },
                'drawCallback':function(oSettings){
                    drawCallBack(oSettings);
                    Kacana.utils.closeLoading();
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
        tag: function(element, columns, addParamsCallBack, cacheLoadedCallBack){
            var url = '/tag/generateTagTable';
            var options = {
                'order': [0, "desc"]
            };
            var defaultSearchColumns = [];

            var cacheParamsCallBack = function(oData){
                //do something
            };

            var drawCallBack = function(e){
                //do something
                //$(e.nTable).find('input[type=checkbox]').iCheck({
                //    checkboxClass: 'icheckbox_minimal'
                //});
            };

            var rowCallBack = function(){
                //do something
            };

            return Kacana.datatable.init(element, url, columns, defaultSearchColumns, addParamsCallBack, cacheParamsCallBack, rowCallBack, drawCallBack, cacheLoadedCallBack, options);
        },
        productTag: function(tagId, element, columns, addParamsCallBack, cacheLoadedCallBack){
            var url = '/product/generateProductTagTable?tagId='+tagId;
            var options = {
                'order': [0, "desc"],
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
        product: function(element, columns, addParamsCallBack, cacheLoadedCallBack){
            var url = '/product/generateProductTable';
            var options = {
                'order': [0, "desc"],
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
        user: function(element, columns, addParamsCallBack, cacheLoadedCallBack){
            var url = '/user/generateUserTable';
            var options = {
                'order': [0, "desc"],
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
        detailTable: function(element, columns,typeReport, orderBy, addParamsCallBack, cacheLoadedCallBack){
            // var controller = typeReport.toLowerCase();
            var url = '/index/reportDetailTable'+typeReport;
            var options = {
                'order': [orderBy, "desc"],
                displayLength: 10
            };
            console.log(orderBy);
            console.log(typeReport);
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
                'order': [0, "desc"],
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
        shipping: function(element, columns, addParamsCallBack, cacheLoadedCallBack){
            var url = '/shipping/generateShippingTable';
            var options = {
                'order': [0, "desc"],
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
        generateAddressReceiveByUserId: function (element, columns, $userId,addParamsCallBack, cacheLoadedCallBack) {
            var url = '/user/generateAddressReceiveByUserId/'+$userId;
            var options = {
                'order': [0, "desc"],
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
        generateAllOrderDetailByUserTable: function (element, columns, userId, addParamsCallBack, cacheLoadedCallBack) {
            var url = '/user/generateAllOrderDetailByUserTable/'+userId;
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
        generateUserWaitingTransferTable: function (element, columns, addParamsCallBack, cacheLoadedCallBack) {
            var url = '/partner/generateUserWaitingTransferTable';
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
        generateAllCommissionTable: function (element, columns, userId, addParamsCallBack, cacheLoadedCallBack) {
            var url = '/partner/generateAllCommissionTable/'+userId;
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
        generateTempCommissionTable: function (element, columns, userId, addParamsCallBack, cacheLoadedCallBack) {
            var url = '/partner/generateTempCommissionTable/'+userId;
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
        generateValidCommissionTable: function (element, columns, userId, addParamsCallBack, cacheLoadedCallBack) {
            var url = '/partner/generateValidCommissionTable/'+userId;
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
        generatePaymentCommissionTable: function (element, columns, userId, addParamsCallBack, cacheLoadedCallBack) {
            var url = '/partner/generatePaymentCommissionTable/'+userId;
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
        generatePaymentHistoryTable: function (element, columns, userId, addParamsCallBack, cacheLoadedCallBack) {
            var url = '/partner/generatePaymentHistoryTable/'+userId;
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
        generatePartnerPaymentTable: function (element, columns, addParamsCallBack, cacheLoadedCallBack) {
            var url = '/partner/generatePartnerPaymentTable/';
            var options = {
                'order': [4, "desc"],
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
        },
        generatePostTable: function (element, columns, addParamsCallBack, cacheLoadedCallBack) {
            var url = '/blog/generatePostTable/';
            var options = {
                'order': [0, "desc"],
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
        generateCommentTable: function (element, columns, postId,addParamsCallBack, cacheLoadedCallBack) {
            var url = '/blog/generateCommentTable/'+postId;
            var options = {
                'order': [0, "desc"],
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
        }

    }
};
$.extend(true, Kacana, datatablePackage);