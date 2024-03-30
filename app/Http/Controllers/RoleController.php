<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//adding from Spatie
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:watch-role|insert-role|modify-role|delete-role', ['only' => ['index']]);
        $this->middleware('permission:insert-role', ['only' => ['create', 'store']]);
        $this->middleware('permission:modify-role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Show Role view
        $roles = Role::paginate(5);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Insert a Role
        $permission = Permission::get();
        return view('roles.insert', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar la petición
        $this->validate($request, ['name' => 'required', 'permission' => 'required']);

        // Crear el rol con el nombre proporcionado
        $role = Role::create(['name' => $request->input('name')]);

        // Sincronizar los permisos asociados con el rol
        $role->permissions()->sync($request->input('permission'));
        return redirect()->route('roles.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Modify the role
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('roles.modify', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Save changes to Role
        $this->validate($request, ['name' => 'required', 'permission' => 'required']);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->permissions()->sync($request->input('permission'));
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Delete the Role
        DB::table('roles')->where('id', $id)->delete();
        return redirect()->route('roles.index');
    }
}
