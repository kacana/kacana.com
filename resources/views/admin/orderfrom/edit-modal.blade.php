<div id="modal-edit-order-from" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Cập nhật order from</h4>
            </div>
            <form role="form" method="post" action="" id="form-edit">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="orderFromName">Tên order from</label>
                            <input required name="name" placeholder="Tên order from" id="order_from_title" class="form-control" type="text" value="">
                        </div>
                        <div class="form-group">
                            <label for="orderFromName">Miêu tả</label>
                            <textarea class="form-control" rows="5" id="order_from_desc" name="description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" value="" id="order_from_id"/>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-primary" value="Cập nhật"/>
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>