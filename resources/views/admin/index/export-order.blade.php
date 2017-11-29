<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export order: FROM {{$from}} - TO {{$to}}</title>

    <style>
        .invoice-box{
            max-width:800px;
            margin:auto;
            border:1px solid #eee;
            box-shadow:0 0 10px rgba(0, 0, 0, .15);
            font-size:14px;
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
            padding-bottom:10px;
            background: #ddd;
            margin-top: 20px;
        }

        .invoice-box table tr.item td{
            border-bottom:1px solid #999;
        }

        .invoice-box table tr.item:last-child td{
            /*border-bottom:none;*/
            /*padding-bottom:40px;*/
        }

        .invoice-box table tr.total td:nth-child(2){
            border-top:2px solid #eee;
            font-weight:bold;
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
                            <b>Ecommerce system - Buy online</b><br><br>
                            Export Order FROM: <b>{{$from}}</b> => TO: <b>{{$to}}</b>
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
                            Docment type: <span style="font-size: 20px" >Secret</span><br>
                            Priority: <b>TOP</b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    @foreach($ordersGroup as $orderGroup)
        <table cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td>
                    Date: {{$orderGroup->date}}
                </td>

                <td>
                    total: {{formatMoney($orderGroup->item)}}
                </td>
            </tr>
        </table>

            @foreach($orders as $order)
                @if($order->date == $orderGroup->date)
                <table cellpadding="0" cellspacing="0">
                    <tr class="details">
                        <td>
                            Name: {{$order->addressReceive->name}}<br>
                            Phone: <b>{{$order->addressReceive->phone}}</b><br>
                            Total: <b>{{formatMoney($order->total)}}</b><br>
                        </td>

                        <td>
                            {{isset($order->addressReceive->street)?$order->addressReceive->street:''}}<br>
                            {{(isset($order->addressReceive->district_id) && $order->addressReceive->district_id)?$order->addressReceive->district->name:''}}<br>
                            {{(isset($order->addressReceive->city_id) && $order->addressReceive->city_id)?$order->addressReceive->city->name:''}}<br>
                        </td>
                    </tr>
                </table>
                <table style="margin-bottom: 30px" cellpadding="0" cellspacing="0">
                    <tr class="detail">
                        <td style="width: 40%;font-weight: bold">
                            Sản phẩm
                        </td>

                        <td style="width: 15%;text-align: center;font-weight: bold" >
                            Số lượng
                        </td>
                        <td style="width: 15%;text-align: right;font-weight: bold" >
                            Giá
                        </td>
                        <td style="width: 15%;text-align: right;font-weight: bold" >
                            Giảm giá
                        </td>
                        <td style="width: 15%;text-align: right;font-weight: bold" >
                            Tổng
                        </td>
                    </tr>
                    @foreach($order->orderDetail as $orderDetail)
                        <tr class="item">
                            <td>
                                {{$orderDetail->name}}
                            </td>

                            <td style="text-align: center" >
                                {{$orderDetail->quantity}}
                            </td>
                            <td style="text-align: right" >
                                {{formatMoney($orderDetail->price)}}
                            </td>
                            <td style="text-align: right" >
                                {{formatMoney($orderDetail->discount)}}
                            </td>
                            <td style="text-align: right" >
                                {{formatMoney($orderDetail->subtotal)}}
                            </td>
                        </tr>
                    @endforeach
                </table>
                @endif
            @endforeach
    @endforeach



    <p style="width: 100%; font-size: 30px; text-align: center; margin-top: 50px;" >
        It’s everywhere you want to be
    </p>
</div>
<script>
//    window.print();
</script>
</body>
</html>