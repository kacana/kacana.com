<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>In barcode sản phẩm: {{$product->name}}</title>

        <style>
            body{
                padding: 0;
                margin: 0;
                font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            }
            .barcode-label{
                margin-top: 17px;
            }
            .basic-info{
                height: 100px;
                width: 260px;
                display: block;
                float: left;
            }
            .basic-info .logo{
                text-align: center;
                width: 100%;
                display: block;
            }
            .basic-info .price{
                font-size: 40px;
                text-align: center;
                font-weight: 500;
            }
            .basic-info .logo img{
                max-width: 60%;
                padding: 10px;
            }
            .barcode{
                clear: both;
            }
            .barcode .property-code{
                width: 380px;
                display: block;
                overflow: hidden;
                height: 125px;
                padding: 10px;
                float: left;
            }
            .barcode .bardcode-number
            {
                text-align: center;
                font-size: 25px;
            }
            .product-link{
                float: left;
                width: 100px;
                margin: 10px 0 0 0;

            }
            .product-link img{
                margin-left: 8px;
            }
        </style>
    </head>

    <body>
        <div class="barcode-label">
            <div class="basic-info" >
                <div class="logo">
                    <img src="//image.kacana.vn/images/client/logo_print.jpg">
                </div>
                <div class="price" >
                    {{formatMoney($product->sell_price)}}
                </div>
            </div>
            <div class="product-link">
                <img src="data:image/png;base64,{{generateQrcode(urlProductDetail($product))}}">
            </div>
            <div class="barcode">
                <div class="property-code" >
                    <img src="data:image/png;base64,{{generateBarcode($property->id)}}">
                    <div class="bardcode-number" >
                        983 {{$product->id}} {{$property->id}}
                    </div>
                </div>
            </div>
        </div>
        <script>
            window.print();
        </script>
    </body>
</html>