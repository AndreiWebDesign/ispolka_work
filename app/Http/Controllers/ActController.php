<?php

namespace App\Http\Controllers;

use App\Models\Passport;
use App\Models\HiddenWork;
use Illuminate\Http\Request;
use mikehaertl\pdftk\Pdf;


class ActController extends Controller
{
    public function select(Passport $passport)
    {
        $actTemplates = config('act_templates');
        $groupedActs = [];

// Формируем массив
        foreach ($actTemplates as $key => $template) {
            $group = $template['group'] ?? 'Прочие акты';
            $label = $template['label'] ?? $key;
            $groupedActs[$group][$key] = $label;
        }

// 1. Сортируем группы по ключу (группе)
        uksort($groupedActs, function ($a, $b) {
            // Попробуем сортировать по номеру перед названием, если он есть
            return strnatcasecmp($a, $b);
        });

// 2. Сортируем элементы внутри каждой группы по названию акта
        foreach ($groupedActs as &$acts) {
            asort($acts, SORT_NATURAL | SORT_FLAG_CASE);
        }
        unset($acts); // на всякий случай

        return view('acts.select', compact('passport', 'groupedActs'));

    }
    // Форма создания акта для выбранного объекта
    public function create(Passport $passport, Request $request)
    {
        if ($passport->user_id !== auth()->id()) {
            abort(403, 'Доступ запрещён');
        }

        $type = $request->query('type');
        $templates = config('act_templates');

        if (!isset($templates[$type])) {
            abort(404, 'Неверный тип акта');
        }

        $modelClass = $templates[$type]['model'];
        $numberField = $templates[$type]['number_field'] ?? 'act_number';
        $fieldsToTry = ['number_acts', 'number_act', 'act_number'];
        $numberField = null;

        foreach ($fieldsToTry as $field) {
            if (
                \Schema::hasColumn((new $modelClass)->getTable(), $field)
            ) {
                $numberField = $field;
                break;
            }
        }
        // Если не нашли — можно дефолт, но лучше выбросить ошибку
        if (!$numberField) {
            abort(503, 'Не найдено ни одно подходящее поле для номера акта.');
        }

        $maxActNumber = $modelClass::where('passport_id', $passport->id)->max($numberField);

        $nextActNumber = $maxActNumber ? $maxActNumber + 1 : 1;

        // Получаем название blade-шаблона, если указано (например: 'acts.templates.prilozeniye_21')
        $view = $templates[$type]['view'] ?? 'acts.create';
        return view($view, compact('passport', 'nextActNumber', 'type'));
    }



    protected $actModels = [
        'hidden_works' => \App\Models\HiddenWork::class,
        'intermediate_accept' => \App\Models\IntermediateAccept::class,
        'Prilozeniye_21' => \App\Models\Prilozeniye_21::class,
        'Prilozeniye_22' => \App\Models\Prilozeniye_22::class,
        'Prilozeniye_23' => \App\Models\Prilozeniye_23::class,
        'Prilozeniye_24' => \App\Models\Prilozeniye_24::class,
        'Prilozeniye_26' => \App\Models\Prilozeniye_26::class,
        'Prilozeniye_27' => \App\Models\Prilozeniye_27::class,
        'Prilozeniye_28' => \App\Models\Prilozeniye_28::class,
        'Prilozeniye_29' => \App\Models\Prilozeniye_29::class,
        'Prilozeniye_30' => \App\Models\Prilozeniye_30::class,
        'Prilozeniye_31' => \App\Models\Prilozeniye_31::class,
        'Prilozeniye_32' => \App\Models\Prilozeniye_32::class,
        'Prilozeniye_67' => \App\Models\Prilozeniye_67::class,
        'Prilozeniye_72' => \App\Models\Prilozeniye_72::class,
        'Prilozeniye_73' => \App\Models\Prilozeniye_73::class,
        'Prilozeniye_74' => \App\Models\Prilozeniye_74::class,
        'Prilozeniye_75' => \App\Models\Prilozeniye_75::class,
        'Prilozeniye_gotovn_podmostei' => \App\Models\Prilozeniye_gotovnPodmostei::class,
        'prilozeniye_gotovn_lift' => \App\Models\prilozeniyeGotovnLift::class,


        // другие типы…
    ];


    // Сохранение акта для объекта
    public function store(Request $request, Passport $passport)
    {
        $type = $request->input('type');

        $templateConf = config("act_templates.$type");

        if (!$templateConf) {
            return back()->with('error', 'Неизвестный тип акта/шаблона');
        }

        $validated = $request->validate($templateConf['validation']);

        $modelClass = $this->actModels[$type] ?? null;
        if (!$modelClass) {
            return back()->with('error', 'Модель для акта не найдена');
        }

        $act = $modelClass::create($validated);

        $fields = [];
        foreach ($templateConf['fields'] as $field) {
            $fields[$field] = $act->$field ?? '';
        }

        $templatePath = storage_path('app/pdf_templates/' . $templateConf['pdf']);

        // Создаём директорию: /storage/app/pdf_outputs/{passport_id}/{type}/{act_number}/
        $actDirPath = storage_path("app/pdf_outputs/{$passport->id}/{$type}/{$act->act_number}");
        if (!file_exists($actDirPath)) {
            mkdir($actDirPath, 0775, true);
        }

        $pdfPath = "$actDirPath/{$act->act_number}.pdf";

        $pdf = new \mikehaertl\pdftk\Pdf($templatePath);
        $result = $pdf->fillForm($fields)
            ->needAppearances()
            ->flatten()
            ->replacementFont('/var/www/ispolka/public/times.ttf')
            ->saveAs($pdfPath);

        if (!$result) {
            $errorMessage = 'Ошибка при создании PDF: ' . $pdf->getError();
            session()->flash('pdf_error', $errorMessage);
            return back();
        }

        return redirect()->route('projects.show', $passport)
            ->with('success', 'Акт успешно создан.');
    }






    public function passport()
    {
        return $this->belongsTo(\App\Models\Passport::class);
    }
}
