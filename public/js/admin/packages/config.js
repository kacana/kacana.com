var configPackage = {
    config:{
        initSummerNote: function(){

            $( "form" ).on( "submit", function() {
                var form = $(this);
                $('.note-editor').each(function(){
                    var divSummit = $(this).prev();
                    var textArea = $('<textarea></textarea>');
                    textArea.attr('name', divSummit.attr('name'));
                    textArea.css('visibility', 'hidden');
                    textArea.text(divSummit.summernote('code'));
                    form.append(textArea);
                });
            });

            var $detailPage = $('.note-group-select-from-files');
            var $buttonUpload = $('.note-image-input');
            var uploadHost = '/upload/chunk';
            var uploadLimit = 100;
            var container = 'image-upload-container';
            var dropElement = 'undefined';
            var browseButton = 'select-file';
            var multiSelection = true;
            var filters = [
                {title : 'Image Files', extensions : 'jpg,jpeg,gif,png,bmp'}
            ];

            var uploaderTextImage = Kacana.uploader.init(uploadHost,container,dropElement,browseButton,multiSelection,uploadLimit,filters);
            var $areaEditorImageUpload = null;

            $('.kacana-editor-content').summernote({
                height: 300,
                callbacks: {
                    onImageUpload: function(files) {

                        $.each(files, function(i, file) {
                            uploaderTextImage.addFile(file);
                        });
                        uploaderTextImage.start();

                        $areaEditorImageUpload = $(this);
                    },
                    onMediaDelete : function($target, editor, $editable) {
                        console.log($target.attr('src'));
                    }
                },
            });

            uploaderTextImage.bind('FileUploaded', function(up, file, info) {
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
                            data = data.data
                            var $image = '<div class="product-image-item" data-type="3" data-id="'+data.id+'">';
                            $image +=       '<img class="product-image" src="'+data.image+'">';
                            $image +=       '<div class="product-image-tool">';
                            $image +=           '<a href="#setPrimaryImage"> <i class="fa fa-photo"></i> </a>';
                            $image +=           '<a href="#setSlideImage"><i class="fa fa-star"></i></a>';
                            $image +=           '<a href="#deleteImage"><i class="fa fa-trash"></i></a>';
                            $image +=       '</div>';
                            $image +=   '</div>';

                            // $('.list-product-image').prepend($image);
                            // Kacana.product.detail.addImageToProperties(data);

                            $areaEditorImageUpload.summernote('insertImage', data.image);
                        }

                    };

                    var errorCallBack = function(){

                    };

                    Kacana.ajax.product.addProductImage(sendData, callBack, errorCallBack);

                }
            });
        }
    }
};

$.extend(true, Kacana, configPackage);;