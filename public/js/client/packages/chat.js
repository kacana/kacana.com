var chatPackage = {
    chat:{
        page: false,
        threadId: 0,
        keyStorge: '__chat_session_user__',
        soundMessage: false,
        iconMessage: false,
        init: function(){
            // Kacana.chat.setUpSocketChat();
            Kacana.chat.page = $('#chat-window-wrap');
            Kacana.chat.soundMessage = $('#chat-sound-new-message')[0];
            Kacana.chat.iconMessage = Kacana.chat.page.find('.top_menu .fa');
            // Kacana.chat.clientChat();
            Kacana.chat.bindEvent();
            Kacana.chat.checkHistoryMessage();
        },
        checkHistoryMessage: function () {
            var dataStorage = Lockr.get(Kacana.chat.keyStorge);

            if(dataStorage !== undefined)
            {
                var callBack = function(data){
                    if(data.ok){
                       var messages = data.messages;
                        var lastMessageReply = false;

                        for (var i = 0; i < messages.length; i++){
                            var message = messages[i];
                            if(message.type == 'ask')
                                Kacana.chat.sendMessage(message.body, 'right');
                            else
                            {
                                lastMessageReply = message.body;
                                Kacana.chat.sendMessage(message.body, 'left');
                            }

                        }

                        if(lastMessageReply && lastMessageReply !=  dataStorage.lastReply )
                        {
                            Kacana.chat.iconMessage.addClass('have-new-message');
                            Kacana.chat.iconMessage.data('last-reply', lastMessageReply);
                        }

                        var durationSession = ($.now() - dataStorage.time)/1000/60;
                        if(durationSession < 30 && dataStorage.is_close == 0 && !$('#chat-window-wrap').hasClass('active'))
                        {
                            Kacana.chat.page.find('.top_menu').click();
                        }
                    }
                    else
                        Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                };

                var errorCallBack = function(data){
                    Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                    Kacana.utils.loading.closeLoading();
                };

                var data = {
                    threadId: dataStorage.threadId,
                    keyRead: dataStorage.keyRead
                };

                Kacana.chat.threadId = dataStorage.threadId;
                Kacana.chat.setUpSocketChat(Kacana.chat.threadId);
                Kacana.ajax.chat.getUserMessage(data, callBack, errorCallBack);
            }
        },
        bindEvent: function () {
            Kacana.chat.page.on('click', '.top_menu',  Kacana.chat.toggleChatWindow)

            Kacana.chat.page.on('click', '.send_message', function(e) {
                var textMessage = Kacana.chat.getMessageTextClient();

                if(Kacana.chat.isURL(textMessage))
                    textMessage = '<a class="color-white" target="_blank" href="'+textMessage+'">'+textMessage+'</a>';

                Kacana.chat.processChat(textMessage);
                return Kacana.chat.sendMessage(textMessage, 'right');
            });

            Kacana.chat.page.on('keyup', '.message_input', function (e) {
                if (e.which === 13 && $.trim($(this).val())) {
                    var textMessage = Kacana.chat.getMessageTextClient();

                    if(Kacana.chat.isURL(textMessage))
                        textMessage = '<a class="color-white" target="_blank" href="'+textMessage+'">'+textMessage+'</a>';

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
                    data.time = $.now();
                    data.is_close = 0;
                    Lockr.set(Kacana.chat.keyStorge, data);

                    if(data.reload)
                    {
                        Kacana.chat.page.find('.messages').html('');
                        Kacana.chat.sendMessage('Xin chào - Muốn hỗ trợ gì nè! :)', 'left');
                        Kacana.chat.checkHistoryMessage();
                    }

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
                userTrackingHistoryId: $('#__kacana_user_tracking_history_id__').data('id')
            };

            Kacana.ajax.chat.createNewThread(data, callBack, errorCallBack);
        },
        createNewMessage: function (textMessage) {
            var callBack = function(data){
                if(data.ok){
                    console.log('pushed message');
                    Kacana.chat.updateStorageTime();
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
                threadId: Kacana.chat.threadId,
                userTrackingHistoryId: $('#__kacana_user_tracking_history_id__').data('id')
            };

            Kacana.ajax.chat.createNewMessage(data, callBack, errorCallBack);
        },
        toggleChatWindow: function () {
            if(Kacana.chat.page.hasClass('active'))
            {
                Kacana.chat.page.css('height', '34px');
                Kacana.chat.page.removeClass('active');
                Kacana.chat.updateStorageClosePopup(1);
            }
            else
            {
                Kacana.chat.updateStorageClosePopup(0);

                Kacana.chat.page.css('height', '386px');
                Kacana.chat.page.addClass('active');

                if(Kacana.chat.iconMessage.hasClass('have-new-message'))
                {
                    Kacana.chat.iconMessage.removeClass('have-new-message');
                    Kacana.chat.updateLastMessageReply(Kacana.chat.iconMessage.data('last-reply'));

                }

                Kacana.chat.page.find('.message_input').focus();

                if(!Kacana.chat.page.find('.messages').html())
                {
                    Kacana.chat.sendMessage('Xin chào - Muốn hỗ trợ gì nè! :)', 'left');
                }
            }
        },
        setUpSocketChat: function (threadId) {
            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            // var pusherKey = '21054d1ab37cab6eb74f'; // development key
            var pusherKey = '65bb7e6aa3cfdd3b4b63'; // production key


            var pusher = new Pusher(pusherKey, {
                cluster: 'ap1',
                encrypted: true
            });

            var channel = pusher.subscribe('Kacana_Client');
            channel.bind('Kacana-Client-Thread-'+threadId, function(data) {
                if(data.type == 'reply')
                {
                    if($('#chat-window-wrap').hasClass('active'))
                    {
                        Kacana.chat.updateLastMessageReply(data.message);
                    }
                    else{
                        Kacana.chat.iconMessage.addClass('have-new-message');
                        Kacana.chat.iconMessage.data('last-reply', data.message);
                    }

                    Kacana.chat.updateStorageTime();
                    Kacana.chat.soundMessage.play();
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
            return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 0);
        },
        getMessageTextClient: function () {
            var $message_input;
            $message_input = Kacana.chat.page.find('.message_input');
            return $message_input.val();
        },
        updateLastMessageReply: function (lastMessage) {
            var dataStorage = Lockr.get(Kacana.chat.keyStorge);
            dataStorage.lastReply = lastMessage;
            dataStorage.time = $.now();
            Lockr.set(Kacana.chat.keyStorge, dataStorage);
        },
        updateStorageTime: function () {
            var dataStorage = Lockr.get(Kacana.chat.keyStorge);
            dataStorage.time = $.now();
            Lockr.set(Kacana.chat.keyStorge, dataStorage);
        },
        updateStorageClosePopup: function (val) {
            var dataStorage = Lockr.get(Kacana.chat.keyStorge);
            if(dataStorage !== undefined)
            {
                dataStorage.is_close = val;
                Lockr.set(Kacana.chat.keyStorge, dataStorage);
            }
        },
        isURL: function (testString) {

            var regex = new RegExp("^((https{0,1}|ftp|rtsp|mms){0,1}://){0,1}(([0-9a-z_!~\\*'\\(\\)\\.&=\\+\\$%\\-]{1,}:\\ ){0,1}[0-9a-z_!~\\*'\\(\\)\\.&=\\+\\$%\\-]{1,}@){0,1}(([0-9]{1,3}\\.){3,3}[0-9]{1,3}|([0-9a-z_!~\\*'\\(\\)\\-]{1,}\\.){0,}([0-9a-z][0-9a-z\\-]{0,61}){0,1}[0-9a-z]\\.[a-z]{2,6}|localhost)(:[0-9]{1,4}){0,1}((/{0,1})|(/[0-9a-z_!~\\*'\\(\\)\\.;\\?:@&=\\+\\$,%#\\-]{1,}){1,}/{0,1})$", "gi");

            if(regex.exec(testString) !=  null)
                return true;
            else return false;
        }
    }
};

$.extend(true, Kacana, chatPackage);