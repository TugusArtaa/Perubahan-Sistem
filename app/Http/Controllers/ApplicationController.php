<?php
namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // Menampilkan daftar aplikasi
    public function index()
    {
        // Mengambil semua data aplikasi beserta relasi 'changes'
        $applications = Application::paginate(10);
        // Mengembalikan view 'applications.index' dengan data aplikasi
        return view('applications.index', compact('applications'));
    }

    // Menampilkan form untuk membuat aplikasi baru
    public function create()
    {
        // Mengembalikan view 'applications.create'
        return view('applications.create');
    }

    // Menyimpan aplikasi baru ke database
    public function store(Request $request)
    {
        // Validasi data dari form
        $validatedData = $request->validate([
            'nama' => 'required',
            'fungsi' => 'required',
            'pengguna' => 'required',
            'pemilik' => 'required',
            'pengembang' => 'required',
        ]);
    
        // Simpan data ke database
        Application::create($validatedData);
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('applications.index')->with('success', 'Data berhasil disimpan!');
    }
    
    // Menampilkan form untuk mengedit aplikasi yang sudah ada
    public function edit($id)
    {
        // Mengambil data aplikasi berdasarkan id
        $application = Application::findOrFail($id);
        // Mengembalikan view 'applications.edit' dengan data aplikasi
        return view('applications.edit', compact('application'));
    }

    // Memperbarui data aplikasi yang sudah ada
    public function update(Request $request, $id)
    {
        // Validasi data dari form
        $request->validate([
            'nama' => 'required',
            'fungsi' => 'required',
            'pengguna' => 'required',
            'pemilik' => 'required',
            'pengembang' => 'required',
        ]);

        // Mengambil data aplikasi berdasarkan id
        $application = Application::findOrFail($id);
        // Memperbarui data aplikasi dengan data baru
        $application->update($request->all());
        // Redirect ke halaman index
        return redirect()->route('applications.index');
    }

    // Menghapus aplikasi dari database
    public function destroy($id)
    {
        // Mengambil data aplikasi berdasarkan id
        $application = Application::findOrFail($id);
        // Menghapus data aplikasi
        $application->delete();
        // Redirect ke halaman index
        return redirect()->route('applications.index');
    }
}