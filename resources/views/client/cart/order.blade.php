@extends('layouts.client.master')

@section('content')
    <div role="main" class="main shop">
        <div class="container">
            <hr class="tall">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            Chi tiết đơn đặt hàng
                        </a>
                    </h4>
                </div>
                <div>
                    <div class="panel-body">
                        <table cellspacing="0" class="shop_table cart">
                            <thead>
                            <tr>
                                <th class="product-name">
                                    Sản phẩm
                                </th>
                                <th class="product-color center">
                                    Màu sắc
                                </th>
                                <th class="product-price center">
                                    Giá
                                </th>
                                <th class="product-quantity center">
                                    Số lượng
                                </th>
                                <th class="product-subtotal center">
                                    Tổng số tiền
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($items as $item)
                            <tr class="cart_table_item">
                                <td class="product-name">
                                    <a href="shop-product-sidebar.html">{{$item->name}}</a>
                                </td>
                                <td class="product-price" align="center">
                                    <span class="amount">{{formatMoney($item->price)}}</span>
                                </td>
                                <td class="product-quantity" align="center">
                                    {{$item->quantity}}
                                </td>
                                <td class="product-subtotal" align="center">
                                    <span class="amount">{{formatMoney($item->subtotal)}}</span>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <hr class="tall">

                        <h4>Cart Totals</h4>
                        <table cellspacing="0" class="cart-totals">
                            <tbody>
                            <tr class="cart-subtotal">
                                <th>
                                    <strong>Cart Subtotal</strong>
                                </th>
                                <td>
                                    <strong><span class="amount">{{formatMoney($order->total)}}</span></strong>
                                </td>
                            </tr>
                            <tr class="shipping">
                                <th>
                                    Shipping
                                </th>
                                <td>
                                    Free Shipping<input type="hidden" value="free_shipping" id="shipping_method" name="shipping_method">
                                </td>
                            </tr>
                            <tr class="total">
                                <th>
                                    <strong>Order Total</strong>
                                </th>
                                <td>
                                    <strong><span class="amount">{{formatMoney($order->total)}}</span></strong>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop