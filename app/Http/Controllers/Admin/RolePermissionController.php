<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Menu; // Add this import for Menu model
use App\Models\Submenu; // Add this import for Submenu model

class RolePermissionController extends Controller
{
    // Display all roles
    public function index()
    {
        $roles = Role::paginate(10); // Paginate results
        return view('admin.roles.index', compact('roles'));
    }

    // Show form to create a new role
    public function create()
    {
        return view('admin.roles.create'); // Ensure this view exists
    }

    // Store a new role
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Role::create($request->only('name'));
        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    // Edit a specific role
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }

    // Update a specific role
    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $role = Role::findOrFail($id);
        $role->update($request->only('name'));
        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    // Delete a specific role
    public function delete($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }

    // Display all permissions with pagination and search
    public function permissionsIndex(Request $request)
    {
        $query = Permission::query();

        // Optional: Handle search functionality
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $permissions = $query->paginate(10); // Adjust the number per page as needed
        return view('admin.permissions.index', compact('permissions'));
    }

    // Show form to create a new permission
    public function permissionsCreate()
    {
        // Fetch menus and submenus for the select options
        $menus = Menu::all();
        $submenus = Submenu::all();
        return view('admin.permissions.create', compact('menus', 'submenus')); // Pass menus and submenus to the view
    }

    // Store a new permission
    public function permissionsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:permissions,slug', // Ensure unique slug
            'route' => 'required|string|max:255',
            'menu_id' => 'required|exists:menus,id', // Validate that the menu exists
            'submenu_id' => 'required|exists:submenus,id', // Validate that the submenu exists
        ]);

        // Create the new permission with the provided fields
        Permission::create($request->only(['name', 'slug', 'route', 'menu_id', 'submenu_id']));

        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
    }

    // Edit a specific permission
    public function permissionsEdit($id)
    {
        $permission = Permission::findOrFail($id);
        $menus = Menu::all(); // Fetch menus for the dropdown
        $submenus = Submenu::all(); // Fetch submenus for the dropdown
        return view('admin.permissions.edit', compact('permission', 'menus', 'submenus'));
    }

    // Update a specific permission
    public function permissionsUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:permissions,slug,' . $id, // Ensure unique slug, except for the current permission
            'route' => 'required|string|max:255',
            'menu_id' => 'required|exists:menus,id',
            'submenu_id' => 'required|exists:submenus,id',
        ]);

        $permission = Permission::findOrFail($id);
        $permission->update($request->only(['name', 'slug', 'route', 'menu_id', 'submenu_id']));

        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
    }

    // Delete a specific permission
    public function permissionsDelete($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
    }

    // Display the Assign Permissions Form
    public function assignPermissionsForm($roleId)
    {
        $role = Role::with('permissions')->findOrFail($roleId);
        $role->load('permissions');
        $permissions = Permission::all(); // Fetch all permissions

        return view('admin.roles.assign_permissions', compact('role', 'permissions'));
    }

    // Store Assigned Permissions to a Role
    public function assignPermissions(Request $request, $roleId)
    {
        $request->validate([
            'permissions' => 'required|array',
        ]);

        $role = Role::findOrFail($roleId);
        $role->permissions()->syncWithoutDetaching($request->permissions); // Add new permissions without removing existing ones

        return redirect()->route('admin.roles.assign.permissions.form', $roleId)
            ->with('success', 'Permissions assigned successfully.');
    }

    // Revoke Permission from a Role
    public function revokePermission($roleId, $permissionId)
    {
        $role = Role::findOrFail($roleId);
        $role->permissions()->detach($permissionId); // Remove the specific permission

        return redirect()->route('admin.roles.assign.permissions.form', $roleId)
            ->with('success', 'Permission revoked successfully.');
    }
}
