var partnerPackage = {
  partner:{
      init: function(){
          Kacana.partner.generateUserWaitingTransferTable();
      },
      generateUserWaitingTransferTable: function(){
          var $formInline = $('.form-inline');
          var element = '#userWaitingTransferTable';
          $(element).parents('.box').css('overflow', 'auto');
          var columns = [
              {
                  'title': 'ID',
                  'width':'5%'
              },
              {
                  'title': 'name'
              },
              {
                  'title': 'phone',
                  'sortable':false
              },
              {
                  'title': 'quantity',
                  'sortable':false
              },
              {
                  'title': 'total',
                  'sortable':false
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
                      return '<a href="/partner/detail/'+full[0]+'" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></a>';
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
          };

          var datatable = Kacana.datatable.generateUserWaitingTransferTable(element, columns, addParamsCallBack, cacheLoadedCallBack);

          $formInline.off('submit').on('submit', function (e) {
              e.preventDefault();

              var api = datatable.api(true);

              var name = $formInline.find('input[name="name"]').val();
              var phone = $formInline.find('input[name="phone"]').val();

              api.column(1).search(name)
                  .column(2).search(phone);

              api.draw();
          });
      },
      detail:{
          page: false,
          init: function () {
              Kacana.partner.detail.generateAllCommissionTable();
              Kacana.partner.detail.generateTempCommissionTable();
              Kacana.partner.detail.generateValidCommissionTable();
              Kacana.partner.detail.generatePaymentCommissionTable();
              Kacana.partner.detail.generatePaymentHistoryTable();

              Kacana.partner.detail.chooseOrderDetailToTransfer();

              Kacana.partner.detail.page = $('#content-detail-commission-partner');

              Kacana.partner.detail.page.on('click', 'a[href="#allCommission"]', function () {
                  $("#productSendTable").parents('.commission-box').removeClass('hidden').siblings('.commission-box').addClass('hidden');
                  var table = $("#productSendTable").DataTable();
                  table.draw('full-reset');
              });

              Kacana.partner.detail.page.on('click', 'a[href="#tempCommission"]', function () {
                  $("#productTempTable").parents('.commission-box').removeClass('hidden').siblings('.commission-box').addClass('hidden');
                  var table = $("#productTempTable").DataTable();
                  table.draw('full-reset');
              });

              Kacana.partner.detail.page.on('click', 'a[href="#validCommission"]', function () {
                  $("#productValidTable").parents('.commission-box').removeClass('hidden').siblings('.commission-box').addClass('hidden');
                  var table = $("#productValidTable").DataTable();
                  table.draw('full-reset');
              });

              Kacana.partner.detail.page.on('click', 'a[href="#paymentCommission"]', function () {
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
              var userId = $('#user_id').val();
              var datatable = Kacana.datatable.generateAllCommissionTable(element, columns, userId,addParamsCallBack, cacheLoadedCallBack);

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
              var userId = $('#user_id').val();
              var datatable = Kacana.datatable.generateTempCommissionTable(element, columns, userId, addParamsCallBack, cacheLoadedCallBack);

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
              var userId = $('#user_id').val();
              var datatable = Kacana.datatable.generateValidCommissionTable(element, columns, userId, addParamsCallBack, cacheLoadedCallBack);

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
              var userId = $('#user_id').val();
              var datatable = Kacana.datatable.generatePaymentCommissionTable(element, columns, userId, addParamsCallBack, cacheLoadedCallBack);

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
                          return '<a target="_blank" href="/partner/detailTransfer/'+data+'" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></a>';
                      }
                  }
              ];

              var addParamsCallBack = function(oData){

              };

              var cacheLoadedCallBack = function(oData){

              };
              var userId = $('#user_id').val();
              var datatable = Kacana.datatable.generatePaymentHistoryTable(element, columns, userId, addParamsCallBack, cacheLoadedCallBack);
          },
          chooseOrderDetailToTransfer: function () {
              var modal = $('#modal-transfer-partner');

              modal.on('click','.order_detail_success', function () {
                  var total = 0;
                  modal.find('.order_detail_success:checked').each(function () {
                      var subTotal = $(this).data('sub-total');
                      total +=subTotal;
                  });

                  $('#transfer_total').val(Kacana.utils.formatCurrency(total));

                  if(total)
                  {
                      $('#btn-submit-transfer').removeAttr('disabled');
                  }
                  else
                  {
                      $('#btn-submit-transfer').attr('disabled', true);
                  }

              });
          }
      },
      historyPayment: {
          generatePartnerPaymentTable: function () {
              var $formInline = $('.form-inline');
              var element = '#partnerPaymentTable';

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
                      },
                      'sortable':false
                  },
                  {
                      'title': 'số đơn',
                      'sortable':false
                  },
                  {
                      'title': 'partner',
                      'sortable':false
                  },
                  {
                      'title': 'ngày',
                      'render': function ( data, type, full, meta ) {
                          return data ? data.slice(0, -8) +'<br><b>' + data.slice(11, 19)+'</b>' : '';
                      }
                  },
                  {
                      'width':'4%',
                      'class':'center',
                      'sortable':false,
                      'render': function ( data, type, full, meta ) {
                          return '<a href="/partner/detailTransfer/'+data+'" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></a>';
                      }
                  }
              ];

              var addParamsCallBack = function(oData){
                  //search name or email
                  //oData.columns[2].search.orWhere = true;
                  //oData.columns[3].search.orWhere = true;
              };

              var cacheLoadedCallBack = function(oData){
                  $formInline.find('input[name="code"]').val(oData.columns[0].search.search);
                  $formInline.find('input[name="name"]').val(oData.columns[3].search.search);
              };

              var datatable = Kacana.datatable.generatePartnerPaymentTable(element, columns, addParamsCallBack, cacheLoadedCallBack);

              $formInline.off('submit')
                  .on('submit', function (e) {
                      e.preventDefault();

                      var api = datatable.api(true);

                      var code = $formInline.find('input[name="code"]').val();
                      var name = $formInline.find('input[name="name"]').val();

                      api.column(0).search(code)
                          .column(3).search(name);

                      api.draw();
                  });
          }
      }
   }
};

$.extend(true, Kacana, partnerPackage);