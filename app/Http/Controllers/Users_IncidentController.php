<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Users_incident;
use App\Models\Departement;
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
        return Session::get('incidents');
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
        $entiter_utilisateurs = array();
        $types = DB::table('types')->get();
        $sites = DB::table('sites')->get();
        $departements = DB::table('departements')->get();

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
            'departements' => $departements,
            'users_incidents' => $users_incidents,
            'u_incident' => $u_incident,
            'number' => $request->number,
            'sites' => $sites,
            'types' => $types,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function defineUserOfIncident(Request $request){

        $users_a_inserer = array();
        $number = $request->input('number');
        $departement_id = $request->input('departement_id');
        $site_id = $request->input('site_id');

        $user_incident_qui_a_creer = DB::table('users_incidents')
        ->where('incident_number', '=' , $number)
        ->where('isCoordo', '=', TRUE)
        ->get()->first();

        if($departement_id && is_numeric($departement_id)){

            $users = DB::table('users')->where('departement_id', '=', $departement_id)->get();

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
                            'isTriggerPlus' => TRUE,
                            'isCoordo' => TRUE,

                    ]);


                    if(Auth::user()->id == $user_incident_qui_a_creer->user_id){

                        DB::table('users_incidents')->where(
                            [
                                ['incident_number', '=' ,$number],
                                ['user_id', '=', intval($user->id)],
    
                            ])->update([
    
                                'isTrigger' => FALSE,
                                'isCoordo' => FALSE,
                                'isTriggerPlus' => FALSE,
    
                        ]);
    
                    }
                }
        
            }

            for ($v=0; $v < count($users_a_inserer); $v++) {
                
                $utili = $users_a_inserer[$v];

                DB::table('users_incidents')->insert([
                    'isTrigger' => TRUE,
                    'isTriggerPlus' => TRUE,
                    'isCoordo' => TRUE,
                    'incident_number' => $number,
                    'user_id' => intval($utili->id),
                    'created_at' => Carbon::now()->format('Y-m-d'),
                ]);

                if(Auth::user()->id == $user_incident_qui_a_creer->user_id){

                    DB::table('users_incidents')
                    ->where('id', '=', $user_incident_qui_a_creer->id)
                    ->update([
                        
                        'isTrigger' => FALSE,
                        'isCoordo' => FALSE,
                        'isTriggerPlus' => FALSE,
                    ]);
    
    
                }
    
            }

            return response()->json([1]);

        }elseif($site_id){
            
            $users = DB::table('users')->where('site_id', '=', $site_id)->get();

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
                            'isTriggerPlus' => TRUE,
                            'isCoordo' => TRUE,


                    ]);

                    if(Auth::user()->id == $user_incident_qui_a_creer->user_id){

                        DB::table('users_incidents')->where(
                            [
                                ['incident_number', '=' ,$number],
                                ['user_id', '=', intval($user->id)],
    
                            ])->update([
    
                                'isTrigger' => FALSE,
                                'isTriggerPlus' => FALSE,
                                'isCoordo' => FALSE,
    
                        ]);
    
                    }
                }
            }

            for ($v=0; $v < count($users_a_inserer); $v++) { 
                
                $utili = $users_a_inserer[$v];

                DB::table('users_incidents')->insert([
                    'isTrigger' => TRUE,
                    'isTriggerPlus' => TRUE,
                    'isCoordo' => TRUE,
                    'incident_number' => $number,
                    'user_id' => intval($utili->id),
                    'created_at' => Carbon::now()->format('Y-m-d'),
                ]);

                if(Auth::user()->id == $user_incident_qui_a_creer->user_id){

                    DB::table('users_incidents')->insert([
                        'isTrigger' => FALSE,
                        'isTriggerPlus' => FALSE,
                        'isCoordo' => FALSE,
                        'incident_number' => $number,
                        'user_id' => intval($utili->id),
                        'created_at' => Carbon::now()->format('Y-m-d'),
                    ]);
    
                }
            }

            return response()->json([1]);
        }

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_edit(Request $request){

        $number = $request->input('number');
        $get_incidents = $this->getIncidents();

        $user_incideww = DB::table('users_incidents')
        ->where('incident_number', '=' , $number)
        ->get();

        
        DB::table('incidents')->where('number', $request->number)->update([
            'observation_rex' => $request->observation ? $request->observation : NULL,
        ]);


        if(Session::has('incidents')){
            $incident_edit = NULL;
            $newIncidents = array();

            for ($w=0; $w < count($get_incidents); $w++) {
                $incidant_cour = $get_incidents[$w];
                if($incidant_cour->number == $request->number){

                    $incident_edit = $incidant_cour;
                    $incident_edit->observation_rex = $request->observation ? $request->observation : NULL;
                }else{
                    array_push($newIncidents, $incidant_cour);    
                }
            }

            array_push($newIncidents, $incident_edit);
            Session::put('incidents', $newIncidents);
        }

        for ($cf=0; $cf < count($user_incideww); $cf++) {
                $uzer_i = $user_incideww[$cf];

                        if($uzer_i->isDeclar == FALSE && $uzer_i->isTrigger == TRUE){
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
                                'isTriggerPlus' => FALSE,
                            ]);
                        }
        }
        
        $users_a_inserer = array();
        $departement_id = $request->input('esperanceEditshow');
        $site_id = $request->input('city');
            
        $user_incident_qui_a_creer = DB::table('users_incidents')
        ->where('incident_number', '=' , $number)
        ->where('isCoordo', '=', TRUE)
        ->get()->first();

        if($departement_id && is_numeric($departement_id)){
                
                $users = DB::table('users')->where('departement_id', '=', $departement_id)->get();

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
                        'isTriggerPlus' => FALSE,
                        'incident_number' => $number,
                        'user_id' => intval($le_respo->id),
                        'created_at' => Carbon::now()->format('Y-m-d'),
                    ]);
                }}}

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
                            'isTriggerPlus' => TRUE,
                            'isCoordo' => TRUE,
                        ]);

                        //A MODIFIER
                        if($user_incident_qui_a_creer){
                            if(Auth::user()->id == $user_incident_qui_a_creer->user_id){

                                DB::table('users_incidents')
                                ->where('id', '=', $user_incident_qui_a_creer->id)
                                ->update([

                                    'isTrigger' => FALSE,
                                    'isCoordo' => FALSE,
                                    'isTriggerPlus' => FALSE,
                                ]);
            
                            }
                        }
                    }
            
                }


                for ($v=0; $v < count($users_a_inserer); $v++) {
                    
                    $utili = $users_a_inserer[$v];

                    DB::table('users_incidents')->insert([
                        'isTrigger' => TRUE,
                        'isTriggerPlus' => TRUE,
                        'isCoordo' => TRUE,
                        'incident_number' => $number,
                        'user_id' => intval($utili->id),
                        'created_at' => Carbon::now()->format('Y-m-d'),
                    ]);
                }

                if($user_incident_qui_a_creer){
                    if(Auth::user()->id == $user_incident_qui_a_creer->user_id){

                        DB::table('users_incidents')
                        ->where('id', '=', $user_incident_qui_a_creer->id)
                        ->update([
                            
                            'isTrigger' => FALSE,
                            'isCoordo' => FALSE,
                            'isTriggerPlus' => FALSE,
                        ]);

                    }
                }

        }elseif($departement_id && (!is_numeric($departement_id))){
                
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
                        'isTriggerPlus' => FALSE,
                        'incident_number' => $number,
                        'user_id' => intval($le_respo->id),
                        'created_at' => Carbon::now()->format('Y-m-d'),
                    ]);
                }}}


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
                            'isTriggerPlus' => TRUE,
                            'isCoordo' => TRUE,
                        ]);

                        if($user_incident_qui_a_creer){
                            if(Auth::user()->id == $user_incident_qui_a_creer->user_id){

                                DB::table('users_incidents')
                                ->where('id', '=', $user_incident_qui_a_creer->id)
                                ->update([
                                    
                                    'isTrigger' => FALSE,
                                    'isCoordo' => FALSE,
                                    'isTriggerPlus' => FALSE,
                                ]);
                            }
                        }
                    }
                }

                for ($v=0; $v < count($users_a_inserer); $v++) {
                    
                    $utili = $users_a_inserer[$v];

                    DB::table('users_incidents')->insert([
                        'isTrigger' => TRUE,
                        'isCoordo' => TRUE,
                        'isTriggerPlus' => TRUE,
                        'incident_number' => $number,
                        'user_id' => intval($utili->id),
                        'created_at' => Carbon::now()->format('Y-m-d'),
                    ]);

                }

                if($user_incident_qui_a_creer){
                    if(Auth::user()->id == $user_incident_qui_a_creer->user_id){

                        DB::table('users_incidents')
                        ->where('id', '=', $user_incident_qui_a_creer->id)
                        ->update([
                            
                            'isTrigger' => FALSE,
                            'isCoordo' => FALSE,
                            'isTriggerPlus' => FALSE,
                        ]);

                        DB::table('incidents')->where('number', '=', $number)->update([

                            'site_id' => $site_id

                        ]);
                    }
                }
        }

        $new_User_Incident = array();
        $nice = DB::table('users_incidents')->get();
        for ($ni=0; $ni < count($nice); $ni++) {
            array_push($new_User_Incident, $nice[$ni]);
        }

        Session::put('users_incidents', $new_User_Incident);

        return response()->json([1]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function revocation(Request $request)
    {

        $id_user = $request->input('user_id');
        $site_id = $request->input('site');
        $departement_id = $request->input('departement');

        if($site_id){

            DB::table('users_incidents')
            ->where('user_id', '=', intval($id_user))
            ->where('incident_number', '=', $request->number)
            ->delete();

            smilify('success', 'Révocation Du Site Effectué Avec Succèss !');

            return response()->json();
    
        }elseif ($departement_id) {
            
            DB::table('users_incidents')
            ->where('user_id', '=', intval($id_user))
            ->where('incident_number', '=', $request->number)
            ->delete();        
        
            smilify('success', 'Révocation Du Département Effectué Avec Succèss !');

            return response()->json();
    
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function revocation_modification(Request $request){

        $id_user = $request->input('user_id');
        $site_id = $request->input('site');
        $departement_id = $request->input('departement');

        if($site_id){

            DB::table('users_incidents')->where(
                [
                    ['incident_number', '=' , $request->number],
                    ['user_id', '=', intval($id_user)],

                ])->update([

                'isTrigger' => FALSE

            ]);
    
            smilify('success', 'Révocation Du Site Effectué Avec Succèss !');

            return response()->json();
    
    
        }elseif ($departement_id) {
            
            DB::table('users_incidents')->where(
                [
                    ['incident_number', '=' , $request->number],
                    ['user_id', '=', intval($id_user)],

                ])->update([

                'isTrigger' => FALSE

            ]);
        
            smilify('success', 'Révocation Du Département Effectué Avec Succèss !');

            return response()->json();
        
        }
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

    }

    public function generate(){

    }

    public function affectation(Request $request){
        
    }
}
