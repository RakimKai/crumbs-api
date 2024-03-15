<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    use HttpResponses;

    public function index(){
        $user = Auth::user();
        $userNotifications = DB::table('notifications')
        ->whereJsonContains('data->id', $user->id)
        ->get();
        return $userNotifications;
    }


}
