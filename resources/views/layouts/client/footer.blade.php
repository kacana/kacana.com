<footer id="footer">
    <div class="container">
        <div class="row">

            <div class="hidden-xs col-sm-4">
                <div class="newsletter">
                    <h4>ĐĂNG KÝ NHẬN TIN</h4>
                    <p>Đăng ký nhận tin mới và chương trình khuyến mãi của Kacana</p>

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
                </div>
            </div>

            <div class="col-sm-4">
                <div class="contact-details">
                    <h4>Liên Hệ</h4>
                    <ul class="contact">
                        <li><p><i class="fa fa-map-marker"></i> <strong>Địa Chỉ:</strong> 43 Tản Đà, Phường 10, Quận 5, Hồ Chí Minh</p></li>
                        <li><p><i class="fa fa-phone"></i> <strong>Điện Thoại :</strong> 0906.054.206 - 01695.393.076</p></li>
                        <li><p><i class="fa fa-envelope"></i> <strong>Email:</strong> <a href="mailto:info@gmail.com">info@kacana.com</a></p></li>
                        <li><p><i class="fa fa-facebook"></i> <strong>Facebook:</strong> <a target="_blank" href="https://www.facebook.com/profile.php?id=100009296741412">facebook.com/kacanafashion</a></p></li>
                    </ul>
                </div>
            </div>

            <div class="hidden-xs col-sm-3 col-sm-offset-1">
                <div class="contact-details">
                    <h4>Sản phẩm</h4>
                    <ul class="contact">
                        @foreach($menu_items as $item)
                                <li>
                                    <a href="">{{ $item->name }}</a>
                                </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <nav id="sub-menu">
                        <ul>
                            <li><a href="/contact/cau-hoi">FAQ's</a></li>
                            <li><a href="/sitemap.xml">Sitemap</a></li>
                            <li><a href="/contact/thong-tin-lien-he">Liên Hệ</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</footer>