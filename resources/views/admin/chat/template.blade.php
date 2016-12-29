<script id="template-direct-chat-msg-left" type="template">
    <div class="direct-chat-msg">
        <div class="direct-chat-info clearfix">
            <span class="direct-chat-timestamp pull-right">${message_date}</span>
        </div>
        <div class="direct-chat-text">
            ${text}
        </div>
    </div>
</script>

<script id="template-direct-chat-msg-right" type="template">
    <div class="direct-chat-msg right">
        <div class="direct-chat-info clearfix">
            <span class="direct-chat-timestamp pull-left">${message_date}</span>
        </div>
        <div class="direct-chat-text">
            ${text}
        </div>
    </div>
</script>

<script id="template-chat-thread" type="template">
    <div id="{{KACANA_CHAT_THREAD_PREFIX}}${id}" data-id="${id}" class="col-md-3 Kacana-Client-Thread">
        <div class="box box-primary direct-chat direct-chat-primary">
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
