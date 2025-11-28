<?php

namespace Database\Factories;

use App\Models\Pendonor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PendonorFactory extends Factory
{
    protected $model = Pendonor::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->pendonor(),
            'nama' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'no_hp' => $this->faker->phoneNumber(),
            'NIK' => $this->faker->numerify('##############'), // 16 digit NIK
            'tanggal_lahir' => $this->faker->dateTimeBetween('-60 years', '-17 years')->format('Y-m-d'),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'golongan_darah' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'alamat' => $this->faker->address(),
        ];
    }

    /**
     * Indicate that the pendonor is male.
     */
    public function male(): static
    {
        return $this->state(fn (array $attributes) => [
            'jenis_kelamin' => 'L',
            'nama' => $this->faker->name('male'),
        ]);
    }

    /**
     * Indicate that the pendonor is female.
     */
    public function female(): static
    {
        return $this->state(fn (array $attributes) => [
            'jenis_kelamin' => 'P',
            'nama' => $this->faker->name('female'),
        ]);
    }

    /**
     * Create a pendonor with specific blood type.
     */
    public function withBloodType(string $bloodType): static
    {
        return $this->state(fn (array $attributes) => [
            'golongan_darah' => $bloodType,
        ]);
    }

    /**
     * Create a young pendonor (17-25 years old).
     */
    public function young(): static
    {
        return $this->state(fn (array $attributes) => [
            'tanggal_lahir' => $this->faker->dateTimeBetween('-25 years', '-17 years')->format('Y-m-d'),
        ]);
    }

    /**
     * Create a middle-aged pendonor (26-45 years old).
     */
    public function middleAged(): static
    {
        return $this->state(fn (array $attributes) => [
            'tanggal_lahir' => $this->faker->dateTimeBetween('-45 years', '-26 years')->format('Y-m-d'),
        ]);
    }

    /**
     * Create an older pendonor (46-60 years old).
     */
    public function older(): static
    {
        return $this->state(fn (array $attributes) => [
            'tanggal_lahir' => $this->faker->dateTimeBetween('-60 years', '-46 years')->format('Y-m-d'),
        ]);
    }

    /**
     * Create a pendonor with universal donor blood type (O-).
     */
    public function universalDonor(): static
    {
        return $this->state(fn (array $attributes) => [
            'golongan_darah' => 'O-',
        ]);
    }

    /**
     * Create a pendonor with universal recipient blood type (AB+).
     */
    public function universalRecipient(): static
    {
        return $this->state(fn (array $attributes) => [
            'golongan_darah' => 'AB+',
        ]);
    }

    /**
     * Create a pendonor from Makassar area.
     */
    public function fromMakassar(): static
    {
        return $this->state(fn (array $attributes) => [
            'alamat' => 'Jl. ' . $this->faker->streetName . ', Makassar, Sulawesi Selatan',
        ]);
    }

    /**
     * Create a pendonor with specific age.
     */
    public function age(int $age): static
    {
        return $this->state(fn (array $attributes) => [
            'tanggal_lahir' => now()->subYears($age)->format('Y-m-d'),
        ]);
    }

    /**
     * Create a pendonor with existing user.
     */
    public function withUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->user_id,
            'nama' => $user->nama,
            'email' => $user->email,
        ]);
    }
}