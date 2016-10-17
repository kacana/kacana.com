<section>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    </div>
</section>

<section>
    <div id="confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Xoá Tag</h4>
                </div>

                <div class="modal-body">
                    Bạn thật sự muốn xoá thông tin này?
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>

            </div>
        </div>
    </div>

    <div id="modal-add-image-tag" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">add image for tag</h4>
                </div>

                <div class="modal-body">
                    <div class="box-tools margin-bottom">

                        <div id="image-upload-container"></div>
                        <button id="select-file" class="btn btn-sm btn-primary">
                            <i class="icon icon-plus"></i> <span>Select File</span>
                            <input type="file" class="hide">
                        </button>

                        <button id="banner-upload-btn" class="btn btn-sm btn-success hide">
                            <i class="icon icon-upload-alt"></i> <span>Confirm</span>
                        </button>

                        <button id="banner-remove-btn" class="btn btn-sm btn-danger">
                            <i class="icon icon-remove-circle"></i> <span>Remove</span>
                        </button>
                    </div>
                    <div class="row">
                        <div class="banner-cropper col-md-12 margin-bottom">
                            <img style="width: 100%;" class="banner-cropper-preview" src="">
                        </div>
                        <div class="col-md-12" id="current-baner-for-tag" >
                            <img style="width: 100%;" src="">
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</section>
