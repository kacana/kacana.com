<?php namespace App\Http\Controllers\Client;

use App\services\chatService;
use App\services\productService;
use App\services\shipService;
use App\services\tagService;
use App\services\trackingService;
use App\services\userService;
use Illuminate\Http\Request;
use Kacana\Util;
use Kacana\Client\KPusher;
/**
 * Class ChatController
 * @package App\Http\Controllers\Client
 */
class ChatController extends BaseController {

    public function createNewMessage(Request $request)
    {
        $chatService = new chatService();

        $result['ok'] = 0;
        $message = $request->input('message', '');
        $threadId = $request->input('threadId', 15);

        try{
            $pusher = new KPusher();

            $userId = ($this->_user)?$this->_user->id:0;

            $chatType = KACANA_CHAT_TYPE_ASK;

            $pusher->createNewPush($message, KACANA_CHAT_THREAD_PREFIX.$threadId, $chatType);
            $chatService->createNewMessage($threadId, $userId, $chatType, $message);

            $result['ok'] = 1;
            $result['thread'] = $threadId;
        }
        catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }

        return response()->json($result);
    }

    public function createNewThread(Request $request)
    {
        $chatService = new chatService();

        $result['ok'] = 0;
        $message = $request->input('message', '');

        try{
            $pusher = new KPusher();

            $userId = ($this->_user)?$this->_user->id:0;

            $chatThread = $chatService->createNewThread('Client_Chat', $userId);
            $chatType = KACANA_CHAT_TYPE_ASK;
            $threadId = KACANA_CHAT_THREAD_PREFIX.$chatThread->id;

            $pusher->createNewPush($message, $threadId, $chatType);
            $chatService->createNewMessage($chatThread->id, $userId, $chatType, $message);

            $result['ok'] = 1;
            $result['threadId'] = $chatThread->id;
        }
        catch (\Exception $e) {
            if($request->ajax())
            {
                $result['error'] = $e->getMessage();
                return $result;
            }
            else
                return view('errors.404', ['error_message' => $e]);
        }

        return response()->json($result);
    }

    public function testMessages(){
        return view('client.index.test-messages');
    }
}
