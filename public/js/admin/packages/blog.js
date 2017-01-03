var blogPackage = {
    blog:{
        init: function(){

        },
        listPost: {
            page: false,
            init: function () {
                Kacana.blog.listPost.page = $('#content-blog-page');
                Kacana.blog.listPost.setupDatatableForPost();
                Kacana.blog.listPost.bindEvent();
            },
            bindEvent: function () {
                Kacana.blog.listPost.page.on('click', '#create-post-btn', function () {
                    var modal = $('#modal-create-post');
                    modal.find('#post_title').val('');
                    modal.find('#post_tag_id').val('');
                    modal.modal();
                });
            },
            setupDatatableForPost: function () {
                var $formInline = $('.form-inline');
                var element = '#postTable';
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
                        'title': 'Người viết',
                    },
                    {
                        'title': 'Chuyên mục',
                    },
                    {
                        'title': 'Comments',
                    },
                    {
                        'title': 'Status',
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
                            return '<a href="/blog/editPost/' + full[0] + '" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>';
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

                var datatable = Kacana.datatable.generatePostTable(element, columns, addParamsCallBack, cacheLoadedCallBack);

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
            page: false,
            init: function () {
                Kacana.config.initSummerNote(Kacana.blog.detail.simpleNoteUploadImageCallback);

                Kacana.blog.detail.page = $('#content-edit-post');

                Kacana.blog.detail.page.find('#group-tag-for-post').select2({
                    closeOnSelect: false
                });
                Kacana.blog.detail.bindEvent();
                Kacana.blog.detail.uploadMainImage();
                Kacana.blog.detail.setupDatatableForComment();

                Kacana.blog.detail.page.find('#post_tags').select2({
                    ajax: {
                        url: "/blog/searchTagPost",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                name: params.term, // search term
                                page: params.page,
                                postId: $('#postId').val()
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
                    templateSelection: Kacana.blog.detail.parsePostTagSelection,
                    templateResult: Kacana.blog.detail.parsePostTagTemplate,
                });
            },
            simpleNoteUploadImageCallback: function(up, file, info, $areaEditorImageUpload) {
                var data = jQuery.parseJSON(info.response);

                if(data.ok)
                {
                    var sendData = {
                        name: data.name,
                        postId: $('#postId').val(),
                        type: 4
                    };

                    var callBack = function(data){
                        if(data.ok){
                            data = data.data;
                            var nodeParent = document.createElement('p');
                            var node = document.createElement('img');
                            node.src = data.image;
                            nodeParent.appendChild(node);
                            $areaEditorImageUpload.summernote('insertNode', nodeParent);
                        }

                    };

                    var errorCallBack = function(){

                    };

                    Kacana.ajax.blog.addPostImage(sendData, callBack, errorCallBack);

                }
            },
            parsePostTagSelection: function (repo) {
                return repo.name || repo.text;
            },
            parsePostTagTemplate: function (repo) {
                if (repo.loading) return repo.text;
                var markup = '<div>'+repo.name+'</div>';
                return markup;
            },
            bindEvent: function () {

                Kacana.blog.detail.page.on('change','#group-tag-for-post', function () {
                    if($(this).val())
                        $(this).parents('.form-group').find('button').removeAttr('disabled');
                    else
                        $(this).parents('.form-group').find('button').attr('disabled', 'disabled');
                });
                Kacana.blog.detail.page.on('click','#add-group-tag-to-product-tag', Kacana.blog.detail.addGroupTagToPostTag);
                Kacana.blog.detail.page.on('click','#remove-group-tag-from-product-tag', Kacana.blog.detail.removeGroupTagFromPostTag);
            },
            addGroupTagToPostTag: function () {
                var groupTagIds = $(this).parents('.form-group').find('select').val();

                var errorCallBack = function(e){
                    console.log(e);
                };
                var callBack = function (data){
                    console.log(data);
                    var tagInput = $('#post_tags');
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
            removeGroupTagFromPostTag: function () {
                var groupTagId = $(this).parents('.form-group').find('select').val();

                var errorCallBack = function(e){
                    console.log(e);
                };
                var callBack = function (data){
                    console.log(data);
                    var tagInput = $('#post_tags');
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
            uploadMainImage: function(){
                var $detailPage = $('#post-image-main');
                var $buttonUpload = $('#banner-upload-btn');
                var uploadHost = '/upload/chunk';
                var uploadLimit = 100;
                var container = 'image-main-post-upload-container';
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
                                    aspectRatio: 16/6,
                                    zoomable: true,
                                    minCropBoxHeight: 192,
                                    minCropBoxWidth: 512
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
                        postId: $('#postId').val()
                    };
                    var callBack = function(data){

                        if(data.ok){
                            location.reload();
                        }
                    };

                    var errorCallBack = function(){

                    };

                    Kacana.ajax.blog.updatePostMainImage(sendData, callBack, errorCallBack);
                });

                uploader.bind('FileUploaded', function(up, file, info) {
                    var data = jQuery.parseJSON(info.response);

                    if(data.ok)
                    {
                        var imageName = data.name;
                        var sendData = {
                            name: data.name,
                            postId: $('#postId').val()
                        };

                        var callBack = function(data){

                            if(data.ok){
                                location.reload();
                            }
                        };

                        var errorCallBack = function(){

                        };

                        Kacana.ajax.blog.updatePostMainImage(sendData, callBack, errorCallBack);

                    }
                });
            },
            setupDatatableForComment: function () {
                var $formInline = $('.form-inline');
                var element = '#commentTable';
                $(element).parents('.box').css('overflow', 'auto');
                var columns = [
                    {
                        'title': 'ID',
                        'width': '5%'
                    },
                    {
                        'title': 'User'
                    },
                    {
                        'title': 'Body',
                    },
                    {
                        'title': 'Status',
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
                    }
                ];

                var addParamsCallBack = function (oData) {
                    //search name or email
                    //oData.columns[2].search.orWhere = true;
                    //oData.columns[3].search.orWhere = true;
                };

                var cacheLoadedCallBack = function (oData) {
                    // $formInline.find('input[name="search"]').val(oData.columns[1].search.search);
                    // $formInline.find('select[name="searchStatus"]').val(oData.columns[2].search.search);
                };

                var datatable = Kacana.datatable.generateCommentTable(element, columns, $('#postId').val(), addParamsCallBack, cacheLoadedCallBack);

                // $formInline.off('submit')
                //     .on('submit', function (e) {
                //         e.preventDefault();
                //
                //         var api = datatable.api(true);
                //
                //         //var userType = $formInline.find('select[name="searchUserType"]').val();
                //         var status = $formInline.find('select[name="searchStatus"]').val();
                //         //var level = $formInline.find('select[name="searchLevel"]').val();
                //         var text = $formInline.find('input[name="search"]').val();
                //         //
                //         api.column(1).search(text)
                //             .column(2).search(status, true);
                //
                //         api.draw();
                //     });
            }
        }
    }
};

$.extend(true, Kacana, blogPackage);