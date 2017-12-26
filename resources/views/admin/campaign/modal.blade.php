<div id="modal-create-campaign" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Create campaign</h4>
            </div>
            <form role="form" method="post" action="/campaign/createCampaign">
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="productName">Name</label>
                            <input required name="campaign_name" placeholder="campaign name" id="post_title" class="form-control" type="text">
                        </div>
                        <div class="form-group">
                            <label for="productName">Display</label>
                            <input required name="display_date" placeholder="Display date" id="display_date" class="form-control" type="text">
                        </div>
                        <div class="form-group">
                            <label for="productName">Apply</label>
                            <input required name="apply_date" placeholder="Apply date" id="apply_date" class="form-control" type="text">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-primary" value="Tạo mới"/>
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal-add-product-campaign" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Add product campaign</h4>
            </div>
            <div class="modal-body">
                    <div class="row" >
                        <div class="col-sm-7">
                            <div class="row" >
                                <input required name="input-search-add-product-name" placeholder="enter product name" id="input-search-add-product-name" class="form-control" type="text">
                            </div>
                            <div class="row">
                                <div id="list-search-product-campaign">
                                    <div class="col-sm-12 item">
                                        <div class="col-sm-5 product-info" >
                                            <img src="//image.kacana.vn/images/product/Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060 1496040258.jpg">
                                            <span >Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060</span>
                                            <span class="text-aqua" >990,000 đ</span></a>
                                        </div>
                                        <div class="col-sm-6 product-current-deal">
                                            <span class="text-danger">2017-12-01 21:38:00 - 2017-12-01 21:38:00</span> <span class="type-product-deal text-info">Đồng Giá</span> <span class="text-maroon">500,000 đ</span><br>
                                            <span class="text-danger">2017-12-01 21:38:00 - 2017-12-01 21:38:00</span> <span class="type-product-deal text-info">Đồng Giá</span> <span class="text-maroon">500,000 đ</span><br>
                                            <span class="text-danger">2017-12-01 21:38:00 - 2017-12-01 21:38:00</span> <span class="type-product-deal text-info">Đồng Giá</span> <span class="text-maroon">500,000 đ</span><br>
                                        </div>
                                        <div class="col-sm-1 action-item">
                                            <a href="#add-product"><i class="fa fa-plus-circle fa-2x" ></i></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 item">
                                        <div class="col-sm-5 product-info" >
                                            <img src="//image.kacana.vn/images/product/Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060 1496040258.jpg">
                                            <span >Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060</span>
                                            <span class="text-aqua" >990,000 đ</span></a>
                                        </div>
                                        <div class="col-sm-6 product-current-deal">
                                            <span class="text-danger">2017-12-01 21:38:00 - 2017-12-01 21:38:00</span> <span class="type-product-deal text-info">Đồng Giá</span> <span class="text-maroon">500,000 đ</span><br>
                                        </div>
                                        <div class="col-sm-1 action-item">
                                            <a href="#add-product"><i class="fa fa-plus-circle fa-2x" ></i></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 item">
                                        <div class="col-sm-5 product-info" >
                                            <img src="//image.kacana.vn/images/product/Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060 1496040258.jpg">
                                            <span >Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060</span>
                                            <span class="text-aqua" >990,000 đ</span></a>
                                        </div>
                                        <div class="col-sm-6 product-current-deal">
                                            {{--<span class="text-danger">2017-12-01 21:38:00 - 2017-12-01 21:38:00</span> <span class="type-product-deal text-info">Đồng Giá</span> <span class="text-maroon">500,000 đ</span><br>--}}
                                        </div>
                                        <div class="col-sm-1 action-item">
                                            <a href="#add-product"><i class="fa fa-plus-circle fa-2x" ></i></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 item">
                                        <div class="col-sm-5 product-info" >
                                            <img src="//image.kacana.vn/images/product/Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060 1496040258.jpg">
                                            <span >Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060</span>
                                            <span class="text-aqua" >990,000 đ</span></a>
                                        </div>
                                        <div class="col-sm-6 product-current-deal">
                                            <span class="text-danger">2017-12-01 21:38:00 - 2017-12-01 21:38:00</span> <span class="type-product-deal text-info">Đồng Giá</span> <span class="text-maroon">500,000 đ</span><br>
                                        </div>
                                        <div class="col-sm-1 action-item">
                                            <a href="#add-product"><i class="fa fa-plus-circle fa-2x" ></i></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 item">
                                        <div class="col-sm-5 product-info" >
                                            <img src="//image.kacana.vn/images/product/Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060 1496040258.jpg">
                                            <span >Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060</span>
                                            <span class="text-aqua" >990,000 đ</span></a>
                                        </div>
                                        <div class="col-sm-6 product-current-deal">
                                            <span class="text-danger">2017-12-01 21:38:00 - 2017-12-01 21:38:00</span> <span class="type-product-deal text-info">Đồng Giá</span> <span class="text-maroon">500,000 đ</span><br>
                                        </div>
                                        <div class="col-sm-1 action-item">
                                            <a href="#add-product"><i class="fa fa-plus-circle fa-2x" ></i></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 item">
                                        <div class="col-sm-5 product-info" >
                                            <img src="//image.kacana.vn/images/product/Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060 1496040258.jpg">
                                            <span >Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060</span>
                                            <span class="text-aqua" >990,000 đ</span></a>
                                        </div>
                                        <div class="col-sm-6 product-current-deal">
                                            <span class="text-danger">2017-12-01 21:38:00 - 2017-12-01 21:38:00</span> <span class="type-product-deal text-info">Đồng Giá</span> <span class="text-maroon">500,000 đ</span><br>
                                        </div>
                                        <div class="col-sm-1 action-item">
                                            <a href="#add-product"><i class="fa fa-plus-circle fa-2x" ></i></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 item">
                                        <div class="col-sm-5 product-info" >
                                            <img src="//image.kacana.vn/images/product/Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060 1496040258.jpg">
                                            <span >Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060</span>
                                            <span class="text-aqua" >990,000 đ</span></a>
                                        </div>
                                        <div class="col-sm-6 product-current-deal">
                                            <span class="text-danger">2017-12-01 21:38:00 - 2017-12-01 21:38:00</span> <span class="type-product-deal text-info">Đồng Giá</span> <span class="text-maroon">500,000 đ</span><br>
                                        </div>
                                        <div class="col-sm-1 action-item">
                                            <a href="#add-product"><i class="fa fa-plus-circle fa-2x" ></i></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 item">
                                        <div class="col-sm-5 product-info" >
                                            <img src="//image.kacana.vn/images/product/Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060 1496040258.jpg">
                                            <span >Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060</span>
                                            <span class="text-aqua" >990,000 đ</span></a>
                                        </div>
                                        <div class="col-sm-6 product-current-deal">
                                            <span class="text-danger">2017-12-01 21:38:00 - 2017-12-01 21:38:00</span> <span class="type-product-deal text-info">Đồng Giá</span> <span class="text-maroon">500,000 đ</span><br>
                                        </div>
                                        <div class="col-sm-1 action-item">
                                            <a href="#add-product"><i class="fa fa-plus-circle fa-2x" ></i></a>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="text-danger text-bold text-center">List Product Campaign</h4>
                                <div id="list-product-add-to-campaign" >
                                    <div class="col-sm-12 item">
                                        <div class="col-sm-5 product-info" >
                                            <img src="//image.kacana.vn/images/product/Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060 1496040258.jpg">
                                            <span >Balo chống trộm phiên bản balo đeo chéo ngực một quai MIXI 2060</span>
                                            <span class="text-aqua" >990,000 đ</span></a>
                                        </div>
                                        <div class="col-sm-6 product-current-deal">
                                            <span class="text-danger">2017-12-01 21:38:00 - 2017-12-01 21:38:00</span> <span class="type-product-deal text-info">Đồng Giá</span> <span class="text-maroon">500,000 đ</span><br>
                                        </div>
                                        <div class="col-sm-1 action-item">
                                            <a href="#add-product"><i class="text-danger fa fa-minus-circle fa-2x" ></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="productName">Deal Type</label>
                                <select name="orderType" class="form-control">
                                    <option value="0">Please choose deal</option>
                                    <option value="{{KACANA_CAMPAIGN_DEAL_TYPE_DISCOUNT_PRICE}}">price discount</option>
                                    <option value="{{KACANA_CAMPAIGN_DEAL_TYPE_DISCOUNT_PERCENT}}">% discount</option>
                                    <option value="{{KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT}}">buy get 1 free</option>
                                    <option value="{{KACANA_CAMPAIGN_DEAL_TYPE_SAME_PRICE}}">same price</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="productName">Deal reference</label>
                                <div class="attachment-block clearfix">
                                    <p class="small">
                                        <span class="text-bold">Price discount</span> discount price for product: 200k discount 30k = 170k
                                    </p>
                                    <p class="small">
                                        <span class="text-bold">% discount</span> discount price for product: 300k discount 30% = 140k
                                    </p>
                                    <p class="small">
                                        <span class="text-bold">Buy 1 get 1 free</span> buy products in list get free product id: 1432
                                    </p>
                                    <p class="small">
                                        <span class="text-bold">same price</span> buy products in list with same price : 180k
                                    </p>
                                </div>
                                <input required="" name="deal_deference" placeholder="Deal reference" id="deal_reference" class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label for="productName">Apply</label>
                                <input required="" name="apply_date" placeholder="Apply date" id="apply_date" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" class="btn btn-primary" value="Tạo mới"/>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </div>
    </div>
</div>