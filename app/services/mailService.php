<?php namespace App\services;

use \Kacana\Util;
use Illuminate\Support\Facades\Mail;
use App\services\orderService;

/**
 * Class mailService
 * @package App\services
 */
class mailService {

    public function sendEmailOrder($email, $orderId)
    {
        $orderService = new orderService();
        $subject = "Kacana đã nhận đơn hàng ". $orderId;
        $viewBlade = 'client.emails.send-email-order';
        $bcc = KACANA_EMAIL_DON_HANG;
        $orderData = ['order'=>$orderService->getOrderById($orderId)];
        return $this->send($email, $subject, $viewBlade, $orderData, $bcc);
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
}