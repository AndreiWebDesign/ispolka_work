<?php

namespace App\Http\Controllers;

use App\Models\Passport;
use App\Models\HiddenWork;
use Illuminate\Http\Request;

class ActController extends Controller
{
    // Форма создания акта для выбранного объекта
    public function create(Passport $passport)
    {
        // Проверка: только владелец объекта может создавать акты
        if ($passport->user_id !== auth()->id()) {
            abort(403, 'Доступ запрещён');
        }

        $maxActNumber = HiddenWork::where('passport_id', $passport->id)->max('act_number');
        $nextActNumber = $maxActNumber ? $maxActNumber + 1 : 1;
        return view('acts.create', compact('passport', 'nextActNumber'));
    }

    // Сохранение акта для объекта
    public function store(Request $request, Passport $passport)
    {
        // Проверка: только владелец объекта может сохранять акты
        if ($passport->user_id !== auth()->id()) {
            abort(403, 'Доступ запрещён');
        }

        $validated = $request->validate([
            'act_number' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'act_date' => 'required|date',
            'object_name' => 'nullable|string|max:255',
            'contractor_representative' => 'nullable|string|max:255',
            'tech_supervisor_representative' => 'nullable|string|max:255',
            'author_supervisor_representative' => 'nullable|string|max:255',
            'additional_participants' => 'nullable|string|max:1000',
            'work_executor' => 'nullable|string|max:255',
            'hidden_works' => 'nullable|string|max:1000',
            'psd_info' => 'nullable|string|max:1000',
            'materials' => 'nullable|string|max:1000',
            'compliance_evidence' => 'nullable|string|max:1000',
            'deviations' => 'nullable|string|max:1000',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'commission_decision' => 'nullable|string|max:255',
            'next_works' => 'nullable|string|max:1000',
            'contractor_sign_name' => 'nullable|string|max:255',
            'contractor_sign' => 'nullable|string|max:255',
            'tech_supervisor_sign_name' => 'nullable|string|max:255',
            'tech_supervisor_sign' => 'nullable|string|max:255',
            'author_supervisor_sign_name' => 'nullable|string|max:255',
            'author_supervisor_sign' => 'nullable|string|max:255',
            'additional_signs' => 'nullable|string|max:1000',
            'type' => 'nullable|string|max:255',
        ]);

        // Сохраняем акт как hidden work, привязывая к объекту
        $passport->hiddenWorks()->create($validated);

        return redirect()->route('projects.show', $passport)->with('success', 'Акт успешно создан!');
    }

    public function passport()
    {
        return $this->belongsTo(\App\Models\Passport::class);
    }
}
