<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Incident;
use App\Models\Categorie;
use App\Models\Processus;
use App\Models\Tache;
use App\Models\User;
use App\Models\Site;
use App\Models\Users_Incident;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
        notify()->info('Liste Des Incidents ! ⚡️', 'Info Incident');
        
        $years = array();
        $incidents = array();

        // $u_incidents = array();
        // $get_incidents = $this->getIncidents();

        // if(Session::has('users_incidents')){
        //     if(is_iterable(Session::get('users_incidents'))){
        //         for ($y=0; $y < count(Session::get('users_incidents')); $y++) {
        //             $u = Session::get('users_incidents')[$y];
        //             if($u->user_id == Auth::user()->id){
        //                 array_push($u_incidents, $u);
        //             }
        //         }
        //     }
        // }
        
        // if(Session::has('roles')){
        //     if(is_iterable(Session::get('roles'))){
        //         for ($n=0; $n < count(Session::get('roles')); $n++) {
                    
        //             $r = Session::get('roles')[$n];

        //             if(Auth::user()->roles[0]->name == $r->name){
        //                     $tab = array();

        //                     for ($s=0; $s < count($u_incidents); $s++) {
        //                         $uin = $u_incidents[$s];

        //                         for ($nb=0; $nb < count($get_incidents); $nb++) {
        //                             $in = $get_incidents[$nb];
        //                             if($in->number == $uin->incident_number){
        //                                 array_push($tab, $in);
        //                             }
        //                         }
        //                     }

        //                     for ($h=0; $h < count($tab); $h++) {
        //                         $indit = $tab[$h];

        //                         if(
        //                         ($indit->status == "CLÔTURÉ" && intval($indit->archiver) == 0) ||
        //                         ($indit->status != "ANNULÉ" && $indit->status != "CLÔTURÉ")
        //                         ){
        //                             array_push($incidents, $indit);
        //                         }
        //                     }
        //             }
        //         }
        //     }
        // }

        if(Session::has('incidents')){
        if(is_iterable(Session::get('incidents'))){
        for ($h=0; $h < count(Session::get('incidents')); $h++) {
            $indit = Session::get('incidents')[$h];

            if(
            ($indit->status == "CLÔTURÉ" && intval($indit->archiver) == 0) ||
            ($indit->status != "ANNULÉ" && $indit->status != "CLÔTURÉ")
            ){
                array_push($incidents, $indit);
            }
        }}}

        $annee = Carbon::now()->format('Y');
        for ($m=1; $m < 5; $m++) {
            array_push($years, intval($annee) - $m+1);
        }

        return view('incidents.index', compact('incidents', 'years'));
    }

    public function tableau(Request $request){

        $regions = [
            "OUEST",
            "NORD-OUEST",
            "SUD-OUEST",
            "CENTRE",
            "LITTORAL",
            "EXTREME-NORD",
            "SUD",
            "NORD",
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

        $annee = Carbon::now()->format('Y');

        $years = array();
        for ($i=1; $i < 5; $i++) {
            array_push($years, intval($annee) - $i+1);
        }
    
        if(Session::has('incidents')){
            if(is_iterable(Session::get('incidents'))){
            for ($d=0; $d < count(Session::get('incidents')); $d++) {
                $incident_courant = Session::get('incidents')[$d];
        
                $ann = substr($incident_courant->created_at, 0, 4);

                if(intval($annee) == intval($ann)){

                    if(
                        ($incident_courant->observation_rex != NULL) &&
                        ($incident_courant->deja_pris_en_compte == NULL)){
                        array_push($incident_annee_encour, $incident_courant);
                    }
                }
        }}}

        if(is_iterable($incident_annee_encour)){
        for ($g=0; $g < count($incident_annee_encour); $g++) {

            $inci = $incident_annee_encour[$g];
    
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

        
        if(Session::has('sites')){
            if(is_iterable(Session::get('sites'))){
            for ($z=0; $z < count(Session::get('sites')); $z++) {
                $siteCourant = Session::get('sites')[$z];
        
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
        }}}
        
        return view('incidents.tableau_statistique', [

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
    public function archive()
    {
        notify()->info('Liste Des Incidents Archivés ! ⚡️', 'Info Incident');

        $years = array();
        
        $incidents = array();
                   
        if(Session::has('roles')){
        if(is_iterable(Session::get('roles'))){
        for ($n=0; $n < count(Session::get('roles')); $n++) {
            $r = Session::get('roles')[$n];
            if(Auth::user()->roles[0]->name == $r->name){
                $tab = array();

                if(Auth::user()->departement_id){

                    if($r->name == "COORDONATEUR"){
                        
                        $u_incidents = DB::table('users_incidents')->where('user_id', '=', Auth::user()->id)->get();

                        for ($s=0; $s < count($u_incidents); $s++) {
                            $uin = $u_incidents[$s];
    
                            $incid = Incident::with('categories', 'processus')->where('number', '=', $uin->incident_number)->get()->first();
                            
                            array_push($tab, $incid);
                        }
    
                        for ($h=0; $h < count($tab); $h++) {
                            $indit = $tab[$h];
    
                            if(
                               ($indit->status == "CLÔTURÉ" && intval($indit->archiver) == 1) ||
                               ($indit->status == "ANNULÉ")
                            ){
                                array_push($incidents, $indit);
                            }
                        }

                    }else{

                        $uis = DB::table('users_incidents')
                        ->where('user_id', '=', Auth::user()->id)
                        ->get();

                        for ($x=0; $x < count($uis); $x++) {
                            $uinci = $uis[$x];

                            $ini = Incident::with('categories', 'processus')
                            ->where('number', '=', $uinci->incident_number)
                            ->get()->first();

                            array_push($tab, $ini);
                        }

                        for ($t=0; $t < count($tab); $t++) {

                            $incident = $tab[$t];

                            if(
                                ($incident->status == "CLÔTURÉ" && intval($incident->archiver) == 1) ||
                                ($incident->status == "ANNULÉ")
                            ){
                                array_push($incidents, $incident);
                            }
                            
                        }
        
                    }
                    
                }elseif(Auth::user()->site_id){

                    $u_incidents = DB::table('users_incidents')->where('user_id', '=', Auth::user()->id)->get();

                    for ($s=0; $s < count($u_incidents); $s++) {
                        $uin = $u_incidents[$s];

                        $incid = Incident::with('categories', 'processus')->where('number', '=', $uin->incident_number)->get()->first();
                        
                        array_push($tab, $incid);
                    }

                    for ($h=0; $h < count($tab); $h++) {
                        $indit = $tab[$h];

                        if(
                           ($indit->status == "CLÔTURÉ" && intval($indit->archiver) == 1) ||
                           ($indit->status == "ANNULÉ")
                        ){
                            array_push($incidents, $indit);
                        }
                    }

                }else{

                    $u_incidents = DB::table('users_incidents')->where('user_id', '=', Auth::user()->id)->get();

                    for ($s=0; $s < count($u_incidents); $s++) {
                        $uin = $u_incidents[$s];

                        $incid = Incident::with('categories', 'processus')->where('number', '=', $uin->incident_number)->get()->first();
                        
                        array_push($tab, $incid);
                    }

                    for ($h=0; $h < count($tab); $h++) {
                        $indit = $tab[$h];

                        if(
                           ($indit->status == "CLÔTURÉ" && intval($indit->archiver) == 1) ||
                           ($indit->status == "ANNULÉ")
                        ){
                            array_push($incidents, $indit);
                        }
                    }

                }

            }
        }}}

        $annee = Carbon::now()->format('Y');
    
        for ($i=1; $i < 5; $i++) {
            array_push($years, intval($annee) - $i+1);
        }
    
        return view('incidents.archive',
            compact('incidents', 'years'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cloture(Request $request)
    {

        $incidents = $this->getIncidents();

        DB::table('incidents')->where('number', $request->number)->update([
            'closure_date' => Carbon::now()->format('Y-m-d'),
            'status' => $request->status,
            'valeur' => $request->valeur ? intval($request->valeur) : NULL,
            'comment' => $request->comment ? $request->comment : NULL,
            'archiver' => TRUE,
        ]);
        
        if(Session::has('incidents')){

            $incident_edit = NULL;
            $newIncidents = array();

            if(is_iterable($incidents)){
            for ($j=0; $j < count($incidents); $j++) {
                    $incident_courant = $incidents[$j];
                    if($request->number == $incident_courant->number){

                        $incident_edit = $incident_courant;
                        $incident_edit->closure_date = Carbon::now()->format('Y-m-d');
                        $incident_edit->status = $request->status;
                        $incident_edit->valeur = $request->valeur ? intval($request->valeur) : NULL;
                        $incident_edit->comment = $request->comment ? $request->comment : NULL;
                        $incident_edit->archiver = TRUE;

                    } else{
                        array_push($newIncidents, $incident_courant);
                    }
            }}

            array_push($newIncidents, $incident_edit);

            Session::put('incidents', $newIncidents);
        }

        smilify('success', 'Incident Clôturé Avec Succèss !');
        
        return response()->json([1]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setCategorieIncident(Request $request){
        
        $incidents = $this->getIncidents();

        DB::table('incidents')->where('number', $request->number)->update([

            'categorie_id' => $request->categorie
        ]);
        
        $incident = Incident::with('categories.departements', 'processus', 'sites')
        ->where('number', $request->number)->get()->first();

        if(Session::has('incidents')){

            $incident_edit = NULL;
            $newIncidents = array();

            if(is_iterable($incidents)){
            for ($j=0; $j < count($incidents); $j++) {
                    $incident_courant = $incidents[$j];
                    if($request->number != $incident_courant->number){
                        array_push($newIncidents, $incident_courant);
                    }
            }}

            array_push($newIncidents, $incident);

            Session::put('incidents', $newIncidents);
        }

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

        $incidents = $this->getIncidents();

        DB::table('incidents')->where('number', $request->number)->update([
            'due_date' => $request->date,
        ]);
        
        if(Session::has('incidents')){

            $incident_edit = NULL;
            $newIncidents = array();

            if(is_iterable($incidents)){
            for ($j=0; $j < count($incidents); $j++) {
                    $incident_courant = $incidents[$j];
                    if($request->number == $incident_courant->number){

                        $incident_edit = $incident_courant;
                        $incident_edit->due_date = $request->date;

                    } else{
                        array_push($newIncidents, $incident_courant);
                    }
            }}

            array_push($newIncidents, $incident_edit);

            Session::put('incidents', $newIncidents);
        }

        notify()->success('Date D\'échéance De L\'Incident Définis Avec Succèss ! ⚡️');

        return response()->json([1]);
    }


    public function generateUniqueCode()
    {
        $incidents = Incident::get();
        $code;

        if(count($incidents) > 0){
            $tab = array();
        
            for ($i=0; $i < count($incidents); $i++) {
                $incident = $incidents[$i];
                array_push($tab, intval(substr($incident->number, 3)));
            }

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

        $incidents = $this->getIncidents();

        DB::table('incidents')->where('number', '=', $request->number)->update([
            'archiver' => 1,
        ]);

        if(Session::has('incidents')){

            $incident_edit = NULL;
            $newIncidents = array();

            if(is_iterable($incidents)){
            for ($j=0; $j < count($incidents); $j++) {
                    $incident_courant = $incidents[$j];
                    if($request->number == $incident_courant->number){

                        $incident_edit = $incident_courant;
                        $incident_edit->archiver = 1;

                    } else{
                        array_push($newIncidents, $incident_courant);
                    }
            }}

            array_push($newIncidents, $incident_edit);

            Session::put('incidents', $newIncidents);
        }

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

        $incidents = $this->getIncidents();

        DB::table('incidents')->where('number', '=', $request->number)->update([
            'archiver' => 0,
        ]);

        if(Session::has('incidents')){

            $incident_edit = NULL;
            $newIncidents = array();

            if(is_iterable($incidents)){
            for ($j=0; $j < count($incidents); $j++) {
                    $incident_courant = $incidents[$j];
                    if($request->number == $incident_courant->number){

                        $incident_edit = $incident_courant;
                        $incident_edit->archiver = 0;

                    } else{
                        array_push($newIncidents, $incident_courant);
                    }
            }}

            array_push($newIncidents, $incident_edit);

            Session::put('incidents', $newIncidents);
        }

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

        $incidents = $this->getIncidents();

        DB::table('incidents')->where('number', '=', $request->number)->update([

            'status' => "ENCOURS",
            'motif_annulation' => NULL,

        ]);

        if(Session::has('incidents')){

            $incident_edit = NULL;
            $newIncidents = array();

            if(is_iterable($incidents)){
            for ($j=0; $j < count($incidents); $j++) {
                    $incident_courant = $incidents[$j];
                    if($request->number == $incident_courant->number){

                        $incident_edit = $incident_courant;
                        $incident_edit->motif_annulation = NULL;
                        $incident_edit->status = "ENCOURS";
                        
                    } else{
                        array_push($newIncidents, $incident_courant);
                    }
            }}

            array_push($newIncidents, $incident_edit);

            Session::put('incidents', $newIncidents);
        }

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

        $get_incidents = $this->getIncidents();

        DB::table('incidents')->where('number', '=', $request->number)->update([

            'status' => "CLÔTURÉ",
            'due_date' => Carbon::now()->format('Y-m-d'),
            'closure_date' => Carbon::now()->format('Y-m-d'),
            'observation_rex' => $request->observation,
            'deja_pris_en_compte' => TRUE,
            'comment' => "Incident Pris En Compte ( Déja Déclaré Par Un Autre Site )"
        ]);

        $newIncidents = array();
        $incident_editer = NULL;

        if(is_iterable($get_incidents)){
        for ($w=0; $w < count($get_incidents); $w++) {
            $incidou = $get_incidents[$w];
            if($incidou->number == $request->number){

                $incident_editer = $incidou;
                
                $incident_editer->status = "CLÔTURÉ";
                $incident_editer->due_date = Carbon::now()->format('Y-m-d');
                $incident_editer->closure_date = Carbon::now()->format('Y-m-d');
                $incident_editer->observation_rex = $request->observation;
                $incident_editer->deja_pris_en_compte = TRUE;

            }else{
                array_push($newIncidents, $incidou);
            }
        }}

        array_push($newIncidents, $incident_editer);

        Session::put('incidents', $newIncidents);

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
            $users = array();
            $get_incidents = $this->getIncidents();
            $incident_tasks = $request->all();
            $number = $this->generateUniqueCode();

            DB::table('incidents')->insert(
                [
                'archiver' => 0,
                'battles' => $incident_tasks['battles'] ? $incident_tasks['battles'] : NULL,
                'perimeter' => $incident_tasks['perimeter'] ? $incident_tasks['perimeter'] : NULL,
                'description' => $incident_tasks['description'],
                'status' => "ENCOURS",
                'cause' => $incident_tasks['cause'],
                'proces_id' => $incident_tasks['processus_id'][0] ? intval($incident_tasks['processus_id'][0]) : (intval($incident_tasks['processus_id'][1]) ? intval($incident_tasks['processus_id'][1]) : NULL),
                'priority' => $incident_tasks['priority'],
                'number' => $number,
                'created_at' => Carbon::now()->format('Y-m-d'),
                'site_id' => Auth::user()->site_id ? intval(Auth::user()->site_id) : NULL,
                ]
            );

            $incident = Incident::with('categories.departements', 'processus', 'sites')
            ->where('number', '=', $number)
            ->get()->first();

            if(Session::has('incidents')){
                $newIncidents = array();
                array_push($newIncidents, $incident);

                for ($w=0; $w < count($get_incidents); $w++) {
                    $incidou = $get_incidents[$w];
                    array_push($newIncidents, $incidou);
                }

                Session::put('incidents', $newIncidents);
            }

            if(Auth::user()->site_id){
                if(Session::has('users')){
                    if(is_iterable(Session::get('users'))){
                        for ($dr=0; $dr < count(Session::get('users')); $dr++) {
                            $usi = Session::get('users')[$dr];
                            if($usi->site_id){
                                if(intval($usi->site_id) == intval(Auth::user()->site_id)){
                                    array_push($users, $usi);
                                }
                            }
                        }
                    }
                }
            }elseif (Auth::user()->departement_id) {
                if(Session::has('users')){
                    if(is_iterable(Session::get('users'))){
                        for ($dr=0; $dr < count(Session::get('users')); $dr++) {
                            $usi = Session::get('users')[$dr];
                            if($usi->departement_id){
                                if(intval($usi->departement_id) == intval(Auth::user()->departement_id)){
                                    array_push($users, $usi);
                                }
                            }
                        }
                    }
                }
            }

            if(Auth::user()->roles[0]->name == "EMPLOYE"){
                    
                    $newUser_Incidents = array();

                    for ($r=0; $r < count($users); $r++){
                        $utili = $users[$r];

                        DB::table('users_incidents')->insert([
                            'created_at' => Carbon::now()->format('Y-m-d'),
                            'incident_number' => $incident->number,
                            'user_id' => $utili->id,
                            'isCoordo' => 1,
                            'isDeclar' => 1,
                        ]);
        
                        $user_incide = DB::table('users_incidents')
                        ->where('user_id', '=', $utili->id)
                        ->where('incident_number', '=', $incident->number)
                        ->get()->first();

                        array_push($newUser_Incidents, $user_incide);
                    }
                    
                    $responsable_user_logger = NULL;
                    if(Auth::user()->responsable){
                    for ($to=0; $to < count(Session::get('users')); $to++) {
                        $ux = Session::get('users')[$to];
                        
                        if(intval($ux->id) == intval(Auth::user()->responsable)){
                            $responsable_user_logger = $ux;
                        }
                    }}

                    if($responsable_user_logger){
                        if($responsable_user_logger->roles[0]->name == "COORDONATEUR"){
                            
                            DB::table('users_incidents')->insert([
                                'created_at' => Carbon::now()->format('Y-m-d'),
                                'incident_number' => $incident->number,
                                'user_id' => $responsable_user_logger->id,
                            ]);

                            $userincid = DB::table('users_incidents')->get()->last();

                            array_push($newUser_Incidents, $userincid);
                            
                            if(Session::has('users_incidents')){
                            if(is_iterable(Session::get('users_incidents'))){

                                for ($w=0; $w < count(Session::get('users_incidents')); $w++) {
                                    $ui = Session::get('users_incidents')[$w];
                                    array_push($newUser_Incidents, $ui);
                                }

                                Session::put('users_incidents', $newUser_Incidents);
                            }}
                        }
                    }
            }elseif (Auth::user()->roles[0]->name == "COORDONATEUR") {

                    $newUser_Incidents = array();

                    for ($o=0; $o < count($users); $o++) {
                        $user = $users[$o];
        
                        DB::table('users_incidents')->insert([
                            'created_at' => Carbon::now()->format('Y-m-d'),
                            'incident_number' => $incident->number,
                            'user_id' => $user->id,
                            'isTriggerPlus' => TRUE,
                            'isTrigger' => TRUE,
                            'isCoordo' => TRUE,
                            'isDeclar' => 1,
                        ]);

                        $user_incide = DB::table('users_incidents')->get()->last();

                        array_push($newUser_Incidents, $user_incide);
                    }

                    if(Session::has('users_incidents')){
                        $using_inci = Session::get('users_incidents');
                        for ($w=0; $w < count($using_inci); $w++) {
                            $ui = $using_inci[$w];
                            array_push($newUser_Incidents, $ui);
                        }
                        Session::put('users_incidents', $newUser_Incidents);
                    }

            }

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
        $incidents = $this->getIncidents();

        DB::table('incidents')->where('number', '=', $request->number)->update([
            'priority' => $request->priorite,
        ]);

        if(Session::has('incidents')){

            $incident_edit = NULL;
            $newIncidents = array();

            for ($j=0; $j < count($incidents); $j++) {
                    $incident_courant = $incidents[$j];
                    if($request->number == $incident_courant->number){

                        $incident_edit = $incidetn_courant;
                        $incident_edit->priority = $request->priorite;

                    } else{
                        array_push($newIncidents, $incident_courant);
                    }
            }

            array_push($newIncidents, $incident_edit);

            Session::put('incidents', $newIncidents);
        }

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

        for ($fb=0; $fb < count($all_tasks); $fb++) {
            $ta = $all_tasks[$fb];
            DB::table('logtaches')->where('tache_id', '=', $ta->id)->delete();
        }

        for ($sc=0; $sc < count($all_tasks); $sc++) {
            $ach = $all_tasks[$sc];
            DB::table('taches')->where('id', '=', $ach->id)->delete();
        }

        DB::table('users_incidents')->where('incident_number', '=', $request->number)->delete();

        DB::table('incidents')->where('number', '=', $request->number)->delete();

        if(Session::has('incidents')){
            $newIncidents = array();
            $incidents = $this->getIncidents();

            for ($j=0; $j < count($incidents); $j++) {
                $incident_courant = $incidents[$j];
                if($request->number != $incident_courant->number){
                    array_push($newIncidents, $incident_courant);
                }
            }

            Session::put('incidents', $newIncidents);
        }

        $newUsers_incidents = array();
        if(Session::has('users_incidents')){
        if(is_iterable(Session::get('users_incidents'))){
        for ($pi=0; $pi < count(Session::get('users_incidents')); $pi++) {

            $ui = Session::get('users_incidents')[$pi];

            if($request->number != $ui->incident_number){
                array_push($newUsers_incidents, $ui);
            }
        }}}

        Session::put('users_incidents', $newUsers_incidents);
        
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
            $incidents = $this->getIncidents();

            DB::table('incidents')->where('number', $request->number)->update([
                'due_date' => $request->due_date ? $request->due_date : NULL,
                'battles' => $request->battles ? $request->battles : NULL,
                'description' => $request->description,
                'cause' => $request->cause,
                'perimeter'=> $request->perimeter ? $request->perimeter : NULL,
                'categorie_id' => $request->categorie_id ? intval($request->input('categorie_id')) : NULL,
                'proces_id' => $request->processus_id,
                'priority' => $request->priority,
            ]);
            
            if(Session::has('incidents')){

                $incident_edit = NULL;
                $newIncidents = array();
    
                for ($j=0; $j < count($incidents); $j++) {
                        $incident_courant = $incidents[$j];
                        if($incident_courant->number == $request->number){

                            $incident_edit = $incident_courant;
                            $incident_edit->due_date = $request->due_date ? $request->due_date : NULL;
                            $incident_edit->battles = $request->battles ? $request->battles : NULL;
                            $incident_edit->description = $request->description;
                            $incident_edit->cause = $request->cause;
                            $incident_edit->perimeter = $request->perimeter ? $request->perimeter : NULL;
                            $incident_edit->categorie_id = intval($request->input('categorie_id'));
                            $incident_edit->proces_id = $request->processus_id;
                            $incident_edit->priority = $request->priority;

                        } else{
                            array_push($newIncidents, $incident_courant);
                        }
                }

                array_push($newIncidents, $incident_edit);

                Session::put('incidents', $newIncidents);
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

        $incidents = $this->getIncidents();

        DB::table('incidents')->where('number', $request->number)->update([
            'motif_annulation' => $request->motif,
            'status' => "ANNULÉ"
        ]);
        
        if(Session::has('incidents')){

            $incident_edit = NULL;
            $newIncidents = array();

            for ($j=0; $j < count($incidents); $j++) {
                    $incident_courant = $incidents[$j];
                    if($request->number == $incident_courant->number){

                        $incident_edit = $incident_courant;
                        $incident_edit->motif_annulation = $request->motif;
                        $incident_edit->status = "ANNULÉ";

                    } else{
                        array_push($newIncidents, $incident_courant);
                    }
            }

            array_push($newIncidents, $incident_edit);

            Session::put('incidents', $newIncidents);
        }

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

        $incident = NULL;
        $incidents = $this->getIncidents();

        for ($i=0; $i < count($incidents); $i++) {
            $inci = $incidents[$i];
            if($inci->number == $request->number){
                $incident = $inci;
            }
        }

        $pdf = PDF::loadView('PDF/incident', ['incident' => $incident]);
        
        return $pdf->stream('incident.pdf', array('Attachment'=> false));
    }

}
