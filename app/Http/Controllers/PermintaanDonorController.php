<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermintaanDonor;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PermintaanDonorController extends Controller
{
    /**
     * Tampilkan formulir permintaan darah
     */
    public function create()
    {
        return view('dashboard.pendonor.formulir-permintaan-donor-darah');
    }

    /**
     * Simpan data permintaan darah
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'golongan_darah' => 'required|string|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'riwayat_penyakit' => 'nullable|string|max:1000',
            'tempat_dirawat' => 'required|string|max:255',
            'jenis_permintaan' => 'required|string|in:darah_lengkap,prc,trombosit,plasma',
            'jumlah_kantong' => 'required|integer|min:1|max:10',
            'tingkat_urgensi' => 'required|string|in:normal,mendesak,darurat',
            'nama_kontak' => 'required|string|max:255',
            'nomor_hp' => 'required|string|regex:/^[0-9]{10,15}$/',
            'hubungan_pasien' => 'required|string|max:100',
        ], [
            // Pesan error kustom
            'nama_pasien.required' => 'Nama pasien wajib diisi',
            'golongan_darah.required' => 'Golongan darah wajib dipilih',
            'golongan_darah.in' => 'Golongan darah tidak valid',
            'tempat_dirawat.required' => 'Tempat dirawat wajib diisi',
            'jenis_permintaan.required' => 'Jenis permintaan wajib dipilih',
            'jumlah_kantong.required' => 'Jumlah kantong wajib diisi',
            'jumlah_kantong.min' => 'Jumlah kantong minimal 1',
            'jumlah_kantong.max' => 'Jumlah kantong maksimal 10',
            'nama_kontak.required' => 'Nama kontak wajib diisi',
            'nomor_hp.required' => 'Nomor HP wajib diisi',
            'nomor_hp.regex' => 'Format nomor HP tidak valid (10-15 digit)',
            'hubungan_pasien.required' => 'Hubungan dengan pasien wajib diisi',
        ]);

        try {
            // ✅ PERBAIKAN: Generate nomor pelacakan yang lebih unik
            do {
                $nomorPelacakan = 'REQ' . now()->format('ymd') . strtoupper(Str::random(6));
            } while (PermintaanDonor::where('nomor_pelacakan', $nomorPelacakan)->exists());

            // Simpan data ke database
            $permintaan = PermintaanDonor::create([
                'user_id' => auth()->id(),
                'nomor_pelacakan' => $nomorPelacakan,
                'tanggal_hari' => Carbon::now()->format('Y-m-d'),
                'nama_pasien' => $validated['nama_pasien'],
                'gol_darah' => $validated['golongan_darah'],
                'riwayat_penyakit' => $validated['riwayat_penyakit'],
                'tempat_dirawat' => $validated['tempat_dirawat'],
                'jenis_permintaan' => $validated['jenis_permintaan'],
                'jumlah_kantong' => $validated['jumlah_kantong'],
                'tingkat_urgensi' => $validated['tingkat_urgensi'],
                'nama_kontak' => $validated['nama_kontak'],
                'nomor_hp' => $validated['nomor_hp'],
                'hubungan_pasien' => $validated['hubungan_pasien'],
                'status_permintaan' => 'Pending',
            ]);

            // Redirect ke halaman sukses
            return redirect()->route('pendonor.permintaan-darah.sukses', $permintaan->permintaan_id)
                ->with('success', 'Permintaan donor darah berhasil dikirim!');

        } catch (\Exception $e) {
            // ✅ PERBAIKAN: Log error untuk debugging
            \Log::error('Error menyimpan permintaan donor: ' . $e->getMessage());
    
            // Handle error
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.']);
        }
    }

    /**
     * Tampilkan halaman sukses
     */
    public function success($id)
    {
        // Ambil data permintaan berdasarkan ID dan user yang login
        $permintaan = PermintaanDonor::where('permintaan_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('dashboard.pendonor.permintaan-sukses', compact('permintaan'));
    }
}