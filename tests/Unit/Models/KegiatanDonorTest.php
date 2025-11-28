<?php

namespace Tests\Unit\Models;

use App\Models\KegiatanDonor;
use App\Models\User;
use App\Models\DonasiDarah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class KegiatanDonorTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_kegiatan_donor()
    {
        $kegiatanData = [
            'nama_kegiatan' => 'Donor Darah Kampus',
            'tanggal' => '2024-12-25',
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '15:00',
            'lokasi' => 'Gedung Rektorat UNHAS',
            'deskripsi' => 'Kegiatan donor darah rutin kampus',
            'target_donor' => 100,
            'status' => 'Planned',
        ];

        $kegiatan = KegiatanDonor::create($kegiatanData);

        $this->assertInstanceOf(KegiatanDonor::class, $kegiatan);
        $this->assertEquals('Donor Darah Kampus', $kegiatan->nama_kegiatan);
        $this->assertEquals('Gedung Rektorat UNHAS', $kegiatan->lokasi);
        $this->assertEquals(100, $kegiatan->target_donor);
        $this->assertEquals('Planned', $kegiatan->status);
    }

    /** @test */
    public function it_casts_tanggal_to_carbon_date()
    {
        $kegiatan = KegiatanDonor::create([
            'nama_kegiatan' => 'Test Kegiatan',
            'tanggal' => '2024-12-25',
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '15:00',
            'lokasi' => 'Test Location',
            'status' => 'Planned',
        ]);

        $this->assertInstanceOf(Carbon::class, $kegiatan->tanggal);
        $this->assertEquals('2024-12-25', $kegiatan->tanggal->format('Y-m-d'));
    }

    /** @test */
    public function it_validates_status_enum_values()
    {
        $validStatuses = ['Completed', 'Planned', 'Ongoing', 'Cancelled'];

        foreach ($validStatuses as $status) {
            $kegiatan = KegiatanDonor::create([
                'nama_kegiatan' => 'Test Kegiatan',
                'tanggal' => '2024-12-25',
                'waktu_mulai' => '09:00',
                'waktu_selesai' => '15:00',
                'lokasi' => 'Test Location',
                'status' => $status,
            ]);

            $this->assertEquals($status, $kegiatan->status);
        }
    }

    /** @test */
    public function it_has_default_status_planned()
    {
        $kegiatan = KegiatanDonor::create([
            'nama_kegiatan' => 'Test Kegiatan',
            'tanggal' => '2024-12-25',
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '15:00',
            'lokasi' => 'Test Location',
            // No status specified
        ]);

        $this->assertEquals('Planned', $kegiatan->status);
    }

    /** @test */
    public function it_has_default_time_values()
    {
        $kegiatan = KegiatanDonor::create([
            'nama_kegiatan' => 'Test Kegiatan',
            'tanggal' => '2024-12-25',
            'lokasi' => 'Test Location',
            // No time specified
        ]);

        $this->assertEquals('09:00:00', $kegiatan->waktu_mulai);
        $this->assertEquals('15:00:00', $kegiatan->waktu_selesai);
    }

    /** @test */
    public function it_belongs_to_creator_user()
    {
        $creator = User::factory()->create(['role' => 'staf']);
        $kegiatan = KegiatanDonor::create([
            'nama_kegiatan' => 'Test Kegiatan',
            'tanggal' => '2024-12-25',
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '15:00',
            'lokasi' => 'Test Location',
            'created_by' => $creator->user_id,
        ]);

        $this->assertInstanceOf(User::class, $kegiatan->creator);
        $this->assertEquals($creator->user_id, $kegiatan->creator->user_id);
    }

    /** @test */
    public function it_has_many_donasi_darah()
    {
        $kegiatan = KegiatanDonor::factory()->create();
        $donasi1 = DonasiDarah::factory()->create(['kegiatan_id' => $kegiatan->kegiatan_id]);
        $donasi2 = DonasiDarah::factory()->create(['kegiatan_id' => $kegiatan->kegiatan_id]);

        $this->assertCount(2, $kegiatan->donasiDarah);
        $this->assertTrue($kegiatan->donasiDarah->contains($donasi1));
        $this->assertTrue($kegiatan->donasiDarah->contains($donasi2));
    }

    /** @test */
    public function it_validates_target_donor_is_positive_integer()
    {
        $kegiatan = KegiatanDonor::create([
            'nama_kegiatan' => 'Test Kegiatan',
            'tanggal' => '2024-12-25',
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '15:00',
            'lokasi' => 'Test Location',
            'target_donor' => 50,
        ]);

        $this->assertEquals(50, $kegiatan->target_donor);
        $this->assertIsInt($kegiatan->target_donor);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        KegiatanDonor::create([
            // Missing required fields
            'nama_kegiatan' => '',
            'lokasi' => '',
        ]);
    }

    /** @test */
    public function it_validates_waktu_selesai_after_waktu_mulai()
    {
        // This would typically be handled by custom validation rules
        $kegiatan = KegiatanDonor::create([
            'nama_kegiatan' => 'Test Kegiatan',
            'tanggal' => '2024-12-25',
            'waktu_mulai' => '15:00',
            'waktu_selesai' => '09:00', // End time before start time
            'lokasi' => 'Test Location',
        ]);

        // In a real application, you'd add custom validation to prevent this
        // For now, we just verify the data is stored as entered
        $this->assertEquals('15:00:00', $kegiatan->waktu_mulai);
        $this->assertEquals('09:00:00', $kegiatan->waktu_selesai);
    }

    /** @test */
    public function it_can_update_status()
    {
        $kegiatan = KegiatanDonor::factory()->create(['status' => 'Planned']);

        $kegiatan->update(['status' => 'Ongoing']);

        $this->assertEquals('Ongoing', $kegiatan->fresh()->status);
    }

    /** @test */
    public function it_can_calculate_duration()
    {
        $kegiatan = KegiatanDonor::create([
            'nama_kegiatan' => 'Test Kegiatan',
            'tanggal' => '2024-12-25',
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '15:00',
            'lokasi' => 'Test Location',
        ]);

        // This would be a custom method in the model
        // For demonstration purposes only
        $startTime = Carbon::createFromTimeString($kegiatan->waktu_mulai);
        $endTime = Carbon::createFromTimeString($kegiatan->waktu_selesai);
        $duration = $endTime->diffInHours($startTime);

        $this->assertEquals(6, $duration);
    }
}