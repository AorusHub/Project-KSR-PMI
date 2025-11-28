<?php

namespace Tests\Feature\Kegiatan;

use App\Models\User;
use App\Models\KegiatanDonor;
use App\Models\Pendonor;
use App\Models\DonasiDarah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KegiatanManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $staf;
    protected $pendonor;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->staf = User::factory()->create(['role' => 'staf']);
        $this->pendonor = User::factory()->create(['role' => 'pendonor']);
    }

    /** @test */
    public function admin_can_view_kegiatan_management_page()
    {
        $response = $this->actingAs($this->admin)->get('/managemen-kegiatan');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.dev.managemen_kegiatan');
    }

    /** @test */
    public function staf_can_view_kegiatan_management_page()
    {
        $response = $this->actingAs($this->staf)->get('/managemen-kegiatan');

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.dev.managemen_kegiatan');
    }

    /** @test */
    public function pendonor_cannot_access_kegiatan_management_page()
    {
        $response = $this->actingAs($this->pendonor)->get('/managemen-kegiatan');

        $response->assertStatus(403); // Forbidden
    }

    /** @test */
    public function admin_can_create_new_kegiatan()
    {
        $kegiatanData = [
            'nama_kegiatan' => 'Donor Darah Test Event',
            'tanggal' => '2024-12-25',
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '15:00',
            'lokasi' => 'Test Location',
            'deskripsi' => 'Test description for the event',
            'target_donor' => 100,
        ];

        $response = $this->actingAs($this->admin)
            ->post('/managemen-kegiatan', $kegiatanData);

        $response->assertRedirect();
        $this->assertDatabaseHas('kegiatan_donor', [
            'nama_kegiatan' => 'Donor Darah Test Event',
            'lokasi' => 'Test Location',
            'target_donor' => 100,
            'created_by' => $this->admin->user_id,
        ]);
    }

    /** @test */
    public function staf_can_create_new_kegiatan()
    {
        $kegiatanData = [
            'nama_kegiatan' => 'Staff Created Event',
            'tanggal' => '2024-12-25',
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '15:00',
            'lokasi' => 'Staff Location',
            'target_donor' => 50,
        ];

        $response = $this->actingAs($this->staf)
            ->post('/managemen-kegiatan', $kegiatanData);

        $response->assertRedirect();
        $this->assertDatabaseHas('kegiatan_donor', [
            'nama_kegiatan' => 'Staff Created Event',
            'created_by' => $this->staf->user_id,
        ]);
    }

    /** @test */
    public function kegiatan_creation_validates_required_fields()
    {
        $response = $this->actingAs($this->admin)
            ->post('/managemen-kegiatan', []);

        $response->assertSessionHasErrors([
            'nama_kegiatan',
            'tanggal',
            'lokasi',
        ]);
    }

    /** @test */
    public function kegiatan_creation_validates_future_date()
    {
        $kegiatanData = [
            'nama_kegiatan' => 'Past Event',
            'tanggal' => '2020-01-01', // Past date
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '15:00',
            'lokasi' => 'Test Location',
        ];

        $response = $this->actingAs($this->admin)
            ->post('/managemen-kegiatan', $kegiatanData);

        $response->assertSessionHasErrors('tanggal');
    }

    /** @test */
    public function admin_can_update_kegiatan()
    {
        $kegiatan = KegiatanDonor::factory()->create([
            'created_by' => $this->admin->user_id,
        ]);

        $updateData = [
            'nama_kegiatan' => 'Updated Event Name',
            'tanggal' => '2024-12-26',
            'lokasi' => 'Updated Location',
            'target_donor' => 150,
        ];

        $response = $this->actingAs($this->admin)
            ->put("/managemen-kegiatan/{$kegiatan->kegiatan_id}", $updateData);

        $response->assertRedirect();
        $this->assertDatabaseHas('kegiatan_donor', [
            'kegiatan_id' => $kegiatan->kegiatan_id,
            'nama_kegiatan' => 'Updated Event Name',
            'lokasi' => 'Updated Location',
            'target_donor' => 150,
        ]);
    }

    /** @test */
    public function admin_can_delete_kegiatan()
    {
        $kegiatan = KegiatanDonor::factory()->create([
            'created_by' => $this->admin->user_id,
        ]);

        $response = $this->actingAs($this->admin)
            ->delete("/managemen-kegiatan/{$kegiatan->kegiatan_id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('kegiatan_donor', [
            'kegiatan_id' => $kegiatan->kegiatan_id,
        ]);
    }

    /** @test */
    public function cannot_delete_kegiatan_with_existing_donations()
    {
        $kegiatan = KegiatanDonor::factory()->create();
        $pendonor = Pendonor::factory()->create();
        
        // Create a donation record for this kegiatan
        DonasiDarah::factory()->create([
            'kegiatan_id' => $kegiatan->kegiatan_id,
            'pendonor_id' => $pendonor->pendonor_id,
        ]);

        $response = $this->actingAs($this->admin)
            ->delete("/managemen-kegiatan/{$kegiatan->kegiatan_id}");

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('kegiatan_donor', [
            'kegiatan_id' => $kegiatan->kegiatan_id,
        ]);
    }

    /** @test */
    public function admin_can_change_kegiatan_status()
    {
        $kegiatan = KegiatanDonor::factory()->create([
            'status' => 'Planned',
        ]);

        $response = $this->actingAs($this->admin)
            ->patch("/managemen-kegiatan/{$kegiatan->kegiatan_id}/status", [
                'status' => 'Ongoing',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('kegiatan_donor', [
            'kegiatan_id' => $kegiatan->kegiatan_id,
            'status' => 'Ongoing',
        ]);
    }

    /** @test */
    public function can_view_participants_of_kegiatan()
    {
        $kegiatan = KegiatanDonor::factory()->create();
        $pendonor1 = Pendonor::factory()->create();
        $pendonor2 = Pendonor::factory()->create();

        DonasiDarah::factory()->create([
            'kegiatan_id' => $kegiatan->kegiatan_id,
            'pendonor_id' => $pendonor1->pendonor_id,
        ]);
        DonasiDarah::factory()->create([
            'kegiatan_id' => $kegiatan->kegiatan_id,
            'pendonor_id' => $pendonor2->pendonor_id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get("/kegiatan/{$kegiatan->kegiatan_id}/peserta");

        $response->assertStatus(200);
        $response->assertViewHas('kegiatan');
        $response->assertViewHas('participants');
    }

    /** @test */
    public function can_export_kegiatan_participants_report()
    {
        $kegiatan = KegiatanDonor::factory()->create();
        $pendonor = Pendonor::factory()->create();

        DonasiDarah::factory()->create([
            'kegiatan_id' => $kegiatan->kegiatan_id,
            'pendonor_id' => $pendonor->pendonor_id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get("/kegiatan/{$kegiatan->kegiatan_id}/export");

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /** @test */
    public function kegiatan_shows_correct_participant_count()
    {
        $kegiatan = KegiatanDonor::factory()->create();
        $pendonors = Pendonor::factory()->count(3)->create();

        foreach ($pendonors as $pendonor) {
            DonasiDarah::factory()->create([
                'kegiatan_id' => $kegiatan->kegiatan_id,
                'pendonor_id' => $pendonor->pendonor_id,
                'status_donasi' => 'Berhasil',
            ]);
        }

        $response = $this->actingAs($this->admin)
            ->get("/kegiatan/{$kegiatan->kegiatan_id}");

        $response->assertStatus(200);
        $response->assertSee('3 terdaftar'); // Participant count display
    }

    /** @test */
    public function only_planned_and_ongoing_kegiatan_shown_in_public_list()
    {
        KegiatanDonor::factory()->create(['status' => 'Planned']);
        KegiatanDonor::factory()->create(['status' => 'Ongoing']);
        KegiatanDonor::factory()->create(['status' => 'Completed']);
        KegiatanDonor::factory()->create(['status' => 'Cancelled']);

        $response = $this->get('/kegiatan');

        $response->assertStatus(200);
        $response->assertViewHas('kegiatan');
        
        $kegiatan = $response->original->getData()['kegiatan'];
        $this->assertCount(2, $kegiatan);
    }
}