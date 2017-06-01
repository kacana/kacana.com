<script id="template-direct-chat-msg-left" type="template">
    <div class="direct-chat-msg">
        <div class="direct-chat-info clearfix">
            <span class="direct-chat-timestamp pull-right">${message_date} - <a data-id="${user_tracking_history_id}" href="#show-information-client-message" ><i class="fa fa-info-circle" ></i></a></span>
        </div>
        <div class="direct-chat-text client-message">
            @{{html text}}
        </div>
    </div>
</script>

<script id="template-direct-chat-msg-right" type="template">
    <div class="direct-chat-msg right">
        <div class="direct-chat-info clearfix">
            <span class="direct-chat-timestamp pull-left">${message_date}</span>
        </div>
        <div class="direct-chat-text">
            @{{html text}}
        </div>
    </div>
</script>

<script id="template-chat-thread" type="template">
    <div id="{{KACANA_CHAT_THREAD_PREFIX}}${id}" data-id="${id}" class="col-md-3 Kacana-Client-Thread">
        <div class="box box-success direct-chat direct-chat-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Chat ${id}</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <div class="direct-chat-messages">

                </div>
            </div>

            <div class="box-footer">
                <div class="input-group">
                    <input name="message" placeholder="Type Message ..." class="message_input form-control" type="text">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat send_message">Send</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</script>

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
    <p><b>Session ID:</b> ${data.session_id}</p>
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
