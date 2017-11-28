<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>In barcode sản phẩm: {{$product->name}}</title>
    <link href="/css/admin/admin.css" rel="stylesheet" type="text/css"/>
    <style>
        body {
            padding: 0;
            margin: 0;
            color: #000000;
        }

        .barcode-label {
            margin-top: 0px;
        }

        .basic-info {
            width: 960px;
            display: block;
            float: left;
        }

        .basic-info .logo {
            text-align: center;
            width: 100%;
            display: block;
        }

        .basic-info .product-name {
            font-size: 60px;
            text-align: center;
            font-weight: 500;
            padding: 30px 0 10px;
            max-height: 140px;
            overflow: hidden;
        }

        .basic-info .property-name {
            font-size: 60px;
            text-align: center;
            font-weight: 500;
            padding: 0px 0 10px;
        }

        .basic-info .logo img {
            max-width: 45%;
            padding: 7px 30px 0;
        }

        .barcode {
            clear: both;
        }

        .barcode .property-code {
            width: 960px;
            display: block;
            overflow: hidden;
            height: 370px;
            padding: 5px 10px;
            float: left;
        }

        .barcode .bardcode-number {
            text-align: center;
            font-size: 60px;
            font-weight: 600;
        }
        .barcode .product-price {
            text-align: center;
            font-size: 80px;
            font-weight: 600;
        }

        .product-link img {
            margin-left: 8px;
        }
    </style>
</head>

<body>
<div class="barcode-label">
    <div class="basic-info">
        <div class="logo">
            <img src="//image.kacana.vn/images/client/logo-print-label.jpg">
        </div>
        <div class="product-name">{{$product->name}}</div>
        <div class="property-name">{{$property->color->name}}</div>
    </div>
    {{--<div class="product-link">--}}
    {{--<img src="data:image/png;base64,{{generateQrcode(urlProductDetail($product))}}">--}}
    {{--</div>--}}
    <div class="barcode">
        <div class="property-code">
            <img src="data:image/png;base64,{{generateBarcode($property->id)}}">
            <div class="bardcode-number">983 {{$product->id}} {{$property->id}}</div>
            <div class="product-price">{{formatMoney($product->sell_price)}}</div>
        </div>
    </div>
</div>
<script>
                window.print();
</script>
</body>
</html>