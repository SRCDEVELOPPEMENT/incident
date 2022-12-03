<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Incident;
use App\Models\Categorie;
use App\Models\Processus;
use App\Models\Tache;
use App\Models\User;
use App\Models\Users_Incident;
use Illuminate\Support\Facades\Auth;
use PDF;
use DB;
use Carbon\Carbon;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:lister-incident|creer-incident|editer-incident|supprimer-incident|voir-incident', ['only' => ['index','show']]);
        $this->middleware('permission:creer-incident', ['only' => ['create','store']]);
        $this->middleware('permission:editer-incident', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-incident', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        notify()->info('Liste Des Incidents ! ⚡️', 'Info Incident');
        //smilify('success', 'You are successfully reconnected');
        //emotify('success', 'You are awesome, your data was successfully created');
        //connectify('success', 'Connection Found', 'Success Message Here');
        $categories = Categorie::all();

        $users = User::all();

        $tasks = Tache::all();

        $processus = DB::table('pros')->get();

        $incidents = Incident::with('categories', 'processus')->get();

        $departements = DB::table('departements')->get();

        $users_incidents = DB::table('users_incidents')->get();

        $years = array();

        $annee = Carbon::now()->format('Y');
    
        for ($i=1; $i < 9; $i++) {
            array_push($years, intval($annee) - $i+1);
        }
    
        return view('incidents.index', compact(
            'departements',
            'incidents', 
            'categories', 
            'processus', 
            'users', 
            'tasks', 
            'years',
            'users_incidents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cloture(Request $request)
    {
        DB::table('incidents')->where('number', $request->number)->update([
            'closure_date' => Carbon::now()->format('Y-m-d'),
            'status' => $request->status,
            'valeur' => $request->valeur,
            'comment' => $request->comment,
        ]);
        
        smilify('success', 'Incident Clôturé Avec Succèss !');
        
        return response()->json([1]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setDueDate(Request $request)
    {
        DB::table('incidents')->where('number', $request->number)->update([
            'due_date' => $request->date,
        ]);
        
        smilify('success', 'Date D\'échéance De L\'Incident Définis Avec Succèss !');
        
        return response()->json([1]);
    }


    public function generateUniqueCode()
    {
        $last = DB::table('incidents')->get()->last();

        if($last){
            $nbr = substr($last->number, 3);
            $code = "INC". ($nbr + 1);
        }else{
            $code = "INC". "0";
        }
        // do {
        //     random_int(100000, 999999);
        // } while (Incident::where("number", "=", $code)->get()->first());
  
        return $code;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $incident_tasks = $request->all();

            Incident::create([
                'due_date' => $incident_tasks['due_date'],
                'battles' => $incident_tasks['battles'] ? $incident_tasks['battles'] : NULL,
                'perimeter' => $incident_tasks['perimeter'] ? $incident_tasks['perimeter'] : NULL,
                'description' => $incident_tasks['description'],
                'status' => "DÉCLARÉ",
                'cause' => $incident_tasks['cause'],
                'proces_id' => $incident_tasks['processus_id'][0] ? intval($incident_tasks['processus_id'][0]) : (intval($incident_tasks['processus_id'][1]) ? intval($incident_tasks['processus_id'][1]) : NULL),
                'priority' => $incident_tasks['priority'],
                'categorie_id' => $incident_tasks['categorie_id'],
                'number' => $this->generateUniqueCode(),
                'created_at' => Carbon::now()->format('Y-m-d'),
            ]);
    
            $incident = Incident::with('categories', 'processus')->get()->last();
            
            if($request->taches){
                for ($i=0; $i < count($incident_tasks['taches']); $i++) {
                    $task = $incident_tasks['taches'][$i];

                    Tache::create([
                        'incident_number' => $incident->number,
                        'description' => $task['description'],
                        'status' => "EN-RÉALISATION",
                        'maturity_date' => $task['date_echeance'],
                        'departement_solving_id' => $task['departement'],
                        'user_trigger_id' => Auth::user()->id,
                        'created_at' => Carbon::now()->format('Y-m-d'),
                    ]);
                }
            }
            
            DB::table('users_incidents')->insert([
                'created_at' => Carbon::now()->format('Y-m-d'),
                'incident_number' => $incident->number,
                'user_id' => Auth::user()->id,
                'isTrigger' => 1,
            ]);

            return response()->json([$incident]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatut(Request $request)
    {
        DB::table('incidents')->where('number', '=', $request->number)->update([
            'status' => $request->status,
        ]);

        smilify('success', 'Statut De L\'Incident Modifier Avec Succèss !');
        
        return response()->json([1]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePriorite(Request $request)
    {
        DB::table('incidents')->where('number', '=', $request->number)->update([
            'priority' => $request->priorite,
        ]);

        smilify('success', 'Priorité De L\'Incident Modifier Avec Succèss !');

        return response()->json([1]);
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::table('incidents')->where('number', '=', $request->number)->delete();

        smilify('danger', 'Incident Supprimer Avec Succèss !');

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
            DB::table('incidents')->where('number', $request->number)->update([
                'battles' => $request->battles ? $request->battles : NULL,
                'description' => $request->description,
                'cause' => $request->cause,
                'perimeter'=> $request->perimeter ? $request->perimeter : NULL,
                'categorie_id' => $request->categorie_id,
                'proces_id' => $request->processus_id[0],
                'priority' => $request->priority,
                'due_date' => $request->due_date,
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
    public function setMotifAnnul(Request $request)
    {
        DB::table('incidents')->where('number', $request->number)->update([
            'motif_annulation' => $request->motif,
            'status' => "ANNULÉ"
        ]);
        
        smilify('success', 'Incident Annulé Avec Succèss !');

        return response()->json([1]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request){

        $incident = Incident::with('categories', 'processus')->where('number', '=', $request->number)->get()->first();

        $pdf = PDF::loadView('PDF/incident', ['incident' => $incident])->setPaper('a4', 'portrait');
        
        return $pdf->stream('incident.pdf', array('Attachment'=> false));
    }

}
