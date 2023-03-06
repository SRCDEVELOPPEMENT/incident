<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:lister-role|creer-role|editer-role|supprimer-role|voir-role', ['only' => ['index','store']]);
         $this->middleware('permission:creer-role', ['only' => ['create','store']]);
         $this->middleware('permission:editer-role', ['only' => ['edit','update']]);
         $this->middleware('permission:supprimer-role', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permissions = DB::table('permissions')->get();

        $roles = Role::orderBy('id','DESC')->get();

        notify()->info('Liste Des Rôle ! ⚡️');
       
        return view('roles.index',compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('roles.create',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $good = true;
        $message = "";
    
        $get_roles = Role::get();
        $oui = true;
        foreach ($get_roles as $role) {
            $role_courrant = strtolower(Str::ascii(str_replace(" ", "", $role->name)));
            $role_saisi = strtolower(Str::ascii(str_replace(" ", "", $input['name'])));
            if(strcmp($role_courrant, $role_saisi) == 0){
                $oui = false;
            }
        }
        if(!$oui){
            $good = false;
            $message .= "Veuillez Modifier Votre Rôle Car Déja Existant ! \n";
        }
        // if(!$request->input('permission')){
        //     $good = false;
        //     $message .= "Veuillez Selectionner Une Permission ! \n";
        // }
        if(!$good){
            $good = false;
            return response()->json([$message]);
        }else{

            $role = Role::create(
                [
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                ]);
            
            // if($request->input('permission')){
            //     $role->syncPermissions($request->input('permission'));
            // }

            notify()->success('Rôle Créer Avec Succèss ! ⚡️');

            $rol = DB::table('roles')->get()->last();
    
            return response()->json([$rol, 1]);   
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', 'permissions.id')
            ->where('role_has_permissions.role_id',$id)
            ->get();
    
        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
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
        $role = Role::find($id);

        if($request->input('permission')){
            $role->syncPermissions($request->input('permission'));
        }
        
        return redirect()->route('roles.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modify(Request $request)
    {
        Role::where('id', '=', $request->id)->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        
        return response()->json([1]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::table('roles')->where('id', $request->id)->delete();

        toastr()->success('Role Supprimer Avec Succèss !');

        return response()->json();
    }
}
