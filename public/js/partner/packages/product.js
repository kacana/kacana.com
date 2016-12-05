var productPackage = {
  product:{
      init: function(){
      },
      listProductBoot: {
          page: null,
          init: function(){
              Kacana.product.listProductBoot.page = $('#page-content-product');
              Kacana.product.listProductBoot.setupDatatableForProductBoot();

              Kacana.product.listProductBoot.page.on('click','.product-boot-check', function () {
                    if(Kacana.product.listProductBoot.page.find('.product-boot-check:checked').length)
                        Kacana.product.listProductBoot.page.find('.product-supper-boot').removeClass('disabled');
                    else
                        Kacana.product.listProductBoot.page.find('.product-supper-boot').addClass('disabled');
              });

              Kacana.product.listProductBoot.page.on('click','.product-supper-boot', Kacana.product.listProductBoot.productSupperBoot);
              Kacana.product.listProductBoot.page.on('click','a[href="#product-boot"]', Kacana.product.listProductBoot.productBoot);

              var modal = $('#modal-supper-boot-product');

              modal.on('click', '.item-image-post-to-facebook img', function () {
                  var listItem = $(this).parents('.list-image-post-to-facebook');
                  var numberProduct = modal.find('.product-boot-item').length;
                  if(listItem.find('.item-image-post-to-facebook.active').length == 3 && !$(this).parents('.item-image-post-to-facebook').hasClass('active') && numberProduct > 1)
                      Kacana.utils.showError('Bạn chỉ được chọn tối đa 3 hình ảnh cho một sản phẩm!');
                  else if((listItem.find('.item-image-post-to-facebook.active').length == 1 && $(this).parents('.item-image-post-to-facebook').hasClass('active')))
                      Kacana.utils.showError('Sản phẩm phải có ít nhất một hình được chọn!');
                  else
                      $(this).parents('.item-image-post-to-facebook').toggleClass('active');
              });

              modal.on('click', '.list-social-post .social-list li', function () {
                  var listItem = $(this).parents('.list-social-post');
                  if(listItem.find('.social-list li.active').length == 1 && $(this).hasClass('active'))
                      Kacana.utils.showError('Bạn phải chọn ít nhất một tài khoản!');
                  else
                      $(this).toggleClass('active');
              });

              modal.on('click', 'a[href="#btn-post-to-social"]', Kacana.product.listProductBoot.postToSocial)

          },
          postToSocial: function () {
              var modal = $('#modal-supper-boot-product');

              var socials = [];
              var products = [];

              modal.find('.list-social-post .social-list li.active').each(function () {
                 socials.push({
                     socialId: $(this).data('social-id'),
                     type: $(this).data('type')
                 })
              });

              modal.find('.list-product-super-boot-item .product-boot-item').each(function () {
                  var images = [];
                  $(this).find('.item-image-post-to-facebook.active').each(function () {
                      images.push($(this).data('id'));
                  });
                  products.push({
                      productId: $(this).data('product-id'),
                      images: images,
                      caption: $(this).find('.caption-image').html()
                  });
              });

              var desc = modal.find('.desc-post-to-social').html();

              var callBack = function(data){
                  modal.modal('hide');
                  if(data.ok)
                  {
                      sweetAlert(
                          'Hoàn thành!',
                          'Đang post sản phẩm lên tài khoản của bạn! ( thời giạn dự kiến hoàn thành trong 10 phút )',
                          'success'
                      )
                  }
                  else
                  {
                      Kacana.utils.showError(data.error_message);
                  }

                  Kacana.utils.loading.closeLoading();
              };

              var errorCallBack = function(){};
              var data = {
                  products: products,
                  desc: desc,
                  socials: socials
              };
              Kacana.utils.loading.loading(Kacana.product.listProductBoot.page);
              Kacana.ajax.product.postToSocial(data, callBack, errorCallBack);
          },
          productBoot: function () {
              var productId = $(this).data('id');
              Kacana.product.listProductBoot.bootProduct([productId]);
          },
          productSupperBoot: function () {
              var productIds = [];

              Kacana.product.listProductBoot.page.find('.product-boot-check:checked').each(function () {
                  productIds.push($(this).val());
              });

              Kacana.product.listProductBoot.bootProduct(productIds);
          },
          bootProduct: function (productIds) {
              var callBack = function(data){
                  if(data.ok)
                  {
                      var modal = $('#modal-supper-boot-product');

                      var productSuperBootItem = $('#template-product-super-boot-item');
                      var templateDescDuperPostToSocial = $('#template-desc-super-post-to-social');

                      var productSuperBootItemGenerate = $.tmpl(productSuperBootItem, {'products': data.data});
                      modal.find('.list-product-super-boot-item').empty().append(productSuperBootItemGenerate);
                      var product = data.data;
                      for(var i = 0 ; i < product.length; i++)
                      {
                          var imageCaptionProductSuperBootItemGenerated = modal.find('.list-product-super-boot-item').find('#caption-image-'+product[i].id);
                          imageCaptionProductSuperBootItemGenerated.empty().html(product[i].caption);
                      }

                      if(product.length == 1){
                          modal.find('.desc-post-to-social').html(product[0].caption);
                          modal.find('.desc-post-to-social').append(data.saleRule);
                      }
                      else
                      {
                          modal.find('.desc-post-to-social').html('Tổng hợp các mẫu bán chạy nhất ...');
                          modal.find('.desc-post-to-social').append(data.saleRule);
                      }

                      modal.find('.list-social-post .social-list li').addClass('active');
                      modal.modal();
                  }
                  else
                  {
                      Kacana.utils.showError(data.error_message);
                  }
                  Kacana.utils.loading.closeLoading();
              };

              var errorCallBack = function(){};

              Kacana.utils.loading.loading(Kacana.product.listProductBoot.page);
              Kacana.ajax.product.productSupperBoot(productIds, callBack, errorCallBack);
          },
          setupDatatableForProductBoot: function () {
              var $formInline = $('.product-boot-form-inline');
              var element = '#productBootTable';
              $(element).parents('.box').css('overflow', 'auto');
              var columns = [
                  {
                      'title': 'Chọn',
                      'sortable':false,
                      'render': function ( data, type, full, meta ) {
                          return '<input class="product-boot-check" type="checkbox" value="'+data+'" >';
                      },
                      'width': '3%',
                  },
                  {
                      'title': 'Tên'
                  },
                  {
                      'title': 'Ảnh',
                      'sortable':false,
                      'render': function ( data, type, full, meta ) {
                          return '<img style="width: 50px" class="img-responsive" src="//image.kacana.vn'+data+'" />';
                      }
                  },
                  {
                      'title': 'Giá',
                      'render': function ( data, type, full, meta ) {
                          return Kacana.utils.formatCurrency(data);
                      }
                  },
                  {
                      'title': 'Giảm giá',
                      'render': function ( data, type, full, meta ) {
                          return Kacana.utils.formatCurrency(data);
                      }
                  },
                  {
                      'title': 'Cập nhật',
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
                          return '<a href="#product-boot" data-id="'+full[0]+'" class="btn btn-default btn-xs"><i class="fa fa-rocket"></i></a>';
                      }
                  }
              ];

              var addParamsCallBack = function(oData){
                  //search name or email
                  //oData.columns[2].search.orWhere = true;
                  //oData.columns[3].search.orWhere = true;
              };

              var cacheLoadedCallBack = function(oData){
                  $formInline.find('input[name="search"]').val(oData.columns[1].search.search);
                  $formInline.find('select[name="searchStatus"]').val(oData.columns[2].search.search);
              };

              var datatable = Kacana.datatable.productBoot(element, columns, addParamsCallBack, cacheLoadedCallBack);

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
      },
      detail: {
          init: function(){

          }
      }
  }
};

$.extend(true, Kacana, productPackage);