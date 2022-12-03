@extends('layouts.main')


@section('content')

    <div class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                        <div class="card-header py-3">
                            <div class="row mb-4" style="font-family: Century Gothic;">
                                <a title="Retour A La Liste Des Incidents" href="{{ URL::to('incidents') }}" style="border-radius: 3em;" class="btn btn-outline-primary"><span class="fe fe-corner-up-left fe-16 mr-2"></span><span class="text">Retour</span></a>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-left text-xl text-uppercase">
                                    <h2 class="mb-2">
                                    <span class="fe fe-info mr-2"></span>    
                                    Liste Tâches</h2>
                                </div>
                                <div class="col-md-9 text-right">
                                    <button 
                                            id="toto"
                                            data-backdrop="static" 
                                            data-keyboard="false"
                                            title="Ajout D'une Tâche" 
                                            style="background-color: #345B86;" 
                                            class="btn btn-icon-split"
                                            data-toggle="modal" data-target="#modal_task">
                                        <span class="icon text-white-80">
                                            <i class="fe fe-plus" style="font-size:15px;"></i>
                                            <i class="fe fe-anchor mr-3" style="font-size:20px;"></i>
                                        </span>
                                        Ajout Tâche
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
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                                        <!-- <label for="validationCustom04">State</label> -->
                                                        <select class="custom-select" id="validationCustom04" required>
                                                            <option selected value="">Choisissez...</option>
                                                            <option value="EN-RÉALISATION">EN-RÉALISATION</option>
                                                            <option value="RÉALISÉ">RÉALISÉ</option>
                                                            <option value="ANNULÉ">ANNULÉ</option>
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
                                            <div class="col-md-6 text-right">
                                                <span style="font-size: 1.5em;" class="badge badge-primary">{{ $number_incident }}</span>
                                            </div>
                                        </div>
                                        <!-- table -->
                                        <table class="table table-borderless table-hover" id="dataTable-task">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th></th>
                                                    <th>N°</th>
                                                    <th>Description</th>
                                                    <th>Statut</th>
                                                    <th>Date D'échéance</th>
                                                    <th>Département Concerné</th>
                                                    <th>Dégré Réalisation</th>
                                                    <th>Fichier</th>
                                                    <th></th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <!-- <tfoot class="thead-dark">
                                                <tr>
                                                    <th></th>
                                                    <th>N°</th>
                                                    <th>Titre</th>
                                                    <th>Description</th>
                                                    <th>Statut</th>
                                                    <th>Date D'échéance</th>
                                                    <th>Gérant Tâche</th>
                                                    <th>Dégré Réalisation</th>
                                                    <th>Fichier</th>
                                                    <th>Fichier</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot> -->
                                            <tbody class="tachsx">
                                                @foreach($taches as $key => $task)
                                                    <tr>
                                                        <td>
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input">
                                                                <label class="custom-control-label"></label>
                                                            </div>
                                                        </td>
                                                        <td>{{ $key+1 }}</td>
                                                        <td><p class="mb-0 text-muted">{{ $task->description }}</p></td>
                                                        <td>    
                                                                @if($task->status == 'RÉALISÉ')
                                                                <a
                                                                    style="color: #3ABF71; text-decoration:none;"
                                                                   href="#"
                                                                   id="modif_stay_tach"
                                                                   data-key="{{ $key+1 }}"
                                                                   data-task="{{ $task }}"
                                                                   data-backdrop="static"
                                                                   data-keyboard="false" 
                                                                   data-toggle="modal"
                                                                   data-target="#change_status">
                                                                   {{ $task->status }}
                                                                </a>
                                                                @elseif($task->status == 'EN-RÉALISATION')
                                                                <a
                                                                   id="modif_stay_tach"
                                                                   data-key="{{ $key+1 }}"
                                                                   data-task="{{ $task }}"
                                                                   style="color: #EEA303; text-decoration:none;"
                                                                   {{ $task->status }} == 'EN-RÉALISATION' ? style="color: #EEA303; text-decoration:none;":{{ $task->status }} == 'RÉALISÉ' ? style="color: #3ABF71; text-decoration:none;":style="color: #1B68FF; text-decoration:none;"
                                                                   href="#"
                                                                   data-backdrop="static"
                                                                   data-keyboard="false" 
                                                                   data-toggle="modal"
                                                                   data-target="#change_status">
                                                                   {{ $task->status }}
                                                                </a>
                                                                @else
                                                                <a
                                                                   id="modif_stay_tach"
                                                                   data-key="{{ $key+1 }}"
                                                                   data-task="{{ $task }}"
                                                                   style="color: #1B68FF; text-decoration:none;"
                                                                   href="#"
                                                                   data-backdrop="static"
                                                                   data-keyboard="false" 
                                                                   data-toggle="modal"
                                                                   data-target="#change_status">
                                                                   {{ $task->status }}
                                                                </a>
                                                                @endif
                                                        </td>
                                                        <td>{{ $task->maturity_date }}</td>
                                                        <td>{{ $task->departements ? $task->departements->name : '' }}</td>
                                                        <td>
                                                            @if($task->resolution_degree)
                                                            <a  
                                                                id="set_priority_degr"
                                                                href="#"
                                                                style="text-decoration:none;"
                                                                data-task="{{ $task }}"
                                                                data-key="{{ $key+1 }}"
                                                                data-backdrop="static"
                                                                data-keyboard="false"
                                                                data-toggle="modal"
                                                                data-target="#update_degree">
                                                                {{ $task->resolution_degree }}
                                                            </a>
                                                            @else
                                                                <a
                                                                    id="set_priority_degr"
                                                                    href="#"
                                                                    data-task="{{ $task }}"
                                                                    data-key="{{ $key+1 }}"
                                                                    style="text-decoration:none;"
                                                                    data-backdrop="static"
                                                                    data-keyboard="false"
                                                                    data-toggle="modal"
                                                                    data-target="#update_degree">
                                                                    DÉFINISSEZ UNE RÉALISATION
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td><a 
                                                                data-task="{{ $task }}"
                                                                style="text-decoration:none;"
                                                                data-backdrop="static"
                                                                data-keyboard="false" 
                                                                data-toggle="modal" 
                                                                data-target="#defaultModal"
                                                                href="/" 
                                                                title="Joindre Le Fichier Justificatif" 
                                                                class="fe fe-upload-cloud fe-32 files_id"></a>
                                                        </td>
                                                        <td><a 
                                                                data-task="{{ $task }}"
                                                                data-files="{{ $files }}"
                                                                style="text-decoration:none; color:white;"
                                                                data-backdrop="static"
                                                                data-keyboard="false" 
                                                                data-toggle="modal" 
                                                                data-target="#downloadModal"
                                                                href="/" 
                                                                title="Télécharger Le Fichier De La Tâche"
                                                                class="fe fe-download-cloud fe-32 down_id"></a>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="text-muted sr-only">Action</span>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                            <!-- <a 
                                                               data-task="{{ $task }}"
                                                               id="ask_service"
                                                               class="dropdown-item"
                                                               href="#"
                                                               data-backdrop="static"
                                                               data-keyboard="false"
                                                               data-toggle="modal"
                                                               data-target="#serviceAski" ><span class="fe fe-smile mr-4"></span>Demande De Service
                                                            </a> -->
                                                            <a  
                                                                id="edin"
                                                                class="dropdown-item" 
                                                                href="#"
                                                                data-task="{{ $task }}"
                                                                data-backdrop="static"
                                                                data-keyboard="false"
                                                                data-toggle="modal"
                                                                data-target="#modal_edit_task"><span class="fe fe-edit-2 mr-4"></span> Editer
                                                            </a>
                                                                <!-- <a class="dropdown-item" href="#"><span class="fe fe-trash mr-4"></span> Annuler</a> -->
                                                            <a class="dropdown-item" data-key="{{ $key+1 }}" id="supp_task" data-id="{{ $task->id }}" href="#"><span class="fe fe-x mr-4"></span> Supprimer</a>
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
                                                            <span id="txt_num_i" style="margin-left: 13em;" class="text">{{ $number_incident }}</span>
                                                        </div>
                                                    </strong>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <form id="frmtasks">
                                                        @csrf
                                                        @method('POST')
                                                    <input type="hidden" id="hids" value="{{ $number_incident }}" name="number">
                                                    <!-- <div class="form-group mb-3">
                                                        <label for="task"> <span class="fe fe-edit mr-1"></span> A Propos De La Tâche</label>
                                                        <textarea style="resize:none;" class="form-control" id="task_unique" name="title" placeholder="Veuillez Entrer Un Intitulé Précis."></textarea>
                                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div> -->
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
                                                        <label for="user_task"><span class="fe fe-user-plus mr-2"></span>Assigner Un Département A La Tâche</label>
                                                        <select class="form-control select2" name="departement_solving_id" id="user_task_unique">
                                                            <optgroup label="LISTE DEPARTEMENTS">
                                                            <option value=""></option>
                                                            @foreach($departements as $departement)
                                                            <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                                                            @endforeach
                                                            </optgroup>
                                                        </select>
                                                    </div> <!-- form-group -->
                                                    <div class="form-row">
                                                        <div class="text-left mr-4">
                                                            
                                                        </div>
                                                        <div class="ml-auto w-40">
                                                            <button type="button" id="btn_clear_fields" class="btn btn-sm btn-light">
                                                                <span class="fe fe-trash fe-16 mr-1"></span>
                                                                 Effacer Le Texte
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btn_add_unique_task" class="btn btn-sm btn-info">
                                    <span class="fe fe-anchor fe-32"></span>
                                    <span class="fe fe-save mr-2"></span> 
                                    <span class="text-lg">Attribuer La Tâche</span>
                                </button>
                            </div>
                          </div>
                        </div>
    </div>

    <!-- Modal Edit Task -->
    <div style="font-family: Century Gothic; font-size:15px;" class="modal" id="modal_edit_task" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="verticalModalTitle">
                                    <i class="fe fe-plus" style="font-size:15px;"></i>
                                    <i class="fe fe-anchor mr-3" style="font-size:20px;"></i>
                                Edition D'une Tâche</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                                            <span id="txt_num_i" style="margin-left: 13em;" class="text">{{ $number_incident }}</span>
                                                        </div>
                                                    </strong>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <form id="frmedittasks">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" id="hids" value="{{ $number_incident }}" name="number">
                                                        <input type="hidden" id="id_edit" value="" name="id">
                                                    <!-- <div class="form-group mb-3">
                                                        <label for="task"> <span class="fe fe-edit mr-1"></span> A Propos De La Tâche</label>
                                                        <textarea style="resize:none;" class="form-control" id="task_unique" name="title" placeholder="Veuillez Entrer Un Intitulé Précis."></textarea>
                                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div> -->
                                                    <div class="form-group mb-3">
                                                        <label for="desc"><span class="fe fe-edit mr-1"></span> Description (Décrivez De Facon Brève L'objectif De Votre Tâche !)</label>
                                                        <textarea style="resize:none;" class="form-control" id="desc_uniques" name="description" placeholder="Veuillez Entrer Une Cause Assez Exacte." rows="3"></textarea>
                                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="date_echeance">
                                                        <span class="fe fe-calendar fe-16 mr-1"></span>    
                                                        Date D'échéance De La Tâche</label>
                                                        <div class="input-group">
                                                        <input type="date" class="form-control" id="dateing" name="maturity_date">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16 mx-2"></span></div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="user_task"><span class="fe fe-user-plus mr-2"></span>Assigner Un Département A La Tâche</label>
                                                        <select class="form-control" name="departement_solving_id" id="user_task_uniques">
                                                            @foreach($departements as $departement)
                                                            <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                                                            @endforeach
                                                            </optgroup>
                                                        </select>
                                                    </div> <!-- form-group -->
                                                    <div class="form-row">
                                                        <div class="text-left mr-4">
                                                            
                                                        </div>
                                                        <div class="ml-auto w-40">
                                                            <button type="button" id="btn_clear_fields_edit" class="btn btn-sm btn-light">
                                                                <span class="fe fe-trash fe-16 mr-1"></span>
                                                                 Effacer Le Texte
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btn_edit_unique_task" class="btn btn-sm btn-info">
                                    <span class="fe fe-anchor fe-32"></span>
                                    <span class="fe fe-save mr-2"></span> 
                                    <span class="text-lg">Edition De La Tâche</span>
                                </button>
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

    <!-- Modal Upload File -->
    <div style="font-family:Century Gothic;" class="modal" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="defaultModalLabel">
                                    <span class="fe fe-upload fe-32 mr-4"></span>
                                    Chargement Fichier(s)
                                </h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body"> 
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
                                                    <input type="hidden" value="{{ $number_incident }}" name="numero">
                                                    <div class="form-group">
                                                        <input type="file" multiple="multiple" class="form-control" name="file[]" id="inputfile">
                                                    </div>
                                                    <div class="form-group">
                                                        <button disabled id="btn_uploads" class="btn btn-block btn-primary" name="sumbit_files" type="submit">
                                                            <span class="fe fe-upload fe-16 mr-2"></span>
                                                            Charger Le Où Les Fichiers
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
                                <h5 class="modal-title" id="defaultModalLabel">
                                    <span class="fe fe-download fe-32 mr-4"></span>
                                    TéléChargement Fichier(s)
                                </h5>
                              <button id="exit_modal_down" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body"> 
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
                                                    <input type="hidden" value="{{ $number_incident }}" name="numero_down">
                                                    <div class="form-group">
                                                        <span id="span_info" style="font-size: 1.1em; text-align: center; margin-bottom:1em;"><i class="fe fe-file fe-32 mr-2"></i> TéléCharger Le(s) Fichier(s) De Réalisation De La Tâche</span>
                                                        <div style="margin:0 auto;" class="row" id="bakugo"></div>
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

    <!-- Modal Changement De Statut D'une Tâche -->
    <div id="change_status" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-battery-charging mr-3" style="font-size:20px;"></i>
                                    Satut D'une Tâche</h5>
                                <button id="btnExitModalCloture" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="row mb-4" style="text-align:center">
                                        <div class=" col-md-4 text-left"><span>Tâche N°</span> </div>
                                        <div class=" col-md-8 text-right"><span id="tachi"></span></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="statut_e">
                                        <span class="fe fe-battery-charging fe-16 mr-1"></span>    
                                        Séléctionner Un Statut</label>
                                        <div class="form-group">
                                            <select class="custom-select" name="status" id="statut_e">
                                                <option selected value="">Choisissez...</option>
                                                <option value="EN-RÉALISATION">EN-RÉALISATION</option>
                                                <option value="RÉALISÉ">RÉALISÉ</option>
                                            </select>
                                        </div>
                                        <div class="row col-md-12 mt-4">
                                            <button id="tasch_m" data-fichiers="{{ $files }}" data-task="" class="btn btn-sm btn-outline-success btn-block ml-3">
                                                <span class="fe fe-battery-charging fe-16 mr-3"></span>
                                                Modifier Le Statut
                                            </button>
                                        </div>
                                    </div>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->

    <!-- Modal Changement Du Dégré De Réalisation D'une Tâche -->
    <div id="update_degree" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-thumbs-down mr-3" style="font-size:20px;"></i>
                                        Dégré De Réalisation De La Tâche</h5>
                                <button id="btnExitModalCloture" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="row mb-4" style="text-align:center">
                                        <div class=" col-md-4 text-left"><span>Tâche N°</span> </div>
                                        <div class=" col-md-8 text-right"><span id="ttach"></span></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="degree_r">
                                        Séléctionner Un Dégré De Réalisation</label>
                                        <div class="form-group">
                                            <select class="custom-select" name="degree_r" id="degree_r">
                                                <option selected value="">Choisissez...</option>
                                                <option value="CORRECT">CORRECT</option>
                                                <option value="INACHEVÉ">INACHEVÉ</option>
                                            </select>
                                        </div>
                                        <div class="row col-md-12 mt-4">
                                            <button id="valid_deg" data-tache="" class="btn btn-sm btn-outline-success btn-block ml-3">
                                                <span class="fe fe-thumbs-down fe-16 mr-3"></span>
                                                Modifier Le Dégré
                                            </button>
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

    <!-- Modal error validation-->
    <div style="font-family: Century Gothic;" class="modal" id="tache_error_validations" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation" disabled style="width:100%; height:12em;border-style:none; resize: none;color:white; background-color: #495057; font-size:19px;" class="form-control"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="btn_tach_err_ok" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal error validation-->
    <div style="font-family: Century Gothic;" class="modal" id="tache_error_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation_edin" disabled style="width:100%; height:12em;border-style:none; resize: none;color:white; background-color: #495057; font-size:19px;" class="form-control"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="btn_tachedinok" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <script src="{{ url('taches.js') }}"></script>

@endsection