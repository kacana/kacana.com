<?php
    $orderDetail = $order->orderDetail;
    $address = $order->addressReceive;
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Thông tin đơn hàng đặt nhanh[{{$address->phone}}]</title>
    </head>
    <body style="font-family: arial; font-size:13px">
        <div marginwidth="0" marginheight="0" style="margin:0;padding:15px 10px;color:#292929;font-family:Helvetica,Arial,sans-serif">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="border-spacing:0;border-collapse:collapse;font-size:14px">
                <tbody><tr>
                    <td align="center" valign="top" style="border-collapse:collapse">

                        <table width="600" border="0" cellpadding="0" cellspacing="0" style="border-spacing:0;border-collapse:collapse;font-size:14px;max-width:600px">
                            <tbody>
                                <tr>
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

                                            <tbody>

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
                                                                    <td valign="top" align="right" style="border-collapse:collapse;padding-top:10px;padding-right:10px;color:#292929;min-width:140px">{{formatMoney($order->total - $order->shipping_fee)}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;color:#646464;width:80%">Phí giao hàng:</td>
                                                                    @if($order->total >= 500000)
                                                                        <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;color:#292929;min-width:140px">Miễn Phí</td>
                                                                    @else
                                                                        <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;color:#292929;min-width:140px"><small>Hồ Chí Minh: 15.000 đ <br>Khác: 30.000 đ</small></td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;color:#646464;width:80%">Giảm giá (Voucher):</td>
                                                                    <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;color:#292929;min-width:140px">0</td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="right" style="border-collapse:collapse;padding-top:10px;padding-right:10px;font-size:16px;width:80%"><strong>Tổng cộng:</strong></td>
                                                                    <td valign="top" align="right" style="border-collapse:collapse;padding-top:10px;padding-right:10px;font-size:16px;color:#646464;min-width:140px"><strong style="color:#4CAF50">{{ formatMoney($order->total)}} + ship</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" align="right" style="border-collapse:collapse;width:80%"></td>
                                                                    <td valign="top" align="right" style="border-collapse:collapse;padding-top:5px;padding-right:10px;padding-bottom:10px;font-size:13px;color:#646464;min-width:140px">(Đã bao gồm VAT trong giá bán sản phẩm)</td>
                                                                </tr>
                                                                </tbody></table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody></table><div class="yj6qo"></div><div class="adL">
            </div>
        </div>
    </body>
</html>