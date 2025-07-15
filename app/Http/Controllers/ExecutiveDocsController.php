<?php

namespace App\Http\Controllers;

class ExecutiveDocsController extends Controller
{
    public function store(Request $request)
    {
        // Логика сохранения данных акта выполненных работ
        // Например: ExecutiveDoc::create($request->all());
        return redirect()->back()->with('success', 'Акт успешно сохранён!');
    }
}
