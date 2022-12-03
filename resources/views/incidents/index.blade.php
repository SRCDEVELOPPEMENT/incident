@extends('layouts.main')


@section('content')

    <div class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-md-5 text-left text-xl text-uppercase">
                                    <h1 class="mb-2">
                                    <span class="fe fe-info mr-2"></span>    
                                    Liste Incidents Notable</h1>
                                </div>
                                <div class="col-md-7 text-right">
                                    <button 
                                            id="toto"
                                            data-backdrop="static" 
                                            data-keyboard="false"
                                            title="Déclaration D'incident" 
                                            style="background-color: #345B86;" 
                                            class="btn btn-icon-split"
                                            data-toggle="modal" 
                                            data-target="#modal_incident">
                                            <span class="icon text-white-80">
                                                <i class="fe fe-plus" style="font-size:15px;"></i>
                                                <i class="fe fe-bell mr-3" style="font-size:20px;"></i>
                                            </span>
                                        Déclaration Incident
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- <p class="card-text">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, built upon the foundations of progressive enhancement, that adds all of these advanced features to any HTML table. </p> -->
                        <div class="row my-4">
                            <!-- Small table -->
                            <div class="col-md-12">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-4 text-left">
                                                <!-- <label for="validationCustom04">State</label> -->
                                                <select class="form-control select2" id="validationCustom04">
                                                    <option selected value="">Choisissez Une Catégorie...</option>
                                                    @foreach($categories as $categorie)
                                                    <option value="{{ $categorie->name }}">{{ $categorie->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback"> Please select a valid state. </div>
                                            </div>
                                            <div class="col-md-3 text-right">
                                                <!-- <label for="validationCustom04">State</label> -->
                                                <select class="custom-select" id="year_courant_incident">
                                                        <option selected value="">Choisissez Une Année...</option>
                                                        @foreach($years as $year)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                </select>
                                                <div class="invalid-feedback"> Please select a valid state. </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group mb-3">
                                                    <input type="date" class="form-control" id="searchDate" aria-describedby="button-addon2">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16 mx-2"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- table -->
                                        <table class="table table-hover datatables" id="dataTable-1">
                                            <thead class="bg-dark text-white">
                                                <tr>
                                                    <th></th>
                                                    <th>Numéro</th>
                                                    <th>Description Incident</th>
                                                    <th>Déclaration</th>
                                                    <th>Echéance</th>
                                                    <!-- <th>Statut</th> -->
                                                    <th>Procéssus Impacté</th>
                                                    <th>Catégorie</th>
                                                    <th>Priorité</th>
                                                    <th>Tâches</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="agencies">
                                                @foreach($incidents as $key => $incident)
                                                    <?php
                                                        $nombre_taches = 0;
                                                        for ($i=0; $i < count($tasks); $i++) {
                                                            $task = $tasks[$i];
                                                            if($task->incident_number == $incident->number){
                                                                $nombre_taches +=1;
                                                            }
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input">
                                                                <label class="custom-control-label"></label>
                                                            </div>
                                                        </td>
                                                        <td>{{ $incident->number }}<span class="dot dot-lg bg-primary ml-2"></span></td>
                                                        <td>{{ $incident->description }}</td>
                                                        <td>{{ substr($incident->created_at, 0, 10) }}</td>
                                                        <td>
                                                            @if($incident->due_date)
                                                            <a  
                                                                id="due_date_set"
                                                                data-incident="{{ $incident }}"
                                                                style="text-decoration:none;"
                                                                href="#"
                                                                data-backdrop="static"
                                                                data-keyboard="false"
                                                                data-toggle="modal"
                                                                data-target="#define_dat_echean"
                                                            >
                                                            {{ $incident->due_date }}
                                                            </a>
                                                            @else
                                                            <a  
                                                                id="due_date_set"
                                                                data-incident="{{ $incident }}"
                                                                style="text-decoration:none;"
                                                                href="#"
                                                                data-backdrop="static"
                                                                data-keyboard="false"
                                                                data-toggle="modal"
                                                                data-target="#define_dat_echean"
                                                            >
                                                            DÉFINISSEZ LA DATE D'ÉCHÉANCE
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <!-- <td>
                                                            @if($incident->status == "RÉSOLU")
                                                            <a 
                                                                style="color: #B4EE2C; text-decoration:none;"
                                                                href="#">
                                                                {{ $incident->status }}
                                                            </a>
                                                            @elseif($incident->status == "ANNULÉ")
                                                            <a 
                                                                style="color: white; text-decoration:none;"
                                                                href="#"
                                                                >
                                                                {{ $incident->status }}
                                                            </a>
                                                            @else
                                                            <a 
                                                                id="status1"
                                                                data-incident="{{ $incident }}"
                                                                style="color: #EEA303; text-decoration:none;"
                                                                href="#"
                                                                data-backdrop="static"
                                                                data-keyboard="false"
                                                                data-toggle="modal"
                                                                data-target="#change_status_incident">
                                                                {{ $incident->status }}
                                                            </a>
                                                            @endif
                                                        </td> -->
                                                        <td>{{ $incident->processus->name }}</td>
                                                        <td>{{ $incident->categories->name }}</td>
                                                        <td>
                                                            @if($incident->priority)
                                                            <a 
                                                                id="define_prioriti"
                                                                data-incident="{{ $incident }}"
                                                                @if($incident->priority == 'URGENT')
                                                                style="color:red; text-decoration:none;"
                                                                @elseif($incident->priority == 'ÉLEVÉE')
                                                                style="color:yellow; text-decoration:none;"
                                                                @else
                                                                style="color:green; text-decoration:none;"
                                                                @endif
                                                                href="#"
                                                                data-backdrop="static"
                                                                data-keyboard="false"
                                                                data-toggle="modal"
                                                                data-target="#edit_priority_incident">
                                                                {{ $incident->priority }}
                                                            </a>
                                                            @else
                                                            <a 
                                                                style="text-decoration:none;"
                                                                href="#"
                                                                id="define_prioriti"
                                                                data-incident="{{ $incident }}"
                                                                data-backdrop="static"
                                                                data-keyboard="false"
                                                                data-toggle="modal"
                                                                data-target="#edit_priority_incident">
                                                                DÉFINISSEZ UNE PRIORITÉ
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a 
                                                                style="text-decoration:none; color: white;" 
                                                                href="{{ route('listedTask', ['number' => $incident->number]) }}" 
                                                                title="Liste Des Tâches De L'incident">
                                                                <small class="text-white text-lg mr-1">{{ $nombre_taches < 10 ? 0 .''. $nombre_taches : $nombre_taches}}</small>
                                                                <span class="fe fe-list"></span>
                                                                <span class="fe fe-check"></span>
                                                            </a>
                                                        </td>
                                                        <td><a style="text-decoration:none; color:white;" type="button" href="{{ route('printIncident', ['number' => $incident->number]) }}" title="Imprimer Cet Incident" class="fe fe-printer fe-32"></a></td>
                                                        <!-- <td><a style="text-decoration:none; color:white;" type="button" href="{{ route('listedBattle', ['number' => $incident->number]) }}" title="Travaux Réalisés Pour Cet Incident" class="fe fe-check-circle fe-32"></a></td> -->
                                                        <td>
                                                            <a 
                                                               id="toggle"
                                                               data-incident="{{ $incident }}"
                                                               type="button"
                                                               href="#" 
                                                               title="Cloturer Cet Incident"
                                                               
                                                               @if($incident->closure_date)
                                                               style="text-decoration:none; color:green;"
                                                               class="fe fe-toggle-right fe-32 saiyan"

                                                               @else
                                                               style="text-decoration:none; color:white;"
                                                               class="fe fe-toggle-left fe-32 saiyan"
                                                               @endif
                                                               >
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="text-muted sr-only">Action</span>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <!-- <a class="dropdown-item incd mb-1"
                                                                data-id="{{ $incident->number }}"
                                                                data-backdrop="static"
                                                                data-keyboard="false"
                                                                data-toggle="modal"
                                                                data-target="#modal_task" 
                                                                href="#"><span class="fe fe-anchor mr-4"></span> Attribuer Une Tâche
                                                                </a> -->
                                                                <!-- <a 
                                                                data-incident="{{ $incident }}"
                                                                id="battle_actions"
                                                                class="dropdown-item mb-1"
                                                                href="#"
                                                                data-backdrop="static"
                                                                data-keyboard="false"
                                                                data-toggle="modal"
                                                                data-target="#battles" ><span class="fe fe-check-circle mr-4"></span>Battles
                                                                </a> -->
                                                                <a
                                                                href="#"
                                                                data-incident="{{ $incident }}"
                                                                id="btn_edit_in"
                                                                class="dropdown-item mb-1" 
                                                                data-backdrop="static"
                                                                data-keyboard="false" 
                                                                data-toggle="modal" 
                                                                data-target="#modaledit_incident"><span class="fe fe-edit-2 mr-4"></span> Editer
                                                                </a>
                                                                @if($incident->status != "ANNULÉ")
                                                                <a 
                                                                    id="motas"
                                                                    data-incident="{{ $incident }}"
                                                                    class="dropdown-item mb-1" 
                                                                    href="#"
                                                                    data-backdrop="static"
                                                                    data-keyboard="false" 
                                                                    data-toggle="modal" 
                                                                    data-target="#motif_danul"><span class="fe fe-trash mr-4"></span> Annuler</a>
                                                                @else
                                                                <a 
                                                                    data-incident="{{ $incident }}"
                                                                    id="motiannulitions"
                                                                    class="dropdown-item mb-1" 
                                                                    href="#"
                                                                    data-backdrop="static"
                                                                    data-keyboard="false" 
                                                                    data-toggle="modal" 
                                                                    data-target="#modal_info_motifs"><span class="fe fe-pocket mr-4"></span>Motif D'annulation</a>
                                                                @endif
                                                                <a
                                                                    id="infos_incident"
                                                                    data-departements="{{ $departements }}"
                                                                    data-users="{{ $users }}"
                                                                    data-users_incidents="{{ $users_incidents }}"
                                                                    data-number="{{ $incident }}"
                                                                    data-task="{{ $tasks }}"
                                                                    class="dropdown-item mb-1" 
                                                                    href="#"
                                                                    data-backdrop="static"
                                                                    data-keyboard="false" 
                                                                    data-toggle="modal" 
                                                                    data-target="#modal_infos_incidant">
                                                                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                                                                </a>
                                                                <a
                                                                    class="dropdown-item mb-1"
                                                                    href="{{ route('viewUser', ['number' => $incident->number]) }}">
                                                                    <span class="fe fe-eye"></span>
                                                                    <span class="fe fe-eye mr-2"></span>
                                                                     Voir Technicien(s) Incident
                                                                </a>
                                                                <a 
                                                                    id="assign_other_user" 
                                                                    data-incident="{{ $incident }}"
                                                                    class="dropdown-item mb-1" 
                                                                    href="#"
                                                                    data-backdrop="static"
                                                                    data-keyboard="false" 
                                                                    data-toggle="modal" 
                                                                    data-target="#assign_incident"><span class="fe fe-corner-down-right"></span><span class="fe fe-user mr-2"></span> Assigner Un Utilisateur
                                                                </a>
                                                                <a 
                                                                    id="delete_incids" 
                                                                    data-incident="{{ $incident }}" 
                                                                    class="dropdown-item mb-1" 
                                                                    href="#"><span class="fe fe-x mr-4"></span> Supprimer</a>
                                                                <a class="dropdown-item" href="{{ route('listedTask', ['number' => $incident->number]) }}"><span class="fe fe-list mr-4"></span> Liste Des Tâches</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
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

    <!-- Modal SET Date D'échéance D'un Incident -->
    <div id="define_dat_echean" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-clock mr-3" style="font-size:20px;"></i>
                                        Échéance D'un Incident</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="date_echeance">
                                        <span class="fe fe-calendar fe-16 mr-1"></span>
                                            Date D'échéance</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="date_due" aria-describedby="button-addon2">
                                            <div class="input-group-append">
                                                <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16 mx-2"></span></div>
                                            </div>
                                        </div>
                                        <div class="row col-md-12 mt-4">
                                            <button data-incident="" id="echeance_btn_inc" class="btn btn-sm btn-outline-success btn-block ml-3">
                                                <span class="fe fe-clock fe-16 mr-3"></span>
                                                Définir
                                            </button>
                                        </div>
                                    </div>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->


    <!-- Modal error validation-->
    <div class="modal" id="Falco" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation" disabled style="width:100%; height:15em;border-style:none; resize: none;color:white; background-color: #495057; font-size:19px;" class="form-control"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_btn" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal error validation-->
    <div class="modal" id="FalcoTas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validtion_task" disabled style="width:100%; height:12em;border-style:none; resize: none;color:white; background-color: #495057; font-size:19px;" class="form-control"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_btn_tasq" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal error validation-->
    <div class="modal" id="editIncidentError" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validtion_edii" disabled style="width:100%; height:12em;border-style:none; resize: none;color:white; background-color: #495057; font-size:19px;" class="form-control"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_btn_edii" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal -->
    <div style="font-family: Century Gothic; font-size:15px;" class="modal" id="modal_incident" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="verticalModalTitle">
                                    <i class="fe fe-plus" style="font-size:15px;"></i>
                                    <i class="fe fe-bell mr-3" style="font-size:20px;"></i>
                                    Déclaration D'un Incident
                              </h5>
                              <button id="btnExitModalIncident" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                    <div class="card col-md-6">
                                        <div class="card-header">
                                            <strong style="font-size:20px;" class="card-title">Incident</strong>
                                        </div>
                                        <div class="card-body">
                                          <form id="form_incident">
                                                @csrf
                                                @method('POST')
                                            <div class="form-group mb-3">
                                                <label for="description"> <span class="fe fe-edit-2 mr-1"></span> A Propos De L'incident (Décrivez Votre Problème !)</label>
                                                <textarea style="resize:none;" class="form-control" id="description" name="description" placeholder="Veuillez Entrer Une Description Précise."></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="cause"><span class="fe fe-edit-2 mr-1"></span> Cause Probable (Pas De Verbiage S'il-Vous-Plait !)</label>
                                                <textarea style="resize:none;" class="form-control" id="cause" name="cause" placeholder="Veuillez Entrer Une Cause Assez Exacte." rows="3"></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="cause"><span class="fe fe-edit-2 mr-1"></span> Périmètre (Jusqu'où S'étant L'incident ?)</label>
                                                <textarea style="resize:none;" rows="2" class="form-control" id="perimeter" name="perimeter" placeholder="Veuillez Entrer La Portée De L'incident." rows="3"></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="categorie"><span class="fe fe-box mr-1"></span>Catégorie De L'incident</label>
                                                <select class="form-control select2" id="categorie" name="categorie_id">
                                                    <optgroup label="Catégorise">
                                                    <option value=""></option>
                                                    @foreach($categories as $categorie)
                                                    <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                                                    @endforeach
                                                    </optgroup>
                                                </select>
                                            </div> <!-- form-group -->
                                            <div class="form-group mb-3">
                                                <label for="battles"><span class="fe fe-box mr-1"></span>Quelles Actions Avez-vous Méneés ?</label>
                                                <textarea style="resize:none;" class="form-control" id="battles" name="battles" placeholder="Veuillez Spécifiez Les Actions Méneés." rows="3"></textarea>
                                            </div> <!-- form-group -->
                                            <div class="form-group">
                                                <label for="process"><span class="fe fe-activity mr-1"></span>Procéssus Impacté</label>
                                                <select class="form-control select2-multi" id="process_incdent" name="processus_id">
                                                    <optgroup label="Procéssus">
                                                    <option value=""></option>
                                                    @foreach($processus as $process)
                                                    <option value="{{ $process->id }}">{{ $process->name }}</option>
                                                    @endforeach
                                                    </optgroup>
                                                </select>
                                            </div> <!-- form-group -->
                                            <div class="form-group">
                                                <label for="priority">Priorité</label>
                                                <select class="form-control" id="priority" name="priority">
                                                    <option selected value="">Choisissez Une Priorité...</option>
                                                    <option value="FAIBLE">FAIBLE</option>
                                                    <option value="MOYENNE">MOYENNE</option>
                                                    <option value="ÉLEVÉE">ÉLÉVÉE</option>
                                                    <option value="URGENT">URGENT</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                    <label for="date_echeance_incident">
                                                    <span class="fe fe-calendar fe-16 mr-1"></span> 
                                                    Date D'échéance De L'incident</label>
                                                    <div class="input-group">
                                                        <input type="date" class="form-control" name="due_date" id="date_echeance_incident" aria-describedby="button-addon2">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16 mx-2"></span></div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="form-row">
                                                    <div class="text-left">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" name="radi" class="custom-control-input" id="c1">
                                                            <label class="custom-control-label" for="c1">Tâche</label>
                                                        </div>
                                                    </div>
                                                    <div class="ml-auto w-40">
                                                        <button type="button" id="btn_clear_fields_incident" class="btn btn-sm btn-danger"><span class="fe fe-trash fe-16 mr-1"></span> Effacer Le Texte Des Champs</button>
                                                    </div>
                                            </div>
                                          </form>
                                        </div>
                                    </div>

                                    <!-- <div class="card col-md-6 shadow" style="margin-left:37.3em; margin-top:-50.8em;">
                                            <div class="card-header" style="margin-bottom: 2.9em;">
                                                <div class="row">
                                                    <strong style="font-size:20px;" class="card-title">

                                                    </strong>
                                                    <div class="ml-auto w-50">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                    </div> -->

                                    <div class="card col-md-6" style="margin-left:37.3em; margin-top:-61.6em;">
                                        <div id="dismiss_task">
                                            <div class="card-header" style="margin-bottom: 1em;">
                                                <div class="row">
                                                    <strong style="font-size:20px;" class="card-title">
                                                        <span class="text mr-2">Tâches</span>
                                                        <span class="badge badge-pill badge-primary"><i id="number_task">0</i></span>
                                                    </strong>
                                                    <div class="ml-auto w-50">
                                                        <strong id="btn_display"></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <!-- <p style="margin-bottom:2em;">
                                                    <i class="fe fe-info fe-28 mr-1"></i> 
                                                    Vous Pouvez Ajouter Plusieurs Tâches Pour Un Meme Incident !
                                                </p> -->
                                                <form id="form_tache">
                                                        @csrf
                                                        @method('POST')
                                                    <div class="form-group mb-4">
                                                        <label for="desc"><span class="fe fe-edit mr-1"></span> Description (Décrivez De Facon Brève L'objectif De Votre Tâche !)</label>
                                                        <textarea style="resize:none;" class="form-control" id="desc" placeholder="Veuillez Entrer Une Cause Assez Exacte." rows="10"></textarea>
                                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="date_echeance">
                                                        <span class="fe fe-calendar fe-16 mr-1"></span>    
                                                        Date D'échéance De La Tâche</label>
                                                        <div class="input-group">
                                                        <input type="date" class="form-control" id="date_echeance" aria-describedby="button-addon2">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16 mx-2"></span></div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="user_task"><span class="fe fe-user-plus mr-2"></span>Assigner Un Département A La Tâche</label>
                                                        <select class="form-control select2" id="departement_task">
                                                            <optgroup label="Départements">
                                                            <option value=""></option>
                                                            @foreach($departements as $departement)
                                                            <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                                                            @endforeach
                                                            </optgroup>
                                                        </select>
                                                    </div> <!-- form-group -->
                                                    <div class="form-row" style="margin-top: 19.7em;">
                                                        <div class="text-left mr-4">
                                                            <button type="button" id="btn_add_task" class="btn btn-sm btn-info"><span class="fe fe-plus fe-16 mr-1"></span> Ajouter Tâche</button>
                                                        </div>
                                                        <div class="text-left">
                                                            <button type="button" id="btn_reset_task" class="btn btn-sm btn-danger"><span class="fe fe-trash-2 fe-16 mr-1"></span> Supprimer Les Tâches</button>
                                                        </div>
                                                        <div class="ml-auto w-40">
                                                            <button type="button" id="btn_clear_fields" class="btn btn-sm btn-light"><span class="fe fe-trash fe-16 mr-1"></span> Effacer Le Texte</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div id="espoir" style="margin-bottom: 22.2em; margin-top: 15em; margin-left: 2.5em;">
                                            <span style="font-size: 5em;" class="fe fe-plus"></span>
                                            <span style="font-size: 24em;" class="fe fe-bell"></span>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                              <button data-processus="{{ $processus }}" name="buttonAddingIncidants" type="button" class="btn mb-2 btn-primary"><span class="fe fe-save fe-16 mr-2"></span>Enregister Incident</button>
                            </div>
                          </div>
                        </div>
    </div>


    <!-- Modal Edit Incident -->
    <div style="font-family: Century Gothic; font-size:15px;" class="modal" id="modaledit_incident" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                    <i class="fe fe-edit-2" style="font-size:15px;"></i>
                                    <i class="fe fe-bell mr-3" style="font-size:20px;"></i>
                                    Modification D'un Incident
                                    <span id="nimero" class="ml-4"></span>
                                </h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                    <div class="card">
                                        <div class="card-body">
                                          <form id="formEditIncident">
                                                @csrf
                                                @method('POST')
                                            <input type="hidden" id="incid" name="number">
                                            <div class="form-group mb-3">
                                                <label for="description"> <span class="fe fe-edit-2 mr-1"></span> A Propos De L'incident (Décrivez Votre Problème !)</label>
                                                <textarea style="resize:none;" class="form-control" id="description_edit" name="description" placeholder="Veuillez Entrer Une Description Précise." required></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="cause"><span class="fe fe-edit-2 mr-1"></span> Cause Probable (Pas De Verbiage S'il-Vous-Plait !)</label>
                                                <textarea style="resize:none;" class="form-control" id="cause_edit" name="cause" placeholder="Veuillez Entrer Une Cause Assez Exacte." required rows="3"></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="cause"><span class="fe fe-edit-2 mr-1"></span> Périmètre (Jusqu'où S'étant L'incident ?)</label>
                                                <textarea style="resize:none;" rows="2" class="form-control" id="perimeter_edit" name="perimeter" placeholder="Veuillez Entrer La Portée De L'incident." required rows="3"></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="categorie"><span class="fe fe-box mr-1"></span>Catégorie De L'incident</label>
                                                <select class="form-control" id="categorie_edit" name="categorie_id">
                                                    @foreach($categories as $categorie)
                                                    <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                                                    @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="battles"><span class="fe fe-box mr-1"></span>Quelles Actions Avez-vous Méneés ?</label>
                                                <textarea style="resize:none;" class="form-control" id="battles_edit" name="battles" placeholder="Veuillez Spécifiez Les Actions Méneés." rows="3"></textarea>
                                            </div> <!-- form-group -->
                                            <div class="form-group">
                                                <label for="process_edit"><span class="fe fe-activity mr-1"></span>Procéssus Impacté</label>
                                                <select data-processus="{{ $processus }}" class="form-control" id="process_edit" name="processus_id">
                                                    <option value=""></option>
                                                    @foreach($processus as $process)
                                                    <option value="{{ $process->id }}">{{ $process->name }}</option>
                                                    @endforeach
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="priority">Priorité</label>
                                                <select class="form-control" id="prioritys" name="priority">
                                                    <option value="FAIBLE">FAIBLE</option>
                                                    <option value="MOYENNE">MOYENNE</option>
                                                    <option value="ÉLEVÉE">ÉLÉVÉE</option>
                                                    <option value="URGENT">URGENT</option>
                                                </select>
                                            </div>
                                            <div>
                                                    <label for="date_echeance_edit">
                                                    <span class="fe fe-calendar fe-16 mr-1"></span>    
                                                    Date D'échéance De L'incident</label>
                                                    <div class="input-group">
                                                        <input type="date" class="form-control" name="due_date" id="date_echeance_edit" aria-describedby="button-addon2">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16 mx-2"></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                          </form>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                              <button id="btn_edit_incident" type="button" class="btn mb-2 btn-primary"><span class="fe fe-edit-3 fe-16 mr-2"></span>Modifier Incident</button>
                            </div>
                          </div>
                        </div>
    </div>


    <!-- Modal Task -->
    <div style="font-family: Century Gothic; font-size:15px;" class="modal" id="modal_task" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="verticalModalTitle">
                                    <i class="fe fe-plus" style="font-size:15px;"></i>
                                    <i class="fe fe-anchor mr-3" style="font-size:20px;"></i>
                                Attribution D'une Tâche</h5>
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
                                                <form id="frmtach">
                                                        @csrf
                                                        @method('POST')
                                                    <input type="hidden" id="hids" name="number">
                                                    <div class="form-group mb-3">
                                                        <label for="task"> <span class="fe fe-edit mr-1"></span> A Propos De La Tâche</label>
                                                        <textarea style="resize:none;" class="form-control" id="task_unique" name="title" placeholder="Veuillez Entrer Un Intitulé Précis."></textarea>
                                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="desc"><span class="fe fe-edit mr-1"></span> Description (Décrivez De Facon Brève L'objectif De Votre Tâche !)</label>
                                                        <textarea style="resize:none;" class="form-control" id="desc_unique" name="description" placeholder="Veuillez Entrer Une Cause Assez Exacte." rows="3"></textarea>
                                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="date_echeance">
                                                        <span class="fe fe-calendar fe-16 mr-1"></span>    
                                                        Date D'échéance De La Tâche</label>
                                                        <div class="input-group">
                                                        <input type="date" class="form-control" id="date_echeance_unique" name="maturity_date" aria-describedby="button-addon2">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16 mx-2"></span></div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="user_task"><span class="fe fe-user-plus mr-2"></span>Assigner Un Utilisateur A La Tâche</label>
                                                        <select class="form-control select2" name="user_solving_id" id="user_task_unique">
                                                            <optgroup label="User Assigned">
                                                            <option value=""></option>
                                                            @foreach($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                                            @endforeach
                                                            </optgroup>
                                                        </select>
                                                    </div> <!-- form-group -->
                                                    <div class="form-row">
                                                        <div class="text-left mr-4">
                                                            
                                                        </div>
                                                        <div class="ml-auto w-40">
                                                            <button type="button" id="btn_clear_fields" class="btn btn-sm btn-light"><span class="fe fe-trash fe-16 mr-1"></span> Effacer Le Texte</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btn_add_unique_task" class="btn btn-sm btn-info"><span class="fe fe-save fe-16 mr-1"></span> Attribuer La Tâche</button>
                            </div>
                          </div>
                        </div>
    </div>


    <!-- Modal Confirmation Save Incident -->
    <div style="font-family:Century Gothic;" class="modal" id="modalConfirmationSaveIncident" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                    <i class="fas fa-check fa-lg mr-3"></i>    
                                    Confirmez-Vous Ces Informations ?</h5>
                                </div>
                                <div style="background-color: #495057; color:white; height: 40em;" class="modal-body">
                                        <div class="card col-md-6">
                                                <div class="card-header">
                                                    <strong style="font-size:20px;" class="card-title">Incident</strong>
                                                </div>  
                                                <table class="table table-bordered mb-2">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Description</span>
                                                            </td>
                                                            <td>
                                                                <textarea style="color:white;" disabled name="" id="description_conf" cols="30" rows="3"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Cause</span>
                                                                </td>
                                                                <td>
                                                                <textarea style="color:white;" disabled name="" id="cause_conf" cols="30" rows="3"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Périmètre</span>
                                                                </td>
                                                                <td>
                                                                <span style="color: white; font-size: 20px;" id="perimeter_conf"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Actions Méneés</span>
                                                                </td>
                                                                <td>
                                                                <span style="color: white; font-size: 20px;" id="menees_actions_conf"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Catégorie De L'incident</span>
                                                                </td>
                                                                <td>
                                                                <span style="color: white; font-size: 20px;" id="categorie_conf"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Processus Impacté</span>
                                                                </td>
                                                                <td>
                                                                <textarea style="color:white;" disabled name="" id="process_conf" cols="30" rows="3"></textarea>
                                                            </td>
                                                        </tr>
                                                    <tbody>
                                                </table>
                                        </div>
                                        <div style="margin-left:40em; margin-top:-31em;" class="card col-md-6">
                                            <div class="card-header">
                                                <strong style="font-size:20px;" class="card-title">Tâches</strong>
                                            </div>
                                            <table class="table table-bordered mb-2">
                                                <tbody id="tbodys">
                                                    <thead>
                                                        <tr><td>Tâches</td><td>Descriptif</td></tr>
                                                    </thead>
                                                </tbody>
                                            </table>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="conf_save_incident" class="btn btn-primary">OUI</button>
                                    <button type="button" id="non_confirmation" class="btn btn-secondary" data-dismiss="modal">NON</button>
                                </div>
                            </div>
                        </div>
    </div> 

    <!-- Modal Confirmation Save Task -->
    <div class="modal" id="modalConfirmationSaveTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                    <i class="fas fa-check fa-lg mr-3"></i>
                                    Confirmez-Vous Ces Informations ?</h5>
                                </div>
                                <div style="background-color: #474E55; color:white;" class="modal-body">
                                        <div class="card">
                                                <div class="card-header">
                                                    <strong style="font-size:20px;" class="card-title">Tâche</strong>
                                                </div>  
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                A Propos De La Tâche</span>
                                                            </td>
                                                            <td>
                                                                <textarea style="color:white;" disabled name="" id="apropos_conf" cols="30" rows="4"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Description De La Tâche</span>
                                                                </td>
                                                                <td>
                                                                <textarea style="color:white;" disabled name="" id="decrit_conf" cols="30" rows="3"></textarea>
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
                                    <button type="button"class="btn btn-secondary" data-dismiss="modal">NON</button>
                                </div>
                            </div>
                        </div>
    </div> 


    <!-- Modal Cloture Incident -->
    <div id="clos" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-lock mr-3" style="font-size:20px;"></i>
                                        Clôture D'un Incident</h5>
                                <button id="btnExitModalCloture" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="row my-4">
                                        <div class="col-md-6 text-left">
                                            Numéro
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <strong id="nibiru"></strong>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <!-- <label for="date_echeance">
                                        <span class="fe fe-calendar fe-16 mr-1"></span>
                                        Date De Clôture De L'incident</label>
                                        <div class="input-group mb-3">
                                            <input type="date" class="form-control" id="date_Klot" aria-describedby="button-addon2">
                                            <div class="input-group-append">
                                                <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16 mx-2"></span></div>
                                            </div>
                                        </div> -->
                                        <div class="form-group mb-3">
                                            <label for="valeure"> <span class="fe fe-edit mr-2"></span>Valeur</label>
                                            <input type="number" min="0" class="form-control" id="valeure" name="valeure">
                                            <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                        </div>
                                        <div class="form-group mb-3">
                                                <label for="dotnet">
                                                    <span class="fe fe-battery-charging mr-2"></span>
                                                    Statut
                                                </label>
                                                <select class="custom-select" id="dotnet">
                                                    <option selected value="">Choisissez Un Statut...</option>
                                                    <option value="CLÔTURÉ">CLÔTURÉ</option>
                                                    <option value="ENCOUR">ENCOUR</option>
                                                    <option value="DÉCLARÉ">DÉCLARÉ</option>
                                                    <option value="ANNULÉ">ANNULÉ</option>
                                                </select>
                                        </div>
                                        <div class="form-group mb-3">
                                                <label for="task"> <span class="fe fe-edit mr-2"></span>Commentaire</label>
                                                <textarea style="resize:none;" rows="4" class="form-control" id="cloture_comment" name="comment" placeholder="Veuillez Entrer Un Commentaire."></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                        </div>
                                        <div class="row col-md-12 mt-4">
                                            <button data-incident="" data-tasks="{{ $tasks }}" id="Kloture" class="btn btn-sm btn-outline-success btn-block ml-3">
                                                <span class="fe fe-lock fe-16 mr-3"></span>
                                                Clôturé
                                            </button>
                                        </div>
                                    </div>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->


    <!-- Modal Battles Incident -->
    <div id="battles" style="font-family: Century Gothic;" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-check-circle mr-3" style="font-size:20px;"></i>
                                    Travaux Réalisés <span class="ml-4" id="batt_inc"></span>
                                </h5>
                                <button id="bat_boy" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="frm_bat" autocomplete="off">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="id_incidan" id="num_In">
                                    <div class="row mb-4">
                                        <div class="card shadow col-xs-12 ml-5 mr-5">
                                            <div class="card-header">
                                                    <strong>
                                                        Travail 1
                                                    </strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group mb-3">
                                                    <label for="simpleinput" style="font-size: 15px;">Catégorie Du Travail (Ex: Plomberie | Elèctricité | Maconnerie)</label>
                                                    <input style="font-size:17px; font-family: Century Gothic;" type="text" id="cat1" name="title" class="form-control">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="description" style="font-size: 15px;"> <span class="fe fe-edit-2 mr-1"></span> A Propos Du Travail (Décrivez Le Travail Effectué !)</label>
                                                    <textarea style="resize:none; font-size:17px; font-family: Century Gothic;" rows="5" class="form-control" id="description1" name="description" placeholder="Veuillez Entrer Une Description Précise."></textarea>
                                                    <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card shadow col-xs-12">
                                            <div class="card-header">
                                                    <strong>
                                                        Travail 2
                                                    </strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group mb-3">
                                                    <label for="simpleinput" style="font-size: 15px;">Catégorie Du Travail (Ex: Plomberie | Elèctricité | Maconnerie)</label>
                                                    <input style="font-size:17px; font-family: Century Gothic;" type="text" id="cat2" name="title2" class="form-control">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="description" style="font-size: 15px;"> <span class="fe fe-edit-2 mr-1"></span> A Propos Du Travail (Décrivez Le Travail Effectué !)</label>
                                                    <textarea style="resize:none; font-size:17px; font-family: Century Gothic;" rows="5" class="form-control" id="description2" name="description2" placeholder="Veuillez Entrer Une Description Précise."></textarea>
                                                    <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ml-4">
                                        <div class="col-md-3">
                                            <button id="btnSaveBattle" type="button" class="btn btn-sm btn-outline-primary btn-block">
                                                <span class="fe fe-check-circle fe-16 mr-3 text-white"></span>
                                                <span style="font-size: 20px; color:white;">Valider</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->


    <!-- Modal Changement De Statut D'un Incident -->
    <div id="change_status_incident" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-battery-charging mr-3" style="font-size:20px;"></i>
                                    Satut D'un Incident</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="row mb-4" style="text-align:center">
                                        <div class=" col-md-3 text-left"><span>Incident</span> </div>
                                        <div class=" col-md-9 text-right"><span id="numi"></span></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="statut_e">
                                        <span class="fe fe-battery-charging fe-16 mr-1"></span> 
                                        Séléctionner Un Statut</label>
                                        <div class="form-group">
                                            <select class="custom-select" id="stat_chs" required>
                                                <option selected value="">Choisissez...</option>
                                                <option value="EN-RÉSOLUTION">EN-RÉSOLUTION</option>
                                                <option value="RÉSOLU">RÉSOLU</option>
                                            </select>
                                        </div>
                                        <div class="row col-md-12 mt-4">
                                            <button data-incident="" data-taches="{{ $tasks }}" id="sta_edi_inci" class="btn btn-sm btn-outline-success btn-block ml-3">
                                                <span class="fe fe-battery-charging fe-16 mr-3"></span>
                                                Modifier Le Statut
                                            </button>
                                        </div>
                                    </div>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->


    <!-- Modal Changement De Priorité D'un Incident -->
    <div id="edit_priority_incident" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-alert-triangle mr-3" style="font-size:20px;"></i>
                                    Priorité D'un Incident</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="row mb-4" style="text-align:center">
                                        <div class=" col-md-3 text-left"><span>Incident</span> </div>
                                        <div class=" col-md-9 text-right"><span id="prior"></span></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="statut_e">
                                        Séléctionner Une Priorité</label>
                                        <div class="form-group">
                                            <select class="custom-select" id="priority_it" required>
                                                <option selected value="">Choisissez...</option>
                                                <option value="FAIBLE">FAIBLE</option>
                                                <option value="MOYENNE">MOYENNE</option>
                                                <option value="ÉLEVÉE">ÉLEVÉE</option>
                                                <option value="URGENT">URGENT</option>
                                            </select>
                                        </div>
                                        <div class="row col-md-12 mt-4">
                                            <button id="modif_s_i" data-incident="" class="btn btn-sm btn-outline-success btn-block ml-3">
                                                <span class="fe fe-alert-triangle fe-16 mr-3"></span>
                                                Modifier La Priorité
                                            </button>
                                        </div>
                                    </div>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->


    <!-- Modal Motif D'annulation D'un Incident -->
    <div id="motif_danul" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-trash mr-3" style="font-size:20px;"></i>
                                    Annulation D'un Incident</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="row mb-4" style="text-align:center">
                                        <div class=" col-md-3 text-left"><span>Incident</span> </div>
                                        <div class=" col-md-9 text-right"><span id="moties"></span></div>
                                    </div>
                                    <div class="mb-3">
                                            <div class="form-group mb-3">
                                                <label for="mottifs"> <span class="fe fe-edit-2 mr-1"></span> Motif D'annulation De Cet Incident !</label>
                                                <textarea style="resize:none;" rows="4" class="form-control" id="mottifs" name="mottifs" placeholder="Veuillez Entrer Une Description Du Motif De L'annulation."></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div class="row col-md-12 mt-4">
                                                <button data-incident="" id="anule" class="btn btn-sm btn-outline-success btn-block ml-3">
                                                    <span class="fe fe-trash fe-16 mr-2"></span>
                                                    Annuler L'incident
                                                </button>
                                            </div>
                                    </div>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->


    <!-- Modal Infos Motif D'annulation D'un Incident -->
    <div id="modal_info_motifs" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-pocket mr-3" style="font-size:20px;"></i>
                                    Motif D'annulation De L'Incident</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="row mb-4" style="text-align:center">
                                        <div class=" col-md-3 text-left"><span>Incident</span> </div>
                                        <div class=" col-md-9 text-right"><span id="prioro"></span></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="tiffmo"> <span class="fe fe-info mr-1"></span> Motif D'annulation De Cet Incident !</label>
                                        <textarea style="resize:none;" disabled rows="4" class="form-control" id="tiffmo"></textarea>
                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                    </div>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->


    <!-- Modal Assignation D'un Incident -->
    <div id="assign_incident" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-corner-down-right" style="font-size:22px;"></i>
                                        <i class="fe fe-user mr-3" style="font-size:20px;"></i>
                                    Assignation D'un Utilisateur A Un Incident</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="row mb-4" style="text-align:center">
                                        <div class=" col-md-4 text-left"><span>Incident</span> </div>
                                        <div class=" col-md-8 text-right"><span id="asign_te"></span></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="users_s">
                                        <span class="fe fe-user-plus fe-16 mr-1"></span> 
                                        Séléctionner Un Utilisateur</label>
                                        <div class="form-group">
                                            <select class="custom-select" id="users_s" required>
                                                <option selected value="">Choisissez...</option>
                                                @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row col-md-12 mt-4">
                                            <button data-incident="" id="save_assign" class="btn btn-sm btn-outline-success btn-block ml-3">
                                                <span class="fe fe-user fe-16"></span>
                                                <span class="fe fe-save fe-16 mr-3"></span>
                                                Assigner L'utilisateur A L'incident
                                            </button>
                                        </div>
                                    </div>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->


    <!-- MODAL INFO INCIDENT -->
    <div id="modal_infos_incidant" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
                                                <strong class="card-title"><span id="inf_number"></span></strong>
                                                <a class="float-right small text-muted" href="#!">Voir Tous</a>
                                            </div>
                                            <div class="card-body">
                                            <div class="list-group list-group-flush my-n3">
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <span class="fe fe-box fe-24"></span>
                                                        </div>
                                                        <div class="col">
                                                            <small><strong></strong></small>
                                                            <div class="my-0 text-muted big"><span class="desc"></span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <small class="badge badge-pill badge-light text-uppercase text-white">Description</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <span class="fe fe-edit-2 fe-24"></span>
                                                        </div>
                                                        <div class="col">
                                                            <small><strong></strong></small>
                                                            <div class="my-0 text-muted big"><span class="cose"></span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <small class="badge badge-pill badge-light text-uppercase text-white">Cause</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                        <span class="fe fe-map-pin fe-24"></span>
                                                        </div>
                                                        <div class="col">
                                                        <small><strong></strong></small>
                                                        <div class="my-0 text-muted big"><span class="perim"></span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                        <small class="badge badge-pill badge-light text-uppercase text-white">Périmètre</small>
                                                        </div>
                                                    </div> <!-- / .row -->
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <span class="fe fe-anchor fe-24"></span>
                                                        </div>
                                                        <div class="col">
                                                            <small><strong></strong></small>
                                                            <div class="my-0 text-muted big"><span class="tac"></span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <small class="badge badge-pill badge-light text-uppercase text-white">Tâches</small>
                                                        </div>
                                                    </div>
                                                </div> <!-- / .row -->
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <span class="fe fe-home fe-24"></span>
                                                        </div>
                                                        <div class="col">
                                                            <small><strong></strong></small>
                                                            <div class="my-0 text-muted big"><span class="deeps"></span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <small class="badge badge-pill badge-light text-uppercase text-white">Département Emétteur</small>
                                                        </div>
                                                    </div>
                                                </div> <!-- / .row -->
                                            </div> <!-- / .list-group -->
                                        </div> <!-- / .card-body -->
                            </div> <!-- / .card -->
                        </div>
                    </div>
    </div> <!-- small modal -->


    <script src="{{ url('incidents.js') }}"></script>

@endsection
