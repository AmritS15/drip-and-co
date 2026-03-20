<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TC1UserRegistrationValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_valid_details(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'tc1@example.com',
            'mobile' => '07000000001',
            'password' => 'ValidPass1',
            'password_confirmation' => 'ValidPass1',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'tc1@example.com',
            'mobile' => '07000000001',
        ]);
    }
}
