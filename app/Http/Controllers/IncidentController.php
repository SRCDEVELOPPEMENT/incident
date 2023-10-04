<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Incident;
use App\Models\Categorie;
use App\Models\Pros;
use App\Models\Tache;
use App\Models\User;
use App\Models\Site;
use App\Models\Users_Incident;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Connection;
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
                notify()->info('Liste Des Incidents ! ⚡️', 'Info Incident');

                $years = array();
                $incidents = array();
                $in = $request->in;
                $tasks = array();
                $users = array();
                $processus = array();
                $types = array();
                $sites = array();
                
                $conn = $this->connect();
                $Query = "SELECT * FROM users";
                $stmt = sqlsrv_query( $conn, $Query);
                if ($stmt)
                {while ($row = sqlsrv_fetch_object($stmt)) {
                $url = $row; if($url){array_push($users, $url);}}}

                $taches = Tache::all();

                $categories = Categorie::with('sites')->get();

                $Query = "SELECT * FROM pros";
                $stmt = sqlsrv_query( $conn, $Query);
                if ($stmt)
                {while ($row = sqlsrv_fetch_object($stmt)) {
                $url = $row; if($url){array_push($processus, $url);}}}

                $Query = "SELECT * FROM sites";
                $stmt = sqlsrv_query( $conn, $Query);
                if ($stmt)
                {while ($row = sqlsrv_fetch_object($stmt)) {
                $url = $row; if($url){array_push($sites, $url);}}}

                $Query = "SELECT * FROM types";
                $stmt = sqlsrv_query( $conn, $Query);
                if ($stmt)
                {while ($row = sqlsrv_fetch_object($stmt)) {
                $url = $row; if($url){array_push($types, $url);}}}

                if(
                    (Auth::user()->roles[0]->name == "EMPLOYE")
                ){
                switch ($request->in) {
                    case 1:
                        if(Session::has('times')){
                            $times = 1;
                            Session::put('times', $times);
                        }
        
                        $incidents = Incident::with('categories', 'processus', 'sites')
                        ->where('status', '=', 'ENCOURS')
                        ->where(function($query){
                            $query->where('site_id', '=', Auth::user()->site_id)
                                  ->orWhere('site_declarateur', '=', Auth::user()->site_id);
                        })->get();
                                
                        if(is_iterable($incidents)){
                        for ($i=0; $i < count($incidents); $i++) {
                            $idi = $incidents[$i];

                            $tas = Tache::with('sites')
                            ->where('incident_number', '=', $idi->number)
                            ->get();
                            
                            array_push($tasks, $tas);
                        }}
                        
                        break;
                    default:
                        break;
                }

                }elseif(Auth::user()->roles[0]->name == "COORDONATEUR"){

                    $incidents = Incident::with('categories', 'processus', 'sites')
                    ->join('users_incidents', 'users_incidents.incident_number', '=', 'incidents.number')
                    ->where('users_incidents.user_id', '=', Auth::user()->id)
                    ->where('incidents.status', '=', "ENCOURS")
                    ->get();

                    if(is_iterable($incidents)){
                    for ($i=0; $i < count($incidents); $i++) {
                        $idi = $incidents[$i];

                        $tas = Tache::with('sites')
                        ->where('incident_number', '=', $idi->number)
                        ->get();

                        array_push($tasks, $tas);
                    }}
                }
                elseif (
                    (Auth::user()->roles[0]->name == "ADMINISTRATEUR") ||
                    (Auth::user()->roles[0]->name == "CONTROLLEUR") ||
                    (Auth::user()->roles[0]->name == "SuperAdmin")
                ){
                    switch ($request->in) {
                        case 1:
                            if(Session::has('times')){
                                $times = 1;
                                Session::put('times', $times);
                            }
                    
                            $incidents = Incident::with('categories', 'processus', 'sites')
                            ->where('incidents.status', '=', "ENCOURS")
                            ->get();

                            if(is_iterable($incidents)){
                            for ($i=0; $i < count($incidents); $i++) { 
                                $idi = $incidents[$i];

                                $tas = Tache::with('sites')
                                ->where('incident_number', '=', $idi['number'])
                                ->get();

                                array_push($tasks, $tas);
                            }}
        
                            break;
                        case 2:
                            Session::put('times', $request->times);
                            $subDays = intval($request->times) * 30;
                            $start = Carbon::now()->subDays($subDays);
        
                            break;
                        default:
                            break;
                    }
    
                }

                $annee = Carbon::now()->format('Y');
                for ($m=1; $m < 5; $m++) {
                    array_push($years, intval($annee) - $m+1);
                }

                return view('incidents.index', 
                compact('incidents', 'types', 'processus', 'taches',
                        'categories', 
                        'tasks', 'sites', 'years', 'in', 'users'));
    }

    public function incident_annee_encour($annee){

        $incidents = Incident::with('categories', 'processus', 'sites')->get();

        $incident_annee_encour = array();

        if(is_iterable($incidents)){
            for ($d=0; $d < count($incidents); $d++) {
                $incident_courant = $incidents[$d];
            
                $ann = substr($incident_courant->declaration_date, 0, 4);
    
                if(intval($annee) == intval($ann)){
    
                    if(
                        ($incident_courant->observation_rex != NULL) &&
                        ($incident_courant->deja_pris_en_compte == NULL)){
                        array_push($incident_annee_encour, $incident_courant);
                    }
                }
            }}

        return $incident_annee_encour;
    }

    public function tableau(Request $request){

        $regions = [
            "OUEST",
            "NORD-OUEST",
            "CENTRE",
            "LITTORAL",
            "SUD",
            "ADAMAOUA",
            "EST",
        ];
    
        $janvier_incident = array();
        $fevrier_incident = array();
        $mars_incident = array();
        $avril_incident = array();
        $mai_incident = array();
        $juin_incident = array();
        $juillet_incident = array();
        $aout_incident = array();
        $septembre_incident = array();
        $octobre_incident = array();
        $novembre_incident = array();
        $deccembre_incident = array();
    
        $janvier_total_year = 0;
        $fevrier_total_year = 0;
        $mars_total_year = 0;
        $avril_total_year = 0;
        $mai_total_year = 0;
        $juin_total_year = 0;
        $juillet_total_year = 0;
        $aout_total_year = 0;
        $septembre_total_year = 0;
        $octobre_total_year = 0;
        $novembre_total_year = 0;
        $deccembre_total_year = 0;

        $janvier_total_cloture = 0;
        $fevrier_total_cloture = 0;
        $mars_total_cloture = 0;
        $avril_total_cloture = 0;
        $mai_total_cloture = 0;
        $juin_total_cloture = 0;
        $juillet_total_cloture = 0;
        $aout_total_cloture = 0;
        $septembre_total_cloture = 0;
        $octobre_total_cloture = 0;
        $novembre_total_cloture = 0;
        $deccembre_total_cloture = 0;

        $janvier_total_annuler = 0;
        $fevrier_total_annuler = 0;
        $mars_total_annuler = 0;
        $avril_total_annuler = 0;
        $mai_total_annuler = 0;
        $juin_total_annuler = 0;
        $juillet_total_annuler = 0;
        $aout_total_annuler = 0;
        $septembre_total_annuler = 0;
        $octobre_total_annuler = 0;
        $novembre_total_annuler = 0;
        $deccembre_total_annuler = 0;

        $janvier_total_encours = 0;
        $fevrier_total_encours = 0;
        $mars_total_encours = 0;
        $avril_total_encours = 0;
        $mai_total_encours = 0;
        $juin_total_encours = 0;
        $juillet_total_encours = 0;
        $aout_total_encours = 0;
        $septembre_total_encours = 0;
        $octobre_total_encours = 0;
        $novembre_total_encours = 0;
        $deccembre_total_encours = 0;

        $janvier_total_enretard = 0;
        $fevrier_total_enretard = 0;
        $mars_total_enretard = 0;
        $avril_total_enretard = 0;
        $mai_total_enretard = 0;
        $juin_total_enretard = 0;
        $juillet_total_enretard = 0;
        $aout_total_enretard = 0;
        $septembre_total_enretard = 0;
        $octobre_total_enretard = 0;
        $novembre_total_enretard = 0;
        $deccembre_total_enretard = 0;

        ///////////////////
        $janvier_total = 0;
        $fevrier_total = 0;
        $mars_total = 0;
        $avril_total = 0;
        $mai_total = 0;
        $juin_total = 0;
        $juillet_total = 0;
        $aout_total = 0;
        $septembre_total = 0;
        $octobre_total = 0;
        $novembre_total = 0;
        $deccembre_total = 0;
    
        $janvier_cloture = 0;
        $fevrier_cloture = 0;
        $mars_cloture = 0;
        $avril_cloture = 0;
        $mai_cloture = 0;
        $juin_cloture = 0;
        $juillet_cloture = 0;
        $aout_cloture = 0;
        $septembre_cloture = 0;
        $octobre_cloture = 0;
        $novembre_cloture = 0;
        $deccembre_cloture = 0;
    
        $janvier_annuler = 0;
        $fevrier_annuler = 0;
        $mars_annuler = 0;
        $avril_annuler = 0;
        $mai_annuler = 0;
        $juin_annuler = 0;
        $juillet_annuler = 0;
        $aout_annuler = 0;
        $septembre_annuler = 0;
        $octobre_annuler = 0;
        $novembre_annuler = 0;
        $deccembre_annuler = 0;
    
        $janvier_encours = 0;
        $fevrier_encours = 0;
        $mars_encours = 0;
        $avril_encours = 0;
        $mai_encours = 0;
        $juin_encours = 0;
        $juillet_encours = 0;
        $aout_encours = 0;
        $septembre_encours = 0;
        $octobre_encours = 0;
        $novembre_encours = 0;
        $deccembre_encours = 0;
    
        $janvier_enretard = 0;
        $fevrier_enretard = 0;
        $mars_enretard = 0;
        $avril_enretard = 0;
        $mai_enretard = 0;
        $juin_enretard = 0;
        $juillet_enretard = 0;
        $aout_enretard = 0;
        $septembre_enretard = 0;
        $octobre_enretard = 0;
        $novembre_enretard = 0;
        $deccembre_enretard = 0;
    
        $ouest = 0;
        $nord_ouest = 0;
        $sud_ouest = 0;
        $centre = 0;
        $littoral = 0;
        $extreme_nord = 0;
        $sud = 0;
        $nord = 0;
        $adamaoua = 0;
        $est = 0;

        $inc_ouest = array();
        $inc_nord_ouest = array();
        $inc_sud_ouest = array();
        $inc_centre = array();
        $inc_littoral = array();
        $inc_extreme_nord = array();
        $inc_sud = array();
        $inc_nord = array();
        $inc_adamaoua = array();
        $inc_est = array();
    
        $incidentSites = array();
        $incident_annee_encour = array();
        $incident_direction_generale = array();
        $incidents = array();
        $sites = Site::with('types')->get();

        $annee = Carbon::now()->format('Y');

        $years = array();
        for ($i=1; $i < 5; $i++) {
            array_push($years, intval($annee) - $i+1);
        }
    
        if ((Auth::user()->roles[0]->name == "COORDONATEUR")) {

            $incident_annee_encour = $this->incident_annee_encour($annee);

        }elseif (
                    (Auth::user()->roles[0]->name == "ADMINISTRATEUR") ||
                    (Auth::user()->roles[0]->name == "CONTROLLEUR") ||
                    (Auth::user()->roles[0]->name == "SuperAdmin")
        ){
            $incident_annee_encour = $this->incident_annee_encour($annee);
        }

        if(is_iterable($incident_annee_encour)){
        for ($g=0; $g < count($incident_annee_encour); $g++) {

            $inci = $incident_annee_encour[$g];
            $mois_de_my_incident = intval(substr($inci->created_at, 5, 2));

            switch ($mois_de_my_incident) {
                case 1:
                    
                    $janvier_total_year +=1;

                    if($inci->status == "CLÔTURÉ"){
                        $janvier_total_cloture +=1;
                    }elseif($inci->status == "ENCOURS"){
                        $janvier_total_encours +=1;
                    }elseif ($inci->status == "ANNULÉ") {
                        $janvier_total_annuler +=1;
                    }
                    
                    if($inci->due_date){
                        if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $janvier_total_enretard +=1;
                        }
                    }

                    break;
                case 2:
                    
                    $fevrier_total_year +=1;

                    if($inci->status == "CLÔTURÉ"){
                        $fevrier_total_cloture +=1;
                    }elseif($inci->status == "ENCOURS"){
                        $fevrier_total_encours +=1;
                    }elseif ($inci->status == "ANNULÉ") {
                        $fevrier_total_annuler +=1;
                    }
                    
                    if($inci->due_date){
                        if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $fevrier_total_enretard +=1;
                        }
                    }

                    break;
                case 3:
                    
                    $mars_total_year +=1;

                    if($inci->status == "CLÔTURÉ"){
                        $mars_total_cloture +=1;
                    }elseif($inci->status == "ENCOURS"){
                        $mars_total_encours +=1;
                    }elseif ($inci->status == "ANNULÉ") {
                        $mars_total_annuler +=1;
                    }
                    
                    if($inci->due_date){
                        if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $mars_total_enretard +=1;
                        }
                    }

                    break;
                case 4:
                    
                    $avril_total_year +=1;

                    if($inci->status == "CLÔTURÉ"){
                        $avril_total_cloture +=1;
                    }elseif($inci->status == "ENCOURS"){
                        $avril_total_encours +=1;
                    }elseif ($inci->status == "ANNULÉ") {
                        $avril_total_annuler +=1;
                    }
                    
                    if($inci->due_date){
                        if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $avril_total_enretard +=1;
                        }
                    }

                    break;
                case 5:
                    
                    $mai_total_year +=1;

                    if($inci->status == "CLÔTURÉ"){
                        $mai_total_cloture +=1;
                    }elseif($inci->status == "ENCOURS"){
                        $mai_total_encours +=1;
                    }elseif ($inci->status == "ANNULÉ") {
                        $mai_total_annuler +=1;
                    }
                    
                    if($inci->due_date){
                        if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $mai_total_enretard +=1;
                        }
                    }

                    break;
                case 6:
                    
                    $juin_total_year +=1;

                    if($inci->status == "CLÔTURÉ"){
                        $juin_total_cloture +=1;
                    }elseif($inci->status == "ENCOURS"){
                        $juin_total_encours +=1;
                    }elseif ($inci->status == "ANNULÉ") {
                        $juin_total_annuler +=1;
                    }
                    
                    if($inci->due_date){
                        if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $juin_total_enretard +=1;
                        }
                    }

                    break;
                case 7:
                    
                    $juillet_total_year +=1;

                    if($inci->status == "CLÔTURÉ"){
                        $juillet_total_cloture +=1;
                    }elseif($inci->status == "ENCOURS"){
                        $juillet_total_encours +=1;
                    }elseif ($inci->status == "ANNULÉ") {
                        $juillet_total_annuler +=1;
                    }
                    
                    if($inci->due_date){
                        if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $juillet_total_enretard +=1;
                        }
                    }

                    break;
                case 8:
                    
                    $aout_total_year +=1;

                    if($inci->status == "CLÔTURÉ"){
                        $aout_total_cloture +=1;
                    }elseif($inci->status == "ENCOURS"){
                        $aout_total_encours +=1;
                    }elseif ($inci->status == "ANNULÉ") {
                        $aout_total_annuler +=1;
                    }
                    
                    if($inci->due_date){
                        if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $aout_total_enretard +=1;
                        }
                    }

                    break;
                case 9:
                    
                    $septembre_total_year +=1;

                    if($inci->status == "CLÔTURÉ"){
                        $septembre_total_cloture +=1;
                    }elseif($inci->status == "ENCOURS"){
                        $septembre_total_encours +=1;
                    }elseif ($inci->status == "ANNULÉ") {
                        $septembre_total_annuler +=1;
                    }
                    
                    if($inci->due_date){
                        if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $septembre_total_enretard +=1;
                        }
                    }

                    break;
                case 10:
                    
                    $octobre_total_year +=1;

                    if($inci->status == "CLÔTURÉ"){
                        $octobre_total_cloture +=1;
                    }elseif($inci->status == "ENCOURS"){
                        $octobre_total_encours +=1;
                    }elseif ($inci->status == "ANNULÉ") {
                        $octobre_total_annuler +=1;
                    }
                    
                    if($inci->due_date){
                        if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $octobre_total_enretard +=1;
                        }
                    }

                    break;
                case 11:
                    
                    $novembre_total_year +=1;

                    if($inci->status == "CLÔTURÉ"){
                        $novembre_total_cloture +=1;
                    }elseif($inci->status == "ENCOURS"){
                        $novembre_total_encours +=1;
                    }elseif ($inci->status == "ANNULÉ") {
                        $novembre_total_annuler +=1;
                    }
                    
                    if($inci->due_date){
                        if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $novembre_total_enretard +=1;
                        }
                    }

                    break;
                case 12:
                    
                    $deccembre_total_year +=1;

                    if($inci->status == "CLÔTURÉ"){
                        $deccembre_total_cloture +=1;
                    }elseif($inci->status == "ENCOURS"){
                        $deccembre_total_encours +=1;
                    }elseif ($inci->status == "ANNULÉ") {
                        $deccembre_total_annuler +=1;
                    }
                    
                    if($inci->due_date){
                        if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $deccembre_total_enretard +=1;
                        }
                    }

                    break;

                default:
                    break;
            }

            if($inci->site_id){
                switch ($inci->sites->region) {
                    case 'OUEST':
                        $ouest +=1;
                        array_push($inc_ouest, $inci);
                        break;
                    case 'NORD-OUEST':
                        $nord_ouest +=1;
                        array_push($inc_nord_ouest, $inci);
                        break;
                    case 'SUD-OUEST':
                        $sud_ouest +=1;
                        array_push($inc_sud_ouest, $inci);
                        break;
                    case 'CENTRE':
                        $centre +=1;
                        array_push($inc_centre, $inci);
                        break;
                    case 'LITTORAL':
                        $littoral +=1;
                        array_push($inc_littoral, $inci);
                        break;
                    case 'EXTREME-NORD':
                        $extreme_nord +=1;
                        array_push($inc_extreme_nord, $inci);
                        break;
                    case 'SUD':
                        $sud +=1;
                        array_push($inc_sud, $inci);
                        break;
                    case 'NORD':
                        $nord +=1;
                        array_push($inc_nord, $inci);
                        break;
                    case 'ADAMAOUA':
                        $adamaoua +=1;
                        array_push($inc_adamaoua, $inci);
                        break;
                    case 'EST':
                        $est +=1;
                        array_push($inc_est, $inci);
                        break;
    
                    default:
                        break;
                }
            }else{
                $littoral +=1;
                array_push($inc_littoral, $inci);
            }
        }}
    
        if(is_iterable($incident_annee_encour)){
        for ($p=0; $p < count($incident_annee_encour); $p++) {

            $probleme = $incident_annee_encour[$p];
    
            if($probleme->site_id == NULL){
                if($probleme->categories){
                if($probleme->categories->departement_id != NULL){
                    array_push($incident_direction_generale, $probleme);
                }}
            }
            
        }}
    
        if(is_iterable($incident_direction_generale)){
        for ($c=0; $c < count($incident_direction_generale); $c++) {
            $incid = $incident_direction_generale[$c];
    
            $mois = substr($incid->created_at, 5, 2);
    
            switch ($mois) {
                case '01':
                    $janvier_total +=1;
    
                    array_push($janvier_incident, $incid);
    
                    if($incid->status == "CLÔTURÉ"){
                        $janvier_cloture +=1;
                    }elseif($incid->status == "ENCOURS"){
                        $janvier_encours +=1;
                    }elseif ($incid->status == "ANNULÉ") {
                        $janvier_annuler +=1;
                    }
                    
                    if($incid->due_date){
                        if(intval(str_replace("-", "", $incid->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $janvier_enretard +=1;
                        }
                    }
                    break;
                case '02':
                    $fevrier_total +=1;
    
                    array_push($fevrier_incident, $incid);
    
                    if($incid->status == "CLÔTURÉ"){
                        $fevrier_cloture +=1;
                    }elseif($incid->status == "ENCOURS"){
                        $fevrier_encours +=1;
                    }elseif ($incid->status == "ANNULÉ") {
                        $fevrier_annuler +=1;
                    }
    
                    if($incid->due_date){
                        if(intval(str_replace("-", "", $incid->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $fevrier_enretard +=1;
                        }    
                    }
                    break;
                case '03':
                    $mars_total +=1;
    
                    array_push($mars_incident, $incid);
    
                    if($incid->status == "CLÔTURÉ"){
                        $mars_cloture +=1;
                    }elseif($incid->status == "ENCOURS"){
                        $mars_encours +=1;
                    }elseif ($incid->status == "ANNULÉ") {
                        $mars_annuler +=1;
                    }
    
                    if($incid->due_date){
                        if(intval(str_replace("-", "", $incid->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $mars_enretard +=1;
                        }    
                    }
                    break;
                case '04':
                    $avril_total +=1;
    
                    array_push($avril_incident, $incid);
    
                    if($incid->status == "CLÔTURÉ"){
                        $avril_cloture +=1;
                    }elseif($incid->status == "ENCOURS"){
                        $avril_encours +=1;
                    }elseif ($incid->status == "ANNULÉ") {
                        $avril_annuler +=1;
                    }
    
                    if($incid->due_date){
                        if(intval(str_replace("-", "", $incid->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $avril_enretard +=1;
                        }    
                    }
                    break;
                case '05':
                    $mai_total +=1;
    
                    array_push($mai_incident, $incid);
    
                    if($incid->status == "CLÔTURÉ"){
                        $mai_cloture +=1;
                    }elseif($incid->status == "ENCOURS"){
                        $mai_encours +=1;
                    }elseif ($incid->status == "ANNULÉ") {
                        
                    }
    
                    if($incid->due_date){
                        if(intval(str_replace("-", "", $incid->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $mai_enretard +=1;
                        }    
                    }
                    break;
                case '06':
                    $juin_total +=1;
    
                    array_push($juin_incident, $incid);
    
                    if($incid->status == "CLÔTURÉ"){
                        $juin_cloture +=1;
                    }elseif($incid->status == "ENCOURS"){
                        $juin_encours +=1;
                    }elseif ($incid->status == "ANNULÉ") {
                        $juin_annuler +=1;
                    }
    
                    if($incid->due_date){
                        if(intval(str_replace("-", "", $incid->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $juin_enretard +=1;
                        }    
                    }
                    break;
                case '07':
                    $juillet_total +=1;
    
                    array_push($juillet_incident, $incid);
    
                    if($incid->status == "CLÔTURÉ"){
                        $juillet_cloture +=1;
                    }elseif($incid->status == "ENCOURS"){
                        $juillet_encours +=1;
                    }elseif ($incid->status == "ANNULÉ") {
                        $juillet_annuler +=1;
                    }
    
                    if($incid->due_date){
                        if(intval(str_replace("-", "", $incid->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $juillet_enretard +=1;
                        }    
                    }
                    break;
                case '08':
                    $aout_total +=1;
    
                    array_push($aout_incident, $incid);
                    
                    if($incid->status == "CLÔTURÉ"){
                        $aout_cloture +=1;
                    }elseif($incid->status == "ENCOURS"){
                        $aout_encours +=1;
                    }elseif ($incid->status == "ANNULÉ") {
                        $aout_annuler +=1;
                    }
    
                    if($incid->due_date){
                        if(intval(str_replace("-", "", $incid->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $aout_enretard +=1;
                        }    
                    }
                    break;
                case '09':
                    $septembre_total +=1;
    
                    array_push($septembre_incident, $incid);
    
                    if($incid->status == "CLÔTURÉ"){
                        $septembre_cloture +=1;
                    }elseif($incid->status == "ENCOURS"){
                        $septembre_encours +=1;
                    }elseif ($incid->status == "ANNULÉ") {
                        $septembre_annuler +=1;
                    }
    
                    if($incid->due_date){
                        if(intval(str_replace("-", "", $incid->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $septembre_enretard +=1;
                        }    
                    }
                    break;
                case '10':
                    $octobre_total +=1;
    
                    array_push($octobre_incident, $incid);
    
                    if($incid->status == "CLÔTURÉ"){
                        $octobre_cloture +=1;
                    }elseif($incid->status == "ENCOURS"){
                        $octobre_encours +=1;
                    }elseif ($incid->status == "ANNULÉ") {
                        $octobre_annuler +=1;
                    }
    
                    if($incid->due_date){
                        if(intval(str_replace("-", "", $incid->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $octobre_enretard +=1;
                        }    
                    }
                    break;
                case '11':
                    $novembre_total +=1;
    
                    array_push($novembre_incident, $incid);
    
                    if($incid->status == "CLÔTURÉ"){
                        $novembre_cloture +=1;
                    }elseif($incid->status == "ENCOURS"){
                        $novembre_encours +=1;
                    }elseif ($incid->status == "ANNULÉ") {
                        $novembre_annuler +=1;
                    }
    
                    if($incid->due_date){
                        if(intval(str_replace("-", "", $incid->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $novembre_enretard +=1;
                        }    
                    }
                    break;
                case '12':
                    $deccembre_total +=1;
    
                    array_push($deccembre_incident, $incid);
    
                    if($incid->status == "CLÔTURÉ"){
                        $deccembre_cloture +=1;
                    }elseif($incid->status == "ENCOURS"){
                        $deccembre_encours +=1;
                    }elseif ($incid->status == "ANNULÉ") {
                        $deccembre_annuler +=1;
                    }
    
                    if($incid->due_date){
                        if(intval(str_replace("-", "", $incid->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $deccembre_enretard +=1;
                        }    
                    }
                    break;
                default:
                    break;
            }
        }}

        if(is_iterable($sites)){
            for ($z=0; $z < count($sites); $z++) {
                $siteCourant = $sites[$z];
        
                $incidentDunSite = array();
        
                if(is_iterable($incident_annee_encour)){
                    for ($b=0; $b < count($incident_annee_encour); $b++) {
                        $incident = $incident_annee_encour[$b];
            
                        if($incident->site_id){
                            if($incident->site_id == $siteCourant->id){
                                array_push($incidentDunSite, $incident);
                            }
                        }
                    }
            }
        
            array_push($incidentSites, $incidentDunSite);
        }}
        
        return view('incidents.tableau_statistique', [

            'sites' => $sites,
            'janvier_total_year' => $janvier_total_year,
            'fevrier_total_year' => $fevrier_total_year,
            'mars_total_year' => $mars_total_year,
            'avril_total_year' => $avril_total_year,
            'mai_total_year' => $mai_total_year,
            'juin_total_year' => $juin_total_year,
            'juillet_total_year' => $juillet_total_year,
            'aout_total_year' => $aout_total_year,
            'septembre_total_year' => $septembre_total_year,
            'octobre_total_year' => $octobre_total_year,
            'novembre_total_year' => $novembre_total_year,
            'deccembre_total_year' => $deccembre_total_year,

            'janvier_total_cloture' => $janvier_total_cloture,
            'fevrier_total_cloture' => $fevrier_total_cloture,
            'mars_total_cloture' => $mars_total_cloture,
            'avril_total_cloture' => $avril_total_cloture,
            'mai_total_cloture' => $mai_total_cloture,
            'juin_total_cloture' => $juin_total_cloture,
            'juillet_total_cloture' => $juillet_total_cloture,
            'aout_total_cloture' => $aout_total_cloture,
            'septembre_total_cloture' => $septembre_total_cloture,
            'octobre_total_cloture' => $octobre_total_cloture,
            'novembre_total_cloture' => $novembre_total_cloture,
            'deccembre_total_cloture' => $deccembre_total_cloture,
    
            'janvier_total_annuler' => $janvier_total_annuler,
            'fevrier_total_annuler' => $fevrier_total_annuler,
            'mars_total_annuler' => $mars_total_annuler,
            'avril_total_annuler' => $avril_total_annuler,
            'mai_total_annuler' => $mai_total_annuler,
            'juin_total_annuler' => $juin_total_annuler,
            'juillet_total_annuler' => $juillet_total_annuler,
            'aout_total_annuler' => $aout_total_annuler,
            'septembre_total_annuler' => $septembre_total_annuler,
            'octobre_total_annuler' => $octobre_total_annuler,
            'novembre_total_annuler' => $novembre_total_annuler,
            'deccembre_total_annuler' => $deccembre_total_annuler,

            'janvier_total_encours' => $janvier_total_encours,
            'fevrier_total_encours' => $fevrier_total_encours,
            'mars_total_encours' => $mars_total_encours,
            'avril_total_encours' => $avril_total_encours,
            'mai_total_encours' => $mai_total_encours,
            'juin_total_encours' => $juin_total_encours,
            'juillet_total_encours' => $juillet_total_encours,
            'aout_total_encours' => $aout_total_encours,
            'septembre_total_encours' => $septembre_total_encours,
            'octobre_total_encours' => $octobre_total_encours,
            'novembre_total_encours' => $novembre_total_encours,
            'deccembre_total_encours' => $deccembre_total_encours,

            'janvier_total_enretard' => $janvier_total_enretard,
            'fevrier_total_enretard' => $fevrier_total_enretard,
            'mars_total_enretard' => $mars_total_enretard,
            'avril_total_enretard' => $avril_total_enretard,
            'mai_total_enretard' => $mai_total_enretard,
            'juin_total_enretard' => $juin_total_enretard,
            'juillet_total_enretard' => $juillet_total_enretard,
            'aout_total_enretard' => $aout_total_enretard,
            'septembre_total_enretard' => $septembre_total_enretard,
            'octobre_total_enretard' => $octobre_total_enretard,
            'novembre_total_enretard' => $novembre_total_enretard,
            'deccembre_total_enretard' => $deccembre_total_enretard,
        
            'regions' => $regions,
            'ouest' => $ouest,
            'nord_ouest' => $nord_ouest,
            'sud_ouest' => $sud_ouest,
            'centre' => $centre,
            'littoral' => $littoral,
            'extreme_nord' => $extreme_nord,
            'sud' => $sud,
            'nord' => $nord,
            'adamaoua' => $adamaoua,
            'est' => $est,
    
            'inc_ouest' => $inc_ouest,
            'inc_nord_ouest' => $inc_nord_ouest,
            'inc_sud_ouest' => $inc_sud_ouest,
            'inc_centre' => $inc_centre,
            'inc_littoral' => $inc_littoral,
            'inc_extreme_nord' => $inc_extreme_nord,
            'inc_sud' => $inc_sud,
            'inc_nord' => $inc_nord,
            'inc_adamaoua' => $inc_adamaoua,
            'inc_est' => $inc_est,
    
            'years' => $years,
            'incidentSites' => $incidentSites,
            'incidents' => $incident_annee_encour,

            'janvier_total' =>  $janvier_total,
            'fevrier_total' => $fevrier_total,
            'mars_total' => $mars_total,
            'avril_total' => $avril_total,
            'mai_total' => $mai_total,
            'juin_total' => $juin_total,
            'juillet_total' => $juillet_total,
            'aout_total' => $aout_total,
            'septembre_total' => $septembre_total,
            'octobre_total' => $octobre_total,
            'novembre_total' => $novembre_total,
            'deccembre_total' => $deccembre_total,
    
            'janvier_cloture' =>  $janvier_cloture,
            'fevrier_cloture' => $fevrier_cloture,
            'mars_cloture' => $mars_cloture,
            'avril_cloture' => $avril_cloture,
            'mai_cloture' => $mai_cloture,
            'juin_cloture' => $juin_cloture,
            'juillet_cloture' => $juillet_cloture,
            'aout_cloture' => $aout_cloture,
            'septembre_cloture' => $septembre_cloture,
            'octobre_cloture' => $octobre_cloture,
            'novembre_cloture' => $novembre_cloture,
            'deccembre_cloture' => $deccembre_cloture,
        
            'janvier_annuler' => $janvier_annuler,
            'fevrier_annuler' => $fevrier_annuler,
            'mars_annuler' => $mars_annuler,
            'avril_annuler' => $avril_annuler,
            'mai_annuler' => $mai_annuler,
            'juin_annuler' => $juin_annuler,
            'juillet_annuler' => $juillet_annuler,
            'aout_annuler' => $aout_annuler,
            'septembre_annuler' => $septembre_annuler,
            'octobre_annuler' => $octobre_annuler,
            'novembre_annuler' => $novembre_annuler,
            'deccembre_annuler' => $deccembre_annuler,
        
            'janvier_encours' => $janvier_encours,
            'fevrier_encours' => $fevrier_encours,
            'mars_encours' => $mars_encours,
            'avril_encours' => $avril_encours,
            'mai_encours' => $mai_encours,
            'juin_encours' => $juin_encours,
            'juillet_encours' => $juillet_encours,
            'aout_encours' => $aout_encours,
            'septembre_encours' => $septembre_encours,
            'octobre_encours' => $octobre_encours,
            'novembre_encours' => $novembre_encours,
            'deccembre_encours' => $deccembre_encours,
        
            'janvier_enretard' => $janvier_enretard,
            'fevrier_enretard' => $fevrier_enretard,
            'mars_enretard' => $mars_enretard,
            'avril_enretard' => $avril_enretard,
            'mai_enretard' => $mai_enretard,
            'juin_enretard' => $juin_enretard,
            'juillet_enretard' => $juillet_enretard,
            'aout_enretard' => $aout_enretard,
            'septembre_enretard' => $septembre_enretard,
            'octobre_enretard' => $octobre_enretard,
            'novembre_enretard' => $novembre_enretard,
            'deccembre_enretard' => $deccembre_enretard,
            
            'janvier_incident' => $janvier_incident,
            'fevrier_incident' => $fevrier_incident,
            'mars_incident' => $mars_incident,
            'avril_incident' => $avril_incident,
            'mai_incident' => $mai_incident,
            'juin_incident' => $juin_incident,
            'juillet_incident' => $juillet_incident,
            'aout_incident' => $aout_incident,
            'septembre_incident' => $septembre_incident,
            'octobre_incident' => $octobre_incident,
            'novembre_incident' => $novembre_incident,
            'deccembre_incident' => $deccembre_incident,
    
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function archive(Request $request)
    {
        notify()->info('Liste Des Incidents Archivés ! ⚡️', 'Info Incident');
       
        $users = array();
        $sites = array();
        $years = array();
        $tasks = array();
        $taches = array();
        $categories = array();

        $conn = $this->connect();
        $Query = "SELECT * FROM categories";
        $stmt = sqlsrv_query( $conn, $Query);
        if ($stmt)
        {while ($row = sqlsrv_fetch_object($stmt)) {
        $url = $row; if($url){array_push($categories, $url);}}}

        $Query = "SELECT * FROM sites";
        $stmt = sqlsrv_query( $conn, $Query);
        if ($stmt)
        {while ($row = sqlsrv_fetch_object($stmt)) {
        $url = $row; if($url){array_push($sites, $url);}}}

        $Query = "SELECT * FROM users";
        $stmt = sqlsrv_query( $conn, $Query);
        if ($stmt)
        {while ($row = sqlsrv_fetch_object($stmt)) {
        $url = $row; if($url){array_push($users, $url);}}}

        $Query = "SELECT * FROM taches";
        $stmt = sqlsrv_query( $conn, $Query);
        if ($stmt)
        {while ($row = sqlsrv_fetch_object($stmt)) {
        $url = $row; if($url){array_push($taches, $url);}}}

        if(
            (Auth::user()->roles[0]->name == "EMPLOYE")
        ){

        switch ($request->arc) {
            case 1:
                if(Session::has('times')){
                    $times = 1;
                    Session::put('times', $times);
                }
        
                $incidents = Incident::with('categories', 'processus', 'sites')
                ->where('status', '=', 'CLÔTURÉ')
                ->where(function($query){
                    $query->where('site_id', '=', Auth::user()->site_id)
                          ->orWhere('site_declarateur', '=', Auth::user()->site_id);
                })->get();
                
                if(is_iterable($incidents)){
                for ($i=0; $i < count($incidents); $i++) {
                    $idi = $incidents[$i];

                    $tas = Tache::with('sites')
                    ->where('incident_number', '=', $idi->number)
                    ->count();

                    array_push($tasks, $tas);
                }}
                
                break;
            case 2:
                Session::put('times', $request->times);
                $subDays = intval($request->times) * 10;
                $start = Carbon::now()->subDays($subDays);

                break;
            default:
                break;
        }

        }elseif ((Auth::user()->roles[0]->name == "COORDONATEUR")) {

            switch ($request->arc) {
                case 1:
                    if(Session::has('times')){
                        $times = 1;
                        Session::put('times', $times);
                    }

                $incidents = Incident::with('categories', 'processus', 'sites')
                ->join('users_incidents', 'users_incidents.incident_number', '=', 'incidents.number')
                ->where('users_incidents.user_id', '=', Auth::user()->id)
                ->where('incidents.status', '=', "CLÔTURÉ")
                ->orWhere('incidents.status', '=', "ANNULÉ")
                ->get();

                
                if(is_iterable($incidents)){
                for ($i=0; $i < count($incidents); $i++) {
                    $idi = $incidents[$i];
                        
                    $tas = Tache::with('sites')
                    ->where('incident_number', '=', $idi['number'])
                    ->count();

                    array_push($tasks, $tas);
                }}
                        break;
                case 2:
                    Session::put('times', $request->times);
                    $subDays = intval($request->times) * 10;
                    
                    $start = Carbon::now()->subDays($subDays);

                    break;

                default:
                    break;
            }
        }elseif (
            (Auth::user()->roles[0]->name == "ADMINISTRATEUR") ||
            (Auth::user()->roles[0]->name == "CONTROLLEUR") ||
            (Auth::user()->roles[0]->name == "SuperAdmin")
        ){
            switch ($request->arc) {
                case 1:
                    if(Session::has('times')){
                        $times = 1;
                        Session::put('times', $times);
                    }
            
                    $incidents = Incident::with('categories', 'processus', 'sites')
                    ->where('incidents.status', '=', "CLÔTURÉ")
                    ->orWhere('incidents.status', '=', "ANNULÉ")
                    ->get();
                    
                    if(is_iterable($incidents)){
                    for ($i=0; $i < count($incidents); $i++) { 
                        $idi = $incidents[$i];

                        $tas = Tache::with('sites')
                        ->where('incident_number', '=', $idi['number'])
                        ->get();

                        array_push($tasks, $tas);
                    }}

                    break;
                case 2:
                    Session::put('times', $request->times);
                    $subDays = intval($request->times) * 30;
                    $start = Carbon::now()->subDays($subDays);

                    for ($t=0; $t < $subDays; $t++) {

                        $date_courant = $start->addDays(1)->format('Y-m-d');
                        $problems = Incident::with('categories', 'processus', 'sites')
                        ->where('created_at', '=', $date_courant)
                        ->get();
                        
                        for ($ju=0; $ju < count($problems); $ju++) {
                            $inci = $problems[$ju];

                            if(
                                ($inci->status != "ANNULÉ" && $inci->status != "CLÔTURÉ")
                            ){
                                array_push($incidents, $inci);
                            }
                
                        }
                    }

                    break;
                default:
                    break;
            }

        }


        $annee = Carbon::now()->format('Y');
    
        for ($i=1; $i < 5; $i++) {
            array_push($years, intval($annee) - $i+1);
        }
    
        return view('incidents.archive',
            compact('incidents', 'years', 'tasks', 
                    'taches', 'categories', 'sites', 
                    'users'));
    }

    public function get_un_incident(Request $request){

        $incident = Incident::with('categories', 'processus', 'sites')->where('number', '=', $request->number)->get()->first();

        return response()->json($incident);
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
            'valeur' => $request->valeur ? intval($request->valeur) : NULL,
            'comment' => $request->comment ? $request->comment : NULL,
            'archiver' => TRUE,
        ]);
        

        smilify('success', 'Incident Clôturé Avec Succèss !');
        
        return response()->json([1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setCategorieIncident(Request $request){
        
        DB::table('incidents')->where('number', $request->number)->update([

            'categorie_id' => $request->categorie
        ]);
        
        smilify('success', 'Incident Assigner A Un Département Avec Succèss !');
        
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
        
        notify()->success('Date D\'échéance De L\'Incident Définis Avec Succèss ! ⚡️');

        return response()->json([1]);
    }


    public function generateUniqueCode()
    {
        $incidents = Incident::get();
        $code;

        if(count($incidents) > 0){
            $tab = array();
        
            if(is_iterable($incidents)){
            for ($i=0; $i < count($incidents); $i++) {
                $incident = $incidents[$i];
                array_push($tab, intval(substr($incident->number, 3)));
            }}

            $value = max($tab);

            $code = "INC". ($value+1);

        }else{
            $code = "INC". "0";
        }

        return $code;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setArchive(Request $request){

        DB::table('incidents')->where('number', '=', $request->number)->update([
            'archiver' => 1,
        ]);

        notify()->success('Incident Archivé Avec Succèss ! ⚡️');

        return response()->json();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setDesarchive(Request $request){

        DB::table('incidents')->where('number', '=', $request->number)->update([
            'archiver' => 0,
        ]);

        notify()->success('Incident Désarchivé Avec Succèss ! ⚡️');

        return response()->json();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setRestoration(Request $request){

        DB::table('incidents')->where('number', '=', $request->number)->update([

            'status' => "ENCOURS",
            'motif_annulation' => NULL,

        ]);


        notify()->success('Incident Désarchivé Avec Succèss ! ⚡️');

        return response()->json();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function incident_encompte(Request $request){

        DB::table('incidents')->where('number', '=', $request->number)->update([

            'status' => "CLÔTURÉ",
            'archiver' => TRUE,
            'due_date' => Carbon::now()->format('Y-m-d'),
            'closure_date' => Carbon::now()->format('Y-m-d'),
            'observation_rex' => $request->observation,
            'deja_pris_en_compte' => TRUE,
            'comment' => "Incident Pris En Compte ( Déja Déclaré Par Un Autre Site )"
        ]);

        return response()->json([1]);
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

            $doublon = DB::table('incidents')->where('description', '=', $incident_tasks['description'])->get()->first();
            if(!$doublon){
            $usings = NULL;
            $users = User::with('sites')->get();
            $number = $this->generateUniqueCode();

            DB::table('incidents')->insert(
                [
                'archiver' => 0,
                'fullname_declarateur' => $incident_tasks['fullname'],
                'due_date' => $incident_tasks['due_date'],
                'observation' => $incident_tasks['observation'] ? $incident_tasks['observation'] : NULL,
                'categorie_id' => $incident_tasks['categorie'],
                'battles' => $incident_tasks['battles'] ? $incident_tasks['battles'] : NULL,
                'perimeter' => $incident_tasks['perimeter'] ? $incident_tasks['perimeter'] : NULL,
                'description' => $incident_tasks['description'],
                'status' => "ENCOURS",
                'cause' => $incident_tasks['cause'],
                'proces_id' => $incident_tasks['processus_id'][0] ? intval($incident_tasks['processus_id'][0]) : (intval($incident_tasks['processus_id'][1]) ? intval($incident_tasks['processus_id'][1]) : NULL),
                'priority' => $incident_tasks['priority'],
                'number' => $number,
                'created_at' => Carbon::now()->format('Y-m-d'),
                'declaration_date' => Carbon::now()->format('Y-m-d'),
                'site_declarateur' => intval(Auth::user()->site_id),
                'site_id' => intval($request->domaine),
                'site_incident' => intval($incident_tasks['site_incident']),
                'observation_rex' => 'Incident Assigné Avec Succèss !'
                ]
            );

            if(is_iterable($users)){
            for ($dr=0; $dr < count($users); $dr++) {
                $usi = $users[$dr];
                if($usi->site_id){
                    if(intval($usi->site_id) == intval(Auth::user()->site_id)){
                            $usings = $usi;
                    }
                }
            }}

            if((Auth::user()->roles[0]->name == "EMPLOYE") ||
               (Auth::user()->roles[0]->name == "COORDONATEUR") ||
               (Auth::user()->roles[0]->name == "CONTROLLEUR")){
                
                if(intval(Auth::user()->site_id) == intval($request->domaine)){
                    DB::table('users_incidents')->insert([
                        'created_at' => Carbon::now()->format('Y-m-d'),
                        'incident_number' => $number,
                        'user_id' => Auth::user()->id,
                        'isCoordo' => TRUE,
                        'isDeclar' => TRUE,
                        'isTrigger' => TRUE,
                    ]);
                }else{

                    $users_assigneur = NULL;
                    if(is_iterable($users)){
                    for ($dr=0; $dr < count($users); $dr++) {
                        $usi = $users[$dr];
                        if($usi->site_id){
                        if(intval($usi->site_id) == intval($request->domaine)){
                            $users_assigneur = $usi;
                            }
                        }
                    }}

                    DB::table('users_incidents')->insert([
                        'created_at' => Carbon::now()->format('Y-m-d'),
                        'incident_number' => $number,
                        'user_id' => Auth::user()->id,
                        'isCoordo' => TRUE,
                        'isDeclar' => TRUE,
                        'isTrigger' => TRUE,
                    ]);

                    if($users_assigneur){
                    DB::table('users_incidents')->insert([
                        'created_at' => Carbon::now()->format('Y-m-d'),
                        'incident_number' => $number,
                        'user_id' => $users_assigneur->id,
                        'isTrigger' => FALSE,
                        'isCoordo' => FALSE,
                    ]);
                    }
                }
                    
                $responsable_user_logger = NULL;
                if(Auth::user()->responsable){
                    if(is_iterable($users)){
                    for ($to=0; $to < count($users); $to++) {
                        $ux = $users[$to];
                        
                        if(intval($ux->id) == intval(Auth::user()->responsable)){
                            $responsable_user_logger = $ux;
                        }
                    }}
                }

                if($responsable_user_logger){
                    if($responsable_user_logger->roles[0]->name == "COORDONATEUR"){
                            
                        DB::table('users_incidents')->insert([
                            'created_at' => Carbon::now()->format('Y-m-d'),
                            'incident_number' => $number,
                            'user_id' => $responsable_user_logger->id,
                            'isCoordo' => TRUE,
                            'isDeclar' => TRUE,
                            'isTrigger' => TRUE,
                        ]);
                    }
                }

            }
            }else{
                return response()->json([1, 0]);
            }
            return response()->json([1]);
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

        $all_tasks = DB::table('taches')->where('incident_number', '=', $request->number)->get();

        if(is_iterable($all_tasks)){
        for ($fb=0; $fb < count($all_tasks); $fb++) {
            $ta = $all_tasks[$fb];
            DB::table('logtaches')->where('tache_id', '=', $ta->id)->delete();
        }}

        if(is_iterable($all_tasks)){
        for ($sc=0; $sc < count($all_tasks); $sc++) {
            $ach = $all_tasks[$sc];
            DB::table('taches')->where('id', '=', $ach->id)->delete();
        }}

        DB::table('users_incidents')->where('incident_number', '=', $request->number)->delete();

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
            $users = User::with('sites')->get();

            DB::table('incidents')->where('number', $request->number)->update([
                'fullname_declarateur' => $request->fullname,
                'site_id' => intval($request->esperanceEdit),
                'observation' => $request->observation ? $request->observation : NULL,
                'due_date' => $request->due_date ? $request->due_date : NULL,
                'battles' => $request->battles ? $request->battles : NULL,
                'description' => $request->description,
                'cause' => $request->cause,
                'perimeter'=> $request->perimeter ? $request->perimeter : NULL,
                'categorie_id' => $request->categorie_id ? intval($request->input('categorie_id')) : NULL,
                'proces_id' => $request->processus_id,
                'priority' => $request->priority,
                'site_incident' => intval($request->site_incident),
            ]);
            
            DB::table('users_incidents')
            ->where('incident_number', '=', $request->number)
            ->delete();

            if(intval(Auth::user()->site_id) == intval($request->input('esperanceEdit'))){
                DB::table('users_incidents')->insert([
                    'created_at' => Carbon::now()->format('Y-m-d'),
                    'incident_number' => $request->number,
                    'user_id' => Auth::user()->id,
                    'isCoordo' => TRUE,
                    'isDeclar' => TRUE,
                    'isTrigger' => TRUE,
                ]);
            }else{

                $users_assigneur = NULL;
                if(is_iterable($users)){
                for ($dr=0; $dr < count($users); $dr++) {
                    $usi = $users[$dr];
                    if($usi->site_id){
                    if(intval($usi->site_id) == intval($request->input('esperanceEdit'))){
                        $users_assigneur = $usi;
                        }
                    }
                }}

                DB::table('users_incidents')->insert([
                    'created_at' => Carbon::now()->format('Y-m-d'),
                    'incident_number' => $request->number,
                    'user_id' => Auth::user()->id,
                    'isCoordo' => TRUE,
                    'isDeclar' => TRUE,
                    'isTrigger' => TRUE,
                ]);

                if($users_assigneur){
                DB::table('users_incidents')->insert([
                    'created_at' => Carbon::now()->format('Y-m-d'),
                    'incident_number' => $request->number,
                    'user_id' => $users_assigneur->id,
                    'isTrigger' => FALSE,
                    'isCoordo' => FALSE,
                ]);}
            }
                
            $responsable_user_logger = NULL;
            if(Auth::user()->responsable){
            if(is_iterable($users)){
            for ($to=0; $to < count($users); $to++) {
                    $ux = $users[$to];
                    
                    if(intval($ux->id) == intval(Auth::user()->responsable)){
                        $responsable_user_logger = $ux;
                    }
            }}}

            if($responsable_user_logger){
                    if($responsable_user_logger->roles[0]->name == "COORDONATEUR"){
                        
                        DB::table('users_incidents')->insert([
                            'created_at' => Carbon::now()->format('Y-m-d'),
                            'incident_number' => $request->number,
                            'user_id' => $responsable_user_logger->id,
                        ]);
                    }
            }

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
            'status' => "ANNULÉ",
            'archiver' => TRUE,
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

        $incident = Incident::with('categories', 'processus', 'sites')
        ->where('number', '=', $request->number)
        ->get()->first();

        $pdf = PDF::loadView("PDF/incident", ['incident' => $incident])->setPaper('a4', 'portrait');
        
        return $pdf->download("incident$request->number.pdf", array('Attachment'=> false));
    }

    public function print_annee_specifique(Request $request){

        $incident_annee_choisit = array();
        $incidents = Incident::with('categories', 'processus', 'sites')->get();

        if(is_iterable($incidents)){
            for ($d=0; $d < count($incidents); $d++) {
                $incident_courant = $incidents[$d];
                $ann = substr($incident_courant['declaration_date'], 0, 4);

                if(intval($request->annee) == intval($ann)){

                    if(
                        ($incident_courant['observation_rex'] != NULL) &&
                        ($incident_courant['deja_pris_en_compte'] == NULL)){
                        array_push($incident_annee_choisit, $incident_courant);
                    }
                }
        }}

        $pdf = PDF::loadView('PDF/tableau', ['incidents' => $incident_annee_choisit, 'annee' => $request->annee, 'Du' => NULL]);
        
        return $pdf->download("QteIncident$request->annee.pdf", array('Attachmnet'=> false));

    }

    public function print_entre_date(Request $request){

        $incident_dates_choisit = array();
        $date_debut = intval(str_replace("-", "", $request->date_debut));
        $date_fin = intval(str_replace("-", "", $request->date_fin));
        $sites = DB::table('sites')->get();
        $site_id = $request->site_id;
        $incidentSites = array();
        $site_choisit = NULL;

        if($request->site_id && $request->date_debut && $request->date_fin){
            if(is_iterable($sites)){
                for ($mg=0; $mg < count($sites); $mg++) { 
                    $site_courant = $sites[$mg];
                        if($site_courant->id == $site_id){
                        $site_choisit = $site_courant;
                        break;
                    }
                }
            }

            $incidents = Incident::with('categories', 'processus', 'sites')
            ->where('site_id', '=', $site_id)
            ->orWhere('site_declarateur', '=', $site_id)
            ->get();

            if(is_iterable($incidents)){
                for ($d=0; $d < count($incidents); $d++) {
                    $incident_courant = $incidents[$d];
                                        
                    if(
                        ($incident_courant->observation_rex != NULL) &&
                        ($incident_courant->deja_pris_en_compte == NULL)
                    ){
                        $date_declaration = intval(str_replace("-", "", substr($incident_courant->declaration_date, 0, 10)));

                        if(
                            (($date_declaration == $date_debut) && ($date_declaration < $date_fin)) ||
                            (($date_declaration > $date_debut) && ($date_declaration < $date_fin)) ||
                            (($date_declaration > $date_debut) && ($date_declaration == $date_fin)) ||
                            (($date_declaration == $date_debut) && ($date_declaration == $date_fin))
                        )
                        {
                            array_push($incident_dates_choisit, $incident_courant);
                        }
                    }
            }}

            $pdf = PDF::loadView('PDF/tableau_entre_date',
            [
                'incidents' => count($incident_dates_choisit) > 0 ? $incident_dates_choisit : $incidentSites,
                'Du' => $request->date_debut,
                'Au' => $request->date_fin,
                'name' => $site_id ? $site_choisit->name : NULL,
                'sites' => $sites,
            ]);
    
            return $pdf->download("QteIncident_Du_$request->date_debut._Au_$request->date_fin.pdf", array('Attachment'=> false));
    
        }elseif($request->date_debut && $request->date_fin){

            $incidents = Incident::with('categories', 'processus', 'sites')->get();

            if(is_iterable($sites)){
                for ($z=0; $z < count($sites); $z++) {
                    $siteCourant = $sites[$z];
            
                    $incidentDunSite = array();
            
                    if(is_iterable($incidents)){
                        for ($b=0; $b < count($incidents); $b++) {
                            $incident = $incidents[$b];
                
                            if(
                                ($incident->observation_rex != NULL) &&
                                ($incident->deja_pris_en_compte == NULL)
                            ){
                                if($incident->site_id){
                                    if(($incident->site_id == $siteCourant->id) || ($incident->site_declarateur == $siteCourant->id)){
                                        
                                        $date_declaration = intval(str_replace("-", "", substr($incident->declaration_date, 0, 10)));

                                        if(
                                            (($date_declaration == $date_debut) && ($date_declaration < $date_fin)) ||
                                            (($date_declaration > $date_debut) && ($date_declaration < $date_fin)) ||
                                            (($date_declaration > $date_debut) && ($date_declaration == $date_fin)) ||
                                            (($date_declaration == $date_debut) && ($date_declaration == $date_fin))
                                        )
                                        {
                                            array_push($incidentDunSite, $incident);
                                        }
                                    }
                                }
    
                            }
                        }
                    }
    
                    array_push($incidentSites, $incidentDunSite);
                }
            }
    
            $pdf = PDF::loadView('PDF/tableau_entre_date',
            [
                'incidents' => count($incident_dates_choisit) > 0 ? $incident_dates_choisit : $incidentSites,
                'Du' => $request->date_debut,
                'Au' => $request->date_fin,
                'name' => $site_id ? $site_choisit->name : NULL,
                'sites' => $sites,
            ]);
    
            return $pdf->download("QteIncident_Du_$request->date_debut._Au_$request->date_fin.pdf", array('Attachment'=> false));    
        }
    }

    public function print_region_date(Request $request){

        $ouest = 0;
        $nord_ouest = 0;
        $sud_ouest = 0;
        $centre = 0;
        $littoral = 0;
        $extreme_nord = 0;
        $sud = 0;
        $nord = 0;
        $adamaoua = 0;
        $est = 0;
        
        $incident_annee_choisit = array();
        $incidents = Incident::with('categories', 'processus', 'sites')->get();

        if(is_iterable($incidents)){
            for ($d=0; $d < count($incidents); $d++) {
                $incident_courant = $incidents[$d];
                $ann = substr($incident_courant['declaration_date'], 0, 4);

                if(intval($request->annee) == intval($ann)){

                    if(
                        ($incident_courant['observation_rex'] != NULL) &&
                        ($incident_courant['deja_pris_en_compte'] == NULL)){
                        
                        array_push($incident_annee_choisit, $incident_courant);

                        if($incident_courant->site_id){
                        switch ($incident_courant->sites->region) {
                            case 'OUEST':
                                $ouest +=1;
                                break;
                            case 'NORD-OUEST':
                                $nord_ouest +=1;
                                break;
                            case 'SUD-OUEST':
                                $sud_ouest +=1;
                                break;
                            case 'CENTRE':
                                $centre +=1;
                                break;
                            case 'LITTORAL':
                                $littoral +=1;
                                break;
                            case 'EXTREME-NORD':
                                $extreme_nord +=1;
                                break;
                            case 'SUD':
                                $sud +=1;
                                break;
                            case 'NORD':
                                $nord +=1;
                                break;
                            case 'ADAMAOUA':
                                $adamaoua +=1;
                                break;
                            case 'EST':
                                $est +=1;
                                break;
                       
                            default:
                                break;
                        }}
                    }
                }
        }}
        //dd($est);
        $pdf = PDF::loadView('PDF/regions', 

        ['incidents' => $incident_annee_choisit,
        'annee' => $request->annee,
        'ouest' => $ouest,
        'nord_ouest' => $nord_ouest,
        'centre' => $centre,
        'littoral' => $littoral,
        'sud' => $sud,
        'adamaoua' => $adamaoua,
        'est' => $est,
        ]);
        
        return $pdf->download("QteIncidentParRegion.$request->annee.pdf", array('Attachment'=> false));

    }

    public function generation_incidents_par_site(Request $request){
        $sites = DB::table('sites')->get();
        $incident_annee_encour = $this->incident_annee_encour($request->annee);
        $incidentSites = array();

        if(is_iterable($sites)){
            for ($z=0; $z < count($sites); $z++) {
                $siteCourant = $sites[$z];
        
                $incidentDunSite = array();
        
                if(is_iterable($incident_annee_encour)){
                    for ($b=0; $b < count($incident_annee_encour); $b++) {
                        $incident = $incident_annee_encour[$b];
            
                        if($incident->site_id){
                            if(($incident->site_id == $siteCourant->id) || ($incident->site_declarateur == $siteCourant->id)){
                                array_push($incidentDunSite, $incident);
                            }
                        }
                    }
                }

                array_push($incidentSites, $incidentDunSite);
            }
        }

        $pdf = PDF::loadView('PDF/incidentParSite',

        [
            'incidentSites' => $incidentSites,
            'annee' => $request->annee,
            'sites' => $sites,
        ]);
        
        return $pdf->download("QteIncidentParSite.$request->annee.pdf", array('Attachment'=> false));
    }
}
