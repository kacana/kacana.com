var configPackage = {
    config:{
        initSummerNote: function(imageUploadCallback){

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
            var browseButton = 'btn-upload-image-desc';
            var multiSelection = true;
            var filters = [
                {title : 'Image Files', extensions : 'jpg,jpeg,gif,png,bmp'}
            ];

            var uploaderTextImage = Kacana.uploader.init(uploadHost,container,dropElement,browseButton,multiSelection,uploadLimit,filters);
            var $areaEditorImageUpload = null;
            var $containerEditor = null;
            var changeCount = 0;

            $('.kacana-editor-content').summernote({
                height: 300,
                toolbar: [
                    ['sfd', ['style']],
                    ['style', ['bold', 'italic', 'underline', 'clear','fontsize', 'color']],
                    ['asd', ['ul', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['picture', 'table', 'hr', 'video', 'link']],
                    ['misc', ['undo', 'redo', 'fullscreen']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        $areaEditorImageUpload = $(this);
                        $containerEditor = $(this).next();
                        Kacana.utils.loading($containerEditor);
                        $.each(files, function(i, file) {
                            uploaderTextImage.addFile(file);
                        });
                        uploaderTextImage.start();


                    },
                    onMediaDelete : function($target, editor, $editable) {
                        console.log($target.attr('src'));
                    },
                    onChange: function(contents, $editable) {
                        if(changeCount >= 5){
                            var callBack = function(data){
                                console.log('auto save DONE !')
                            };

                            var errorCallBack = function(){
                                // do something here if error
                            };

                            changeCount = 0;
                            if($(this).data('id'))
                            {
                                Kacana.ajax.admin.updateField($(this).data('id'), contents, $(this).data('field'), $(this).data('table') , callBack, errorCallBack);
                            }
                        }

                        changeCount++;
                    }
                },
            });

            uploaderTextImage.bind('FileUploaded', function(up, file, info) {
                imageUploadCallback(up, file, info, $areaEditorImageUpload);
            });

            uploaderTextImage.bind('UploadComplete', function(up, files) {
                Kacana.utils.closeLoading();
            });
        }
    }
};

$.extend(true, Kacana, configPackage);;