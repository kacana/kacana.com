<?php namespace App\Http\Controllers\Admin;

use App\services\chatService;
use App\services\orderService;
use App\services\productService;
use App\services\trackingService;
use App\services\userService;
use Illuminate\Http\Request;
use Kacana\Client\KPusher;

class ChatController extends BaseController {

    public function index(Request $request)
	{
        $return['ok'] = 0;
        try{
            $return['ok'] = 1;
        } catch (\Exception $e) {
            if($request->ajax())
            {
                $return['error'] = $e->getMessage();
            }
            else
                return view('errors.404', ['error_message' => $e->getMessage()]);
        }

        return view('admin.chat.index');
	}

	public function sendMessage(Request $request){
        $chatService = new chatService();

        $result['ok'] = 0;
        $message = $request->input('message', '');
        $threadId = $request->input('threadId', 15);

        try{
            $pusher = new KPusher();

            $userId = ($this->_user)?$this->_user->id:0;

            $chatType = KACANA_CHAT_TYPE_REPLY;

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

    public function getNewMessage(Request $request){
        $chatService = new chatService();


        $result['ok'] = 0;

        try{
            $result['data'] = $chatService->getNewMesaage();
            $result['ok'] = 1;
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

    public function getOldThread(Request $request){
        $chatService = new chatService();
        $result['ok'] = 0;

        try{
            $result['data'] = $chatService->getOldThread();
            $result['ok'] = 1;
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

    public function getMessageThread(Request $request){
        $chatService = new chatService();
        $result['ok'] = 0;


    }

    public function updateLastRead(Request $request){
        $chatService = new chatService();
        $result['ok'] = 0;
        $threadId = $request->input('threadId', 0);

        try{
            $result['data'] = $chatService->updateLastRead($threadId, $this->_user->id);
            $result['ok'] = 1;
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
}
