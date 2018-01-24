var campaignPackage = {
    campaign: {
        init: function () {

        },
        listCampaign: {
            page: null,
            validateTime: false,
            init: function () {
                Kacana.campaign.listCampaign.page = $('#content-campaign-list-page');
                Kacana.campaign.listCampaign.setupDatatableForCampaign();
                Kacana.campaign.listCampaign.bindEvent();
            },
            bindEvent: function () {
                Kacana.campaign.listCampaign.page.on('click', '.create-campaign-btn', Kacana.campaign.listCampaign.popupCreateCampaign);


                var modalCreateCampaign = $('#modal-create-campaign');

                modalCreateCampaign.find('#display_date, #apply_date').daterangepicker({
                    startDate: moment().subtract(7, 'days'),
                    endDate: moment(),
                    timePicker: true,
                    timePicker24Hour: true,
                    locale: {
                        format: 'YYYY-MM-DD H:mm'
                    }
                });

                modalCreateCampaign.find('form').submit(function (event) {
                    var value = $(this).find('#apply_date').val();
                    if (!Kacana.campaign.listCampaign.validateTime) {
                        Kacana.utils.loading($('#modal-create-campaign').find('form'));
                        Kacana.campaign.listCampaign.validateTimeCampaign(value, Kacana.campaign.listCampaign.callbackValidateCampaign, 0);
                        return false;
                    }

                });

            },
            callbackValidateCampaign: function (data) {
                var modalCreateCampaign = $('#modal-create-campaign');

                if (!data.length) {
                    Kacana.campaign.listCampaign.validateTime = true;
                    modalCreateCampaign.find('form').submit();
                }
                else {
                    var warningString = '<div class="text-left text-red" ><b>' + modalCreateCampaign.find('#post_title').val() + '</b> <p>' + modalCreateCampaign.find('#apply_date').val() + '</p> </div>';
                    for (var i = 0; i < data.length; i++) {
                        var item = data[i];
                        warningString += '<div class="text-left" ><a target="_blank" href="/campaign/edit/' + item.id + '">' + item.name + '</a> <p>' + item.start_date + ' - ' + item.end_date + '</p> </div>';
                    }
                    swal({
                        tite: 'same time',
                        html: warningString,
                        showCloseButton: true,
                        showCancelButton: false
                    })
                }
            },
            validateTimeCampaign: function (value, callBackParent, $campaignId) {
                var callBack = function (data) {;
                    callBackParent(data);
                };

                var errorCallback = function () {

                };

                Kacana.ajax.campaign.validateTimeCampaign({'date': value, 'campaign_id': $campaignId}, callBack, errorCallback);
            },
            popupCreateCampaign: function () {
                $('#modal-create-campaign').modal();
            },
            setupDatatableForCampaign: function () {
                var $formInline = $('.form-inline');
                var element = '#campaignTable';
                $(element).parents('.box').css('overflow', 'auto');
                var columns = [
                    {
                        'title': 'ID',
                        'width': '5%'
                    },
                    {
                        'title': 'Name'
                    },
                    {
                        'title': 'Banner',
                        'render': function (data, type, full, meta) {
                            if (data)
                                return '<img src="http://image.kacana.vn' + data + '" width="100" height="35" />';
                            else
                                return '<p class="text-red">no image</p>';
                        }
                    },
                    {
                        'title': 'Display start',
                        'render': function (data, type, full, meta) {
                            return data ? data.slice(0, -8) + '<br><b>' + data.slice(11, 19) + '</b>' : '';
                        }
                    },
                    {
                        'title': 'Display end',
                        'render': function (data, type, full, meta) {
                            return data ? data.slice(0, -8) + '<br><b>' + data.slice(11, 19) + '</b>' : '';
                        }
                    },
                    {
                        'title': 'Apply start',
                        'render': function (data, type, full, meta) {
                            return data ? data.slice(0, -8) + '<br><b>' + data.slice(11, 19) + '</b>' : '';
                        }
                    },
                    {
                        'title': 'Apply end',
                        'render': function (data, type, full, meta) {
                            return data ? data.slice(0, -8) + '<br><b>' + data.slice(11, 19) + '</b>' : '';
                        }
                    },
                    {
                        'title': 'Status',
                    },
                    {
                        'title': 'Updated',
                        'width': '12%',
                        'render': function (data, type, full, meta) {
                            return data ? data.slice(0, -8) + '<br><b>' + data.slice(11, 19) + '</b>' : '';
                        }
                    },
                    {
                        'width': '4%',
                        'class': 'center',
                        'sortable': false,
                        'render': function (data, type, full, meta) {
                            return '<a href="/campaign/edit/' + full[0] + '" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></a>';
                        }
                    },
                ];

                var addParamsCallBack = function (oData) {
                    //search name or email
                    //oData.columns[2].search.orWhere = true;
                    //oData.columns[3].search.orWhere = true;
                };

                var cacheLoadedCallBack = function (oData) {
                    $formInline.find('input[name="name"]').val(oData.columns[1].search.search);
                };

                var datatable = Kacana.datatable.generateCampaignTable(element, columns, addParamsCallBack, cacheLoadedCallBack);

                $formInline.off('submit')
                    .on('submit', function (e) {
                        e.preventDefault();

                        var api = datatable.api(true);

                        //var userType = $formInline.find('select[name="searchUserType"]').val();
                        var status = $formInline.find('select[name="searchStatus"]').val();
                        //var level = $formInline.find('select[name="searchLevel"]').val();
                        var text = $formInline.find('input[name="name"]').val();
                        //
                        api.column(1).search(text)
                            .column(2).search(status, true);

                        api.draw();
                    });
            }
        },
        editCampaign: {
            page: false,
            init: function () {
                Kacana.campaign.editCampaign.page = $('#campaign-edit-page');

                Kacana.config.initSummerNote(Kacana.campaign.editCampaign.simpleNoteUploadImageCallback);
                Kacana.campaign.editCampaign.installDate();
                Kacana.campaign.editCampaign.uploadImage();
                Kacana.campaign.editCampaign.page.on('change', '#apply_date', function () {
                    var value = $(this).val();
                    var campaignId = $('#campagin_id').val();
                    Kacana.campaign.listCampaign.validateTimeCampaign(value, Kacana.campaign.editCampaign.callBackValidateTimeCampaign, campaignId);
                });

                Kacana.campaign.editCampaign.page.on('click', ' #add-product-campaign-btn', Kacana.campaign.editCampaign.addProductCampaign);
                Kacana.campaign.editCampaign.bindEventModal();

            },
            callBackValidateTimeCampaign: function(data){
                var modalCreateCampaign = $('#modal-create-campaign');

                if (data.length) {
                    var warningString = '<div class="text-left text-red" ><b>' + modalCreateCampaign.find('#post_title').val() + '</b> <p>' + modalCreateCampaign.find('#apply_date').val() + '</p> </div>';
                    for (var i = 0; i < data.length; i++) {
                        var item = data[i];
                        warningString += '<div class="text-left" ><a target="_blank" href="/campaign/edit/' + item.id + '">' + item.name + '</a> <p>' + item.start_date + ' - ' + item.end_date + '</p> </div>';
                    }
                    swal({
                        tite: 'same time',
                        html: warningString,
                        showCloseButton: true,
                        showCancelButton: false
                    })
                }
            },
            installDate: function () {
                Kacana.campaign.editCampaign.page.find('#display_date, #apply_date').daterangepicker({
                    timePicker: true,
                    timePicker24Hour: true,
                    locale: {
                        format: 'YYYY-MM-DD H:mm'
                    }
                });
            },
            simpleNoteUploadImageCallback: function(up, file, info, $areaEditorImageUpload) {
                var data = jQuery.parseJSON(info.response);

                if(data.ok)
                {
                    var sendData = {
                        name: data.name,
                        campaignId: $('#campagin_id').val(),
                        type: 1
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

                    Kacana.ajax.campaign.updateCampaignImage(sendData, callBack, errorCallBack);

                }
            },
            uploadImage: function(){
                var $detailPage = $('#campaign-edit-page');
                var $buttonUpload = $('#banner-upload-btn');
                var uploadHost = '/upload/chunk';
                var uploadLimit = 100;
                var container = 'image-upload-container';
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

                                var image = new Image();
                                image.src = e.target.result;
                                image.onload = function() {
                                    if(this.width > 1000 && this.height > 350)
                                    {
                                        $image.attr('src', e.target.result);
                                        $detailPage.find('.banner-cropper-preview').show();
                                        var options = {
                                            aspectRatio: 10/3.5,
                                            zoomable: true,
                                            minCropBoxHeight: 80,
                                            minCropBoxWidth: 80
                                        };

                                        $image.cropper('destroy');
                                        $image.cropper(options);

                                        $buttonUpload.removeClass('hide');
                                    }
                                    else{
                                        swal('image size is small', 'please upload image min size is: 1000 x 350', 'error');
                                    }
                                };

                            }
                        };

                        reader.readAsDataURL(files[0].getNative());

                    }catch (err){
                        console.log(err);
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
                        campaignId: $('#campagin_id').val(),
                        type: 2
                    };
                    var callBack = function(data){

                        if(data.ok){
                            location.reload();
                        }
                    };

                    var errorCallBack = function(){

                    };

                    Kacana.ajax.campaign.updateCampaignImage(sendData, callBack, errorCallBack);
                });

                uploader.bind('FileUploaded', function(up, file, info) {
                    var data = jQuery.parseJSON(info.response);

                    if(data.ok)
                    {
                        var imageName = data.name;
                        var sendData = {
                            name: data.name,
                            campaignId: $('#campagin_id').val(),
                            type: 2
                        };

                        var callBack = function(data){

                            if(data.ok){
                                location.reload();
                            }
                        };

                        var errorCallBack = function(){

                        };

                        Kacana.ajax.campaign.updateCampaignImage(sendData, callBack, errorCallBack);
                    }
                });
            },
            addProductCampaign:function () {
                var modalAddProduct = $('#modal-add-product-campaign');
                modalAddProduct.modal();
            },
            bindEventModal: function () {
                var modal = $('#modal-add-product-campaign');
                modal.on('change', '#input-search-add-product-name', Kacana.campaign.editCampaign.searchProduct);
                modal.on('click', '#list-search-product-campaign a[href="#add-product"]', Kacana.campaign.editCampaign.addProductToCampaign);
                modal.on('click', '#list-product-add-to-campaign a[href="#add-product"]', Kacana.campaign.editCampaign.removeProductToCampaign);
            },
            searchProduct: function () {
                var keySearch = $(this).val();
                var sendData = {'key': keySearch};
                var modal = $('#modal-add-product-campaign');
                var template = $('#template-product-item-add-campaign');
                var callBack = function(data){
                    if(data.ok){
                        var item = data.data;
                        var templateGenerate = $.tmpl(template, {'listItem': item});
                        modal.find('.modal-body #list-search-product-campaign').empty().append(templateGenerate);
                    }
                };

                var errorCallBack = function(){

                };

                Kacana.ajax.campaign.searchProduct(sendData, callBack, errorCallBack);

                return false;
            },
            addProductToCampaign: function () {
                var productId = $(this).parents('.item').data('product-id');

                $('#list-product-add-to-campaign .item').each(function () {
                    if($(this).data('product-id') == productId){
                        return Kacana.utils.showError('sản phẩm đã được thêm!')
                    }
                });

                var item = $(this).parents('.item').clone();
                item.find('a[href="#add-product"] i').attr('class', "text-danger fa fa-minus-circle fa-2x");
                item.prependTo('#list-product-add-to-campaign');
            },
            removeProductToCampaign: function () {
                $(this).parents('.item').remove();
            }
        }
    }
};

$.extend(true, Kacana, campaignPackage);