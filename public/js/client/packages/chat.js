var chatPackage = {
    chat:{
        page: false,
        threadId: 0,
        init: function(){
            // Kacana.chat.setUpSocketChat();
            Kacana.chat.page = $('#chat-window-wrap');
            // Kacana.chat.clientChat();
            Kacana.chat.bindEvent();
        },
        bindEvent: function () {
            Kacana.chat.page.on('click', '.top_menu',  Kacana.chat.toggleChatWindow)

            Kacana.chat.page.on('click', '.send_message', function(e) {
                var textMessage = Kacana.chat.getMessageTextClient();
                Kacana.chat.processChat(textMessage);
                return Kacana.chat.sendMessage(textMessage, 'right');
            });

            Kacana.chat.page.on('keyup', '.message_input', function (e) {
                if (e.which === 13) {
                    var textMessage = Kacana.chat.getMessageTextClient();
                    Kacana.chat.processChat(textMessage);
                    return Kacana.chat.sendMessage(textMessage, 'right');
                }
            });
        },
        processChat: function (textMessage) {
            if(!Kacana.chat.threadId)
            {
                Kacana.chat.createNewThread(textMessage);
            }
            else{
                Kacana.chat.createNewMessage(textMessage);
            }
        },
        createNewThread: function (textMessage) {
            var callBack = function(data){
                if(data.ok){
                    Kacana.chat.threadId = data.threadId;
                    Kacana.chat.setUpSocketChat(Kacana.chat.threadId);
                }
                else
                    Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
            };

            var errorCallBack = function(data){
                Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                Kacana.utils.loading.closeLoading();
            };

            var data = {
                message: textMessage
            };

            Kacana.ajax.chat.createNewThread(data, callBack, errorCallBack);
        },
        createNewMessage: function (textMessage) {
            var callBack = function(data){
                if(data.ok){
                    console.log('pushed message');
                }
                else
                    Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
            };

            var errorCallBack = function(data){
                Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                Kacana.utils.loading.closeLoading();
            };

            var data = {
                message: textMessage,
                threadId: Kacana.chat.threadId
            };

            Kacana.ajax.chat.createNewMessage(data, callBack, errorCallBack);
        },
        toggleChatWindow: function () {
            if(Kacana.chat.page.hasClass('active'))
            {
                Kacana.chat.page.css('height', '37px');
                Kacana.chat.page.removeClass('active');
            }
            else
            {
                Kacana.chat.page.css('height', '386px');
                Kacana.chat.page.addClass('active');
                if(!Kacana.chat.page.find('.messages').html())
                {
                    Kacana.chat.sendMessage('Xin chào - Muốn hỗ trợ gì nè! :)', 'left');
                }
            }
        },
        setUpSocketChat: function (threadId) {
            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('65bb7e6aa3cfdd3b4b63', {
                cluster: 'ap1',
                encrypted: true
            });

            var channel = pusher.subscribe('Kacana_Client');
            channel.bind('Kacana-Client-Thread-'+threadId, function(data) {
                if(data.type == 'reply')
                {
                    Kacana.chat.sendMessage(data.message, 'left');
                }
            });
        },
        messageObject: function(arg){
            this.text = arg.text, this.message_side = arg.message_side;
            this.draw = function (_this) {
                return function () {
                    var $message;
                    $message = $($('.message_template').clone().html());
                    $message.addClass(_this.message_side).find('.text').html(_this.text);
                    $('.messages').append($message);
                    return setTimeout(function () {
                        return $message.addClass('appeared');
                    }, 0);
                };
            }(this);
            return this;
        },
        sendMessage: function (text, message_side) {
            var $messages, message;
            if (text.trim() === '') {
                return;
            }
            Kacana.chat.page.find('.message_input').val('');
            $messages =  Kacana.chat.page.find('.messages');

            message = new Kacana.chat.messageObject({
                text: text,
                message_side: message_side
            });

            message.draw();
            return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
        },
        getMessageTextClient: function () {
            var $message_input;
            $message_input = Kacana.chat.page.find('.message_input');
            return $message_input.val();
        }
    }
};

$.extend(true, Kacana, chatPackage);