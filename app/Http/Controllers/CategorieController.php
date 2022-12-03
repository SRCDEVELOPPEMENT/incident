<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use App\Models\Incident;
use App\Models\Departement;
use Validator,Redirect,Response;
use Illuminate\Support\Str;
use PDF;
use DB;
use Carbon\Carbon;

class CategorieController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:lister-categorie|creer-categorie|editer-categorie|supprimer-categorie|voir-categorie', ['only' => ['index','show']]);
        $this->middleware('permission:creer-categorie', ['only' => ['create','store']]);
        $this->middleware('permission:editer-categorie', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-categorie', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        notify()->info('Liste Des Catégories ! ⚡️');

        $departements = Departement::all();

        $categories = Categorie::with('departements')->get();

        $incidents = Incident::with('categories', 'processus')->get();

        return view('categories.index', 
        [
            'categories' => $categories,
            'departements' => $departements,
            'incidents' => $incidents
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $get_categories = Categorie::get();
        $oui = true;

        foreach ($get_categories as $categorie) {
            $categorie_courrant = strtolower(Str::ascii(str_replace(" ", "", $categorie->name)));
            $categorie_saisi = strtolower(Str::ascii(str_replace(" ", "", $input['name'])));
            if(strcmp($categorie_courrant, $categorie_saisi) == 0){
                $oui = false;
            }
        }

        if(!$oui){
            return [];
        }else{

            $categorie = new Categorie();

            $categorie->name = $input['name'];
            $categorie->departement_id = $input['departement_id'];
            $categorie->created_at = Carbon::now()->format('Y-m-d');
            $categorie->save();

            $categorie = Categorie::with('departements')->get()->last();
            
            smilify('success', 'Catégorie Enrégistrer Avec Succès !');

            return response([$categorie]);    
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
        //
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
        $categories = DB::table('categories')->get();

        $Qte = 0;
        $tab = array();

        foreach ($categories as $categorie) {
            if($categorie->id != intval($request->input('id'))){
                array_push($tab, $categorie);
            }
        }

        foreach ($tab as $categorie) {
            $categorie_present = strtolower(Str::ascii(str_replace(" ", "", $categorie->name)));
            $categorie_int = strtolower(Str::ascii(str_replace(" ", "", $request->input('name'))));
            if(strcmp($categorie_present, $categorie_int) == 0){
                $Qte += 1;
            }
        }

        if($Qte > 0){
            return response()->json([]);
        }else{
            DB::table('categories')->where('id', $request->id)->update([
                'name'=> $request->name,
                'departement_id'=> $request->departement_id,
            ]);
            
            smilify('success', 'Catégorie Modifier Avec Succès !');

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
        DB::table('categories')->where('id', $request->id)->delete();

        smilify('success', 'Catégorie Supprimer Avec Succèss !');

        return response()->json([1]);
    }

    public function generate(){

        $vehicules = Vehicule::get();

        $pdf = PDF::loadView('PDF/vehicules', ['vehicules' => $vehicules]);
        
        return $pdf->stream('vehicules.pdf', array('Attachment'=>0));
    }
}
