<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    

    use RegistersUsers;

    
    protected $redirectTo = '/';

    
    public function __construct()
    {
        $this->middleware('guest');
    }

    
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'mobile' => ['required', 'digits:11', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'contains_number', 'contains_uppercase', 'confirmed'],
            ],
            [
                'password.min' => 'Password must be at least 8 characters.',
                'password.contains_number' => 'Password must include at least 1 number.',
                'password.contains_uppercase' => 'Password must include at least 1 capital letter.',
                'password.confirmed' => 'Password confirmation does not match.',
                'mobile.digits' => 'The phone number must be 11 digits.',
                'mobile.unique' => 'This phone number is already registered.',
            ]
        );
    }

    
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
