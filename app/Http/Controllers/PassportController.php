<?php

namespace App\Http\Controllers;

use App\Models\Passport;
use Illuminate\Http\Request;

class PassportController extends Controller
{
    // Список паспортов только текущего пользователя
    public function index()
    {
        $passports = auth()->user()->passports()->latest()->get();
        return view('projects.index', compact('passports'));
    }

    // Форма создания паспорта
    public function create()
    {
        return view('projects.create');
    }

    // Сохранение нового паспорта
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

    // Просмотр паспорта и связанных актов (только для владельца)
    public function show(Passport $passport)
    {
        // Защита: только владелец может просматривать объект
        if ($passport->user_id !== auth()->id()) {
            abort(403, 'Доступ запрещён');
        }

        // Получаем все акты, связанные с этим паспортом
        $acts = $passport->hiddenWorks()->orderBy('act_date', 'desc')->get();

        return view('projects.show', compact('passport', 'acts'));
    }
}
