<?php
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

        auth()->user()->update([
            'bin' => $request->bin,
            'organization_name' => $request->organization_name,
            'role' => $request->role,
            'is_profile_complete' => true,
        ]);

        return redirect()->route('projects.index');
    }
}
