<?php namespace App\models;

use App\services\chatService;
use Illuminate\Database\Eloquent\Model;

/**
 * Class chatMessageModel
 * @package App\models
 */
class chatMessageModel extends Model {


    /**
     * @var string
     */
    protected $table = 'chat_messages';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @param $threadId
     * @param $userId
     * @param $type
     * @param $body
     * @return chatMessageModel
     */
    public function createNewMessage($threadId, $userId, $type, $body){
        $message = new chatMessageModel();

        $message->thread_id = $threadId;
        $message->user_id = $userId;
        $message->type = $type;
        $message->body = $body;

        $message->save();
        return $message;
    }

}
