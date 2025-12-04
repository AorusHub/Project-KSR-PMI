<?php
// filepath: [StokDarahController.php](http://_vscodecontentref_/0)

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokDarah;
use Illuminate\Support\Facades\Auth;

class StokDarahController extends Controller
{
    /**
     * ✅ Tampilkan halaman stok darah (Admin & Staf only)
     */
    public function index(Request $request)
    {
        // Authorization: Hanya admin dan staf yang bisa akses
        if (!in_array(Auth::user()->role, ['admin', 'staf'])) {
            abort(403, 'Unauthorized action.');
        }

        // Get filter jenis darah
        $filterJenis = $request->get('jenis_darah', 'Semua');

        // Base query
        $query = StokDarah::query();

        // Apply filter jika bukan "Semua"
        if ($filterJenis !== 'Semua') {
            $query->where('jenis_darah', $filterJenis);
        }

        // Data stok darah per golongan
        $stokDarah = [
            'A+' => (clone $query)->where('golongan_darah', 'A+')->sum('jumlah_kantong') ?? 0,
            'B+' => (clone $query)->where('golongan_darah', 'B+')->sum('jumlah_kantong') ?? 0,
            'O+' => (clone $query)->where('golongan_darah', 'O+')->sum('jumlah_kantong') ?? 0,
            'AB+' => (clone $query)->where('golongan_darah', 'AB+')->sum('jumlah_kantong') ?? 0,
            'A-' => (clone $query)->where('golongan_darah', 'A-')->sum('jumlah_kantong') ?? 0,
            'B-' => (clone $query)->where('golongan_darah', 'B-')->sum('jumlah_kantong') ?? 0,
            'O-' => (clone $query)->where('golongan_darah', 'O-')->sum('jumlah_kantong') ?? 0,
            'AB-' => (clone $query)->where('golongan_darah', 'AB-')->sum('jumlah_kantong') ?? 0,
        ];

        // Hitung perubahan bulan ini
        $perubahanBulanIni = [
            'A+' => $this->hitungPerubahan('A+', $filterJenis),
            'B+' => $this->hitungPerubahan('B+', $filterJenis),
            'O+' => $this->hitungPerubahan('O+', $filterJenis),
            'AB+' => $this->hitungPerubahan('AB+', $filterJenis),
            'A-' => $this->hitungPerubahan('A-', $filterJenis),
            'B-' => $this->hitungPerubahan('B-', $filterJenis),
            'O-' => $this->hitungPerubahan('O-', $filterJenis),
            'AB-' => $this->hitungPerubahan('AB-', $filterJenis),
        ];

        return view('dashboard.dev.stok-darah', compact('stokDarah', 'perubahanBulanIni', 'filterJenis'));
    }

    /**
     * Hitung perubahan stok bulan ini
     */
    private function hitungPerubahan($golongan, $filterJenis = 'Semua')
    {
        $query = StokDarah::where('golongan_darah', $golongan)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);

        if ($filterJenis !== 'Semua') {
            $query->where('jenis_darah', $filterJenis);
        }

        return $query->sum('jumlah_kantong') ?? 0;
    }

    /**
     * ✅ Update stok darah (Admin & Staf only)
     */
    public function update(Request $request)
    {
        // Authorization
        if (!in_array(Auth::user()->role, ['admin', 'staf'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        $validated = $request->validate([
            'golongan_darah' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'jenis_darah' => 'required|in:Darah Lengkap (Whole Blood),Packed Red Cells (PRC),Trombosit (TC),Plasma',
            'jumlah_kantong' => 'required|integer',
            'keterangan' => 'nullable|string'
        ]);

        try {
            StokDarah::create([
                'golongan_darah' => $validated['golongan_darah'],
                'jenis_darah' => $validated['jenis_darah'],
                'jumlah_kantong' => $validated['jumlah_kantong'],
                'keterangan' => $validated['keterangan'] ?? 'Update manual',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Stok darah berhasil diupdate!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}