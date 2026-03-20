<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserPasswordController extends Controller
{
    
    public function edit()
    {
        return view('user.account-password');
    }

    
    public function update(Request $request)
    {
        
        $request->validate(
            [
                'current_password' => ['required'],
                'new_password'     => ['required', 'string', 'min:8', 'contains_number', 'contains_uppercase', 'confirmed'],
            ],
            [
                'new_password.min' => 'Password must be at least 8 characters.',
                'new_password.contains_number' => 'Password must include at least 1 number.',
                'new_password.contains_uppercase' => 'Password must include at least 1 capital letter.',
                'new_password.confirmed' => 'Password confirmation does not match.',
            ]
        );

        $user = Auth::user();

        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with(['error' => 'old passwords do not match']);
        }
        
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('status', 'Password changed successfully!');
    }
}