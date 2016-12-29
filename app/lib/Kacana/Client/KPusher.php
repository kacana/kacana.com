<?php
namespace Kacana\Client;
use Pusher;

class KPusher extends Pusher
{

    private $_chanelName = 'Kacana_Client';

    public function __construct() {
        $options = array(
            'cluster' => 'ap1',
            'encrypted' => true
        );

        parent::__construct(KACANA_REAL_PUSHER_KEY, KACANA_REAL_PUSHER_SECRET, KACANA_REAL_PUSHER_ID, $options);
    }

    public function createNewPush($message, $threadId, $type)
    {
        $data['message'] = $message;
        $data['type'] = $type;
        $data['date'] =  date('Y-m-d H:i:s');
        $this->trigger($this->_chanelName, $threadId, $data);
    }

    public function createNewThread($threadId, $type){

        $data['threadId'] = $threadId;
        $data['type'] = $type;
        $data['subject'] = 'new chat message';
        $data['date'] =  date('Y-m-d H:i:s');

        $this->trigger($this->_chanelName, KACANA_REAL_PUSHER_NEW_THREAD, $data);
    }
}

?>