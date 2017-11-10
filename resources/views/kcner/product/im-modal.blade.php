<section>
    <div id="modal-import-product-by-barcode" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Nhập sản phẩm</h4>
                </div>

                <div class="modal-body">

                </div>
                <div class="modal-footer" >
                    <input id="" class="btn btn-primary" value="Nhập kho" type="submit">
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script id="template-import-product-by-barcode" type="template">
        <div class="row margin-bottom" >
            <div class="col-xs-5">
                <img class="img-responsive" src="${item.imageProduct}">
            </div>
            <div class="col-xs-7">
                <p>
                    Sản phẩm: <b>${item.productObject.name}</b>
                </p>
                @{{if item.tag_color_id}}
                    <p>
                        Màu: ${item.colorObject.name}
                    </p>
                @{{/if}}
                @{{if item.tag_size_id}}
                    <p>
                        Size: ${item.sizeObject.name}
                    </p>
                @{{/if}}
                <p>
                    Giá bán: ${Kacana.utils.formatCurrency(item.price)}
                </p>
                <p>
                    <label>Số lượng:</label> <input style="width: 200px" name="quantity_import" placeholder="Nhập số lượng" value="1" class="form-control" type="text" >
                </p>
                <p>
                    <label>Giá nhập:</label> <input style="width: 200px" name="price_import" placeholder="Giá bán nhập sản phẩm" class="form-control" type="text" >
                    <input class="hidden" name="propertyId" value="${item.id}" >
                </p>
            </div>
        </div>
    </script>

</section>
