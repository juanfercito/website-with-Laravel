<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpKernel\Profiler\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Profile::class;
        return view('profile.index', compact('profile'));
    }

    public function show($id)
    {
        // Lógica para mostrar el perfil con el ID proporcionado
    }

    public function edit(Request $request): View
    {
        return view('profile.modify', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Obtiene el usuario autenticado
        $user = auth()->user();

        // Verifica si el usuario es una instancia de User
        if (!($user instanceof \App\Models\User)) {
            // Manejar el error apropiadamente
            abort(500, 'No se encontró el usuario autenticado');
        }

        // Actualiza los campos del usuario con los datos validados del formulario
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->profile_name = $request->input('profile_name');
        $user->dni = $request->input('dni');
        $user->telephone = $request->input('telephone');
        $user->address = $request->input('address');
        $user->city = $request->input('city');
        $user->province = $request->input('province');
        // Continuar con otros campos que desees actualizar

        // Verifica si se ha proporcionado una nueva imagen
        if ($request->hasFile('image')) {
            // Elimina la imagen anterior si existe
            if ($user->image) {
                File::delete(public_path('storage/' . $user->image));
            }

            // Almacena la nueva imagen y actualiza la ruta en el modelo
            $imagePath = $request->file('image')->store('profile_img');
            $user->image = $imagePath;
        }

        // Guarda los cambios en el usuario
        $user->save();

        // Redirige de vuelta a la vista del perfil con un mensaje de éxito
        return redirect()->route('profile.index')->with('status', 'profile-updated');
    }



    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        return redirect()->route('logout');
    }
}
