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
                ->addColumn('action', function ($permission) {
                    $actions = '<div class="btn-group" role="group">';
                    
                    // Edit button (only if user can edit permissions)
                    if (auth()->user()->can('edit-permissions')) {
                        $actions .= '<a href="' . route('permissions.edit', $permission->id) . '" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>';
                    }
                    
                    // Delete button (only if user can delete permissions and permission is not system protected)
                    $systemPermissions = ['view-users', 'create-users', 'edit-users', 'delete-users', 
                                        'view-roles', 'create-roles', 'edit-roles', 'delete-roles',
                                        'view-permissions', 'create-permissions', 'edit-permissions', 'delete-permissions',
                                        'view-applications', 'create-applications', 'edit-applications', 'delete-applications',
                                        'view-changes', 'create-changes', 'edit-changes', 'delete-changes', 'approve-changes'];
                    
                    if (auth()->user()->can('delete-permissions')) {
                        $actions .= '<button type="button" class="btn btn-sm btn-danger delete-permission" data-id="' . $permission->id . '">
                                <i class="bi bi-trash"></i> Delete
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
