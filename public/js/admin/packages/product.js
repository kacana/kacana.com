var productPackage = {
  product:{
      init: function(){
          Kacana.product.listProducts.init();
      },
      listProducts: {
          page: null,
          init: function(){
              Kacana.product.listProducts.setupDatatableForProduct();
              Kacana.product.listProducts.page = $('#content-list-product')
              Kacana.product.listProducts.page.on('click', '#create-csv-for-remarketing', Kacana.product.listProducts.createCSVForRemarketing);
              Kacana.product.listProducts.page.on('click', 'a[href="#remove-campaign-product"]', Kacana.product.listProducts.removeCampaignProduct);
              Kacana.product.listProducts.page.on('click', 'a[href="#createCampaignProduct"]', Kacana.product.listProducts.openModalCreateCampaignProduct);
              $('#modal-create-campaign-product').on('click', '#submit-products-add-to-campaign', Kacana.product.listProducts.createProductCampaign);
              $('#modal-create-campaign-product').on('change','#campaign_id', Kacana.product.listProducts.changeCampaign)
          },
          createCSVForRemarketing: function () {
              var callBack = function(data){
                  if(data.ok)
                  {
                      swal({
                          title: 'Xong Rồi!',
                          text: 'File is integrated to google re-marketing by System  ',
                          type: 'success',
                          confirmButtonText: 'Cool'
                      });
                  }
                  Kacana.utils.closeLoading();
              };
              var errorCallBack = function(){};
              Kacana.utils.loading();
              Kacana.ajax.product.createCSVForRemarketing(callBack, errorCallBack);
          },
          openModalCreateCampaignProduct: function () {
                var modal = $('#modal-create-campaign-product');
                var productId = $(this).data('product-id');
                modal.data('product-id', productId);
                var callBack = function(data){
                    var product = data.data;

                    if(data.ok)
                    {
                      var productName = product.name+' <img class="thumbnail-product-create-campaign" src="'+product.image+'">';
                      modal.find('#product-campaign-name-and-image').html(productName);
                      var campaigns = Kacana.utils.generateProductCampaignProductTable(product.campaign_product, product.sell_price, false);
                      modal.find('#product-campaign-current-campaign').html(campaigns);
                        modal.find('#campaign_product_apply_date').daterangepicker({
                            timePicker: true,
                            timePicker24Hour: true,
                            locale: {
                                format: 'YYYY-MM-DD H:mm'
                            }
                        });
                      modal.modal();
                    }
                    Kacana.utils.closeLoading();
                };

                var errorCallBack = function(){};
                Kacana.utils.loading();
                Kacana.ajax.product.getProductAjax(productId, callBack, errorCallBack);

          },
          changeCampaign: function () {
            var campaignId = $(this).val();
            var modal = $('#modal-create-campaign-product');
            var option = modal.find('#campaign_id option[value="'+campaignId+'"]');
            modal.find('#campaign_product_apply_date').data('daterangepicker').setStartDate(option.data('start'));
            modal.find('#campaign_product_apply_date').data('daterangepicker').setEndDate(option.data('end'));
          },
          createProductCampaign: function () {
              var modal = $('#modal-create-campaign-product');
              var productId = modal.data('product-id');

              var listProductAdded = [productId];

              var discountType = modal.find('#campaign_discount_type').val();
              var discountDate = modal.find('#campaign_product_apply_date').val();
              var discountRef = modal.find('#campaign_discount_reference').val();
              var campaignId = modal.find('#campaign_id').val();

              var callBack = function (data) {
                  if(data.ok){
                      Kacana.product.listProducts.page.find('.form-inline').submit();
                      modal.modal('hide');
                  }
                  else {
                      Kacana.utils.showError('Some day, please re-check discount day!');
                  }
              };

              var errorCallBack = function () {

              };

              var data = {
                  listProductAdded: listProductAdded,
                  discountType: discountType,
                  discountDate: discountDate,
                  discountRef: discountRef,
                  campaignId: campaignId
              };

              Kacana.ajax.campaign.addProductCampaign(data, callBack, errorCallBack);

              return false;
          },
          removeCampaignProduct: function () {
            var id = $(this).data('id');

              swal({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
              }).then(function() {
                  var callBack = function (data) {
                      if(data.ok){
                          swal({
                              type: 'success',
                              title: 'Delete'
                          });
                          Kacana.product.listProducts.page.find('.form-inline').submit();
                      }
                      else {
                          Kacana.utils.showError('Have error when delete.');
                      }
                  };

                  var errorCallBack = function () {

                  };
                  Kacana.ajax.campaign.removeCampaignProduct(id, callBack, errorCallBack);
              });
          },
          setupDatatableForProduct: function(){
              var $formInline = $('.form-inline');
              var element = '#productTable';
              $(element).parents('.box').css('overflow', 'auto');
              generateStoreProductTable

              var addParamsCallBack = function(oData){
                  //search name or email
                  //oData.columns[2].search.orWhere = true;
                  //oData.columns[3].search.orWhere = true;
              };

              var cacheLoadedCallBack = function(oData){
                  $formInline.find('input[name="search"]').val(oData.columns[1].search.search);
                  $formInline.find('select[name="searchStatus"]').val(oData.columns[5].search.search);
              };

              var datatable = Kacana.datatable.product(element, columns, addParamsCallBack, cacheLoadedCallBack);

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
                          .column(5).search(status, true);

                      api.draw();
                  });
          },
      },
      removeProduct: function(idProduct){

          var callBack = function(data){
              window.location.reload();
          };
          var errorCallBack = function(){};
          $('#delete').click(function (e) {
              $('#confirm').modal('show');
              Kacana.ajax.product.removeProduct(idProduct, callBack, errorCallBack);
          });
      },
      setStatus: function(id, status){
          var callBack = function(data){
              window.location.reload();
          };
          var errorCallBack = function(){};
          Kacana.ajax.product.setStatus(id, status, callBack, errorCallBack);
      },
      detail: {
            init: function(){
                Kacana.config.initSummerNote(Kacana.product.detail.simpleNoteUploadImageCallback);
                var $page = $('#product-detail-page');
                $('.select-size').select2();
                $('.properties-color').select2({
                    "language": {
                        "noResults": function(){
                            return "Nhấn Enter để tạo tag này!";
                        }
                    }
                });

                $('body').on('keyup', '.select2-search__field', Kacana.product.detail.addColorTag);

                $page.on('click', 'a[href="#remove-product-property"]',  Kacana.product.detail.removeProductProperty);
                $page.on('click', 'a[href="#print-barcode"]',  Kacana.product.detail.printBarcode);

                $page.on('click', 'button[data-target="#modal-add-image-product-properties"]', function(){
                    var $modal = $('#modal-add-image-product-properties');

                    var colorName = $(this).parents('.row').find('.properties-color option:selected').html();
                    $modal.find('.modal-header').html('chọn hình cho sản phẩm màu: <b>'+colorName+'</b>');
                    var productGalleryId = $(this).parents('.wrapper-properties-image').find('input').val();
                    $page.find('.wrapper-properties-image').removeClass('processing');
                    $(this).parents('.wrapper-properties-image').addClass('processing');

                    $modal.find('.wraper-image').removeClass('active');
                    if(productGalleryId)
                    {
                        $modal.find('.wraper-image[data-id="'+productGalleryId+'"]').addClass('active');
                    }

                    $modal.modal();
                   return false;
                });

                $page.on('change', '.properties-color', function(){
                    Kacana.product.detail.limitColor();
                });

                $page.find('#tag_search_product').select2({
                    closeOnSelect: false,
                    ajax: {

                        url: "/tag/searchTagProduct",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                name: params.term, // search term
                                page: params.page,
                                productId: $('#productId').val()
                            };
                        },
                        processResults: function (data, params) {
                            // parse the results into the format expected by Select2
                            // since we are using custom formatting functions we do not need to
                            // alter the remote JSON data, except to indicate that infinite
                            // scrolling can be used
                            params.page = params.page || 1;

                            return {
                                results: data.items,
                                pagination: {
                                    more: (params.page * 30) < data.total_count
                                }
                            };
                        },
                        cache: true
                    },
                    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                    minimumInputLength: 1,
                    templateSelection: Kacana.product.detail.parseProductTagSelection,
                    templateResult: Kacana.product.detail.parseProductTagTemplate,
                });


                Kacana.product.detail.limitColor();

                $page.on('click', 'button[data-target="#add-product-property"]', function(){

                    var propertyTempalate = $('#template-product-properties');

                    var newPropertyHtml = propertyTempalate.html();
                    $(this).parents('.box').find('.modal-body').append(newPropertyHtml);

                    $('.select-size').select2();
                    $('.properties-color').select2();
                    Kacana.product.detail.limitColor();
                    return false;
                });
                $('#modal-add-image-product-properties').on('click', '.wraper-image', function(){
                    if($(this).hasClass('active')){
                        $(this).removeClass('active');
                        $page.find('.wrapper-properties-image.processing input').val(0);
                        $page.find('.wrapper-properties-image.processing button.btn').removeClass('btn-success').addClass('btn-primary').html('<i class="fa fa-plus"></i> hình ảnh');
                    }
                    else
                    {
                        $(this).addClass('active').siblings().removeClass('active');
                        var id = $(this).data('id');
                        $page.find('.wrapper-properties-image.processing input').val(id);
                        $page.find('.wrapper-properties-image.processing button.btn').removeClass('btn-primary').addClass('btn-success').html('<i class="fa fa-pencil"></i> chọn lại');
                    }
                });

                $("#tree-tags").tree({
                    closedIcon: $('<i class="fa fa-plus-square-o"></i>'),
                    openedIcon: $('<i class="fa fa-minus-square-o"></i>'),
                    onCreateLi: function(node, $li){
                        countChild = node.childs;
                        nodeid = node.id;
                        if(node.checked == true){
                            $li.find('.jqtree-title').before(' <input type="checkbox" name="productTag_1[]" value="'+nodeid+'" checked/> ');
                        }else{
                            $li.find('.jqtree-title').before(' <input type="checkbox" name="productTag_1[]" value="'+nodeid+'" /> ');
                        }
                    },
                    autoOpen: true
                });

                Kacana.product.detail.uploadImage();
                Kacana.product.detail.uploadMainImage();

                var $listImageProduct = $('.list-product-image');
                $listImageProduct.on('click', 'a[href="#deleteImage"],a[href="#setPrimaryImage"],a[href="#setSlideImage"]', Kacana.product.detail.updateProductImageType);

                $('#form-edit-product').on('keyup', '.currency', function(){
                    var id = $(this).attr('id');
                    $('#format-'+id).val(Kacana.utils.formatCurrency($(this).val(), 'đ'));
                });

                $('#form-edit-product .currency').each(function(){
                    var id = $(this).attr('id');
                    $('#format-'+id).val(Kacana.utils.formatCurrency($(this).val(), 'đ'));
                });

                $page.on('change','#group-tag-for-product', function () {
                   if($(this).val())
                        $(this).parents('.form-group').find('button').removeAttr('disabled');
                    else
                       $(this).parents('.form-group').find('button').attr('disabled', 'disabled');
                });

                $page.find('#group-tag-for-product').select2({
                    closeOnSelect: false
                });

                $page.on('click','#add-group-tag-to-product-tag', Kacana.product.detail.addGroupTagToProductTag);
                $page.on('click','#remove-group-tag-from-product-tag', Kacana.product.detail.removeGroupTagFromProductTag);
                $('#product-image-detail .list-product-image').sortable({
                    placeholder: "product-image-item-holder",
                    stop: function( ) {
                        Kacana.product.detail.sortProductGallery();
                    }
                });
            },
            printBarcode: function () {
                var href = $(this).data('href');
                window.open(href, 'Print Barcode', 'height=700,width=1000');
                return true;
            },
            removeProductProperty: function () {
                var that = $(this);
                swal({
                    title: 'Xoá thuộc tính!',
                    text: "Bạn có chắc xoá thuộc tính sản phẩm này!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xoá!'
                }).then(function () {
                    Kacana.utils.loading();
                    var callback = function(data){
                        if(data.ok)
                        {
                            Kacana.utils.closeLoading();

                            that.closest('.row').remove();
                            swal(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )

                            console.log('Removed');
                        }
                    };
                    var errorCallback = function(){
                        // do something here if error
                    };

                    Kacana.ajax.product.deleteProductProperty(that.data('id'), callback, errorCallback);
                });

                return false;
            },
            sortProductGallery: function () {
                var listImage = $('#product-image-detail .list-product-image');
                var imageIds = [];
                listImage.find('.product-image-item').each(function () {
                    imageIds.push($(this).data('id'));
                });

                var callback = function(data){
                    if(data.ok)
                    {
                        console.log('Done sort');
                    }
                };
                var errorCallback = function(){
                    // do something here if error
                };

                Kacana.ajax.product.sortProductGallery(imageIds, $('#productId').val(), callback, errorCallback);
            },
            simpleNoteUploadImageCallback: function(up, file, info, $areaEditorImageUpload) {
                var data = jQuery.parseJSON(info.response);

                if(data.ok)
                {
                    var sendData = {
                        name: data.name,
                        productId: $('#productId').val(),
                        type: 4
                    };

                    var callBack = function(data){
                        if(data.ok){
                            data = data.data;
                            var nodeParent = document.createElement('p');
                            var node = document.createElement('img');
                            node.src = data.image;
                            node.title = $('#name').val();
                            node.alt = $('#name').val();
                            nodeParent.appendChild(node);
                            $areaEditorImageUpload.summernote('insertNode', nodeParent);
                        }

                    };

                    var errorCallBack = function(){

                    };

                    Kacana.ajax.product.addProductImage(sendData, callBack, errorCallBack);

                }
            },
            addColorTag: function (e) {
                var keyCode = e.keyCode || e.which;
                var tagName = $(this).val()
                if(keyCode == 13 && tagName)
                {
                    var callback = function(data){
                        if(data.ok)
                        {
                            $('.properties-color').append("<option value='"+data.data.id+"'>"+data.data.name+"</option>");
                            var selectColorCurrent = $('.properties-color').parents('.form-group').find('.select2-container--open').parents('.form-group').find('.properties-color');
                            selectColorCurrent.find('option[value="'+data.data.id+'"]').attr('selected', 'selected');
                            selectColorCurrent.trigger('change').select2("close");
                            Kacana.product.detail.limitColor();
                        }
                        console.log(data);
                    };
                    var errorCallback = function(){
                        // do something here if error
                    };
                    Kacana.ajax.tag.createTagWithType(tagName, 2, 0, callback, errorCallback);
                }


            },
            addGroupTagToProductTag: function () {
                var groupTagIds = $(this).parents('.form-group').find('select').val();

                var errorCallBack = function(e){
                    console.log(e);
                };
                var callBack = function (data){
                    console.log(data);
                    var tagInput = $('#tag_search_product');
                    if(data.ok)
                    {
                        // var tags = data.data.childs;
                        var tags = data.data;
                        for(var i = 0; i < tags.length; i++){
                            if($.inArray( tags[i].id.toString(), tagInput.val()) == -1)
                                tagInput.append('<option value="'+tags[i].id.toString()+'" selected >'+tags[i].name+'</option>').trigger("change");

                            var tagChilds = tags[i].childs;
                            if(tagChilds !== undefined)
                            {
                                for(var j = 0; j < tagChilds.length; j++){
                                    if($.inArray( tagChilds[j].id.toString(), tagInput.val()) == -1)
                                        tagInput.append('<option value="'+tagChilds[j].id.toString()+'" selected >'+tagChilds[j].name+'</option>').trigger("change");
                                }
                            }
                        }
                    }
                };

                Kacana.ajax.tag.getGroupTag(groupTagIds, callBack, errorCallBack);

            },
            removeGroupTagFromProductTag: function () {
                  var groupTagId = $(this).parents('.form-group').find('select').val();

                  var errorCallBack = function(e){
                      console.log(e);
                  };
                  var callBack = function (data){
                      console.log(data);
                      var tagInput = $('#tag_search_product');
                      if(data.ok)
                      {
                          var tags = data.data;
                          for(var i = 0; i < tags.length; i++){
                              if($.inArray( tags[i].id.toString(), tagInput.val()) >= 0)
                              {
                                  tagInput.find('option[value="'+tags[i].id.toString()+'"]').remove();
                                  tagInput.trigger("change");
                              }

                              var tagChilds = tags[i].childs;
                              for(var j = 0; j < tagChilds.length; j++){
                                  if($.inArray( tagChilds[j].id.toString(), tagInput.val()) >= 0) {
                                      tagInput.find('option[value="'+tagChilds[j].id.toString()+'"]').remove();
                                      tagInput.trigger("change");
                                  }
                              }

                          }
                      }
                  };

                  Kacana.ajax.tag.getGroupTag(groupTagId, callBack, errorCallBack);

            },
            parseProductTagTemplate: function(repo){
                if (repo.loading) return repo.text;
                var markup = '<div>'+repo.name+'</div>';
                return markup;
            },
            parseProductTagSelection: function(repo){
                return repo.name || repo.text;
            },
            addImageToProperties: function(dataImage){
                var image = '<div class="col-sm-4 wraper-image margin-bottom" data-id="'+dataImage.id+'">';
                image +=        '<img class="img-responsive" src="'+dataImage.image+'">';
                image +=    '</div>';
                $('#modal-add-image-product-properties .modal-body .row').prepend(image);
            },
            removeImageFromProperties: function (id) {
                var blockModalProperties = $('#modal-add-image-product-properties .modal-body .row');
                var blockProperties = $('#form-edit-product .list-product-property');

                blockModalProperties.find('.wraper-image[data-id="'+id+'"]').remove();

                blockProperties.find('.row').each(function () {
                    var input = $(this).find('.wrapper-properties-image input');
                    if(parseInt(input.val()) == id)
                    {
                        input.val('');
                        input.parents('.form-group').find('button.btn').removeClass('btn-success').addClass('btn-primary').html('<i class="fa fa-plus"></i> hình ảnh');
                    }
                });
            },
            limitColor: function(){
            },
            updateProductImageType: function(){
                var data = {};
                var btnClick = $(this);
                var productId = $('#productId').val();
                var imageWrap = $(this).parents('.product-image-item');
                var imageId = imageWrap.data('id');
                var imageType = imageWrap.data('type');
                var callBack = false;
                var errorCallBack = function(e){
                    console.log(e);
                };

                if($(this).attr('href') == '#deleteImage')
                {
                    data = {
                        productId : productId,
                        imageId: imageId,
                        action: 'deleteImage'
                    };

                    callBack = function (data){
                        if(data.ok)
                        {
                            $('.product-image-item[data-id="'+imageId+'"]').remove();
                            Kacana.product.detail.removeImageFromProperties(imageId);
                            Kacana.product.detail.sortProductGallery();
                        }
                    }
                }
                else if($(this).attr('href') == '#setPrimaryImage')
                {
                    data = {
                        productId : productId,
                        imageId: imageId,
                        action: 'setPrimaryImage'
                    };
                    callBack = function(data){
                      if(data.ok){
                          $('.product-image-item[data-type="1"]').attr('data-type',3).find('a[href="#setPrimaryImage"]').removeClass('active');
                          imageWrap.attr('data-type', 1);
                          btnClick.toggleClass('active').siblings().removeClass('active');
                      }
                    };
                }
                else if($(this).attr('href') == '#setSlideImage')
                {
                    data = {
                        productId : productId,
                        imageId: imageId,
                        action: 'setSlideImage'
                    };
                    callBack = function(data){
                        if(data.ok){
                            btnClick.toggleClass('active');
                            imageWrap.data('type', data.data.type);
                            if(data.data.type == 2)
                                Kacana.product.detail.addImageToProperties(data.data);
                            else if(data.data.type == 3)
                                Kacana.product.detail.removeImageFromProperties(data.data.id);
                        }
                    };
                }

                Kacana.ajax.product.updateProductImageType(data, callBack, errorCallBack);
            },
            uploadMainImage: function(){
                var $detailPage = $('#product-image-main');
                var $buttonUpload = $('#banner-upload-btn');
                var uploadHost = '/upload/chunk';
                var uploadLimit = 100;
                var container = 'image-main-product-upload-container';
                var dropElement = 'undefined';
                var browseButton = 'select-file-main-image';
                var multiSelection = false;
                var filters = [
                    {title : 'Image Files', extensions : 'jpg,jpeg,gif,png,bmp'}
                ];
                $detailPage.find('.banner-cropper-preview').hide();
                var uploader = Kacana.uploader.init(uploadHost,container,dropElement,browseButton,multiSelection,uploadLimit,filters);

                uploader.bind('FilesAdded', function(up, files) {

                    up.refresh(); // Reposition Flash/Silverlight

                    try{
                        var reader = new FileReader();

                        var $image = $detailPage.find('.banner-cropper-preview');

                        reader.onload = function (e) {
                            if(e.target.result.indexOf("data:image") >= 0){
                                $image.attr('src', e.target.result);
                                $detailPage.find('.banner-cropper-preview').show();
                                var options = {
                                    aspectRatio: 10/10,
                                    zoomable: true,
                                    minCropBoxHeight: 80,
                                    minCropBoxWidth: 80
                                };

                                $image.cropper('destroy');
                                $image.cropper(options);

                                $buttonUpload.removeClass('hide');
                            }
                        };

                        reader.readAsDataURL(files[0].getNative());

                    }catch (err){
                        //
                    }

                    /* hack 1: run the callback after files are added... used to init draggables */
                    if (typeof window.uploaderFilesAddedCallback == 'function')
                        window.uploaderFilesAddedCallback(files);
                });

                uploader.bind('UploadProgress', function(up, file) {

                    $buttonUpload.find('span').text('Uploading... ('+file.percent+'%)');
                });

                uploader.bind('UploadComplete', function(up, file) {

                    $buttonUpload.addClass('btn-success').find('span').text('Success!');
                });

                uploader.bind('Error', function(up, err) {
                    console.log(err);

                    $buttonUpload.addClass('btn-danger').find('span').text('Error!: '+err.message);
                });

                $buttonUpload.on('click', function(){
                    var $image = $detailPage.find('.banner-cropper-preview');
                    var canvas = $image.cropper("getCroppedCanvas");

                    var dataUrl = canvas.toDataURL("image/jpeg");

                    $image.attr('src', dataUrl);
                    $image.cropper('destroy');
                    $detailPage.find('.org-logo').remove();//remove old logo
                    $image.addClass('org-logo');

                    var file = new mOxie.File(null, dataUrl);
                    file.name = "logo.jpg"; // you need to give it a name here (required)

                    //remove old file
                    $.each(uploader.files, function(i,v){
                        uploader.removeFile(uploader.files[0]);
                    });

                    uploader.addFile(file);
                    uploader.start();

                    $buttonUpload.find('span').text('Uploading... ');
                    return false;
                });

                $('#banner-remove-btn').on('click', function(){
                    var sendData = {
                        name: '',
                        productId: $('#productId').val()
                    };
                    var callBack = function(data){

                        if(data.ok){
                            location.reload();
                        }
                    };

                    var errorCallBack = function(){

                    };

                    Kacana.ajax.product.updateImage(sendData, callBack, errorCallBack);
                });

                uploader.bind('FileUploaded', function(up, file, info) {
                    var data = jQuery.parseJSON(info.response);

                    if(data.ok)
                    {
                        var imageName = data.name;
                        var sendData = {
                            name: data.name,
                            productId: $('#productId').val()
                        };

                        var callBack = function(data){

                            if(data.ok){
                                location.reload();
                            }
                        };

                        var errorCallBack = function(){

                        };

                        Kacana.ajax.product.updateImage(sendData, callBack, errorCallBack);

                    }
                });
            },
            uploadImage: function(){
                var $detailPage = $('#product-image-detail');
                var $buttonUpload = $('#image-upload-btn');
                var uploadHost = '/upload/chunk';
                var uploadLimit = 100;
                var container = 'image-upload-container';
                var dropElement = 'undefined';
                var browseButton = 'select-file-product-image';
                var multiSelection = true;
                var filters = [
                    {title : 'Image Files', extensions : 'jpg,jpeg,gif,png,bmp'}
                ];

                var uploader = Kacana.uploader.init(uploadHost,container,dropElement,browseButton,multiSelection,uploadLimit,filters);

                uploader.bind('FilesAdded', function(up, files) {
                    up.refresh(); // Reposition Flash/Silverlight

                    try{
                        $.each(files, function(i, file) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                if(e.target.result.indexOf("data:image") >= 0){

                                    var $image = '<div id="add_new_image_'+file.id+'" class="product-image-item" data-type="3" data-id="0">';
                                    $image +=       '<img class="product-image" src="'+e.target.result+'">';
                                    $image +=       '<div class="product-image-tool">';
                                    $image +=           '<a class="active pull-left" href="#setSlideImage"><i class="ion-ios-circle-filled"></i></a>';
                                    $image +=           '<a class="pull-right" href="#deleteImage"><i class="ion-trash-b"></i></a>';
                                    $image +=       '</div>';
                                    $image +=       '<div class="product-image-uploading">';
                                    $image +=           '<div class="overlay-iploading" >';
                                    $image +=               '<i class="fa fa-refresh fa-spin" ></i>';
                                    $image +=           '</div>';
                                    $image +=       '</div>';
                                    $image +=   '</div>';
                                    $('.list-product-image').prepend($image);
                                    up.start();
                                }
                            };

                            reader.readAsDataURL(file.getNative());
                        });

                    }catch (err){
                        //
                    }
                });

                uploader.bind('FileUploaded', function(up, file, info) {
                    var data = jQuery.parseJSON(info.response);

                    if(data.ok)
                    {
                        var sendData = {
                            name: data.name,
                            productId: $('#productId').val(),
                            type: 2
                        };

                        var callBack = function(data){

                            var $imageWrap = $('.list-product-image #add_new_image_'+file.id);

                            if(data.ok){
                                $imageWrap.attr('data-id',data.data.id);
                                $imageWrap.find('.product-image-uploading').remove();
                                Kacana.product.detail.addImageToProperties(data.data);
                                Kacana.product.detail.sortProductGallery();
                            }
                            else{
                                $imageWrap.remove();
                            }
                        };

                        var errorCallBack = function(){

                        };

                        Kacana.ajax.product.addProductImage(sendData, callBack, errorCallBack);

                    }
                });
            }
        },
        imProduct:{
            init: function () {
                Kacana.product.imProduct.setupDataTableForImportProduct();
                Kacana.product.imProduct.bindEvent();
            },
            bindEvent: function () {
                Kacana.product.imProduct.barcodeScanner();
                $('body').on('click', 'a[href="#edit-import-product"]', Kacana.product.imProduct.editImportProduct)
            },
            editImportProduct: function () {
                if($(this).find('i').hasClass('fa-check'))
                {
                    Kacana.product.imProduct.updateImportRow($(this));
                }
                else
                {
                    var row = $(this).parents('tr');
                    row.find('input').removeClass('hidden');
                    row.find('.label-product-quantity, .label-product-price').addClass('hidden');
                    $(this).find('i').removeClass('fa-pencil').addClass('fa-check');
                }
            },
            updateImportRow: function (button) {
                var id = button.data('id');
                var row = button.parents('tr');

                var quantity = row.find('input[name="quantity-import"]').val();
                var currentQuantity = row.find('input[name="quantity-import"]').data('value');
                var price = row.find('input[name="price-import"]').val();

                row.find('input').addClass('hidden');
                row.find('.label-product-quantity, .label-product-price').removeClass('hidden');
                row.find('.label-product-quantity').html(quantity);
                row.find('.label-product-price').html(Kacana.utils.formatCurrency(price));
                button.find('i').removeClass('fa-check').addClass('fa-pencil');

                var callBack = function(data){
                    if(data.ok){
                        console.log('đã cập nhật dữ liệu!')
                    }
                    else{
                        swal(
                            'Lỗi!',
                            'detect product quantity, Please check product quantity!',
                            'error'
                        );
                    }
                };

                var errorCallBack = function(){

                };

                Kacana.ajax.product.updateImport(id, currentQuantity, quantity, price, callBack, errorCallBack);
            },
            barcodeScanner: function () {

                $(document).scannerDetection({
                    timeBeforeScanTest: 200, // wait for the next character for upto 200ms
                    avgTimeByChar: 40, // it's not a barcode if a character takes longer than 100ms
                    preventDefault: false,
                    endChar: [13],
                    onComplete: function(barcode, qty){
                        console.log('barcode: '+barcode);
                        var propertyId = barcode.substring(0, 11);

                        var modal = $('#modal-import-product-by-barcode');
                        console.log('barcode: '+barcode);
                        Kacana.product.imProduct.importProductBarcode(propertyId);

                        console.log('barcode: '+barcode);
                    }
                });
            },
            importProductBarcode: function (barcode) {
                console.log('jhjgjgjg');
                var propertyId = barcode;
                var quantity = 1;
                var price = 0;

                var callBack = function(data){
                    if(data.ok){
                        console.log('đã nhập sản phẩm!');
                        var table = $('#importProductTable').DataTable();

                        var rowNode = table.row.add( [ data.data.id, data.property.product.name, data.property.galleryObject.image, 0, 1, data.user.name, data.property.product.id, data.property.id, data.data.created_at, data.data.updated_at ] ).draw().node();
                    }
                };

                var errorCallBack = function(){

                };

                Kacana.ajax.product.importProduct(propertyId, quantity, price, callBack, errorCallBack);

            },
            getProductInfoByPropertyId:function (propertyId) {
                var modal = $('#modal-import-product-by-barcode');
                var template = $('#template-import-product-by-barcode');

                var callBack = function(data){
                    if(data.ok){
                        var item = data.data;
                        var imageProduct = '';
                        if(item.product_gallery_id){
                            imageProduct = item.galleryObject.image;
                        }
                        else
                        {
                            imageProduct = item.productObject.image;
                        }

                        item.imageProduct = imageProduct;
                        var templateGenerate = $.tmpl(template, {'item': item});
                        modal.find('.modal-body').empty().append(templateGenerate);
                        modal.modal();

                    }
                };

                var errorCallBack = function(){

                };

                Kacana.ajax.product.getProductInfoByPropertyId(propertyId, callBack, errorCallBack);
            },
            setupDataTableForImportProduct: function(){
                var $formInline = $('.form-inline');
                var element = '#importProductTable';
                $(element).parents('.box').css('overflow', 'auto');
                var columns = [
                    {
                        'title': 'id',
                        'visible': false
                    },
                    {
                        'title': 'sản phẩm'
                    },
                    {
                        'title': 'hình',
                        'sortable':false,
                        'render': function ( data, type, full, meta ) {
                            return '<img style="width: 50px" class="img-responsive" src="//image.kacana.vn'+data+'" />';
                        }
                    },
                    {
                        'title': 'giá nhập',
                        'render': function ( data, type, full, meta ) {
                            return '<p class="label-product-price" >'+ Kacana.utils.formatCurrency(data) + '</p><input style="width: 80px;" type="text" value="'+data+'" name="price-import" class="hidden" >';
                        }
                    },
                    {
                        'title': 'số lượng',
                        'render': function ( data, type, full, meta ) {

                            return '<p class="label-product-quantity">'+ data + '</p><input data-value="'+data+'" style="width: 80px;" type="number" value="'+data+'" name="quantity-import" class="hidden" >';
                        }
                    },
                    {
                        'title': 'người nhập'
                    },
                    {
                        'title': 'product_id',
                        'visible': false
                    },
                    {
                        'title': 'property_id',
                        'visible': false
                    },
                    {
                        'title': 'created',
                        'width':'12%',
                        'render': function ( data, type, full, meta ) {
                            return data ? data.slice(0, -8) +'<br><b>' + data.slice(11, 19)+'</b>' : '';
                        }
                    },
                    {
                        'title': 'updated',
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
                            return '<a data-id="'+full[0]+'" href="#edit-import-product" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>';
                        }
                    }
                ];

                var addParamsCallBack = function(oData){
                    //search name or email
                    //oData.columns[2].search.orWhere = true;
                    //oData.columns[3].search.orWhere = true;
                };

                var cacheLoadedCallBack = function(oData){
                    $formInline.find('input[name="name"]').val(oData.columns[0].search.search);
                    $formInline.find('select[name="user"]').val(oData.columns[1].search.search);
                    $formInline.find('select[name="productId"]').val(oData.columns[2].search.search);
                    $formInline.find('select[name="propertyId"]').val(oData.columns[3].search.search);
                };

                var datatable = Kacana.datatable.importProduct(element, columns, addParamsCallBack, cacheLoadedCallBack);

                $formInline.off('submit')
                    .on('submit', function (e) {
                        e.preventDefault();

                        var api = datatable.api(true);

                        var name = $formInline.find('select[name="name"]').val();
                        var user = $formInline.find('select[name="user"]').val();
                        var productId = $formInline.find('select[name="productId"]').val();
                        var propertyId = $formInline.find('input[name="propertyId"]').val();

                        api.column(0).search(name)
                            .column(1).search(user)
                            .column(2).search(productId, true)
                            .column(3).search(propertyId, true);

                        api.draw();
                    });
            },
        }
  }
};

$.extend(true, Kacana, productPackage);