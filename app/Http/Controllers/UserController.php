<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Adding other resources
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     *
     */

    function construct()
    {
        $this->middleware('permission:watch-users|insert-user|modify-user|delete-user', ['only' => ['index']]);
        $this->middleware('permission:insert-user', ['only' => ['create', 'store']]);
        $this->middleware('permission:modify-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $query = $request->input('search');

        $users = User::where(function ($q) use ($query) {
            $q->where('name', 'like', "%$query%")
                ->orWhere('dni', 'like', "%$query%")
                ->orWhere('city', 'like', "%$query%")
                ->orWhere('province', 'like', "%$query%");
        })
            ->paginate(5);

        return view('users.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id')->all();
        return view('users.insert', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'profile_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'dni' => 'required',
            'telephone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'password' => 'required|same:confirm-password',
            'roles' => 'required|array', // make sure the roles are an array
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Make user_image field optional
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        // Check if user uploaded an image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('profile_img', $imageName, 'public'); // Guardar la imagen en la carpeta storage/app/public/profile_img
            $input['image'] = $imageName; // Guardar el nombre de la imagen en el registro del usuario en la base de datos
        }


        $user = User::create($input);

        // get the role names and assign them to.
        $roles = $request->input('roles');
        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $user->assignRole($role);
            }
        }

        return redirect()->route('users.index');
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
        $user = User::find($id);

        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles()->pluck('name', 'name')->all();

        return view('users.modify', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'profile_name' => 'nullable',
            'email' => 'required|email|unique:users,email,' . $id,
            'dni' => 'required',
            'telephone' => 'nullable',
            'address' => 'nullable',
            'city' => 'required',
            'province' => 'required',
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        // Verificar si se ha proporcionado una nueva imagen
        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($user->image) {
                Storage::disk('public')->delete('profile_img/' . $user->image);
            }
            // Guardar la nueva imagen
            $input['image'] = $request->file('image')->store('profile_img', 'public');
        }

        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index');
    }
}
