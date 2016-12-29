<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class chatThreadModel
 * @package App\models
 */
class chatThreadModel extends Model {


    /**
     * @var string
     */
    protected $table = 'chat_threads';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @param $subject
     * @param $ref
     * @return chatThreadModel
     */
    public function createNewThread($subject, $ref){

        $thread = new chatThreadModel();

        $thread->subject = $subject;
        $thread->ref = $ref;
        $thread->key_read = md5('chat-'.time());

        $thread->save();

        return $thread;
    }


    /**
     * @return mixed
     */
    public function getNewThreadMesaage(){
        $threads = $this->leftJoin('chat_messages', 'chat_messages.id', '=', 'chat_threads.id')
            ->leftJoin('chat_participants', 'chat_participants.thread_id', '=', 'chat_threads.id')
            ->where('chat_participants.is_read' ,'=', 0)
            ->orWhereNull('chat_participants.id')
            ->orderBy('chat_participants.updated_at', 'asc')
            ->groupBy('chat_threads.id')
            ->select(['chat_threads.*', 'last_message_time'=>'chat_participants.updated_at']);

        return $threads->get();
    }

    /**
     * @return mixed
     */
    public function getOldThread($newThreadIds){
        $threads = $this->leftJoin('chat_messages', 'chat_messages.id', '=', 'chat_threads.id')
            ->leftJoin('chat_participants', 'chat_participants.thread_id', '=', 'chat_threads.id')
            ->whereNotIn('chat_threads.id', $newThreadIds)
            ->orderBy('chat_participants.updated_at', 'asc')
            ->groupBy('chat_threads.id')
            ->select(['chat_threads.*', 'last_message_time'=>'chat_participants.updated_at']);

        return $threads->get();
    }


}
