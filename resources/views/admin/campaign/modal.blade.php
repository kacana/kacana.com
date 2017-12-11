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