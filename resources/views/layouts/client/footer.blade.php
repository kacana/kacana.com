<footer id="footer">
    <div class="container">
        <div class="row">

            <div class="hidden-xs col-sm-5">
                <div class="newsletter">
                    <h4>ĐĂNG KÝ NHẬN TIN</h4>
                    <div class="alert alert-success hidden" id="newsletterSuccess">
                        <strong>Success!</strong> You've been added to our email list.
                    </div>

                    <div class="alert alert-danger hidden" id="newsletterError"></div>

                    <form id="newsletterForm" action="php/newsletter-subscribe.php" method="POST">
                        <div class="input-group">
                            <input class="form-control" placeholder="Địa chỉ email của bạn" name="newsletterEmail" id="newsletterEmail" type="text">
										<span class="input-group-btn">
											<button class="btn btn-default" type="submit">Go!</button>
										</span>
                        </div>
                    </form>

                    <ul class="contact margin-top-10px">
                        <li>
                            Hộ Kinh Doanh: TÚI XÁCH KACANA
                        </li>
                        <li>
                            Giấy CNĐKDN: 41E8 033230 - Ngày cấp: 05/04/2017 - Cấp lần đầu
                        </li>
                        <li>
                            Cơ quan cấp: Uỷ ban nhân dân quận 5, Hồ Chí Minh
                        </li>
                        <li>
                            Địa chỉ đăng ký kinh doanh: Số 60/36 Trần Hưng Đạo, Phường 7, Quận 5, Hồ Chí Minh
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-sm-5">
                <div class="contact-details">
                    <h4>Liên Hệ</h4>
                    <ul class="contact">
                        <li><p><i class="fa fa-map-marker"></i> <strong>Địa Chỉ:</strong> 60/36 Trần Hưng Đạo, phường 7, Quận 5, Hồ Chí Minh</p></li>
                        <li><p><i class="fa fa-phone"></i> <strong>Điện Thoại :</strong> 0906.054.206 - 01695.393.076</p></li>
                        <li><p><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:info@gmail.com">info@kacana.com</a></p></li>
                        <li><p><i class="fa fa-facebook"></i> <strong>Facebook:</strong> <a target="_blank" href="https://www.facebook.com/TuiXachKacana">facebook.com/TuiXachKacana</a></p></li>
                    </ul>
                </div>
            </div>

            <div class="hidden-xs col-sm-2">
                <div class="contact-details">
                    <h4>Sản phẩm</h4>
                    <ul class="contact">
                        @foreach($menu_items as $item)
                                <li>
                                    <a href="{{urlTag($item)}}">{{ $item->name }}</a>
                                </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="footer-copyright">--}}
        {{--<div class="container">--}}
            {{--<div class="row">--}}
                {{--<div class="col-xs-12 text-center">--}}
                    {{--<nav id="sub-menu">--}}
                        {{--<ul>--}}
                            {{--<li><a href="/contact/cau-hoi">FAQ's</a></li>--}}
                            {{--<li><a href="/sitemap.xml">Sitemap</a></li>--}}
                            {{--<li><a href="/contact/thong-tin-lien-he">Liên Hệ</a></li>--}}
                        {{--</ul>--}}
                    {{--</nav>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
</footer>