<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class NotificationsController extends Controller
{
    //
    public function markAsRead($nofity_id)
    {
        //auth()->user()->unreadNotifications->markAsRead();
        //$res = auth()->user()->unreadNotifications->markEachNotificationAsRead('545abba8-4f66-4c29-ba68-b4956ef9f500');
        auth()->user()->unreadNotifications->map(function ($n) use ($nofity_id) {
            if ($n->id == $nofity_id) {
                $n->markAsRead();
            }
        });
    }

}
