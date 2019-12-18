<?php namespace App\services;

use App\models\chatMessageModel;
use App\models\chatParticipantModel;
use App\models\chatThreadModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
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

    public function createNewMessage($userTrackingHistoryId, $threadId, $userId, $type, $body, $autoReply = false){
        if($type == KACANA_CHAT_TYPE_ASK){
            $userTrackingService = new userTrackingService();
            $tracking = $userTrackingService->getUserTrackingHistory($userTrackingHistoryId);

            $slack = new Slack('#messages_tool');
            $slack->notificationNewMessage($threadId, $body, $tracking);
        }
        if($autoReply) {
            $this->_chatParticipantModel->updateAutoReplyAt($threadId);
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

    public function autoReply($id){
        $pusher = new KPusher();
        $participant = $this->_chatParticipantModel->getParticipantByThreadId($id);
        $autoReplyAt = Carbon::parse($participant->auto_reply_at);
        $diffSeconds = $autoReplyAt->diffInSeconds(Carbon::now());

        $lastReadAt = Carbon::parse($participant->last_read);
        $lastReadSeconds = $lastReadAt->diffInSeconds(Carbon::now());

        $chatType = KACANA_CHAT_TYPE_REPLY;
        $threadId = KACANA_CHAT_THREAD_PREFIX . $id;
        $message = false;
        $autoReply = false;
        if ($diffSeconds == 0 || $diffSeconds > 86400) {
            if (date('H') < 7 || date('H') > 22) {
                if (date('H') > 22 && date('H') < 7)
                    $message = 'Hiện tại Kacana không online. Bạn vui lòng để lại <b class="color-red">Số điện thoại</b> hay <b class="color-red">Email</b>. Kacana sẽ liên lạc với Bạn trong thời gian sớm nhất!<br> Cảm ơn và chúc bạn ngày mới nhiều niềm vui';
                else
                    $message = 'Hiện tại Kacana không online. Bạn vui lòng để lại <b class="color-red">Số điện thoại</b> hay <b class="color-red">Email</b>. Kacana sẽ liên lạc với Bạn trong thời gian sớm nhất!<br> Cảm ơn và chúc bạn ngủ ngon';

            } else {
                $message = 'Chào bạn</br>Bạn có thể cho bên mình <b class="color-red">số điện thoại</b> để tư vấn được nhanh và chi tiết hơn </br> Cảm ơn bạn! ';
            }
            $autoReply = true;
        } elseif ($lastReadSeconds == 0 && $diffSeconds > 0 && $diffSeconds < 20) {
            $message = 'Cảm ơn bạn đã chat với KACANA!</br>Bọn mình sẽ liên hệ với bạn sớm nhất nhé!';
        }

        if ($message) {
            $pusher->createNewPush($message, $threadId, $chatType);
            $this->createNewMessage(0, $id, '0', $chatType, $message, $autoReply);
            return true;
        }

        return false;
    }

    public function createMessagesResponseFromSlack($params){
        if($params['token'] == KACANA_SLACK_TOKEN_MESSAGE && $params['user_name'] != 'slackbot')
        {
            $lastMessage = $this->_chatMessageModel->getLastMessage();
            $message = $params['text'];
            $messageDecode = explode(' ', $message);
            $threadId = str_replace('#', '', $messageDecode[0]);

            if($this->_chatThreadModel->getThreadById($threadId)) {
                $message = str_replace($messageDecode[0].' ', '', $message);
            } else {
                $threadId = $lastMessage->thread_id;
            }

            $message = $this->getDescDetect($message);

            $pusher = new KPusher();

            $userId = 0;

            $chatType = KACANA_CHAT_TYPE_REPLY;

            $pusher->createNewPush($message, KACANA_CHAT_THREAD_PREFIX.$threadId, $chatType);
            $this->createNewMessage(0, $threadId, $userId, $chatType, $message);
            $this->_chatParticipantModel->updateLastRead($threadId, 3, 1);
        }
    }

    private function getDescDetect($short) {
        switch ($short){
            case 'csbh':
                $desc = "chính sách bán hàng của bên mình nè bạn:<br>
1. Miễn phí ship cho tất cả đơn hàng  và mọi ngóc ngách ở Việt Nam<br>
2. Được kiểm tra hàng trước khi nhận sản phẩm<br>
3. Nhận sản phẩm và trả tiền tại nhà của bạn <br>
";
            break;
            case 'ship':
                $desc = 'Miễn phí ship cho tất cả đơn hàng  và mọi ngóc ngách ở Việt Nam';
                break;
            case 'dc':
                $desc = 'Shop mình ở Bình Tân, HCM <br> bên mình chỉ hoạt động theo kho và ship online bạn nha!';
                break;
            case 'tg':
                $desc = 'Bạn ở HCM thì ship trong ngày 2 - 3 tiếng là nhận được hàng <br> Ship ngoài HCM thì 1 - 3 ngày bạn nha!';
                break;
            case 'bh':
                $desc = 'sản phẩm được bảo hành 6 tháng. bên mình bảo hành bằng số điện thoại mua hàng!';
                break;
            case 'tv':
                $desc = 'Bạn có thể cho bên mình <b class="color-red">số điện thoại</b> để tư vấn được nhanh và chi tiết hơn </br> Cảm ơn bạn! ';
                break;
            default:
                $desc = false;
        }
        return ($desc)?$desc:$short;
    }
}



?>