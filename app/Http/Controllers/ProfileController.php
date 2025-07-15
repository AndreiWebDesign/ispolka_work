<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
