var tagPackage = {
  tag:{
      init: function(){
        Kacana.tag.listTag.init();
        Kacana.tag.relationTags();
      },
      listTag: {
        init: function(){
            var wrapContent = $('#content-tag-system');

            Kacana.tag.listTag.setupDatatableForTag();
            wrapContent.on('click', '.create-tag-btn', Kacana.tag.listTag.createTag);
            wrapContent.on('click', 'a[href="#edit-tag-btn"]', Kacana.tag.listTag.editTag);
        },
        createTag: function(){
            swal({
                title: 'Create Tag',
                html: '<input id="fTagName" autofocus placeholder="tag name" class="swal2-input" autofocus="">',
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonText: 'Create',
                preConfirm: function() {
                    return new Promise(function(resolve, reject) {
                        var tagName = $('#fTagName').val();
                        if(!tagName)
                            reject('please input tag name!');
                        else
                        {
                            var callback = function(data){
                                resolve(data);
                                $('.form-inline').find('button[type="reset"]').click();
                                $('.form-inline').find('button[type="submit"]').click();
                            };

                            var errorCallback = function(){
                                // do something here if error
                            };

                            Kacana.ajax.tag.createTag(tagName, callback, errorCallback);
                        }
                    });
                },
                onOpen: function(){
                    setTimeout(function () {
                        $('#fTagName').focus();
                    }, 300);
                    Kacana.tag.listTag.searchTag();
                }
            }).then(function(data) {
                if(data.ok){
                    swal({
                        type: 'success',
                        title: 'created',
                        html:'<b> ' + data.data.name +'</b>'
                    });
                }
                else
                {
                    swal({
                        title: 'Error!',
                        text: 'Opp!something wrong on processing.',
                        type: 'error',
                        confirmButtonText: 'Cool'
                    });
                }
            });
            $('body').on('keyup', '#fTagName', function (e) {
                var keyCode = e.keyCode || e.which;
                if(keyCode == 13)
                {
                    swal.clickConfirm();
                }
            });
        },
        searchTag: function(){
            $('#fTagName').autocomplete({
                source: function( request, response ) {
                    var callback = function(data){
                        if(data.ok)
                            response( data.items );
                        else
                            swal({
                                title: 'Error!',
                                text: 'Opp!something wrong on processing.',
                                type: 'error',
                                confirmButtonText: 'Cool'
                            });
                    };

                    var errorCallback = function(){
                        // do something here if error
                    };
                    Kacana.ajax.tag.searchTag(request.term, callback, errorCallback);
                },
                minLength: 2,
                select: function( event, ui ) {
                    console.log( "Selected: " + ui.item.value + " aka " + ui.item.id );
                    window.open('/tag/fullEditTag/'+ui.item.id, '_blank');
                    return '';
                }
            }).autocomplete( "widget" ).addClass("search-tag");
        },
        editTag: function(){
            var id = $(this).data('id');

            var callbackGetTag = function(data){
                Kacana.utils.closeLoading();
                if(data.ok)
                {
                    data = data.items;
                    swal({
                        title: 'Edit Tag',
                        html: '<input id="fTagId" placeholder="tag id" disabled="" class="swal2-input" value="'+data.id+'" autofocus="">'+'<input autofocus id="fTagName" placeholder="tag name" class="swal2-input" value="'+data.name+'" autofocus="">'+'<textarea autofocus id="fTagShortDescription" placeholder="tag short description" class="swal2-textarea" >'+data.short_desc+'</textarea>',
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        confirmButtonText: 'Change',
                        preConfirm: function() {
                            return new Promise(function(resolve, reject) {
                                var tagName = $('#fTagName').val();
                                var shortTagDescription = $('#fTagShortDescription').val();
                                if(shortTagDescription == 'null' || shortTagDescription == 'NULL')
                                    shortTagDescription = '';
                                if(!tagName)
                                    reject('please input tag name!');
                                else
                                {
                                    var callback = function(data){
                                        resolve(data);
                                        $('.form-inline').find('button[type="reset"]').click();
                                        $('.form-inline').find('button[type="submit"]').click();
                                    };

                                    var errorCallback = function(){
                                        // do something here if error
                                    };
                                    Kacana.ajax.tag.editTag(id, tagName, shortTagDescription, callback, errorCallback);
                                }
                            });
                        }
                    }).then(function(data) {
                        if(data.ok){
                            swal({
                                type: 'success',
                                title: 'edited',
                                html: ' Updated Tag: '+ data.data.name
                            });
                        }
                        else
                        {
                            swal({
                                title: 'Error!',
                                text: 'Opp!something wrong on processing.',
                                type: 'error',
                                confirmButtonText: 'Cool'
                            });
                        }
                    });
                }
                else{
                    swal({
                        title: 'Error!',
                        text: 'Opp!something wrong on processing.',
                        type: 'error',
                        confirmButtonText: 'Cool'
                    });
                }

            };

            var errorCallbackGetTag = function(){
                // do something here if error
            };
            Kacana.utils.loading();
            Kacana.ajax.tag.getTag(id, callbackGetTag, errorCallbackGetTag);
        },
        setupDatatableForTag: function(){
        var $formInline = $('.form-inline');
        var element = '#tagTable';
        $(element).parents('.box').css('overflow', 'auto');
        var columns = [
          {
              'title': 'ID',
              'width':'5%'
          },
          {
              'title': 'Name'
          },
          {
              'title': 'Status',
          },
          {
              'title': 'Created',
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
                    return '<a href="#edit-tag-btn" data-id="'+full[0]+'" data-name="'+full[1]+'" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>';
                }
            },
          {
              'width':'4%',
              'class':'center',
              'sortable':false,
              'render': function ( data, type, full, meta ) {
                  return '<a href="/tag/fullEditTag/'+full[0]+'" class="btn btn-default btn-xs"><i class="fa fa-pencil-square-o"></i></a>';
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

        var datatable = Kacana.datatable.tag(element, columns, addParamsCallBack, cacheLoadedCallBack);

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
      relationTags:{
          init: function () {
              Kacana.tag.relationTags.initTreeTags();
              Kacana.tag.relationTags.collectionTag();

              var wrapContent = $('#content-tag-relation');

              wrapContent.on('click', '.create-tag-btn', Kacana.tag.relationTags.popupCreateTagWithType);
              wrapContent.on('click', 'a[href="#edit-tag-btn"]', Kacana.tag.relationTags.editTagWithType);
              wrapContent.on('click', 'a[href="#delete-tag-btn"]', Kacana.tag.relationTags.deleteTagWithType);
              wrapContent.on('click', 'a[href="#add-image-tag"]', Kacana.tag.relationTags.addImageTagWithType);
              wrapContent.on('click', 'a[href="#show-product-tag-btn"]', Kacana.tag.relationTags.showProductTag);
              $('#modal-add-image-tag').on('click', 'button#banner-remove-btn', Kacana.tag.relationTags.removeImageTagWithType);

          },
          createTagWithType: function (tagName, parentId, id, callBackPopup) {

              var typeId = $('#content-tag-relation').find('#create-tag-btn').data('type-id');

              var callback = function(data){
                  callBackPopup(data);
                  var $tagsElement = $('#tree-tags');
                  var newNode = data.data;
                  if(id)
                  {
                      var nodeId  = id+'_'+parentId+'_'+typeId;
                      var node = $tagsElement.tree('getNodeById', nodeId);
                      var order = 0;
                      if(node.getData())
                          order = node.getData().length + 1;

                      $tagsElement.tree(
                          'appendNode',
                          {
                              name: newNode.name,
                              id: newNode.id+'_'+id+'_'+typeId,
                              'tag_type_id': typeId,
                              'tag_order': order,
                              'short_desc':'',
                              'image': '',
                              'child_count': 0,
                              'child_id': newNode.id,
                              'parent_id': id,
                              'product_count': '?'
                          },
                          node
                      );

                      $tagsElement.tree(
                          'updateNode',
                          node,
                          {
                              'child_count': node.children.length
                          }
                      );
                  }
                  else {

                      $tagsElement.tree(
                          'appendNode',
                          {
                              name: newNode.name,
                              id: newNode.id+'_0_'+typeId,
                              'tag_type_id': typeId,
                              'short_desc':'',
                              'image': '',
                              'child_count': 0,
                              'child_id': newNode.id,
                              'parent_id': 0,
                              'product_count': '?'
                          }
                      );
                  }

              };

              var errorCallback = function(){
                  // do something here if error
              };
              Kacana.ajax.tag.createTagWithType(tagName, typeId, id, callback, errorCallback);
          },
          popupCreateTagWithType: function(){
              var parentId = $(this).data('parent-id');
              var id = $(this).data('id');

              swal({
                  title: 'Create Tag',
                  html: '<input id="fTagName" autofocus placeholder="tag name" class="swal2-input" autofocus="">',
                  showCancelButton: true,
                  showLoaderOnConfirm: true,
                  confirmButtonText: 'Create',
                  preConfirm: function() {

                      return new Promise(function(resolve, reject) {
                          var tagName = $('#fTagName').val();
                          if(!tagName)
                              reject('please input tag name!');
                          else
                          {
                              var callBack = function (data) {
                                  resolve(data);
                              };
                              Kacana.tag.relationTags.createTagWithType(tagName, parentId, id,  callBack);
                          }
                      });
                  },
                  onOpen: function(){
                      setTimeout(function () {
                          $('#fTagName').focus();
                      }, 300);

                      callBackPopup = function (data) {
                          if(data.ok){
                              swal({
                                  type: 'success',
                                  title: 'added',
                                  html:'<b> ' + data.data.name +'</b>'
                              });
                          }
                          else
                          {
                              swal({
                                  title: 'Error!',
                                  text: 'Opp!something wrong on processing.',
                                  type: 'error',
                                  confirmButtonText: 'Cool'
                              });
                          }
                      };

                      Kacana.tag.relationTags.searchTag(parentId, id, callBackPopup);
                  }
              }).then(function(data) {
                  if(data.ok){
                      swal({
                          type: 'success',
                          title: 'created',
                          html:'<b> ' + data.data.name +'</b>'
                      });
                  }
                  else
                  {
                      swal({
                          title: 'Error!',
                          text: 'Opp!something wrong on processing.',
                          type: 'error',
                          confirmButtonText: 'Cool'
                      });
                  }
              });

              $('body').on('keyup', '#fTagName', function (e) {
                  var keyCode = e.keyCode || e.which;
                  if(keyCode == 13)
                  {
                      swal.clickConfirm();
                  }
              });
          },
          initTreeTags: function(){
              var tagsElement = $("#tree-tags");

              tagsElement.tree({
                  autoOpen: false,
                  dragAndDrop: true,
                  saveState: true,
                  useContextMenu: false,
                  closedIcon: $('<i class="fa fa-plus-square-o"></i>'),
                  openedIcon: $('<i class="fa fa-minus-square-o"></i>'),
                  onCreateLi: function(node, $li){
                      var countChild = node.child_count;
                      var countProduct = node.product_count;
                      var nodeid = node.child_id;
                      var parentId = node.parent_id;

                      var str = '<span class="badge bg-gray childleft"><a href="javascript:void(0)"> '+countChild+' childs </a></span>';
                      str += '<span class="badge bg-gray childleft"><a data-id="'+nodeid+'" href="#show-product-tag-btn"> <b>'+countProduct+'</b> sản phẩm </a></span>';
                      str += ' <span><a class="btn bg-light-blue-active btn-xs create-tag-btn" data-parent-id="'+parentId+'" data-id="'+nodeid+'"   title="add tag" href="#"><i class="fa fa-plus"></i></a></span>';
                      str += ' <span><a  class="btn bg-light-blue-active btn-xs" data-parent-id="'+parentId+'" data-name="'+node.name+'" data-id="'+nodeid+'" href="#add-image-tag" title="image tag" id="_tag_'+nodeid+'_'+parentId+'" data-url="'+node.image+'"><i class="fa fa-photo"></i></a></span>';
                      str += ' <span><a href="#edit-tag-btn" data-name="'+node.name+'" data-id="'+nodeid+'" data-parent-id="'+parentId+'" class="btn bg-light-blue-active btn-xs" title="edit tag"><i class="fa fa-pencil"></i></a></span>';
                      str += ' <span><a href="/tag/fullEditTag/'+nodeid+'" target="_blank" class="btn bg-light-blue-active btn-xs" title="full edit tag"><i class="fa fa-pencil-square-o"></i></a></span>';
                      str += ' <span><a href="#delete-tag-btn" data-parent-id="'+parentId+'" data-id="'+nodeid+'" class="btn bg-red btn-xs" title="remove tag" ><i class="fa fa-remove"></i></a></span>';
                      $li.find('.jqtree-title').after(str);
                  },
                  onLoading: function(is_loading, node, $el){
                        if(is_loading)
                        {
                            Kacana.utils.loading(tagsElement);
                        }
                        else
                        {
                            Kacana.utils.closeLoading();
                        }
                  }
              });

              tagsElement.bind(
                  'tree.move',
                  function(event) {
                      console.log('moved_node', event.move_info.moved_node);
                      console.log('target_node', event.move_info.target_node);
                      console.log('position', event.move_info.position);
                      console.log('previous_parent', event.move_info.previous_parent);

                      var movedTagId = event.move_info.moved_node.child_id;
                      var targetTagId = event.move_info.target_node.child_id;
                      var position = event.move_info.position;
                      var movedTagParentId = event.move_info.previous_parent.child_id;
                      var typeId = $('#content-tag-relation').find('#create-tag-btn').data('type-id');

                      var callBack = function(data) {
                          if (data.ok === 0) {
                              event.preventDefault();
                              console.log('Move failed!');
                          } else {

                          }
                      };

                      var errorCallBack = function() {

                      };
                      Kacana.ajax.tag.processTagMove(movedTagId, targetTagId, position, movedTagParentId, typeId, callBack, errorCallBack);
                  }
              );
          },
          editTagWithType: function(){
              var typeId = $('#content-tag-relation').find('#create-tag-btn').data('type-id');
              var id = $(this).data('id');
              var parentId = $(this).data('parent-id');

              var callbackGetTag = function(data){
                  Kacana.utils.closeLoading();
                  if(data.ok)
                  {
                      data = data.items;
                      swal({
                          title: 'Edit Tag',
                          html: '<input id="fTagId" placeholder="tag id" disabled="" class="swal2-input" value="'+data.id+'" autofocus="">'+'<input autofocus id="fTagName" placeholder="tag name" class="swal2-input" value="'+data.name+'" autofocus="">'+'<textarea autofocus id="fTagShortDescription" placeholder="tag short description" class="swal2-textarea" >'+data.short_desc+'</textarea>',
                          showCancelButton: true,
                          showLoaderOnConfirm: true,
                          confirmButtonText: 'Change',
                          preConfirm: function() {
                              return new Promise(function(resolve, reject) {
                                  var tagName = $('#fTagName').val();
                                  var shortTagDescription = $('#fTagShortDescription').val();
                                  if(shortTagDescription == 'null' || shortTagDescription == 'NULL')
                                      shortTagDescription = '';
                                  if(!tagName)
                                      reject('please input tag name!');
                                  else
                                  {
                                      var callback = function(data){
                                          resolve(data);
                                          var $tagsElement = $('#tree-tags');

                                          var nodeId  = id+'_'+parentId+'_'+typeId;
                                          var node = $tagsElement.tree('getNodeById', nodeId);
                                          $tagsElement.tree('updateNode', node,{
                                              name: data.data.name
                                          });
                                      };

                                      var errorCallback = function(){
                                          // do something here if error
                                      };
                                      Kacana.ajax.tag.editTag(id, tagName, shortTagDescription, callback, errorCallback);
                                  }
                              });
                          }
                      }).then(function(data) {
                          if(data.ok){
                              swal({
                                  type: 'success',
                                  title: 'edited',
                                  html: ' Updated Tag: '+ data.data.name
                              });
                          }
                          else
                          {
                              swal({
                                  title: 'Error!',
                                  text: 'Opp!something wrong on processing.',
                                  type: 'error',
                                  confirmButtonText: 'Cool'
                              });
                          }
                      });
                  }
                  else{
                      swal({
                          title: 'Error!',
                          text: 'Opp!something wrong on processing.',
                          type: 'error',
                          confirmButtonText: 'Cool'
                      });
                  }

              };

              var errorCallbackGetTag = function(){
                  // do something here if error
              };
              Kacana.utils.loading();
              Kacana.ajax.tag.getTag(id, callbackGetTag, errorCallbackGetTag);
          },
          showProductTag: function(){
              var tagsElement = $("#tree-tags");
              var that = $(this);
              var tagId = $(this).data('id');
              var callback = function(data){
                  Kacana.utils.closeLoading();
                  if(data.ok)
                  {
                      that.find('b').html(data.data);
                  }
                  else{
                      swal({
                          title: 'Error!',
                          text: 'Opp!something wrong on processing.',
                          type: 'error',
                          confirmButtonText: 'Cool'
                      });
                  }

              };

              var errorCallback = function(){
                  // do something here if error
              };
              Kacana.utils.loading(tagsElement);
              Kacana.ajax.product.countSearchProductByTagId(tagId, callback, errorCallback);
          },
          deleteTagWithType: function () {
              var typeId = $('#content-tag-relation').find('#create-tag-btn').data('type-id');
              var id = $(this).data('id');
              var parentId = $(this).data('parent-id');
              var $tagsElement = $('#tree-tags');

              swal({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  type: 'warning',
                  showCancelButton: true,
                  showLoaderOnConfirm: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!',
                  preConfirm: function() {
                      return new Promise(function(resolve, reject) {
                          var callback = function(data){
                              resolve(data);
                              var $tagsElement = $('#tree-tags');
                              var nodeId  = id+'_'+parentId+'_'+typeId;
                              var node = $tagsElement.tree('getNodeById', nodeId);
                              if(parentId != 0)
                              {
                                  $tagsElement.tree(
                                      'updateNode',
                                      node.parent,
                                      {
                                          'child_count': node.parent.children.length - 1
                                      }
                                  );
                              }
                              $tagsElement.tree('removeNode', node);
                          };

                          var errorCallback = function(){
                              // do something here if error
                          };

                          Kacana.ajax.tag.removeTagRelation(id, typeId, parentId, callback, errorCallback);
                      });
                  }
              }).then(function() {
                  swal(
                      'Deleted!',
                      'Tag relation has been deleted.',
                      'success'
                  );
              })
          },
          removeImageTagWithType: function(){
              var $detailPage = $('#modal-add-image-tag');

              var sendData = {
                  name: '',
                  tagId: $detailPage.data('id'),
                  parentId: $detailPage.data('parent-id'),
                  typeId: $detailPage.data('type-id')
              };

              var callBack = function(data){

                  if(data.ok){
                      $detailPage.find('#banner-remove-btn').addClass('hide');
                      $detailPage.find('#current-baner-for-tag img').addClass('hide').attr('src', '');
                      $('#tree-tags').find('#_tag_'+$detailPage.data('id')+'_'+$detailPage.data('parent-id')).data('url','');
                  }
              };

              var errorCallBack = function(){

              };

              Kacana.ajax.tag.updateImage(sendData, callBack, errorCallBack);
          },
          addImageTagWithType: function(){
              var url = $(this).data('url');
              var id = $(this).data('id');
              var parentId = $(this).data('parent-id');
              var nameTag = $(this).data('name');
              var modalUploadImage = $('#modal-add-image-tag');
              var typeId = $('#content-tag-relation').find('#create-tag-btn').data('type-id');

              modalUploadImage.data('id', id).data('type-id', typeId).data('parent-id', parentId).find('#myModalLabel').html('add image for tag: <b>'+ nameTag+'</b>');
              modalUploadImage.find('.banner-cropper').html('<img style="width: 100%;" class="banner-cropper-preview" src="">');
              modalUploadImage.find('#banner-upload-btn').addClass('hide').find('span').text('Confirm');
              if(url !=='null' && url)
              {
                  modalUploadImage.find('#banner-remove-btn').removeClass('hide');
                  modalUploadImage.find('#current-baner-for-tag').removeClass('hide');
                  modalUploadImage.find('#current-baner-for-tag img').attr('src', '/'+url);

              }
              else{
                  modalUploadImage.find('#banner-remove-btn').addClass('hide');
                  modalUploadImage.find('#current-baner-for-tag').addClass('hide');
                  modalUploadImage.find('#current-baner-for-tag img').attr('src', '');
              }
              Kacana.tag.relationTags.uploadBannerTag();
              modalUploadImage.modal();
          },
          uploadBannerTag: function(){
              var $detailPage = $('#modal-add-image-tag');
              var $buttonUpload = $('#banner-upload-btn');
              var uploadHost = '/upload/chunk';
              var uploadLimit = 100;
              var container = 'image-upload-container';
              var dropElement = 'undefined';
              var browseButton = 'select-file';
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
                                  aspectRatio: 16/6,
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
              });

              uploader.bind('FileUploaded', function(up, file, info) {
                  var data = jQuery.parseJSON(info.response);

                  if(data.ok)
                  {
                      var imageName = data.name;
                      var sendData = {
                          name: data.name,
                          tagId: $detailPage.data('id'),
                          parentId: $detailPage.data('parent-id'),
                          typeId: $detailPage.data('type-id')
                      };

                      var callBack = function(data){

                          if(data.ok){

                              $detailPage.find('.banner-cropper').html('<img style="width: 100%;display: none;" class="banner-cropper-preview" src="">');
                              $detailPage.find('#banner-upload-btn').addClass('hide').find('span').text('Confirm');
                              $detailPage.find('#banner-remove-btn').removeClass('hide');
                              $detailPage.find('#current-baner-for-tag').removeClass('hide').find('img').attr('src', imageName);
                              $('#tree-tags').find('#_tag_'+$detailPage.data('id')+'_'+$detailPage.data('parent-id')).data('url',imageName);
                          }
                      };

                      var errorCallBack = function(){

                      };

                      Kacana.ajax.tag.updateImage(sendData, callBack, errorCallBack);

                  }
              });
          },
          searchTag: function (parentId, currentTagId, callBackPopup) {
              var typeId = $('#content-tag-relation').find('#create-tag-btn').data('type-id');
              var noResultMessage = "don't have results!";

              $('#fTagName').autocomplete({
                  source: function( request, response ) {
                      var callback = function(data){
                          if(data.ok)
                          {
                              var data = data.data;
                              if(!data.total){

                                  var result = [noResultMessage];

                                  response(result);

                              } else{
                                  var searchData = [];
                                  var results = data.results;

                                  for(var i = 0;i < results.length;i++)
                                  {
                                      searchData.push({
                                          id : results[i].id,
                                          name: results[i].name,
                                          label : results[i].name
                                      });
                                  };

                                  response( searchData );
                              }
                          }
                          else
                              swal({
                                  title: 'Error!',
                                  text: 'Opp!something wrong on processing.',
                                  type: 'error',
                                  confirmButtonText: 'Cool'
                              });
                      };

                      var errorCallback = function(){
                          // do something here if error
                      };
                      Kacana.ajax.tag.searchTagRelation(request.term, typeId, callback, errorCallback);
                  },
                  minLength: 2,
                  select: function( event, ui ) {
                      var name = ui.item.name;
                      var id = ui.item.id;

                      if(noResultMessage == ui.item.value){

                          return false;

                      }else{
                          var callback = function(data){
                              var $tagsElement = $('#tree-tags');

                                var nodeId  = currentTagId+'_'+parentId+'_'+typeId;
                                var node = $tagsElement.tree('getNodeById', nodeId);

                                $tagsElement.tree(
                                    'appendNode',
                                    {
                                        name: name,
                                        id: id+'_0_'+typeId,
                                        'tag_type_id': typeId,
                                        'short_desc':'',
                                        'image': '',
                                        'child_count': 0,
                                        'child_id': id,
                                        'parent_id': 0,
                                        'product_count': '?'
                                    },
                                    node
                                );
                              callBackPopup(data);
                          };

                          var errorCallback = function(){
                              // do something here if error
                          };
                          Kacana.ajax.tag.addTagToParent(id, currentTagId, typeId, callback, errorCallback);
                      }
                  }
              }).autocomplete( "widget" ).addClass("search-tag");
          },
          collectionTag: function(){
              var searchBox = $('#tag-search-box');
              var searchResult = $('#search-result');
              var typeId = $('#content-tag-relation').find('#create-tag-btn').data('type-id');
              var noResultMessage = "don't have results!";

              searchBox.autocomplete({
                  minLength: 3,
                  source: function( request, response ) {

                      var callBack = function(data){
                        var data = data.data;
                          if(!data.total){

                              var result = [noResultMessage];

                              response(result);

                          } else{
                              var searchData = [];
                              var results = data.results;

                              for(var i = 0;i < results.length;i++)
                              {
                                  searchData.push({
                                      id : results[i].id,
                                      name: results[i].name,
                                      label : results[i].name
                                  });
                              };

                              response( searchData );
                          }
                      };

                      var errorCallBack = function(){};

                      Kacana.ajax.tag.searchTagRelation(request.term, typeId, callBack, errorCallBack);
                  },
                  success: function (data) {},
                  select: function( event, ui ) {

                      var name = ui.item.name;
                      var id = ui.item.id;

                      if(noResultMessage == ui.item.value){

                          return false;

                      }else{
                          var callback = function(data){
                              var $tagsElement = $('#tree-tags');

                              $tagsElement.tree(
                                  'appendNode',
                                  {
                                      name: name,
                                      id: id+'_0_'+typeId,
                                      'tag_type_id': typeId,
                                      'short_desc':'',
                                      'image': '',
                                      'child_count': 0,
                                      'child_id': id,
                                      'parent_id': 0,
                                      'product_count': '?'
                                  }
                              );

                          };

                          var errorCallback = function(){
                              // do something here if error
                          };
                          Kacana.ajax.tag.addTagToRoot(id, typeId, callback, errorCallback);
                      }
                  }
              }).autocomplete( "widget" ).addClass("search-tag-result-to-add-relation");
          }
      },
      detailTag: {
          init: function(){
            Kacana.tag.detailTag.setupDatatableForProductTag();
          Kacana.config.initSummerNote();
          },
          setupDatatableForProductTag: function(){
              var tagId = $('input[name="id"]').val();
              var element = '#productTagTable';
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
              };

              var cacheLoadedCallBack = function(oData){

              };

              var datatable = Kacana.datatable.productTag(tagId, element, columns, addParamsCallBack, cacheLoadedCallBack);
          },
      }
  }
};

$.extend(true, Kacana, tagPackage);