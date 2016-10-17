<section>
    <div id="confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Xoá Sản Phẩm</h4>
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

    <div id="modal-create-product" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Thêm sản phẩm</h4>
                </div>
                <form role="form" method="post" action="/product/createBaseProduct">
                    <div class="modal-body">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="productName">tên sản phẩm</label>
                                    <input name="productName" type="text" placeholder="tên sản phẩm" id="productName" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="productPriceIm">giá nhập</label>
                                    <input name="productPriceIm" type="text" placeholder="giá nhập" id="productPriceIm" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="productPriceEx">giá bán</label>
                                    <input name="productPriceEx" type="text" placeholder="giá bán" id="productPriceEx" class="form-control">
                                </div>
                            </div><!-- /.box-body -->
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-primary" value="Tạo sản phẩm"/>
                        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>