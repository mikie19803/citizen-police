<?php

namespace App\Http\Controllers;

use App\Mail\VerifyAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestScriptsController extends Controller
{
    //
    public function testEmail($toEmail)
    {
        try{
            Mail::to($toEmail)->queue(new VerifyAccount('test','test'));



echo 'Email sent successfully to '.$toEmail;

        }catch(\Exception $e){
echo 'Email could not be sent to '.$toEmail."<br/>";
echo $e->getMessage();
        }
    }

    public function testSms()
    {
        $q = new GeneralController();
        $q->sendMessage('0247563014','Test message localhost');
    }
}