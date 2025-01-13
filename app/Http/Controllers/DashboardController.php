<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Change;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalApplications = Application::count();
        $totalChanges = Change::count();
        $normalChanges = Change::where('tingkat_kepentingan', 'Normal')->count();
        $urgentChanges = Change::where('tingkat_kepentingan', 'Mendesak')->count();

        // Pencarian
        $search = $request->input('search');
        $recentChanges = Change::when($search, function ($query, $search) {
            return $query->where('perubahan', 'like', "%{$search}%")
                         ->orWhereHas('application', function ($query) use ($search) {
                             $query->where('nama', 'like', "%{$search}%");
                         });
        })->orderBy('updated_at', 'desc')->paginate(10);

        return view('home.dashboard', compact('totalApplications', 'totalChanges', 'normalChanges', 'urgentChanges', 'recentChanges', 'search'));
    }
}