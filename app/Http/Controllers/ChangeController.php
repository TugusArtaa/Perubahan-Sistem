<?php

namespace App\Http\Controllers;

use App\Models\Change;
use App\Models\Application;
use Illuminate\Http\Request;

class ChangeController extends Controller
{
    // Menampilkan daftar perubahan
    public function index()
    {
        // Mengambil semua data perubahan
        $changes = Change::all();
        // Mengembalikan view 'changes.perubahan' dengan data perubahan
        return view('changes.perubahan', compact('changes'));
    }

    // Menampilkan form untuk membuat perubahan baru
    public function create($applicationId)
    {
        // Mengambil data aplikasi berdasarkan id
        $application = Application::findOrFail($applicationId);
        // Mengembalikan view 'changes.create' dengan data aplikasi
        return view('changes.create', compact('application'));
    }

    // Menyimpan perubahan baru ke database
    public function store(Request $request, $applicationId)
    {
        // Validasi data dari form
        $request->validate([
            'perubahan' => 'required',
            'tingkat_kepentingan' => 'required',
            'request_date' => 'required|date',
            'version' => 'required',
        ]);

        // Simpan data perubahan ke database
        Change::create([
            'application_id' => $applicationId,
            'perubahan' => $request->perubahan,
            'tingkat_kepentingan' => $request->tingkat_kepentingan,
            'request_date' => $request->request_date,
            'approval_date' => $request->approval_date,
            'uat_date' => $request->uat_date,
            'release_date' => $request->release_date,
            'version' => $request->version,
            'target_release_date' => $request->target_release_date,
        ]);

        // Redirect ke halaman index
        return redirect()->route('changes.index');
    }

    // Menampilkan form untuk mengedit perubahan yang sudah ada
    public function edit($id)
    {
        // Mengambil data perubahan berdasarkan id
        $change = Change::findOrFail($id);
        // Mengembalikan view 'changes.edit' dengan data perubahan
        return view('changes.edit', compact('change'));
    }

    // Memperbarui data perubahan yang sudah ada
    public function update(Request $request, $id)
    {
        // Validasi data dari form
        $request->validate([
            'perubahan' => 'required',
            'tingkat_kepentingan' => 'required',
            'request_date' => 'required|date',
            'version' => 'required',
        ]);

        // Mengambil data perubahan berdasarkan id
        $change = Change::findOrFail($id);
        // Memperbarui data perubahan dengan data baru
        $change->update($request->all());

        // Redirect ke halaman index
        return redirect()->route('changes.index');
    }

    // Menghapus perubahan dari database
    public function destroy($applicationId, $id)
    {
        // Mengambil data perubahan berdasarkan id
        $change = Change::findOrFail($id);
        // Menghapus data perubahan
        $change->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('changes.index')->with('success', 'Perubahan berhasil dihapus.');
    }
}