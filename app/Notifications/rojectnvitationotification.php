<?php

use Illuminate\Notifications\Notification;

class ProjectInvitationNotification extends Notification
{
    public $project, $inviter, $role;

    public function __construct($project, $inviter, $role)
    {
        $this->project = $project;
        $this->inviter = $inviter;
        $this->role = $role;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'project_id' => $this->project->id,
            'project_name' => $this->project->name,
            'inviter_name' => $this->inviter->name,
            'role' => $this->role,
            'message' => "{$this->inviter->name} пригласил вас в проект «{$this->project->name}» как {$this->role}",
        ];
    }
}
