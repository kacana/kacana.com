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
    <div id="modal-create-campaign-product" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add product campaign</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="productName">Product</label>
                        <div id="product-campaign-name-and-image">

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="productName">Current Campaign</label>
                        <div id="product-campaign-current-campaign" >

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="productName">Campaign</label>
                        <select id="campaign_id" name="campaign_id" class="form-control">
                            <option value="0">Please choose campaign</option>
                            @if(count($campaigns))
                                @foreach($campaigns as $campaign)
                                    <option value="{{$campaign->id}}">{{$campaign->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="productName">Deal Type</label>
                        <select id="campaign_discount_type" name="campaign-discount-type" class="form-control">
                            <option value="0">Please choose deal</option>
                            <option value="{{KACANA_CAMPAIGN_DEAL_TYPE_DISCOUNT_PRICE}}">price discount</option>
                            <option value="{{KACANA_CAMPAIGN_DEAL_TYPE_DISCOUNT_PERCENT}}">% discount</option>
                            <option value="{{KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT}}">buy get 1 free</option>
                            <option value="{{KACANA_CAMPAIGN_DEAL_TYPE_SAME_PRICE}}">same price</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="productName">Deal reference</label>
                        {{--<div class="attachment-block clearfix">--}}
                            {{--<p class="small">--}}
                                {{--<span class="text-bold">Price discount</span> discount price for product: 200k discount 30k = 170k--}}
                            {{--</p>--}}
                            {{--<p class="small">--}}
                                {{--<span class="text-bold">% discount</span> discount price for product: 300k discount 30% = 140k--}}
                            {{--</p>--}}
                            {{--<p class="small">--}}
                                {{--<span class="text-bold">Buy 1 get 1 free</span> buy products in list get free product id: 1432--}}
                            {{--</p>--}}
                            {{--<p class="small">--}}
                                {{--<span class="text-bold">same price</span> buy products in list with same price : 180k--}}
                            {{--</p>--}}
                        {{--</div>--}}
                        <input required="" name="deal_deference" placeholder="Deal reference" id="campaign_discount_reference" class="form-control" type="text">
                    </div>
                    <div class="form-group">
                        <label for="productName">Apply</label>
                        <input required="" name="product_apply_date" placeholder="Apply date" id="campaign_product_apply_date" class="form-control" type="text">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" id="submit-products-add-to-campaign" class="btn btn-primary" value="Tạo mới"/>
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</section>