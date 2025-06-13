<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $roles = Role::with('permissions')->get();
            
            return DataTables::of($roles)
                ->addColumn('permissions', function ($role) {
                    return $role->permissions->pluck('name')->implode(', ');
                })
                ->editColumn('created_at', function ($user) {
                    return $user->created_at->format('M d, Y H:i');
                })
                ->addColumn('action', function ($role) {
                    $actions = '<div class="btn-group-actions">';
                    
                    // Edit button (only if user can edit roles)
                    if (auth()->user()->can('edit-roles')) {
                        $actions .= '<a href="' . route('roles.edit', $role->id) . '" class="btn btn-action btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit Role">
                                <i class="bi bi-pencil"></i>
                            </a>';
                    }
                    
                    // Delete button (only if user can delete roles and role is not system protected)
                    if (auth()->user()->can('delete-roles') && !in_array($role->name, ['Super Admin', 'Admin'])) {
                        $actions .= '<button type="button" class="btn btn-action btn-sm btn-danger delete-role" data-id="' . $role->id . '" data-bs-toggle="tooltip" title="Hapus Role">
                                <i class="bi bi-trash"></i>
                            </button>';
                    }
                    
                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $request->name]);
        
        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return response()->json([
            'success' => true,
            'message' => 'Role created successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array'
        ]);

        $role->update(['name' => $request->name]);
        
        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully!'
        ]);
    }
}
