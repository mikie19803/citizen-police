<?php

namespace App\Http\Controllers;

use App\OfficerReport;
use App\User;
use App\UserReport;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class GeneralController extends Controller
{
    //
    public $paginate = 10;
    public $citizenCommentBackground = '#FBF6EE';
    public $officerCommentBackground = '#ECECEC';

    public function generateConfirmationCode()
    {
        return strtoupper(str_random(7));
    }

    public function generateConfirmationStatus()
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        return md5(substr(str_shuffle($chars), 0, 4));
    }


    public function verifyCaptcha($recaptchaResponse)
    {
        $arr = array();
        $arr['success'] = 1;
        return $arr;

        try {
            $secretKey = config('app.captchaSecretKey');
            $ip = $_SERVER['REMOTE_ADDR'];
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey .
                "&response=" . $recaptchaResponse . "&remoteip=" . $ip);
            $responseKeys = json_decode($response, true);
            return $responseKeys;
        } catch (ErrorException $e) {
            Log::info('Google recapture : ' . $e);
            $arr = array();
            $arr['success'] = 'recaptcha-error';
            return $arr;
        }

    }

    public function generateAccountNumber()
    {
        $chars = "12345678901234567890123456789012345678901234567890123456789012345678901234567890";
        $check = false;
        //Check if code exists in db;
        while ($check == false) {
            $code = substr(str_shuffle($chars), 0, 7);
            $count = User::where('account_no', $code)->count();
            if ($count > 0) {
                $check = false;
            } else {
                $check = true;
            }

        }
        return $code;


    }

    public static function getCitizenCmtBckGrnd()
    {
        $q = new GeneralController();
        return $q->citizenCommentBackground;
    }

    public static function getOfficerCmtBckGrnd()
    {
        $q = new GeneralController();
        return $q->officerCommentBackground;
    }

    public function sendMessage($toPhone, $message)
    {
        $clientId = config('custom.hubtelClientId');  // Remember to put your own API Key here
        $clientSecret = config('custom.hubtelClientSecret');  // Remember to put your own API Key here
        $sender_id = config('custom.hubtelSenderId'); //11 Characters maximum;
        $date_time = Carbon::now()->format('Y-m-d H:i:s');

//encode the message
        $message = urlencode($message);

//prepare your url
        $url = "https://api.hubtel.com/v1/messages/send?From=".$sender_id."&To=".$toPhone."&Content=".$message."&ClientId=".$clientId."&ClientSecret=".$clientSecret."&RegisteredDelivery=true";

        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);


            $ress = json_decode($result,true);
//
            return $ress['status'];
        } catch (\Exception $e) {
//    return 'Message could not be sent.';
            return $e->getMessage();
        }



    }

    public function sendMessage2($toPhone, $message) // for mnotify
    {
        $key = config('custom.mNotifyApiKey');  // Remember to put your own API Key here
        $sender_id = config('custom.mNotifySenderId'); //11 Characters maximum;
        $date_time = Carbon::now()->format('Y-m-d H:i:s');

//encode the message
        $message = urlencode($message);

//prepare your url
        $url = "https://apps.mnotify.net/smsapi?"
            . "key=$key"
            . "&to=$toPhone"
            . "&msg=$message"
            . "&sender_id=$sender_id"
            . "&date_time=$date_time";

        try {
            $ch = curl_init($url);
            $result = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

        } catch (\Exception $e) {
//    return 'Message could not be sent.';
            return $e->getMessage();
        }
        $res = '';
        switch ($result) {
            case "1000":
                $res = "Message sent";
                break;
            case "1002":
                $res = "Message not sent";
                break;
            case "1003":
                $res = "You don't have enough balance";
                break;
            case "1004":
                $res = "Invalid API Key";
                break;
            case "1005":
                $res = "Phone number not valid";
                break;
            case "1006":
                $res = "Invalid Sender ID";
                break;
            case "1008":
                $res = "Empty message";
                break;
        }
//        dd($result);


    }
}
