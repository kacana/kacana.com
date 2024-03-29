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
                fontSizes: ['8', '9', '10', '11', '12', '14', '15', '18', '24', '36', '48' , '64', '82', '150'],
                toolbar: [
                    ['sfd', ['style']],
                    ['style', ['italic', 'bold','underline', 'clear','fontsize', 'color']],
                    ['asd', ['ul', 'paragraph']],
                    ['height', ['height']],
                    ['seo',['seo']],
                    ['insert', ['picture', 'table', 'hr', 'link', 'video']],
                    ['misc', ['undo', 'redo', 'fullscreen', 'codeview']],
                ],
                popover: {
                    image: [
                        ['custom', ['captionIt', 'imageAttributes']],
                        ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ],
                },
                captionIt:{
                    icon:'<i class="fa fa-image"/>', // Leave empty or don't set for default Icon.
                    figureClass:'kacana-figure-image',
                    figcaptionClass:'kacana-figcaption-image',
                },
                lang: 'en-US',
                imageAttributes:{
                    imageDialogLayout:'default', // default|horizontal
                    icon:'<i class="note-icon-pencil"/>',
                    removeEmpty:false // true = remove attributes | false = leave empty if present
                },
                displayFields:{
                    imageBasic:true,  // show/hide Title, Source, Alt fields
                    imageExtra:false, // show/hide Alt, Class, Style, Role fields
                    linkBasic:true,   // show/hide URL and Target fields for link
                    linkExtra:false   // show/hide Class, Rel, Role fields for link
                },
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
                    onInit: function() {
                        $areaEditorImageUpload = $(this);
                        $containerEditor = $(this).next();
                        if($areaEditorImageUpload.hasClass('set-view-client')) {
                            $containerEditor.find('.note-editing-area').addClass('container');
                            $containerEditor.find('.note-editable.panel-body').addClass($areaEditorImageUpload.data('view'));
                        }
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
                }
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