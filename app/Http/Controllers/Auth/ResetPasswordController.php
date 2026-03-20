<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    

    use ResetsPasswords;

    
    protected $redirectTo = '/';

    
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|contains_number|contains_uppercase|confirmed',
        ];
    }

    
    protected function validationErrorMessages()
    {
        return [
            'password.min' => 'Password must be at least 8 characters.',
            'password.contains_number' => 'Password must include at least 1 number.',
            'password.contains_uppercase' => 'Password must include at least 1 capital letter.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }
}
