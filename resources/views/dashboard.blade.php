@extends('layouts.main')

@section('content')
    <!-- Begin Page Content -->
    <script src="{{ url('js/charts.min.js') }}"></script>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                <div class="row align-items-center">
                    <div class="col">
                      <div class="text-left" style="font-size: 2em;">
                          <span class="fe fe-bar-chart-2 fe-32 mr-2"></span>
                          Etat Statistique
                      </div>
                    </div>
                      <div class="col">
                        <div class="text-right">
                          <!-- <span class="text-xl badge badge-pill badge-success"><i class="fe fe-calendar mr-2"></i></span> -->
                        </div>
                      </div>
                </div>
                
                  @can('dashboard_employe')
                      <?php 

                              $incidant_encours = array();
                              $incidant_cloturer = array();
                              $incidant_annuller = array();
                              $incidant_enretard = array();

                              $nombre_cloture_enretard = 0;
                              $nombre_cloture_a_temps = 0;
                              $a_temps = 0;
                              $enretard = 0;
  
                              $encour = 0;
                              $cloture = 0;
                              $annul = 0;

                              $encourtache = 0;
                              $realisetache = 0;
                              $annultache = 0;
                              $enAttentetache = 0;

                              $encourtaches = array();
                              $realisetaches = array();
                              $annultaches = array();
                              $enAttentetaches = array();

                              $nbr_emis = 0;
                              $nbr_recus = 0;

                              $width_emis = 0;
                              $width_recus = 0;
                              $width_encour = 0;
                              $width_annul = 0;
                              $width_cloture = 0;
                              
                              $width_tache_encour = 0;
                              $width_tache_annul = 0;
                              $width_tache_realise = 0;
                              $width_tache_enAttente = 0;

                              $width_tache_emise = 0;  
                              $width_tache_recues = 0;

                              $cit = NULL;
                              $inciSites = array();

                              $nombre_incidents = 0;

                              $nbr_taches = 0;

                              $tachess = array();

                              $nbr_taches_emises = 0;
                              $nbr_taches_recues = 0;

                              $taches_emises = array();
                              $taches_recues = array();

                              $janv = 0;
                              $fev = 0;
                              $mars = 0;
                              $avril = 0;
                              $mai = 0;
                              $juin = 0;
                              $juill = 0;
                              $aout = 0;
                              $sept = 0;
                              $oct = 0;
                              $nov = 0;
                              $decc = 0;
                              
                              $janv_encours = 0;
                              $fev_encours = 0;
                              $mars_encours = 0;
                              $avril_encours = 0;
                              $mai_encours = 0;
                              $juin_encours = 0;
                              $juill_encours = 0;
                              $aout_encours = 0;
                              $sept_encours = 0;
                              $oct_encours = 0;
                              $nov_encours = 0;
                              $decc_encours = 0;
  
                              $janv_cloturer = 0;
                              $fev_cloturer = 0;
                              $mars_cloturer = 0;
                              $avril_cloturer = 0;
                              $mai_cloturer = 0;
                              $juin_cloturer = 0;
                              $juill_cloturer = 0;
                              $aout_cloturer = 0;
                              $sept_cloturer = 0;
                              $oct_cloturer = 0;
                              $nov_cloturer = 0;
                              $decc_cloturer = 0;
  
                              $janv_annuler = 0;
                              $fev_annuler = 0;
                              $mars_annuler = 0;
                              $avril_annuler = 0;
                              $mai_annuler = 0;
                              $juin_annuler = 0;
                              $juill_annuler = 0;
                              $aout_annuler = 0;
                              $sept_annuler = 0;
                              $oct_annuler = 0;
                              $nov_annuler = 0;
                              $decc_annuler = 0;
  
                              if(is_iterable($incident_annee_encour)){
                              for ($c=0; $c < count($incident_annee_encour); $c++) {
                                  $tine = $incident_annee_encour[$c];

                                  $extract_mois = intval(substr($tine->declaration_date, 5, 2));
                                  switch ($extract_mois) {
                                    case 1:
                                      $janv +=1;
                                      break;
                                    case 2:
                                      $fev +=1;
                                      break;
                                    case 3:
                                      $mars +=1;
                                      break;
                                    case 4:
                                      $avril +=1;
                                      break;
                                    case 5:
                                      $mai +=1;
                                      break;
                                    case 6:
                                      $juin +=1;
                                      break;
                                    case 7:
                                      $juill +=1;
                                      break;
                                    case 8:
                                      $aout +=1;
                                      break;
                                    case 9:
                                      $sept +=1;
                                      break;
                                    case 10:
                                      $oct +=1;
                                      break;
                                    case 11:
                                      $nov +=1;
                                      break;
                                    case 12:
                                      $decc +=1;
                                      break;
                                    default:
                                      # code...
                                      break;
                                  }

                                  //if($tine->number == $ui->incident_number){

                                      //if($ui->user_id == Auth::user()->id){
                                        $nombre_incidents +=1;

                                        //array_push($newIncidents, $tine);
                                        if($tine->status == "ENCOURS"){

                                          $encour +=1;
                                          array_push($incidant_encours, $tine);
        
                                          if($tine->due_date){
                                            $auday = str_replace("-", "", date('Y-m-d'));
                                            $date_echeance = str_replace("-", "", $tine->due_date);
                                            if(intval($date_echeance) < intval($auday)){
                                                $enretard +=1;
                                                array_push($incidant_enretard, $tine);
                                            }else{
                                              $a_temps +=1;
                                            }
                                          }
      
                                        }elseif ($tine->status == "CLÔTURÉ") {
        
                                          $cloture +=1;
                                          array_push($incidant_cloturer, $tine);
        
                                          if($tine->due_date && $tine->closure_date){
                                            if(intval(str_replace("-", "", $tine->closure_date)) > intval(str_replace("-", "", $tine->due_date))){
                                                $nombre_cloture_enretard +=1;
                                            }else{
                                                $nombre_cloture_a_temps +=1;
                                            }
                                          }

                                        }elseif ($tine->status == "ANNULÉ") {
        
                                          $annul +=1;
                                          array_push($incidant_annuller, $tine);
        
                                        }
        
                                        //ELEMENT IMPORTANT CA NE MARCHE PAS
                                        if(Auth::user()->site_id){
                                          if($tine->site_id){
                                            if(intval(Auth::user()->site_id) == intval($tine->site_id)){
                                              $nbr_emis +=1;
                                            }else{
                                              $nbr_recus +=1;
                                            }
                                          }
                                        }elseif (Auth::user()->departement_id) {
                                          if($tine->departement_id){
                                            if(intval(Auth::user()->departement_id) == intval($tine->departement_id)){
                                              $nbr_emis +=1;
                                            }else{
                                              $nbr_recus +=1;
                                            }
                                          }
                                        }

                                  for ($yo=0; $yo < count($tasks); $yo++) {
                                    $ta = $tasks[$yo];

                                    if($ta->incident_number == $tine->number){
                                        
                                      if($ta->site_id){
                                        if(Auth::user()->site_id){

                                            if($ta->site_id == Auth::user()->site_id){
                                                $nbr_taches += 1;
                                                array_push($tachess, $ta);
                                            }else {

                                              // if(is_iterable($users_incidents)){
                                              // for ($d=0; $d < count($users_incidents); $d++){
                                              //     $us = $users_incidents[$d];

                                              //     if($us->user_id == Auth::user()->id){
                                              //         if($us->incident_number == $ta->incident_number){
                                              //             if($us->isCoordo == TRUE){
                                              //                 $nbr_taches += 1;
                                              //             }
                                              //         }
                                              //     }
                                              // }}
                                          }

                                        }elseif (Auth::user()->departement_id){

                                          if(is_iterable($users_incidents)){
                                            for ($d=0; $d < count($users_incidents); $d++){
                                              $us = $users_incidents[$d];

                                              if($us->user_id == Auth::user()->id){
                                                if($us->incident_number == $ta->incident_number){
                                                    if($us->isCoordo == TRUE){
                                                        $nbr_taches += 1;
                                                        array_push($tachess, $ta);
                                                    }
                                                }
                                              }
                                          }}
                                        }
                                      }elseif ($ta->departement_id) {
                                          if(Auth::user()->departement_id){
                                              if(Auth::user()->departement_id == $ta->departement_id){
                                                  $nbr_taches += 1;
                                                  array_push($tachess, $ta);
                                              }else{

                                                // if(is_iterable($users_incidents)){
                                                // for ($d=0; $d < count($users_incidents); $d++){
                                                //   $us = $users_incidents[$d];

                                                //   if($us->user_id == Auth::user()->id){
                                                //     if($us->incident_number == $ta->incident_number){
                                                //         if($us->isCoordo == TRUE){
                                                //             $nbr_taches += 1;
                                                //             array_push($tachess, $ta);
                                                //         }
                                                //     }
                                                //   }
                                                // }}
                                              }
                                          }elseif(Auth::user()->site_id){
                                            if(is_iterable($users_incidents)){
                                            for ($d=0; $d < count($users_incidents); $d++){
                                              $us = $users_incidents[$d];

                                              if($us->user_id == Auth::user()->id){
                                                if($us->incident_number == $ta->incident_number){
                                                    if($us->isCoordo == TRUE){
                                                        $nbr_taches += 1;
                                                        array_push($tachess, $ta);
                                                    }
                                                }
                                              }
                                            }}
                                          }
                                      }
                                        
                                    }
                                  }

                              }}
                              //}
                            //}

                              
                              if(is_iterable($tachess)){
                              for ($tv=0; $tv < count($tachess); $tv++) {

                                      $ta = $tachess[$tv];

                                      if($ta->status == "ENCOURS"){
                                          $encourtache +=1;
                                          array_push($encourtaches, $ta);
                                      }elseif ($ta->status == "RÉALISÉE") {
                                          $realisetache +=1;
                                          array_push($realisetaches, $ta);
                                      }elseif ($ta->status == "EN-ATTENTE") {
                                          $enAttentetache +=1;
                                          array_push($enAttentetaches, $ta);
                                      }elseif ($ta->status == "ANNULÉE") {
                                          $annultache +=1;
                                          array_push($annultaches, $ta);
                                      }

                                      if($ta->site_id){
                                          if(Auth::user()->site_id){
                                            if(Auth::user()->site_id == $ta->site_id){
                                                $nbr_taches_recues +=1;
                                            }else{
                                                $nbr_taches_emises +=1;
                                            }
                                          }elseif (Auth::user()->departement_id) {

                                              if(is_iterable($users_incidents)){
                                              for($cd=0; $cd < count($users_incidents); $cd++){
                                                $mu = $users_incidents[$cd];
                                                 if($mu->incident_number == $ta->incident_number){
                                                      if($mu->user_id == Auth::user()->id){
                                                          if($mu->isCoordo){
                                                            $nbr_taches_emises +=1;
                                                          }else{
                                                            $nbr_taches_recues +=1;
                                                          }
                                                      }
                                                 }
                                              }}
                                          }

                                      }elseif($ta->departement_id) {
                                          if(Auth::user()->departement_id){
                                            if(Auth::user()->departement_id == $ta->departement_id){
                                                $nbr_taches_recues +=1;
                                            }else{
                                                $nbr_taches_emises +=1;
                                            }
                                          }elseif (Auth::user()->site_id) {

                                            if(is_iterable($users_incidents)){
                                            for($cd=0; $cd < count($users_incidents); $cd++){
                                              $mu = $users_incidents[$cd];
                                               if($mu->incident_number == $ta->incident_number){
                                                    if($mu->user_id == Auth::user()->id){
                                                        if($mu->isCoordo){
                                                          $nbr_taches_emises +=1;
                                                        }else{
                                                          $nbr_taches_recues +=1;
                                                        }
                                                    }
                                               }
                                            }}
                                          }
                                      }
                              }}

                              if(Auth::user()->site_id){

                                if(is_iterable($sites)){
                                for ($t=0; $t < count($sites); $t++) { 
                                  $s = $sites[$t];
                                  if(intval($s->id) == intval(Auth::user()->site_id)){
                                    $cit = $s;
                                  }
                                }}
                                
                              }elseif (Auth::user()->departement_id) {

                                if(is_iterable($departements)){
                                for ($t=0; $t < count($departements); $t++) { 
                                  $d = $departements[$t];
                                  if(intval($d->id) == intval(Auth::user()->departement_id)){
                                    $cit = $d;
                                  }
                                }}
                              }

                              if(count($incident_annee_encour) > 0){

                                    $width_encour = intval($encour/count($incident_annee_encour)*100);
                                    $width_annul = intval($annul/count($incident_annee_encour)*100);
                                    $width_cloture = intval($cloture/count($incident_annee_encour)*100);
                                    
                                    $width_emis = intval($nbr_emis/count($incident_annee_encour)*100);
                                    $width_recus = intval($nbr_recus/count($incident_annee_encour)*100);

                                  if($nbr_taches > 0){
                                    $width_tache_encour = intval($encourtache/$nbr_taches*100);
                                    $width_tache_annul = intval($annultache/$nbr_taches*100);
                                    $width_tache_realise = intval($realisetache/$nbr_taches*100);  
                                    $width_tache_enAttente = intval($enAttentetache/$nbr_taches*100);

                                    $width_tache_emise = intval($nbr_taches_emises/$nbr_taches*100);  
                                    $width_tache_recues = intval($nbr_taches_recues/$nbr_taches*100);

                                  }
                              }

                              if(is_iterable($incidant_encours)){
                              for ($fi=0; $fi < count($incidant_encours); $fi++) {
                                $mon_i = $incidant_encours[$fi];
                                $extrac_mois = intval(substr($mon_i->declaration_date, 5, 2));
                                switch ($extrac_mois) {
                                  case 1:
                                    $janv_encours +=1;
                                    break;
                                  case 2:
                                    $fev_encours +=1;
                                    break;
                                  case 3:
                                    $mars_encours +=1;
                                    break;
                                  case 4:
                                    $avril_encours +=1;
                                    break;
                                  case 5:
                                    $mai_encours +=1;
                                    break;
                                  case 6:
                                    $juin_encours +=1;
                                    break;
                                  case 7:
                                    $juill_encours +=1;
                                    break;
                                  case 8:
                                    $aout_encours +=1;
                                    break;
                                  case 9:
                                    $sept_encours +=1;
                                    break;
                                  case 10:
                                    $oct_encours +=1;
                                    break;
                                  case 11:
                                    $nov_encours +=1;
                                    break;
                                  case 12:
                                    $decc_encours +=1;
                                    break;
                                  default:
                                    break;
                                }
  
                              }}
  
                              if(is_iterable($incidant_cloturer)){
                              for ($rs=0; $rs < count($incidant_cloturer); $rs++) {
                                $monInci = $incidant_cloturer[$rs];
                                $extra_mois = intval(substr($monInci->declaration_date, 5, 2));
                                switch ($extra_mois) {
                                  case 1:
                                    $janv_cloturer +=1;
                                    break;
                                  case 2:
                                    $fev_cloturer +=1;
                                    break;
                                  case 3:
                                    $mars_cloturer +=1;
                                    break;
                                  case 4:
                                    $avril_cloturer +=1;
                                    break;
                                  case 5:
                                    $mai_cloturer +=1;
                                    break;
                                  case 6:
                                    $juin_cloturer +=1;
                                    break;
                                  case 7:
                                    $juill_cloturer +=1;
                                    break;
                                  case 8:
                                    $aout_cloturer +=1;
                                    break;
                                  case 9:
                                    $sept_cloturer +=1;
                                    break;
                                  case 10:
                                    $oct_cloturer +=1;
                                    break;
                                  case 11:
                                    $nov_cloturer +=1;
                                    break;
                                  case 12:
                                    $decc_cloturer +=1;
                                    break;
                                  default:
                                    break;
                                }
                              }}
                              
                              if(count($incidant_annuller) > 0){
                              for ($do=0; $do < count($incidant_annuller); $do++) {
                                $monIncid = $incidant_annuller[$do];
                                
                                $extr_mois = intval(substr($monIncid->declaration_date, 5, 2));
                                switch ($extr_mois) {
                                  case 1:
                                    $janv_annuler +=1;
                                    break;
                                  case 2:
                                    $fev_annuler +=1;
                                    break;
                                  case 3:
                                    $mars_annuler +=1;
                                    break;
                                  case 4:
                                    $avril_annuler +=1;
                                    break;
                                  case 5:
                                    $mai_annuler +=1;
                                    break;
                                  case 6:
                                    $juin_annuler +=1;
                                    break;
                                  case 7:
                                    $juill_annuler +=1;
                                    break;
                                  case 8:
                                    $aout_annuler +=1;
                                    break;
                                  case 9:
                                    $sept_annuler +=1;
                                    break;
                                  case 10:
                                    $oct_annuler +=1;
                                    break;
                                  case 11:
                                    $nov_annuler +=1;
                                    break;
                                  case 12:
                                    $decc_annuler +=1;
                                    break;
                                  default:
                                    break;
                                }
  
                              }}
  

                              $tab_ids = array();
                              $tab_created = array();
                              $tab_exited = array();
  
                              if(is_iterable($incidents)){
                              for ($j=0; $j < count($incidents); $j++) {
                                $indi = $incidents[$j];
                                array_push($tab_ids, $indi->number);
                                array_push($tab_exited, $indi->due_date);
                                array_push($tab_created, substr(strval($indi->declaration_date), 0, 10));
                              }}
  
                      ?>

                      <hr style="margin-bottom:2em; margin-top:3em;">

                      <div class="row justify-content-center" style="font-family: Century Gothic;">
                            <div class="text-left col-md-5">
                                  <div class="input-group mb-3">
                                          <strong style="font-size:2em;" class="mr-4">Entre Le</strong>
                                          <input 
                                                  type="date" 
                                                  class="form-control border-primary text-xl" 
                                                  id="grik_date"
                                                  data-user_connecte="{{ json_encode(Auth::user()) }}"
                                                  data-tasks="{{ json_encode($tasks) }}"
                                                  data-ids="{{ json_encode($tab_ids) }}"
                                                  data-created="{{ json_encode($tab_created) }}"
                                                  data-exited="{{ json_encode($tab_exited) }}"
                                                  data-incidents="{{ json_encode($incidents) }}"
                                                  data-sites="{{ json_encode($sites) }}"
                                                  data-users="{{ json_encode($users) }}"
                                                  data-users_incidents="{{ json_encode($users_incidents) }}"
                                                  data-incident_annee_encours="{{ json_encode($incident_annee_encour) }}"
                                                  data-regions="{{ json_encode($regions) }}">
                                  </div>
                            </div>
                            <div class="text-right col-md-5">
                                  <div class="input-group mb-3">
                                          <strong style="font-size:2em;" class="mr-4">Et Le</strong>
                                          <input 
                                                  type="date"
                                                  disabled
                                                  class="form-control border-primary text-xl"
                                                  id="krik_date"
                                                  data-user_connecte="{{ json_encode(Auth::user()) }}"
                                                  data-tasks="{{ json_encode($tasks) }}"
                                                  data-ids="{{ json_encode($tab_ids) }}"
                                                  data-created="{{ json_encode($tab_created) }}"
                                                  data-exited="{{ json_encode($tab_exited) }}"
                                                  data-incidents="{{ json_encode($incidents) }}"
                                                  data-sites="{{ json_encode($sites) }}"
                                                  data-users="{{ json_encode($users) }}"
                                                  data-users_incidents="{{ json_encode($users_incidents) }}"
                                                  data-incident_annee_encours="{{ json_encode($incident_annee_encour) }}"
                                                  data-regions="{{ json_encode($regions) }}">
                                  </div>
                            </div>
                      </div>

                      <hr style="margin-bottom:4em; margin-top:2em;">

                      <div class="row">
                                <div class="col-md-4">
                                  <div class="card shadow border-info mb-4">
                                    <div class="card-body">
                                      <div class="row align-items-center">
                                        <div class="col my-4">
                                          <span class="my-3 text-lg font-weight-bold">Nombre D'incident(s) TOTAL</span>
                                        </div>
                                        <div class="col-4 text-right">
                                          <span style="font-size:3em;" class="alters mb-0">
                                            {{ $nombre_incidents < 10 ? 0 ."". $nombre_incidents : $nombre_incidents }}
                                          </span>
                                        </div>
                                      </div> <!-- /. row -->
                                    </div> <!-- /. card-body -->
                                  </div> <!-- /. card -->
                                </div> <!-- /. col -->
                      </div>
                      <div class="row">
                            <div class="col-md-4">
                              <div class="card shadow border-danger mb-4">
                                <div class="card-body">
                                  <div class="row align-items-center">
                                    <div class="col my-4">
                                      <span class="text-lg text-danger font-weight-bold">Nombre D'incident(s)</span></br>
                                      <span class="mb-1 text-lg text-danger font-weight-bold"> EN-RETARD </span>
                                    </div>
                                    <div class="col-4 text-right">
                                      <h1 style="font-size:3em;" class="text-danger mb-0 cliotu">
                                          {{ $enretard < 10 ? 0 ."". $enretard : $enretard }}
                                      </h1>
                                    </div>
                                  </div> <!-- /. row -->
                                </div> <!-- /. card-body -->
                              </div> <!-- /. card -->
                            </div> <!-- /. col -->
                            <div class="col-md-4">
                              <div class="card shadow border-secondary mb-4">
                                <div class="card-body">
                                  <div class="row align-items-center">
                                    <div class="col my-4">
                                      <span class="text-lg text-tertiary font-weight-bold">Nombre D'incident(s)</span></br>
                                      <span class="mb-1 text-lg text-tertiary font-weight-bold"> NON-EN-RETARD </span>
                                    </div>
                                    <div class="col-4 text-right">
                                      <h1 style="font-size:3em;" class="text-tertiary mb-0 cliotu">
                                          {{ $a_temps < 10 ? 0 ."". $a_temps : $a_temps }}
                                      </h1>
                                    </div>
                                  </div> <!-- /. row -->
                                </div> <!-- /. card-body -->
                              </div> <!-- /. card -->
                            </div> <!-- /. col -->

                      </div>
                      <div class="row justify-content-center" style="font-family: Century Gothic;">
                            <div class="col-md-4">
                              <div class="card shadow border-success mb-4">
                                <div class="card-body">
                                  <div class="row align-items-center">
                                    <div class="col my-4">
                                      <span class="mb-1 text-lg text-success font-weight-bold">Nombre D'incident(s)</span></br>
                                      <span class="mb-1 text-lg text-success font-weight-bold"> CLÔTURÉ(S) </span>
                                    </div>
                                    <div class="col-4 text-right">
                                      <span style="font-size:3em;" class="text-success mb-0 cloture_gros">
                                          {{ $cloture < 10 ? 0 ."". $cloture : $cloture }}
                                      </span>
                                    </div>
                                  </div> <!-- /. row -->
                                </div> <!-- /. card-body -->
                              </div> <!-- /. card -->
                            </div> <!-- /. col -->
                            <div class="col-md-4">
                              <div class="card shadow border-primary mb-4">
                                <div class="card-body">
                                  <div class="row align-items-center">
                                    <div class="col my-4">
                                      <span class="mb-1 text-lg text-primary font-weight-bold">Nombre D'incident(s) </span></br>
                                      <span class="mb-1 text-lg text-primary font-weight-bold"> ENCOURS </span>
                                    </div>
                                    <div class="col-4 text-right">
                                      <h1 style="font-size:3em;" class="text-primary mb-0 encour_gros">
                                          {{ $encour < 10 ? 0 ."". $encour : $encour }}
                                      </h1>
                                    </div>
                                  </div> <!-- /. row -->
                                </div> <!-- /. card-body -->
                              </div> <!-- /. card -->
                            </div> <!-- /. col -->
                            <div class="col-md-4">
                              <div class="card shadow border-dark mb-4">
                                <div class="card-body">
                                  <div class="row align-items-center">
                                    <div class="col my-4">
                                      <span class="mb-1 text-lg font-weight-bold">Nombre D'incident(s)</span></br>
                                      <span class="mb-1 text-lg font-weight-bold"> ANNULÉ(S) </span>
                                    </div>
                                    <div class="col-4 text-right">
                                      <h1 style="font-size:3em;" class="mb-0 annule_gros">
                                          {{ $annul < 10 ? 0 ."". $annul : $annul }}
                                      </h1>
                                    </div>
                                  </div> <!-- /. row -->
                                </div> <!-- /. card-body -->
                              </div> <!-- /. card -->
                            </div> <!-- /. col -->
                      </div>

                      <hr style="margin-bottom:3em; margin-top:2em;">
                      
                      <div class="row" style="font-family: Century Gothic;">
                          <div class="content">
                            <div class="page-inner">
                                    <h4 class="page-title"></h4>
                                    <div class="page-category"></div>
                                    <div class="row">
                                      <div class="col-md-12">
                                              <div class="card">
                                                  <div class="card-header">
                                                      <div class="card-title">Evolution Des Incidents Aucour De L'année</div>
                                                  </div>
                                                  <div class="card-body">
                                                      <div style="visibility: hidden;" class="card-sub">
                                                        Sometimes you need a very complex legend. In these cases, it makes sense to generate an HTML legend. Charts provide a generateLegend() method on their prototype that returns an HTML string for the legend.
                                                      </div>
                                                      <div class="chart-container">
                                                          <canvas class="w-100" id="lineChart"></canvas>
                                                      </div>
                                                  </div>
                                              </div>
                                      </div>
                                    </div>
                            </div>
                          </div>
                      </div>

                      <div class="row my-4" style="font-family: Century Gothic;">
                            <div class="content">
                                <div class="page-inner">
                                    <h4 class="page-title"></h4>
                                    <div class="page-category"></div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="card-title">Statuts Incident(s)</div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="chart-container">
                                                        <canvas class="w-100 h-100" id="pieChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="card-title">Etats Incident(s) </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="chart-container">
                                                        <canvas class="w-100 h-100" id="doughnutChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="card-title">Radar Chart</div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="chart-container">
                                                        <canvas id="radarChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="card-title">Bubble Chart</div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="chart-container">
                                                        <canvas id="bubbleChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col-md-6 my-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="card-title">Statuts Incident(s)</div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="chart-container">
                                                        <canvas class="w-100 h-100" id="multipleLineChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 my-4">
                                                    <div class="chart-container">
                                                        <!-- <canvas class="w-100 h-100" id="multipleBarChart"></canvas> -->
                                                    </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      </div>

                      <hr style="margin-bottom:4em; margin-top:2em;">

                    <script>
                        var lineChart = document.getElementById('lineChart').getContext('2d');
                        var myLineChart = new Chart(lineChart, {
                          type: 'line',
                          data: {
                            labels: ["Jan", "Fev", "Mar", "Avr", "Mai", "Juin", "Juill", "Aout", "Sep", "Oct", "Nov", "Dec"],
                            datasets: [{
                              label: "Evolution Incident",
                              borderColor: "#1d7af3",
                              pointBorderColor: "#FFF",
                              pointBackgroundColor: "#1d7af3",
                              pointBorderWidth: 2,
                              pointHoverRadius: 4,
                              pointHoverBorderWidth: 1,
                              pointRadius: 4,
                              backgroundColor: 'transparent',
                              fill: true,
                              borderWidth: 2,
                              data: [{{$janv}}, {{$fev}}, {{$mars}}, {{$avril}}, {{$mai}}, {{$juin}}, {{$juill}}, {{$aout}}, {{$sept}}, {{$oct}}, {{$nov}}, {{$decc}}]
                            }]
                          },
                          options : {
                            responsive: true, 
                            maintainAspectRatio: false,
                            legend: {
                              position: 'bottom',
                              labels : {
                                padding: 10,
                                fontColor: '#1d7af3',
                              }
                            },
                            tooltips: {
                              bodySpacing: 4,
                              mode:"nearest",
                              intersect: 0,
                              position:"nearest",
                              xPadding:10,
                              yPadding:10,
                              caretPadding:10
                            },
                            layout:{
                              padding:{left:15,right:15,top:15,bottom:15}
                            }
                          }
                        });
                    </script>
                  @endcan

                  @can('dashboard_coordo')

                    <?php

                            $incidant_encours = array();
                            $incidant_enretard = array();
                            $incidant_cloturer = array();
                            $incidant_annuller = array();
                            $nombre_cloture_enretard = 0;
                            $nombre_cloture_a_temps = 0;
                            $a_temps = 0;
                            $enretard = 0;
                            $encour = 0;
                            $cloture = 0;
                            $annul = 0;
                            $width_encour = 0;
                            $width_non_encour = 0;
                            $width_annul = 0;
                            $width_non_annul = 0;
                            $width_cloture = 0;
                            $width_non_cloture = 0;
                            $width_enretard = 0;
                            $width_non_enretard = 0;

                            $taches_created = array();
                            $taches_closure = array();
                            $taches_ids = array();

                            $tab_ids = array();
                            $tab_created = array();
                            $tab_exited = array();

                            $janv = 0;
                            $fev = 0;
                            $mars = 0;
                            $avril = 0;
                            $mai = 0;
                            $juin = 0;
                            $juill = 0;
                            $aout = 0;
                            $sept = 0;
                            $oct = 0;
                            $nov = 0;
                            $decc = 0;

                            $janv_encours = 0;
                            $fev_encours = 0;
                            $mars_encours = 0;
                            $avril_encours = 0;
                            $mai_encours = 0;
                            $juin_encours = 0;
                            $juill_encours = 0;
                            $aout_encours = 0;
                            $sept_encours = 0;
                            $oct_encours = 0;
                            $nov_encours = 0;
                            $decc_encours = 0;

                            $janv_cloturer = 0;
                            $fev_cloturer = 0;
                            $mars_cloturer = 0;
                            $avril_cloturer = 0;
                            $mai_cloturer = 0;
                            $juin_cloturer = 0;
                            $juill_cloturer = 0;
                            $aout_cloturer = 0;
                            $sept_cloturer = 0;
                            $oct_cloturer = 0;
                            $nov_cloturer = 0;
                            $decc_cloturer = 0;

                            $janv_annuler = 0;
                            $fev_annuler = 0;
                            $mars_annuler = 0;
                            $avril_annuler = 0;
                            $mai_annuler = 0;
                            $juin_annuler = 0;
                            $juill_annuler = 0;
                            $aout_annuler = 0;
                            $sept_annuler = 0;
                            $oct_annuler = 0;
                            $nov_annuler = 0;
                            $decc_annuler = 0;

                            $tab_Qte_site = array();
                            $tab_Qte_site_departement = array();
                            if(is_iterable($sites)){
                            for ($jh=0; $jh < count($sites); $jh++) {
                              if($sites[$jh]->types->name == "AGENCE"){
                                  $site_cour = $sites[$jh];
                                  $value_cour = 0;
                                  for ($g=0; $g < count($incident_annee_encour); $g++) {
                                    $mon_inci = $incident_annee_encour[$g];
                                    if($mon_inci->site_id){
                                      if(intval($mon_inci->site_id) == intval($site_cour->id)){
                                        $value_cour +=1;
                                      }elseif (intval($mon_inci->site_declarateur) == intval($site_cour->id)) {
                                        $value_cour +=1;
                                      }
                                    }
                                  }
                                  array_push($tab_Qte_site, $value_cour);
                              }elseif ($sites[$jh]->types->name == "DEPARTEMENT") {
                                $site_cour = $sites[$jh];
                                $value_cour = 0;
                                for ($g=0; $g < count($incident_annee_encour); $g++) {
                                  $mon_inci = $incident_annee_encour[$g];
                                  if($mon_inci->site_id){
                                    if(intval($mon_inci->site_id) == intval($site_cour->id)){
                                      $value_cour +=1;
                                    }elseif (intval($mon_inci->site_declarateur) == intval($site_cour->id)) {
                                      $value_cour +=1;
                                    }
                                  }
                                }
                                array_push($tab_Qte_site_departement, $value_cour);

                              }
                            }}

                            if(is_iterable($incident_annee_encour)){
                            for ($c=0; $c < count($incident_annee_encour); $c++) {
                                $tine = $incident_annee_encour[$c];

                                
                                $extract_mois = intval(substr($tine->declaration_date, 5, 2));
                                switch ($extract_mois) {
                                  case 1:
                                    $janv +=1;
                                    break;
                                  case 2:
                                    $fev +=1;
                                    break;
                                  case 3:
                                    $mars +=1;
                                    break;
                                  case 4:
                                    $avril +=1;
                                    break;
                                  case 5:
                                    $mai +=1;
                                    break;
                                  case 6:
                                    $juin +=1;
                                    break;
                                  case 7:
                                    $juill +=1;
                                    break;
                                  case 8:
                                    $aout +=1;
                                    break;
                                  case 9:
                                    $sept +=1;
                                    break;
                                  case 10:
                                    $oct +=1;
                                    break;
                                  case 11:
                                    $nov +=1;
                                    break;
                                  case 12:
                                    $decc +=1;
                                    break;
                                  default:
                                    break;
                                }

                                if($tine->status == "ENCOURS"){
                                  $encour +=1;
                                  array_push($incidant_encours, $tine);

                                  if($tine->due_date){
                                      $auday = str_replace("-", "", date('Y-m-d'));
                                      $date_echeance = str_replace("-", "", $tine->due_date);
                                      if(intval($date_echeance) < intval($auday)){
                                          $enretard +=1;
                                          array_push($incidant_enretard, $tine);
                                      }else{
                                        $a_temps +=1;
                                      }
                                  }else{
                                    $a_temps +=1;
                                  }
                
                                }elseif($tine->status == "CLÔTURÉ"){
                                    $cloture +=1;
                                    array_push($incidant_cloturer, $tine);

                                    if($tine->due_date && $tine->closure_date){
                                      if(intval(str_replace("-", "", $tine->closure_date)) > intval(str_replace("-", "", $tine->due_date))){
                                          $nombre_cloture_enretard +=1;
                                      }else{
                                          $nombre_cloture_a_temps +=1;
                                      }
                                    }
                  
                                }else{
                                    $annul +=1;
                                    array_push($incidant_annuller, $tine);
                                }

                            }}//dd($enretard);

                            if(is_iterable($incidant_encours)){
                            for ($p=0; $p < count($incidant_encours); $p++) {
                              $mon_i = $incidant_encours[$p];
                              $extrac_mois = intval(substr($mon_i->declaration_date, 5, 2));
                              switch ($extrac_mois) {
                                case 1:
                                  $janv_encours +=1;
                                  break;
                                case 2:
                                  $fev_encours +=1;
                                  break;
                                case 3:
                                  $mars_encours +=1;
                                  break;
                                case 4:
                                  $avril_encours +=1;
                                  break;
                                case 5:
                                  $mai_encours +=1;
                                  break;
                                case 6:
                                  $juin_encours +=1;
                                  break;
                                case 7:
                                  $juill_encours +=1;
                                  break;
                                case 8:
                                  $aout_encours +=1;
                                  break;
                                case 9:
                                  $sept_encours +=1;
                                  break;
                                case 10:
                                  $oct_encours +=1;
                                  break;
                                case 11:
                                  $nov_encours +=1;
                                  break;
                                case 12:
                                  $decc_encours +=1;
                                  break;
                                default:
                                  break;
                              }

                            }}

                            if(is_iterable($incidant_cloturer)){
                            for ($ee=0; $ee < count($incidant_cloturer); $ee++) {
                              $monInci = $incidant_cloturer[$ee];
                              $extra_mois = intval(substr($monInci->declaration_date, 5, 2));
                              switch ($extra_mois) {
                                case 1:
                                  $janv_cloturer +=1;
                                  break;
                                case 2:
                                  $fev_cloturer +=1;
                                  break;
                                case 3:
                                  $mars_cloturer +=1;
                                  break;
                                case 4:
                                  $avril_cloturer +=1;
                                  break;
                                case 5:
                                  $mai_cloturer +=1;
                                  break;
                                case 6:
                                  $juin_cloturer +=1;
                                  break;
                                case 7:
                                  $juill_cloturer +=1;
                                  break;
                                case 8:
                                  $aout_cloturer +=1;
                                  break;
                                case 9:
                                  $sept_cloturer +=1;
                                  break;
                                case 10:
                                  $oct_cloturer +=1;
                                  break;
                                case 11:
                                  $nov_cloturer +=1;
                                  break;
                                case 12:
                                  $decc_cloturer +=1;
                                  break;
                                default:
                                  break;
                              }

                            }}

                            if(is_iterable($incidant_annuller)){
                            for ($bn=0; $bn < count($incidant_annuller); $bn++) {
                              $monIncid = $incidant_annuller[$bn];
                              $extr_mois = intval(substr($monIncid->declaration_date, 5, 2));
                              switch ($extr_mois) {
                                case 1:
                                  $janv_annuler +=1;
                                  break;
                                case 2:
                                  $fev_annuler +=1;
                                  break;
                                case 3:
                                  $mars_annuler +=1;
                                  break;
                                case 4:
                                  $avril_annuler +=1;
                                  break;
                                case 5:
                                  $mai_annuler +=1;
                                  break;
                                case 6:
                                  $juin_annuler +=1;
                                  break;
                                case 7:
                                  $juill_annuler +=1;
                                  break;
                                case 8:
                                  $aout_annuler +=1;
                                  break;
                                case 9:
                                  $sept_annuler +=1;
                                  break;
                                case 10:
                                  $oct_annuler +=1;
                                  break;
                                case 11:
                                  $nov_annuler +=1;
                                  break;
                                case 12:
                                  $decc_annuler +=1;
                                  break;
                                default:
                                  break;
                              }

                            }}

                            if(count($incident_annee_encour) > 0){
                              $width_encour = intval($encour/count($incident_annee_encour)*100);
                              $width_annul = intval($annul/count($incident_annee_encour)*100);
                              $width_cloture = intval($cloture/count($incident_annee_encour)*100);
                              $width_enretard = $encour > 0 ? intval(($enretard/$encour) * 100) : 0;
                              $width_non_enretard = $encour > 0 ? intval(($a_temps/$encour)*100) : 0;
                              $width_non_cloture = intval((($encour + $annul)/count($incident_annee_encour))*100);
                              $width_non_encour = intval((($cloture + $annul)/count($incident_annee_encour))*100);
                              $width_non_annul = intval((($encour + $cloture)/count($incident_annee_encour))*100);
                            }

                            if(is_iterable($incidents)){
                            for ($j=0; $j < count($incidents); $j++) {
                              $indi = $incidents[$j];
                              array_push($tab_ids, $indi->number);
                              array_push($tab_exited, $indi->due_date);
                              array_push($tab_created, substr(strval($indi->declaration_date), 0, 10));
                            }}

                            if(is_iterable($tasks)){
                            for ($v=0; $v < count($tasks); $v++) {
                              $t = $tasks[$v];
                              array_push($taches_ids, $t->id);
                              array_push($taches_closure, $t->closure_date);
                              array_push($taches_created, substr(strval($t->declaration_date), 0, 10));
                            }}

                    ?>

                    <hr style="margin-bottom:2em; margin-top:1em;">
                    <fieldset style="margin: 8px; border: 1px solid silver; border-radius: 4px; padding: 8px;">
                      <legend style="padding: 2px;">Critère(s) De Recherche</legend>
                        <div class="row justify-content-center my-2">
                              <div style="margin-top:0.6em;"><i class="fe fe-16 fe-home"></i></div>
                              <div class="col-md-5 mb-1 mr-4">
                                    <select 
                                            class="custom-select text-lg border-primary"
                                            id="citadelle"
                                            data-user_conneter="{{ json_encode(Auth::user()) }}"
                                            data-taches_ids="{{ json_encode($taches_ids) }}"
                                            data-taches_created="{{ json_encode($taches_created) }}"
                                            data-users="{{ json_encode($users) }}"
                                            data-tasks="{{ json_encode($tasks) }}"
                                            data-ids="{{ json_encode($tab_ids) }}"
                                            data-created="{{ json_encode($tab_created) }}"
                                            data-exited="{{ json_encode($tab_exited) }}"
                                            data-incidents="{{ json_encode($incidents) }}"
                                            data-sites="{{ json_encode($sites) }}"
                                            data-users_incidents="{{ json_encode($users_incidents) }}"
                                            data-regions="{{ json_encode($regions) }}">
                                        <option selected value="">Choisissez Un Site...</option>
                                        <option value="dg">DIRECTION GENERALE</option>
                                        @if(is_iterable($sites))
                                        @foreach($sites as $site)
                                            <option value="{{ $site->id }}">{{ $site->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                              </div>

                              <div style="margin-top:0.6em;"><i class="fe fe-16 fe-globe"></i></div>
                              <div class="col-md-5 mb-1">
                                    <select 
                                            class="custom-select text-lg border-primary"
                                            id="regionnn"
                                            data-user_conneter="{{ json_encode(Auth::user()) }}"
                                            data-taches_ids="{{ json_encode($taches_ids) }}"
                                            data-taches_created="{{ json_encode($taches_created) }}"
                                            data-users="{{ json_encode($users) }}"
                                            data-tasks="{{ json_encode($tasks) }}"
                                            data-ids="{{ json_encode($tab_ids) }}"
                                            data-created="{{ json_encode($tab_created) }}"
                                            data-exited="{{ json_encode($tab_exited) }}"
                                            data-incidents="{{ json_encode($incidents) }}"
                                            data-users_incidents="{{ json_encode($users_incidents) }}"
                                            data-sites="{{ json_encode($sites) }}">
                                        <option selected value="">Choisissez Une Région...</option>
                                        @if(is_iterable($regions))
                                        @foreach($regions as $region)
                                            <option value="{{ $region }}">{{ $region }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                              </div>
                        </div>
                    </fieldset>

                    <fieldset style="margin: 8px; border: 1px solid silver; padding: 8px; border-radius: 4px; font-size: 2em;">
                        <legend style="padding: 2px;"></legend>
                        <div class="row justify-content-center my-2">
                              <strong>Entre Le</strong>
                              <div class="col-md-3 mr-4">
                                <div class="input-group mb-1">
                                      <input 
                                              type="date"
                                              class="form-control text-xl border-primary" 
                                              id="DateDebut"
                                              data-user_conneter="{{ json_encode(Auth::user()) }}"
                                              data-taches_ids="{{ json_encode($taches_ids) }}"
                                              data-taches_created="{{ json_encode($taches_created) }}"
                                              data-users="{{ json_encode($users) }}"
                                              data-tasks="{{ json_encode($tasks) }}"
                                              data-ids="{{ json_encode($tab_ids) }}"
                                              data-created="{{ json_encode($tab_created) }}"
                                              data-exited="{{ json_encode($tab_exited) }}"
                                              data-incidents="{{ json_encode($incidents) }}"
                                              data-sites="{{ json_encode($sites) }}"
                                              data-users_incidents="{{ json_encode($users_incidents) }}"
                                              data-regions="{{ json_encode($regions) }}">
                                </div>
                              </div>

                              <strong>Et Le</strong>
                              <div class="col-md-3">
                                <div class="input-group mb-1">
                                      <input 
                                              disabled
                                              type="date" 
                                              class="form-control text-xl border-primary"
                                              id="DateFin"
                                              data-user_conneter="{{ json_encode(Auth::user()) }}"
                                              data-taches_ids="{{ json_encode($taches_ids) }}"
                                              data-taches_created="{{ json_encode($taches_created) }}"
                                              data-users="{{ json_encode($users) }}"
                                              data-tasks="{{ json_encode($tasks) }}"
                                              data-ids="{{ json_encode($tab_ids) }}"
                                              data-created="{{ json_encode($tab_created) }}"
                                              data-exited="{{ json_encode($tab_exited) }}"
                                              data-incidents="{{ json_encode($incidents) }}"
                                              data-sites="{{ json_encode($sites) }}"
                                              data-users_incidents="{{ json_encode($users_incidents) }}"
                                              data-regions="{{ json_encode($regions) }}">
                                </div>
                              </div>
                        </div>
                    </fieldset>


                    <hr style="margin-bottom:2em; margin-top:2em;">

                      <div class="row">
                                <div class="col-md-4">
                                  <div class="card shadow border-info mb-4">
                                    <div class="card-body">
                                      <div class="row align-items-center">
                                        <div class="col my-4">
                                          <span class="text-lg font-weight-bold">Nombre D'incident(s)</span></br>
                                          <span class="my-3 text-lg font-weight-bold">TOTAL</span>
                                        </div>
                                        <div class="col-4 text-right">
                                          <span style="font-size:3em;" class="mb-0 tout_ta_fait">
                                              {{ count($incident_annee_encour) < 10 ? 0 ."". count($incident_annee_encour) : count($incident_annee_encour) }}
                                            </span>
                                        </div>
                                      </div> <!-- /. row -->
                                    </div> <!-- /. card-body -->
                                  </div> <!-- /. card -->
                                </div>
                                <div class="col-md-4">
                                  <div class="card shadow border-info mb-4">
                                    <div class="card-body">
                                      <div class="row align-items-center">
                                        <div class="col my-4">
                                          <span class="text-lg font-weight-bold">Nombre D'incident(s)</span></br>
                                          <span class="my-3 text-lg font-weight-bold">DEJA PRIS EN COMPTE</span>
                                        </div>
                                        <div class="col-4 text-right">
                                          <span style="font-size:3em;" class="mb-0 tout_ta_fait">
                                              {{ $deja_pris_en_compte < 10 ? 0 ."". $deja_pris_en_compte : $deja_pris_en_compte }}
                                            </span>
                                        </div>
                                      </div> <!-- /. row -->
                                    </div> <!-- /. card-body -->
                                  </div> <!-- /. card -->
                                </div> <!-- /. col -->
                      </div>
                      <div class="row justify-content-center" style="font-family: Century Gothic;">
                            <div class="col-md-4">
                              <div class="card shadow border-success mb-4">
                                <div class="card-body">
                                  <div class="row align-items-center">
                                    <div class="col my-4">
                                      <span class="text-lg text-success font-weight-bold">Nombre D'incident(s)</span></br>
                                      <span class="mb-1 text-lg text-success font-weight-bold">CLÔTURÉ(S)</span>
                                    </div>
                                    <div class="col-4 text-right">
                                      <h1 style="font-size:3em;" class="text-success mb-0 cliotu">
                                          {{ $cloture < 10 ? 0 ."". $cloture : $cloture }}
                                      </h1>
                                    </div>
                                  </div> <!-- /. row -->
                                </div> <!-- /. card-body -->
                              </div> <!-- /. card -->
                            </div> <!-- /. col -->
                            <div class="col-md-4">
                              <div class="card shadow border-primary mb-4">
                                <div class="card-body">
                                  <div class="row align-items-center">
                                    <div class="col my-4">
                                      <span class="mb-1 text-lg text-primary font-weight-bold">Nombre D'incident(s)</span></br>
                                      <span class="text-lg text-primary font-weight-bold">ENCOURS</span>
                                    </div>
                                    <div class="col-4 text-right">
                                      <h1 style="font-size:3em;" class="text-primary mb-0 encourgiant">
                                          {{ $encour < 10 ? 0 ."". $encour : $encour }}
                                      </h1>
                                    </div>
                                  </div> <!-- /. row -->
                                </div> <!-- /. card-body -->
                              </div> <!-- /. card -->
                            </div> <!-- /. col -->
                            <div class="col-md-4">
                              <div class="card shadow border-dark mb-4">
                                <div class="card-body">
                                  <div class="row align-items-center">
                                    <div class="col my-4">
                                      <span class="mb-1 text-lg font-weight-bold">Nombre D'incident(s)</span></br>
                                      <span class="text-lg font-weight-bold">ANNULÉ(S)</span>
                                    </div>
                                    <div class="col-4 text-right">
                                      <h1 style="font-size:3em;" class="mb-0 annulegiant">
                                          {{ $annul < 10 ? 0 ."". $annul : $annul }}
                                      </h1>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                      </div>
                      <div class="row">
                            <div class="col-md-4">
                              <div class="card shadow border-danger mb-4">
                                <div class="card-body">
                                  <div class="row align-items-center">
                                    <div class="col my-4">
                                      <span class="text-lg text-danger font-weight-bold">Nombre D'incident(s)</span></br>
                                      <span class="mb-1 text-lg text-danger font-weight-bold"> EN-RETARD </span>
                                    </div>
                                    <div class="col-4 text-right">
                                      <h1 style="font-size:3em;" class="text-danger mb-0 cliotu">
                                          {{ $enretard < 10 ? 0 ."". $enretard : $enretard }}
                                      </h1>
                                    </div>
                                  </div> <!-- /. row -->
                                </div> <!-- /. card-body -->
                              </div> <!-- /. card -->
                            </div> <!-- /. col -->
                            <div class="col-md-4">
                              <div class="card shadow border-secondary mb-4">
                                <div class="card-body">
                                  <div class="row align-items-center">
                                    <div class="col my-4">
                                      <span class="text-lg text-tertiary font-weight-bold">Nombre D'incident(s)</span></br>
                                      <span class="mb-1 text-lg text-tertiary font-weight-bold"> DANS LES DELAIS </span>
                                    </div>
                                    <div class="col-4 text-right">
                                      <h1 style="font-size:3em;" class="text-tertiary mb-0 cliotu">
                                          {{ $a_temps < 10 ? 0 ."". $a_temps : $a_temps }}
                                      </h1>
                                    </div>
                                  </div> <!-- /. row -->
                                </div> <!-- /. card-body -->
                              </div> <!-- /. card -->
                            </div> <!-- /. col -->
                      </div>

                    <hr style="margin-bottom: 3em; margin-top: 3em;">

                      <!-- <div class="row" style="font-family: Century Gothic;">
                          <div class="content">
                              <div class="page-inner">
                                      <h4 class="page-title"></h4>
                                      <div class="page-category"></div>
                                      <div class="row">
                                        <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="card-title">Evolution Des Incidents Aucour De L'année</div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div style="visibility: hidden;" class="card-sub">
                                                          Sometimes you need a very complex legend. In these cases, it makes sense to generate an HTML legend. Charts provide a generateLegend() method on their prototype that returns an HTML string for the legend.
                                                        </div>
                                                        <div class="chart-container">
                                                            <canvas class="w-100" id="lineChart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                      </div>
                              </div>
                          </div>
                      </div> -->

                      <div class="row my-4" style="font-family: Century Gothic;">
                            <div class="content">
                                      <div class="page-inner">
                                          <h4 class="page-title"></h4>
                                          <div class="page-category"></div>
                                          <div class="row">
                                          <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                  <div class="card-title">Evolution Des Incidents Par Agence</div>
                                                </div>
                                                <div class="card-body">
                                                    <div style="visibility: hidden;" class="card-sub mb-0">
                                                      Sometimes you need a very complex legend. In these cases, it makes sense to generate an HTML legend. Charts provide a generateLegend() method on their prototype that returns an HTML string for the legend.
                                                    </div>

                                                    <div class="chart-container">
                                                        <canvas class="w-100" id="barChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                          </div>
                                      </div>
                            </div>
                      </div>

                      <div class="row my-4" style="font-family: Century Gothic;">
                            <div class="content">
                                      <div class="page-inner">
                                          <h4 class="page-title"></h4>
                                          <div class="page-category"></div>
                                          <div class="row">
                                          <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                  <div class="card-title">Evolution Des Incidents Par Procéssus</div>
                                                </div>
                                                <div class="card-body">
                                                    <div style="visibility: hidden;" class="card-sub mb-0">
                                                      Sometimes you need a very complex legend. In these cases, it makes sense to generate an HTML legend. Charts provide a generateLegend() method on their prototype that returns an HTML string for the legend.
                                                    </div>

                                                    <div class="chart-container">
                                                        <canvas class="w-100" id="barChartProcessus11"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                          </div>
                                      </div>
                            </div>
                      </div>

                      <div class="row my-4" style="font-family: Century Gothic;">
                            <div class="content">
                                      <div class="page-inner">
                                          <h4 class="page-title"></h4>
                                          <div class="page-category"></div>
                                          <div class="row">
                                          <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                  <div class="card-title">Evolution Des Incidents Par Département</div>
                                                </div>
                                                <div class="card-body">
                                                    <div style="visibility: hidden;" class="card-sub mb-0">
                                                      Sometimes you need a very complex legend. In these cases, it makes sense to generate an HTML legend. Charts provide a generateLegend() method on their prototype that returns an HTML string for the legend.
                                                    </div>

                                                    <div class="chart-container">
                                                        <canvas class="w-100" id="barChartDepartement"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                          </div>
                                      </div>
                            </div>
                      </div>

                      <div class="row my-4" style="font-family: Century Gothic;">
                            <div class="content">
                                <div class="page-inner">
                                    <h4 class="page-title"></h4>
                                    <div class="page-category"></div>
                                    <div class="row">
                                        <div class="col-md-12 my-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="card-title">Comparaison Evolution Incident(s) Par Statut</div>
                                                </div>
                                                <div class="card-body">
                                                    <div style="visibility: hidden;" class="card-sub mb-0">
                                                      Sometimes you need a very complex legend. In these cases, it makes sense to generate an HTML legend. Charts provide a generateLegend() method on their prototype that returns an HTML string for the legend.
                                                    </div>
                                                    <div class="chart-container">
                                                        <canvas class="w-100" id="multipleLineChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      </div>

                      <div class="row my-4" style="font-family: Century Gothic;">
                            <div class="content">
                                <div class="page-inner">
                                    <h4 class="page-title"></h4>
                                    <div class="page-category"></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="card-title">Statuts Incident(s)</div>
                                                </div>
                                                <div class="card-body">
                                                    <div style="visibility: hidden;" class="card-sub mb-0">
                                                      Sometimes you need a very complex legend. In these cases, it makes sense to generate an HTML legend. Charts provide a generateLegend() method on their prototype that returns an HTML string for the legend.
                                                    </div>
                                                    <div class="chart-container">
                                                        <canvas class="w-100" id="pieChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6 my-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="card-title">Comparaison Evolution Incident(s) Par Statut</div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="chart-container">
                                                        <canvas class="w-100 h-100" id="multipleLineChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                      </div>


                      <hr class="my-4">
                      <!-- <h1 class="text-xl" style="margin-bottom: 3em;"><i class="fe fe-32 fe-bell"></i><i style="font-size:15px;" class="fe fe-percent mr-2"></i>POURCENTAGE INCIDENT  PAR SERVICE</h1> -->
                      
                    <script>

                      		let barChart = document.getElementById('barChart').getContext('2d');
                          let allSites = Array();
                          let syty = {!! json_encode($sites); !!}
                              syty.forEach(site => {
                                if(site.types.name == "AGENCE"){
                                allSites.push(site.name.substr(8));
                              }
                          });

                          let values = {!! json_encode($tab_Qte_site); !!}

                          var myBarChart = new Chart(barChart, {
                            type: 'bar',
                            data: {
                              labels: allSites,
                              datasets : [{
                                label: "Nombre D'incident",
                                backgroundColor: 'rgb(23, 125, 255)',
                                borderColor: 'rgb(23, 125, 255)',
                                data: values,
                              }],
                            },
                            options: {
                              responsive: true, 
                              maintainAspectRatio: false,
                              scales: {
                                yAxes: [{
                                  ticks: {
                                    beginAtZero:true
                                  }
                                }]
                              },
                            }
                          });


                          let barChartDepartement = document.getElementById('barChartDepartement').getContext('2d');
                          let alldepartement = Array();
                              syty.forEach(site => {barChartDepartement
                                if(site.types.name == "DEPARTEMENT"){
                                  alldepartement.push(site.name);
                              }
                          });
                          
                          let valuesDepart = {!! json_encode($tab_Qte_site_departement); !!}

                          var myBarChartD = new Chart(barChartDepartement, {
                            type: 'bar',
                            data: {
                              labels: alldepartement,
                              datasets : [{
                                label: "Nombre D'incident",
                                backgroundColor: 'rgb(23, 125, 255)',
                                borderColor: 'rgb(23, 125, 255)',
                                data: valuesDepart,
                              }],
                            },
                            options: {
                              responsive: true, 
                              maintainAspectRatio: false,
                              scales: {
                                yAxes: [{
                                  ticks: {
                                    beginAtZero:true
                                  }
                                }]
                              },
                            }
                          });

                          //BAR CHAR PROCESSUS
                          let barChartProces = document.getElementById('barChartProcessus11').getContext('2d');
                          let allProcess = Array();
                          let possessus = {!! json_encode($processus_incident); !!}
                              possessus.forEach(Pros => {
                              allProcess.push(Pros);
                          });

                          let allValueProsessus = Array();
                          let values_proces = {!! json_encode($incident_par_processus); !!}
                          var myBarChartProcessus = new Chart(barChartProces, {
                            type: 'bar',
                            data: {
                              labels: allProcess,
                              datasets : [{
                                label: "NOMBRE D'INCIDENT",
                                backgroundColor: 'rgb(23, 125, 255)',
                                borderColor: 'rgb(23, 125, 255)',
                                data: values_proces,
                              }],
                            },
                            options: {
                              responsive: true, 
                              maintainAspectRatio: false,
                              scales: {
                                yAxes: [{
                                  ticks: {
                                    beginAtZero:true
                                  }
                                }]
                              },
                            }
                          });

                    </script>
                  @endcan

            </div>
        </div>
    </div>
    
    <!-- Modal liste -->
    <div style="font-family: Century Gothic;" class="modal" id="modal_liste_incident" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="text-lg" id="verticalModalTitle">
                                    <i class="fe fe-list" style="font-size:15px;"></i>
                                    <i class="fe fe-bell mr-3" style="font-size:20px;"></i>
                                  Liste Incident
                              </h5>
                              <button id="btnExitModalTask" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                    <div class="card">
                                            <div class="card-header mt-2">
                                                <div class="row">
                                                  <span class="text-xl ml-3" id="name_of_hight"></span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row justify-content-center">
                                                  <div class="col-12">

                                                    <div class="row text-uppercase">
                                                      <div class="col ml-2">
                                                        <div class="row float-left col-md-12" id="cloturation">
                                                          <div class="form-group mr-4">
                                                              <strong class="mr-3">Nombre Incident(s) Clôturé A Temps</strong ><strong id="a_temps"></strong>
                                                          </div>
                                                          <div class="form-group">
                                                              <strong class="mr-3">Nombre Incident(s) Clôturé En-Retard</strong><strong id="en_ret"></strong>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>

                                                    <div class="row my-4">
                                                        <div class="col ml-auto my-2">
                                                                <div class="row float-left col-md-12">
                                                                    <div class="col-md-3">
                                                                      <input type="text" name="" id="search_incidant" class="form-control text-xs" placeholder="Search...">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="input-group">
                                                                            <input type="date" class="form-control" id="searchDate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="searchMonthDash" type="month">
                                                                    </div>
                                                                </div>
                                                        </div>
                                                      <div class="col-md-12">
                                                          <div class="card-body">
                                                            <table class="table table-hover datatables text-center" id="dataTable_incident">
                                                              <thead class="thead-dark">
                                                                <tr style="font-size: 0.9em;">
                                                                  <th><span class="dot dot-lg bg-primary mr-1"></span>Numéro</th>
                                                                  <th>Déclaration</th>
                                                                  <th>Echéance</th>
                                                                  <th>Procéssus Impacté(s)</th>
                                                                  <th>Catégorie</th>
                                                                  <th>Priorité</th>
                                                                  <th>Tâche</th>
                                                                  <th>Action</th>
                                                                </tr>
                                                              </thead>
                                                              <tbody id="shaw">
                                                              </tbody>
                                                            </table>
                                                          </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                            </div>
                          </div>
                        </div>
    </div>
    
    <!-- Modal Task Liste -->
    <div style="font-family: Century Gothic;" class="modal" id="modall_tasks_incidents" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="text-lg" id="verticalModalTitle">
                                    <i class="fe fe-list" style="font-size:15px;"></i>
                                    <i class="fe fe-anchor mr-3" style="font-size:20px;"></i>
                                  Liste Tâche
                              </h5>
                              <button id="btnTaskListExte" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                    <div class="card">
                                            <div class="card-header mt-2">
                                                <div class="row">
                                                  <span class="text-xl ml-3" id="name_of_mon_incident"></span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row justify-content-center">
                                                  <div class="col-12">

                                                    <div class="row text-uppercase">
                                                      <div class="col ml-2">
                                                        <div class="row float-left col-md-12" id="clotu_taske">
                                                          <div class="form-group mr-4">
                                                              <strong class="mr-3">Nombre Tâche(s) Clôturé A Temps</strong ><strong id="tach_a_temps">0</strong>
                                                          </div>
                                                          <div class="form-group">
                                                              <strong class="mr-3">Nombre Tâche(s) Clôturé En-Retard</strong><strong id="tach_en_ret">0</strong>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>

                                                    <div class="row my-4">
                                                        <div class="col ml-auto my-2">
                                                                <div class="row float-left col-md-12">
                                                                    <div class="col-md-3">
                                                                      <input type="text" name="" id="" class="form-control text-xs" placeholder="Search...">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="input-group">
                                                                            <input type="date" class="form-control" id="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input class="form-control" id="" type="month">
                                                                    </div>
                                                                </div>
                                                        </div>
                                                      <div class="col-md-12">
                                                          <div class="card-body">
                                                            <table class="table table-hover datatables text-center" id="dataTable_incident">
                                                              <thead class="thead-dark">
                                                                <tr style="font-size: 0.9em;">
                                                                  <th>Description De La Tâche</th>
                                                                  <th>Déclaration</th>
                                                                  <th>Echéance</th>
                                                                  <th>Entité Concerné</th>
                                                                  <th>Dégré Réalisation</th>
                                                                  <th>Statut</th>
                                                                  <th>Action</th>
                                                                </tr>
                                                              </thead>
                                                              <tbody id="shadow">
                                                              </tbody>
                                                            </table>
                                                          </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                            </div>
                          </div>
                        </div>
    </div>

    <!-- Modal error date-->
    <div class="modal" id="duedi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-sm modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-clock mr-2"></i>
                                        Erreur Date</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation_due_date" disabled style="width:100%; height:6em;border-style:none; resize: none; font-size:15px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_btn_ude" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>


    <!-- MODAL INFO INCIDENT -->
    <div id="modal_infos_incidant" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-info mr-3"></i>
                                    <span class="text-lg" style="font-family: Century Gothic;">Informations Incident</span>
                                </h5>
                                <button id="close_fight" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="col-md-12 mb-4 mt-4">
                                        <div class="card shadow">
                                            <div class="card-header">
                                                <div class="row text-lg my-4">
                                                    <div class="col-md-6 text-left"><strong>Numéro Incident</strong></div>
                                                    <div class="col-md-6 text-right">
                                                        <strong class="card-title"><i class="no"></i></strong>
                                                    </div>
                                                </div>
                                            <!-- <a class="float-right small text-muted" href="#!">Voir Tous</a> -->
                                            </div>
                                            <div class="card-body">
                                                <div class="list-group list-group-flush my-n3">
                                                  <div class="list-group-item">
                                                      <div class="row align-items-center">
                                                          <div class="col">
                                                              <small><strong></strong></small>
                                                              <div class="my-0 big"><span class="deja_pris_encompte"></span></div>
                                                          </div>
                                                          <div class="col-auto">
                                                              <small class="badge badge-pill badge-light text-uppercase">Etat De L'incident</small>
                                                          </div>
                                                      </div>
                                                  </div> <!-- / .row -->

                                                  <div class="list-group-item">
                                                      <div class="row align-items-center">
                                                      <div class="col">
                                                        <small><strong></strong></small>
                                                        <div class="my-0 big"><span class="creat_dat"></span></div>
                                                      </div>
                                                      <div class="col-auto">
                                                        <small class="badge badge-pill badge-light text-uppercase">Date De Déclaration</small>
                                                      </div>
                                                  </div>
                                                </div> <!-- / .row -->

                                                <div class="list-group-item">
                                                  <div class="row align-items-center">
                                                    <div class="col">
                                                        <small><strong></strong></small>
                                                        <div class="my-0 big"><span class="due_dat"></span></div>
                                                    </div>
                                                    <div class="col-auto">
                                                      <small class="badge badge-pill badge-light text-uppercase">Date D'échéance</small> 
                                                    </div>
                                                  </div>
                                                </div> <!-- / .row -->
                                                <div class="list-group-item">
                                                  <div class="row align-items-center">
                                                    <div class="col">
                                                        <small><strong></strong></small>
                                                        <div class="my-0 big"><span class="closur_dat"></span></div>
                                                    </div>
                                                    <div class="col-auto">
                                                      <small class="badge badge-pill badge-light text-uppercase">Date De CLÔTURÉ</small>   
                                                    </div>
                                                  </div>
                                                </div> <!-- / .row -->

                                                <div class="list-group-item">
                                                  <div class="row align-items-center">
                                                    <div class="col">
                                                        <small><strong></strong></small>
                                                        <div class="my-0 big"><span class="stat_inci"></span></div>
                                                    </div>
                                                    <div class="col-auto">
                                                      <small class="badge badge-pill badge-light text-uppercase">Statut</small>
                                                    </div>
                                                  </div>
                                                </div> <!-- / .row -->

                                                <div class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                    <small><strong></strong></small>
                                                    <div class="my-0 big"><span class="desc"></span></div>
                                                    </div>
                                                    <div class="col-auto">
                                                      <small class="badge badge-pill badge-light text-uppercase">Description</small>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                    <small><strong></strong></small>
                                                    <div class="my-0 big"><span class="cose"></span></div>
                                                    </div>
                                                    <div class="col-auto">
                                                      <small class="badge badge-pill badge-light text-uppercase">Cause</small>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                    <small><strong></strong></small>
                                                    <div class="my-0 big"><span class="perim"></span></div>
                                                    </div>
                                                    <div class="col-auto">
                                                      <small class="badge badge-pill badge-light text-uppercase">Périmètre</small>
                                                    </div>
                                                </div> <!-- / .row -->
                                                </div>
                                                <div class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                    <small><strong></strong></small>
                                                    <div class="my-0 big"><span class="actions_do"></span></div>
                                                    </div>
                                                    <div class="col-auto">
                                                      <small class="badge badge-pill badge-light text-uppercase">Actions Ménées</small>
                                                    </div>
                                                </div> <!-- / .row -->
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <small><strong></strong></small>
                                                            <div class="my-0 big"><span class="processus_impacter"></span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <small class="badge badge-pill badge-light text-uppercase">Procéssus Impacté</small>
                                                        </div>
                                                    </div>
                                                </div> <!-- / .row -->
                                                <div class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                    <small><strong></strong></small>
                                                    <div class="my-0 big"><span class="tac"></span></div>
                                                    </div>
                                                    <div class="col-auto">
                                                      <small class="badge badge-pill badge-light text-uppercase">Tâches</small>
                                                    </div>
                                                </div>
                                                </div> <!-- / .row -->
                                                <div class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                    <small><strong></strong></small>
                                                    <div class="my-0 big"><span class="kate"></span></div>
                                                    </div>
                                                    <div class="col-auto">
                                                      <small class="badge badge-pill badge-light text-uppercase">Catégorie</small>
                                                    </div>
                                                </div>
                                                </div> <!-- / .row -->
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <small><strong></strong></small>
                                                            <div class="my-0 big"><span class="site_emeter"></span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                          <small class="badge badge-pill badge-light text-uppercase">Entité Emétteur</small>
                                                        </div>
                                                    </div>
                                                </div> <!-- / .row -->
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <small><strong></strong></small>
                                                            <div class="my-0 big"><span class="syte_receppt"></span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                          <small class="badge badge-pill badge-light text-uppercase">Entité Récèpteur</small>
                                                        </div>
                                                    </div>
                                                </div> <!-- / .row -->
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <small><strong></strong></small>
                                                            <div class="my-0 big"><span class="observation_coordos"></span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <small class="badge badge-pill badge-light text-uppercase">Observation Du Coordonateur</small>
                                                        </div>
                                                    </div>
                                                </div> <!-- / .row -->
                                            </div> <!-- / .list-group -->
                                            </div> <!-- / .card-body -->
                                        </div> <!-- / .card -->
                          </div>
                        </div>
    </div> <!-- small modal -->


  <script>

    var janv = 0;
    var fev = 0;
    var mars = 0;
    let avril = 0;
    var mai = 0;
    var juin = 0;
    var juill = 0;
    var aout = 0;
    var sept = 0;
    var oct = 0;
    var nov = 0;
    var decc = 0;
    
    var incidents = {!! json_encode($incidents); !!}
    var numbers = {!! json_encode($tab_ids) !!}
    var mon_tab_date = {!! json_encode($tab_created) !!}
    var incidentAprendrEnCompte = [];

    $(document).ready(function(){

        for (let me = 0; me < incidents.length; me++) {
          const tins = incidents[me];
          
          if ((tins.observation_rex) && (!tins.deja_pris_en_compte)) {
            let annee_incid = parseInt(mon_tab_date[me].substring(0, 4));

            if(annee_incid == parseInt(new Date().getFullYear())){
              incidentAprendrEnCompte.push(tins);
            }
          }
        }

        for (let mr = 0; mr < incidentAprendrEnCompte.length; mr++) {
          const icidant = incidentAprendrEnCompte[mr];
          
          let indes = -1;
          for (let fs = 0; fs < numbers.length; fs++) {
            const numeru = numbers[fs];
            if(numeru == icidant.number){
              indes = fs;
              break;
            }
          }

          let mois = parseInt(mon_tab_date[indes].substring(5, 7));
          
          switch (mois) {
            case 1:
              janv +=1;
              break;
            case 2:
              fev +=1;
              break;
            case 3:
              mars +=1;
              break;
            case 4:
              avril +=1;
              break;
            case 5:
              mai +=1;
              break;
            case 6:
              juin +=1;
              break;
            case 7:
              juill +=1;
              break;
            case 8:
              aout +=1;
              break;
            case 9:
              sept +=1;
              break;
            case 10:
              oct +=1;
              break;
            case 11:
              nov +=1;
              break;
            case 12:
              decc +=1;
              break;
            default:
              break;
          }
        }
    });

    $(document).on('change', '#DateFin', function(){

        let debut = parseInt($('#DateDebut').val().replaceAll("-", ""));
        let fin = parseInt($('#DateFin').val().replaceAll("-", ""));

        for (let vt = 0; vt < incidents.length; vt++) {
                const iir = incidents[vt];

                let date_declaration = parseInt(mon_tab_date[vt].replaceAll("-", ""));

                if(
                    ((date_declaration == debut) && (date_declaration < fin)) ||
                    ((date_declaration > debut) && (date_declaration < fin)) ||
                    ((date_declaration > debut) && (date_declaration == fin)) ||
                    ((date_declaration == debut) && (date_declaration == fin))
                 ) 
                {
                        if ((iir.observation_rex) && (!iir.deja_pris_en_compte)) {
                            incidentAprendrEnCompte.push(iir);
                        }
                }

        }

        for (let mr = 0; mr < incidentAprendrEnCompte.length; mr++) {
          const icidant = incidentAprendrEnCompte[mr];
          
          let indes = -1;
          for (let fs = 0; fs < numbers.length; fs++) {
            const numeru = numbers[fs];
            if(numeru == icidant.number){
              indes = fs;
              break;
            }
          }

          let mois = parseInt(mon_tab_date[indes].substring(5, 7));
          
          switch (mois) {
            case 1:
              janv +=1;
              break;
            case 2:
              fev +=1;
              break;
            case 3:
              mars +=1;
              break;
            case 4:
              avril +=1;
              break;
            case 5:
              mai +=1;
              break;
            case 6:
              juin +=1;
              break;
            case 7:
              juill +=1;
              break;
            case 8:
              aout +=1;
              break;
            case 9:
              sept +=1;
              break;
            case 10:
              oct +=1;
              break;
            case 11:
              nov +=1;
              break;
            case 12:
              decc +=1;
              break;
            default:
              break;
          }
        }

    });
    
		var pieChart = document.getElementById('pieChart').getContext('2d');
		var multipleLineChart = document.getElementById('multipleLineChart').getContext('2d');

		var myPieChart = new Chart(pieChart, {
			type: 'pie',
			data: {
				datasets: [{
					data: [{{$encour}}, {{$cloture}}, {{$annul}}],
					backgroundColor :["#1d7af3","#2A792E","#fdaf4b"],
					borderWidth: 0
				}],
				labels: ['ENCOURS', 'CLÔTURÉ', 'ANNULÉ'] 
			},
			options : {
				responsive: true, 
				maintainAspectRatio: false,
				legend: {
					position : 'bottom',
					labels : {
						fontColor: 'rgb(154, 154, 154)',
						fontSize: 11,
						usePointStyle : true,
						padding: 20
					}
				},
				pieceLabel: {
					render: 'percentage',
					fontColor: 'white',
					fontSize: 14,
				},
				tooltips: false,
				layout: {
					padding: {
						left: 20,
						right: 20,
						top: 20,
						bottom: 20
					}
				}
			}
		});


		var myMultipleLineChart = new Chart(multipleLineChart, {
			type: 'line',
			data: {
				labels: ["Jan", "Fev", "Mar", "Avr", "Mai", "Juin", "Juil", "Aout", "Sep", "Oct", "Nov", "Dec"],
				datasets: [{
					label: "ENCOURS",
					borderColor: "#1d7af3",
					pointBorderColor: "#FFF",
					pointBackgroundColor: "#1d7af3",
					pointBorderWidth: 2,
					pointHoverRadius: 4,
					pointHoverBorderWidth: 1,
					pointRadius: 4,
					backgroundColor: 'transparent',
					fill: true,
					borderWidth: 2,
					data: [{{$janv_encours}}, {{$fev_encours}}, {{$mars_encours}}, {{$avril_encours}}, {{$mai_encours}}, {{$juin_encours}}, {{$juill_encours}}, {{$aout_encours}}, {{$sept_encours}}, {{$oct_encours}}, {{$nov_encours}}, {{$decc_encours}}]
				},{
					label: "CLÔTURÉ",
					borderColor: "#59d05d",
					pointBorderColor: "#FFF",
					pointBackgroundColor: "#59d05d",
					pointBorderWidth: 2,
					pointHoverRadius: 4,
					pointHoverBorderWidth: 1,
					pointRadius: 4,
					backgroundColor: 'transparent',
					fill: true,
					borderWidth: 2,
					data: [{{$janv_cloturer}}, {{$fev_cloturer}}, {{$mars_cloturer}}, {{$avril_cloturer}}, {{$mai_cloturer}}, {{$juin_cloturer}}, {{$juill_cloturer}}, {{$aout_cloturer}}, {{$sept_cloturer}}, {{$oct_cloturer}}, {{$nov_cloturer}}, {{$decc_cloturer}}]
				}, {
					label: "ANNULÉ",
					borderColor: "#FFA229",
					pointBorderColor: "#FFF",
					pointBackgroundColor: "#FFA229",
					pointBorderWidth: 2,
					pointHoverRadius: 4,
					pointHoverBorderWidth: 1,
					pointRadius: 4,
					backgroundColor: 'transparent',
					fill: true,
					borderWidth: 2,
					data: [{{$janv_annuler}}, {{$fev_annuler}}, {{$mars_annuler}}, {{$avril_annuler}}, {{$mai_annuler}}, {{$juin_annuler}}, {{$juill_annuler}}, {{$aout_annuler}}, {{$sept_annuler}}, {{$oct_annuler}}, {{$nov_annuler}}, {{$decc_annuler}}]
				}]
			},
			options : {
				responsive: true, 
				maintainAspectRatio: false,
				legend: {
					position: 'top',
				},
				tooltips: {
					bodySpacing: 4,
					mode:"nearest",
					intersect: 0,
					position:"nearest",
					xPadding:10,
					yPadding:10,
					caretPadding:10
				},
				layout:{
					padding:{left:15,right:15,top:15,bottom:15}
				}
			}
		});



	</script>

  <script src="{{ url('dashboard.js') }}"></script>

@endsection
