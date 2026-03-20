<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TC3LoginAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_with_valid_then_invalid_password_behaves_correctly(): void
    {
        $user = User::factory()->create([
            'mobile' => '07000000003',
            'email' => 'tc3@example.com',
            'password' => Hash::make('ValidPass1'),
        ]);

        $validLogin = $this->post('/login', [
            'email' => $user->email,
            'password' => 'ValidPass1',
        ]);
        $validLogin->assertRedirect('/');
        $this->assertAuthenticatedAs($user);

        $this->post('/logout');
        $this->assertGuest();

        $invalidLogin = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'WrongPass1',
        ]);
        $invalidLogin->assertRedirect('/login');
        $invalidLogin->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }
}
