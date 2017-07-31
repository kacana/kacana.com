<?php namespace App\services;

use \Kacana\Util;
use Illuminate\Support\Facades\Mail;
use App\services\orderService;
use App\services\userService;

/**
 * Class mailService
 * @package App\services
 */
class mailService extends baseService {

    public function sendEmailOrder($email, $orderId, $orderCode)
    {
        $orderService = new orderService();
        $subject = "Kacana đã nhận đơn hàng ". $orderCode;
        $viewBlade = 'client.emails.send-email-order';
        $bcc = KACANA_EMAIL_DON_HANG;
        $orderData = ['order'=>$orderService->getOrderById($orderId)];
        return $this->send($email, $subject, $viewBlade, $orderData, $bcc);
    }

    public function sendEmailQuickOrder($orderId)
    {
        $orderService = new orderService();
        $order = $orderService->getOrderById($orderId);
        $subject = "[ĐẶT NHANH][".$order->addressReceive->phone."] Kacana đã nhận đơn hàng". $orderId;
        $viewBlade = 'client.emails.send-email-quick-order';
        $orderData = ['order'=>$order];
        return $this->send(KACANA_EMAIL_DON_HANG, $subject, $viewBlade, $orderData);
    }

    public function sendEmailNewThread($threadId, $message, $email = KACANA_EMAIL_ADMIN){

        $subject = "[KACANA - New thread] ID:".$threadId;
        $viewBlade = 'client.emails.send-email-new-thread';
        $threadData = ['message_text'=>$message];
        return $this->send($email, $subject, $viewBlade, $threadData);
    }


    public function send($toEmail, $subject, $viewBlade, $dataView = array(), $bcc = false, $cc = false){

        $fromEmail = KACANA_EMAIL_INFO;
        $NameFromEmail = KACANA_EMAIL_INFO_NAME;

        $mail =  Mail::send($viewBlade, $dataView, function($message) use($toEmail, $fromEmail, $NameFromEmail, $subject, $bcc){

            $message->from($fromEmail, $NameFromEmail)->to($toEmail)->subject($subject);

            if($bcc)
                $message->bcc($bcc);
        });

        return $mail;
    }

    public function sendEmailForgotPassword($email)
    {
        $userService = new userService();
        $subject = "Kacana.com - Xác nhận phục hồi mật khẩu";
        $viewBlade = 'client.emails.send-email-forgot-password';
        $bcc = KACANA_EMAIL_ADMIN;
        $dataView = ['user'=>$userService->getUserByEmail($email)];
        return $this->send($email, $subject, $viewBlade, $dataView, $bcc);
    }

    public function sendEmailNewUser($email)
    {
        
        $userService = new userService();
        $subject = "Kacana.com - Chào mừng bạn đến với Kacana";
        $viewBlade = 'client.emails.send-email-new-user';
        $bcc = KACANA_EMAIL_ADMIN;
        $dataView = ['user'=>$userService->getUserByEmail($email)];
        return $this->send($email, $subject, $viewBlade, $dataView, $bcc);
    }
}