<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
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


    public function getCategories()
    {
        return Session::get('categories');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        notify()->info('Liste Des Catégories ! ⚡️');

        $types = DB::table('types')->get();

        $departements = Departement::all();

        $categories = Categorie::with('departements')->get();

        $incidents = Incident::with('categories', 'processus')->get();

        return view('categories.index', 
        [
            'types' => $types,
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

        $get_categories = $this->getCategories();
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
            $categorie->created_at = Carbon::now()->format('Y-m-d');
            if(is_numeric($input['departement_id'])){
                $categorie->departement_id = $input['departement_id'];
            }else{
                $categorie->type = $input['departement_id'];
            }

            $categorie->save();

            $categorie = Categorie::with('departements')->get()->last();

            if(Session::has('categories')){
                $newCategories = array();
                array_push($newCategories, $categorie);

                for ($w=0; $w < count($get_categories); $w++) {
                    $cat = $get_categories[$w];
                    array_push($newCategories, $cat);
                }
                Session::put('categories', $newCategories);
            }

            smilify('success', 'Catégorie Enrégistrer Avec Succès !');

            return response([$categorie]);    
        }
    }

    /**get_categories
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
        $categories = $this->getCategories();

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
            if(is_numeric($request->departement_id)){

                DB::table('categories')->where('id', $request->id)->update([
                    'name'=> $request->name,
                    'type'=> NULL,
                    'departement_id'=> $request->departement_id,
                ]);

                if(Session::has('categories')){

                    $categorie_edit = NULL;
                    $newCategories = array();
        
                    for ($j=0; $j < count($categories); $j++) {
                            $categorie_courant = $categories[$j];
                            if(intval($request->input('id')) == intval($categorie_courant->id)){

                                $categorie_edit = $categorie_courant;
                                $categorie_edit->name = $request->name;
                                $categorie_edit->type = NULL;
                                $categorie_edit->departement_id = $request->departement_id;
    
                            } else{
                                array_push($newCategories, $categorie_courant);
                            }
                    }
    
                    array_push($newCategories, $categorie_edit);
    
                    Session::put('categories', $newCategories);
                }
     
            }else{
                DB::table('categories')->where('id', $request->id)->update([
                    'name'=> $request->name,
                    'departement_id'=> NULL,
                    'type'=> $request->departement_id,
                ]);
                
                if(Session::has('categories')){

                    $categorie_edit = NULL;
                    $newCategories = array();
        
                    for ($j=0; $j < count($categories); $j++) {
                            $categorie_courant = $categories[$j];
                            if(intval($request->input('id')) == intval($categorie_courant->id)){

                                $categorie_edit = $categorie_courant;
                                $categorie_edit->name = $request->name;
                                $categorie_edit->type = $request->departement_id;
                                $categorie_edit->departement_id = NULL;
    
                            } else{
                                array_push($newCategories, $categorie_courant);
                            }
                    }
    
                    array_push($newCategories, $categorie_edit);
    
                    Session::put('categories', $newCategories);
                }

            }

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

        if(Session::has('categories')){
            $newCategories = array();
            $categories = $this->getCategories();

            for ($j=0; $j < count($categories); $j++) {
                $categorie_courant = $categories[$j];
                if(intval($request->id) != intval($categorie_courant->id)){
                    array_push($newCategories, $categorie_courant);
                }
            }

            Session::put('categories', $newCategories);
        }

        smilify('success', 'Catégorie Supprimer Avec Succèss !');

        return response()->json([1]);
    }

}
