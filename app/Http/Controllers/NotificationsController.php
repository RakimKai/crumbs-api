<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationsResource;
use App\Models\User;
use App\Models\UserNotifications;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    use HttpResponses;

    public function index(Request $request){
        $user = Auth::user();
        $userNotifications = DB::table('notifications')
        ->whereJsonContains('data->id', $user->id)
        ->paginate($request->query('perPage'));
        $notificationsCollection = NotificationsResource::collection($userNotifications);
        return $notificationsCollection;
    }

    public function readAll(){
        DB::table('notifications')->whereJsonContains('data->id', Auth::user()->id)->update(['read_at'=>now()]);
        return $this->success(null,'You have successfully marked all notifications as read',200);
    }


}
