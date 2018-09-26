<?php
namespace App\Http\ViewComposers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


/**
 * Created by PhpStorm.
 * User: Vincentia
 * Date: 09-Sep-17
 * Time: 1:09 PM
 */
class NotificationComposer
{
    public $user;
    public function __construct()
    {
//        $this->user = $user;
     }

    public function compose(View $view)
    {
        if(Auth::guest()){
            $invitationsN = [];
        }else{
            $invitationsN = Auth::user()->receivedInvitations;
        }

        $view->with([
            'invitationsN'=> $invitationsN
        ]);
    }

}