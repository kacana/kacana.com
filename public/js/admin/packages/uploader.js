var uploaderPackage = {
    uploader:{
        init:function(uploadPath,container,dropElement,browseButton,multiSelection,sizeLimit,filters){

            var uploader = new plupload.Uploader(
                {
                    runtimes : 'gears,html5,flash,silverlight,browserplus',
                    multi_selection: multiSelection,
                    drop_element: dropElement,
                    browse_button : browseButton,
                    container : container,

                    max_file_size : sizeLimit+'mb',
                    url : uploadPath,

                    flash_swf_url : '/lib/plupload/js/Moxie.swf',
                    silverlight_xap_url : '/lib/plupload/js/Moxie.xap',

                    filters : filters,

                    resize : {width : 1600, height : 1200, quality : 90},

                    chunk_size : '1mb',
                    unique_names : true,
                    headers: {
                        'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
                    },

                    // PreInit events, bound before any internal events
                    preinit : {

                        Init: function(up, info)
                        {
                            console.log('[Init]', 'Info:', info, 'Features:', up.features);
                        },

                        UploadFile: function(up, file)
                        {
                            console.log('[UploadFile]', file);
                            // You can override settings before the file is uploaded
                        }
                    },

                    init: {

                        Refresh: function(up)
                        {
                            // Called when upload shim is moved
                            console.log('[Refresh]');
                        },

                        StateChanged: function(up)
                        {
                            // Called when the state of the queue is changed
                            console.log('[StateChanged]', up.state == plupload.STARTED ? "STARTED" : "STOPPED");
                        },

                        QueueChanged: function(up)
                        {
                            // Called when the files in queue are changed by adding/removing files
                            console.log('[QueueChanged]');
                        },

                        UploadProgress: function(up, file)
                        {
                            console.log('[UploadProgress]');
                        },

                        FilesAdded: function(up, files)
                        {
                            // Called when files are added to queue
                            console.log('[FilesAdded]');
                        },

                        FilesRemoved: function(up, files)
                        {
                            // Called when files where removed from queue
                            console.log('[FilesRemoved]');
                            plupload.each(files, function(file) {
                                console.log('  File:', file);
                            });
                        },

                        FileUploaded: function(up, file, info)
                        {
                            // Called when a file has finished uploading
                            console.log('[FileUploaded] File:', file, 'Info:', info);
                        },

                        ChunkUploaded: function(up, file, info)
                        {
                            // Called when a file chunk has finished uploading
                            console.log('[ChunkUploaded] File:', file, "Info:", info);
                        },

                        Error: function(up, err)
                        {
                            // Called when a error has occured
                            console.log('[error] ', err);
                        }
                    }

                });

            console.log('Loaded plupload', uploader);

            var $target = $('#'+dropElement);

            $target.on('dragenter', function(event) {
                $(this).addClass('dragover');
            });

            $target.on('dragleave', function(event) {
                $(this).removeClass('dragover');
            });

            $target.on('drop', function(event) {
                $(this).removeClass('dragover');
            });

            uploader.init();

            return uploader;
        }
    }

};
$.extend(true, Kacana, uploaderPackage);