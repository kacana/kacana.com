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

            channel.bind('__new_thread_message_listener__', function(data) {
                Kacana.chat.getNewMessage();
                if(data.type == 'message')
                    $('#chat-sound-new-message')[0].play();
                if(data.type == 'thread')
                    $('#chat-sound-new-thread')[0].play();
            });
        },
        createRowNewMessageZone: function (id, day, time) {
            var itemMessageTemplate = $('#template-chat-list-thread').html();

            var listNewMessage = $('#list-chat-right-side-new');
            var itemMessageTemplateGenerate = $.tmpl(itemMessageTemplate, {'id': id, 'day': day, 'time': time});
            listNewMessage.prepend(itemMessageTemplateGenerate);
        },
        createRowOldMessageZone: function (id, day, time) {
            var itemMessageTemplate = $('#template-chat-list-old-thread').html();

            var listNewMessage = $('#list-chat-right-side-old');
            var itemMessageTemplateGenerate = $.tmpl(itemMessageTemplate, {'id': id, 'day': day, 'time': time});
            listNewMessage.prepend(itemMessageTemplateGenerate);
        },
        bindEvent: function () {
            Kacana.chat.page.on('click', '.Kacana-Client-Thread .send_message', function(e) {
                var textMessage = $(this).val();
                var thread = $(this).parents('.Kacana-Client-Thread');

                return Kacana.chat.sendMessage(textMessage, 'right', thread);
            });

            Kacana.chat.page.on('keyup', '.Kacana-Client-Thread .message_input', function (e) {
                if (e.which === 13) {
                    var textMessage = $(this).val();
                    var thread = $(this).parents('.Kacana-Client-Thread');

                    return Kacana.chat.sendMessage(textMessage, 'right', thread);
                }
            });

            Kacana.chat.page.on('focus', '.message_input', function (e) {
                var thread = $(this).parents('.Kacana-Client-Thread');
                Kacana.chat.updateLastRead(thread.data('id'));
            });

            Kacana.chat.sideChatList.on('click', '.create-thread-message', function () {
                var threadTemplate = $('#template-chat-thread').html();
                var id = $(this).data('thread-id');
                var threadId = 'Kacana-Client-Thread-'+id;

                if($('#'+threadId).length)
                {
                    $('#'+threadId).find('.message_input').focus();
                    // $('#'+threadId).find('.message_input').val('focus');
                    return false;
                }



                Kacana.chat.updateLastRead(id);
                var threadTemplateGenerate = $.tmpl(threadTemplate, {'id': id});

                Kacana.chat.page.find('#chat-thread-list').append(threadTemplateGenerate);

                var channel = Kacana.chat.KPusher.subscribe('Kacana_Client');
                var thread = $('#'+threadId);

                var $messages =  thread.find('.direct-chat-messages');
                var btnShowMessage = $('#btn-show-list-chat-right-side');

                if($(this).hasClass('new-thread'))
                {
                    var numberNewMessage = parseInt(btnShowMessage.find('span').html());
                    btnShowMessage.find('span').html(numberNewMessage - 1);
                }

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
            Kacana.chat.updateLastRead(threadId);
            Kacana.ajax.chat.createNewThread(data, callBack, errorCallBack);
        },
        sendMessage: function (text, message_side, $thread) {
            var threadId = $thread.data('id');
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
            var btnShowMessage = $('#btn-show-list-chat-right-side');

            var callBack = function(data){
                if(data.ok){
                    var items = data.data;
                    btnShowMessage.find('span').html(items.length);
                    $('#list-chat-right-side-new').html('');
                    for(var i = 0; i< items.length; i++){
                        var item = items[i];
                        console.log(item.id);
                        var date = item.updated_at;
                        date = date.split(' ');
                        Kacana.chat.createRowNewMessageZone(item.id, date[0], date[1]);
                    }
                }
                else
                    Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');

                Kacana.chat.getOldMessage();
            };

            var errorCallBack = function(data){
                Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                Kacana.utils.loading.closeLoading();
            };

            var data = {};

            Kacana.ajax.chat.getNewMessage(data, callBack, errorCallBack);
        },
        getOldMessage: function () {
            var callBack = function(data){
                if(data.ok){
                    var items = data.data;
                    $('#list-chat-right-side-old').html('');
                    for(var i = 0; i< items.length; i++){
                        var item = items[i];
                        var date = item.updated_at;
                        date = date.split(' ');
                        Kacana.chat.createRowOldMessageZone(item.id, date[0], date[1]);
                    }
                }
                else
                    Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
            };

            var errorCallBack = function(data){
                Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                Kacana.utils.loading.closeLoading();
            };

            var data = {};

            Kacana.ajax.chat.getOldThread(data, callBack, errorCallBack);
        },
        updateLastRead: function (threadId) {
            var callBack = function(data){
                if(data.ok){
                   console.log('update Last read')
                }
                else
                    Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
            };

            var errorCallBack = function(data){
                Kacana.utils.showError('có cái gì sai sai ở đây! vui lòng gọi: 0906.054.206');
                Kacana.utils.loading.closeLoading();
            };

            var data = {
                'threadId': threadId
            };

            Kacana.ajax.chat.updateLastRead(data, callBack, errorCallBack);
        }
    }
};

$.extend(true, Kacana, chatPackage);