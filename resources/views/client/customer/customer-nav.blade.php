<aside id="customer-nav" class="sidebar customer-nav">
    <h4 class="color-green">Tài khoản của Tôi</h4>
    @if(\Kacana\Util::isLoggedIn())
        <ul class="nav nav-list primary push-bottom customer-nav-loggedin">
            <li><a
                        @if(Route::current()->getName() == 'CustomerAccount'
                            || Route::current()->getName() == 'CustomerAccountUpdateInformation'
                            || Route::current()->getName() == 'CustomerAccountUpdatePassword'
                        )
                                class="color-green"
                        @endif
                        href="/khach-hang/tai-khoan"><i class="pe-7s-config"></i>Quản lý tài khoản</a></li>

            <li><a
                        @if(Route::current()->getName() == 'CustomerMyOrder'
                            || Route::current()->getName() == 'CustomerTrackingMyOrder'
                            || Route::current()->getName() == 'CustomerTrackingOrder'
                        )
                        class="color-green"
                        @endif
                        href="/khach-hang/don-hang-cua-toi"><i class="pe-7s-ribbon"></i>Đơn hàng của tôi</a></li>
            <li><a
                        @if(Route::current()->getName() == 'CustomerProductLike'
                        )
                        class="color-green"
                        @endif
                        href="/khach-hang/danh-sach-yeu-thich"><i class="pe-7s-like"></i>Danh sách yêu thích</a></li>
            <li><a
                        @if(Route::current()->getName() == 'CustomerMyAddess'
                            || Route::current()->getName() == 'CustomerMyAddessDetail'
                            || Route::current()->getName() == 'CustomerAddNewAddressReceive'
                        )
                        class="color-green"
                        @endif
                        href="/khach-hang/so-dia-chi"><i class="pe-7s-map-marker"></i>Sổ địa chỉ</a></li>
            <li><a href="/auth/sign-out"><i class="pe-7s-angle-right-circle"></i>Đăng xuất</a></li>
        </ul>
    @else
        <ul class="nav nav-list primary push-bottom">
            <li><a  href="#login-header-popup">Đăng nhập</a></li>
            <li><a href="#signup-header-popup">Đăng kí</a></li>
        </ul>
    @endif

</aside>