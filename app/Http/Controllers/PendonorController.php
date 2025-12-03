<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendonor;
use Illuminate\Support\Facades\Log;

class PendonorController extends Controller
{
    /**
     * Display a listing of pendonor
     */
    public function index(Request $request)
    {
        try {
            $query = Pendonor::query();

            // Search functionality
            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('no_hp', 'like', '%' . $search . '%')
                      ->orWhere('golongan_darah', 'like', '%' . $search . '%');
                });
            }

            // Filter by golongan darah
            if ($request->has('golongan_darah') && $request->golongan_darah != '') {
                $query->where('golongan_darah', $request->golongan_darah);
            }

            $pendonors = $query->orderBy('created_at', 'desc')->paginate(10);

            return view('admin.pendonor.index', compact('pendonors'));

        } catch (\Exception $e) {
            Log::error('Error in index pendonor: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat data');
        }
    }

    /**
     * Show the form for creating a new pendonor
     */
    public function create()
    {
        return view('admin.pendonor.create');
    }

    /**
     * Store a newly created pendonor
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pendonor,email',
            'no_hp' => 'required|string|max:15',
            'golongan_darah' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        try {
            Pendonor::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'golongan_darah' => $request->golongan_darah,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            return redirect()->route('admin.pendonor.index')
                ->with('success', 'Pendonor berhasil ditambahkan');

        } catch (\Exception $e) {
            Log::error('Error in store pendonor: ' . $e->getMessage());
            return back()->with('error', 'Gagal menambahkan pendonor')->withInput();
        }
    }

    /**
     * Display the specified pendonor
     */
    public function show($id)
    {
        try {
            $pendonor = Pendonor::with(['riwayatDonasi', 'partisipasiKegiatan.kegiatan'])
                ->findOrFail($id);

            return view('admin.pendonor.show', compact('pendonor'));

        } catch (\Exception $e) {
            Log::error('Error in show pendonor: ' . $e->getMessage());
            return redirect()->route('admin.pendonor.index')
                ->with('error', 'Pendonor tidak ditemukan');
        }
    }

    /**
     * Show the form for editing the specified pendonor
     */
    public function edit($id)
    {
        try {
            $pendonor = Pendonor::findOrFail($id);
            return view('admin.pendonor.edit', compact('pendonor'));

        } catch (\Exception $e) {
            Log::error('Error in edit pendonor: ' . $e->getMessage());
            return redirect()->route('admin.pendonor.index')
                ->with('error', 'Pendonor tidak ditemukan');
        }
    }

    /**
     * Update the specified pendonor
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pendonor,email,' . $id . ',pendonor_id',
            'no_hp' => 'required|string|max:15',
            'golongan_darah' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ]);

        try {
            $pendonor = Pendonor::findOrFail($id);
            $pendonor->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'golongan_darah' => $request->golongan_darah,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            return redirect()->route('admin.pendonor.index')
                ->with('success', 'Data pendonor berhasil diperbarui');

        } catch (\Exception $e) {
            Log::error('Error in update pendonor: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui data pendonor')->withInput();
        }
    }

    /**
     * Remove the specified pendonor
     */
    public function destroy($id)
    {
        try {
            $pendonor = Pendonor::findOrFail($id);
            $pendonor->delete();

            return redirect()->route('admin.pendonor.index')
                ->with('success', 'Pendonor berhasil dihapus');

        } catch (\Exception $e) {
            Log::error('Error in destroy pendonor: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus pendonor');
        }
    }

    /**
     * Get riwayat donasi pendonor
     */
    public function riwayatDonasi($id)
    {
        try {
            $pendonor = Pendonor::with(['riwayatDonasi' => function ($query) {
                $query->orderBy('tanggal_donasi', 'desc');
            }])->findOrFail($id);

            return view('admin.pendonor.riwayat-donasi', compact('pendonor'));

        } catch (\Exception $e) {
            Log::error('Error in riwayatDonasi: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat riwayat donasi');
        }
    }
/**
 * Export PDF riwayat donor untuk pendonor
 */
    public function exportPdf()
    {
        $pendonor = auth()->user()->pendonor;
        $riwayatDonasi = $pendonor->donasiDarah()->orderBy('tanggal_donasi', 'desc')->get();
        
        $totalBerhasil = $riwayatDonasi->where('status_donasi', 'Berhasil')->count();
        $nyawaTerselamatkan = $totalBerhasil * 3;
        $persentaseKeberhasilan = $riwayatDonasi->count() > 0 
            ? round(($totalBerhasil / $riwayatDonasi->count()) * 100) 
            : 0;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.pendonor.riwayat-donor-pdf', compact(
            'pendonor',
            'riwayatDonasi',
            'totalBerhasil',
            'nyawaTerselamatkan',
            'persentaseKeberhasilan'
        ));

        return $pdf->download('riwayat-donor-' . $pendonor->nama . '.pdf');
    }
}