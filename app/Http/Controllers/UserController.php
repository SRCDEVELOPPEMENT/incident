<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Departement;
use App\Models\Vehicule;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
         $this->middleware('permission:lister-utilisateur|creer-utilisateur|editer-utilisateur|supprimer-utilisateur|voir-utilisateur', ['only' => ['index','store']]);
         $this->middleware('permission:creer-utilisateur', ['only' => ['create','store']]);
         $this->middleware('permission:editer-utilisateur', ['only' => ['edit','update']]);
         $this->middleware('permission:supprimer-utilisateur', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        notify()->info('Liste Des Utilisateurs De L\'application ! ⚡️', 'Info Utilisateur');

        $departements = Departement::all();

        $roles = Role::get();

        $utilisateurs = User::with('sites.types')->get();
        
        $sites = Site::with('types')->get();

        return view('users.index', 
        [
        'departements' => $departements,
        'roles' => $roles,
        'sites' => $sites,
        'utilisateurs' => $utilisateurs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }


    public function getUsers(){
        return response()->json(User::with('sites', 'roles')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users = User::all();
        $input = $request->all();
        $good = true;
        $message = "";
        $oui = true;
        $yes = true;

        if($input['login'] && $input['password']){
            foreach ($users as $user) {
                $user_courrant = strtolower(Str::ascii(str_replace(" ", "", $user->login)));
                $user_saisi = strtolower(Str::ascii(str_replace(" ", "", $input['login'])));
                $email_saisi = strtolower(Str::ascii(str_replace(" ", "", $input['email'])));

                if(strcmp($user_courrant, $user_saisi) == 0){
                    $oui = false;
                }
                if(strcmp($user->email, $email_saisi) == 0){
                    $yes = false;
                }
            }

            if(!$oui){
                $good = false;
                $message .= "Veuillez Modifier Votre Nom D'utilisateur Car Déja Existant !\n";
            }

            if(!$yes){
                $good = false;
                $message .= "Veuillez Modifier Votre Email Car Déja Existant !\n";
            }

            $oui = true;
            foreach ($users as $user) {
                if(Hash::check($request->input('password'), $user->password)){
                    $oui = false;
                }
            }

            if(!$oui){
                $good = false;
                $message .= "Veuillez Renseigner Un Autre Mot De Passe Car Déja Existant !\n";
            }
        }

        if($good){

            $user = User::create([
                'responsable' => $input['usings'] ? intval($input['usings']) : NULL,
                'email' => $email_saisi ? $email_saisi : NULL,
                'login' => $input['login'] ? Str::ascii(str_replace(" ", "", $input['login'])) : NULL,
                'see_password' => $input['password'],
                'password' => $input['password'] ? Hash::make($input['password']) : NULL,
                'departement_id' => $request->input('departement_id') ? intval($request->input('departement_id')) : NULL,
                'fullname' => $request->fullname ? $request->fullname : NULL,
                'site_id' => $request->input('site_id') ? intval($request->input('site_id')) : ($request->input('magasin_id') ? intval($request->input('magasin_id')) : NULL),
            ]);

            
            $user->assignRole($request->input('roles'));

            $utilisateurs = User::get();

            $utilisateur = User::with('departements', 'sites')->get()->last();
            
            notify()->success('Utilisateur Créer Avec Succèss ! ⚡️');

            return response()->json([$utilisateur, $utilisateurs]);

        }else{
            return response([$message]);
        }            
    }


        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reinitializepass(Request $request)
    {

        $input = $request->all();
        
        $user = User::where('login', '=', $input['username'])->get()->first();
        $user->password = Hash::make($input['password']);
        $user->save();
        // User::where('id', '=', $request->id)->update([
        //     'password' => Hash::make($input['password']),
        //     'see_password' => $input['password'],
        // ]);
        notify()->success('Mot De Passe Modifier Avec Succèss ! ⚡️');

        return response()->json([1, 2]);    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function resetpass(Request $request)
    {
        $input = $request->all();
        
        $user = User::find(Auth::user()->id);

        $users = DB::table('users')->get();
        
        $tab = array();
        for ($i=0; $i < count($users); $i++) {
            $u = $users[$i];
            if($u->see_password != $user['password']){
                array_push($tab, $u);
            }
        }

        $elt = 0;
        for ($i=0; $i < count($tab); $i++) {
            $u = $tab[$i];
            if($u->see_password == $input['password']){
                $elt +=1;
            }
        }

        if($elt == 0){
            User::where('id', '=', $request->id)->update([
                'password' => Hash::make($input['password']),
                'see_password' => $input['password'],
            ]);
            return response()->json([1, 2]);
        }else{
            return response()->json([1]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

            User::where('id', '=', $request->id)->update([
                'responsable' => $request->input('usings_edit') ? intval($request->input('usings_edit')) : NULL,
                'email' => $request->input('email') ? $request->input('email') : NULL,
                'fullname' => $request->input('fullname'),
                'departement_id' => $request->input('departement_id') ? intval($request->input('departement_id')) : NULL,
                'login' => $request->input('login') ? $request->input('login') : NULL,
                'password' => $request->input('password') ? Hash::make($request->input('password')) : NULL,
                'see_password' => $request->input('password'),
                'site_id' => $request->input('site_id') != NULL ? intval($request->input('site_id')) : ($request->input('magasin_id') != NULL ? intval($request->input('magasin_id')) : NULL),
            ]);

            $user = User::where('id', '=', $request->id)->get()->first();

            $user->syncRoles([]);
            $user->assignRole($request->input('roles'));

            notify()->success('Utilisateur Modifier Avec Succèss ! ⚡️');

            return response()->json();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'fullname' => ['required', 'string', 'max:255'],
            'matricule' => ['required', 'string', 'max:255', 'unique:users'],
            'login' => ['required', 'string', 'max:255', 'unique:users'],
            'telephone' => ['required', 'string', 'max:255', 'unique:users'],
            'site_id' => ['required', 'unique:users'],
            'password' => ['required', 'same:confirm-password', Rules\Password::defaults()],
            'email' => 'required|email|unique:users,email',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::table('users')->where('id', $request->id)->delete();

        notify()->success('Utilisateur Supprimer Avec Succèss ! ⚡️');

        return response()->json();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeRole(Request $request)
    {
        $user = User::where('id', '=', $request->id)->get()->first();

        $user->syncRoles([]);
        $user->assignRole($request->input('roles'));

        notify()->success('Rôle De L\'Utilisateur Modifier Avec Succèss ! ⚡️');

        return response()->json();
    }
}
