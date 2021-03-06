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

                            </div>
                            <h4 class="text-danger text-bold text-center">List Product Campaign</h4>
                            <div id="list-product-add-to-campaign" >

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
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
                            <input required="" name="deal_deference" placeholder="Deal reference" id="campaign_discount_reference" class="form-control" type="text">
                        </div>
                        <div class="form-group">
                            <label for="productName">Apply</label>
                            <input required="" name="product_apply_date" placeholder="Apply date" id="campaign_product_apply_date" class="form-control" type="text">
                        </div>
                    </div>
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

<script id="template-product-item-add-campaign" type="template">
    @{{each listItem}}
        <div data-product-id="${this.id}" class="col-sm-12 item">
            <div class="col-sm-5 product-info" >
                <img src="${this.image}">
                <span >${this.name}</span>
                <span class="text-aqua" >${Kacana.utils.formatCurrency(this.sell_price)}</span></a>
            </div>
            <div class="col-sm-6 product-current-deal">
                @{{each this.campaign_product}}
                    <span class="text-danger">${this.start_date} - ${this.end_date}</span>
                    <span class="type-product-deal text-info">${Kacana.utils.dealType(this.discount_type)}</span>
                    <span class="text-maroon">@{{html Kacana.utils.dealRef(this.discount_type,this.ref)}}</span>
                <br><br>
                @{{/each}}
            </div>
            <div class="col-sm-1 action-item">
                <a href="#add-product"><i class="fa fa-plus-circle fa-2x" ></i></a>
            </div>
        </div>
    @{{/each}}
</script>