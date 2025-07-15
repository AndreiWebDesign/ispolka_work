<?php
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectInvitation;
use App\Notifications\ProjectInvitationNotification;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string']);

        $project = Project::create([
            'name' => $request->name,
            'contractor_id' => auth()->id(),
        ]);

        return redirect()->route('projects.index');
    }

    public function invite(Request $request, Project $project)
    {
        $request->validate([
            'bin' => 'required|string',
            'role' => 'required|in:технадзор,авторнадзор',
        ]);

        if ($project->contractor_id !== auth()->id()) {
            abort(403);
        }

        $user = User::where('bin', $request->bin)->firstOrFail();

        $invitation = ProjectInvitation::create([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'role' => $request->role,
        ]);

        $user->notify(new ProjectInvitationNotification($project, auth()->user(), $request->role));

        return back()->with('success', 'Приглашение отправлено.');
    }

    public function accept(ProjectInvitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $invitation->update(['status' => 'accepted']);
        $invitation->project->users()->attach($invitation->user_id, ['role' => $invitation->role]);

        return back()->with('success', 'Вы присоединились к проекту.');
    }

    public function decline(ProjectInvitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $invitation->update(['status' => 'declined']);
        return back()->with('info', 'Приглашение отклонено.');
    }

    public function notifications()
    {
        return view('notifications.index', [
            'notifications' => auth()->user()->notifications,
        ]);
    }
}
