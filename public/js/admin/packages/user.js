var userPackage = {
  user:{
      init: function(){
          Kacana.user.setupDatatableForUser();
          Kacana.user.createUser();
          Kacana.user.setStatus();
      },
      setupDatatableForUser: function(){
          var $formInline = $('.form-inline');
          var element = '#userTable';
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
                  'title': 'email',
                  'sortable':false
              },
              {
                  'title': 'phone',
                  'sortable':false
              },
              {
                  'title': 'role',
              },
              {
                  'title': 'status',
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
                  'width':'80px',
                  'class':'center',
                  'sortable':false,
                  'render': function ( data, type, full, meta ) {
                      var partnerBtn = '';

                      if(full[8] == 'partner')
                      {
                          partnerBtn = '<a target="_blank" href="/partner/detail/'+full[0]+'" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></a>';
                      }


                    return '<a href="/user/edit/'+full[0]+'" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a> '+partnerBtn;
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
              $formInline.find('input[name="email"]').val(oData.columns[2].search.search);
              $formInline.find('input[name="phone"]').val(oData.columns[3].search.search);
              $formInline.find('select[name="searchRole"]').val(oData.columns[4].search.search);
              $formInline.find('select[name="searchStatus"]').val(oData.columns[5].search.search);
          };

          var datatable = Kacana.datatable.user(element, columns, addParamsCallBack, cacheLoadedCallBack);

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
      },
      setupDatatableForUserTracking: function () {
          $('#content-list-user').on('click', 'a[href="#show-information-client-message"]', Kacana.chat.showClientMessageInfo);
          var $formInline = $('.form-inline');
          var element = '#userTrackingTable';
          $(element).parents('.box').css('overflow', 'auto');
          var columns = [
              {
                  'title': 'ID',
                  'width':'5%'
              },
              {
                  'title': 'url'
              },
              {
                  'title': 'referer'
              },
              {
                  'title': 'ip'
              },
              {
                  'title': 'type_call',
              },
              {
                  'title': 'created',
                  'width':'12%',
                  'render': function ( data, type, full, meta ) {
                      return data ? data.slice(0, -8) : '';
                  }
              },
              {
                  'width':'80px',
                  'class':'center',
                  'sortable':false,
                  'render': function ( data, type, full, meta ) {
                      return '<a href="#show-information-client-message" data-id="'+full[0]+'" class="btn btn-default btn-xs"><i class="fa fa-info-circle"></i></a> ';
                  }
              }
          ];

          var addParamsCallBack = function(oData){

          };

          var cacheLoadedCallBack = function(oData){

          };
            var trackingId = $('#user-tracking-id').data('id');
          var datatable = Kacana.datatable.userTracking(trackingId, element, columns, addParamsCallBack, cacheLoadedCallBack);

          $formInline.off('submit').on('submit', function (e) {
              e.preventDefault();

              var api = datatable.api(true);

              api.draw();
          });
      },
      setupDatatableForFacebookComment: function(){
          var $formInline = $('.form-inline');
          var element = '#facebookComment';
          $(element).parents('.box').css('overflow', 'auto');
          var columns = [
              {
                  'title': 'ID',
                  'width':'5%'
              },
              {
                  'title': 'Sender',
                  'width':'10%',
                  'render': function ( data, type, full, meta ) {
                      return '<a href="https://facebook.com/'+full[2]+'" target="_blank" ><b>'+data+'</b></a>';
                  }
              },
              {
                  'title': 'Sender Image',
                  'width':'5%',
                  'sortable':false,
                  'render':  function ( data, type, full, meta ) {
                      return '<a href="https://facebook.com/'+full[2]+'" target="_blank" ><img src="http://graph.facebook.com/'+data+'/picture?type=large" style="width:50px"/></a>';
                  }
              },
              {
                  'title': 'PostId',
                  'sortable':true,
                  'width':'12%',
                  'render':  function ( data, type, full, meta ) {
                        var postId = data.split('_');
                        return postId[1];
                  }
              },
              {
                  'title': 'type',
                  'width':'5%',
                  'sortable':true,
                  'render':  function ( data, type, full, meta ) {
                      if(data == 'like')
                        return '<span style="display: block" class="text-aqua text-center"><i class="fa fa-thumbs-o-up"></i><p>'+data+'</p></span>';
                      else if(data == 'comment')
                        return '<span style="display: block" class="text-green text-center"><i class="fa fa-comment" ></i><p>'+data+'</p></span>';
                  }
              },
              {
                  'title': 'Message',
                  'sortable':true
              },
              {
                  'title': 'created',
                  'width':'12%',
                  'render': function ( data, type, full, meta ) {
                      return data ? data.slice(0, -8) +'<br><b>' + data.slice(11, 19)+'</b>' : '';
                  }
              }
          ];

          var addParamsCallBack = function(oData){

          };

          var cacheLoadedCallBack = function(oData){
              $formInline.find('input[name="name"]').val(oData.columns[1].search.search);
              $formInline.find('input[name="post_id"]').val(oData.columns[3].search.search);
              $formInline.find('select[name="search_type"]').val(oData.columns[4].search.search);
              $formInline.find('input[name="message"]').val(oData.columns[5].search.search);
          };

          var datatable = Kacana.datatable.generateFacebookCommentTable(element, columns, addParamsCallBack, cacheLoadedCallBack);

          $formInline.off('submit').on('submit', function (e) {
              e.preventDefault();

              var api = datatable.api(true);

              var name = $formInline.find('input[name="name"]').val();
              var postId = $formInline.find('input[name="post_id"]').val();
              var searchType = $formInline.find('select[name="search_type"]').val();
              var message = $formInline.find('input[name="message"]').val();

              api.column(1).search(name)
                  .column(3).search(postId)
                  .column(4).search(searchType)
                  .column(5).search(message);

              api.draw();
          });
      },
      detailUser:{
          init: function () {
                Kacana.user.detailUser.generateAddressReceiveByUserId();
                Kacana.user.detailUser.generateAllCommissionByUserTable();
          },
          generateAddressReceiveByUserId: function () {

              var element = '#addressReceiveTable';
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
                      'title': 'email',
                      'sortable':false
                  },
                  {
                      'title': 'street',
                      'sortable':false
                  },
                  {
                      'title': 'city',
                      'sortable':false
                  },
                  {
                      'title': 'district',
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
                      'width':'4%',
                      'class':'center',
                      'sortable':false,
                      'render': function ( data, type, full, meta ) {
                          return '<a href="/user/edit/'+full[0]+'" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>';
                      }
                  }
              ];

              var addParamsCallBack = function(oData){

              };

              var cacheLoadedCallBack = function(oData){

              };

              var userId = $('#user_id').val();
              var datatable = Kacana.datatable.generateAddressReceiveByUserId(element, columns, userId,addParamsCallBack, cacheLoadedCallBack);
          },
          generateAllCommissionByUserTable: function () {
              var $formInline = $('.form-inline-all');
              var element = '#productSendTable';

              $(element).parents('.box').css('overflow', 'auto');
              var columns = [
                  {
                      'title': 'mã đh',
                      'render': function ( data, type, full, meta ) {
                          return '<a href="/order/edit/'+full[10]+'" target="_blank" >'+data+'</a>';
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
                      'title': 'giá'
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
              var datatable = Kacana.datatable.generateAllOrderDetailByUserTable(element, columns, userId, addParamsCallBack, cacheLoadedCallBack);

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

$.extend(true, Kacana, userPackage);