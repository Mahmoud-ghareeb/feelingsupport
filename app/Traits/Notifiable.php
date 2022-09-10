<?php

namespace App\Traits;

trait Notifiable
{
 
    public function sendMessageThroughFCM($registatoin_ids, $data)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' =>   $registatoin_ids   ,
            'data' => $data,
        );
        
        define("GOOGLE_API_KEY", "AAAAQqWumbs:APA91bFo-m1wzceEcndX07W42rDzANBo0xLJTDfdrmnc5WFTaBGQyjjw30Y1OnJGqzYXUvMT58aQq2HSI5_U3hjbMdoVZcS2qYwYgOX6j7y7aJ9w6xTMvqgA77-s-WjFqGtelj9d7YLL");
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    }

}