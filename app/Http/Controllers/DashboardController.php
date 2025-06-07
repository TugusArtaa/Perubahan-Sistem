<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Change;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalApplications = Application::count();
        $totalChanges = Change::count();
        $normalChanges = Change::where('tingkat_kepentingan', 'Normal')->count();
        $urgentChanges = Change::where('tingkat_kepentingan', 'Mendesak')->count();
        
        // Approval status counts
        $pendingChanges = Change::where('approval_status', 'pending')->orWhereNull('approval_status')->count();
        $approvedChanges = Change::where('approval_status', 'approved')->count();
        $rejectedChanges = Change::where('approval_status', 'rejected')->count();

        return view('home.dashboard', compact(
            'totalApplications', 
            'totalChanges', 
            'normalChanges', 
            'urgentChanges',
            'pendingChanges',
            'approvedChanges',
            'rejectedChanges'
        ));
    }

    public function getChangesData(Request $request)
    {
        \Log::info('DataTables AJAX request received', [
            'is_ajax' => $request->ajax(),
            'user_id' => auth()->id(),
            'request_data' => $request->all()
        ]);        if ($request->ajax()) {
            $data = Change::with('application')
                ->select(['id', 'application_id', 'perubahan', 'tingkat_kepentingan', 'approval_status', 'updated_at']);

            \Log::info('Query data count: ' . $data->count());

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
                ->addColumn('formatted_date', function($row) {
                    return $row->updated_at->format('Y-m-d');
                })
                ->addColumn('action', function($row) {
                    $viewUrl = route('changes.show', $row->id);
                    return '<a href="' . $viewUrl . '" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye me-1"></i>Detail
                            </a>';
                })
                ->rawColumns(['tingkat_kepentingan_badge', 'approval_status_badge', 'action'])
                ->make(true);
        }
        
        \Log::info('Non-AJAX request to getChangesData');
        return response()->json(['error' => 'Not an AJAX request'], 400);
    }
}