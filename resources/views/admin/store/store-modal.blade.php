<section>
    <div id="modal-quick-import-product" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Nhập sản phẩm</h4>
                </div>
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
                        <div>
                            <label for="productPriceIm">Loại nhập hàng</label>
                            <select name="importType" type="text" placeholder="giá nhập" id="importType" class="form-control">
                                <option value="0">Chọn loại nhập hàng</option>
                                <option value="{{KACANA_STORE_IMPORT_TYPE_FACTORY}}">Xưởng</option>
                                <option value="{{KACANA_STORE_IMPORT_TYPE_RETURN}}">Trả hàng</option>
                                <option value="{{KACANA_STORE_IMPORT_TYPE_ANOTHER_STORE}}">Kho khác</option>
                                <option value="{{KACANA_STORE_IMPORT_TYPE_OTHER}}">Khác</option>
                        </select>
                        </div>
                    </div><!-- /.box-body -->
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-primary" value="Tạo sản phẩm"/>
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</section>