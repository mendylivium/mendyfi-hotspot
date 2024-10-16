<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait TelegramHelper
{
    public function telegramSendMessage($token,$chat_id,$msg)
    {
        Http::get("https://api.telegram.org/bot{$token}/sendmessage?chat_id={$chat_id}&text={$msg}&parse_mode=HTML");
    }

    public function telegramValidate($token,$chat_id,$testMessage = "This message is used for Validation of Your Telegram Settings - Just Ignore")
    {
        $response = Http::get("https://api.telegram.org/bot{$token}/sendmessage?chat_id={$chat_id}&text={$testMessage}&parse_mode=HTML");
        return json_decode($response,true)['ok'];
    }
}
