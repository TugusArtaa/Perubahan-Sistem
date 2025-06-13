<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = User::with('roles')->get();
            
            return DataTables::of($users)
                ->addColumn('roles', function ($user) {
                    return $user->roles->pluck('name')->implode(', ');
                })
                ->editColumn('created_at', function ($user) {
                    return $user->created_at->format('M d, Y H:i');
                })
                ->addColumn('action', function ($user) {
                    $actions = '<div class="btn-group-actions">';
                    
                    // View button (always shown for users who can view users)
                    $actions .= '<a href="' . route('users.show', $user->id) . '" class="btn btn-action btn-sm btn-info" data-bs-toggle="tooltip" title="Lihat Detail">
                            <i class="bi bi-eye"></i>
                        </a>';
                    
                    // Edit button (only if user can edit users)
                    if (auth()->user()->can('edit-users')) {
                        $actions .= '<a href="' . route('users.edit', $user->id) . '" class="btn btn-action btn-sm btn-warning" data-bs-toggle="tooltip" title="Edit User">
                                <i class="bi bi-pencil"></i>
                            </a>';
                    }
                    
                    // Delete button (only if user can delete users and user is not current user)
                    if (auth()->user()->can('delete-users') && $user->id !== auth()->id()) {
                        $actions .= '<button type="button" class="btn btn-action btn-sm btn-danger delete-user" data-id="' . $user->id . '" data-bs-toggle="tooltip" title="Hapus User">
                                <i class="bi bi-trash"></i>
                            </button>';
                    }
                    
                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'array'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        return response()->json([
            'success' => true,
            'message' => 'User created successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('roles', 'permissions')->findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'array'
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        if ($request->roles) {
            $user->syncRoles($request->roles);
        } else {
            $user->syncRoles([]);
        }

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully!'
        ]);
    }
}
