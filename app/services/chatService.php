<?php namespace App\services;

use App\models\chatMessageModel;
use App\models\chatParticipantModel;
use App\models\chatThreadModel;
use Kacana\Client\KPusher;
use Kacana\Client\Slack;

class chatService extends baseService {

    private $_chatThreadModel;

    private $_chatParticipantModel;

    private $_chatMessageModel;

    public function __construct()
    {
        $this->_chatMessageModel = new chatMessageModel();
        $this->_chatThreadModel = new chatThreadModel();
        $this->_chatParticipantModel = new chatParticipantModel();
    }

    public function createNewThread($subject , $ref)
    {
        $mailService = new mailService();
        return $this->_chatThreadModel->createNewThread($subject, $ref);
    }

    public function createNewMessage($userTrackingHistoryId, $threadId, $userId, $type, $body){
        if($type == KACANA_CHAT_TYPE_ASK){
            $userTrackingService = new userTrackingService();
            $tracking = $userTrackingService->getUserTrackingHistory($userTrackingHistoryId);

            $slack = new Slack('#messages_tool');
            $slack->notificationNewMessage($threadId, $body, $tracking);
        }

        return $this->_chatMessageModel->createNewMessage($userTrackingHistoryId, $threadId, $userId, $type, $body);
    }

    public function getNewMesaage(){
        return $this->_chatThreadModel->getNewThreadMesaage();
    }

    public function getOldThread()
    {
        $newThreads = self::getNewMesaage();
        $newThreadIds = [];
        foreach ($newThreads as $thread)
        {
            array_push($newThreadIds, $thread->id);
        }
        return $this->_chatThreadModel->getOldThread($newThreadIds);
    }

    public function updateLastRead($threadId, $userId, $isRead = 1){
        return $this->_chatParticipantModel->updateLastRead($threadId, $userId, $isRead);
    }

    public function getUserMessage($threadId, $keyRead){
        return $this->_chatMessageModel->getUserMessage($threadId, $keyRead);
    }

    public function getUserMessageByThreadId($threadId){
        return $this->_chatMessageModel->getUserMessageByThreadId($threadId);
    }

    public function checkTimeAutoReply($id){
        $pusher = new KPusher();

        if(date('H') < 7 || date('H') > 22)
        {
            if(date('H') > 3 && date('H') < 7)
                $message = 'Hiện tại Kacana không online. Bạn vui lòng để lại <b class="color-red">Số điện thoại</b> hay <b class="color-red">Email</b>. Kacana sẽ liên lạc với Bạn trong thời gian sớm nhất!<br> Cảm ơn và chúc bạn ngày mới nhiều niềm vui';
            else
                $message = 'Hiện tại Kacana không online. Bạn vui lòng để lại <b class="color-red">Số điện thoại</b> hay <b class="color-red">Email</b>. Kacana sẽ liên lạc với Bạn trong thời gian sớm nhất!<br> Cảm ơn và chúc bạn ngủ ngon';

            $chatType = KACANA_CHAT_TYPE_REPLY;
            $threadId = KACANA_CHAT_THREAD_PREFIX.$id;

            $pusher->createNewPush($message, $threadId, $chatType);

            $this->createNewMessage(0, $id, '0', $chatType, $message);

            return true;
        }

        return false;
    }

    public function createMessagesResponseFromSlack($params){

        if($params['token'] == KACANA_SLACK_TOKEN_MESSAGE)
        {
            $message = $params['text'];
            $messageDecode = explode(' ', $message);
            $threadId = str_replace('#', '', $messageDecode[0]);

            $message = str_replace($messageDecode[0].' ', '', $message);
            $pusher = new KPusher();

            $userId = 0;

            $chatType = KACANA_CHAT_TYPE_REPLY;

            $pusher->createNewPush($message, KACANA_CHAT_THREAD_PREFIX.$threadId, $chatType);
            $this->createNewMessage(0, $threadId, $userId, $chatType, $message);
        }

    }
}



?>