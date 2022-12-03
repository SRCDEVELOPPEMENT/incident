<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Site;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use DB;
use Redirect;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            // 'matricule' => ['required', 'string', 'max:255', 'unique:users'],
            'login' => ['required', 'string', 'max:255', 'unique:users'],
            // 'telephone' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:5'],
            // 'email' => 'required|email|unique:users,email',
            'roles' => 'required'
            ],[
                // 'matricule.unique' => 'Matricule Déja Utiliser !',
                'login.unique' => 'Nom Utilisateur Déja Utiliser !',
                // 'telephone.unique' => 'Téléphone Déja Utiliser !',
                // 'email.unique' => 'Email Déja Utilier !',
                'password.confirmed' => 'Mot De Passes Non Identique !',
                'password.min' => 'Le Mot De Passe Doit avoir Au Minimum 8 Caractères !'
            ]);

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
              
        $permitions = [
            'creer-role',
            'lister-role',
            'editer-role',
            'supprimer-role',
            'voir-role',
            'creer-utilisateur',
            'lister-utilisateur',
            'editer-utilisateur',
            'supprimer-utilisateur',
            'voir-utilisateur',
            'creer-permission',
            'lister-permission',
            'editer-permission',
            'supprimer-permission',
            'voir-permission',
            'creer-incident',
            'lister-incident',
            'editer-incident',
            'supprimer-incident',
            'annuler-incident',
            'voir-incident',
            'creer-departement',
            'lister-departement',
            'editer-departement',
            'supprimer-departement',
            'voir-departement',
            'creer-categorie',
            'lister-categorie',
            'editer-categorie',
            'supprimer-categorie',
            'voir-categorie',
            'creer-processus',
            'lister-processus',
            'editer-processus',
            'supprimer-processus',
            'voir-processus',
            'joindre-demande-service',
            'supprimer-demande-service',
            'editer-demande-service',
            'annuler-demande-service',
            'creer-tache',
            'lister-tache',
            'editer-tache',
            'supprimer-tache',
            'voir-tache',

        ];

        foreach ($permitions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $role = Role::create(['name' => $request->input('roles')]);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
