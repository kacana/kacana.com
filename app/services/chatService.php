<?php namespace App\services;

use App\Http\Requests\Request;
use App\models\chatMessageModel;
use App\models\chatParticipantModel;
use App\models\chatThreadModel;
use App\models\productModel;
use App\models\productPropertiesModel;
use App\models\productTagModel;
use App\models\productViewModel;
use App\models\tagModel;
use App\models\User;
use App\models\userProductLikeModel;
use App\models\userSocialModel;
use Kacana\Client\KPusher;
use Kacana\DataTables;
use Kacana\Util;
use Kacana\ViewGenerateHelper;
use Kacana\HtmlFixer;
use Cache;
use App\models\productGalleryModel;
use \Storage;
use Carbon\Carbon;
use Shorten;

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


}



?>