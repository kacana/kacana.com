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

            $('.kacana-editor-content').summernote({
                height: 300,
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