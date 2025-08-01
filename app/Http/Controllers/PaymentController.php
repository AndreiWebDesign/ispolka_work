<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class PaymentController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Предположим, у вас есть модель Payment и связь hasMany
        $payments = $user->payments()->latest()->get();

        return view('payments.index', compact('user', 'payments'));
    }
}
