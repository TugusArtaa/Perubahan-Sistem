<?php
namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Application;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ApplicationController extends Controller
{
    // Menampilkan daftar aplikasi
    public function index()
    {
        // Mengembalikan view 'applications.index'
        return view('applications.index');
    }

    // DataTables endpoint for applications
    public function getApplicationsData(Request $request)
    {
        if ($request->ajax()) {
            $data = Application::select(['id', 'nama', 'fungsi', 'pengguna', 'pemilik', 'pengembang']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $actions = '<div class="text-center">';
                    
                    // Catalog button (always available for those who can view applications)
                    $catalogUrl = route('applications.catalog', $row->id);
                    $actions .= '<a href="' . $catalogUrl . '" class="btn btn-sm btn-primary me-1" data-bs-toggle="tooltip" title="Katalog Aplikasi">
                            <i class="bi bi-book"></i>
                        </a>';
                    
                    // Edit button (only if user can edit applications)
                    if (auth()->user()->can('edit-applications')) {
                        $editUrl = route('applications.edit', $row->id);
                        $actions .= '<a href="' . $editUrl . '" class="btn btn-sm btn-warning me-1" data-bs-toggle="tooltip" title="Edit Aplikasi">
                                <i class="bi bi-pencil"></i>
                            </a>';
                    }
                    
                    // Add change button (only if user can create changes)
                    if (auth()->user()->can('create-changes')) {
                        $changeUrl = route('application.changes.create', $row->id);
                        $actions .= '<a href="' . $changeUrl . '" class="btn btn-sm btn-info me-1" data-bs-toggle="tooltip" title="Tambah Perubahan">
                                <i class="bi bi-plus-circle"></i>
                            </a>';
                    }
                    
                    // Delete button (only if user can delete applications)
                    if (auth()->user()->can('delete-applications')) {
                        $actions .= '<button type="button" class="btn btn-sm btn-danger" onclick="deleteApplication(' . $row->id . ')" data-bs-toggle="tooltip" title="Hapus Aplikasi">
                                <i class="bi bi-trash"></i>
                            </button>';
                    }
                    
                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
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
        $validatedData = $request->validate([
            'nama' => 'required',
            'fungsi' => 'required',
            'pengguna' => 'required',
            'pemilik' => 'required',
            'pengembang' => 'required',
        ]);

        // Mengambil data aplikasi berdasarkan id
        $application = Application::findOrFail($id);
        $applicationName = $application->nama;
        
        // Memperbarui data aplikasi dengan data baru
        $application->update($validatedData);
        
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('applications.index')
            ->with('success', "Aplikasi '{$applicationName}' berhasil diperbarui!");
    }

    public function catalog($id)
    {
        // Mengambil data aplikasi berdasarkan id
        $application = Application::findOrFail($id);
        // Mengambil data perubahan terkait aplikasi
        $changes = $application->changes;

        // Mengembalikan view 'applications.catalog' dengan data aplikasi dan perubahan
        return view('applications.catalog', compact('application', 'changes'));
    }

    public function downloadPdf($id)
    {
        $application = Application::findOrFail($id);
        $changes = $application->changes;
    
        $pdf = PDF::loadView('applications.pdf', compact('application', 'changes'));
        return $pdf->download('katalog_perubahan_sistem_aplikasi.pdf');
    }

    // Menghapus aplikasi dari database
    public function destroy(Request $request, $id)
    {
        try {
            // Mengambil data aplikasi berdasarkan id
            $application = Application::findOrFail($id);
            $applicationName = $application->nama;
            
            // Menghapus data aplikasi
            $application->delete();
            
            // Check if request is AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Aplikasi '{$applicationName}' berhasil dihapus!"
                ]);
            }
            
            // Redirect ke halaman index dengan pesan sukses
            return redirect()->route('applications.index')
                ->with('success', "Aplikasi '{$applicationName}' berhasil dihapus!");
                
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus aplikasi: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('applications.index')
                ->with('error', 'Gagal menghapus aplikasi: ' . $e->getMessage());
        }
    }
}