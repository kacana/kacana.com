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

}
