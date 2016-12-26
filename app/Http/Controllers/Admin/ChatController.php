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
        $result['ok'] = 0;
        $message = $request->input('message', '');
        $threadId = $request->input('threadId', 15);

        try{
            $pusher = new KPusher();

            $pusher->createNewPush($message, $threadId, KACANA_CHAT_TYPE_REPLY);
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
}
