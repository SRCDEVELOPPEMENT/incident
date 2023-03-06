@extends('layouts.main')

@section('content')
    <!-- Begin Page Content -->
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

                              $newIncidents = array();
                              $nombre_incidents = 0;

                              if(is_iterable($users_incidents)){
                              for ($gy=0; $gy < count($users_incidents); $gy++) {
                                $ui = $users_incidents[$gy];

                                if(is_iterable($incident_annee_encour)){
                                for ($c=0; $c < count($incident_annee_encour); $c++) {
                                  $tine = $incident_annee_encour[$c];
                                  if($tine->number == $ui->incident_number){

                                      if($ui->user_id == Auth::user()->id){
                                        $nombre_incidents +=1;

                                        array_push($newIncidents, $tine);

                                        if($ui->isCoordo == TRUE){
                                            $nbr_emis +=1;
                                        }elseif ($ui->isCoordo == FALSE) {
                                          $nbr_recus +=1;
                                        }
                                      }
                                  }
                                }}
                              }}

                              $nbr_taches = 0;

                              $tachess = array();

                              $nbr_taches_emises = 0;
                              $nbr_taches_recues = 0;

                              $taches_emises = array();
                              $taches_recues = array();

                              if(is_iterable($newIncidents)){
                              for ($uv=0; $uv < count($newIncidents); $uv++) {
                                
                                $newI = $newIncidents[$uv];
                                
                                for ($yo=0; $yo < count($tasks); $yo++) {
                                    $ta = $tasks[$yo];

                                    if($ta->incident_number == $newI->number){
                                        
                                      if($ta->site_id){
                                        if(Auth::user()->site_id){

                                            if($ta->site_id == Auth::user()->site_id){
                                                $nbr_taches += 1;
                                                array_push($tachess, $ta);
                                            }else {

                                              if(is_iterable($users_incidents)){
                                              for ($d=0; $d < count($users_incidents); $d++){
                                                  $us = $users_incidents[$d];

                                                  if($us->user_id == Auth::user()->id){
                                                      if($us->incident_number == $ta->incident_number){
                                                          if($us->isCoordo == TRUE){
                                                              $nbr_taches += 1;
                                                          }
                                                      }
                                                  }
                                              }}
                                          }

                                        }elseif (Auth::user()->departement_id){
                                          if($ta->departement_id == Auth::user()->departement_id){
                                              $nbr_taches += 1;
                                              array_push($tachess, $ta);
                                          }else{

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
                                      }elseif ($ta->departement_id) {
                                          if(Auth::user()->departement_id){
                                              if(Auth::user()->departement_id == $ta->departement_id){
                                                  $nbr_taches += 1;
                                                  array_push($tachess, $ta);
                                              }else{

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

                                if($newI->status == "ENCOURS"){

                                  $encour +=1;
                                  array_push($incidant_encours, $newI);

                                }elseif ($newI->status == "CLÔTURÉ") {

                                  $cloture +=1;
                                  array_push($incidant_cloturer, $newI);

                                }elseif ($newI->status == "ANNULÉ") {

                                  $annul +=1;
                                  array_push($incidant_annuller, $newI);

                                }

                              }}
                              
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

                                  if(count($newIncidents) > 0){
                                    $width_encour = intval($encour/count($newIncidents)*100);
                                    $width_annul = intval($annul/count($newIncidents)*100);
                                    $width_cloture = intval($cloture/count($newIncidents)*100);
                                    
                                    $width_emis = intval($nbr_emis/count($newIncidents)*100);
                                    $width_recus = intval($nbr_recus/count($newIncidents)*100);
                                  }

                                  if($nbr_taches > 0){
                                    $width_tache_encour = intval($encourtache/$nbr_taches*100);
                                    $width_tache_annul = intval($annultache/$nbr_taches*100);
                                    $width_tache_realise = intval($realisetache/$nbr_taches*100);  
                                    $width_tache_enAttente = intval($enAttentetache/$nbr_taches*100);

                                    $width_tache_emise = intval($nbr_taches_emises/$nbr_taches*100);  
                                    $width_tache_recues = intval($nbr_taches_recues/$nbr_taches*100);

                                  }
                              }

                              $tab_ids = array();
                              $tab_created = array();
                              $tab_exited = array();
  
                              if(is_iterable($incidents)){
                              for ($j=0; $j < count($incidents); $j++) {
                                $indi = $incidents[$j];
                                array_push($tab_ids, $indi->number);
                                array_push($tab_exited, $indi->due_date);
                                array_push($tab_created, substr(strval($indi->created_at), 0, 10));
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
                                                  data-departements="{{ json_encode($departements) }}"
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
                                                  data-departements="{{ json_encode($departements) }}"
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
                                          <span class="my-3 text-lg font-weight-bold">Nombre D'incidents TOTAL</span>
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
                      <div class="row justify-content-center" style="font-family: Century Gothic;">
                            <div class="col-md-4">
                              <div class="card shadow border-success mb-4">
                                <div class="card-body">
                                  <div class="row align-items-center">
                                    <div class="col my-4">
                                      <span class="mb-1 text-lg text-success font-weight-bold">Nombre D'incidents CLÔTURÉ</span>
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
                                      <span class="mb-1 text-lg text-primary font-weight-bold">Nombre D'incidents ENCOURS</span>
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
                                      <span class="mb-1 text-lg font-weight-bold">Nombre D'incidents ANNULÉ</span>
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

                      <hr style="margin-bottom:4em; margin-top:2em;">

                      <div class="row" style="font-family: Century Gothic;">
                        <div class="col-md-5">
                              <div class="card shadow">
                                  <div class="card-body">
                                    <div style="margin-bottom: 5em;" class="row align-items-center">
                                        <div class="col jill">
                                            <span class="h2 onesmore">
                                              {{ $nombre_incidents < 10 ? 0 ."". $nombre_incidents : $nombre_incidents }}                                         
                                            </span>
                                            <p class="text-xl font-weight-bold text-gray mt-4"><span class="nomInci"> Nombre D'Incidents Total </span></p>
                                            <p class="text-lg text-gray mt-2">{{ $cit ? $cit->name : "" }}</p>
                                            <p class="text-xl text-gray mt-2"><span class="setDate"></span></p>
                                            <p class="text-xl text-gray mt-2"><span class="getDate"></span></p>
                                        </div>
                                        <div class="col-auto">
                                            <span class="fe fe-32 fe-bell text-muted mb-0"></span>
                                        </div>
                                    </div>

                                    <hr style="background-color: gray; height: 2px;">

                                    <div class="row align-items-center font-weight-bold my-4">
                                            <div class="col text-lg">
                                                <span class="emis_Inci">
                                                    {{ $nbr_emis < 10 ? 0 ."". $nbr_emis : $nbr_emis }}
                                                </span>
                                                <p class="mt-1">ÉMIS</p>
                                            </div>
                                            <div class="col text-lg">
                                                <span class="text-info recu_Inci">
                                                    {{ $nbr_recus < 10 ? 0 ."". $nbr_recus : $nbr_recus }}
                                                </span>
                                                <p class="text-info text-uppercase mt-1">reçus</p>
                                            </div>
                                    </div>

                                    <p style="border: 1px solid gray; width:100%;"></p>

                                    <div class="row font-weight-bold align-items-center my-4">
                                      <div class="col text-lg mr-4">
                                          <span class="text-primary encours_Inci">
                                              {{ $encour < 10 ? 0 ."". $encour : $encour }}
                                          </span>
                                          <p class="text-primary mt-1">ENCOURS</p>
                                      </div>
                                      <div class="col text-lg mr-4">
                                          <span class="text-success cloture_Inci">
                                              {{ $cloture < 10 ? 0 ."". $cloture : $cloture }}
                                          </span>
                                          <p class="text-success mt-1">CLÔTURÉ</p>
                                      </div>
                                      <div class="col text-lg">
                                          <span class="text-gray annule_Inci">
                                              {{ $annul < 10 ? 0 ."". $annul : $annul }}
                                          </span>
                                          <p class="text-gray mt-1">ANNULÉ</p>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                        </div>
                        <div class="col-md-7">
                              <div class="">
                                              <div class="row">
                                                <div class="col-md-6 text-left text-white">ÉMIS</div>
                                                <div class="col-md-6 text-right"><i class="fe fe-32 fe-trending-up text-secondary"></i></div>
                                              </div>

                                              <div class="progress text-lg mb-3" style="height: 30px;">
                                                <div class="progress-bar bg-secondary pg_emis_inci" role="progressbar" style="width: {{ $width_emis == 0 ? 3 : $width_emis }}%;" aria-valuenow="{{ $width_emis == 0 ? 3 : $width_emis }}" aria-valuemin="0" aria-valuemax="100">{{ $width_emis }}%</div>
                                              </div>

                                              <div class="row">
                                                <div class="col-md-6 text-left text-info">REÇUS</div>
                                                <div class="col-md-6 text-right"><i class="fe fe-32 fe-trending-down text-info"></i></div>
                                              </div>

                                              <div class="progress text-lg mb-3" style="height: 30px;">
                                                <div class="progress-bar bg-info pg_recu_inci" role="progressbar" style="width: {{ $width_recus == 0 ? 3 : $width_recus }}%;" aria-valuenow="{{ $width_recus == 0 ? 3 : $width_recus }}" aria-valuemin="0" aria-valuemax="100">{{ $width_recus }}%</div>
                                              </div>

                                              <hr style="margin-top:3em; margin-bottom:3em;">

                                              <div class="row">
                                                <div class="col-md-6 text-left text-primary">ENCOURS</div>
                                                <div class="col-md-6 text-right"><i class="fe fe-32 fe-bell text-primary"></i></div>
                                              </div>

                                              <div class="progress text-lg mb-3" style="height: 30px;">
                                                <div class="progress-bar bg-primary pg_encou_inci" role="progressbar" style="width: {{ $width_encour == 0 ? 3 : $width_encour }}%;" aria-valuenow="{{ $width_encour == 0 ? 3 : $width_encour }}" aria-valuemin="0" aria-valuemax="100">{{ $width_encour }}%</div>
                                              </div>

                                              <div class="row">
                                                <div class="col-md-6 text-left text-success">CLÔTURÉ</div>
                                                <div class="col-md-6 text-right"><i class="fe fe-32 fe-bell text-success"></i></div>
                                              </div>

                                              <div class="progress text-lg mb-3" style="height: 30px;">
                                                <div class="progress-bar bg-success pg_clot_inci" role="progressbar" style="width: {{ $width_cloture == 0 ? 3 : $width_cloture }}%;" aria-valuenow="{{ $width_cloture == 0 ? 3 : $width_cloture }}" aria-valuemin="0" aria-valuemax="100">{{ $width_cloture }}%</div>
                                              </div>


                                              <div class="row">
                                                <div class="col-md-6 text-left text-gray-500">ANNULÉ</div>
                                                <div class="col-md-6 text-right" style="cursor:pointer;"><i class="fe fe-32 fe-bell text-gray-400"></i></div>
                                              </div>

                                              <div class="progress text-lg mb-3" style="height: 30px;">
                                                <div class="progress-bar bg-light pg_anne_inci" role="progressbar" style="width: {{ $width_annul == 0 ? 3 : $width_annul }}%;" aria-valuenow="{{ $width_annul == 0 ? 3 : $width_annul }}" aria-valuemin="0" aria-valuemax="100">{{ $width_annul }}%</div>
                                              </div>

                              </div>
                        </div>
                      </div>

                      <hr style="margin-bottom:4em; margin-top:3em;">


                      <div class="row" style="font-family: Century Gothic;">
                        <div class="col-md-7">
                              <div class="card shadow">
                                  <div class="card-body">
                                    <div style="margin-bottom: 5em;" class="row align-items-center">
                                        <div class="col jill">
                                            <span class="h2 nombre_tache_totals">
                                              {{ $nbr_taches < 10 ? 0 ."". $nbr_taches : $nbr_taches }}
                                            </span>
                                            <p class="small text-xl font-weight-bold text-gray mt-4"> <span class="name_t">Nombre De Tâche Total</span> </p>
                                            <p class="small text-lg text-gray mt-2">{{ $cit ? $cit->name : "" }}</p>
                                            <p class="text-xl text-gray mt-2"><span class="setDate_taskss"></span></p>
                                            <p class="text-xl text-gray mt-2"><span class="getDate_taskss"></span></p>

                                        </div>
                                        <div class="col-auto">
                                            <span class="fe fe-32 fe-list text-muted mb-0"></span>
                                            <span class="fe fe-32 fe-check text-muted mb-0"></span>
                                        </div>
                                    </div>

                                    <hr style="background-color: gray; height: 2px;">

                                    <div class="row font-weight-bold align-items-center my-4">
                                            <div class="col text-lg">
                                                <span class="nb_ta_emi">
                                                    {{ $nbr_taches_emises < 10 ? 0 ."". $nbr_taches_emises : $nbr_taches_emises  }}
                                                </span>
                                                <p class="mt-1">ÉMISE</p>
                                            </div>
                                            <div class="col text-lg">
                                                <span class="text-info nb_ta_rec">
                                                    {{ $nbr_taches_recues < 10 ? 0 ."". $nbr_taches_recues : $nbr_taches_recues  }}
                                                </span>
                                                <p class="text-info text-uppercase mt-1">reçus</p>
                                            </div>
                                    </div>

                                    <p style="border: 1px solid gray; width:100%;"></p>

                                    <div class="row font-weight-bold align-items-center my-4">
                                      <div class="col text-lg mr-4">
                                          <span class="text-primary tach_enc_to">
                                              {{ $encourtache < 10 ? 0 ."". $encourtache : $encourtache }}
                                          </span>
                                          <p class="text-primary mt-1">ENCOURS</p>
                                      </div>
                                      <div class="col text-lg mr-4">
                                          <span class="text-success tach_real_to">
                                              {{ $realisetache < 10 ? 0 ."". $realisetache : $realisetache }}
                                          </span>
                                          <p class="text-success mt-1">RÉALISÉE</p>
                                      </div>
                                      <div class="col text-lg">
                                          <span class="text-warning tach_enA_to">
                                              {{ $enAttentetache < 10 ? 0 ."". $enAttentetache : $enAttentetache }}
                                          </span>
                                          <p class="text-warning mt-1">EN-ATTENTE</p>
                                      </div>
                                      <div class="col text-lg">
                                          <span class="text-gray-400 tach_an_to">
                                              {{ $annultache < 10 ? 0 ."". $annultache : $annultache }}
                                          </span>
                                          <p class="text-gray-400 mt-1">ANNULÉE</p>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                        </div>
                        <div class="col-md-5">
                              <div class="">
                                              <div class="row">
                                                <div class="col-md-6 text-left text-white">ÉMIS</div>
                                                <div class="col-md-6 text-right"><i class="fe fe-32 fe-trending-up text-secondary"></i></div>
                                              </div>

                                              <div class="progress text-lg mb-3" style="height: 30px;">
                                                <div class="progress-bar bg-secondary pg_tache_emis" role="progressbar" style="width: {{ $width_tache_emise == 0 ? 3 : $width_tache_emise }}%;" aria-valuenow="{{ $width_tache_emise == 0 ? 3 : $width_tache_emise }}" aria-valuemin="0" aria-valuemax="100">{{ $width_tache_emise }}%</div>
                                              </div>

                                              <div class="row">
                                                <div class="col-md-6 text-left text-info">REÇUS</div>
                                                <div class="col-md-6 text-right"><i class="fe fe-32 fe-trending-down text-info"></i></div>
                                              </div>

                                              <div class="progress text-lg mb-3" style="height: 30px;">
                                                <div class="progress-bar bg-info pg_tache_recues" role="progressbar" style="width: {{ $width_tache_recues == 0 ? 3 : $width_tache_recues }}%;" aria-valuenow="{{ $width_tache_recues == 0 ? 3 : $width_tache_recues }}" aria-valuemin="0" aria-valuemax="100">{{ $width_tache_recues }}%</div>
                                              </div>

                                              <hr style="margin-top:3em; margin-bottom:3em;">

                                              <div class="row">
                                                <div class="col-md-6 text-left text-primary">ENCOURS</div>
                                                <div class="col-md-6 text-right">
                                                <i class="fe fe-16 fe-list text-primary"></i>
                                                  <i class="fe fe-32 fe-check text-primary"></i></div>
                                              </div>

                                              <div class="progress text-lg mb-3" style="height: 30px;">
                                                <div class="progress-bar bg-primary pg_tache_encous" role="progressbar" style="width: {{ $width_tache_encour == 0 ? 3 : $width_tache_encour }}%;" aria-valuenow="{{ $width_tache_encour == 0 ? 3 : $width_tache_encour }}" aria-valuemin="0" aria-valuemax="100">{{ $width_tache_encour }}%</div>
                                              </div>

                                              <div class="row">
                                                <div class="col-md-6 text-left text-success">RÉALISÉE</div>
                                                <div class="col-md-6 text-right">
                                                <i class="fe fe-16 fe-list text-success"></i>
                                                  <i class="fe fe-32 fe-check text-success"></i></div>
                                              </div>

                                              <div class="progress text-lg mb-3" style="height: 30px;">
                                                <div class="progress-bar bg-success pg_tache_realis" role="progressbar" style="width: {{ $width_tache_realise == 0 ? 3 : $width_tache_realise }}%;" aria-valuenow="{{ $width_tache_realise == 0 ? 3 : $width_tache_realise }}" aria-valuemin="0" aria-valuemax="100">{{ $width_tache_realise }}%</div>
                                              </div>


                                              <div class="row">
                                                <div class="col-md-6 text-left text-warning">EN-ATTENTE</div>
                                                <div class="col-md-6 text-right">
                                                <i class="fe fe-16 fe-list text-warning"></i>
                                                  <i class="fe fe-32 fe-check text-warning"></i></div>
                                              </div>

                                              <div class="progress text-lg mb-3" style="height: 30px;">
                                                <div class="progress-bar bg-warning pg_tache_enatten" role="progressbar" style="width: {{ $width_tache_enAttente == 0 ? 3 : $width_tache_enAttente }}%;" aria-valuenow="{{ $width_tache_enAttente == 0 ? 3 : $width_tache_enAttente }}" aria-valuemin="0" aria-valuemax="100">{{ $width_tache_enAttente }}%</div>
                                              </div>

                                              <div class="row">
                                                <div class="col-md-6 text-left text-gray-500">ANNULÉE</div>
                                                <div class="col-md-6 text-right" style="cursor:pointer;">
                                                <i class="fe fe-16 fe-list text-gray-400"></i>
                                                <i class="fe fe-32 fe-check text-gray-400"></i></div>
                                              </div>

                                              <div class="progress text-lg mb-3" style="height: 30px;">
                                                <div class="progress-bar bg-light pg_tache_annils" role="progressbar" style="width: {{ $width_tache_annul == 0 ? 3 : $width_tache_annul }}%;" aria-valuenow="{{ $width_tache_annul == 0 ? 3 : $width_tache_annul }}" aria-valuemin="0" aria-valuemax="100">{{ $width_annul }}%</div>
                                              </div>

                              </div>
                        </div>
                      </div>
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

                            $newIncidents = array();

                            if(is_iterable($users_incidents)){
                            for ($gy=0; $gy < count($users_incidents); $gy++) {
                              $ui = $users_incidents[$gy];

                              for ($c=0; $c < count($incident_annee_encour); $c++) {
                                $tine = $incident_annee_encour[$c];
                                if($tine->number == $ui->incident_number){

                                    if(intval($ui->user_id) == intval(Auth::user()->id)){
                                      array_push($newIncidents, $tine);
                                    }
                                }
                              }
                            }}

                            if(
                              (Auth::user()->roles[0]->name == "EMPLOYE") ||
                              (Auth::user()->roles[0]->name == "COORDONATEUR")
                              ){
                              
                              if(is_iterable($newIncidents)){
                              for ($i=0; $i < count($newIncidents); $i++) {
                                  $inci = $newIncidents[$i];

                                  if($inci->status == "ENCOURS"){
                                      $encour +=1;
                                      array_push($incidant_encours, $inci);

                                    if($inci->due_date){
                                        $auday = str_replace("-", "", date('Y-m-d'));
                                        $date_echeance = str_replace("-", "", $inci->due_date);
                                        if(intval($date_echeance) < intval($auday)){
                                            $enretard +=1;
                                            array_push($incidant_enretard, $inci);
                                        }else{
                                          $a_temps +=1;
                                        }
                                    }
                    
                                  }elseif($inci->status == "CLÔTURÉ"){
                                      $cloture +=1;
                                      array_push($incidant_cloturer, $inci);

                                      if($inci->due_date && $inci->closure_date){
                                        if(intval(str_replace("-", "", $inci->closure_date)) > intval(str_replace("-", "", $inci->due_date))){
                                            $nombre_cloture_enretard +=1;
                                        }else{
                                            $nombre_cloture_a_temps +=1;
                                        }
                                    }
                    
                                  }else{
                                      $annul +=1;
                                      array_push($incidant_annuller, $inci);
                                  }
                              }}

                              if(count($newIncidents) > 0){
                                $width_encour = intval($encour/count($newIncidents)*100);
                                $width_annul = intval($annul/count($newIncidents)*100);
                                $width_cloture = intval($cloture/count($newIncidents)*100);
                                $width_enretard = $encour > 0 ? intval(($enretard/$encour) * 100) : 0;
                                $width_non_enretard = $encour > 0 ? intval(($a_temps/$encour)*100) : 0;
                                $width_non_cloture = intval((($encour + $annul)/count($newIncidents))*100);
                                $width_non_encour = intval((($cloture + $annul)/count($newIncidents))*100);
                                $width_non_annul = intval((($encour + $cloture)/count($newIncidents))*100);
                              }
                              
                            }elseif(
                              (Auth::user()->roles[0]->name == "SuperAdmin") ||
                              (Auth::user()->roles[0]->name == "CONTROLLEUR")
                              ) {

                              if(is_iterable($incident_annee_encour)){
                              for ($i=0; $i < count($incident_annee_encour); $i++) {
                                $inci = $incident_annee_encour[$i];

                                if($inci->status == "ENCOURS"){
                                    $encour +=1;
                                    array_push($incidant_encours, $inci);

                                  if($inci->due_date){
                                      $auday = str_replace("-", "", date('Y-m-d'));
                                      $date_echeance = str_replace("-", "", $inci->due_date);
                                      if(intval($date_echeance) < intval($auday)){
                                          $enretard +=1;
                                          array_push($incidant_enretard, $inci);
                                      }else{
                                        $a_temps +=1;
                                      }
                                  }
                  
                                }elseif($inci->status == "CLÔTURÉ"){
                                    $cloture +=1;
                                    array_push($incidant_cloturer, $inci);

                                    if($inci->due_date && $inci->closure_date){
                                      if(intval(str_replace("-", "", $inci->closure_date)) > intval(str_replace("-", "", $inci->due_date))){
                                          $nombre_cloture_enretard +=1;
                                      }else{
                                          $nombre_cloture_a_temps +=1;
                                      }
                                  }
                  
                                }else{
                                    $annul +=1;
                                    array_push($incidant_annuller, $inci);
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
                            }

                            if(is_iterable($incidents)){
                            for ($j=0; $j < count($incidents); $j++) {
                              $indi = $incidents[$j];
                              array_push($tab_ids, $indi->number);
                              array_push($tab_exited, $indi->due_date);
                              array_push($tab_created, substr(strval($indi->created_at), 0, 10));
                            }}

                            if(is_iterable($tasks)){
                            for ($v=0; $v < count($tasks); $v++) {
                              $t = $tasks[$v];
                              array_push($taches_ids, $t->id);
                              array_push($taches_closure, $t->closure_date);
                              array_push($taches_created, substr(strval($t->created_at), 0, 10));
                            }}

                    ?>

                    <hr style="margin-bottom:2em; margin-top:1em;">
                    <fieldset style="margin: 8px; border: 1px solid silver; border-radius: 4px; padding: 8px;">
                      <legend style="padding: 2px;">Critère(s) De Recherche</legend>
                        <div class="row justify-content-center my-2">
                              <div style="margin-top:0.6em;"><i class="fe fe-16 fe-home"></i></div>
                              <div class="col-md-3 mb-1 mr-4">
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
                                            data-departements="{{ json_encode($departements) }}"
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

                              <div style="margin-top:0.6em;"><i class="fe fe-16 fe-home"></i></div>
                              <div class="col-md-4 mb-1 mr-4">
                                    <select 
                                            class="custom-select text-lg border-primary"
                                            id="departes"
                                            data-user_conneter="{{ json_encode(Auth::user()) }}"
                                            data-taches_ids="{{ json_encode($taches_ids) }}"
                                            data-taches_created="{{ json_encode($taches_created) }}"
                                            data-users="{{ json_encode($users) }}"
                                            data-tasks="{{ json_encode($tasks) }}"
                                            data-ids="{{ json_encode($tab_ids) }}"
                                            data-created="{{ json_encode($tab_created) }}"
                                            data-exited="{{ json_encode($tab_exited) }}"
                                            data-incidents="{{ json_encode($incidents) }}"
                                            data-departements="{{ json_encode($departements) }}"
                                            data-sites="{{ json_encode($sites) }}"
                                            data-users_incidents="{{ json_encode($users_incidents) }}"
                                            data-regions="{{ json_encode($regions) }}">
                                        <option selected value="">Choisissez Un Département...</option>
                                        @if(is_iterable($departements))
                                        @foreach($departements as $departement)
                                            <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                              </div>

                              <div style="margin-top:0.6em;"><i class="fe fe-16 fe-globe"></i></div>
                              <div class="col-md-3 mb-1">
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
                                            data-departements="{{ json_encode($departements) }}"
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
                                              data-departements="{{ json_encode($departements) }}"
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
                                              data-departements="{{ json_encode($departements) }}"
                                              data-sites="{{ json_encode($sites) }}"
                                              data-users_incidents="{{ json_encode($users_incidents) }}"
                                              data-regions="{{ json_encode($regions) }}">
                                </div>
                              </div>
                        </div>
                    </fieldset>


                    <hr style="margin-bottom:4em; margin-top:2em;">

                      <div class="row">
                                <div class="col-md-4">
                                  <div class="card shadow border-info mb-4">
                                    <div class="card-body">
                                      <div class="row align-items-center">
                                        <div class="col my-4">
                                          <span class="my-3 text-lg font-weight-bold">Nombre D'incidents TOTAL</span>
                                        </div>
                                        <div class="col-4 text-right">
                                          <span style="font-size:3em;" class="mb-0 tout_ta_fait">
                                            @if(
                                              (Auth::user()->roles[0]->name == "SuperAdmin") ||
                                              (Auth::user()->roles[0]->name == "CONTROLLEUR") ||
                                              (Auth::user()->roles[0]->name == "ADMINISTRATEUR")
                                              )
                                              {{ count($incident_annee_encour) < 10 ? 0 ."". count($incident_annee_encour) : count($incident_annee_encour) }}
                                            
                                            @elseif(
                                              (Auth::user()->roles[0]->name == "EMPLOYE") ||
                                              (Auth::user()->roles[0]->name == "COORDONATEUR"))
                                              {{ count($newIncidents) < 10 ? 0 ."". count($newIncidents) : count($newIncidents) }}
                                            @endif
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
                                      <span class="mb-1 text-lg text-success font-weight-bold">Nombre D'incidents CLÔTURÉ</span>
                                    </div>
                                    <div class="col-4 text-right">
                                      <h1 style="font-size:3em;" class="text-success mb-0">
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
                                      <span class="mb-1 text-lg text-primary font-weight-bold">Nombre D'incidents ENCOURS</span>
                                    </div>
                                    <div class="col-4 text-right">
                                      <h1 style="font-size:3em;" class="text-primary mb-0">
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
                                      <span class="mb-1 text-lg font-weight-bold">Nombre D'incidents ANNULÉ</span>
                                    </div>
                                    <div class="col-4 text-right">
                                      <h1 style="font-size:3em;" class="mb-0">
                                          {{ $annul < 10 ? 0 ."". $annul : $annul }}
                                      </h1>
                                    </div>
                                  </div> <!-- /. row -->
                                </div> <!-- /. card-body -->
                              </div> <!-- /. card -->
                            </div> <!-- /. col -->
                      </div>


                    <hr style="margin-bottom: 3em; margin-top: 6em;">

                    <div class="row" style="font-family: Century Gothic;">
                        <div class="col-md-5 mb-4">
                            <div class="card shadow">
                                <div class="card-body">
                                  <div style="margin-bottom: 5em;" class="row align-items-center">
                                      <div class="col jill">
                                          <span class="h2" id="tot">
                                            @if(
                                              (Auth::user()->roles[0]->name == "SuperAdmin") ||
                                              (Auth::user()->roles[0]->name == "CONTROLLEUR") ||
                                              (Auth::user()->roles[0]->name == "ADMINISTRATEUR")
                                              )
                                              {{ count($incident_annee_encour) < 10 ? 0 ."". count($incident_annee_encour) : count($incident_annee_encour) }}
                                            
                                            @elseif(
                                              (Auth::user()->roles[0]->name == "EMPLOYE") ||
                                              (Auth::user()->roles[0]->name == "COORDONATEUR"))
                                              {{ count($newIncidents) < 10 ? 0 ."". count($newIncidents) : count($newIncidents) }}
                                            @endif
                                          </span>
                                          <p class="small text-lg text-gray mt-4"><span id="namels"></span></p>
                                          <p class="small text-xl font-weight-bold text-gray"><span id="nom_site_ou_departement"> Nombre D'Incidents Total</span></p>
                                          <p class="small text-lg text-gray mt-1"><span id="date_du"></span></p>
                                      </div>
                                      <div class="col-auto">
                                          <span class="fe fe-32 fe-bell text-muted mb-0"></span>
                                      </div>
                                  </div>

                                  <hr style="background-color: gray; height: 2px;">

                                  <div class="row align-items-center my-4">
                                    <div class="col text-lg mr-4">
                                        <span class="text-primary" id="enc">
                                            {{ $encour < 10 ? 0 ."". $encour : $encour }}
                                        </span>
                                        <p class="text-primary mt-1">ENCOURS</p>
                                    </div>
                                    <div class="col text-lg mr-4">
                                        <span class="text-success" id="clot">
                                            {{ $cloture < 10 ? 0 ."". $cloture : $cloture }}
                                        </span>
                                        <p class="text-success mt-1">CLÔTURÉ</p>
                                    </div>
                                    <div class="col text-lg">
                                        <span class="text-gray-400" id="ann">
                                            {{ $annul < 10 ? 0 ."". $annul : $annul }}
                                        </span>
                                        <p class="text-gray-400 mt-1">ANNULÉ</p>
                                    </div>
                                  </div>

                                  <p style="border: 1px solid gray; width:100%; margin-bottom:2em;"></p>

                                  <div style="margin-bottom: 4em;" class="row align-items-center">
                                      <div class="col-xl-4 mr-4">
                                        <div class="row">
                                          <span class="text-primary mr-4">
                                              <span id="encour_a_temps" class="text-lg">
                                                {{ $a_temps < 10 ? 0 ."". $a_temps : $a_temps }}
                                              </span>
                                              <p style="font-size:0.8em;" class="text-primary mt-1"> DELAIS</p>
                                          </span>
                                          <span class="text-warning">
                                              <span id="en_retar" class="text-lg">
                                                {{ $enretard < 10 ? 0 ."". $enretard : $enretard }}
                                              </span>
                                              <p style="font-size:0.8em;" class="text-warning mt-1"> EN RETARD</p>
                                          </span>
                                        </div>
                                      </div>
                                      <div class="col-xl-4">
                                        <div class="row">
                                          <span class="text-success mr-4">
                                              <span id="clot_a_temp" class="text-lg">
                                                {{ $nombre_cloture_a_temps < 10 ? 0 ."". $nombre_cloture_a_temps : $nombre_cloture_a_temps }}
                                              </span>
                                              <p style="font-size:0.8em;" class="text-success mt-1"> DELAIS</p>
                                          </span>
                                          <span class="text-warning">
                                              <span id="clot_hors_delai" class="text-lg">
                                                {{ $nombre_cloture_enretard < 10 ? 0 ."". $nombre_cloture_enretard : $nombre_cloture_enretard }}
                                              </span>
                                              <p style="font-size:0.8em;" class="text-warning mt-1"> HORS DELAI</p>
                                          </span>
                                        </div>
                                      </div>
                                  </div>

                                  <div class="row align-items-center my-4">
                                      <div class="col mr-4">
                                          <button 
                                                  data-encours="{{ json_encode($incidant_encours) }}"
                                                  title="INCIDENT ENCOURS" 
                                                  id="floder_encour" 
                                                  class="btn btn-xs btn-outline-primary survol1"
                                                  data-backdrop="static" 
                                                  data-keyboard="false"
                                                  data-toggle="modal" 
                                                  data-target="#modal_liste_incident">
                                            <span class="fe fe-16 fe-plus"></span>
                                          </button>
                                      </div>
                                      <div class="col mr-4">
                                          <button 
                                                  data-clotures="{{ json_encode($incidant_cloturer) }}" 
                                                  title="INCIDENT CLÔTURÉ" 
                                                  id="floder_cloture" 
                                                  class="btn btn-xs btn-outline-success survol"
                                                  data-backdrop="static" 
                                                  data-keyboard="false"
                                                  data-toggle="modal" 
                                                  data-target="#modal_liste_incident">
                                            <span class="fe fe-16 fe-plus"></span>
                                          </button>
                                      </div>
                                      <div class="col">
                                          <button 
                                                  data-annules="{{ json_encode($incidant_annuller) }}" 
                                                  title="INCIDENT ANNULÉ"
                                                  id="floder_annuler"
                                                  class="btn btn-xs btn-outline-light survol"
                                                  data-backdrop="static" 
                                                  data-keyboard="false"
                                                  data-toggle="modal" 
                                                  data-target="#modal_liste_incident">
                                            <span class="fe fe-16 fe-plus"></span>
                                          </button>
                                      </div>

                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="mt-0">
                                            <div class="row">
                                              <div class="col-md-6 text-left text-success">CLÔTURÉ</div>
                                              <div class="col-md-6 text-right"><i class="fe fe-32 fe-bell text-success"></i></div>
                                            </div>
                                            <!-- <p class="mb-1"><span class="text-success">CLÔTURÉ</span><span style="margin-left:10em;" class="text-right"><i class="fe fe-32 fe-folder-plus"></i></span></p> -->
                                            <div class="progress text-lg mb-3" style="height: 30px;">
                                              <div id="progress_cloture" class="progress-bar bg-success" role="progressbar" style="width: {{ $width_cloture == 0 ? 3 : $width_cloture }}%;" aria-valuenow="{{ $width_cloture == 0 ? 3 : $width_cloture }}" aria-valuemin="0" aria-valuemax="100">{{ $width_cloture }}%</div>
                                            </div>

                                            <div class="col-md-12 text-right">NON-CLÔTURÉ</div>
                                            <div class="progress justify-content-end mb-3">
                                                <div id="progress_non_cloture" class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{ $width_non_cloture == 0 ? 3 : $width_non_cloture }}%" aria-valuenow="{{ $width_non_cloture == 0 ? 3 : $width_non_cloture }}" aria-valuemin="0" aria-valuemax="100">{{ $width_non_cloture }}%</div>
                                            </div>

                                            <div class="row">
                                              <div class="col-md-6 text-left text-primary">ENCOURS</div>
                                              <div  class="col-md-6 text-right"><i class="fe fe-32 fe-bell text-primary"></i></div>
                                            </div>
                                            <!-- <p class="mb-1"><span class="text-primary">ENCOURS</span></p> -->
                                            <div class="progress text-lg mb-3" style="height: 30px;">
                                              <div id="progress_encours" class="progress-bar bg-primary" role="progressbar" style="width: {{ $width_encour == 0 ? 3 : $width_encour }}%;" aria-valuenow="{{ $width_encour == 0 ? 3 : $width_encour }}" aria-valuemin="0" aria-valuemax="100">{{ $width_encour }}%</div>
                                            </div>

                                            <div class="col-md-12 text-right">CLÔTURÉ-ANNULÉ</div>
                                            <div class="progress justify-content-end mb-3">
                                                <div id="progress_non_encours" class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: {{ $width_non_encour == 0 ? 3 : $width_non_encour }}%" aria-valuenow="{{ $width_non_encour == 0 ? 3 : $width_non_encour }}" aria-valuemin="0" aria-valuemax="100">{{ $width_non_encour }}%</div>
                                            </div>

                                            <div class="row">
                                              <div class="col-md-6 text-left text-warning">EN-RETARD</div>
                                              <div class="col-md-6 text-right"><i class="fe fe-32 fe-bell text-warning"></i></div>
                                            </div>
                                            <!-- <p class="mb-1"><span class="text-warning">EN-RETARD</span></p> -->
                                            <div class="progress text-lg mb-3" style="height: 30px;">
                                              <div id="progress_enretard" class="progress-bar bg-warning" role="progressbar" style="width: {{ $width_enretard == 0 ? 3 : $width_enretard }}%;" aria-valuenow="{{ $width_enretard == 0 ? 3 : $width_enretard }}" aria-valuemin="0" aria-valuemax="100">{{ $width_enretard }}%</div>
                                            </div>

                                            <div class="col-md-12 text-right">NON-ENRETARD</div>
                                            <div class="progress justify-content-end mb-3">
                                                <div id="progress_non_enretard" class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: {{ $width_non_enretard == 0 ? 3 : $width_non_enretard }}%" aria-valuenow="{{ $width_non_enretard == 0 ? 3 : $width_non_enretard }}" aria-valuemin="0" aria-valuemax="100">{{ $width_non_enretard }}%</div>
                                            </div>

                                            <div class="row">
                                              <div class="col-md-6 text-left text-gray-500">ANNULÉ</div>
                                              <div class="col-md-6 text-right" style="cursor:pointer;"><i class="fe fe-32 fe-bell text-gray-400"></i></div>
                                            </div>
                                            <!-- <p class="mb-1"><span class="text-gray-500">ANNULÉ</span></p> -->
                                            <div class="progress text-lg mb-3" style="height: 30px;">
                                              <div id="progress_annule" class="progress-bar bg-light" role="progressbar" style="width: {{ $width_annul == 0 ? 3 : $width_annul }}%;" aria-valuenow="{{ $width_annul == 0 ? 3 : $width_annul }}" aria-valuemin="0" aria-valuemax="100">{{ $width_annul }}%</div>
                                            </div>

                                            <div class="col-md-12 text-right">NON-ANNULÉ</div>
                                            <div class="progress justify-content-end mb-3">
                                                <div id="progress_non_annuler" class="progress-bar progress-bar-striped bg-light" role="progressbar" style="width: {{ $width_non_annul == 0 ? 3 : $width_non_annul }}%" aria-valuenow="{{ $width_non_enretard == 0 ? 3 : $width_non_annul }}" aria-valuemin="0" aria-valuemax="100">{{ $width_non_annul }}%</div>
                                            </div>

                            </div>
                        </div>
                    </div>
                  @endcan
            </div>
        </div>
    </div>
    
    <?php
      $mon_departement = NULL;
      $id_departement = Auth::user()->departement_id;
      if($id_departement){
        if(is_iterable($departements)){
        for ($co=0; $co < count($departements); $co++) {
            $de = $departements[$co];
            if($de->id == $id_departement){
              $mon_departement = $de;
            }
        }}
      }
    ?>
    
    @if($mon_departement)
      @if($mon_departement->name == "COORDINATION")
        <hr class="my-4">
        <h1 class="text-xl" style="margin-bottom: 3em;"><i class="fe fe-32 fe-bell"></i><i style="font-size:15px;" class="fe fe-percent mr-2"></i>POURCENTAGE INCIDENT  PAR SERVICE</h1>
        
        @if(is_iterable($departements))
        @foreach($departements as $key => $departement)
          <div class="row" style="font-family: Century Gothic;">
              <div class="col-md-6 text-left">{{$departement->name}}</div>
          </div>

          <div class="progress" style="height: 2em;">
              <div  
                    id="depi{{ $key }}"
                    class="progress-bar bg-success text-lg" 
                    role="progressbar" 
                    style="width: {{ count($incident_direction_generale) > 0 ? (count($incidentsDepartement[$key])/count($incident_direction_generale)) * 100 > 0 ? (count($incidentsDepartement[$key])/count($incident_direction_generale)) * 100 : 2 : 2 }}%" 
                    aria-valuenow="{{ count($incident_direction_generale) > 0 ? (count($incidentsDepartement[$key])/count($incident_direction_generale)) * 100 > 0 ? (count($incidentsDepartement[$key])/count($incident_direction_generale)) * 100 : 2 : 2 }}%" 
                    aria-valuemin="0" 
                    aria-valuemax="100"
                    >
                    {{ count($incident_direction_generale) > 0 ? ((count($incidentsDepartement[$key])/count($incident_direction_generale)) * 100) > 0 ? intval((count($incidentsDepartement[$key])/count($incident_direction_generale)) * 100) : 0 : 0 }}%
              </div>
          </div>
          </br>
        @endforeach
        @endif

        <hr class="my-4">
        <h1 class="text-xl" style="margin-bottom: 3em;">
          <i class="fe fe-32 fe-bell"></i>
          <i style="font-size:15px;" class="fe fe-percent mr-2"></i>
          POURCENTAGE INCIDENT  PAR AGENCE
        </h1>
        
        <?php
              $nombre_incidents_un_site = array();
              $nombre_inc_sites_annee_encour = 0;

              if(is_iterable($incidentSites)){
              for ($o=0; $o < count($incidentSites); $o++) {

                $element = $incidentSites[$o];

                $nombre_inc_sites_annee_encour += count($element);

                array_push($nombre_incidents_un_site, count($element));
              }}

        ?>

        <div class="row" style="font-family: Century Gothic; margin-left: 0.5em;">
          @if(is_iterable($sites))
          @foreach($sites as $key => $site)
            <span style="margin-right: -5em; position: relative;" id="identi{{$key}}">
            {{ $nombre_inc_sites_annee_encour > 0 ? ($nombre_incidents_un_site[$key]/$nombre_inc_sites_annee_encour) * 100  > 0 ? intval(($nombre_incidents_un_site[$key]/$nombre_inc_sites_annee_encour) * 100) : 0 : 0 }}%
            </span>
            <div class="my-4" id="adenti{{$key}}">
              <div class="barcontainer">
                <div 
                      class="bar bg-primary font-weight-bold text-sm" 
                      style="height:{{ $nombre_inc_sites_annee_encour > 0 ? ($nombre_incidents_un_site[$key]/$nombre_inc_sites_annee_encour) * 100  > 0 ? ($nombre_incidents_un_site[$key]/$nombre_inc_sites_annee_encour) * 100 : 0 : 0 }}%; 
                      text-align:center;
                      ">
                </div>
              </div>
              <span style="writing-mode:vertical-rl; font-size:0.9em; margin-right: 2em; margin-top:3em;">{{$site->name}}</span>
            </div>
          @endforeach
          @endif
        </div>
      @endif
    @endif

    @can('dashboard_admin')

    @endcan

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


    <script src="{{ url('dashboard.js') }}"></script>

@endsection
