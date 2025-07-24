<?php

namespace App\Http\Controllers;

use App\Models\Passport;
use App\Models\User;
use App\Models\ProjectInvitation;
use Illuminate\Http\Request;
use App\Notifications\ProjectInvitationNotification;

class ObjectAndProjectController extends Controller
{
    // ==== ОБЪЕКТЫ (ПАСПОРТА) ====
    public function projectCreate()
    {
        if (auth()->user()->role !== 'подрядчик') {
            abort(403, 'Доступ запрещён');
        }

        return view('projects.create');
    }

    public function projectStore(Request $request)
    {
        if (auth()->user()->role !== 'подрядчик') {
            abort(403, 'Доступ запрещён');
        }

        $request->validate(['name' => 'required|string']);

        $project = Project::create([
            'name' => $request->name,
            'contractor_id' => auth()->id(),
        ]);

        return redirect()->route('projects.index')->with('success', 'Проект создан.');
    }

    public function index()
    {
        $user = auth()->user();

        // 1. Паспорта, созданные этим пользователем (он подрядчик)
        $ownPassports = Passport::where('user_id', $user->id);

        // 2. Паспорта, куда он приглашён (технадзор/авторнадзор)
        $invitedPassports = $user->passports(); // если метод определён в модели

        // Если нет метода -> добавим raw-запрос:
        $invitedIds = \DB::table('project_user_roles')
            ->where('user_id', $user->id)
            ->pluck('passport_id');

        $invitedPassports = Passport::whereIn('id', $invitedIds);

        // Объединяем
        $passports = $ownPassports->union($invitedPassports)->get();

        return view('projects.index', compact('passports'));
    }


    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            'customer' => 'required|string|max:255',
            'customer_responsible' => 'nullable|string|max:255',
            'contractor' => 'required|string|max:255',
            'contractor_responsible' => 'required|string|max:255',
            'tech_supervisor' => 'required|string|max:255',
            'tech_supervisor_responsible' => 'required|string|max:255',
            'author_supervisor' => 'required|string|max:255',
            'author_supervisor_responsible' => 'required|string|max:255',
            'project_developer' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'locality' => 'nullable|string|max:255',
            'psd_number' => 'required|string|max:255',
            'object_name' => 'nullable|string|max:255',
        ]);
        $validated['user_id'] = auth()->id();

        $passport = Passport::create($validated);

        return redirect()->route('projects.show', $passport)->with('success', 'Паспорт объекта создан!');
    }

    public function show(Passport $passport)
    {
        $hasAccess = $passport->users()->where('user_id', auth()->id())->exists() || $passport->user_id == auth()->id();
        if (!$hasAccess) {
            abort(403, 'Доступ запрещён');
        }

        $passport->load(['hiddenWorks.signatures.user', 'intermediateAccepts.signatures.user']);

        $hiddenWorks = $passport->hiddenWorks->map(function ($item) {
            $item->type = 'hidden_works';
            return $item;
        });

        $intermediateAccepts = $passport->intermediateAccepts->map(function ($item) {
            $item->type = 'intermediate_accept';
            return $item;
        });

        $acts = $passport->acts->groupBy('act_type');


        $role = $passport->users()
            ->where('user_id', auth()->id())
            ->first()
            ?->pivot
            ?->role;

        if (!$role && $passport->user_id == auth()->id()) {
            $role = 'подрядчик';
        }

        $cmsFiles = [];
        foreach ($acts as $group) {
            foreach ($group as $act) {
                $cmsPath = storage_path("app/pdf_outputs/{$passport->id}/{$act->type}/{$act->act_number}/1.cms");
                $cmsFiles[$act->type . '_' . $act->act_number] = file_exists($cmsPath);
            }
        }

        return view('projects.show', compact('passport', 'acts', 'role', 'cmsFiles'));
    }


    // ==== ПРОЕКТЫ ====



    public function invite(Request $request, Passport $passport)
    {
        $request->validate([
            'bin' => 'required|string',
            'role' => 'required|in:технадзор,авторнадзор',
        ]);

        // Проверяем, что текущий пользователь — владелец паспорта
        if ($passport->user_id !== auth()->id()) {
            abort(403, 'Вы не являетесь владельцем объекта');
        }

        $user = User::where('bin', $request->bin)->firstOrFail();

        $invitation = ProjectInvitation::create([
            'user_id'    => $user->id,
            'passport_id' => $passport->id, // или переименуй поле в 'passport_id', если меняешь логику
            'role'       => $request->role,
        ]);

        $user->notify(new ProjectInvitationNotification($passport, auth()->user(), $request->role));

        return back()->with('success', 'Приглашение отправлено.');
    }
    public function accept(ProjectInvitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        $invitation->update(['status' => 'accepted']);
        $invitation->passport->users()->attach($invitation->user_id, ['role' => $invitation->role]);

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
        // Получаем все уведомления текущего пользователя
        $notifications = auth()->user()->notifications;

        return view('notifications.index', compact('notifications'));
    }

}
