<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'is_verified' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function user_cannot_login_with_invalid_email()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function user_cannot_login_with_invalid_password()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function unverified_user_cannot_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'is_verified' => false,
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertRedirect('/verify-otp');
    }

    /** @test */
    public function admin_is_redirected_to_admin_dashboard()
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_verified' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard/admin');
    }

    /** @test */
    public function staf_is_redirected_to_staf_dashboard()
    {
        $staf = User::factory()->create([
            'email' => 'staf@example.com',
            'password' => Hash::make('password123'),
            'role' => 'staf',
            'is_verified' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'staf@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard/staf');
    }

    /** @test */
    public function pendonor_is_redirected_to_pendonor_dashboard()
    {
        $pendonor = User::factory()->create([
            'email' => 'pendonor@example.com',
            'password' => Hash::make('password123'),
            'role' => 'pendonor',
            'is_verified' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'pendonor@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard/pendonor');
    }

    /** @test */
    public function login_requires_email()
    {
        $response = $this->post('/login', [
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function login_requires_password()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function email_must_be_valid_email_format()
    {
        $response = $this->post('/login', [
            'email' => 'invalid-email',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function authenticated_user_is_redirected_from_login_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function remember_me_functionality_works()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'is_verified' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'remember' => true,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
        
        // Check if remember token is set
        $this->assertNotNull($user->fresh()->remember_token);
    }

    /** @test */
    public function user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    /** @test */
    public function throttling_prevents_brute_force_attacks()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Attempt multiple failed logins
        for ($i = 0; $i < 6; $i++) {
            $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(429); // Too Many Requests
    }
}