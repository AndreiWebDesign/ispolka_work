<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Passport;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.complete');
    }

    public function update(Request $request)
    {
        $request->validate([
            'bin' => 'required|string|unique:users,bin,' . auth()->id(),
            'organization_name' => 'required|string',
            'role' => 'required|in:подрядчик,технадзор,авторнадзор',
        ]);

        $user = auth()->user();
        $user->bin = $request->bin;
        $user->organization_name = $request->organization_name;
        $user->role = $request->role;
        $user->is_profile_complete = true;
        $user->save();

        return redirect()->route('projects.index')->with('success', 'Профиль заполнен');
    }


    public function inviteEmployee(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'position' => 'required|string|max:255',
        ]);

        $inviter = auth()->user();

        if ($inviter->role !== 'подрядчик') {
            abort(403, 'Только подрядчик может приглашать сотрудников.');
        }

        // Создание пользователя
        $employee = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'bin' => $inviter->bin,
            'organization_name' => $inviter->organization_name,
            'role' => $inviter->role, // Используем роль пригласившего
            'position' => $request->position,
            'is_profile_complete' => true,
        ]);

        // Получение всех объектов пригласившего
        $projects = $inviter->passports; // Или как у тебя называется связь на объекты

        foreach ($projects as $project) {
            ProjectUserRole::create([
                'project_id' => $project->id,
                'user_id' => $employee->id,
                'role' => $inviter->role, // Или $employee->role — если позже дадим выбор
            ]);
        }

        return back()->with('success', 'Сотрудник успешно добавлен');
    }
    public function index()
    {
        $user = auth()->user();

        // Все сотрудники из той же организации (по BIN)
        $employees = User::where('bin', $user->bin)
            ->where('id', '!=', $user->id)
            ->get();

        // Объекты, на которые он приглашён через project_invitations
        $objects = $user->invitedPassports()->with('creator')->get();

        return view('profile.index', compact('user', 'employees', 'objects'));
    }



}
