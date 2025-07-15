<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\ProjectInvitation;

class NotificationController extends Controller
{
    public function show($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        // Найдём приглашение по passport_id и user_id
        $invitation = \App\Models\ProjectInvitation::where('passport_id', $notification->data['passport_id'])
            ->where('user_id', auth()->id())
            ->first();

        return view('notifications.show', compact('notification', 'invitation'));
    }
}
