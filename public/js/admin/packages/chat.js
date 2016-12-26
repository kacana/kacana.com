var chatPackage = {
    chat:{
        page: false,
        sideChatList: false,
        threadId: 0,
        Kpusher: false,
        init: function(){
            // Kacana.chat.setUpSocketChat();
            Kacana.chat.KPusher = Kacana.utils.KPusher();
            Kacana.chat.page = $('#content-chat-page');
            Kacana.chat.sideChatList = $('#control-sidebar-chat-tab');
            Kacana.chat.listenNewMessage();
            Kacana.chat.bindEvent();
            Kacana.chat.getNewMessage();
        },
        listenNewMessage: function () {
            var channel = Kacana.chat.KPusher.subscribe('Kacana_Client');

            channel.bind('Kacana_Client_New_Message', function(data) {
                Kacana.chat.createNewRowMessageZone(data);
            });
        },
        createNewRowMessageZone: function () {

        },
        bindEvent: function () {
            Kacana.chat.page.on('click', '.send_message', function(e) {
                var textMessage = Kacana.chat.getMessageTextClient();
                var thread = $(this).parents('.Kacana-Client-Thread');

                return Kacana.chat.sendMessage(textMessage, 'right', thread);
            });

            Kacana.chat.page.on('keyup', '.message_input', function (e) {
                if (e.which === 13) {
                    var textMessage = Kacana.chat.getMessageTextClient();
                    var thread = $(this).parents('.Kacana-Client-Thread');

                    return Kacana.chat.sendMessage(textMessage, 'right', thread);
                }
            });

            Kacana.chat.sideChatList.on('click', '.create-thread-message', function () {
                var threadTemplate = $('#template-chat-thread').html();
                var id = $(this).data('thread-id');

                var threadTemplateGenerate = $.tmpl(threadTemplate, {'id': id});

                Kacana.chat.page.find('#chat-thread-list').append(threadTemplateGenerate);

                var channel = Kacana.chat.KPusher.subscribe('Kacana_Client');
                var threadId = 'Kacana-Client-Thread-'+id;
                var thread = $('#'+threadId);
                var $messages =  thread.find('.direct-chat-messages');
                channel.bind(threadId, function(data) {
                    if(data.type == 'ask')
                    {
                        var messageText = Kacana.chat.generateMessage(data.message, 'left', '23 Jan 5:37 pm');

                        thread.find('.direct-chat-messages').append(messageText);

                        return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
                    }
                });
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
        createNewMessage: function (textMessage, threadId) {
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
                threadId: threadId,
                type: 'reply'
            };

            Kacana.ajax.chat.createNewThread(data, callBack, errorCallBack);
        },
        sendMessage: function (text, message_side, $thread) {
            var threadId = $thread.attr('id');
            var $messages, message;
            if (text.trim() === '') {
                return;
            }
            Kacana.chat.createNewMessage(text, threadId);
            $thread.find('.message_input').val('');

            $messages =  $thread.find('.direct-chat-messages');
            message = Kacana.chat.generateMessage(text, message_side, '23 Jan 5:37 pm');
            $thread.find('.direct-chat-messages').append(message);

            return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
        },
        generateMessage: function (text, message_side, message_date) {

            var messageTemplate = $('#template-direct-chat-msg-left').html();

            if(message_side == 'right')
            {
                messageTemplate = $('#template-direct-chat-msg-right').html();
            }

            return $.tmpl(messageTemplate, {'text': text, 'message_date': message_date});
        },
        getMessageTextClient: function () {
            var $message_input;
            $message_input = Kacana.chat.page.find('.message_input');
            return $message_input.val();
        },
        getNewMessage: function () {
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

            var data = {};

            Kacana.ajax.chat.getNewMessage(data, callBack, errorCallBack);
        }
    }
};

$.extend(true, Kacana, chatPackage);