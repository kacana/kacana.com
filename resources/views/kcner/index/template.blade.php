<div id="modal-tracking-info-client-message" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Thông tin người dùng</h4>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<script id="template-tracking-info-user" type="template">
    <label class="text-aqua">Thông tin chung</label>
    <p><b>Địa chỉ URL:</b> <a target="_blank" href="${data.url}">${data.url}</a></p>
    <p><b>Đến từ:</b> <a target="_blank" href="${data.referer}">${data.referer}</a></p>
    <p><b>Session ID:</b> ${data.session_id} - <a target="_blank" href="/user/detailUserTracking?idTracking=${data.session_id}">Chi tiết</a> </p>
    <p><b>Loại Kết Nối:</b> ${data.type_call}</p>
    <p><b>Ngày:</b> ${data.created_at}</p>

    <label class="text-aqua">Thông tin địa điểm: <a target="_blank" href="https://freegeoip.net/?q=${data.ip.ip}">${data.ip.ip}</a></label>
    <p>Quốc Gia: ${data.ip.country_name}</p>
    <p>Thành phố: ${data.ip.region_name}</p>
    <p>Bản đồ:
        <a href="https://www.google.com.vn/maps/preview/@${data.ip.latitude},${data.ip.longitude}z" ng-show="record.latitude &amp;&amp; record.longitude" target="_blank" class="ng-binding">
            ${data.ip.latitude}, ${data.ip.longitude}
        </a>
    </p>
    <label class="text-aqua">Thông tin thiết bị người dùng:</label>
    <p>Trình Duyệt: ${data.user_agent.ua.family} - version : ${data.user_agent.ua.major}.${data.user_agent.ua.minor}</p>
    <p>Hệ điều hành: ${data.user_agent.os.family} - version : ${data.user_agent.os.major}.${data.user_agent.os.minor}</p>
    <p>Thiết Bị: ${data.user_agent.device.family} - hãng : ${data.user_agent.device.brand} - model: ${data.user_agent.device.model}</p>
</script>