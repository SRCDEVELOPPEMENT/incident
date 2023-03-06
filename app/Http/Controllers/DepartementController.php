<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Departement;
use DB;
use PDF;
use Carbon\Carbon;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:lister-departement|creer-departement|editer-departement|supprimer-departement|voir-departement', ['only' => ['index','show']]);
        $this->middleware('permission:creer-departement|', ['only' => ['create','store']]);
        $this->middleware('permission:editer-departement', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-departement', ['only' => ['destroy']]);
    }

    public function getDepartements()
    {
        return Session::get('departements');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        notify()->info('Liste Des Départements ! ⚡️');

        return view('departements.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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

        $get_departements = $this->getDepartements();
        $oui = true;

        if(is_iterable($get_departements)){
            foreach ($get_departements as $departement) {
                $departement_courrant = strtolower(Str::ascii(str_replace(" ", "", $departement->name)));
                $departement_saisi = strtolower(Str::ascii(str_replace(" ", "", $input['name'])));
                if(strcmp($departement_courrant, $departement_saisi) == 0){
                    $oui = false;
                }
            }
        }

        if(!$oui){
            return [];
        }else{

            $departement = new Departement();

            $departement->name = $input['name'];
            $departement->created_at = Carbon::now()->format('Y-m-d');
            $departement->save();

            $departement = DB::table('departements')->get()->last();

            if(Session::has('departements')){
                $newDepartements = array();

                array_push($newDepartements, $departement);

                for ($w=0; $w < count($get_departements); $w++) {
                    $depa = $get_departements[$w];
                    array_push($newDepartements, $depa);
                }
                
                Session::put('departements', $newDepartements);
            }
            
            notify('success', 'Département Enrégistrer Avec Succès !');

            return response()->json([$departement]);
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
        $input = $request->all();

        $departements = $this->getDepartements();

        $Qte = 0;
        $tab = array();

        if(is_iterable($departements)){
            foreach ($departements as $departement) {
                if($departement->id != intval($request->input('id'))){
                    array_push($tab, $departement);
                }
            }
        }

        foreach ($tab as $departement) {
            $departement_present = strtolower(Str::ascii(str_replace(" ", "", $departement->name)));
            $departement_int = strtolower(Str::ascii(str_replace(" ", "", $request->input('name'))));
            if(strcmp($departement_present, $departement_int) == 0){
                $Qte += 1;
            }
        }

        if($Qte > 0){
            return [];
        }else{

            DB::table('departements')->where('id', $request->id)->update([
                'name'=> $request->name,
            ]);

            if(Session::has('departements')){

                $dept_edit = NULL;
                $newDepartements = array();    
    
                for ($j=0; $j < count($departements); $j++) {
                        $dept_courant = $departements[$j];
                        if(intval($request->id) == intval($dept_courant->id)){
                            $dept_edit = $dept_courant;
                            $dept_edit->name = $request->name;
                        } else{
                            array_push($newDepartements, $dept_courant);
                        }   
                }

                array_push($newDepartements, $dept_edit);

                Session::put('departements', $newDepartements);
            }
    
            notify()->success('Département Modifier Avec Succèss ! ⚡️');
            
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

        DB::table('departements')->where('id', $request->id)->delete();

        if(Session::has('departements')){
            $dept_edit = NULL;
            $newDepartements = array();
            $departements = $this->getDepartements();

            for ($j=0; $j < count($departements); $j++) { 
                $dept_courant = $departements[$j];
                if(intval($request->id) != intval($dept_courant->id)){
                    array_push($newDepartements, $dept_courant);
                }
            }

            Session::put('departements', $newDepartements);
        }

        smilify('success', 'Département Supprimer Avec Succèss !');

        return response()->json([1]);
    }
}
