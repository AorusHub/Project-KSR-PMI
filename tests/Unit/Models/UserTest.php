<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Pendonor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        $userData = [
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'role' => 'pendonor',
        ];

        $user = User::create($userData);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->nama);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertEquals('pendonor', $user->role);
    }

    /** @test */
    public function it_hashes_password_when_creating_user()
    {
        $user = User::create([
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'role' => 'pendonor',
        ]);

        $this->assertTrue(Hash::check('password123', $user->password));
    }

    /** @test */
    public function it_can_check_if_user_is_admin()
    {
        $admin = User::create([
            'nama' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $pendonor = User::create([
            'nama' => 'Donor User',
            'email' => 'donor@example.com',
            'password' => 'password123',
            'role' => 'pendonor',
        ]);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($pendonor->isAdmin());
    }

    /** @test */
    public function it_can_check_if_user_is_staf()
    {
        $staf = User::create([
            'nama' => 'Staff User',
            'email' => 'staf@example.com',
            'password' => 'password123',
            'role' => 'staf',
        ]);

        $pendonor = User::create([
            'nama' => 'Donor User',
            'email' => 'donor@example.com',
            'password' => 'password123',
            'role' => 'pendonor',
        ]);

        $this->assertTrue($staf->isStaf());
        $this->assertFalse($pendonor->isStaf());
    }

    /** @test */
    public function it_can_generate_and_validate_otp()
    {
        $user = User::create([
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'role' => 'pendonor',
            'otp_code' => '123456',
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $this->assertEquals('123456', $user->otp_code);
        $this->assertNotNull($user->otp_expires_at);
        $this->assertTrue($user->otp_expires_at->isFuture());
    }

    /** @test */
    public function it_has_relationship_to_pendonor()
    {
        $user = User::factory()->create(['role' => 'pendonor']);
        $pendonor = Pendonor::factory()->create(['user_id' => $user->user_id]);

        $this->assertInstanceOf(Pendonor::class, $user->pendonor);
        $this->assertEquals($pendonor->pendonor_id, $user->pendonor->pendonor_id);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        User::create([
            // Missing required fields
            'nama' => '',
            'email' => '',
        ]);
    }

    /** @test */
    public function it_validates_unique_email()
    {
        User::create([
            'nama' => 'User One',
            'email' => 'duplicate@example.com',
            'password' => 'password123',
            'role' => 'pendonor',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        User::create([
            'nama' => 'User Two',
            'email' => 'duplicate@example.com', // Duplicate email
            'password' => 'password123',
            'role' => 'pendonor',
        ]);
    }

    /** @test */
    public function it_casts_verification_status_to_boolean()
    {
        $user = User::create([
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'role' => 'pendonor',
            'is_verified' => 1,
        ]);

        $this->assertIsBool($user->is_verified);
        $this->assertTrue($user->is_verified);
    }

    /** @test */
    public function it_casts_otp_expires_at_to_datetime()
    {
        $user = User::create([
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'role' => 'pendonor',
            'otp_expires_at' => '2024-12-31 23:59:59',
        ]);

        $this->assertInstanceOf(\Carbon\Carbon::class, $user->otp_expires_at);
    }
}