<?php

namespace App\Http\Controllers;

use App\Models\Passport;
use App\Models\HiddenWork;
use Illuminate\Http\Request;
use mikehaertl\pdftk\Pdf;


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
        $validated = $request->validate([
            'act_number' => 'required|string',
            'act_date' => 'required|date',
            'object_name' => 'required|string',
            'passport_id' => 'required|exists:passports,id',

            // Комиссия
            'contractor_representative' => 'required|string',
            'tech_supervisor_representative' => 'required|string',
            'author_supervisor_representative' => 'nullable|string',
            'additional_participants' => 'nullable|string',

            // Работы
            'work_executor' => 'required|string',
            'hidden_works' => 'required|string',
            'psd_info' => 'required|string',
            'materials' => 'nullable|string',
            'compliance_evidence' => 'nullable|string',
            'deviations' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'commission_decision' => 'required|string',
            'next_works' => 'nullable|string',

            // Подписи
            'contractor_sign_name' => 'required|string',
            'contractor_sign' => 'required|string',
            'tech_supervisor_sign_name' => 'required|string',
            'tech_supervisor_sign' => 'required|string',
            'author_supervisor_sign_name' => 'nullable|string',
            'author_supervisor_sign' => 'nullable|string',
            'additional_signs' => 'nullable|string',
        ]);

        $act = HiddenWork::create($validated);

        // Генерация PDF после создания
        $pdfPath = storage_path("app/pdf_outputs/act_{$act->id}.pdf");
        $templatePath = storage_path('app/pdf_templates/hidden_work_template.pdf');

        $fields = [
            'act_number' => $act->act_number,
            'city' => $act->city,
            'act_date' => $act->act_date,
            'object_name' => $act->object_name,
            'contractor_representative' => $act->contractor_representative,
            'tech_supervisor_representative' => $act->tech_supervisor_representative,
            'author_supervisor_representative' => $act->author_supervisor_representative,
            'additional_participants' => $act->additional_participants,
            'work_executor' => $act->work_executor,
            'hidden_works' => $act->hidden_works,
            'psd_info' => $act->psd_info,
            'materials' => $act->materials,
            'compliance_evidence' => $act->compliance_evidence,
            'deviations' => $act->deviations,
            'start_date' => $act->start_date,
            'end_date' => $act->end_date,
            'commission_decision' => $act->commission_decision,
            'next_works' => $act->next_works,
            'contractor_sign_name' => $act->contractor_sign_name,
            'contractor_sign' => $act->contractor_sign,
            'tech_supervisor_sign_name' => $act->tech_supervisor_sign_name,
            'tech_supervisor_sign' => $act->tech_supervisor_sign,
            'author_supervisor_sign_name' => $act->author_supervisor_sign_name,
            'author_supervisor_sign' => $act->author_supervisor_sign,
            'additional_signs' => $act->additional_signs,
        ];

        $pdf = new Pdf($templatePath);
        $result = $pdf->fillForm($fields)
            ->needAppearances()
            ->flatten()
            ->replacementFont('/var/www/ispolka/public/times.ttf')
            ->saveAs($pdfPath);

        if (!$result) {
            return back()->with('error', 'Ошибка при создании PDF: ' . $pdf->getError());
        }

        return redirect()->route('projects.show',$passport)->with('success', 'Акт успешно создан и сохранён как PDF.');
    }

    public function passport()
    {
        return $this->belongsTo(\App\Models\Passport::class);
    }
}
