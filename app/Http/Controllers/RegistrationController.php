<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'user_as' => 'required|in:Penyedia Jasa,Pengguna Jasa',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile_number' => 'required|numeric|digits_between:10,15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|string|min:8'
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('profile-photos', 'public');
        } else {
            $photo = null;
        }

        try {
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'role' => $validated['user_as'],
                'email' => $validated['email'],
                'mobile_number' => $validated['mobile_number'], 
                'photo' => $photo,
                'password' => Hash::make($validated['password'])
            ]);

            auth()->login($user);

            return redirect()->route('home')->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Registration failed. Please try again.'])
                        ->withInput($request->except('password'));
        }
    }

    public function showSuccessPage()
    {
        return view('registration-success');
    }
}