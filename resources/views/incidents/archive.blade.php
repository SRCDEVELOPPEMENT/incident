@extends('layouts.main')


@section('content')

    <div class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-md-6 text-left text-xl text-uppercase">
                                    <h1 class="mb-2">
                                    <span class="fe fe-info mr-2"></span>    
                                    Liste Incidents Clôturé(s) | ANNULÉ(S)</h1>
                                </div>
                                <div class="col-md-6 text-right">
                                </div>
                            </div>
                        </div>
                        <!-- <p class="card-text">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, built upon the foundations of progressive enhancement, that adds all of these advanced features to any HTML table. </p> -->
                        <div class="row my-4">
                            <!-- Small table -->
                            <div class="col-md-12">
                                <div class="card shadow">
                                    <div class="card-body">  
                                        <div class="row ml-1 mt-4 my-4">
                                            <div class="col-xs-2 mr-4">
                                                <select class="custom-select border-primary" id="emis_recus">
                                                        <option value="">Incident</option>
                                                        <option value="Emis">Emis</option>
                                                        <option value="Reçus">Reçus</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-2">
                                                <select class="custom-select border-primary" id="year_courant_incident">
                                                        <option selected value="">Année</option>
                                                        @if(is_iterable($years))
                                                        @foreach($years as $year)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                        @endif
                                                </select>
                                                <div class="invalid-feedback"> Please select a valid state. </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                    <input type="date" class="form-control border-primary" id="searchDate">
                                                </div>
                                            </div>

                                            <div class="text-right col-md-2">
                                                <input type="text" name="" id="search_text_simple" class="form-control border-primary" placeholder="Search...">
                                            </div>
                                        </div>
                                        <!-- table -->
                                        <table class="table table-hover datatables" id="dataTable-1">
                                            <thead class="bg-dark text-white">
                                                <tr>
                                                    <th>Numéro</th>
                                                    <th></th>
                                                    <th>Description Incident</th>
                                                    <th>Date Déclaration</th>
                                                    <th>Date Echéance</th>
                                                    <th>Date Clôture</th>
                                                    <th>Priorité</th>
                                                    <th></th>
                                                    <th>Tâches</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="agencies">
                                                @if(is_iterable($incidents))
                                                @foreach($incidents as $key => $incident)
                                                    <?php
                                                        $nombre_taches = 0;
                                                        $created = strval(substr($incident->created_at, 0, 10));
                                                        if(is_iterable($taches)){
                                                        for ($i=0; $i < count($taches); $i++) {
                                                            $task = $taches[$i];
                                                            if($task->incident_number == $incident->number){
                                                                $nombre_taches +=1;
                                                            }
                                                        }}
                                                    ?>
                                                    <!-- <span class="dot dot-lg bg-primary ml-2"></span> -->
                                                    <tr id="myInc" data-incident="{{ json_encode($incident) }}">
                                                        <td>{{ $incident->number }}</td>
                                                        <td>

                                                        </td>
                                                        <td>{{ $incident->description }}</td>
                                                        <td id="createcolumn">{{ $incident->declaration_date }}</td>
                                                        <td>
                                                            @if($incident->due_date)
                                                            <a  
                                                                style="text-decoration:none;"
                                                                href="#!"
                                                            >
                                                            {{ $incident->due_date }}
                                                            </a>
                                                            @else
                                                            <a  
                                                                style="text-decoration:none;"
                                                                href="#!"
                                                            >
                                                            DÉFINISSEZ LA DATE D'ÉCHÉANCE
                                                            </a>
                                                            @endif
                                                        </td>
                                                        <td>{{ $incident->closure_date ? $incident->closure_date : '' }}</td>
                                                        <td>
                                                            <a 
                                                                @if($incident->priority == 'URGENT')
                                                                    style="color:red; text-decoration:none;"
                                                                @elseif($incident->priority == 'ÉLEVÉE')
                                                                    style="color:yellow; text-decoration:none;"
                                                                @else
                                                                    style="color:green; text-decoration:none;"
                                                                @endif
                                                                href="#!">
                                                                {{ $incident->priority }}
                                                            </a>
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                            <a 
                                                                style="text-decoration:none;" 
                                                                href="#!" 
                                                                title="Liste Des Tâches De L'incident">
                                                                <small class="text-lg mr-1">{{ $nombre_taches < 10 ? 0 .''. $nombre_taches : $nombre_taches}}</small>
                                                                <span class="fe fe-list"></span>
                                                                <span class="fe fe-check"></span>
                                                            </a>
                                                        </td>
                                                        <td>
                                                                <a 
                                                                    style="text-decoration:none;" 
                                                                    type="button" 
                                                                    href="{{ route('printIncident', ['number' => $incident['number']]) }}"
                                                                    data-toggle="modal"
                                                                    data-original-title="Imprimer Cet Incident"
                                                                    class="fe fe-printer fe-32">
                                                                </a>
                                                        </td>

                                                        <td></td>
                                                        <td>
                                                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="text-muted sr-only">Action</span>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">

                                                                @if($incident->status != "ANNULÉ" && $incident->status != "CLÔTURÉ")
                                                                <a 
                                                                    id="motas"
                                                                    data-incident="{{ json_encode($incident) }}"
                                                                    class="dropdown-item mb-1" 
                                                                    href="#"
                                                                    data-backdrop="static"
                                                                    data-keyboard="false" 
                                                                    data-toggle="modal" 
                                                                    data-target="#motif_danul"><span class="fe fe-trash mr-4"></span> Annuler
                                                                </a>
                                                                @elseif($incident->status == "ANNULÉ")
                                                                <a 
                                                                    data-incident="{{ json_encode($incident) }}"
                                                                    id="motiannulitions"
                                                                    class="dropdown-item mb-1"
                                                                    href="#!"
                                                                    data-backdrop="static"
                                                                    data-keyboard="false"
                                                                    data-toggle="modal"
                                                                    data-target="#modal_info_motifs"><span class="fe fe-pocket mr-4"></span>Motif D'annulation</a>
                                                                @else
                                                                @endif

                                                                @if($incident->archiver == TRUE)
                                                                <a 
                                                                    href="#!"
                                                                    id="desarchive_incident"
                                                                    data-incident="{{ json_encode($incident) }}"
                                                                    class="dropdown-item mb-1">
                                                                    <span class="fe fe-archive"></span>
                                                                    <span class="fe fe-arrow-right mr-1"></span>
                                                                    Désarchiver
                                                                </a>
                                                                @endif

                                                                @if($incident->status == "ANNULÉ")
                                                                <a 
                                                                    href="#!"
                                                                    id="restorer_incident"
                                                                    data-incident="{{ json_encode($incident) }}"
                                                                    class="dropdown-item mb-1">
                                                                    <span class="fe fe-rotate-cw mr-4"></span>
                                                                    Restorer
                                                                </a>
                                                                @endif

                                                                <a
                                                                    id="infos_incident"
                                                                    data-sites="{{ json_encode($sites) }}"
                                                                    data-users="{{ json_encode($users) }}"
                                                                    data-incident="{{ json_encode($incident) }}"
                                                                    data-task="{{ $nombre_taches }}"
                                                                    class="dropdown-item mb-1" 
                                                                    href="#!"
                                                                    data-backdrop="static"
                                                                    data-keyboard="false" 
                                                                    data-toggle="modal" 
                                                                    data-target="#modal_infos_incidant">
                                                                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                                                                </a>

                                                                @if($incident->status == "CLÔTURÉ")
                                                                <a 
                                                                    id="commentaire_cloture"
                                                                    data-backdrop="static"
                                                                    data-keyboard="false" 
                                                                    data-toggle="modal" 
                                                                    data-target="#modal_commentaire_cloture"
                                                                    data-incident="{{ json_encode($incident) }}" 
                                                                    class="dropdown-item mb-1" 
                                                                    href="#!"><span class="fe fe-message-square mr-4"></span> Commentaire De Clôture
                                                                </a>
                                                                @endif

                                                                <a 
                                                                    id="delete_incids" 
                                                                    data-incident="{{ json_encode($incident) }}" 
                                                                    class="dropdown-item mb-1" 
                                                                    href="#!"><span class="fe fe-x mr-4"></span> Supprimer
                                                                </a>
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

    <!-- Modal Desarchivage D'un Incident -->
    <div style="font-family: Century Gothic;" id="desarchivag" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="text-xl" id="verticalModalTitle">
                                            <i class="fe fe-archive mr-3" style="font-size:20px;"></i>
                                            DESARCHIVAGE
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card shadow">
                                                <div class="row text-lg my-4">
                                                    <div class="col-md-5 text-left ml-5">
                                                        Incident Numéro
                                                    </div>
                                                    <div class="col-md-5 text-right">
                                                        <strong id="taboo"></strong>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-group" style="text-align:center; font-size:20px;">
                                                        Voulez-vous Vraiment Désarchiver Cet Incident ?
                                                    </div>
                                                </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                        <button type="button" id="btn_save_desarching" class="btn btn-primary">OUI</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NON</button>
                                </div>
                            </div>
                        </div>
    </div> <!-- small modal -->

    <!-- Modal Restoration D'un Incident -->
    <div style="font-family: Century Gothic;" id="restauration" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="text-xl" id="verticalModalTitle">
                                            <i class="fe fe-rotate-cw mr-3" style="font-size:20px;"></i>
                                            RESTORATION
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card shadow">
                                                <div class="row text-lg my-4">
                                                    <div class="col-md-5 text-left ml-5">
                                                        Incident Numéro
                                                    </div>
                                                    <div class="col-md-5 text-right">
                                                        <strong id="id_numbers"></strong>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-group" style="text-align:center; font-size:20px;">
                                                        Voulez-vous Vraiment Restorer Cet Incident ?
                                                    </div>
                                                </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                        <button type="button" id="btn_restaurasion" class="btn btn-primary">OUI</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NON</button>
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

    <!-- Modal error annulation incident-->
    <div class="modal" id="annulationError" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur D'annulation</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validtion_annu" disabled style="width:100%; height:4em;border-style:none; resize: none;color:white; background-color: #495057; font-size:19px;" class="form-control"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_btn_annu" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal Infos Commentaire De Cloture D'un Incident -->
    <div id="modal_commentaire_cloture" style="font-family: Century Gothic;" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="text-xl" id="verticalModalTitle">
                                        <i class="fe fe-pocket mr-3" style="font-size:20px;"></i>
                                    Commentaire De Clôture De L'Incident</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-lg">
                                    <div class="row mb-4" style="text-align:center">
                                        <div class=" col-md-6 text-left"><strong>Numéro Incident</strong> </div>
                                        <div class=" col-md-6 text-right"><span id="comment_num_i"></span></div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="commix"> <span class="fe fe-info mr-1"></span> Commentaire De Clôture De Cet Incident !</label>
                                        <textarea style="resize:none;" disabled rows="6" class="form-control text-xl" id="commix"></textarea>
                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                    </div>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->

    <!-- MODAL INFO INCIDENT -->
    <div style="font-family: Century Gothic;" id="modal_infos_incidant" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-xl" id="verticalModalTitle">
                                        <i class="fe fe-info mr-3"></i>
                                    <span>Informations Incident</span>
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="col-md-12 mb-4 mt-4">
                                        <div class="card shadow">
                                            <div class="card-header">
                                                <div class="row text-xl">
                                                    <div class="text-left col-md-6">Incident Numéro</div>
                                                    <div class="text-right col-md-6">
                                                    <strong><span class="inf_numbers"></span></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                            <div class="list-group list-group-flush my-n3">
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <small><strong></strong></small>
                                                            <div class="my-0 big"><span class="declarateur"></span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <small class="badge badge-pill badge-light text-uppercase">Déclarateur De L'incident</small>
                                                        </div>
                                                    </div>
                                                </div> <!-- / .row -->

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
                                                    <div class="my-0 big"><span class="cloture_daaaate"></span></div>
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


    <script src="{{ url('archive.js') }}"></script>

@endsection
