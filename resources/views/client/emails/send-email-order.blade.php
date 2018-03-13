<?php
    $user = $order->user;
    $orderDetail = $order->orderDetail;
    $address = $order->addressReceive;
    $city = $address->city;
    $ward = $address->ward;
    $district = $address->district;
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Thông tin đơn hàng</title>
    </head>
    <body style="font-family: arial; font-size:13px">
        <div marginwidth="0" marginheight="0" style="margin:0;padding:15px 10px;color:#292929;font-family:Helvetica,Arial,sans-serif">
            <img src="http://kacana.com/images/client/homepage/logo-main-color.png" border="0" width="1" height="1" class="CToWUd">
            <span style="display:none!important">Kính chào quý khách {{$user->name}}, Kacana vừa nhận được đơn hàng # {{$order->order_code}} của quý khách đặt ngày {{date("d-m-Y", strtotime($order->created_at))}} với hình thức thanh toán là Cash on Delivery.</span>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="border-spacing:0;border-collapse:collapse;font-size:14px">
                <tbody><tr>
                    <td align="center" valign="top" style="border-collapse:collapse">

                        <table width="600" border="0" cellpadding="0" cellspacing="0" style="border-spacing:0;border-collapse:collapse;font-size:14px;max-width:600px">
                            <tbody><tr>
                                <td style="border-collapse:collapse">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-spacing:0;border-collapse:collapse;font-size:14px;border-bottom:1px solid #dee2e3;width:100%!important">
                                        <tbody><tr>
                                            <td width="50%" height="49" valign="middle" style="border-collapse:collapse;width:50%">
                                                <a href="http://kacana.com" target="_blank">
                                                    <img src="http://kacana.com/images/client/homepage/logo-main-color.png" width="150" alt="Kacana" class="CToWUd">
                                                </a>
                                            </td>
                                            <td width="50%" height="49" valign="bottom" style="border-collapse:collapse;text-align:right;width:50%">

                                            </td>
                                        </tr>
                                        </tbody></table>
                                </td>
                            </tr>

                            <tr>
                                <td style="border-collapse:collapse">

                                    <table border="0" cellpadding="0" cellspacing="0" align="left" style="border-spacing:0;border-collapse:collapse;font-size:14px; margin-top: 10px">


                                        <tbody><tr>
                                            <td valign="top" style="border-collapse:collapse">
                                                <h1 style="font-size:14px;color:#4c4848"><em style="background:#ff6">(Scroll down for English version)</em></h1>
                                                <div style="margin-top:20px"><strong style="font-size:16px">Kính chào quý khách {{$user->name}},</strong></div>
                                                <div style="margin-top:10px;margin-bottom:20px">
                                                    Kacana vừa nhận được <strong style="color:#4CAF50">đơn hàng # {{$order->order_code}}</strong>  của quý khách đặt ngày <strong>{{date("l F d, Y", strtotime($order->created_at))}}</strong> với hình thức thanh toán là <strong>Cash on Delivery</strong>.
                                                    Chúng tôi sẽ gửi thông báo đến quý khách qua một email khác ngay khi sản phẩm được giao cho đơn vị vận chuyển.
                                                </div>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td align="center" width="100%" style="border-collapse:collapse;background-color:#f2f4f6;border-top:2px solid #646464">
                                                <table width="48%" border="0" cellpadding="0" cellspacing="0" align="left" style="border-spacing:0;border-collapse:collapse;font-size:14px">
                                                    <tbody><tr>
                                                        <td align="left" valign="top" style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                            <div>
                                                                <div style="color:#646464">Thời gian giao hàng dự kiến:</div>


                                                                <div style="margin-top:5px;margin-bottom:10px"><strong>Kiện hàng # 1</strong>: {{date("M d", strtotime('+5 day'))}} - {{date("M d, Y", strtotime('+10 day'))}}</div>


                                                                <table width="100%" cellpadding="10" style="width:100%!important">
                                                                    <tbody><tr>
                                                                        <td valign="middle" align="center" style="background-color:#4CAF50;text-align:center;width:100%!important">
                                                                            <a href="{{url()}}/khach-hang/kiem-tra-don-hang/?orderCode={{$order->order_code}}&email={{$user->email}}" style="display:inline-block;text-decoration:none;color:#fff;width:100%!important" target="_blank" >
                                                                                TÌNH TRẠNG ĐƠN HÀNG
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody></table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody></table>

                                                <table width="48%" border="0" cellpadding="0" cellspacing="0" align="left" style="border-spacing:0;border-collapse:collapse;font-size:14px">
                                                    <tbody><tr>
                                                        <td valign="top" style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;text-align:left">
                                                            <div>
                                                                <div style="color:#646464">Đơn hàng sẽ được giao đến:</div>
                                                                <div style="margin-top:5px"><strong style="color:#4CAF50">{{$address->name}}</strong></div>
                                                                <div style="margin-top:5px">
                                                                    <strong>
                                                                        {{($address->street)}} <br> {{$district->name}}, {{$city->name}}  <br> Phone: {{$address->phone}}
                                                                    </strong>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody></table>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td align="left" style="border-collapse:collapse;padding:0">
                                                <div style="margin-top:20px;margin-bottom:10px;margin-right:10px"><strong>Sau đây là thông tin chi tiết về đơn hàng:</strong></div>
                                            </td>
                                        </tr>




                                        <tr>
                                            <td align="left" style="border-collapse:collapse;background-color:#fff8e7;border:1px dashed #e7ebed;padding:0">
                                                <div style="margin-top:10px;margin-bottom:10px;margin-left:10px;margin-right:10px">
                                                    <div style="margin-bottom:5px"><strong style="text-transform:uppercase">KIỆN HÀNG # 1 </strong><span>được giao bởi GiaoHangNhanh </span></div>
                                                    <div><strong style="display:inline-block;margin-right:5px">{{date("M d", strtotime('+5 day'))}} - {{date("M d, Y", strtotime('+10 day'))}} </strong><span style="display:inline-block;min-width:150px">với hình thức giao hàng Standard</span></div>
                                                </div>
                                            </td>
                                        </tr>



                                        <tr>
                                            <td style="border-collapse:collapse;border:1px dashed #e7ebed;border-bottom:none">
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" style="border-spacing:0;border-collapse:collapse;font-size:14px">
                                                    <tbody>
                                                        @foreach($orderDetail as $item)
                                                            <tr>
                                                                <td valign="top" align="center" height="120" style="border-collapse:collapse;padding-top:10px;padding-bottom:10px">
                                                                    <a href="{{$item->product_url}}" target="_blank" data-saferedirecturl="">
                                                                        <img src="{{'http:'.$item->image}}" style="width:120px" class="CToWUd">
                                                                    </a>
                                                                </td>
                                                                <td valign="top" style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                                    <div style="margin-bottom:5px">
                                                                        <a href="{{$item->product_url}}" style="text-decoration:none;color:#292929; font-weight: bold" target="_blank" >
                                                                            {{$item->name}}
                                                                        </a>
                                                                    </div>
                                                                    <div style="margin-bottom:5px;color:#646464">Số lượng: {{$item->quantity}}</div>
                                                                    <div style="margin-bottom:5px;color:#646464">Giá : {{ formatMoney($item->price)}}</div>
                                                                    @if($item->discount)
                                                                        <div class="cart-item-price" >
                                                                            Giảm giá: <b>{{formatMoney($item->discount)}}</b>
                                                                        </div>
                                                                    @elseif($item->discount_type)
                                                                        @if($item->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT)
                                                                            <div class="cart-item-price" >
                                                                                Tặng <a target="_blank" class="color-red" href="{{urlProductDetail($item->discountProductRef)}}">
                                                                                    {{$item->discountProductRef->name}}
                                                                                    <img style="width: 50px;" src="{{$item->discountProductRef->image}}"></a>
                                                                            </div>
                                                                        @else
                                                                            <div class="cart-item-price" >
                                                                                Giảm giá: <span class="color-red" >{{savingDiscount($item->discount_type, $item->discount_ref,$item->price)}}</span>
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                    @if($item->color_id)
                                                                        <div style="margin-bottom:5px;color:#646464">Màu Sắc : {{ $item->color->name }}</div>
                                                                    @endif
                                                                    @if($item->size_id)
                                                                        <div style="margin-bottom:5px;color:#646464">Màu Sắc : {{ $item->size->name }}</div>
                                                                    @endif
                                                                </td>
                                                                <td valign="top" align="right" style="border-collapse:collapse;padding-top:10px;padding-right:10px">
                                                                    <strong>{{ formatMoney($item->subtotal)}}</strong>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>



                                        <tr>
                                            <td style="border-collapse:collapse;border:1px dashed #e7ebed">
                                                <div>
                                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="left" style="border-spacing:0;border-collapse:collapse;font-size:14px;width:100%!important">
                                                        <tbody><tr>
                                                            <td valign="top" align="right" style="border-collapse:collapse;padding-top:10px;padding-right:10px;color:#646464;width:80%">Thành tiền:</td>
                                                            <td valign="top" align="right" style="border-collapse:collapse;padding-top:10px;padding-right:10px;color:#292929;min-width:140px">{{ formatMoney($order->total - $order->shipping_fee)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;color:#646464;width:80%">Phí giao hàng:</td>
                                                            @if(!$order->shipping_fee)
                                                                <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;color:#292929;min-width:140px">Miễn Phí</td>
                                                            @else
                                                                <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;color:#292929;min-width:140px">{{ formatMoney($order->shipping_fee)}}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;color:#646464;width:80%">Giảm giá (Voucher):</td>
                                                            <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;color:#292929;min-width:140px">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" align="right" style="border-collapse:collapse;padding-top:10px;padding-right:10px;font-size:16px;width:80%"><strong>Tổng cộng:</strong></td>
                                                            <td valign="top" align="right" style="border-collapse:collapse;padding-top:10px;padding-right:10px;font-size:16px;color:#646464;min-width:140px"><strong style="color:#4CAF50">{{ formatMoney($order->total)}}</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" align="right" style="border-collapse:collapse;width:80%"></td>
                                                            <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;padding-bottom:10px;font-size:13px;color:#646464;min-width:140px">(Đã bao gồm VAT trong giá bán sản phẩm)</td>
                                                        </tr>
                                                        </tbody></table>
                                                </div>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td align="left" style="border-collapse:collapse;padding:0">
                                                <table border="0" cellpadding="0" cellspacing="0" align="left" style="border-spacing:0;border-collapse:collapse;font-size:14px">
                                                    <tbody><tr>
                                                        <td valign="top" style="border-collapse:collapse">
                                                            <div style="margin-top:20px"><strong>Lưu ý:</strong></div>

                                                            <div style="margin:5px 0 10px 5px;margin-bottom:20px;color:#646464">
                                                                <div>•&nbsp;&nbsp;Quý khách vui lòng chuẩn bị sẵn số tiền mặt tương ứng để thuận tiện cho việc thanh toán.
                                                                    <div>•&nbsp;&nbsp;Trong một số trường hợp, Kacana sẽ thực hiện cuộc gọi tự động hoặc gửi tin nhắn đến số điện thoại quý khách đã đăng ký để xác nhận đơn hàng. Để đơn hàng được xử lý nhanh chóng, xin quý khách vui lòng thực hiện theo hướng dẫn của cuộc gọi hoặc nội dung tin nhắn nhận được. Nếu Kacana không nhận được phản hồi từ quý khách, đơn hàng sẽ được ngưng thực hiện do xác nhận không thành công.</div>

                                                                    <div>

                                                                    </div>
                                                                </div>
                                                            </div></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" width="100%">
                                                        </td>
                                                    </tr>
                                                    </tbody></table>
                                            </td>
                                        </tr>



                                        <tr>
                                            <td align="left" style="border-collapse:collapse;padding:0;border-top:1px dashed #e7ebed;border-bottom:2px solid #4CAF50">
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" style="border-spacing:0;border-collapse:collapse;font-size:14px">
                                                    <tbody><tr>
                                                        <td valign="bottom" style="border-collapse:collapse">
                                                            <div style="margin-top:20px;margin-bottom:15px">
                                                                <div><strong>Quý khách cần hỗ trợ thêm?</strong></div>
                                                                <div style="margin-top:5px">Nếu có bất cứ thắc mắc nào, mời quý khách tham khảo trang <a href="http://info.kacana.com" style="text-decoration:none;color:#199cb7" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=vi&amp;q=http://info.kacana.com/c/r?ACTION%3Dri%26EMID%3D09004HT02NOCH007SSMRP%26UID%3DMJJCCUPHX4PK6QHWXHSA&amp;source=gmail&amp;ust=1472662956597000&amp;usg=AFQjCNEtKvMOieXXAfXgS1FvdebeWUXnrg">Trung tâm hỗ trợ</a>. Để liên hệ với chúng tôi, quý khách vui lòng để lại tin nhắn tại trang
                                                                    <a href="http://info.kacana.com" style="text-decoration:none;color:#199cb7" target="_blank" >Liên Hệ</a>.</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody></table>
                                            </td>
                                        </tr>
                                        </tbody></table>
                                </td>
                            </tr>


                            <tr>
                                <td style="border-collapse:collapse;padding-top:13px">

                                    <table border="0" cellpadding="0" cellspacing="0" align="left" style="border-spacing:0;border-collapse:collapse;font-size:14px">


                                        <tbody><tr>
                                            <td valign="top" style="border-collapse:collapse">
                                                <div style="margin-top:5px"><strong style="font-size:16px">Dear {{$user->name}},</strong></div>
                                                <div style="margin-top:10px;margin-bottom:20px">
                                                    Your <strong style="color:#4CAF50">Order # {{$order->order_code}}</strong> has been placed on <strong>{{date("l F d, Y", strtotime($order->created_at))}}</strong> via <strong>Cash on Delivery</strong>.

                                                </div>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td align="center" width="100%" style="border-collapse:collapse;background-color:#f2f4f6;border-top:2px solid #646464">
                                                <table width="48%" border="0" cellpadding="0" cellspacing="0" align="left" style="border-spacing:0;border-collapse:collapse;font-size:14px">
                                                    <tbody><tr>
                                                        <td align="left" valign="top" style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                            <div>
                                                                <div style="color:#646464">This order will arrive by:</div>


                                                                <div style="margin-top:5px;margin-bottom:10px"><strong>Shipment # 1</strong>: {{date("M d", strtotime('+5 day'))}} - {{date("M d, Y", strtotime('+10 day'))}}</div>


                                                                <table width="100%" cellpadding="10" style="width:100%!important">
                                                                    <tbody><tr>
                                                                        <td valign="middle" align="center" style="background-color:#4CAF50;text-align:center;width:100%!important">
                                                                            <a href="{{url()}}/khach-hang/kiem-tra-don-hang/?orderCode={{$order->order_code}}&email={{$user->email}}" style="display:inline-block;text-decoration:none;color:#fff;width:100%!important" target="_blank" >ORDER STATUS</a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody></table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody></table>

                                                <table width="48%" border="0" cellpadding="0" cellspacing="0" align="left" style="border-spacing:0;border-collapse:collapse;font-size:14px">
                                                    <tbody><tr>
                                                        <td valign="top" style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;text-align:left">
                                                            <div>
                                                                <div style="color:#646464">Your Order will be delivered to:</div>
                                                                <div style="margin-top:5px"><strong style="color:#4CAF50">{{$address->name}}</strong></div>
                                                                <div style="margin-top:5px">
                                                                    <strong>
                                                                        {{($address->street)}} <br> {{$district->name}}, {{$city->name}}  <br> Phone: {{$address->phone}}
                                                                    </strong>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody></table>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td align="left" style="border-collapse:collapse;padding:0">
                                                <div style="margin-top:20px;margin-bottom:10px;margin-right:10px"><strong>Order details:</strong></div>
                                            </td>
                                        </tr>




                                        <tr>
                                            <td align="left" style="border-collapse:collapse;background-color:#fff8e7;border:1px dashed #e7ebed;padding:0">
                                                <div style="margin-top:10px;margin-bottom:10px;margin-left:10px;margin-right:10px">
                                                    <div style="margin-bottom:5px"><strong style="text-transform:uppercase">Shipment # 1 </strong><span>Shiping by GiaoHangNhanh </span></div>
                                                    <div><strong style="display:inline-block;margin-right:5px">{{date("M d", strtotime('+5 day'))}} - {{date("M d, Y", strtotime('+10 day'))}}</strong><span style="display:inline-block;min-width:150px">via Standard Delivery</span></div>
                                                </div>
                                            </td>
                                        </tr>



                                        <tr>
                                            <td style="border-collapse:collapse;border:1px dashed #e7ebed;border-bottom:none">
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" style="border-spacing:0;border-collapse:collapse;font-size:14px">
                                                    <tbody>
                                                        @foreach($orderDetail as $item)
                                                            <tr>
                                                                <td valign="top" align="center" height="120" style="border-collapse:collapse;padding-top:10px;padding-bottom:10px">
                                                                    <a href="{{$item->product_url}}" target="_blank" data-saferedirecturl="">
                                                                        <img src="{{'http:'.$item->image}}" style="width:120px" class="CToWUd">
                                                                    </a>
                                                                </td>
                                                                <td valign="top" style="border-collapse:collapse;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px">
                                                                    <div style="margin-bottom:5px">
                                                                        <a href="{{$item->product_url}}" style="text-decoration:none;color:#292929; font-weight: bold" target="_blank" >
                                                                            {{$item->name}}
                                                                        </a>
                                                                    </div>
                                                                    <div style="margin-bottom:5px;color:#646464">Qty: {{$item->quantity}}</div>
                                                                    <div style="margin-bottom:5px;color:#646464">Price : {{ formatMoney($item->price)}}</div>
                                                                    @if($item->discount)
                                                                        <div class="cart-item-price" >
                                                                            Discount: <b>{{formatMoney($item->discount)}}</b>
                                                                        </div>
                                                                    @elseif($item->discount_type)
                                                                        @if($item->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT)
                                                                            <div class="cart-item-price" >
                                                                                Free <a target="_blank" class="color-red" href="{{urlProductDetail($item->discountProductRef)}}">
                                                                                    {{$item->discountProductRef->name}}
                                                                                    <img style="width: 50px;" src="{{$item->discountProductRef->image}}"></a>
                                                                            </div>
                                                                        @else
                                                                            <div class="cart-item-price" >
                                                                                Discount: <span class="color-red" >{{savingDiscount($item->discount_type, $item->discount_ref,$item->price)}}</span>
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                                    @if($item->color_id)
                                                                        <div style="margin-bottom:5px;color:#646464">Color : {{ $item->color->name }}</div>
                                                                    @endif
                                                                    @if($item->size_id)
                                                                        <div style="margin-bottom:5px;color:#646464">Size: {{ $item->size->name }}</div>
                                                                    @endif
                                                                </td>
                                                                <td valign="top" align="right" style="border-collapse:collapse;padding-top:10px;padding-right:10px">
                                                                    <strong>{{ formatMoney($item->subtotal)}}</strong>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody></table>
                                            </td>
                                        </tr>



                                        <tr>
                                            <td style="border-collapse:collapse;border:1px dashed #e7ebed">
                                                <div>
                                                    <table border="0" width="100%" cellpadding="0" cellspacing="0" align="left" style="border-spacing:0;border-collapse:collapse;font-size:14px;width:100%!important">
                                                        <tbody><tr>
                                                            <td valign="top" align="right" style="border-collapse:collapse;padding-top:10px;padding-right:10px;color:#646464;width:80%">Subtotal:</td>
                                                            <td valign="top" align="right" style="border-collapse:collapse;padding-top:10px;padding-right:10px;color:#292929;min-width:140px">{{ formatMoney($order->total - $order->shipping_fee)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;color:#646464;width:80%">Shipping fee:</td>
                                                            @if(!$order->shipping_fee)
                                                                <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;color:#292929;min-width:140px">Free</td>
                                                            @else
                                                                <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;color:#292929;min-width:140px">{{ formatMoney($order->shipping_fee)}}</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;color:#646464;width:80%">Voucher:</td>
                                                            <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;color:#292929;min-width:140px">0</td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" align="right" style="border-collapse:collapse;padding-top:10px;padding-right:10px;font-size:16px;width:80%"><strong>Total:</strong></td>
                                                            <td valign="top" align="right" style="border-collapse:collapse;padding-top:10px;padding-right:10px;font-size:16px;color:#646464;min-width:140px">
                                                                <strong style="color:#4CAF50">
                                                                    {{ formatMoney($order->total)}}
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td valign="top" align="right" style="border-collapse:collapse;width:80%"></td>
                                                            <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;padding-bottom:10px;font-size:13px;color:#646464;min-width:140px">VAT Included</td>
                                                        </tr>
                                                        </tbody></table>
                                                </div>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td align="left" style="border-collapse:collapse;padding:0">

                                            </td>
                                        </tr>



                                        <tr>
                                            <td align="left" style="border-collapse:collapse;border-bottom:1px dashed #e7ebed;padding:0;border-top:1px dashed #e7ebed">
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="left" style="border-spacing:0;border-collapse:collapse;font-size:14px">
                                                    <tbody><tr>
                                                        <td valign="bottom" style="border-collapse:collapse">
                                                            <div style="margin-top:20px;margin-bottom:15px">
                                                                <div><strong>Need help?</strong></div>
                                                                <div style="margin-top:5px">Visit our <a href="http://info.kacana.com" style="text-decoration:none;color:#199cb7" target="_blank" >Help Center</a> for latest tips or you can leave us a message at our
                                                                    <a href="http://info.kacana.com" style="text-decoration:none;color:#199cb7" target="_blank">Contact</a> page.</div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    </tbody></table>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td valign="bottom" align="center" style="border-collapse:collapse;padding-top:10px">
                                                <a href="http://kacana.com" style="text-decoration:none;color:#292929" target="_blank" ><strong>Kacana.com</strong></a>
                                            </td>
                                        </tr>
                                        </tbody></table>
                                </td>
                            </tr>
                            </tbody></table>
                    </td>
                </tr>
                </tbody></table><div class="yj6qo"></div><div class="adL">
            </div>
        </div>
    </body>
</html>