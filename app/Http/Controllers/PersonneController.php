<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personne;
use App\Models\Vehicule;
use App\Models\Poste;
use DB;
use PDF;

class PersonneController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:lister-personne|creer-personne|editer-personne|supprimer-personne|voir-personne', ['only' => ['index','show']]);
        $this->middleware('permission:creer-personne', ['only' => ['create','store']]);
        $this->middleware('permission:editer-personne', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-personne', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        toastr()->info('Liste Des Acteurs Du Circuit !');

        $vehicules = Vehicule::all();

        $postes = Poste::all();

        $courriers = DB::table('courriers')->get();

        $persons = Personne::all();
        
        return view('personnes.index', [
            'vehicules' => $vehicules, 
            'postes' => $postes,
            'persons' => $persons,
            'courriers' => $courriers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        Personne::create([
            'fullname' => $request->input('fullname'),
            'telephone' => intval($request->input('telephone')),
            'matricule' => $request->input('matricule'),
            'vehicule_id' => $request->input('vehicule_id'),
            'poste_id' => $request->input('poste_id'),
        ]);
    
        $personnes = Personne::get();

        $personne = Personne::with('postes', 'vehicules')->get()->last();

        return response([$personne, $personnes]);
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
        toastr()->success('Personne Modifier Avec Succèss !');

        $personne = Personne::find($request->id);

        $personne->fullname = $request->input('fullname');
        $personne->telephone = intval($request->input('telephone'));
        $personne->matricule = $request->input('matricule') ? $request->input('matricule') : NULL;
        $personne->vehicule_id = intval($request->input('vehicule_id')) ? intval($request->input('vehicule_id')) : NULL;
        $personne->poste_id = intval($request->input('poste_id')) ? intval($request->input('poste_id')) : NULL;

        $personne->save();
        
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Personne::find($request->id)->delete();

        toastr()->info('Personne Supprimer Avec Succèss !');

        return response()->json();
    }

    public function generate_personne(){

        $personnes = Personne::with('vehicules', 'postes')->get();

        $pdf = PDF::loadView('PDF/personnes', ['personnes' => $personnes]);
        
        return $pdf->stream('personnes.pdf', array('Attachment'=> false));
    }
}
