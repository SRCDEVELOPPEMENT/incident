<?php

namespace App\Http\Controllers;

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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        notify()->info('Liste Des Départements ! ⚡️');

        $departements = Departement::all();

        $categories = DB::table('categories')->get();

        return view('departements.index',
        [
         'departements' => $departements,
         'categories' => $categories,
        ]);
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

        $get_departements = Departement::get();
        $oui = true;

        foreach ($get_departements as $departement) {
            $departement_courrant = strtolower(Str::ascii(str_replace(" ", "", $departement->name)));
            $departement_saisi = strtolower(Str::ascii(str_replace(" ", "", $input['name'])));
            if(strcmp($departement_courrant, $departement_saisi) == 0){
                $oui = false;
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
            
            smilify('success', 'Département Enrégistrer Avec Succès !');

            return response([$departement]);    
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

        $departements = DB::table('departements')->get();

        $Qte = 0;
        $tab = array();

        foreach ($departements as $departement) {
            if($departement->id != intval($request->input('id'))){
                array_push($tab, $departement);
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
                'name'=>$request->name,
            ]);
            
            smilify('success', 'Département Modifier Avec Succèss !');

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

        smilify('success', 'Département Supprimer Avec Succèss !');

        return response()->json([1]);
    }

    public function generate(){

        $sites = Site::with('regions')->get();

        $pdf = PDF::loadView('PDF/sites', ['sites' => $sites]);
        
        return $pdf->stream('sites.pdf', array('Attachment'=>0));
    }
}
