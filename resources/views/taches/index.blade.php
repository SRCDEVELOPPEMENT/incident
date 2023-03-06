@extends('layouts.main')


@section('content')
    <?php
            $tab_ids = array();
            $tab_created = array();
            $tab_exited = array();
            $tab_created_log = array();
            $tab_id_log = array();

            $filesss = DB::table('fichiers')->get();

            if(Session::has('incidents')){
            if(is_iterable(Session::get('incidents'))){
            for ($j=0; $j < count(Session::get('incidents')); $j++) {
                $indi = Session::get('incidents')[$j];
                array_push($tab_ids, $indi->number);
                array_push($tab_exited, $indi->due_date);
                array_push($tab_created, substr(strval($indi->created_at), 0, 10));
            }}}
  
            if(Session::has('logs')){
            if(is_iterable(Session::get('logs'))){
            for ($z=0; $z < count(Session::get('logs')); $z++) { 
                $l = Session::get('logs')[$z];
                array_push($tab_id_log, $l->id);
                array_push($tab_created_log, substr(strval($l->created_at), 0, 10));
            }}}
    ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                        <div class="card-header">
                            <div class="row" style="font-family: Century Gothic;">
                                <div class="col-md-7 text-left my-4">
                                    @if($number_incident)
                                        <a title="Retour A La Liste Des Incidents" href="{{ URL::to('incidents') }}" style="border-radius: 3em;" class="btn btn-outline-primary"><span class="fe fe-corner-up-left fe-16 mr-2"></span><span class="text">Retour</span></a>
                                    @endif
                                </div>
                                <div class="col-md-5 text-right my-4">
                                    @if($number_incident)
                                        <span class="mr-4">NUMERO INCIDENT</span>
                                        <span class="badge badge-pill badge-success text-xl">{{ $number_incident }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row" style="font-family: Century Gothic;">
                                <div class="col-md-12 text-right my-4">
                                    @if($incident)
                                        <span class="text-uppercase">Description incident</span></br>
                                        <span class="text-lg">{{ $incident->description }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 text-left text-xl text-uppercase">
                                    <h2 class="mb-2">
                                    <span class="fe fe-info mr-2"></span>    
                                    Liste Tâches</h2>
                                </div>
                                <div class="col-md-9 text-right" style="font-family: Century Gothic;">
                                    @can('creer-tache')
                                        @if($number_incident)
                                        <button 
                                                id="toto"
                                                data-sites="{{ json_encode(Session::get('sites')) }}"
                                                data-incident="{{ json_encode($incident) }}"
                                                data-departements="{{ json_encode(Session::get('departements')) }}"
                                                title="Ajout D'une Tâche"
                                                class="btn btn-primary btn-icon-split"
                                                >
                                            <span class="icon text-white-80">
                                                <i class="fe fe-plus" style="font-size:15px;"></i>
                                                <i class="fe fe-anchor mr-3" style="font-size:20px;"></i>
                                            </span>
                                            Ajout Tâche
                                        </button>
                                        @endif
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <!-- <p class="card-text">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, built upon the foundations of progressive enhancement, that adds all of these advanced features to any HTML table. </p> -->
                        <div class="row my-4">
                            <!-- Small table -->
                            <div class="col-md-12">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div class="row my-4">

                                            <div class="col-md-2">
                                                <select class="custom-select border-primary my-3" id="emis_recus">
                                                        <option value="">Tâche</option>
                                                        <option value="Emise">Emise</option>
                                                        <option value="Reçue">Reçue</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                        <select class="custom-select border-primary my-3" id="validationCustom04">
                                                            <option selected value="">Choisissez...</option>
                                                            <option value="ENCOURS">ENCOURS</option>
                                                            <option value="EN-ATTENTE">EN-ATTENTE</option>
                                                            <option value="RÉALISÉE">RÉALISÉE</option>
                                                            <option value="ANNULÉE">ANNULÉE</option>
                                                        </select>
                                                        <div class="invalid-feedback"> Please select a valid state. </div>
                                            </div>
                                            <div class="col-md-2">
                                                        <select class="custom-select border-primary my-3" id="departe">
                                                            <optgroup label="Liste Département">
                                                                <option selected value="">Choisissez...</option>
                                                                @if(Session::has('departements'))
                                                                @if(is_iterable(Session::get('departements')))
                                                                @foreach(Session::get('departements') as $departement)
                                                                <option value="{{ $departement->name }}">{{ $departement->name }}</option>
                                                                @endforeach
                                                                @endif
                                                                @endif
                                                            </optgroup>
                                                        </select>
                                                        <div class="invalid-feedback"> Please select a valid state. </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group mb-3">
                                                    <input type="date" class="form-control border-primary my-3" id="searchDate" aria-describedby="button-addon2">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input class="form-control border-primary my-3" id="searchMonth" type="month">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="text-right">
                                                    <input type="text" name="" id="search_text_simple" class="form-control border-primary my-3" placeholder="Search...">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- table -->
                                        <table style="font-family: Century Gothic;" class="table table-borderless table-hover" id="dataTable-1">
                                            <thead class="bg-dark">
                                                <tr>
                                                    <th>N°</th>
                                                    <th></th>
                                                    <th>Description Tâche</th>
                                                    @if(!$number_incident)
                                                        <th>Incident</th>
                                                    @endif
                                                    <th>Statut</th>
                                                    <th>Déclaration</th>
                                                    <th>Echéance</th>
                                                    <th>Clôture</th>
                                                    <th>Emétteur</th>
                                                    <th>Récepteur</th>
                                                    <th>Dégré Réalisation</th>
                                                    <th>Fichier</th>
                                                    <th></th>
                                                    <th>Log</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="tachsx">
                                                @if(is_iterable($taches))
                                                @foreach($taches as $key => $task)
                                                    <?php

                                                        $degre = $task->resolution_degree;
                                                        
                                                        $nombre_fichiers = 0;
                                                        
                                                        for ($i=0; $i < count($filesss); $i++) {
                                                            $fichier = $filesss[$i];
                                                            if($fichier->tache_id == $task->id){
                                                                $nombre_fichiers +=1;
                                                            }
                                                        }

                                                        $nombre_log = 0;

                                                        if(Session::has('logs')){
                                                        if(is_iterable(Session::get('logs'))){
                                                        for ($index=0; $index < count(Session::get('logs')); $index++) {
                                                            $log = Session::get('logs')[$index];
                                                            if($log->tache_id == $task->id){
                                                                $nombre_log +=1;
                                                            }
                                                        }}}
                                                        
                                                        $mon_user_incident = NULL;
                                                        if(Session::has('users_incidents')){
                                                        if(is_iterable(Session::get('users_incidents'))){
                                                        for ($d=0; $d < count(Session::get('users_incidents')); $d++) {
                                                            $iu = Session::get('users_incidents')[$d];
                                                            
                                                            if(
                                                                ($iu->incident_number == $task->incident_number) &&
                                                                ($iu->isTriggerPlus == TRUE)
                                                              )
                                                            {
                                                                $mon_user_incident = $iu;
                                                                break;
                                                            }
                                                        }}}

                                                        $utilisateur = NULL;
                                                        if($mon_user_incident){
                                                            if(Session::has('users')){
                                                            if(is_iterable(Session::get('users'))){
                                                            for ($l=0; $l < count(Session::get('users')); $l++) {
                                                                $user = Session::get('users')[$l];
                                                                if($user->id == $mon_user_incident->user_id){
                                                                    $utilisateur = $user;
                                                                }
                                                            }}}
                                                        }

                                                        $emetteur = NULL;
                                                        if($utilisateur){
                                                            if($utilisateur->site_id){
                                                                if(Session::has('sites')){
                                                                if(is_iterable(Session::get('sites'))){
                                                                for ($o=0; $o < count(Session::get('sites')); $o++) {
                                                                    $site = Session::get('sites')[$o];
                                                                    if($site->id == $utilisateur->site_id){
                                                                        $emetteur = $site;
                                                                    }
                                                                }}}
                                                            }elseif ($utilisateur->departement_id) {
                                                                if(Session::has('departements')){
                                                                if(is_iterable(Session::get('departements'))){
                                                                for ($f=0; $f < count(Session::get('departements')); $f++) { 
                                                                    $depar = Session::get('departements')[$f];
                                                                    if($depar->id == $utilisateur->departement_id){
                                                                        $emetteur = $depar;
                                                                    }
                                                                }}}
                                                            }
                                                        }
                                                        
                                                        $user_incident_verif = NULL;
                                                        if(Session::has('users_incidents')){
                                                        if(is_iterable(Session::get('users_incidents'))){
                                                        for ($j=0; $j < count(Session::get('users_incidents')); $j++) {
                                                            $ui = Session::get('users_incidents')[$j];

                                                            if(($ui->incident_number == $task->incident_number)){

                                                                if(intval($ui->user_id) == intval(Auth::user()->id)){
                                                                    $user_incident_verif  = $ui;
                                                                    break;
                                                                }
                                                            }
                                                        }}}
                                                    
                                                    ?>
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>
                                                        @if($user_incident_verif)
                                                            @if($user_incident_verif->isCoordo)
                                                                <span class="badge badge-light">Emise</span>
                                                            @else
                                                                <span class="badge badge-light mr-1">Reçue</span>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-light mr-1">Reçue</span>
                                                        @endif
                                                        </td>
                                                        <td><p style="font-size:0.7em;">{{ $task->description }}</p></td>
                                                        @if(!$number_incident)
                                                        <td>
                                                            <strong class="badge badge-light text-lg">
                                                                <a href="#!"
                                                                   title="Voir Plus Concernant L'incident"
                                                                   id="InfIncs"
                                                                   data-key="{{ $key+1 }}"
                                                                   data-users="{{ json_encode(Session::get('users')) }}"
                                                                   data-users_incidents="{{ json_encode(Session::get('users_incidents')) }}"
                                                                   data-ids="{{ json_encode($tab_ids) }}"
                                                                   data-exited="{{ json_encode($tab_exited) }}"
                                                                   data-created="{{ json_encode($tab_created) }}"
                                                                   data-tasks="{{ json_encode(Session::get('tasks')) }}"
                                                                   data-number="{{ $task->incident_number }}"
                                                                   data-incidents="{{ json_encode(Session::get('incidents')) }}"
                                                                   data-departements="{{ json_encode(Session::get('departements')) }}"
                                                                   data-sites="{{ json_encode(Session::get('sites')) }}"
                                                                   style="text-decoration:none;"
                                                                   data-backdrop="static"
                                                                   data-keyboard="false"
                                                                   data-toggle="modal"
                                                                   data-target="#modal_infos_incidant">
                                                                   {{ $task->incident_number }}
                                                                   <i class="fe fe-eye ml-2"></i>
                                                                </a>
                                                            </strong>
                                                        </td>
                                                        @endif
                                                        <td style="font-size:0.7em;">    
                                                                    <a

                                                                        @if($task->status == 'RÉALISÉE')
                                                                            style="color: #3ABF71; text-decoration:none;"
                                                                        @elseif($task->status == 'ENCOURS')
                                                                            style="color: #EEA303; text-decoration:none;"
                                                                        @else
                                                                            style="color: #1B68FF; text-decoration:none;"
                                                                        @endif
                                                                            href="#!"
                                                                            title="Modifier Le Statut De La Tâche"
                                                                            @if($user_incident_verif)
                                                                                @if($user_incident_verif->isTrigger)
                                                                                    id="modif_stay_tach"
                                                                                    data-key="{{ $key+1 }}"
                                                                                    data-task="{{ json_encode($task) }}"
                                                                                    data-backdrop="static"
                                                                                    data-keyboard="false"
                                                                                    data-toggle="modal"
                                                                                    data-target="#change_status"
                                                                                @endif
                                                                            @endif>
                                                                        {{ $task->status }}
                                                                    </a>
                                                        </td>

                                                        <td style="font-size:0.7em;">{{ ($task->created_at) }}</td>

                                                        <td style="font-size:0.7em;"
                                                                @if(intval(str_replace("-", "", $task->maturity_date)) < intval(str_replace("-", "", date('Y-m-d'))))
                                                                    style="color: red;"
                                                                @elseif(intval(str_replace("-", "", $task->maturity_date)) == intval(str_replace("-", "", date('Y-m-d'))))
                                                                    style="color:yellow;"
                                                                @else
                                                                    style="color:white;"
                                                                @endif
                                                            >
                                                                    <a 
                                                                        href="#!"
                                                                        @if($user_incident_verif)
                                                                            @if($user_incident_verif->isTrigger)
                                                                                @if(($task->status != "RÉALISÉE") && ($task->status != "EN-ATTENTE"))
                                                                                    data-key="{{ $key }}"
                                                                                    data-task="{{ json_encode($task) }}"
                                                                                    id="set_echeance_time"
                                                                                    data-backdrop="static"
                                                                                    data-keyboard="false"
                                                                                    data-toggle="modal"
                                                                                    data-target="#define_dat_echean"
                                                                                @endif
                                                                            @endif
                                                                        @endif

                                                                        title="Ajuster La Date D'échéance"
                                                                        @if(intval(str_replace("-", "", $task->maturity_date)) < intval(str_replace("-", "", date('Y-m-d'))))
                                                                            style="text-decoration:none;"
                                                                            class="text-danger"
                                                                        @elseif(intval(str_replace("-", "", $task->maturity_date)) == intval(str_replace("-", "", date('Y-m-d'))))
                                                                            style="text-decoration:none;"
                                                                            class="text-warning"
                                                                        @else
                                                                            style="text-decoration:none;"
                                                                        @endif
                                                                        >
                                                                        {{ $task->maturity_date }}
                                                                    </a>
                                                        </td>

                                                        <td style="font-size:0.7em;">{{ $task->closure_date ? $task->closure_date : '' }}</td>
                                                        <td style="font-size:0.7em;">
                                                            {{ $emetteur ? $emetteur->name : ""}}
                                                        </td>
                                                        <td style="font-size:0.7em;">{{ $task->departement_id ? "SERVICE " . $task->departements->name : ($task->site_id ? $task->sites->name : "")}}</td>
                                                        <td>
                                                                    <a  
                                                                        
                                                                        href="#!"
                                                                        style="text-decoration:none; padding-left:2em;"
                                                                        @if($user_incident_verif)
                                                                            @if($user_incident_verif->isTrigger)
                                                                                @if(($task->status != "RÉALISÉE") && ($task->status != "EN-ATTENTE"))
                                                                                    id="set_priority_degr"
                                                                                    data-task="{{ json_encode($task) }}"
                                                                                    data-key="{{ $key+1 }}"
                                                                                    data-backdrop="static"
                                                                                    data-keyboard="false"
                                                                                    data-toggle="modal"
                                                                                    data-target="#update_degree"
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                        >
                                                                       {{ $task->resolution_degree == 1 ? "00" : $task->resolution_degree }} %
                                                                    </a>
                                                        </td>
                                                        <td>
                                                                    @can('joindre-fichier')
                                                                        <a 
                                                                            href="#!"
                                                                            style="text-decoration:none;" 
                                                                            title="Joindre Le Fichier Justificatif"
                                                                            @if($user_incident_verif)
                                                                                @if($user_incident_verif->isTrigger)
                                                                                    @if($task->status == "ENCOURS")
                                                                                        data-key="{{ $key+1 }}"
                                                                                        data-task="{{ json_encode($task) }}"
                                                                                        data-backdrop="static"
                                                                                        data-keyboard="false" 
                                                                                        data-toggle="modal" 
                                                                                        data-target="#defaultModal"
                                                                                        class="files_id"
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                            >
                                                                            <div class="row">
                                                                                <small class="text-lg mr-3">{{ $nombre_fichiers < 10 ? 0 .''. $nombre_fichiers : $nombre_fichiers}}</small>
                                                                                <small class="fe fe-upload-cloud fe-32"></small>
                                                                            </div>
                                                                        </a>
                                                                    @endcan
                                                        </td>
                                                        <td class="mr-3">
                                                            @if($user_incident_verif)
                                                                @if($user_incident_verif->isTrigger)
                                                                    @can('telecharger-fichier')
                                                                        <a 
                                                                            data-key="{{ $key+1 }}"
                                                                            data-task="{{ json_encode($task) }}"
                                                                            data-files="{{ json_encode($filesss) }}"
                                                                            style="text-decoration:none;"
                                                                            data-backdrop="static"
                                                                            data-keyboard="false"
                                                                            data-toggle="modal"
                                                                            data-target="#downloadModal"
                                                                            href="#!" 
                                                                            title="Télécharger Le Fichier De La Tâche"
                                                                            class="fe fe-download-cloud fe-32 down_id">
                                                                        </a>
                                                                    @endcan
                                                                @else
                                                                    @can('telecharger-fichier')
                                                                        <a 
                                                                            style="text-decoration:none; color:white;"
                                                                            href="#!" 
                                                                            title="Télécharger Le Fichier De La Tâche"
                                                                            class="fe fe-download-cloud fe-32">
                                                                        </a>
                                                                    @endcan
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>{{ $nombre_log < 10 ? 0 .''. $nombre_log : $nombre_log }}</td>
                                                        <td>
                                                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="text-muted sr-only">Action</span>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                @if($number_incident)
                                                                    @if(($task->status != "ANNULÉE") && ($task->status != "RÉALISÉE"))
                                                                        <a  
                                                                            id="editions"
                                                                            class="dropdown-item" 
                                                                            href="#!"
                                                                            data-task="{{ json_encode($task) }}"
                                                                            data-backdrop="static"
                                                                            data-keyboard="false"
                                                                            data-toggle="modal"
                                                                            data-target="#modal_edit_task"><span class="fe fe-edit-2 mr-4"></span> Editer
                                                                        </a>
                                                                    @endif
                                                                @endif

                                                                @if($number_incident)
                                                                    <a class="dropdown-item" data-key="{{ $key+1 }}" id="supp_task" data-id="{{ $task->id }}" href="#!"><span class="fe fe-x mr-4"></span> Supprimer</a>
                                                                @endif
                                                                <a 
                                                                    class="dropdown-item" 
                                                                    data-key="{{ $key+1 }}" 
                                                                    id="see_task"
                                                                    data-task="{{ json_encode($task) }}"
                                                                    href="#!"
                                                                    data-backdrop="static"
                                                                    data-keyboard="false"
                                                                    data-toggle="modal"
                                                                    data-target="#modal_infos_task"><span class="fe fe-eye mr-4"></span> Voir
                                                                </a>

                                                                @can('log-tache')
                                                                    <a 
                                                                        class="dropdown-item"
                                                                        data-key="{{ $key+1 }}" 
                                                                        id="log_task"
                                                                        data-task="{{ json_encode($task) }}"
                                                                        data-incident=""
                                                                        data-logs="{{ json_encode(Session::get('logs')) }}"
                                                                        data-created_log="{{ json_encode($tab_created_log) }}"
                                                                        data-tab_id_log="{{ json_encode($tab_id_log) }}"
                                                                        href="#!"
                                                                        data-backdrop="static"
                                                                        data-keyboard="false"
                                                                        data-toggle="modal"
                                                                        data-target="#modal_log_tasks"><span class="fe fe-eye mr-4"></span> Log(s) Tâche
                                                                    </a>
                                                                @endcan

                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- simple table -->
                        </div> <!-- end section -->
                </div>
            </div> <!-- .row -->
        </div>
    </div>

    <!-- Modal error validation-->
    <div style="font-family: Century Gothic;" class="modal" id="tache_error_validations" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation" disabled style="width:100%; height:16em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="btn_tach_err_ok" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal error Degree Realisation-->
    <div style="font-family: Century Gothic;" class="modal" id="degreerealisation_error" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        Erreur Dégré Réalisation</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation_degree" disabled style="width:100%; height:4em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="btn_degree" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>


    <!-- Modal error validation changement statut tache -->
    <div class="modal" id="stat_task" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        Erreur Statut</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="textstat" disabled style="width:100%; height:4em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="btnStas" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal error validation-->
    <div style="font-family: Century Gothic;" class="modal" id="tache_error_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation_edin" disabled style="width:100%; height:14em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="btn_tachedinok" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal error Ajout tache a un incident cloture-->
    <div style="font-family: Century Gothic;" class="modal" id="eror_task_add_in" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        Erreur Ajout Tâche</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validat_tsk" disabled style="width:100%; height:6em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>


    <!-- Modal error validation date echeance-->
    <div class="modal" id="echedate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        Erreur Date</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation_due_date" disabled style="width:100%; height:7em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_btn_ude" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>


    <!-- Modal Changement De Statut D'une Tâche -->
    <div id="change_status" style="font-family:Century Gothic;" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="text-xl" id="verticalModalTitle">
                                        <i class="fe fe-battery-charging mr-3" style="font-size:20px;"></i>
                                    Statut Tâche
                                </h5>
                                <button id="btnExitModalCloture" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card shadow" style="padding:2em;">
                                    <div class="row my-4 text-lg" style="text-align:center">
                                        <div class=" col-md-4 text-left"><strong>Tâche N°</strong> </div>
                                        <div class=" col-md-8 text-right"><strong id="tachi"></strong></div>
                                    </div>
                                    <div class="my-3">
                                        <label class="text-xl" for="statut_e">
                                            <span class="fe fe-battery-charging fe-16 mr-1"></span>    
                                            Séléctionner Un Statut <span style="color:red;"> *</span>
                                        </label>
                                        <div class="form-group">
                                            <select style="font-size:1.2em;" class="custom-select border-success" name="status" id="statut_e">
                                                <option selected value="">Choisissez...</option>
                                                <option value="ENCOURS">ENCOURS</option>
                                                <option value="EN-ATTENTE">EN-ATTENTE</option>
                                                <option value="RÉALISÉE">RÉALISÉE</option>
                                                <option value="ANNULÉE">ANNULÉE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="segment">
                                    </div>
                                    <div class="form-group">
                                        <button id="tasch_m" data-fichiers="{{ json_encode($filesss) }}" data-task="" class="btn btn-outline-success btn-block">
                                            <span class="fe fe-battery-charging fe-16 mr-3"></span>
                                            Modifier Le Statut
                                        </button>
                                    </div>
                                    
                                </div>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->


    <!-- Modal Task -->
    <div style="font-family: Century Gothic; font-size:15px;" class="modal" id="modal_task" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="verticalModalTitle">
                                    <i class="fe fe-plus" style="font-size:15px;"></i>
                                    <i class="fe fe-anchor mr-3" style="font-size:20px;"></i>
                                Attribution D'une Tâche A Un Incident</h5>
                              <button id="btnExitModalTask" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                    <div class="card">
                                            <div class="card-header" style="margin-bottom: 1em;">
                                                <div class="row">
                                                    <strong style="font-size:20px;" class="card-title">
                                                        <div class="col-md-12">
                                                            <span class="text">Incident</span>
                                                            <span id="txt_num_i" style="margin-left: 13em;" class="text"></span>
                                                        </div>
                                                    </strong>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <form id="frmtasks">
                                                        @csrf
                                                        @method('POST')
                                                    <input type="hidden" id="inco" value="" name="number">
                                                    <div class="form-group mb-4">
                                                        <label for="desc_unique"><span class="fe fe-edit mr-1"></span> Description (Décrivez De Facon Brève L'objectif De Votre Tâche !) <span style="color:red;"> *</span></label>
                                                        <textarea style="resize:none; font-size:1.2em;" class="form-control border-primary" id="desc_unique" name="description" placeholder="Veuillez Décrire En Quoi Consiste La Tâche..." rows="7"></textarea>
                                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="obs_task"><span class="fe fe-edit-2 mr-1"></span> Observation <span style="color:red;"> *</span></label>
                                                        <textarea style="resize:none; font-size:1.2em;" class="form-control border-primary" id="obs_task" name="observation_task" placeholder="Veuillez Renseigner Une Observation..." rows="5"></textarea>
                                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="date_echeance_unique">
                                                        <span class="fe fe-calendar fe-16 mr-1"></span>    
                                                        Date D'échéance De La Tâche <span style="color:red;"> *</span></label>
                                                        <div class="input-group">
                                                        <input type="date" class="form-control border-primary" id="date_echeance_unique" name="maturity_date" aria-describedby="button-addon2">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16 mx-2"></span></div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group my-4">
                                                        <label for="number_ds_task">Numéro De Demande De Service</label>
                                                        <input style="font-size:1.2em;" type="text" class="form-control border-primary" id="number_ds_task" name="ds_number">
                                                    </div>
                                                    <div class="form-group my-4">
                                                        <label for="deepartes">
                                                            <span class="fe fe-home fe-16 mr-2"></span>
                                                            (Département | Site) Chargé De Resoudre L'incident <span style="color:red;"> *</span>
                                                        </label>
                                                        <select 
                                                                style="font-size: 1.2em;" 
                                                                data-departements="{{ json_encode(Session::get('departements')) }}" 
                                                                data-types="{{ json_encode(Session::get('types')) }}" 
                                                                data-sites="{{ json_encode(Session::get('sites')) }}" 
                                                                class="custom-select border-primary" 
                                                                name="deepartes" 
                                                                id="deepartes" 
                                                                data-number="{{ $number_incident }}" 
                                                                data-users_incidents="">

                                                            <optgroup label="Liste Département">
                                                                        <option selected value="">Choisissez...</option>
                                                                        @if(Session::has('departements'))
                                                                        @if(is_iterable(Session::get('departements')))
                                                                        @foreach(Session::get('departements') as $departement)
                                                                        <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                                                                        @endforeach
                                                                        @endif
                                                                        @endif
                                                            </optgroup>
                                                            <optgroup label="Liste Type Site">
                                                                        @if(Session::has('types'))
                                                                        @if(is_iterable(Session::get('types')))
                                                                        @foreach(Session::get('types') as $type)
                                                                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                                                                        @endforeach
                                                                        @endif
                                                                        @endif
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                    <div id="devdocs"></div>
                                                </form>
                                            </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                    <div class="row my-4">
                                                        <div class="text-left col-xs-6">
                                                            <button type="button" id="btn_clear_fields" class="btn btn-danger">
                                                                <span class="fe fe-trash fe-16 mr-1"></span>
                                                                <span class="text-lg">Effacer Le Texte</span>
                                                            </button>
                                                        </div>
                                                        <div class="text-right col-xs-6 ml-4">
                                                            <button type="button" id="btn_add_unique_task" class="btn btn-primary">
                                                                <span class="fe fe-anchor fe-16"></span>
                                                                <span class="fe fe-save mr-2"></span> 
                                                                <span class="text-lg">Attribuer La Tâche</span>
                                                            </button>
                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    </div>


    <!-- Modal Confirmation Save Task -->
    <div class="modal" id="modalConfirmationSaveTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-xl">
                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                    <i class="fe fe-check mr-3"></i>
                                    Confirmez-Vous Ces Informations ?</h5>
                                </div>
                                <div class="modal-body">
                                        <div class="card">
                                                <div class="card-header">
                                                    <strong style="font-size:20px;" class="card-title">Tâche</strong>
                                                </div>  
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Description De La Tâche</span>
                                                                </td>
                                                                <td>
                                                                <textarea style="color:white; resize:none;" disabled name="" id="decrit_conf" rows="7"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Observation De La Tâche</span>
                                                                </td>
                                                                <td>
                                                                <textarea style="color:white; resize:none;" disabled name="" id="obss_conf" rows="5"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Numéro De DS De La Tâche</span>
                                                                </td>
                                                                <td>
                                                                <span style="color: white; font-size: 20px;" id="dsis_conf"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Date D'échéance De La Tâche</span>
                                                                </td>
                                                                <td>
                                                                <span style="color: white; font-size: 20px;" id="eche_conf"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Le Gérant De La Tâche</span>
                                                                </td>
                                                                <td>
                                                                <span style="color: white; font-size: 20px;" id="gerant_conf"></span>
                                                            </td>
                                                        </tr>
                                                    <tbody>
                                                </table>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="conf_save_t" class="btn btn-primary">OUI</button>
                                    <button type="button" id="infir_save_t" class="btn btn-secondary" data-dismiss="modal">NON</button>
                                </div>
                            </div>
                        </div>
    </div> 


    <!-- MODAL INFO INCIDENT -->
    <div style="font-family: Century Gothic;" id="modal_infos_incidant" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-info mr-3"></i>
                                    <span class="text-lg">Informations Incident</span>
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="col-md-12 mb-4 mt-4">
                                        <div class="card shadow">
                                            <div class="card-header">
                                                <div class="row text-lg my-4">
                                                    <div class="text-left col-md-6">
                                                        <strong>Tâche N°</strong>
                                                    </div>
                                                    <div class="text-right col-md-6">
                                                        <strong class="card-title"><span class="numero_tasks"></span></strong>
                                                    </div>
                                                </div>
                                                <div class="row text-lg">
                                                    <div class="text-left col-md-6">
                                                        <span>Incident Numéro</span>
                                                    </div>
                                                    <div class="text-right col-md-6">
                                                        <strong class="card-title"><span class="sident"></span></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                            <div class="list-group list-group-flush my-n3">
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
                                                    <div class="my-0 big"><span class="cloture_daate"></span></div>
                                                    </div>
                                                    <div class="col-auto">
                                                    <small class="badge badge-pill badge-light text-uppercase">Date De Clôture</small>
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
                                        </div> 
                                    </div><!-- / .card-body -->
                            </div> <!-- / .card -->
                        </div>
                    </div>
    </div> <!-- small modal -->


    <!-- Modal SET Date D'échéance D'une Tache -->
    <div style="font-family: Century Gothic;" id="define_dat_echean" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-clock mr-3" style="font-size:20px;"></i>
                                        Échéance D'une Tâche</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="card shadow" style="padding:2em;">
                                        <div class="row my-4 text-lg">
                                            <div class="col-md-6 text-left">
                                                <strong>Tâche N°</strong>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <strong id="nibi"></strong>
                                            </div>
                                        </div>
                                        <div class="row my-4">
                                            <label for="date_echeance">
                                                <span class="fe fe-calendar fe-16 mr-1"></span>
                                                Date D'échéance
                                            </label>
                                            <div class="input-group">
                                                <input type="date" class="form-control border-success" id="date_maturity" aria-describedby="button-addon2">
                                                <div class="input-group-append">
                                                    <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16 mx-2"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <button data-task="" id="echeance_btn_inc" class="btn btn-block btn-outline-success">
                                                <span class="fe fe-clock fe-16 mr-3"></span>
                                                Définir La Date
                                            </button>
                                        </div>
                                    </div>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->


    <!-- Modal Edit Task -->
    <div style="font-family: Century Gothic; font-size:15px;" class="modal" id="modal_edit_task" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="verticalModalTitle">
                                    <i class="fe fe-plus" style="font-size:15px;"></i>
                                    <i class="fe fe-anchor mr-3" style="font-size:20px;"></i>
                                Edition Des Informations D'une Tâche</h5>
                              <button id="btnKali" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                    <div class="card">
                                            <div class="card-header" style="margin-bottom: 1em;">
                                                <div class="row">
                                                    <strong style="font-size:20px;" class="card-title">
                                                        <div class="col-md-12">
                                                            <span class="text">Incident</span>
                                                            <span id="txt_num_i_edit" style="margin-left: 13em;" class="text"> </span>
                                                        </div>
                                                    </strong>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <form id="frmedittasks">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" id="hids" value=" " name="number">
                                                        <input type="hidden" id="id_edit" value="" name="id">
                                                    <div class="form-group mb-4">
                                                        <label for="desc_uniques"><span class="fe fe-edit mr-1"></span> Description (Décrivez De Facon Brève L'objectif De Votre Tâche !) <span style="color:red;"> *</span></label>
                                                        <textarea style="resize:none; font-size:1.2em;" class="form-control border-primary" id="desc_uniques" name="description" placeholder="Veuillez Entrer Une Cause Assez Exacte." rows="6"></textarea>
                                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="obs_task_edit"><span class="fe fe-edit-2 mr-1"></span> Observation <span style="color:red;"> *</span></label>
                                                        <textarea style="resize:none; font-size:1.2em;" class="form-control border-primary" id="obs_task_edit" name="observation_task" placeholder="Veuillez Renseigner Une Observation..." rows="5"></textarea>
                                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="dateing"><i class="fe fe-calendar mr-2"></i>Date D'échéance De La Tâche <span style="color:red;"> *</span></label>
                                                        <div class="form-group">
                                                        <input type="date" class="form-control border-primary" id="dateing" name="maturity_date">
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="degree_realis">
                                                            <i class="fe fe-percent mr-2"></i>
                                                            Séléctionner Un Dégré De Réalisation De La Tâche <span style="color:red;"> *</span>
                                                        </label>
                                                        <div class="form-group">
                                                            <select style="font-size:1.2em;" class="custom-select border-primary" name="resolution_degree" id="degree_realis">
                                                                <option selected value="">Choisissez...</option>
                                                                <option value="0">0%</option>
                                                                <option value="1">1%</option>
                                                                <option value="5">5%</option>
                                                                <option value="10">10%</option>
                                                                <option value="15">15%</option>
                                                                <option value="20">20%</option>
                                                                <option value="25">25%</option>
                                                                <option value="30">30%</option>
                                                                <option value="35">35%</option>
                                                                <option value="40">40%</option>
                                                                <option value="45">45%</option>
                                                                <option value="50">50%</option>
                                                                <option value="55">55%</option>
                                                                <option value="60">60%</option>
                                                                <option value="65">65%</option>
                                                                <option value="70">70%</option>
                                                                <option value="75">75%</option>
                                                                <option value="80">80%</option>
                                                                <option value="85">85%</option>
                                                                <option value="90">90%</option>
                                                                <option value="95">95%</option>
                                                                <option value="100">100%</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group my-4">
                                                        <label for="deepartes_edit">
                                                            <span class="fe fe-home fe-16 mr-2"></span>
                                                            (Département | Site) Chargé De Resoudre L'incident <span style="color:red;"> *</span>
                                                        </label>
                                                        <select 
                                                                style="font-size: 1.2em;" 
                                                                data-departements="{{ json_encode(Session::get('departements')) }}"
                                                                data-types="{{ json_encode(Session::get('types')) }}" 
                                                                data-sites="{{ json_encode(Session::get('sites')) }}" 
                                                                class="custom-select border-primary" 
                                                                name="deepartes_edit" 
                                                                id="deepartes_edit" 
                                                                data-number="{{ $number_incident }}" 
                                                                data-users_incidents="">

                                                            <optgroup label="Liste Département">
                                                                        <option selected value="">Choisissez...</option>
                                                                        @if(Session::has('departements'))
                                                                        @if(is_iterable(Session::get('departements')))
                                                                        @foreach(Session::get('departements') as $departement)
                                                                        <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                                                                        @endforeach
                                                                        @endif
                                                                        @endif
                                                            </optgroup>
                                                            <optgroup label="Liste Type Site">
                                                                        @if(Session::has('types'))
                                                                        @if(is_iterable(Session::get('types')))
                                                                        @foreach(Session::get('types') as $type)
                                                                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                                                                        @endforeach
                                                                        @endif
                                                                        @endif
                                                            </optgroup>
                                                        </select>
                                                    </div>
                                                    <div id="devdocs_edit"></div>
                                                    <div class="form-row">
                                                        <div class="text-left mr-4">
                                                            
                                                        </div>
                                                        <div class="ml-auto w-40">
                                                            <button type="button" id="btn_clear_fields_edit" class="btn btn-sm btn-light">
                                                                <span class="fe fe-trash fe-16 mr-1"></span>
                                                                 Effacer Le Texte Des Champs
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btn_edit_unique_task" class="btn btn-sm btn-primary">
                                    <span class="fe fe-anchor fe-32"></span>
                                    <span class="fe fe-save mr-2"></span> 
                                    <span class="text-lg">Edition De La Tâche</span>
                                </button>
                            </div>
                          </div>
                        </div>
    </div>


    <!-- Modal Upload File -->
    <div style="font-family:Century Gothic;" class="modal" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-lg" id="defaultModalLabel">
                                    <span class="fe fe-upload fe-32 mr-4"></span>
                                    Chargement Fichier(s)
                                </h5>
                              <button id="close_page_chargement_fichier" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <div class="row col-md-12 text-lg my-4">
                                    <div class="text-left col-md-5">
                                        <span>Tache N°</span>
                                    </div>
                                    <div class="text-right col-md-7">
                                        <strong class="card-title"><span class="radjad"></span></strong>
                                    </div>
                                </div>                                <div class="row col-md-12 text-lg my-4">
                                    <div class="text-left col-md-5">
                                        <span>Incident Numéro</span>
                                    </div>
                                    <div class="text-right col-md-7">
                                        <strong class="card-title"><span class="ispad"></span></strong>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="card shadow mb-4">
                                            <div class="card-header">
                                            <strong>
                                                Zone De Chargement Du Fichier
                                            </strong>
                                            </div>
                                            <div class="card-body">
                                                <form action="upload.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" value="" name="id" id="id_task">
                                                    <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                                                    <input type="hidden" value="" name="numero">

                                                    <div class="form-group">
                                                        <input type="file" multiple="multiple" class="form-control" name="file[]" id="inputfile">
                                                    </div>
                                                    <div class="form-group">
                                                        <button disabled id="btn_uploads" class="btn btn-block btn-primary" name="sumbit_files" type="submit">
                                                            <span class="fe fe-upload fe-16 mr-2"></span>
                                                            Charger Le(s) Fichier(s)
                                                        </button>
                                                    </div>
                                                </form>
                                            </div> <!-- .card-body -->
                                        </div> <!-- .card -->
                                    </div> <!-- .col -->
                                </div>
                            </div>
                          </div>
                        </div>
    </div>

    <!-- Modal Download File -->
    <div style="font-family:Century Gothic;" class="modal" id="downloadModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="text-lg" id="defaultModalLabel">
                                    <span class="fe fe-download fe-32 mr-4"></span>
                                    TéléChargement Fichier(s)
                                </h5>
                              <button id="exit_modal_down" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <div class="row col-md-12 text-lg my-4">
                                    <div class="text-left col-md-5">
                                        <span>Tache N°</span>
                                    </div>
                                    <div class="text-right col-md-7">
                                        <strong class="card-title"><span class="citedor"></span></strong>
                                    </div>
                                </div>                                
                                <div class="row col-md-12 text-lg my-4">
                                    <div class="text-left col-md-5">
                                        <span>Incident Numéro</span>
                                    </div>
                                    <div class="text-right col-md-7">
                                        <strong class="card-title"><span class="zaya"></span></strong>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="card shadow mb-4">
                                            <div class="card-header">
                                                <strong>
                                                </strong>
                                            </div>
                                            <div class="card-body">
                                                <form action="upload.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" value="" name="id" id="idtach">
                                                    <input type="hidden" value="" name="grant" id="midoriya">
                                                    <input type="hidden" value="" name="numero_down">
                                                    <div class="form-group">
                                                        <span class="text-lg my-4" id="span_info">
                                                            <i class="fe fe-file fe-32 mr-2"></i> 
                                                            TéléCharger Le(s) Fichier(s) De Réalisation De La Tâche
                                                        </span>
                                                        <div class="mt-4" id="bakugo"></div>
                                                    </div>
                                                </form>
                                            </div> <!-- .card-body -->
                                        </div> <!-- .card -->
                                    </div> <!-- .col -->
                                </div>
                            </div>
                          </div>
                        </div>
    </div>

    <!-- Modal Changement Du Dégré De Réalisation D'une Tâche -->
    <div style="font-family:Century Gothic;" id="update_degree" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="text-xl" id="verticalModalTitle">
                                        <i class="fe fe-thumbs-up mr-3" style="font-size:20px;"></i>
                                        Dégré De Réalisation De La Tâche</h5>
                                <button id="btnExitModalCloture" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card shadow" style="padding: 1.5em;">
                                    <div class="row text-lg mb-4" style="text-align:center">
                                        <div class=" col-md-4 text-left"><strong>Tâche N°</strong> </div>
                                        <div class=" col-md-8 text-right"><strong id="ttach"></strong></div>
                                    </div>
                                    <div class="my-4">
                                        <label class="text-lg my-2" for="degree_r">
                                            <i class="fe fe-percent mr-2"></i>
                                            Séléctionner Un Dégré De Réalisation
                                        </label>
                                        <div class="form-group">
                                            <select style="font-size:1.2em;" class="custom-select border-success" name="degree_r" id="degree_r">
                                                <option selected value="">Choisissez...</option>
                                                <option value="0">0%</option>
                                                <option value="10">10%</option>
                                                <option value="15">15%</option>
                                                <option value="20">20%</option>
                                                <option value="25">25%</option>
                                                <option value="30">30%</option>
                                                <option value="35">35%</option>
                                                <option value="40">40%</option>
                                                <option value="45">45%</option>
                                                <option value="50">50%</option>
                                                <option value="55">55%</option>
                                                <option value="60">60%</option>
                                                <option value="65">65%</option>
                                                <option value="70">70%</option>
                                                <option value="75">75%</option>
                                                <option value="80">80%</option>
                                                <option value="85">85%</option>
                                                <option value="90">90%</option>
                                                <option value="95">95%</option>
                                                <option value="100">100%</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="my-4">
                                        <div class="form-group">
                                            <button id="valid_deg" data-tache="" class="btn btn-outline-success btn-block">
                                                <span class="fe fe-thumbs-up fe-16 mr-3"></span>
                                                Modifier Le Dégré
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->

    <!-- Modal Demande De Service Tâche -->
    <div id="serviceAski" style="font-family: Century Gothic;" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-smile mr-3" style="font-size:20px;"></i>
                                    Demande De Service
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="frm_askService" autocomplete="off">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="idTa" id="t_In">
                                    <div class="row mb-4">
                                        <div class="card col-md-12 shadow">
                                            <div class="card-header">
                                                    <strong>
                                                        
                                                    </strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group mb-3">
                                                    <label for="tit" style="font-size: 15px;"> <span class="fe fe-edit-2 mr-1"></span> Titre (Objet Demande De Service)</label>
                                                    <textarea style="resize:none; font-size:17px; font-family: Century Gothic;" rows="4" class="form-control" id="tit" name="title" placeholder="Veuillez Entrer L'objet De La Demande De Service."></textarea>
                                                    <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                </div>

                                                <label for="maturity_dat" style="font-size: 15px;"> <span class="fe fe-edit-2 mr-1"></span> Date D'échéance</label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control" name="maturity_date" id="maturity_dat" aria-describedby="button-addon2">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16 mx-2"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button id="btnSaveAskingServie" type="button" class="btn btn-sm btn-outline-primary btn-block">
                                                <span class="fe fe-smile fe-16 mr-3 text-white"></span>
                                                <span style="font-size: 20px; color:white;">Envoyer</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->

    <!-- MODAL INFO TASK -->
    <div id="modal_infos_task" style="font-family: Century Gothic;" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-info mr-3"></i>
                                    <span class="text-lg">Informations Tâche</span>
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="col-md-12 mb-4 mt-4">
                                <div class="card shadow">
                                            <div class="card-header my-2">
                                                <strong class="card-title text-lg"><span id="inf_number">Tâche N°</span></strong>
                                                <strong class="float-right text-lg" href="#!"><span id="burpi"></span></strong>
                                            </div>
                                            <div class="row col-md-12 text-lg my-4">
                                                    <div class="text-left col-md-5">
                                                        <span>Incident Numéro</span>
                                                    </div>
                                                    <div class="text-right col-md-7">
                                                        <strong class="card-title"><span class="nidis"></span></strong>
                                                    </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="list-group list-group-flush my-n3">
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
                                                                <div class="my-0 big"><span class="obbs_tas"></span></div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <small class="badge badge-pill badge-light text-uppercase">Observation De La Tâche</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="list-group-item">
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                            <small><strong></strong></small>
                                                            <div class="my-0 big"><span class="comment_show"></span></div>
                                                            </div>
                                                            <div class="col-auto">
                                                            <small class="badge badge-pill badge-light text-uppercase">commentaire de resolution</small>
                                                            </div>
                                                        </div> <!-- / .row -->
                                                    </div>
                                                    <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                        <small><strong></strong></small>
                                                        <div class="my-0 big"><span class="observation_show"></span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                        <small class="badge badge-pill badge-light text-uppercase">Observation Faite</small>
                                                        </div>
                                                    </div> <!-- / .row -->
                                                    </div>
                                                    <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                        <small><strong></strong></small>
                                                        <div class="my-0 big"><span class="motif_an"></span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                        <small class="badge badge-pill badge-light text-uppercase">motif d'annulation</small>
                                                        </div>
                                                    </div>
                                                    </div> <!-- / .row -->
                                                    <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                        <small><strong></strong></small>
                                                        <div class="my-0 big"><span class="motif_misenatou"></span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                        <small class="badge badge-pill badge-light text-uppercase">motif de mise en attente</small>
                                                        </div>
                                                    </div>
                                                    </div> <!-- / .row -->
                                                </div> <!-- / .list-group -->
                                            </div> <!-- / .card-body -->
                                </div> <!-- / .card -->
                            </div>
                        </div>
                    </div>
    </div> <!-- small modal -->


    <!-- MODAL LOG TASK -->
    <div id="modal_log_tasks" style="font-family: Century Gothic;" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-info mr-3"></i>
                                    <span class="text-lg">Log(s) Tâche <i class="sident"></i></span>
                                </h5>
                                <button type="button" id="resetlog" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="col-md-12 mb-4 mt-4">
                                <div class="card shadow">
                                            <div class="card-header">
                                                <strong class="card-title"><span id="inf_number"></span></strong>
                                                <!-- <a class="float-right small text-muted" href="#!">Voir Tous</a> -->
                                            </div>
                                        <div class="card-body">
                                            <div class="row my-4">
                                                <div class="col-md-6 text-left">
                                                    <strong>Tâche N°</strong>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <strong id="tekila"></strong>
                                                </div>
                                            </div>
                                            <div class="list-group list-group-flush dubai my-n3">
                                                <div class="row text-xl my-4">
                                                    <div class="col">
                                                        <small><strong style="margin-left:4em;">Description</strong></small>
                                                    </div>
                                                    <div class="col">
                                                        <small><strong style="margin-left:3em;"><span class="fe fe-calendar fe-16 mr-2"></span>Date De Modification</strong></small>
                                                    </div>
                                                    <div class="col">
                                                        <small><strong style="margin-left:1.5em;"><span class="fe fe-battery-charging fe-16 mr-2"></span>Nouveau(x) Statu(s)</strong></small>
                                                    </div>
                                                    <div class="col">
                                                        <small><strong><span class="fe fe-user fe-16 mr-2"></span>Utilisateur</strong></small>
                                                    </div>
                                                </div>
                                            </div> <!-- / .list-group -->
                                        </div> <!-- / .card-body -->
                                </div> <!-- / .card -->
                            </div>
                        </div>
                    </div>
    </div> <!-- small modal -->


    <script src="{{ url('taches.js') }}"></script>

@endsection