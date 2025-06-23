<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $permissions = Permission::all();
            
            return DataTables::of($permissions)
                ->editColumn('created_at', function ($user) {
                    return $user->created_at->format('M d, Y H:i');
                })
                ->addColumn('action', function ($permission) {
                    $actions = '<div class="btn-group-actions">';
                    
                    // Edit button (only if user can edit permissions and permission is not system protected)
                    $systemPermissions = ['view-users', 'create-users', 'edit-users', 'delete-users', 
                                        'view-roles', 'create-roles', 'edit-roles', 'delete-roles',
                                        'view-permissions', 'create-permissions', 'edit-permissions', 'delete-permissions',
                                        'view-applications', 'create-applications', 'edit-applications', 'delete-applications',
                                        'view-changes', 'create-changes', 'edit-changes', 'delete-changes', 'approve-changes'];
                    
                    if (auth()->user()->can('edit-permissions') && !in_array($permission->name, $systemPermissions)) {
                        $actions .= '<a href="' . route('permissions.edit', $permission->id) . '" class="btn btn-action btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit Permission">
                                <i class="bi bi-pencil"></i>
                            </a>';
                    }
                    
                    // Delete button (only if user can delete permissions and permission is not system protected)
                    if (auth()->user()->can('delete-permissions') && !in_array($permission->name, $systemPermissions)) {
                        $actions .= '<button type="button" class="btn btn-action btn-sm btn-danger delete-permission" data-id="' . $permission->id . '" data-bs-toggle="tooltip" title="Hapus Permission">
                                <i class="bi bi-trash"></i>
                            </button>';
                    }
                    
                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name'
        ]);

        Permission::create(['name' => $request->name]);

        return response()->json([
            'success' => true,
            'message' => 'Permission created successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission = Permission::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id
        ]);

        $permission->update(['name' => $request->name]);

        return response()->json([
            'success' => true,
            'message' => 'Permission updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return response()->json([
            'success' => true,
            'message' => 'Permission deleted successfully!'
        ]);
    }
}
