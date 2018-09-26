<?php

namespace App\Http\Controllers;

 use App\Classes\DBBackup;
 use App\Mail\SendAlerts;
use App\Mail\SendCollaborationInvitation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class NotificationsController extends Controller
{
    //
    public function create() //returns view for creating notificaiton
    {
        return view('alert.create');
    }
    public function store(Request $request) //sends alert to users
    {
        $q = new GeneralController();

        $email = $request->email_content;
        $sms = $request->sms_content;
//dd($email);
        $citizens = User::where([
            'role' => 'citizen'
        ])->get();

        foreach ($citizens as $citizen) {
            if (trim($citizen->email) != '') {

                Mail::to($citizen->email)->queue(new SendAlerts($citizen->name,$email));
            }else{
                $q->sendMessage($citizen->phone,$sms);
            }
        }
        Session::flash('success','Notifications have been sent.');
        return redirect()->back();
    }

    public function backupDatabase()
    {

        $db = new DBBackup(array(
            'driver' => 'mysql',
            'host' => env('DB_HOST'),
            'user' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'database' => env('DB_DATABASE')
        ));

        $backup = $db->backup();
        if (!$backup['error']) {
            // If there aren't errors, show the content
            // The backup will be at $var['msg']
            // You can do everything you want to. Like save in a file.
            $b = nl2br($backup['msg']);
            $filename = 'citizen_police_' . date('Y_m_d_H_i_s') . ".sql";
            $fp = fopen('dbbackups/' . $filename, 'a+');
            fwrite($fp, $backup['msg']);
            fclose($fp);
            return response()->download('dbbackups/' . $filename);


         } else {
            echo 'An error has ocurred.';
        }

    }


}
