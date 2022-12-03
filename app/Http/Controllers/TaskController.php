<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Tache;
use App\Models\Service_request;
use App\Models\User;

use DB;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:lister-tache|creer-tache|editer-tache|supprimer-tache|voir-tache', ['only' => ['index','show']]);
        $this->middleware('permission:creer-tache', ['only' => ['create','store']]);
        $this->middleware('permission:editer-tache', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-tache', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        notify()->info('Liste Des Tâches ! ⚡️');

        $number_incident = $request->number;

        $users = User::all();

        $departements = DB::table('departements')->get();

        $files = DB::table('fichiers')->get();

        $taches = Tache::with('departements')->where('incident_number', '=', $request->number)->get();
        
        return view('taches.index', 
            compact(
            'taches',
            'users',
            'number_incident',
            'files',
            'departements'
            ));
    }

    public function generateUniqueCode()
    {
        do {
            $code = random_int(10000, 99999);
        } while (Service_request::where("number", "=", $code)->get()->first());
  
        return $code;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function askService(Request $request)
    {
        $service = new Service_request();

        $service->number = $this->generateUniqueCode();
        $service->title = $request->title;
        $service->maturity_date = $request->maturity_date;
        $service->status = "EN-TRAITEMENT";
        $service->tache_id = $request->idTa;

        $service->save();

        $last_service = Service_request::get()->last();

        return response()->json([$last_service]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            Tache::create([
                'description' => $request->input('description'),
                'status' => "EN-RÉALISATION",
                'maturity_date' => $request->input('maturity_date'),
                'departement_solving_id' => $request->input('departement_solving_id'),
                'incident_number' => $request->number,
            ]);

            $tache = Tache::with('departements')->get()->last();

            notify()->success('Tâche Enrégistrer Avec Succèss ! ⚡️');

            return response([$tache]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        DB::table('taches')->where('id', '=', $request->id)->update([
            'status' => $request->status,
        ]);

        notify()->success('Statut Tâche Modifier Avec Succèss ! ⚡️');

        return response()->json([1]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDegree(Request $request)
    {
        DB::table('taches')->where('id', '=', $request->id)->update([
            'resolution_degree' => $request->degree,
        ]);

        notify()->success('Dégré De Réalisation De La Tâche Modifier Avec Succèss ! ⚡️');

        return response()->json([1]);
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
        DB::table('taches')->where('id', $request->id)->update([
            'description' => $request->description,
            'maturity_date' => $request->maturity_date,
            'departement_solving_id'=> $request->departement_solving_id,
        ]);
        
        smilify('success', 'Incident Modifier Avec Succèss !');

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
        DB::table('taches')->where('id', $request->id)->delete();

        smilify('success', 'Tâche Supprimer Avec Succèss !');

        return response()->json([1]);
    }
}
