<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Users_incident;
use App\Models\User;
use App\Models\Incident;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;
use DB;

class Users_IncidentController extends Controller
{
    // function __construct()
    // {
    //     $this->middleware('permission:lister-vehicule|creer-vehicule|editer-vehicule|supprimer-vehicule|voir-vehicule', ['only' => ['index','show']]);
    //     $this->middleware('permission:creer-vehicule', ['only' => ['create','store']]);
    //     $this->middleware('permission:editer-vehicule', ['only' => ['edit','update']]);
    //     $this->middleware('permission:supprimer-vehicule', ['only' => ['destroy']]);
    // }


    public function getIncidents()
    {
        $incidents = array();

        if ((Auth::user()->roles[0]->name == "COORDONATEUR")) {
            $users_incidents = Users_incident::with('users')->where('user_id', '=', Auth::user()->id)->get();
            if(is_iterable($users_incidents)){
                for ($m=0; $m < count($users_incidents); $m++) {
                    $ui = $users_incidents[$m];
        
                    $problem = Incident::with('categories', 'processus', 'sites')
                    ->where('number', '=', $ui->incident_number)
                    ->get()->first();
        
                    if($problem){
    
                        $ttaches = Tache::with('sites.types')
                        ->where('incident_number', '=', $problem->number)
                        ->get();
    
                        for ($xe=0; $xe < count($ttaches); $xe++) {
                            $tachi = $ttaches[$xe];
                            array_push($tasks, $tachi);
                        }
        
                        array_push($incidents, $problem);
                    }                           
                }
            }
    
        }
    
        return $incidents;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        notify()->info('Liste Des Départements Ou Site Assignés A Cet Incident ! ⚡️');
        
        $entiter = array();
        $in = $request->in;
        $entiter_utilisateurs = array();
        $types = DB::table('types')->get();
        $sites = DB::table('sites')->get();

        $u_incident = Users_incident::get();

        $lincident_du_number_ci = DB::table('incidents')->where('number', '=', $request->number)->get()->first();

        $users_incidents = Users_incident::where('incident_number', '=', $request->number)->get();
        

        for ($u=0; $u < count($users_incidents); $u++) {

            $ui = $users_incidents[$u];

            $utilisateur = DB::table('users')->where('id', '=', $ui->user_id)->get()->first();

            array_push($entiter_utilisateurs, $utilisateur);

            if($utilisateur->departement_id){

                $depart = Departement::where('id', '=', intval($utilisateur->departement_id))->get()->first();

                array_push($entiter, $depart);
    
            }elseif($utilisateur->site_id){

                $syt = DB::table('sites')->where('id', '=', intval($utilisateur->site_id))->get()->first();

                array_push($entiter, $syt);
            }
            
        }

        return view('users_incidents.index',
        [
            'entiter' => $entiter,
            'lincident_du_number_ci' => $lincident_du_number_ci,
            'entiter_utilisateurs' => $entiter_utilisateurs,
            'users_incidents' => $users_incidents,
            'u_incident' => $u_incident,
            'number' => $request->number,
            'sites' => $sites,
            'types' => $types,
            'in' => $in,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_edit(Request $request){

        $number = $request->input('number');

        $user_incideww = array();

        $usersIncidants = Users_incident::with('users')->get();

        if(is_iterable($usersIncidants)){
        for ($gu=0; $gu < count($usersIncidants); $gu++) {
            $use_inci_courant = $usersIncidants[$gu];
            if($use_inci_courant->incident_number == $number){
                array_push($user_incideww, $use_inci_courant);
            }
        }}
        
        if(is_iterable($user_incideww)){
        for ($cf=0; $cf < count($user_incideww); $cf++) {
                        $uzer_i = $user_incideww[$cf];

                        if($uzer_i->isDeclar == FALSE){
                            DB::table('users_incidents')
                            ->where('incident_number', '=', $number)
                            ->where('user_id', '=', $uzer_i->user_id)
                            ->delete();
                        }else{
                            DB::table('users_incidents')
                            ->where('incident_number', '=', $number)
                            ->where('user_id', '=', $uzer_i->user_id)
                            ->update([
                                'isTrigger' => FALSE,
                            ]);
                        }
        }}
        
        $users_a_inserer = array();
        $site_id = $request->input('esperanceEditshow');
        
        $user_incident_qui_a_creer = DB::table('users_incidents')
        ->where('incident_number', '=' , $number)
        ->where('isCoordo', '=', TRUE)
        ->get()->first();

        if($site_id){
                
                DB::table('incidents')->where('number', $request->number)->update([
                    'site_id' => $site_id,
                    'observation_rex' => $request->observation ? $request->observation : NULL,
                ]);
        
                $users = DB::table('users')->where('site_id', '=', $site_id)->get();

                $le_premier_user = $users[0];

                $user_incident_respo = NULL;
                if($le_premier_user){
                if($le_premier_user->responsable){
                    $user_incident_respo = DB::table('users_incidents')
                    ->where('incident_number', '=', $number)
                    ->where('user_id', '=', $le_premier_user->responsable)->get()->first();
                }}

                if($le_premier_user){
                if($le_premier_user->responsable){
                if($user_incident_respo == NULL){
                    $le_respo = DB::table('users')->where('id', '=', $le_premier_user->responsable)->get()->first();

                    DB::table('users_incidents')->insert([
                        'isTrigger' => FALSE,
                        'isCoordo' => FALSE,
                        'incident_number' => $number,
                        'user_id' => intval($le_respo->id),
                        'created_at' => Carbon::now()->format('Y-m-d'),
                    ]);
                }}}

                if(is_iterable($users)){
                for ($i=0; $i < count($users); $i++) {

                    $user = $users[$i];

                    $user_i = DB::table('users_incidents')
                    ->where('incident_number', '=' , $number)
                    ->where('user_id', '=', intval($user->id))
                    ->get()->first();

                    if($user_i == NULL){
                        array_push($users_a_inserer, $user);
                    }else{

                        DB::table('users_incidents')->where(
                            [
                                ['incident_number', '=' ,$number],
                                ['user_id', '=', intval($user->id)],

                            ])->update([

                            'isTrigger' => TRUE,
                            'isCoordo' => TRUE,
                        ]);

                        if($user_incident_qui_a_creer){
                            if(Auth::user()->id == $user_incident_qui_a_creer->user_id){

                                DB::table('users_incidents')
                                ->where('id', '=', $user_incident_qui_a_creer->id)
                                ->update([
                                    
                                    'isTrigger' => FALSE,
                                    'isCoordo' => FALSE,
                                ]);
                            }
                        }
                    }
                }}

                if(is_iterable($users_a_inserer)){
                for ($v=0; $v < count($users_a_inserer); $v++) {
                    
                    $utili = $users_a_inserer[$v];

                    DB::table('users_incidents')->insert([
                        'isTrigger' => TRUE,
                        'isCoordo' => TRUE,
                        'incident_number' => $number,
                        'user_id' => intval($utili->id),
                        'created_at' => Carbon::now()->format('Y-m-d'),
                    ]);

                }}

                if($user_incident_qui_a_creer){
                    if(Auth::user()->id == $user_incident_qui_a_creer->user_id){

                        DB::table('users_incidents')
                        ->where('id', '=', $user_incident_qui_a_creer->id)
                        ->update([
                            
                            'isTrigger' => FALSE,
                            'isCoordo' => FALSE,
                        ]);

                        DB::table('incidents')->where('number', '=', $number)->update([

                            'site_id' => $site_id

                        ]);
                    }
                }
        }

        return response()->json([1]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignation(Request $request)
    {
        DB::table('users_incidents')->insert([
            'incident_number' => $request->number,
            'user_id' => intval($request->id_user),
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);

        notify()->success('Utilisateur Assigné A L\'Incident Avec Succèss ! ⚡️');

        return response()->json([1]);
    }

}
