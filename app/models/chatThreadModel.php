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

        $thread->save();

        return $thread;
    }


    /**
     * @return mixed
     */
    public function getNewThreadMesaage(){
        $threads = $this->leftJoin('chat_messages', 'chat_messages.id', '=', 'chat_threads.id')
            ->leftJoin('chat_participants', 'chat_participants.thread_id', '=', 'chat_threads.id')
            ->where('chat_messages.created_at', '>', 'chat_participants.last_read')
            ->orWhereNull('chat_participants.id')
            ->groupBy('chat_threads.id');

        return $threads->get();
    }

    /**
     * @return mixed
     */
    public function getOldThread($newThreadIds){
        $threads = $this->leftJoin('chat_messages', 'chat_messages.id', '=', 'chat_threads.id')
            ->leftJoin('chat_participants', 'chat_participants.thread_id', '=', 'chat_threads.id')
            ->whereNotIn('chat_threads.id', $newThreadIds)
            ->groupBy('chat_threads.id');

        return $threads->get();
    }


}
