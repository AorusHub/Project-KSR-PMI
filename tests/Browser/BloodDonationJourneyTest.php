<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\KegiatanDonor;
use App\Models\Pendonor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\TestCase as DuskTestCase;
use Laravel\Dusk\Browser;

class BloodDonationJourneyTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $pendonorUser;
    protected $pendonor;

    public function setUp(): void
    {
        parent::setUp();

        $this->pendonorUser = User::factory()->create([
            'role' => 'pendonor',
            'is_verified' => true,
        ]);

        $this->pendonor = Pendonor::factory()->create([
            'user_id' => $this->pendonorUser->user_id,
        ]);
    }

    /** @test */
    public function user_can_complete_full_blood_donation_journey()
    {
        $kegiatan = KegiatanDonor::factory()->create([
            'nama_kegiatan' => 'Donor Darah Test Event',
            'tanggal' => now()->addWeek()->format('Y-m-d'),
            'status' => 'Planned',
        ]);

        $this->browse(function (Browser $browser) use ($kegiatan) {
            $browser->loginAs($this->pendonorUser)
                    // Step 1: Discover events
                    ->visit('/kegiatan')
                    ->assertSee('Donor Darah Test Event')
                    
                    // Step 2: View event details
                    ->click('@kegiatan-' . $kegiatan->kegiatan_id)
                    ->assertSee('Detail Kegiatan')
                    ->assertSee('Donor Darah Test Event')
                    ->assertSee('Daftar Sekarang')
                    
                    // Step 3: Register for event
                    ->click('@daftar-button')
                    ->waitFor('@success-message')
                    ->assertSee('Pendaftaran berhasil!')
                    
                    // Step 4: Check registration in dashboard
                    ->visit('/dashboard/pendonor')
                    ->assertSee('Kegiatan yang Diikuti')
                    ->assertSee('Donor Darah Test Event')
                    ->assertSee('Terdaftar')
                    
                    // Step 5: View donation history
                    ->click('@riwayat-donor-link')
                    ->assertSee('Riwayat Donor Darah')
                    ->assertSee('Donor Darah Test Event');
        });
    }

    /** @test */
    public function user_cannot_register_for_same_event_twice()
    {
        $kegiatan = KegiatanDonor::factory()->create([
            'nama_kegiatan' => 'Duplicate Registration Test',
            'tanggal' => now()->addWeek()->format('Y-m-d'),
            'status' => 'Planned',
        ]);

        $this->browse(function (Browser $browser) use ($kegiatan) {
            $browser->loginAs($this->pendonorUser)
                    ->visit("/kegiatan/{$kegiatan->kegiatan_id}")
                    
                    // First registration
                    ->click('@daftar-button')
                    ->waitFor('@success-message')
                    ->assertSee('Pendaftaran berhasil!')
                    
                    // Try to register again
                    ->refresh()
                    ->assertDontSee('Daftar Sekarang')
                    ->assertSee('Sudah Terdaftar');
        });
    }

    /** @test */
    public function user_can_check_eligibility_before_donation()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->pendonorUser)
                    ->visit('/dashboard/pendonor')
                    ->click('@cek-kelayakan-link')
                    ->assertSee('Cek Kelayakan Donor')
                    
                    // Fill eligibility form
                    ->type('@berat-badan', '60')
                    ->type('@tekanan-darah-sistol', '120')
                    ->type('@tekanan-darah-diastol', '80')
                    ->type('@hemoglobin', '13.5')
                    ->select('@kondisi-kesehatan', 'sehat')
                    ->radio('@sedang-hamil', 'tidak')
                    ->radio('@menyusui', 'tidak')
                    ->radio('@donor-terakhir', 'lebih-8-minggu')
                    
                    ->click('@submit-kelayakan')
                    ->waitFor('@result-message')
                    ->assertSee('Anda memenuhi syarat untuk donor darah');
        });
    }

    /** @test */
    public function user_receives_ineligibility_message_when_not_qualified()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->pendonorUser)
                    ->visit('/dashboard/pendonor/cek-kelayakan-donor')
                    
                    // Fill form with disqualifying information
                    ->type('@berat-badan', '40') // Below minimum weight
                    ->type('@tekanan-darah-sistol', '180')
                    ->type('@tekanan-darah-diastol', '110')
                    ->type('@hemoglobin', '10.5')
                    ->select('@kondisi-kesehatan', 'sakit')
                    
                    ->click('@submit-kelayakan')
                    ->waitFor('@result-message')
                    ->assertSee('Maaf, Anda belum memenuhi syarat')
                    ->assertSee('Berat badan minimal 45kg');
        });
    }

    /** @test */
    public function user_can_create_blood_request()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->pendonorUser)
                    ->visit('/dashboard/pendonor')
                    ->click('@permintaan-darah-link')
                    ->assertSee('Formulir Permintaan Donor Darah')
                    
                    // Fill blood request form
                    ->type('@nama-pasien', 'John Doe Patient')
                    ->select('@golongan-darah', 'A+')
                    ->type('@tempat-dirawat', 'RS Test Hospital')
                    ->select('@jenis-permintaan', 'Operasi')
                    ->type('@jumlah-kantong', '2')
                    ->select('@tingkat-urgensi', 'Mendesak')
                    ->type('@nama-kontak', 'Jane Doe')
                    ->type('@nomor-kontak', '081234567890')
                    ->type('@hubungan-pasien', 'Istri')
                    ->textarea('@riwayat-penyakit', 'Tidak ada riwayat penyakit khusus')
                    
                    ->click('@submit-permintaan')
                    ->waitFor('@success-redirect')
                    ->assertPathIs('/permintaan-darah/*/sukses')
                    ->assertSee('Permintaan Berhasil Dikirim')
                    ->assertSee('Nomor Pelacakan');
        });
    }

    /** @test */
    public function user_can_track_blood_request_status()
    {
        // Create a blood request first
        $permintaan = \App\Models\PermintaanDonor::factory()->create([
            'user_id' => $this->pendonorUser->user_id,
            'nomor_pelacakan' => 'PMI-TEST-12345',
            'status_permintaan' => 'Pending',
        ]);

        $this->browse(function (Browser $browser) use ($permintaan) {
            $browser->loginAs($this->pendonorUser)
                    ->visit('/dashboard/pendonor')
                    ->assertSee('Permintaan Darah Aktif')
                    ->assertSee('PMI-TEST-12345')
                    ->assertSee('Pending')
                    
                    ->click('@track-permintaan-' . $permintaan->permintaan_id)
                    ->assertSee('Detail Permintaan')
                    ->assertSee('PMI-TEST-12345')
                    ->assertSee('Status: Pending');
        });
    }

    /** @test */
    public function user_receives_notification_on_status_updates()
    {
        $kegiatan = KegiatanDonor::factory()->create([
            'nama_kegiatan' => 'Notification Test Event',
            'tanggal' => now()->addWeek()->format('Y-m-d'),
        ]);

        $this->browse(function (Browser $browser) use ($kegiatan) {
            $browser->loginAs($this->pendonorUser)
                    ->visit("/kegiatan/{$kegiatan->kegiatan_id}")
                    ->click('@daftar-button')
                    ->waitFor('@success-message')
                    
                    // Check notifications
                    ->click('@notification-bell')
                    ->waitFor('@notification-dropdown')
                    ->assertSee('Pendaftaran berhasil')
                    ->assertSee('Notification Test Event');
        });
    }

    /** @test */
    public function user_can_view_donation_certificate()
    {
        // Create a completed donation
        $kegiatan = KegiatanDonor::factory()->create(['status' => 'Completed']);
        $donasi = \App\Models\DonasiDarah::factory()->create([
            'pendonor_id' => $this->pendonor->pendonor_id,
            'kegiatan_id' => $kegiatan->kegiatan_id,
            'status_donasi' => 'Berhasil',
        ]);

        $this->browse(function (Browser $browser) use ($donasi) {
            $browser->loginAs($this->pendonorUser)
                    ->visit('/dashboard/pendonor/riwayat-donor')
                    ->assertSee('Riwayat Donor Darah')
                    ->assertSee('Berhasil')
                    
                    ->click('@download-certificate-' . $donasi->donasi_id)
                    ->assertSee('Sertifikat Donor Darah')
                    ->assertSee('KSR PMI UNHAS')
                    ->assertSee($this->pendonor->nama);
        });
    }

    /** @test */
    public function user_can_cancel_registration_before_event()
    {
        $kegiatan = KegiatanDonor::factory()->create([
            'nama_kegiatan' => 'Cancellation Test Event',
            'tanggal' => now()->addWeek()->format('Y-m-d'),
        ]);

        $this->browse(function (Browser $browser) use ($kegiatan) {
            $browser->loginAs($this->pendonorUser)
                    ->visit("/kegiatan/{$kegiatan->kegiatan_id}")
                    ->click('@daftar-button')
                    ->waitFor('@success-message')
                    
                    // Go to dashboard and cancel
                    ->visit('/dashboard/pendonor')
                    ->click('@cancel-registration-' . $kegiatan->kegiatan_id)
                    ->acceptDialog()
                    ->waitFor('@cancellation-success')
                    ->assertSee('Pendaftaran berhasil dibatalkan')
                    
                    // Verify can register again
                    ->visit("/kegiatan/{$kegiatan->kegiatan_id}")
                    ->assertSee('Daftar Sekarang');
        });
    }

    /** @test */
    public function user_sees_appropriate_messages_for_past_events()
    {
        $pastKegiatan = KegiatanDonor::factory()->create([
            'nama_kegiatan' => 'Past Event Test',
            'tanggal' => now()->subWeek()->format('Y-m-d'),
            'status' => 'Completed',
        ]);

        $this->browse(function (Browser $browser) use ($pastKegiatan) {
            $browser->loginAs($this->pendonorUser)
                    ->visit("/kegiatan/{$pastKegiatan->kegiatan_id}")
                    ->assertSee('Kegiatan Telah Selesai')
                    ->assertDontSee('Daftar Sekarang');
        });
    }
}