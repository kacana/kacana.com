var productPackage = {
  product:{
      init: function(){
          Kacana.product.listProducts.init();
      },
      listProducts: {
          init: function(){
            Kacana.product.listProducts.setupDatatableForProduct();
          },
          setupDatatableForProduct: function(){
              var $formInline = $('.form-inline');
              var element = '#productTable';
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
                      'title': 'price'
                  },
                  {
                      'title': 'sell price'
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
                  $formInline.find('input[name="search"]').val(oData.columns[1].search.search);
                  $formInline.find('select[name="searchStatus"]').val(oData.columns[2].search.search);
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
                          .column(2).search(status, true);

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
                Kacana.config.initSummerNote();
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

                $page.on('click', 'button[href="#remove-product-property"]', function(){
                    $(this).closest('.row').remove();
                    Kacana.product.detail.limitColor();
                    return false;
                });

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

                $page.find('#tag_search_product').select2(
                    {
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
                    }
                );

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
                $page.on('click','#add-group-tag-to-product-tag', Kacana.product.detail.addGroupTagToProductTag);
                $page.on('click','#remove-group-tag-from-product-tag', Kacana.product.detail.removeGroupTagFromProductTag);

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
                var groupTagId = $(this).parents('.form-group').find('select').val();

                var errorCallBack = function(e){
                    console.log(e);
                };
                var callBack = function (data){
                    console.log(data);
                    var tagInput = $('#tag_search_product');
                    if(data.ok)
                    {
                        var tags = data.data.childs;
                        for(var i = 0; i < tags.length; i++){
                            if($.inArray( tags[i].id.toString(), tagInput.val()) == -1)
                                tagInput.append('<option value="'+tags[i].id.toString()+'" selected >'+tags[i].name+'</option>').trigger("change");
                        }
                    }
                };

                Kacana.ajax.tag.getGroupTag(groupTagId, callBack, errorCallBack);

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
                          var tags = data.data.childs;
                          for(var i = 0; i < tags.length; i++){
                              if($.inArray( tags[i].id.toString(), tagInput.val()) >= 0)
                              {
                                  tagInput.find('option[value="'+tags[i].id.toString()+'"]').remove();
                                  tagInput.trigger("change");
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
                var $page = $('#product-detail-page');
                var colorChoose = [];
                $page.find('.properties-color').each(function(){
                    if(!$(this).hasClass('new-property'))
                        colorChoose.push($(this).val());
                });

                $page.find('.properties-color').each(function(){
                    var colorId = $(this).val();
                    var checkAvailableColor = false;
                    var checkNew = $(this).hasClass('new-property');
                    $(this).find('option').each(function(){
                       var value = $(this).attr('value');
                        if((value != colorId || checkNew) && jQuery.inArray(value, colorChoose) >= 0)
                            $(this).hide()
                        else
                        {
                            $(this).show();
                            if(checkNew)
                                $(this).attr('selected', true);
                            checkAvailableColor = true;
                        }
                    });

                    if(!checkAvailableColor)
                    {
                        swal({
                            title: 'Lỗi rồi!',
                            text: 'Opp! vui lòng thêm tag color tại quản lý tag color',
                            type: 'error',
                            confirmButtonText: 'Cool'
                        });
                        $(this).closest('.row').remove();
                        return false;
                    }
                    else
                        $(this).removeClass('new-property');
                });
                var sizeNumber = 0;
                $page.find('.select-size').each(function(){
                   $(this).attr('name', 'size['+sizeNumber+'][]');
                    sizeNumber++;
                });

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
                                    $image +=           '<a class="active" href="#setSlideImage"><i class="fa fa-star"></i></a>';
                                    $image +=           '<a href="#deleteImage"><i class="fa fa-trash"></i></a>';
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
          branch:{
              init: function(){
                  Kacana.product.branch.listBranch();
                  Kacana.product.branch.showEditBranchForm();
                  Kacana.product.branch.editBranch();
                  Kacana.product.branch.showEditBranchForm();
                  Kacana.product.branch.setStatusBranch();
              },
              listBranch: function(){
                  var columns = ['id', 'name', 'image', 'status', 'created', 'updated', 'action']
                  var btable = Kacana.datatable.init('table', columns, '/branch/getBranch');

                    $("#search-form").on('submit', function(e){
                        btable.search($("#search-name").val()).draw() ;
                        e.preventDefault();
                    })
              },
              createBranch: function(){
                  $("#btn-create").attr('disabled', true);
                  var form_data = new FormData();
                  var file_image = $('#image').prop("files")[0];
                  var other_data = $("#form-create-branch").serialize();
                  form_data.append('image', file_image);
                  var callBack = function(data){
                      window.location.reload();
                  }
                  var errorCallBack = function(data){
                      json_result = JSON.parse(data.responseText);
                      if(typeof(json_result['image'])!=''){
                          $("#error-image").html(json_result['image']);
                      }

                      if(typeof(json_result['name'])!=''){
                          $("#error-name").html(json_result['name']);
                      }
                      $("#btn-create").attr('disabled', false);
                  };
                   Kacana.ajax.branch.createBranch(other_data, form_data, callBack, errorCallBack);
              },
              showEditBranchForm: function(idBranch){
                  var callBack = function(data){
                      $("#editModal").html(data);
                      $("#editModal").modal('show');
                  };
                  var errorCallBack = function(){};
                  Kacana.ajax.branch.showEditBranchForm(idBranch, callBack, errorCallBack);
              },
              editBranch: function(){
                  var form_data = new FormData();
                  var file_image = $('#image').prop("files")[0];
                  var other_data = $("#form-create-branch").serialize();
                  form_data.append('image', file_image);
                  var callBack = function(data){
                      window.location.reload();
                  }
                  var errorCallBack = function(data){
                      json_result = JSON.parse(data.responseText);
                      if(typeof(json_result['image'])!=''){
                          $("#error-image").html(json_result['image']);
                      }

                      if(typeof(json_result['name'])!=''){
                          $("#error-name").html(json_result['name']);
                      }
                      $("#btn-create").attr('disabled', false);
                  };
                  Kacana.ajax.branch.editBranch(other_data, form_data, callBack, errorCallBack);
              },
              setStatusBranch: function(id, status){
                  var callBack = function(data){
                      window.location.reload();
                  };
                  var errorCallBack = function(){};
                  Kacana.ajax.branch.setStatusBranch(id, status, callBack, errorCallBack);
              },
              removeBranch: function(idBranch){
                  $('#confirm').modal('show');
                  var callBack = function(data){
                      window.location.reload();
                  };
                  var errorCallBack = function(){};
                  $('#delete').click(function (e) {
                      Kacana.ajax.branch.removeBranch(idBranch, callBack, errorCallBack);
                  });
              }
      }
  }
};

$.extend(true, Kacana, productPackage);