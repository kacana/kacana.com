var orderFromPackage = {
    orderFrom:{
        init: function(){
            Kacana.orderFrom.listOrderFrom.init();
        },
        listOrderFrom: {
            page: false,
            init: function () {
                Kacana.orderFrom.listOrderFrom.page= $('#content-list-order-from');
                Kacana.orderFrom.listOrderFrom.setupDatatableForOrderFrom();
                Kacana.orderFrom.listOrderFrom.bindEvent();
            },
            bindEvent: function () {
                Kacana.orderFrom.listOrderFrom.page.on('click', '#create-order-from-btn', function () {
                    var modal = $('#modal-create-order-from');
                    modal.find('#order_from_title').val('');
                    modal.find('#order_from_desc').val('');
                    modal.modal();
                });
                Kacana.orderFrom.listOrderFrom.page.on('click', 'a[href="#edit-order-from-btn"]', function () {
                    var modal = $('#modal-edit-order-from');
                    modal.find("#order_from_id").val($(this).data('id'));
                    modal.find('#order_from_title').val($(this).data('name'));
                    modal.find('#order_from_desc').val($(this).data('desc'));
                    modal.find('#form-edit').attr('action', '/orderFrom/editOrderFrom/'+$(this).data('id'));
                    modal.modal();
                });
            },
            setupDatatableForOrderFrom: function () {
                var $formInline = $('.form-inline');
                var element = '#orderFromTable';
                $(element).parents('.box').css('overflow', 'auto');
                var columns = [
                    {
                        'title': 'ID',
                        'width': '5%'
                    },
                    {
                        'title': 'Tên'
                    },
                    {
                        'title': 'Miêu tả',
                    },
                    {
                        'title': 'Created',
                        'width': '12%',
                        'render': function (data, type, full, meta) {
                            return data ? data.slice(0, -8) : '';
                        }
                    },
                    {
                        'title': 'Updated',
                        'width': '12%',
                        'render': function (data, type, full, meta) {
                            return data ? data.slice(0, -8) : '';
                        }
                    },
                    {
                        'width': '4%',
                        'class': 'center',
                        'sortable': false,
                        'render': function (data, type, full, meta) {
                            console.log(full);
                            return '<a href="#edit-order-from-btn" data-id="'+full[0]+'" data-name="'+full[1]+'" data-desc="'+full[2]+'" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>';
                        }
                    },
                ];

                var addParamsCallBack = function (oData) {
                    //search name or email
                    //oData.columns[2].search.orWhere = true;
                    //oData.columns[3].search.orWhere = true;
                };

                var cacheLoadedCallBack = function (oData) {
                    $formInline.find('input[name="search"]').val(oData.columns[1].search.search);
                    $formInline.find('select[name="searchStatus"]').val(oData.columns[2].search.search);
                };

                var datatable = Kacana.datatable.orderFrom(element, columns, addParamsCallBack, cacheLoadedCallBack);

                $formInline.off('submit')
                    .on('submit', function (e) {
                        e.preventDefault();

                        var api = datatable.api(true);

                        //var userType = $formInline.find('select[name="searchUserType"]').val();
                        var status = $formInline.find('select[name="searchStatus"]').val();
                        //var level = $formInline.find('select[name="searchLevel"]').val();
                        var text = $formInline.find('input[name="search"]').val();
                        //
                        api.column(1).search(text)
                            .column(2).search(status, true);

                        api.draw();
                    });
            }
        }
    }
};

$.extend(true, Kacana, orderFromPackage);