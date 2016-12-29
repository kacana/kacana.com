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
use Kacana\DataTables;
use Kacana\Util;
use Kacana\ViewGenerateHelper;
use Kacana\HtmlFixer;
use Cache;
use App\models\productGalleryModel;
use \Storage;
use Carbon\Carbon;
use Shorten;

class chatService {

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
        return $this->_chatThreadModel->createNewThread($subject, $ref);
    }

    public function createNewMessage($threadId, $userId, $type, $body){
        return $this->_chatMessageModel->createNewMessage($threadId, $userId, $type, $body);
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


}



?>