<?php

namespace app\components;

use Yii;
use yii\base\Component;

class SmsSender extends Component
{
    public $apiKey;
    public $apiUrl = 'https://smspilot.ru/api.php';

    public function send($phone, $message)
    {
        $params = [
            'send' => $message,
            'to' => $phone,
            'apikey' => $this->apiKey,
            'format' => 'json',
        ];

        $url = $this->apiUrl . '?' . http_build_query($params);

        // Log the attempt
        Yii::info("Sending SMS to $phone: $message", 'sms');

        // Send request
        $response = @file_get_contents($url);

        Yii::info("SMS Response: $response", 'sms');

        return $response;
    }
}
