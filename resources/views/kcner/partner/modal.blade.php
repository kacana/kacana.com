<div id="modal-transfer-partner" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" method="post" action="/partner/transfer">
                <input type="text" class="hidden" value="{{$user->id}}" name="userId" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Chuyển tiền</h4>
                </div>

                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th style="width: 20px">#</th>
                                <th>Tên</th>
                                <th>Hình</th>
                                <th>Chiết hấu</th>
                            </tr>
                            @if(count($commissions['valid']['data']))
                                @foreach($commissions['valid']['data'] as $commission)
                                    <tr>
                                        <td><input name="orderDetailId[]" class="order_detail_success" value="{{$commission->id}}" data-sub-total="{{$commission->subtotal*PARTNER_DISCOUNT_PERCENT_LEVEL_1/100}}" checked type="checkbox"></td>
                                        <td>{{$commission->name}}</td>
                                        <td>
                                            <img style="width: 50px" class="img-responsive" src="{{$commission->image}}">
                                        </td>
                                        <td>{{formatMoney($commission->subtotal*PARTNER_DISCOUNT_PERCENT_LEVEL_1/100)}}</td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>

                    <div class="form-group">
                        <label for="name">Tổng</label>
                        <input required="required" class="form-control" id="transfer_total" disabled name="total" value="{{formatMoney($commissions['valid']['total'])}}" type="text">
                    </div>
                    <div class="form-group">
                        <label for="name">Mã Chuyển tiền</label>
                        <input required="required" class="form-control" name="ref" value="" placeholder="Nhập mã chuyển tiền của ngân hàng hoặc mã giao dịch" type="text">
                    </div>
                    <div class="form-group">
                        <label for="name">Ghi Chú</label>
                        <input class="form-control" name="note" value="" placeholder="Ghi chú chuyển tiền" type="text">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button id="btn-submit-transfer" type="submit" class="btn btn-primary" >Chuyển tiền</button>
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>