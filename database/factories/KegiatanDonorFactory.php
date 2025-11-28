<?php

namespace Database\Factories;

use App\Models\KegiatanDonor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class KegiatanDonorFactory extends Factory
{
    protected $model = KegiatanDonor::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nama_kegiatan' => 'Donor Darah ' . $this->faker->words(3, true),
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '15:00',
            'tanggal' => $this->faker->dateTimeBetween('+1 week', '+3 months')->format('Y-m-d'),
            'lokasi' => $this->faker->address(),
            'deskripsi' => $this->faker->paragraph(3),
            'target_donor' => $this->faker->numberBetween(50, 200),
            'status' => $this->faker->randomElement(['Completed', 'Planned', 'Ongoing', 'Cancelled']),
            'created_by' => User::factory(),
        ];
    }

    /**
     * Indicate that the kegiatan is planned.
     */
    public function planned(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Planned',
            'tanggal' => $this->faker->dateTimeBetween('+1 week', '+3 months')->format('Y-m-d'),
        ]);
    }

    /**
     * Indicate that the kegiatan is ongoing.
     */
    public function ongoing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Ongoing',
            'tanggal' => now()->format('Y-m-d'),
        ]);
    }

    /**
     * Indicate that the kegiatan is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Completed',
            'tanggal' => $this->faker->dateTimeBetween('-3 months', '-1 week')->format('Y-m-d'),
        ]);
    }

    /**
     * Indicate that the kegiatan is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Cancelled',
        ]);
    }

    /**
     * Indicate that the kegiatan is for today.
     */
    public function today(): static
    {
        return $this->state(fn (array $attributes) => [
            'tanggal' => now()->format('Y-m-d'),
            'status' => 'Ongoing',
        ]);
    }

    /**
     * Indicate that the kegiatan is in the past.
     */
    public function past(): static
    {
        return $this->state(fn (array $attributes) => [
            'tanggal' => $this->faker->dateTimeBetween('-6 months', '-1 day')->format('Y-m-d'),
            'status' => 'Completed',
        ]);
    }

    /**
     * Indicate that the kegiatan is in the future.
     */
    public function future(): static
    {
        return $this->state(fn (array $attributes) => [
            'tanggal' => $this->faker->dateTimeBetween('+1 day', '+6 months')->format('Y-m-d'),
            'status' => 'Planned',
        ]);
    }

    /**
     * Create a kegiatan with specific target.
     */
    public function withTarget(int $target): static
    {
        return $this->state(fn (array $attributes) => [
            'target_donor' => $target,
        ]);
    }

    /**
     * Create a kegiatan with specific location.
     */
    public function atLocation(string $location): static
    {
        return $this->state(fn (array $attributes) => [
            'lokasi' => $location,
        ]);
    }

    /**
     * Create a kegiatan created by admin.
     */
    public function createdByAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'created_by' => User::factory()->admin(),
        ]);
    }

    /**
     * Create a kegiatan created by staff.
     */
    public function createdByStaf(): static
    {
        return $this->state(fn (array $attributes) => [
            'created_by' => User::factory()->staf(),
        ]);
    }
}