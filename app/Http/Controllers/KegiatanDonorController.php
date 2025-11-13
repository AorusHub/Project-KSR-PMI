<?php
// filepath: c:\xampp\htdocs\ksr-pmi\Project-KSR-PMI\app\Http\Controllers\KegiatanDonorController.php

namespace App\Http\Controllers;

use App\Models\KegiatanDonor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KegiatanDonorController extends Controller
{
    // Public: Daftar kegiatan donor
    public function index()
    {
        $kegiatan = KegiatanDonor::where('status', 'Planned')
            ->where('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->paginate(12);
        
        return view('kegiatan.index', compact('kegiatan'));
    }

    // Public: Detail kegiatan
    public function show($id)
    {
        $kegiatan = KegiatanDonor::findOrFail($id);
        return view('kegiatan.show', compact('kegiatan'));
    }

    // Admin: Daftar semua kegiatan (Manajemen Kegiatan)
    public function adminIndex()
    {
        $kegiatan = KegiatanDonor::with('donasiDarah')
            ->orderBy('tanggal', 'desc')
            ->paginate(15);
        
        return view('dashboard.dev.managemen_kegiatan', compact('kegiatan'));
    }

    // Admin: Form create
    public function create()
    {
        return view('admin.kegiatan.create');
    }

    // Admin: Store kegiatan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'lokasi' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'target_donor' => 'nullable|integer|min:0',
            'status' => 'required|in:Planned,Ongoing,Completed,Cancelled',
        ]);

        $validated['created_by'] = Auth::id();

        if (empty($validated['waktu_selesai'])) {
            $validated['waktu_selesai'] = '14:00';
        }
        KegiatanDonor::create($validated);

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan donor berhasil ditambahkan!');
    }

    // Admin: Form edit
    public function edit($id)
    {
        $kegiatan = KegiatanDonor::findOrFail($id);
        return view('admin.kegiatan.edit', compact('kegiatan'));
    }

    // Admin: Update kegiatan
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'lokasi' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'target_donor' => 'nullable|integer|min:0',
            'status' => 'required|in:Planned,Ongoing,Completed,Cancelled',
        ]);

        $kegiatan = KegiatanDonor::findOrFail($id);
        $kegiatan->update($validated);

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan donor berhasil diupdate!');
    }

    // Admin: Delete kegiatan
    public function destroy($id)
    {
        $kegiatan = KegiatanDonor::findOrFail($id);
        $kegiatan->delete();

        return redirect()->route('admin.kegiatan.index')
            ->with('success', 'Kegiatan donor berhasil dihapus!');
    }

    // Staf: Update status kegiatan
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Planned,Ongoing,Completed,Cancelled',
        ]);

        $kegiatan = KegiatanDonor::findOrFail($id);
        $kegiatan->update(['status' => $validated['status']]);

        return redirect()->back()
            ->with('success', 'Status kegiatan berhasil diupdate!');
    }
}