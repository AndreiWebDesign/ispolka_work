<?php

namespace App\Notifications;

use App\Models\Passport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectInvitationNotification extends Notification
{
    use Queueable;

    public $passport;
    public $inviter;
    public $role;

    public function __construct(Passport $passport, $inviter, $role)
    {
        $this->passport = $passport;
        $this->inviter = $inviter;
        $this->role = $role;
    }

    // Только через базу данных
    public function via($notifiable)
    {
        return ['database'];
    }

    // Что хранить в базе
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Вас пригласили к участию в объекте "' . $this->passport->object_name . '" как ' . $this->role,
            'passport_id' => $this->passport->id, // ⚠️ ключ должен совпадать с тем, что ты используешь в Blade
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Вас пригласили к объекту "' . $this->passport->object_name . '" как ' . $this->role,
            'invitation_id' => $this->invitation->id, // это обязательно
        ];
    }

    public function index()
    {
        $notifications = auth()->user()->unreadNotifications;
        return view('notifications.index', compact('notifications'));
    }
}
