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

    /**
     * @param $threadId
     * @param $keyRead
     * @return mixed
     */
    public function getUserMessage($threadId, $keyRead){
        $messages = $this->join('chat_threads', 'chat_messages.thread_id', '=', 'chat_threads.id')
            ->leftJoin('chat_participants', 'chat_participants.thread_id', '=', 'chat_threads.id')
            ->where('chat_threads.id', $threadId)
            ->where('chat_threads.key_read', $keyRead)
            ->orderBy('chat_threads.created_at', 'asc')
            ->select(['chat_messages.*', 'isRead' => 'chat_participants.is_read']);

        return $messages->get();
    }

    public function getUserMessageByThreadId($threadId){
        $messages = $this->join('chat_threads', 'chat_messages.thread_id', '=', 'chat_threads.id')
            ->leftJoin('chat_participants', 'chat_participants.thread_id', '=', 'chat_threads.id')
            ->where('chat_threads.id', $threadId)
            ->orderBy('chat_threads.created_at', 'asc')
            ->select(['chat_messages.*', 'isRead' => 'chat_participants.is_read']);

        return $messages->get();
    }

}
