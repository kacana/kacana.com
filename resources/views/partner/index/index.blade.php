@extends('layouts.partner.master')

@section('content')
    <section class="content-header">
        <h1>
            Hướng dẫn sử dụng công cụ kacana partner
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tổng quan</h3>
                    </div>
                    <div class="box-body">
                        <h4 class="text-green">Kacana Partner sẽ giúp bạn</h4>
                        <h5>1. Đăng nhiều sản phẩm lên nhiều facebook một cách nhanh nhất chỉ bằng một click - tất cả các bài đăng sẽ được đồng bộ vào tạo nên thương hiệu của bạn (chúng tôi đã optimise SEO cho facebook với những bài đăng lên)</h5>
                        <h5>2. Bạn có thể tạo đơn hàng, gửi đơn hàng cho kacana và kiểm tra tình trạng đơn hàng ngay trong sách đơn hàng</h5>
                        <h5>3. Bạn có quản lý khách hàng, cập nhật thông tin khách hàng, danh sách đơn hàng của khách hàng</h5>
                        <h5>4. Bạn có quản lý chiết khấu. Tất cả chiết khấu, chiếc khấu tạm tính, chiết khấu khả dụng, chiết khấu đã chuyển và lịch sử chuyển tiền </h5>

                        <h4 class="text-green">Để bắt đầu</h4>
                        <img class="img-responsive" src="/images/partner/intro/start.jpg">

                 </div>
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-xs-12" >
                <div class="row" >
                    <div class="col-xs-12" >
                        <div class="box box-solid collapsed-box">
                            <div class="box-header with-border">
                                <i class="fa fa-rocket text-red"></i>
                                <h3 class="box-title text-red">Product Boot</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <h4 class="text-green">Boot 1 sản phẩm lên facebook</h4>
                                <h5>Bước 1: bấm "Product boot"</h5>
                                <img class="img-responsive" src="/images/partner/intro/pb_1.png">
                                <h5>Bước 2: chọn sản phẩm cần đăng và bấm "<i class="fa fa-rocket"></i>" để mở công cụ đăng </h5>
                                <img class="img-responsive" src="/images/partner/intro/pb_2.png">
                                <h5>Bước 3: Chọn hình ảnh - chỉnh sửa nội dung đăng - chọn tài khoản facebook và bấm "Đăng bài" để đăng bài  </h5>
                                <img class="img-responsive" src="/images/partner/intro/pb_3.png">

                                <h4 class="text-green">Boot nhiều sản phẩm lên facebook</h4>
                                <h5>Chức năng này phù hợp với việc bạn tổng hợp lại các mẫu đã đăng , các sản phẩm giống nhau về thuộc tính như màu, kích thước, quai đeo ..., các mẫu bán chạy nhất </h5>
                                <h5>Bước 1: bấm "Product boot"</h5>
                                <img class="img-responsive" src="/images/partner/intro/pb_1.png">
                                <h5>Bước 2: chọn nhiều sản phẩm và bấm "Supper boot" để mở công cụ </h5>
                                <img class="img-responsive" src="/images/partner/intro/pb_4.png">
                                <h5>Bước 3: Chọn hình ảnh - chỉnh sửa nội dung đăng - chọn tài khoản facebook và bấm "Đăng bài" để đăng bài  </h5>
                                <img class="img-responsive" src="/images/partner/intro/pb_3.png">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12" >
                        <div class="box box-solid collapsed-box">
                            <div class="box-header with-border">
                                <i class="fa fa-globe text-red"></i>
                                <h3 class="box-title text-red">Tài khoản Facebook</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <h4 class="text-green">Thêm tài khoản</h4>
                                <h5>Bước 1: bấm "Tài khoản facebook" để mở page quản lý tài khoản facebook</h5>
                                <img class="img-responsive" src="/images/partner/intro/ac_1.png">
                                <h5>Bước 2: bấm "Thêm tài khoản" để thêm tài khoản facebook vào danh sách <small>bạn được quyền thêm tối đa {{KACANA_USER_BUSINESS_ACCOUNT_LIMIT}} tài khoản</small></h5>
                                <img class="img-responsive" src="/images/partner/intro/ac_2.png">
                                <h4 class="text-green">Đổi tên tài khoản <small>tên tài khoản chỉ thay đổi tại kacana để tiện việc quản lý của bạn</small></h4>
                                <h5>Bước 1: bấm "Tài khoản facebook" để mở page quản lý tài khoản facebook</h5>
                                <img class="img-responsive" src="/images/partner/intro/ac_1.png">
                                <h5>Bước 2: bấm "<i class="fa fa-edit"></i>" của tài khoản bạn muốn đổi </h5>
                                <img class="img-responsive" src="/images/partner/intro/ac_3.png">
                                <h5>Bước 3: nhập tên và bấm "Cập nhật" để thay đổi tên tài khoản </h5>
                                <img class="img-responsive" src="/images/partner/intro/ac_5.png">
                                <h4 class="text-green">Xoá tài khoản <small>bạn hãy chắc chăn khi thực hiện chức năng này</small></h4>
                                <h5>Bước 1: bấm "Tài khoản facebook" để mở page quản lý tài khoản facebook</h5>
                                <img class="img-responsive" src="/images/partner/intro/ac_1.png">
                                <h5>Bước 2: bấm "<i class="fa fa-trash"></i>" của tài khoản bạn muốn xoá </h5>
                                <img class="img-responsive" src="/images/partner/intro/ac_4.png">
                                <h5>Bước 3: bấm "Có" để xoá tài khoản  </h5>
                                <img class="img-responsive" src="/images/partner/intro/ac_6.png">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12" >
                        <div class="box box-solid collapsed-box">
                            <div class="box-header with-border">
                                <i class="fa fa-user text-red"></i>
                                <h3 class="box-title text-red">Khách hàng</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <h4 class="text-green">Danh sách khách hàng</h4>
                                <h5>Bước 1: bấm "Khách hàng" để mở page quản lý danh sách khách hàng</h5>
                                <img class="img-responsive" src="/images/partner/intro/kh_1.png">
                                <h4 class="text-green">Chi tiết khách hàng <small>Cập nhật thông tin khách hàng và kiểm tra đơn hàng của khách hàng</small></h4>
                                <h5>Bước 1: bấm "Tài khoản facebook" để mở page quản lý tài khoản facebook</h5>
                                <img class="img-responsive" src="/images/partner/intro/kh_2.png">
                                <h5>Bước 2: Nhập thông tin khách hàng và kiểm tra đơn hàng của khách hàng</h5>
                                <img class="img-responsive" src="/images/partner/intro/kh_3.png">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12" >
                        <div class="box box-solid collapsed-box">
                            <div class="box-header with-border">
                                <i class="fa fa-plane text-red"></i>
                                <h3 class="box-title text-red">Đơn hàng</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <h4 class="text-green">Danh sách đơn hàng</h4>
                                <h5>Bước 1: bấm "Đơn hàng" để mở page quản lý danh sáchhàng đơn hàng</h5>
                                <img class="img-responsive" src="/images/partner/intro/dh_1.png">
                                <h4 class="text-green">Tạo đơn hàng <small>Khi khách hàng của bạn đặt hàng - sẽ sử dụng chức năng này</small></h4>
                                <h5>Bước 1: bấm "Tạo Đơn hàng" để mở công cụ tạo đơn </h5>
                                <img class="img-responsive" src="/images/partner/intro/dh_2.png">
                                <h5>Bước 2: Nhập thông tin địa nhận hàng của khách hàng </h5>
                                <img class="img-responsive" src="/images/partner/intro/dh_4.png">
                                <h5>Bước 3: Thêm sản phẩm cho đơn hàng </h5>
                                <img class="img-responsive" src="/images/partner/intro/dh_5.png">
                                <img class="img-responsive" src="/images/partner/intro/dh_6.png">
                                <h5>Bước 4: Chỉnh sữa các thuộc tính của sản phẩm : màu sắc và số  lượng</h5>
                                <img class="img-responsive" src="/images/partner/intro/dh_8.png">
                                <h5>Bước 5: Gửi đơn hàng cho KACANA <small>Kacana sẽ xử lý ship hàng và chuyển chiết khấu cho bạn sau khi đơn hàng thành công</small></h5>
                                <img class="img-responsive" src="/images/partner/intro/dh_9.png">
                                <h4 class="text-green">Cập nhật đơn hàng <small>Chức năng này chỉ được thực hiên khi đơn hàng chưa gửi cho </small></h4>KACANA
                                <h5>Bước 1: Chọn đơn hàng cần cập nhật</h5>
                                <img class="img-responsive" src="/images/partner/intro/dh_3.png">
                                <h5>Bước Tiếp: Giống khi tạo đơn hàng </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop