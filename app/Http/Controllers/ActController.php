<?php

namespace App\Http\Controllers;

use App\Models\Passport;
use App\Models\HiddenWork;
use Illuminate\Http\Request;
use mikehaertl\pdftk\Pdf;
use App\Models\PassportActType;


class ActController extends Controller
{
    public function select(Passport $passport)
    {
        $actTemplates = config('act_templates');
        $hiddenWorkHeadings = config('hidden_work_headings');
        $groupedActs = [];

        // Получаем запись по паспорту
        $actRow = PassportActType::where('passport_id', $passport->id)->first();

        if (!$actRow) {
            return view('acts.select', compact('passport', 'groupedActs'));
        }

        // Преобразуем в массив [имя_поля => значение]
        $selected = $actRow->toArray();

        // Удаляем лишние ключи
        unset($selected['id'], $selected['passport_id'], $selected['created_at'], $selected['updated_at']);

        // Проходим по всем полям, оставляя только включённые (== 1)
        $enabledActs = array_keys(array_filter($selected, fn($v) => $v == 1));

        // Обычные акты
        foreach ($enabledActs as $key) {
            if ($key === 'hidden_works' || $key === 'intermediate_accepts') continue;

            if (isset($actTemplates[$key])) {
                $template = $actTemplates[$key];
                $group = $template['group'] ?? 'Прочие акты';
                $label = $template['label'] ?? $key;

                $groupedActs[$group][$key] = [
                    'label' => $label,
                    'is_hidden' => false,
                ];
            }
        }

        // Скрытые работы
        foreach ($enabledActs as $key) {
            if (isset($hiddenWorkHeadings[$key])) {
                $item = $hiddenWorkHeadings[$key];
                $group = $item['group'] ?? 'Прочие скрытые работы';
                $label = $item['text'] ?? $key;

                $groupedActs[$group][$key] = [
                    'label' => $label,
                    'is_hidden' => true,
                ];
            }
        }

        // Сортировка групп и актов внутри них
        uksort($groupedActs, 'strnatcasecmp');
        foreach ($groupedActs as &$acts) {
            uasort($acts, fn($a, $b) => strnatcasecmp($a['label'], $b['label']));
        }

        return view('acts.select', compact('passport', 'groupedActs'));
    }


    // Форма создания акта для выбранного объекта
    public function create(Passport $passport, Request $request)
    {
        $type = $request->query('type');
        $heading_key = $request->query('heading_key');

        // Выводим начальные параметры запроса
        dump([
            'type' => $type,
            'heading_key' => $heading_key,
        ]);

        $templates = config('act_templates');

        // Проверяем наличие типа акта
        if (!isset($templates[$type])) {
            abort(404, 'Неверный тип акта');
        }

        // Проверка конфигурации шаблона
        dump([
            'template_for_type' => $templates[$type],
        ]);

        $view = $templates[$type]['view'] ?? 'acts.create';

        // Обработка подзаголовка для скрытых работ
        $headingText = null;
        if ($type === 'hidden_works' && $heading_key) {
            $headingText = config("hidden_work_headings.$heading_key.text") ?? null;
            if (!$headingText) abort(404, 'Неверный подпункт акта');
        }

        // Проверяем, есть ли нужная модель
        if (!isset($templates[$type]['model'])) {
            abort(503, 'Не указана модель для типа акта.');
        }

        $modelClass = $templates[$type]['model'];
        if (!class_exists($modelClass)) {
            abort(503, "Класс модели {$modelClass} не найден.");
        }

        dump([
            'modelClass' => $modelClass,
        ]);

        // Поиск подходящего поля для номера акта
        $fieldsToTry = ['number_acts', 'number_act', 'act_number'];
        $numberField = null;
        foreach ($fieldsToTry as $field) {
            if (\Schema::hasColumn((new $modelClass)->getTable(), $field)) {
                $numberField = $field;
                break;
            }
        }

        dump([
            'numberField' => $numberField,
            'model_table' => (new $modelClass)->getTable(),
        ]);

        if (!$numberField) {
            abort(503, 'Не найдено ни одно подходящее поле для номера акта.');
        }

        // Проверяем наличие записей
        $maxActNumber = $modelClass::where('passport_id', $passport->id)->max($numberField);
        $nextActNumber = $maxActNumber ? $maxActNumber + 1 : 1;

        dump([
            'passport_id' => $passport->id,
            'maxActNumber' => $maxActNumber,
            'nextActNumber' => $nextActNumber,
        ]);

        // Окончательный рендер
        return view($view, compact(
            'passport',
            'nextActNumber',
            'type',
            'heading_key',
            'headingText'
        ));
    }






    protected $actModels = [
        'hidden_works' => \App\Models\HiddenWork::class,
        'intermediate_accept' => \App\Models\IntermediateAccept::class,
        'prilozeniye_21' => \App\Models\Prilozeniye_21::class,
        'prilozeniye_22' => \App\Models\Prilozeniye_22::class,
        'prilozeniye_23' => \App\Models\Prilozeniye_23::class,
        'prilozeniye_24' => \App\Models\Prilozeniye_24::class,
        'prilozeniye_26' => \App\Models\Prilozeniye_26::class,
        'prilozeniye_27' => \App\Models\Prilozeniye_27::class,
        'prilozeniye_28' => \App\Models\Prilozeniye_28::class,
        'prilozeniye_29' => \App\Models\Prilozeniye_29::class,
        'prilozeniye_30' => \App\Models\Prilozeniye_30::class,
        'prilozeniye_31' => \App\Models\Prilozeniye_31::class,
        'prilozeniye_32' => \App\Models\Prilozeniye_32::class,
        'prilozeniye_67' => \App\Models\Prilozeniye_67::class,
        'prilozeniye_72' => \App\Models\Prilozeniye_72::class,
        'prilozeniye_73' => \App\Models\Prilozeniye_73::class,
        'prilozeniye_74' => \App\Models\Prilozeniye_74::class,
        'prilozeniye_75' => \App\Models\Prilozeniye_75::class,
        'prilozeniye_gotovn_podmostei' => \App\Models\PrilozeniyeGotovnPodmostei::class,
        'prilozeniye_gotovn_lift' => \App\Models\PrilozeniyeGotovnLift::class,


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
        $fieldsToTry = ['number_acts', 'number_act', 'act_number'];
        $numberField = null;
        foreach ($fieldsToTry as $field) {
            if (\Schema::hasColumn((new $modelClass)->getTable(), $field)) {
                $numberField = $field;
                break;
            }
        }
        // Создаём директорию: /storage/app/pdf_outputs/{passport_id}/{type}/{act_number}/
        $actDirPath = storage_path("app/pdf_outputs/{$passport->id}/{$type}/{$act->$numberField}");
        if (!file_exists($actDirPath)) {
            mkdir($actDirPath, 0775, true);
        }

        $pdfPath = "$actDirPath/{$act->$numberField}.pdf";
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
