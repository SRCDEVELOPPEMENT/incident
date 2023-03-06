<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class PermissionController extends Controller
{

    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
         $this->middleware('permission:lister-permission|creer-permission|editer-permission|supprimer-permission|voir-permission', ['only' => ['index','store']]);
         $this->middleware('permission:creer-permission', ['only' => ['create','store']]);
         $this->middleware('permission:editer-permission', ['only' => ['edit','update']]);
         $this->middleware('permission:supprimer-permission', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        toastr()->info('Liste Des Permissions Du Systèm !');

        $permissions = Permission::get();

        $roles_has_permissions = DB::table('role_has_permissions')->get();

        return view('permissions.index', compact('permissions', 'roles_has_permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
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

        $get_permissions = Permission::get();
        $oui = true;

        foreach ($get_permissions as $permission) {
            $permission_courrant = strtolower(Str::ascii(str_replace("-", "", str_replace(" ", "", $permission->name))));
            $permission_saisi = strtolower(Str::ascii(str_replace("-", "", str_replace(" ", "", $input['name']))));
            if(strcmp($permission_courrant, $permission_saisi) == 0){
                $oui = false;
            }
        }
        if(!$oui){
            return response()->json([]);
        }else{
        Permission::create(
            [
                'name' => $input['name'],
                'description' => $input['description'],
            ]);
    
        $permission = DB::table('permissions')->get()->last();

        toastr()->success('Permission Enrégistrer Avec Succèss !');

        return response()->json([$permission]);

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
        $permission = Permission::find($id);
    
        return view('permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {    
        toastr()->success('Permission Modifier Avec Succèss !');

        $permissions = DB::table('permissions')->get();

        $Qte = 0;
        $tab = array();

        foreach ($permissions as $permission) {
            if($permission->id != intval($request->input('id'))){
                array_push($tab, $permission);
            }
        }

        foreach ($tab as $permission) {
            $permission_present = strtolower(Str::ascii(str_replace("-", "", str_replace(" ", "", $permission->name))));
            $permission_int = strtolower(Str::ascii(str_replace("-", "", str_replace(" ", "", $request->input('name')))));
            if(strcmp($permission_present, $permission_int) == 0){
                $Qte += 1;
            }
        }
        if($Qte > 0){
            return response()->json([]);
        }else{
        $permission = Permission::find($request->id);

        $permission->name = $request->input('name');
        $permission->description = $request->input('description');
        $permission->save();
        
        return response()->json([1]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Permission::find($request->id)->delete();
        
        toastr()->info('Permission Supprimer Avec Succèss !');

        return response()->json();
    }
}
