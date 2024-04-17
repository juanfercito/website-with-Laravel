<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

// Spatie
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'profile_name',
        'email',
        'dni',
        'telephone',
        'address',
        'city',
        'province',
        'password',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function adminlte_image()
    {
        if ($this->image) {
            return asset('storage/' . $this->image); // Agrega el separador de directorios '/'
        } else {
            return 'https://picsum.photos/300/300';
        }
    }



    public function adminlte_desc()
    {
        // Verifica si hay un usuario autenticado
        if (Auth::check()) {
            // Obtén el usuario autenticado
            $user = Auth::user();

            // Verifica si el usuario tiene un rol asignado
            if ($user->roles()->exists()) {
                // Obtiene el primer rol del usuario (asumiendo que un usuario solo tiene un rol)
                $role = $user->roles()->first();

                // Obtiene el nombre del rol
                $roleName = $role->name;

                return $roleName;
            }
        }

        return 'Guest'; // Retorna 'Guest' si no se encuentra un usuario autenticado o no tiene rol asignado
    }

    public function adminlte_profile_url()
    {
        return route('profile.index');
    }
}
