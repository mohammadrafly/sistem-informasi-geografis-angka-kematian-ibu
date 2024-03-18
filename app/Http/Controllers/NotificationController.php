<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::unread(Auth::user()->id)->get();
        return response()->json($notifications);
    }

    public function update(Request $request)
    {
        Notification::updateToRead($request->id);
        return response()->json( 'Notification marked as read.');
    }
}
