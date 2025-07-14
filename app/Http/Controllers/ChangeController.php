<?php

namespace App\Http\Controllers;

use App\Models\Change;
use App\Models\Application;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ChangeController extends Controller
{
    // Menampilkan daftar perubahan
    public function index()
    {
        // Mengembalikan view 'changes.perubahan'
        return view('changes.perubahan');
    }

    // DataTables endpoint for changes
    public function getChangesData(Request $request)
    {
        if ($request->ajax()) {
            $data = Change::with('application')
                ->select(['id', 'application_id', 'perubahan', 'tingkat_kepentingan', 'request_date', 'version', 'approval_date', 'target_release_date', 'approval_status']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('application_name', function($row) {
                    return $row->application ? $row->application->nama : 'N/A';
                })
                ->addColumn('tingkat_kepentingan_badge', function($row) {
                    $badgeClass = $row->tingkat_kepentingan == 'Mendesak' ? 'warning' : 
                                 ($row->tingkat_kepentingan == 'Normal' ? 'info' : 'success');
                    return '<span class="badge bg-' . $badgeClass . '">' . ucfirst($row->tingkat_kepentingan) . '</span>';
                })
                ->addColumn('approval_status_badge', function($row) {
                    $status = $row->approval_status ?? 'pending';
                    switch($status) {
                        case 'approved':
                            return '<span class="badge bg-success fs-6" title="Disetujui"><i class="bi bi-check-circle"></i> ✓</span>';
                        case 'rejected':
                            return '<span class="badge bg-danger fs-6" title="Ditolak"><i class="bi bi-x-circle"></i> ✗</span>';
                        case 'pending':
                        default:
                            return '<span class="badge bg-warning fs-6" title="Menunggu Persetujuan"><i class="bi bi-clock"></i> ⏳</span>';
                    }
                })
                ->addColumn('formatted_request_date', function($row) {
                    return $row->request_date ? date('Y-m-d', strtotime($row->request_date)) : '-';
                })
                ->addColumn('formatted_approval_date', function($row) {
                    return $row->approval_date ? date('Y-m-d', strtotime($row->approval_date)) : '-';
                })
                ->addColumn('formatted_target_date', function($row) {
                    return $row->target_release_date ? date('Y-m-d', strtotime($row->target_release_date)) : '-';
                })
                ->addColumn('action', function($row) {
                    $viewUrl = route('changes.show', ['application' => $row->application_id, 'change' => $row->id]);
                    $editUrl = route('changes.edit', ['application' => $row->application_id, 'change' => $row->id]);
                    
                    $actions = '<div class="btn-group-actions">';
                    
                    // View button
                    $actions .= '<a href="' . $viewUrl . '" class="btn btn-action btn-sm btn-info" data-bs-toggle="tooltip" title="Lihat Detail">
                            <i class="bi bi-eye"></i>
                        </a>';
                    
                    // Edit button (only if user can edit changes)
                    if (auth()->user()->can('edit-changes')) {
                        $actions .= '<a href="' . $editUrl . '" class="btn btn-action btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit Perubahan">
                                <i class="bi bi-pencil"></i>
                            </a>';
                    }
                    
                    // Delete button (only if user can delete changes)
                    if (auth()->user()->can('delete-changes')) {
                        $actions .= '<button type="button" class="btn btn-action btn-sm btn-danger" onclick="deleteChange(' . $row->id . ', ' . $row->application_id . ')" data-bs-toggle="tooltip" title="Hapus Perubahan">
                                <i class="bi bi-trash"></i>
                            </button>';
                    }
                    
                    $actions .= '</div>';
                    return $actions;
                })
                ->addColumn('approval', function($row) {
                    $approvalButtons = '';
                    
                    // Only show approval buttons if user has permission
                    if (auth()->user()->can('approve-changes')) {
                        $approvalButtons .= '
                            <button type="button" class="btn btn-sm btn-success me-1" onclick="approveChange(' . $row->id . ')" data-bs-toggle="tooltip" title="Setujui">
                                <i class="bi bi-check"></i>
                            </button>';
                    }
                    
                    if (auth()->user()->can('reject-changes')) {
                        $approvalButtons .= '
                            <button type="button" class="btn btn-sm btn-danger me-1" onclick="rejectChange(' . $row->id . ')" data-bs-toggle="tooltip" title="Tolak">
                                <i class="bi bi-x"></i>
                            </button>';
                    }
                    
                    // If no approval permissions, show a message or empty div
                    if (empty($approvalButtons)) {
                        return '<div class="text-center text-muted"><small>No permission</small></div>';
                    }
                    
                    return '
                        <div class="text-center">
                            ' . $approvalButtons . '
                        </div>';
                })
                ->rawColumns(['tingkat_kepentingan_badge', 'approval_status_badge', 'action', 'approval'])
                ->make(true);
        }
    }
    
    // Menampilkan detail perubahan
    public function show($id)
    {
        $change = Change::findOrFail($id);
        return view('changes.show', compact('change'));
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
            'request_date_note' => 'nullable|max:50',
            'approval_date_note' => 'nullable|max:50',
            'uat_date_note' => 'nullable|max:50',
            'release_date_note' => 'nullable|max:50',
            'target_release_date_note' => 'nullable|max:50',
            // Note fields are optional, so no validation needed
        ]);

        // Simpan data perubahan ke database
        Change::create([
            'application_id' => $applicationId,
            'perubahan' => $request->perubahan,
            'tingkat_kepentingan' => $request->tingkat_kepentingan,
            'request_date' => $request->request_date,
            'request_date_note' => $request->request_date_note,
            'approval_date' => $request->approval_date,
            'approval_date_note' => $request->approval_date_note,
            'uat_date' => $request->uat_date,
            'uat_date_note' => $request->uat_date_note,
            'release_date' => $request->release_date,
            'release_date_note' => $request->release_date_note,
            'version' => $request->version,
            'target_release_date' => $request->target_release_date,
            'target_release_date_note' => $request->target_release_date_note,
        ]);

        // Redirect ke halaman index
        return redirect()->route('applications.index');
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
            // Note fields are optional, so no validation needed
        ]);

        // Mengambil data perubahan berdasarkan id
        $change = Change::findOrFail($id);
        // Memperbarui data perubahan dengan data baru kecuali approval_status
        $change->update($request->except('approval_status'));

        // Redirect ke halaman index
        return redirect()->route('changes.index');
    }

    // Menghapus perubahan dari database
    public function destroy($applicationId, $id)
    {
        try {
            // Mengambil data perubahan berdasarkan id
            $change = Change::findOrFail($id);
            // Menghapus data perubahan
            $change->delete();

            // Check if request is AJAX
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Perubahan berhasil dihapus.'
                ]);
            }

            // Redirect ke halaman index dengan pesan sukses
            return redirect()->route('changes.index')->with('success', 'Perubahan berhasil dihapus.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus perubahan. ' . $e->getMessage()
                ]);
            }

            return redirect()->route('changes.index')->with('error', 'Gagal menghapus perubahan.');
        }
    }

    // Approve a change
    public function approve($id)
    {
        try {
            $change = Change::findOrFail($id);
            $change->update([
                'approval_status' => 'approved',
                'approval_date' => now()
            ]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Perubahan berhasil disetujui.'
                ]);
            }

            return redirect()->route('changes.index')->with('success', 'Perubahan berhasil disetujui.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyetujui perubahan. ' . $e->getMessage()
                ]);
            }

            return redirect()->route('changes.index')->with('error', 'Gagal menyetujui perubahan.');
        }
    }

    // Reject a change
    public function reject($id)
    {
        try {
            $change = Change::findOrFail($id);
            $change->update([
                'approval_status' => 'rejected',
                'approval_date' => now()
            ]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Perubahan berhasil ditolak.'
                ]);
            }

            return redirect()->route('changes.index')->with('success', 'Perubahan berhasil ditolak.');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menolak perubahan. ' . $e->getMessage()
                ]);
            }

            return redirect()->route('changes.index')->with('error', 'Gagal menolak perubahan.');
        }
    }
}