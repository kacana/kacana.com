<?php namespace App\services;

use App\models\facebookCommentModel;

class webhookService extends baseService {

    public function facebookWebhook($data){
        $facebookCommentModel = new facebookCommentModel();

        if(isset($data['entry'][0]['changes'][0]))
        {
            $dataImport = $data['entry'][0]['changes'][0]['value'];
            $facebookCommentModel->createItem($dataImport);
        }

        if(isset($data['hub_challenge']))
            return $data['hub_challenge'];
    }
}
