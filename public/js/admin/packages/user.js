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
              },
              {
                  'width':'4%',
                  'class':'center',
                  'sortable':false,
                  'render': function ( data, type, full, meta ) {
                      return '<a href="/product/editProduct/'+full[0]+'" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>';
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

          $formInline.off('submit')
              .on('submit', function (e) {
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
      showFormCreateUser: function(){
          var callBack= function(data){
                $("#createModal").html(data);
                $("#createModal").modal('show');
          };
          var errorCallBack = function(){};
          Kacana.ajax.user.showFormCreateUser(callBack, errorCallBack);
      },
      createUser: function(){
          $("#btn-create").attr('disabled', true);
          var form_data = new FormData();
          var file_image = $('#image').prop("files")[0];
          var other_data = $("#form-create-user").serialize();
          form_data.append('image', file_image);

          var callBack = function(data){
              window.location.reload();
          }
          var errorCallBack = function(data){
              json_result = JSON.parse(data.responseText);
              if(typeof(json_result['email'])!=''){
                  $("#error-email").html(json_result['email']);
              }

              if(typeof(json_result['name'])!=''){
                  $("#error-name").html(json_result['name']);
              }

              if(typeof(json_result['phone'])!=''){
                  $("#error-phone").html(json_result['phone']);
              }

              if(typeof(json_result['password'])!=''){
                  $("#error-password").html(json_result['password']);
              }
              $("#btn-create").attr('disabled', false);
          };
          Kacana.ajax.user.createUser(other_data, form_data, callBack, errorCallBack);
      },
      removeUser: function(id){
          $('#confirm').modal('show');
          var callBack = function(data){
              window.location.reload();
          };
          var errorCallBack = function(){};
          $('#delete').click(function (e) {
              Kacana.ajax.user.removeUser(id, callBack, errorCallBack);
          });
      },
      setStatus: function(id, status){
          var callBack = function(data){
              window.location.reload();
          };
          var errorCallBack = function(){};
          Kacana.ajax.user.setStatus(id, status, callBack, errorCallBack);
      },
      /*****************************************************************************
       *
       *          FUNCTION AJAX FOR USER ADDRESS MANAGEMENT
       *
       * ***************************************************************************/
      userAddress: {
          listUserAddress: function(id){
            var columns = ['id', 'name', 'email', 'phone', 'street', 'city', 'ward', 'action'];
            var btable = Kacana.datatable.init('table', columns, '/user/getUserAddress/'+id);
          },
          showFormEdit: function(id){
              var callBack = function(data){
                  $("#createModal").html(data);
                  $("#createModal").modal('show');
              };
              var errorCallBack = function(){};
              Kacana.ajax.userAddress.showFormEdit(id, callBack, errorCallBack);
          },
          edit: function(){
              var form_data = $("#form-edit-address").serialize();
              var callBack = function (data) {
                  window.location.reload();
              };
              var errorCallBack = function(data){
                  json_result = JSON.parse(data);
                  if(typeof(json_result['name'])!=''){
                      $("#error-name").html(json_result['name']);
                  };
                  if(typeof(json_result['email'])!=''){
                      $("#error-email").html(json_result['email']);
                  };
                  if(typeof(json_result['phone'])!=''){
                      $("#error-phone").html(json_result['phone']);
                  };
                  if(typeof(json_result['street'])!=''){
                      $("#error-street").html(json_result['street']);
                  };
              };
              Kacana.ajax.userAddress.edit(form_data, callBack, errorCallBack);
          },
          changeCity: function(){
              city_id = $("#city_id").find('option:selected').val();
              var callBack = function(data){
                $("#ward").html(data);
              };
              var errorCallBack = function(){};
              Kacana.ajax.userAddress.changeCity(city_id, callBack, errorCallBack);
          }
      }
   }
};

$.extend(true, Kacana, userPackage);