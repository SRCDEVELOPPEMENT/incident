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
use App\Models\Users_incident;
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

    public function getTaches()
    {
        return Session::get('tasks');
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

        if(Session::has('incidents')){
            if(is_iterable(Session::get('incidents'))){
                for ($n=0; $n < count(Session::get('incidents')); $n++) {
                    $ici = Session::get('incidents')[$n];
                    if($ici->number == $number_incident){
                        $incident = $ici;
                    }
                }
            }
        }

        if(Session::has('tasks')){
        if(is_iterable(Session::get('tasks'))){
        for ($e=0; $e < count(Session::get('tasks')); $e++) {
            $t = Session::get('tasks')[$e];
            if($t->incident_number == $request->number){
                array_push($taches, $t);
            }
        }}}

        return view('taches.index', compact('taches', 'number_incident', 'incident'));
    }


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listeTaches(Request $request)
    { 
        notify()->info('Liste Des Tâches ! ⚡️');

        $number_incident = FALSE;

        if(
           (Auth::user()->roles[0]->name == "COORDONATEUR") ||
           (Auth::user()->roles[0]->name == "CONTROLLEUR")
          ){

            $taches = Session::get('tasks');

        }else {
            
            //$t = array();
            //$tab = array();
            $taches = [];
            $usersincidents = array();

            if(Session::has('users_incidents_logIn')){
            if(is_iterable(Session::get('users_incidents_logIn'))){
            for ($rv=0; $rv < count(Session::get('users_incidents_logIn')); $rv++) {
                $ui = Session::get('users_incidents_logIn')[$rv];
                if($ui->user_id == Auth::user()->id){
                    array_push($usersincidents, $ui);
                }
            }}}

            // for ($v=0; $v < count($usersincidents); $v++){
            //     $ui = $usersincidents[$v];

                // if(Session::has('tasks')){
                // if(is_iterable(Session::get('tasks'))){
                // for ($fm=0; $fm < count(Session::get('tasks')); $fm++) {
                //     $tach = Session::get('tasks')[$fm];
                //     if($tach->incident_number == $ui->incident_number){
                //         array_push($t, $tach);
                //     }
                // }}}
                //dd(Session::get('tasks'));
                if(Session::has('tasks')){
                if(is_iterable(Session::get('tasks'))){
                for ($pt=0; $pt < count(Session::get('tasks')); $pt++) {
                    $pd = Session::get('tasks')[$pt];

                    if($pd->site_id){
                        if(Auth::user()->site_id){
                            if(Auth::user()->site_id == $pd->site_id){
                                array_push($taches, $pd);
                            }else {
                                // for ($d=0; $d < count($usersincidents); $d++){
                                //     $us = $usersincidents[$d];
                                //     if($us->incident_number == $pd->incident_number){
                                //         if($us->isCoordo == TRUE){
                                //             array_push($taches, $pd);
                                //         }
                                //     }
                                // }
                            }
                        }
                        elseif (Auth::user()->departement_id) {

                            for ($d=0; $d < count($usersincidents); $d++){
                                $us = $usersincidents[$d];
                                if($us->incident_number == $pd->incident_number){
                                    if($us->isCoordo == TRUE){
                                        array_push($taches, $pd);
                                    }
                                }
                            }
                        }
                    }elseif ($pd->departement_id) {
                        if(Auth::user()->departement_id){
                            
                            if(Auth::user()->departement_id == $pd->departement_id){
                                array_push($taches, $pd);
                            }else{
                                // for ($d=0; $d < count($usersincidents); $d++){
                                //     $us = $usersincidents[$d];
                                //     if($us->incident_number == $pd->incident_number){
                                //         if($us->isCoordo == TRUE){
                                //             array_push($taches, $pd);
                                //         }
                                //     }
                                // }
                            }
                        }
                        elseif (Auth::user()->site_id) {
                            for ($d=0; $d < count($usersincidents); $d++){
                                $us = $usersincidents[$d];
                                if($us->incident_number == $pd->incident_number){
                                    if($us->isCoordo == TRUE){
                                        array_push($taches, $pd);
                                    }
                                }
                            }
                        }
                    }
                }}}

            //}
        }

        $incident = NULL;
        
        return view('taches.index', compact('taches', 'number_incident', 'incident'));
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
        $get_taches = $this->getTaches();
        $users = array();
        $site = NULL;
        $departement = NULL;

            if(
                ($request->input('deepartes') == "AGENCE") ||
                ($request->input('deepartes') == "MAGASIN")
            )
            {
                $site = intval($request->input('site_id'));

            }else{
                $departement = intval($request->input('deepartes'));
            }

            Tache::create([
                'ds_number' => $request->input('ds_number') ? $request->input('ds_number') : NULL,
                'resolution_degree' => 1,
                'description' => $request->input('description'),
                'status' => "ENCOURS",
                'maturity_date' => $request->input('maturity_date'),
                'departement_id' => $departement,
                'site_id' => $site,
                'incident_number' => $request->number,
                'observation_task' => $request->input('observation_task'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            $place_user_connecte = NULL;
            if(Auth::user()->site_id){

                $place_user_connecte = Auth::user()->site_id;

                if($site){
                    if(intval($site) != intval($place_user_connecte)){

                        if(Session::has('users')){
                        if(is_iterable(Session::get('users'))){
                        for ($p=0; $p < count(Session::get('users')); $p++) {
                            $us = Session::get('users')[$p];
                            if($us->site_id == $site){
                                array_push($users, $us);
                            }
                        }}}


                        $newUser_Incidents = array();

                        if(is_iterable($users)){
                            $le_responsable = NULL;
                            $le_first = $users[0];
                            if($le_first->responsable){

                                if(Session::has('users')){
                                    if(is_iterable(Session::get('users'))){
                                    for ($ss=0; $ss < count(Session::get('users')); $ss++) {
                                        $us = Session::get('users')[$ss];
                                        if($us->id == $le_first->responsable){
                                            $le_responsable = $us;
                                        }
                                }}}

                                if($le_responsable){
                                    $user_incident_respo = DB::table('users_incidents')
                                    ->where('incident_number', '=', $request->number)
                                    ->where('user_id', '=', $le_responsable->id)->get()->first();

                                    if($user_incident_respo == NULL){
                                        DB::table('users_incidents')->insert([
                                            'isTrigger' => FALSE,
                                            'isCoordo' => FALSE,
                                            'isTriggerPlus' => FALSE,
                                            'incident_number' => $request->number,
                                            'user_id' => intval($le_responsable->id),
                                            'created_at' => Carbon::now()->format('Y-m-d'),
                                        ]);
                                    }
                                }
                            }
                        for ($t=0; $t < count($users); $t++) {
                            $newUser = $users[$t];

                            $search_user = NULL;
                            if(Session::has('users_incidents')){
                            if(is_iterable(Session::get('users_incidents'))){
                            for ($nt=0; $nt < count(Session::get('users_incidents')); $nt++) {
                                $uincs = Session::get('users_incidents')[$nt];
                                if(($uincs->incident_number == $request->number) && ($uincs->user_id == $newUser->id)){
                                    $search_user = $uincs;
                                }
                            }}}

                            if($search_user == NULL){
                                
                                DB::table('users_incidents')->insert([
                                    'isTrigger' => TRUE,
                                    'incident_number' => $request->number,
                                    'user_id' => intval($newUser->id),
                                    'created_at' => Carbon::now()->format('Y-m-d'),
                                ]);

                                $last_ui = DB::table('users_incidents')->get()->last();

                                array_push($newUser_Incidents, $last_ui);  
                            }
                        }}

                        if(Session::has('users_incidents')){
                            if(is_iterable(Session::get('users_incidents'))){
                            for ($w=0; $w < count(Session::get('users_incidents')); $w++) {
                                $ui = Session::get('users_incidents')[$w];
                                array_push($newUser_Incidents, $ui);
                            }
                            Session::put('users_incidents', $newUser_Incidents);
                        }}
    
                    }
                }elseif ($departement) {

                    if(is_numeric($departement)){

                            if(Session::has('users')){
                                if(is_iterable(Session::get('users'))){
                                for ($p=0; $p < count(Session::get('users')); $p++) {
                                    $us = Session::get('users')[$p];
                                    if($us->departement_id == $departement){
                                        array_push($users, $us);
                                    }
                            }}}

                            $newUser_Incidents = array();

                            if(is_iterable($users)){
                                $le_responsable = NULL;
                                $le_first = $users[0];
                                if($le_first->responsable){
    
                                    if(Session::has('users')){
                                        if(is_iterable(Session::get('users'))){
                                        for ($ss=0; $ss < count(Session::get('users')); $ss++) {
                                            $us = Session::get('users')[$ss];
                                            if($us->id == $le_first->responsable){
                                                $le_responsable = $us;
                                            }
                                    }}}
    
                                    if($le_responsable){
                                        $user_incident_respo = DB::table('users_incidents')
                                        ->where('incident_number', '=', $request->number)
                                        ->where('user_id', '=', $le_responsable->id)->get()->first();
    
                                        if($user_incident_respo == NULL){
                                            DB::table('users_incidents')->insert([
                                                'isTrigger' => FALSE,
                                                'isCoordo' => FALSE,
                                                'isTriggerPlus' => FALSE,
                                                'incident_number' => $request->number,
                                                'user_id' => intval($le_responsable->id),
                                                'created_at' => Carbon::now()->format('Y-m-d'),
                                            ]);
                                        }
                                    }
                                }
    
                            for ($t=0; $t < count($users); $t++) {
                                $newUser = $users[$t];

                                $search_user = NULL;
                                if(Session::has('users_incidents')){
                                    if(is_iterable(Session::get('users_incidents'))){
                                    for ($nt=0; $nt < count(Session::get('users_incidents')); $nt++) {
                                        $uincs = Session::get('users_incidents')[$nt];
                                        if(($uincs->incident_number == $request->number) && ($uincs->user_id == $newUser->id)){
                                            $search_user = $uincs;
                                        }
                                }}}
        
                                if($search_user == NULL){

                                    DB::table('users_incidents')->insert([
                                        'isTrigger' => TRUE,
                                        'incident_number' => $request->number,
                                        'user_id' => intval($newUser->id),
                                        'created_at' => Carbon::now()->format('Y-m-d'),
                                    ]);

                                    $last_ui = DB::table('users_incidents')->get()->last();

                                    array_push($newUser_Incidents, $last_ui);
                                }
                            }}

                            if(Session::has('users_incidents')){
                                if(is_iterable(Session::get('users_incidents'))){
                                    for ($w=0; $w < count(Session::get('users_incidents')); $w++) {
                                        $ui = Session::get('users_incidents')[$w];
                                        array_push($newUser_Incidents, $ui);
                                    }
                                    Session::put('users_incidents', $newUser_Incidents);
                                }
                            }
                    }
                }

            }elseif(Auth::user()->departement_id){

                $place_user_connecte = Auth::user()->departement_id;

                if($site){

                        if(Session::has('users')){
                            if(is_iterable(Session::get('users'))){
                            for ($p=0; $p < count(Session::get('users')); $p++) {
                                $us = Session::get('users')[$p];
                                if($us->site_id == $site){
                                    array_push($users, $us);
                                }
                        }}}

                        $newUser_Incidents = array();

                        if(is_iterable($users)){
                            $le_responsable = NULL;
                            $le_first = $users[0];
                            if($le_first->responsable){

                                if(Session::has('users')){
                                    if(is_iterable(Session::get('users'))){
                                    for ($ss=0; $ss < count(Session::get('users')); $ss++) {
                                        $us = Session::get('users')[$ss];
                                        if($us->id == $le_first->responsable){
                                            $le_responsable = $us;
                                        }
                                }}}

                                if($le_responsable){
                                    $user_incident_respo = DB::table('users_incidents')
                                    ->where('incident_number', '=', $request->number)
                                    ->where('user_id', '=', $le_responsable->id)->get()->first();

                                    if($user_incident_respo == NULL){
                                        DB::table('users_incidents')->insert([
                                            'isTrigger' => FALSE,
                                            'isCoordo' => FALSE,
                                            'isTriggerPlus' => FALSE,
                                            'incident_number' => $request->number,
                                            'user_id' => intval($le_responsable->id),
                                            'created_at' => Carbon::now()->format('Y-m-d'),
                                        ]);
                                    }
                                }
                            }

                        for ($t=0; $t < count($users); $t++) {
                            $newUser = $users[$t];

                            $search_user = NULL;
                            if(Session::has('users_incidents')){
                                if(is_iterable(Session::get('users_incidents'))){
                                for ($nt=0; $nt < count(Session::get('users_incidents')); $nt++) {
                                    $uincs = Session::get('users_incidents')[$nt];
                                    if(($uincs->incident_number == $request->number) && ($uincs->user_id == $newUser->id)){
                                        $search_user = $uincs;
                                    }
                            }}}

                            if($search_user == NULL){

                                DB::table('users_incidents')->insert([
                                    'isTrigger' => TRUE,
                                    'incident_number' => $request->number,
                                    'user_id' => intval($newUser->id),
                                    'created_at' => Carbon::now()->format('Y-m-d'),
                                ]);

                                $last_ui = DB::table('users_incidents')->get()->last();

                                array_push($newUser_Incidents, $last_ui);

                            }
                        }}

                        if(Session::has('users_incidents')){
                            if(is_iterable(Session::get('users_incidents'))){
                                for ($w=0; $w < count(Session::get('users_incidents')); $w++) {
                                    $ui = Session::get('users_incidents')[$w];
                                    array_push($newUser_Incidents, $ui);
                                }
                                Session::put('users_incidents', $newUser_Incidents);
                            }
                        }

                        
                }elseif ($departement) {

                    if(is_numeric($departement)){

                        if(intval($departement) != intval($place_user_connecte)){

                            if(Session::has('users')){
                                if(is_iterable(Session::get('users'))){
                                for ($p=0; $p < count(Session::get('users')); $p++) {
                                    $us = Session::get('users')[$p];
                                    if($us->departement_id == $departement){
                                        array_push($users, $us);
                                    }
                            }}}
    
                            $newUser_Incidents = array();
                            if(is_iterable($users)){
                                $le_responsable = NULL;
                                $le_first = $users[0];
                                if($le_first->responsable){
    
                                    if(Session::has('users')){
                                        if(is_iterable(Session::get('users'))){
                                        for ($ss=0; $ss < count(Session::get('users')); $ss++) {
                                            $us = Session::get('users')[$ss];
                                            if($us->id == $le_first->responsable){
                                                $le_responsable = $us;
                                            }
                                    }}}
    
                                    if($le_responsable){
                                        $user_incident_respo = DB::table('users_incidents')
                                        ->where('incident_number', '=', $request->number)
                                        ->where('user_id', '=', $le_responsable->id)->get()->first();
    
                                        if($user_incident_respo == NULL){
                                            DB::table('users_incidents')->insert([
                                                'isTrigger' => FALSE,
                                                'isCoordo' => FALSE,
                                                'isTriggerPlus' => FALSE,
                                                'incident_number' => $request->number,
                                                'user_id' => intval($le_responsable->id),
                                                'created_at' => Carbon::now()->format('Y-m-d'),
                                            ]);
                                        }
                                    }
                                }
    
                            for ($t=0; $t < count($users); $t++) {
                                $newUser = $users[$t];

                                $search_user = NULL;
                                if(Session::has('users_incidents')){
                                    if(is_iterable(Session::get('users_incidents'))){
                                    for ($nt=0; $nt < count(Session::get('users_incidents')); $nt++) {
                                        $uincs = Session::get('users_incidents')[$nt];
                                        if(($uincs->incident_number == $request->number) && ($uincs->user_id == $newUser->id)){
                                            $search_user = $uincs;
                                        }
                                }}}
    
                                if($search_user == NULL){

                                    DB::table('users_incidents')->insert([
                                        'isTrigger' => TRUE,
                                        'incident_number' => $request->number,
                                        'user_id' => intval($newUser->id),
                                        'created_at' => Carbon::now()->format('Y-m-d'),
                                    ]);

                                    $last_ui = DB::table('users_incidents')->get()->last();

                                    array_push($newUser_Incidents, $last_ui);

                                }
                            }}

                            if(Session::has('users_incidents')){
                                if(is_iterable(Session::get('users_incidents'))){
                                    for ($w=0; $w < count(Session::get('users_incidents')); $w++) {
                                        $ui = Session::get('users_incidents')[$w];
                                        array_push($newUser_Incidents, $ui);
                                    }
                                    Session::put('users_incidents', $newUser_Incidents);
                                }
                            }
    
                        }
                    }
                }

            }

            $tache = Tache::with('departements', 'sites')->get()->last();

            if(Session::has('tasks')){
                $newTaches = array();
                array_push($newTaches, $tache);

                for ($w=0; $w < count($get_taches); $w++) {
                    $tach = $get_taches[$w];
                    array_push($newTaches, $tach);
                }

                Session::put('tasks', $newTaches);
            }
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

            $get_Taches = $this->getTaches();

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

                $last_log = Logtache::with('users', 'tasks')->get()->last();

                if(Session::has('logs')){
                    $newLogs = array();
                    array_push($newLogs, $last_log);
        
                    for ($w=0; $w < count(Session::get('logs')); $w++) {
                        $unlog = Session::get('logs')[$w];
                        array_push($newLogs, $unlog);
                    }
        
                    Session::put('logs', $newLogs);
                }
        
                if(Session::has('tasks')){
        
                    $task_edit = NULL;
                    $newTasks = array();
        
                    for ($j=0; $j < count($get_Taches); $j++) {
                            $task_courant = $get_Taches[$j];
                            if($task_courant->id == $request->id){
        
                                $task_edit = $task_courant;
                                $task_edit->status = $request->status;
                                $task_edit->motif_attente = NULL;
                                $task_edit->motif_annulation = NULL;
                                $task_edit->observation = NULL;
                                $task_edit->commentaire = $request->commentaire;
                                $task_edit->closure_date = Carbon::now()->format('Y-m-d');

                            } else{
                                array_push($newTasks, $task_courant);
                            }
                    }
        
                    array_push($newTasks, $task_edit);
        
                    Session::put('tasks', $newTasks);
                }
        
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

                $last_log = Logtache::with('users', 'tasks')->get()->last();

                if(Session::has('logs')){
                    $newLogs = array();
                    array_push($newLogs, $last_log);
        
                    for ($w=0; $w < count(Session::get('logs')); $w++) {
                        $unlog = Session::get('logs')[$w];
                        array_push($newLogs, $unlog);
                    }
        
                    Session::put('logs', $newLogs);
                }
        
                if(Session::has('tasks')){
        
                    $task_edit = NULL;
                    $newTasks = array();
        
                    for ($j=0; $j < count($get_Taches); $j++) {
                            $task_courant = $get_Taches[$j];
                            if($task_courant->id == $request->id){
        
                                $task_edit = $task_courant;
                                $task_edit->status = $request->status;
                                $task_edit->commentaire = NULL;
                                $task_edit->motif_attente = NULL;
                                $task_edit->motif_annulation = NULL;
                                $task_edit->observation = $request->observation;
                                $task_edit->closure_date = NULL;
                            } else{
                                array_push($newTasks, $task_courant);
                            }
                    }
        
                    array_push($newTasks, $task_edit);
        
                    Session::put('tasks', $newTasks);
                }


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


                $last_log = Logtache::with('users', 'tasks')->get()->last();

                if(Session::has('logs')){
                    $newLogs = array();
                    array_push($newLogs, $last_log);
        
                    for ($w=0; $w < count(Session::get('logs')); $w++) {
                        $unlog = Session::get('logs')[$w];
                        array_push($newLogs, $unlog);
                    }
        
                    Session::put('logs', $newLogs);
                }
        
                if(Session::has('tasks')){
        
                    $task_edit = NULL;
                    $newTasks = array();
        
                    for ($j=0; $j < count($get_Taches); $j++) {
                            $task_courant = $get_Taches[$j];
                            if($task_courant->id == $request->id){
        
                                $task_edit = $task_courant;
                                $task_edit->status = $request->status;
                                $task_edit->commentaire = NULL;
                                $task_edit->motif_attente = NULL;
                                $task_edit->observation = NULL;
                                $task_edit->motif_annulation = $request->motif_annulation;

                            } else{
                                array_push($newTasks, $task_courant);
                            }
                    }
        
                    array_push($newTasks, $task_edit);
        
                    Session::put('tasks', $newTasks);
                }

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

                $last_log = Logtache::with('users', 'tasks')->get()->last();

                if(Session::has('logs')){
                    $newLogs = array();
                    array_push($newLogs, $last_log);
        
                    for ($w=0; $w < count(Session::get('logs')); $w++) {
                        $unlog = Session::get('logs')[$w];
                        array_push($newLogs, $unlog);
                    }
        
                    Session::put('logs', $newLogs);
                }
        
                if(Session::has('tasks')){
        
                    $task_edit = NULL;
                    $newTasks = array();
        
                    for ($j=0; $j < count($get_Taches); $j++) {
                            $task_courant = $get_Taches[$j];
                            if($task_courant->id == $request->id){
        
                                $task_edit = $task_courant;
                                $task_edit->status = $request->status;
                                $task_edit->motif_annulation = NULL;
                                $task_edit->commentaire = NULL;
                                $task_edit->observation = NULL;
                                $task_edit->motif_attente = $request->motif_attente;
                            } else{
                                array_push($newTasks, $task_courant);
                            }
                    }
        
                    array_push($newTasks, $task_edit);
        
                    Session::put('tasks', $newTasks);
                }

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

        $get_Taches = $this->getTaches();

        DB::table('taches')->where('id', '=', $request->id)->update([
            'resolution_degree' => $request->degree == 0 ? 1 : $request->degree
        ]);

        DB::table('logtaches')->insert([
            'tache_id' => $request->id,
            'user_id' => Auth::user()->id,
            'title' => "Modification Du Pourcentage De Réalisation De La Tâche A  ". $request->degree ." %",
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);

        $last_log = Logtache::with('users', 'tasks')->get()->last();

        if(Session::has('logs')){
            $newLogs = array();
            array_push($newLogs, $last_log);

            for ($w=0; $w < count(Session::get('logs')); $w++) {
                $unlog = Session::get('logs')[$w];
                array_push($newLogs, $unlog);
            }

            Session::put('logs', $newLogs);
        }

        if(Session::has('tasks')){

            $task_edit = NULL;
            $newTasks = array();

            for ($j=0; $j < count($get_Taches); $j++) {
                    $task_courant = $get_Taches[$j];
                    if($task_courant->id == $request->id){

                        $task_edit = $task_courant;
                        $task_edit->resolution_degree = $request->degree == 0 ? 1 : $request->degree;

                    } else{
                        array_push($newTasks, $task_courant);
                    }
            }

            array_push($newTasks, $task_edit);

            Session::put('tasks', $newTasks);
        }

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

        $get_Taches = $this->getTaches();
        $site = NULL;
        $departement = NULL;

        if(
            ($request->input('deepartes_edit') == "AGENCE") ||
            ($request->input('deepartes_edit') == "MAGASIN")
        )
        {
            $site = intval($request->input('sity_edit'));

        }else{
            $departement = intval($request->input('deepartes_edit'));
        }


        DB::table('taches')->where('id', $request->id)->update([
            'description' => $request->description,
            'observation_task' => $request->observation_task,
            'maturity_date' => $request->maturity_date,
            'resolution_degree' => $request->resolution_degree == 0 ? 1 : $request->resolution_degree,
            'departement_id' => $departement,
            'site_id' => $site,
        ]);
        
        DB::table('logtaches')->insert([
            'tache_id' => $request->id,
            'user_id' => Auth::user()->id,
            'title' => "Edition Des Informations De La Tâche Via Le Boutton Editer",
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);

        $last_log = Logtache::with('users', 'tasks')->get()->last();

        if(Session::has('logs')){
            $newLogs = array();
            array_push($newLogs, $last_log);

            for ($w=0; $w < count(Session::get('logs')); $w++) {
                $unlog = Session::get('logs')[$w];
                array_push($newLogs, $unlog);
            }

            Session::put('logs', $newLogs);
        }


        if(Session::has('tasks')){

            $task_edit = NULL;
            $newTasks = array();

            for ($j=0; $j < count($get_Taches); $j++) {
                    $task_courant = $get_Taches[$j];
                    if($task_courant->id == $request->id){

                        $task_edit = $task_courant;
                        $task_edit->description = $request->description;
                        $task_edit->observation_task = $request->observation_task;
                        $task_edit->maturity_date = $request->maturity_date;
                        $task_edit->resolution_degree = $request->resolution_degree == 0 ? 1 : $request->resolution_degree;
                        $task_edit->departement_id = $departement;
                        $task_edit->site_id = $site;
                    } else{
                        array_push($newTasks, $task_courant);
                    }
            }

            array_push($newTasks, $task_edit);

            Session::put('tasks', $newTasks);
        }

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

        $get_Taches = $this->getTaches();

        DB::table('taches')->where('id', $request->id)->update([
            'maturity_date' => $request->maturity_date,
        ]);
        
        DB::table('logtaches')->insert([
            'tache_id' => $request->id,
            'user_id' => Auth::user()->id,
            'title' => "Modification De La Date D'échéance De La Tâche, Nouvelle Date D'échéance : ". $request->maturity_date ."",
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]); 


        $last_log = Logtache::with('users', 'tasks')->get()->last();

        if(Session::has('logs')){
            $newLogs = array();
            array_push($newLogs, $last_log);

            for ($w=0; $w < count(Session::get('logs')); $w++) {
                $unlog = Session::get('logs')[$w];
                array_push($newLogs, $unlog);
            }

            Session::put('logs', $newLogs);
        }

        if(Session::has('tasks')){

            $task_edit = NULL;
            $newTasks = array();

            for ($j=0; $j < count($get_Taches); $j++) {
                    $task_courant = $get_Taches[$j];
                    if($task_courant->id == $request->id){

                        $task_edit = $task_courant;
                        $task_edit->maturity_date = $request->maturity_date;

                    } else{
                        array_push($newTasks, $task_courant);
                    }
            }

            array_push($newTasks, $task_edit);

            Session::put('tasks', $newTasks);
        }

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

        if(Session::has('logs')){
            $newLogs = array();
            for ($w=0; $w < count(Session::get('logs')); $w++) {
                $unlog = Session::get('logs')[$w];
                if(intval($unlog->tache_id) != intval($request->id)){
                    array_push($newLogs, $unlog);
                }
            }

            Session::put('logs', $newLogs);
        }


        if(Session::has('tasks')){

            $newTasks = array();

            for ($j=0; $j < count($get_Taches); $j++) {
                    $task_courant = $get_Taches[$j];
                    if(intval($task_courant->id) != intval($request->id)){
                        array_push($newTasks, $task_courant);
                    }
            }

            Session::put('tasks', $newTasks);
        }

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


        $last_log = Logtache::with('users', 'tasks')->get()->last();

        if(Session::has('logs')){
            $newLogs = array();
            array_push($newLogs, $last_log);

            for ($w=0; $w < count(Session::get('logs')); $w++) {
                $unlog = Session::get('logs')[$w];
                array_push($newLogs, $unlog);
            }

            Session::put('logs', $newLogs);
        }

        if(Session::has('files')){
            $newFiles = array();

            for ($j=0; $j < count(Session::get('files')); $j++) {
                $file_courant = Session::get('files')[$j];
                if(intval($request->id) != intval($file_courant->id)){
                    array_push($newFiles, $file_courant);
                }
            }

            Session::put('files', $newFiles);
        }

        smilify('success', 'Fichier Supprimer Avec Succèss !');

        return response()->json([1]);
    }

}
