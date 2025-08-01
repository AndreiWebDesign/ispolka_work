<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Passport;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ProjectInvitation;

class ReportController extends Controller
{
    public function index(Passport $passport)
    {
        $actTemplates = config('act_templates');
        $hiddenWorkHeadings = config('hidden_work_headings');

        $groupedActs = [];

        // Список уже существующих таблиц
        $existingActs = [];

        foreach ($actTemplates as $key => $template) {
            if ($key === 'hidden_works') continue;

            $table = $key . 's'; // convention

            // Проверка: есть ли документы с passport_id
            $exists = DB::table($table)->where('passport_id', $passport->id)->exists();

            $group = $template['group'] ?? 'Прочие акты';
            $label = $template['label'] ?? $key;

            $groupedActs[$group][$key] = [
                'label' => $label,
                'is_hidden' => false,
                'exists' => $exists,
            ];

            if ($exists) $existingActs[] = $table;
        }

        foreach ($hiddenWorkHeadings as $key => $item) {
            $table = 'hidden_works';

            $exists = DB::table($table)->where('passport_id', $passport->id)->where('type', $key)->exists();

            $group = $item['group'] ?? 'Прочие скрытые работы';
            $label = $item['text'] ?? $key;

            $groupedActs[$group][$key] = [
                'label' => $label,
                'is_hidden' => true,
                'exists' => $exists,
            ];

            if ($exists) $existingActs[] = $table;
        }

        uksort($groupedActs, 'strnatcasecmp');
        foreach ($groupedActs as &$acts) {
            uasort($acts, fn($a, $b) => strnatcasecmp($a['label'], $b['label']));
        }

        $totalDocuments = array_sum(array_map(fn($group) => count(array_filter($group, fn($a) => $a['exists'])), $groupedActs));

        return view('report.index', compact('passport', 'groupedActs', 'totalDocuments'));
    }

    public function select()
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
        return view('report.select', compact('passports'));

    }
}
