<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'profile_image_file' => 'nullable|image|max:1024',
        ]);

        $data = $request->only('name', 'email', 'phone');

        if ($request->hasFile('profile_image_file')) {
            // Delete old image if exists
            if ($user->profile_image && !str_contains($user->profile_image, 'unsplash')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $user->profile_image));
            }
            
            $path = $request->file('profile_image_file')->store('profiles', 'public');
            $data['profile_image'] = '/storage/' . $path;
        }

        $user->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function destroy(Request $request)
    {
        $request->validate(['password' => 'required|current_password']);

        $user = $request->user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Account deleted.');
    }
}