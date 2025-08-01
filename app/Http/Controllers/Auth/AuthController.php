<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email', // Лучше добавить проверку email
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Обновляем сессию для защиты от фиксации
            $request->session()->regenerate();
            return redirect()->intended('dashboard')
                ->with('success', 'Вы успешно вошли!');
        }
        return redirect()->route('login')->withErrors([
            'email' => 'Неверные данные для входа',
        ]);
    }

    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed', // Для подтверждения пароля
        ]);

        $data = $request->all();
        $user = $this->create($data);
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('complete-profile');
    }


    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors(['access' => 'У вас нет доступа']);
        }

        $monthlyActs = Cache::remember('monthly_acts_' . date('Y'), now()->addMinutes(10), function () {
            $actTables = [
                'hidden_works',
                'intermediate_accepts',
                'prilozeniye_21s',
                'prilozeniye_22s',
                'prilozeniye_23s',
                'prilozeniye_24s',
                'prilozeniye_26s',
                'prilozeniye_27s',
                'prilozeniye_28s',
                'prilozeniye_29s',
                'prilozeniye_30s',
                'prilozeniye_31s',
                'prilozeniye_32s',
                'prilozeniye_67s',
                'prilozeniye_72s',
                'prilozeniye_73s',
                'prilozeniye_74s',
                'prilozeniye_75s',
                'prilozeniye_gotovn_podmosteis',
                'prilozeniye_gotovn_lifts',
            ];

            $year = date('Y');
            $queries = [];

            foreach ($actTables as $table) {
                // Проверка: существует ли таблица и колонка created_at
                if (Schema::hasTable($table) && Schema::hasColumn($table, 'created_at')) {
                    $queries[] = "SELECT MONTH(created_at) as month FROM `{$table}` WHERE YEAR(created_at) = {$year}";
                }
            }

            if (empty($queries)) {
                return array_fill(0, 12, 0); // Вернуть массив из 12 нулей, если нет подходящих таблиц
            }

            $unionQuery = implode(' UNION ALL ', $queries);

            $results = DB::select("
            SELECT month, COUNT(*) as count
            FROM ({$unionQuery}) as all_acts
            GROUP BY month
        ");

            $monthlyActs = array_fill(0, 12, 0); // Янв = 0, ..., Дек = 11
            foreach ($results as $row) {
                $monthlyActs[$row->month - 1] = $row->count;
            }
            return $monthlyActs;
        });

        return view('dashboard', [
            'monthlyActs' => $monthlyActs,
        ]);
    }




    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
