<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'current_password' => 'required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cv_file' => 'nullable|mimes:pdf,doc,docx|max:5120' // 5MB max
        ]);

        // Update basic info
        $user->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
        ]);

        // Update photo if provided
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            
            $photo = $request->file('photo')->store('profile-photos', 'public');
            $user->update(['photo' => $photo]);
        }

        // Update CV if provided
        if ($request->hasFile('cv_file')) {
            // Delete old CV if exists
            if ($user->cv_file) {
                Storage::disk('public')->delete($user->cv_file);
            }
            
            $cv = $request->file('cv_file')->store('cv-files', 'public');
            $user->update(['cv_file' => $cv]);
        }

        // Update password if provided
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }

            if ($request->filled('new_password')) {
                $user->update([
                    'password' => Hash::make($validated['new_password'])
                ]);
            }
        }

        return back()->with('success', 'Profile updated successfully!');
    }
}