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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user_as' => 'required|in:Penyedia Jasa,Pengguna Jasa',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile_number' => 'required|string|max:15',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'required|string|min:8'
        ]);

        try {
            $photoPath = $request->file('photo')->store('profile-photos', 'public');

            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'role' => $validated['user_as'],
                'email' => $validated['email'],
                'mobile_number' => $validated['mobile_number'],
                'photo' => $photoPath,
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