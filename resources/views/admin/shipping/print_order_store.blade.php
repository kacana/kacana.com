<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Shipping - {{$order->order_code}}</title>

    <style>
        .invoice-box{
            max-width:800px;
            margin:auto;
            border:1px solid #eee;
            box-shadow:0 0 10px rgba(0, 0, 0, .15);
            font-size:16px;
            line-height:24px;
            font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color:#000;
        }

        .invoice-box table{
            width:100%;
            line-height:inherit;
            text-align:left;

        }

        .invoice-box table td{
            padding:5px;
            vertical-align:top;
        }

        .invoice-box table tr td:nth-child(2){
            text-align:right;
        }

        .invoice-box table tr.top table td{
            padding-bottom:20px;
        }

        .invoice-box table tr.top table td.title{
            font-size:45px;
            line-height:45px;
            color:#333;
        }
        .invoice-box table tr.top table td.title span{
            display: block;
            font-size: 18px;
            font-weight: bold;
            margin-top: -5px;
            text-align: center;
        }
        .invoice-box table tr.information table td{
            padding-bottom:40px;
        }

        .invoice-box table tr.heading td{
            background:#999;
            border-bottom:1px solid #000;
            font-weight:bold;
            -webkit-print-color-adjust: exact;
        }

        .invoice-box table tr.details td{
            padding-bottom:20px;
        }

        .invoice-box table tr.item td{
            border-bottom:1px solid #999;
        }

        .invoice-box table tr.item.last td{
            border-bottom:none;
        }

        .invoice-box table tr.total td:nth-child(2){
            border-top:2px solid #eee;
            font-weight:bold;
        }
        .label-for-main-info{
            width: 150px;
            display: inline-block;
            margin-top: 10px;
        }
        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td{
                width:100%;
                display:block;
                text-align:center;
            }

            .invoice-box table tr.information table td{
                width:100%;
                display:block;
                text-align:center;
            }
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td style="width: 35%;" class="title">
                            <img src="{{AWS_CDN_URL}}/images/client/logo_print.jpg" style="width:100%; max-width:300px;">
                            <span >http://kacana.vn</span>
                        </td>

                        <td style="text-align: left;padding-left: 20px;font-size: 15px">
                            <b>Hệ thống thương mại điện tử - Mua hàng trực tuyến</b><br><br>
                            Hỗ trợ khách hàng 7 ngày/tuần: <b>0399.761.768</b><br>
                            Truy cập: http://hotro.kacana.vn
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                            <span class="label-for-main-info">Mã đơn hàng: </span><span style="font-size: 20px" >{{$order->order_code}}</span><br>
                            <span class="label-for-main-info">Ngày mua hàng: </span><b>{{$order->created_at}}</b> <br>
                            <span class="label-for-main-info">Cửa hàng: </span><b>{{$order->orderType->name}}</b><br>
                            <span class="label-for-main-info">Nhân viên BH: </span><b>{{$user->name}}</b><br>
                            <span class="label-for-main-info">Địa chỉ: </span><b>{{KACANA_HEAD_ADDRESS_STREET}}, {{KACANA_HEAD_ADDRESS_WARD}}, {{KACANA_HEAD_ADDRESS_DISTRICT}}, {{KACANA_HEAD_ADDRESS_CITY}}</b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td>
                Thông tin thanh toán
            </td>

            <td>
                Địa chỉ giao hàng
            </td>
        </tr>

        <tr class="details">
            <td>
                {{isset($user_address->name)?$user_address->name:''}}<br>
                Điện thoại: <b>{{$user_address->phone}}</b>
            </td>

            <td>
                {{isset($user_address->street)?$user_address->street:''}}<br>
                {{(isset($user_address->district_id) && $user_address->district_id)?$user_address->district->name:''}}<br>
                {{(isset($user_address->city_id) && $user_address->city_id)?$user_address->city->name:''}}<br>
            </td>
        </tr>
    </table>

    <table cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td style="width: 40%;">
                Sản phẩm
            </td>

            <td style="width: 15%;text-align: center" >
                Số lượng
            </td>
            <td style="width: 15%;text-align: right" >
                Giá
            </td>
            <td style="width: 15%;text-align: right" >
                Giảm giá
            </td>
            <td style="width: 15%;text-align: right" >
                Tổng
            </td>
        </tr>
        @foreach($order->orderDetail as $orderDetail)
            <tr class="item">
                <td>
                    {{$orderDetail->name}}
                    @if($orderDetail->discount_type == KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT)
                        <br><small style="margin-left: 10px;font-weight: bold">Tặng: {{$orderDetail->discountProductRef->name}}</small>
                    @endif
                </td>

                <td style="text-align: center" >
                    {{$orderDetail->quantity}}
                </td>
                <td style="text-align: right" >
                    {{formatMoney($orderDetail->price)}}
                </td>
                <td style="text-align: right" >
                    @if($orderDetail->discount_type != KACANA_CAMPAIGN_DEAL_TYPE_FREE_PRODUCT && $orderDetail->discount_type > 0)
                        {{savingDiscount($orderDetail->discount_type, $orderDetail->discount_ref, $orderDetail->price)}}
                    @else
                        0
                    @endif
                </td>
                <td style="text-align: right" >
                    {{formatMoney($orderDetail->subtotal)}}
                </td>
            </tr>
        @endforeach

    </table>

    <table cellpadding="0" cellspacing="0">
        <tr class="item">
            <td style="text-align: right" >
                Tổng chưa giảm
            </td>

            <td style="text-align: right" >
                {{formatMoney($order->origin_total)}}
            </td>
        </tr>
        <tr class="item">
            <td style="text-align: right" >
                Giảm giá
            </td>

            <td style="text-align: right" >
                {{formatMoney($order->discount)}}
            </td>
        </tr>
        @if($order->extra_discount)
            <tr class="item">
                <td style="text-align: right" >
                    Giảm thêm ( {{$order->extra_discount_desc}} )
                </td>

                <td style="text-align: right" >
                    {{formatMoney($order->extra_discount)}}
                </td>
            </tr>
        @endif
        <tr class="item last">
            <td style="text-align: right" >
                Tổng cộng
            </td>

            <td style="text-align: right" >
                <b>{{formatMoney($order->total)}}</b>
            </td>
        </tr>
    </table>
    <p style="width: 100%; font-size: 30px; text-align: center; margin-top: 50px;" >
        It’s everywhere you want to be
    </p>
</div>
<script>
    window.print();
</script>
</body>
</html>