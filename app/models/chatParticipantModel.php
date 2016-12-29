<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class chatParticipantModel
 * @package App\models
 */
class chatParticipantModel extends Model {


    /**
     * @var string
     */
    protected $table = 'chat_participants';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @param $threadId
     * @param $userId
     * @return chatParticipantModel
     */
    public function createNewParticipant($threadId, $userId){

        $participant = new chatParticipantModel();

        $participant->thread_id = $threadId;
        $participant->user_id = $userId;
        $participant->last_read = date('Y-m-d H:i:s');

        $participant->save();
        return $participant;
    }

    public function updateLastRead($threadId, $userId, $isRead = 1){
        $participant = $this->where('thread_id', $threadId)->get();

        if(count($participant)){
            if($isRead)
                return $this->where('thread_id', $threadId)
                    ->update(['user_id'=> $userId, 'last_read' => date('Y-m-d H:i:s'), 'is_read' => $isRead]);
            else
                return $this->where('thread_id', $threadId)
                    ->update(['is_read' => $isRead]);
        }
        else
        {
            $participant = new chatParticipantModel();
            $participant->thread_id = $threadId;
            $participant->is_read = $isRead;
            if($isRead)
            {
                $participant->last_read = date('Y-m-d H:i:s');
                $participant->user_id = $userId;

            }

            $participant->save();
        }

        return $participant;
    }

}
