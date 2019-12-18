<footer id="footer">
    <div class="container">
        <div class="row">

            <div class="hidden-xs col-sm-5">
                <div class="newsletter">
                    <span class="text-head">Đăng kí nhận tin</span>
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
                            Địa chỉ đăng ký kinh doanh: {{KACANA_HEAD_ADDRESS_STREET}}, {{KACANA_HEAD_ADDRESS_WARD}}, {{KACANA_HEAD_ADDRESS_DISTRICT}}, {{KACANA_HEAD_ADDRESS_CITY}}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-sm-5">
                <div class="contact-details">
                    <span class="text-head">Liên Hệ</span>
                    <ul class="contact">
                        <li><p><i class="fa fa-map-marker"></i> <strong>Địa Chỉ:</strong> {{KACANA_HEAD_ADDRESS_STREET}}, {{KACANA_HEAD_ADDRESS_WARD}}, {{KACANA_HEAD_ADDRESS_DISTRICT}}, {{KACANA_HEAD_ADDRESS_CITY}}</p></li>
                        <li><p><i class="fa fa-phone"></i> <strong>Điện Thoại :</strong> 0906.054.206 - 01695.393.076</p></li>
                        <li><p><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:info@gmail.com">info@kacana.com</a></p></li>
                        <li><p><i class="fa fa-facebook"></i> <strong>Facebook:</strong> <a target="_blank" href="https://www.facebook.com/TuiXachKacana">facebook.com/TuiXachKacana</a></p></li>
                    </ul>
                </div>
            </div>

            <div class="hidden-xs col-sm-2">
                <div class="contact-details">
                    <span class="text-head color-white">Sản phẩm</span>
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
    <div id="{{KACANA_USER_TRACKING_HISTORY_ID}}" data-id="{{\Session::get(KACANA_USER_TRACKING_HISTORY_ID)}}" ></div>
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