<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthAndAdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_change_requires_uppercase_and_number(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'mobile' => '07111111111',
            'password' => Hash::make('Current1Password'),
        ]);

        $response = $this->actingAs($user)->from('/change-password')->post('/change-password', [
            'current_password' => 'Current1Password',
            'new_password' => 'lowercaseonly',
            'new_password_confirmation' => 'lowercaseonly',
        ]);

        $response->assertRedirect('/change-password');
        $response->assertSessionHasErrors(['new_password']);
    }

    public function test_non_admin_user_is_blocked_from_admin_route(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'mobile' => '07222222222',
            'utype' => 'USR',
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertRedirect('/login');
    }
}
