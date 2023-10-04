<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Tache;
use App\Models\Logtache;
use App\Models\Incident;
use App\Models\Service_request;
use App\Models\User;
use App\Models\Categorie;
use App\Models\Users_incident;
use App\Models\Connection;
use App\Models\Site;
use Carbon\Carbon;
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

    public function connect(){

        $Connection = new Connection();

        $conn = $Connection->connect();

        return $conn;
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
        $incident = NULL;
        $taches = array();
        $in = $request->in;
        $ta = 1;

        $sites = Site::with('types')->get();
        $types = DB::table('types')->get();
        $users = User::with('sites')->get();
        $categories = Categorie::with('sites')->get();
        $logs = Logtache::with('users', 'tasks')->get();
        $processus = DB::table('pros')->get();

        $conn = $this->connect();


        $incident = Incident::with('categories', 'processus', 'sites')
        ->where('number', '=', $number_incident)
        ->get()->first();

        $taches = Tache::with('sites')
        ->where('incident_number', '=', $number_incident)->get();

        return view('taches.index', 
        compact('taches', 'number_incident', 'logs', 
                'sites', 'types', 'incident', 'in', 'ta', 'processus', 'categories',
                'users'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listeTaches(Request $request)
    { 
        notify()->info('Liste Des Tâches ! ⚡️');
        
        $taches = [];
        $number_incident = FALSE;
        $ta = $request->ta;
        $incidents = array();
        $users = User::with('sites')->get();
        $sites = Site::with('types')->get();
        $types = DB::table('types')->get();
        $categories = Categorie::with('sites')->get();
        $logs = Logtache::with('users', 'tasks')->get();
        $processus = DB::table('pros')->get();

        $conn = $this->connect();

        if(Auth::user()->roles[0]->name == "CONTROLLEUR"){

            $taches = Tache::with('sites')->get();

        }
        elseif(
           (Auth::user()->roles[0]->name == "COORDONATEUR")
        ){

            // $Query = "SELECT * FROM incidents i INNER JOIN users_incidents u ON i.number = u.incident_number
            //             WHERE status = 'ENCOURS' AND user_id = '". Auth::user()->id ."'";
            // $stmt = sqlsrv_query( $conn, $Query);
            // if ($stmt)
            // {
            //     while ($row = sqlsrv_fetch_array($stmt, SQLSRV_SCROLL_FIRST)) {
            //         $url = $row;
            //         if($url){
            //         array_push($incidents, $url);
            //         }
            //     }
            // }

            // for ($ci=0; $ci < count($incidents); $ci++) {
            //         $iic = $incidents[$ci];
                
            //     $taches = Tache::with('sites')
            //     ->where('incident_number', '=', $iic['number'])
            //     ->get();

            // }
            $taches = Tache::with('sites')
            ->where('status', '=', 'ENCOURS')
            ->get();

        }else {

                $Query = "SELECT * FROM incidents i INNER JOIN users_incidents u ON i.number = u.incident_number
                            WHERE status = 'ENCOURS' AND user_id = '". Auth::user()->id ."'";
                $stmt = sqlsrv_query( $conn, $Query);
                if ($stmt)
                {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_SCROLL_FIRST)) {
                        $url = $row;
                        if($url){
                        array_push($incidents, $url);
                        }
                    }
                }

                for ($jy=0; $jy < count($incidents); $jy++) {
                    $iic = $incidents[$jy];

                    $tas = Tache::with('sites')
                    ->where('incident_number', '=', $iic['number'])
                    ->get();
                    
                    for ($pt=0; $pt < count($tas); $pt++) {
                        $pd = $tas[$pt];

                        if($pd->site_id == Auth::user()->site_id){
                            array_push($taches, $pd);
                        }
                    }
                }
        }

        $incident = NULL;
        
        return view('taches.index', 
        compact('taches', 'users', 'logs', 
                'types', 'sites', 'number_incident', 'processus', 'categories',
                'incident', 'ta'));
    }


    public function listeTachesEncours(Request $request)
    { 
        notify()->info('Liste Des Tâches ! ⚡️');

        $taches = [];
        $u_incidents = [];
        $number_incident = FALSE;
        $ta = $request->ta;
        $incidents = array();
        $users = User::with('sites')->get();
        $sites = Site::with('types')->get();
        $types = DB::table('types')->get();
        $categories = Categorie::with('sites')->get();
        $logs = Logtache::with('users', 'tasks')->get();
        $processus = DB::table('pros')->get();

        $conn = $this->connect();

        if((Auth::user()->roles[0]->name == "CONTROLLEUR") ||
           (Auth::user()->roles[0]->name == "COORDONATEUR")){

            $taches = Tache::with('sites')
            ->where('status', '=', 'ENCOURS')
            ->get();

        }
        else{
                $Query = "SELECT * FROM incidents i INNER JOIN users_incidents u ON i.number = u.incident_number
                            WHERE status = 'ENCOURS' AND user_id = '". Auth::user()->id ."'";
                $stmt = sqlsrv_query( $conn, $Query);
                if ($stmt)
                {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_SCROLL_FIRST)) {
                        $url = $row;
                        if($url){
                        array_push($incidents, $url);
                        }
                    }
                }

                for ($jy=0; $jy < count($incidents); $jy++) {
                    $iic = $incidents[$jy];

                    $tas = Tache::with('sites')
                    ->where('incident_number', '=', $iic['number'])
                    ->where('status', '=', 'ENCOURS')
                    ->get();
                    
                    for ($pt=0; $pt < count($tas); $pt++) {
                        $pd = $tas[$pt];

                        if($pd->site_id == Auth::user()->site_id){
                            array_push($taches, $pd);
                        }
                    }
                }
        }

        $incident = NULL;
        
        return view('taches.taskEncours', 
        compact('taches', 'users', 'logs', 
                'types', 'sites', 'number_incident', 'processus', 'categories',
                'incident', 'ta'));
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
            $site = $request->input('deepartes') ? intval($request->input('deepartes')): NULL;
            
            Tache::create([
                'ds_number' => $request->input('ds_number') ? $request->input('ds_number') : NULL,
                'resolution_degree' => 1,
                'description' => $request->input('description'),
                'status' => "ENCOURS",
                'maturity_date' => $request->input('maturity_date'),
                'site_id' => $site,
                'site_emetteur' => Auth::user()->site_id,
                'incident_number' => $request->number,
                'observation_task' => $request->input('observation_task'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            if($site){
                if(intval($site) != intval(Auth::user()->site_id)){
                    $mon_uSer = User::with('sites')->where('site_id', '=', $site)->get()->first();
                    if($mon_uSer){
                    if($mon_uSer->responsable){
                        $eun_ui = DB::table('users_incidents')
                        ->where('incident_number', '=', $request->number)
                        ->where('user_id', '=', $mon_uSer->responsable)
                        ->get()->first();
                        if(!$eun_ui){
                        DB::table('users_incidents')->insert([
                            'isTrigger' => FALSE,
                            'isCoordo' => FALSE,
                            'isTriggerPlus' => FALSE,
                            'incident_number' => $request->number,
                            'user_id' => intval($mon_uSer->responsable),
                            'created_at' => Carbon::now()->format('Y-m-d'),
                        ]);}
                    }
                    $un_ui = DB::table('users_incidents')
                    ->where('incident_number', '=', $request->number)
                    ->where('user_id', '=', $mon_uSer->id)
                    ->get()->first();
                    if(!$un_ui){
                    DB::table('users_incidents')->insert([
                        'isTrigger' => FALSE,
                        'isCoordo' => FALSE,
                        'isTriggerPlus' => FALSE,
                        'incident_number' => $request->number,
                        'user_id' => intval($mon_uSer->id),
                        'created_at' => Carbon::now()->format('Y-m-d'),
                    ]);
                    }}
                }
            }

            $tache = Tache::with('sites')->get()->last();

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
        if(!str_replace(' ', '',$request->commentaire) && !str_replace(' ', '', $request->observation) && !str_replace(' ', '', $request->motif_annulation) && !str_replace(' ', '', $request->motif_attente)){
            return response()->json([1, 1]);
        }else{


            if($request->commentaire){

                DB::table('taches')->where('id', '=', $request->id)->update([
                    'status' => $request->status,
                    'motif_attente' => NULL,
                    'motif_annulation' => NULL,
                    'observation' => NULL,
                    'commentaire' => $request->commentaire,
                    'closure_date' => Carbon::now()->format('Y-m-d'),
                ]);
                
                DB::table('logtaches')->insert([
                    'tache_id' => $request->id,
                    'statut' => $request->status,
                    'user_id' => Auth::user()->id,
                    'title' => $request->commentaire,
                    'created_at' => Carbon::now()->format('Y-m-d'),
                ]); 

            }elseif ($request->observation) {

                DB::table('taches')->where('id', '=', $request->id)->update([
                    'status' => $request->status,
                    'observation' => $request->observation,
                    'closure_date' => NULL,
                    'commentaire' => NULL,
                    'motif_attente' => NULL,
                    'motif_annulation' => NULL,
                ]);

                DB::table('logtaches')->insert([
                    'tache_id' => $request->id,
                    'statut' => $request->status,
                    'user_id' => Auth::user()->id,
                    'title' => $request->observation,
                    'created_at' => Carbon::now()->format('Y-m-d'),
                ]);

            }elseif($request->motif_annulation) {

                DB::table('taches')->where('id', '=', $request->id)->update([
                    'status' => $request->status,
                    'motif_annulation' => $request->motif_annulation,
                    'commentaire' => NULL,
                    'motif_attente' => NULL,
                    'observation' => NULL,
                ]);

                DB::table('logtaches')->insert([
                    'tache_id' => $request->id,
                    'statut' => $request->status,
                    'user_id' => Auth::user()->id,
                    'title' => $request->motif_annulation,
                    'created_at' => Carbon::now()->format('Y-m-d'),
                ]);
        
            }elseif($request->motif_attente) {

                DB::table('taches')->where('id', '=', $request->id)->update([
                    'status' => $request->status,
                    'motif_attente' => $request->motif_attente,
                    'motif_annulation' => NULL,
                    'commentaire' => NULL,
                    'observation' => NULL,

                ]);

                DB::table('logtaches')->insert([
                    'tache_id' => $request->id,
                    'statut' => $request->status,
                    'user_id' => Auth::user()->id,
                    'title' => $request->motif_attente,
                    'created_at' => Carbon::now()->format('Y-m-d'),
                ]);

            }else {
            }

            notify()->success('Statut Tâche Modifier Avec Succèss ! ⚡️');

            return response()->json([1]);

        }
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
            'resolution_degree' => $request->degree == 0 ? 1 : $request->degree
        ]);

        DB::table('logtaches')->insert([
            'tache_id' => $request->id,
            'user_id' => Auth::user()->id,
            'title' => "Modification Du Pourcentage De Réalisation De La Tâche A  ". $request->degree ." %",
            'created_at' => Carbon::now()->format('Y-m-d'),
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
        $site = intval($request->input('deepartes_edit'));

        DB::table('taches')->where('id', $request->id)->update([
            'description' => $request->description,
            'observation_task' => $request->observation_task,
            'maturity_date' => $request->maturity_date,
            'resolution_degree' => $request->resolution_degree == 0 ? 1 : $request->resolution_degree,
            'site_id' => $site,
        ]);
        
        DB::table('logtaches')->insert([
            'tache_id' => $request->id,
            'user_id' => Auth::user()->id,
            'title' => "Edition Des Informations De La Tâche Via Le Boutton Editer",
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);

        smilify('success', 'Tâche Modifier Avec Succèss !');

        return response()->json([1]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setEcheanceDate(Request $request)
    {

        DB::table('taches')->where('id', $request->id)->update([
            'maturity_date' => $request->maturity_date,
        ]);
        
        DB::table('logtaches')->insert([
            'tache_id' => $request->id,
            'user_id' => Auth::user()->id,
            'title' => "Modification De La Date D'échéance De La Tâche, Nouvelle Date D'échéance : ". $request->maturity_date ."",
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]); 

        smilify('success', 'Echéance De La Tâche Ajuster Avec Succèss !');

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

        $get_Taches = $this->getTaches();

        DB::table('taches')->where('id', $request->id)->delete();

        DB::table('logtaches')->where('tache_id', '=', $request->id)->delete();

        smilify('success', 'Tâche Supprimer Avec Succèss !');

        return response()->json([1]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function suppressionFile(Request $request)
    {
        DB::table('fichiers')->where('id', $request->id)->delete();

        DB::table('logtaches')->insert([
            'tache_id' => $request->id_Task,
            'user_id' => Auth::user()->id,
            'title' => "Suppréssion D'un Fichier De La Tâche",
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);

        smilify('success', 'Fichier Supprimer Avec Succèss !');

        return response()->json([1]);
    }

}
