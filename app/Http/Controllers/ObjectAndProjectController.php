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

        // Приглашённые паспорта (через project_user_roles)
        $invitedIds = \DB::table('project_user_roles')
            ->where('user_id', $user->id)
            ->pluck('passport_id');

        // Завершённые паспорта (step = 4)
        $completedPassports = Passport::where('step', 4)
            ->where(function ($query) use ($user, $invitedIds) {
                $query->where('user_id', $user->id)
                    ->orWhereIn('id', $invitedIds);
            })->get();

        // Черновики (step < 4)
        $draftPassports = Passport::where('step', '<', 4)
            ->where('user_id', $user->id) // только свои черновики
            ->get();

        return view('projects.index', compact('completedPassports', 'draftPassports'));
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

        // Загрузка подписей всех типов
        $passport->load([
            'hiddenWorks.signatures.user',
            'intermediateAccepts.signatures.user',
            'prilozeniye21s.signatures.user',
            'prilozeniye22s.signatures.user',
            'prilozeniye23s.signatures.user',
            'prilozeniye24s.signatures.user',
            'prilozeniye26s.signatures.user',
            'prilozeniye27s.signatures.user',
            'prilozeniye28s.signatures.user',
            'prilozeniye29s.signatures.user',
            'prilozeniye30s.signatures.user',
            'prilozeniye31s.signatures.user',
            'prilozeniye32s.signatures.user',
            'prilozeniye67s.signatures.user',
            'prilozeniye72s.signatures.user',
            'prilozeniye73s.signatures.user',
            'prilozeniye74s.signatures.user',
            'prilozeniye75s.signatures.user',
            'prilozeniyeGotovnPodmosteis.signatures.user',
            'prilozeniyeGotovnLifts.signatures.user',
        ]);

        // Преобразование всех актов в коллекции с type
        $actsCollections = collect();

        $mapTypes = [
            'hidden_works' => $passport->hiddenWorks,
            'intermediate_accept' => $passport->intermediateAccepts,
            'prilozeniye_21' => $passport->prilozeniye21s,
            'prilozeniye_22' => $passport->prilozeniye22s,
            'prilozeniye_23' => $passport->prilozeniye23s,
            'prilozeniye_24' => $passport->prilozeniye24s,
            'prilozeniye_26' => $passport->prilozeniye26s,
            'prilozeniye_27' => $passport->prilozeniye27s,
            'prilozeniye_28' => $passport->prilozeniye28s,
            'prilozeniye_29' => $passport->prilozeniye29s,
            'prilozeniye_30' => $passport->prilozeniye30s,
            'prilozeniye_31' => $passport->prilozeniye31s,
            'prilozeniye_32' => $passport->prilozeniye32s,
            'prilozeniye_67' => $passport->prilozeniye67s,
            'prilozeniye_72' => $passport->prilozeniye72s,
            'prilozeniye_73' => $passport->prilozeniye73s,
            'prilozeniye_74' => $passport->prilozeniye74s,
            'prilozeniye_75' => $passport->prilozeniye75s,
            'prilozeniye_gotovn_podmostei' => $passport->prilozeniyeGotovnPodmosteis,
            'prilozeniye_gotovn_lift' => $passport->prilozeniyeGotovnLifts,
        ];

        foreach ($mapTypes as $type => $collection) {
            $actsCollections = $actsCollections->merge(
                $collection->map(function ($item) use ($type) {
                    $item->type = $type;
                    return $item;
                })
            );
        }

        // Группировка по типу
        $acts = $actsCollections->groupBy('type');

        // Получение роли пользователя
        $role = $passport->users()
            ->where('user_id', auth()->id())
            ->first()
            ?->pivot
            ?->role;

        if (!$role && $passport->user_id == auth()->id()) {
            $role = 'подрядчик';
        }

        // Наличие CMS-файлов
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

        return redirect()->route('projects.index')->with('success', 'Вы присоединились к проекту.');

    }

    public function decline(ProjectInvitation $invitation)
    {
        if ($invitation->user_id !== auth()->id()) {
            abort(403);
        }

        // Обновляем статус
        $invitation->update(['status' => 'declined']);

        // Удаляем уведомление по условию
        auth()->user()
            ->notifications()
            ->where('type', 'App\Notifications\ProjectInvitationNotification')
            ->where('data->invitation_id', $invitation->id)
            ->delete();

        return redirect()->route('projects.index')->with('info', 'Приглашение отклонено.');
    }



    public function notifications()
    {
        // Получаем все уведомления текущего пользователя
        $notifications = auth()->user()->notifications;

        return view('notifications.index', compact('notifications'));
    }

}
