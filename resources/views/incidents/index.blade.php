@extends('layouts.main')

<?php

    $times = Session::get('times');
        
?>

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-md-9 text-left text-xl text-uppercase" style="font-weight:bold;">
                                    <h1 class="mb-2 text-danger">
                                    <span class="fe fe-info mr-2"></span>  
                                    NB : Bien Vouloir Contacter Par Téléphone Le Responsable Du Site Auquel L'incident Est Assigné (Recepteur de l'incident)</h1>
                                </div>
                                <div class="col-md-3 text-right">
                                    @can('creer-incident')
                                    <button 
                                            style="font-family: Century Gothic;"
                                            id="toto"
                                            data-backdrop="static" 
                                            data-keyboard="false"
                                            title="Déclaration D'incident" 
                                            class="btn btn-primary btn-icon-split"
                                            data-toggle="modal" 
                                            data-target="#modal_incident">
                                            <span class="icon text-white-80">
                                                <i class="fe fe-plus" style="font-size:15px;"></i>
                                                <i class="fe fe-bell mr-3" style="font-size:20px;"></i>
                                            </span>
                                        Déclaration Incident
                                    </button>
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
                                        <div style="font-family: Century Gothic;" class="row ml-1 mt-4 my-4">
                                            <div class="col-xs-2 mr-4">
                                                <select class="custom-select border-primary" id="emis_recus">
                                                        <option value="">Incident</option>
                                                        <option value="Emis">Emis</option>
                                                        <option value="Reçus">Reçus</option>
                                                </select>
                                            </div>

                                            <div class="col-sm-2">
                                                <select data-sites="{{ json_encode($sites) }}" class="form-control select2" id="validationCustom04">
                                                    <option selected value="">Site...</option>
                                                    @if(is_iterable($sites))
                                                    @foreach($sites as $site)
                                                    <option value="{{ $site->name }}">{{ $site->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-xs-2">
                                                <select class="custom-select border-primary" id="year_courant_incident">
                                                        <option value="">Année</option>
                                                        @if(is_iterable($years))
                                                        @foreach($years as $year)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                        @endforeach
                                                        @endif
                                                </select>
                                                <div class="invalid-feedback"> Please select a valid state. </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="input-group mb-3">
                                                    <input type="date" class="form-control border-primary" id="searchDate">
                                                </div>
                                            </div>
                                            <div class="text-right col-md-2 mr-1">
                                                <input type="text" name="" id="search_text_simple" class="form-control border-primary" placeholder="Search...">
                                            </div>
                                        </div>
                                        <!-- table -->
                                        <table style="font-family: Century Gothic;" class="table table-hover datatables" id="dataTable-1">
                                            <thead class="bg-dark">
                                                <tr>
                                                    <th class="text-sm">Numéro</th>
                                                    <th></th>
                                                    <th>Description Incident</th>
                                                    <th>Date Déclaration</th>
                                                    <th>Date Echéance</th>
                                                    <th>Emetteur</th>
                                                    <th class="text-sm">Recepteur</th>
                                                    
                                                    <th>Tâches</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="agencies">
                                                @if(is_iterable($incidents))
                                                @foreach($incidents as $key => $incident)

                                                    <tr id="myInc" data-incident="{{ json_encode($incident) }}">
                                                        <td class="font-weight-bold" style="font-size:0.9em;">
                                                            {{ $incident->number }}
                                                        </td>
                                                        <td>
                                                            @if($incident->site_declarateur == Auth::user()->site_id)
                                                                <span class="badge badge-light">Emis</span>
                                                            @else
                                                                <span class="badge badge-light">Reçus</span>
                                                            @endif

                                                        </td>
                                                        <td style="font-size:0.7em;">{{ $incident->description }}
                                                        </td>
                                                        <td style="font-size:0.7em;" id="createcolumn">{{ $incident->declaration_date }}</td>
                                                        <td style="font-size:0.7em;">
                                                            <a  
                                                                data-incident="{{ json_encode($incident) }}"
                                                                href="#!"
                                                                @if(($incident->site_declarateur == Auth::user()->site_id) || ($incident->site_id != Auth::user()->site_id))
                                                                            @if(($incident->status != "CLÔTURÉ"))
                                                                                id="due_date_set"
                                                                                data-backdrop="static"
                                                                                data-keyboard="false"
                                                                                data-toggle="modal"
                                                                                data-target="#define_dat_echean"
                                                                            @endif
                                                                @endif
                                                                style="text-decoration:none;"
                                                            >
                                                            {{ $incident->due_date ? $incident->due_date : 'DEFINISSEZ UNE DATE D\'ECHEANCE' }}
                                                            </a>
                                                        </td>
                                                        <?php
                                                            $Ncate = NULL;
                                                            if(is_iterable($categories)){
                                                                for ($gr=0; $gr < count($categories); $gr++) {
                                                                    $categ = $categories[$gr];
                                                                    if($categ->id == $incident->categorie_id){
                                                                        $Ncate = $categ;
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                        <td>
                                                            <?php 
                                                                $site_emetteur = NULL;
                                                                for ($v=0; $v < count($sites); $v++) {
                                                                    $s = $sites[$v];
                                                                    if($s->id == $incident->site_declarateur){
                                                                        $site_emetteur = $s;
                                                                        break;
                                                                    }
                                                                }
                                                            ?>
                                                            <span class="badge badge-light">{{ $site_emetteur ? $site_emetteur->name : "" }}</span>
                                                        </td>
                                                        
                                                        <td>
                                                            <?php 
                                                            $site_recepteur = NULL;
                                                                for ($v=0; $v < count($sites); $v++) {
                                                                    $s = $sites[$v];
                                                                    if($s->id == $incident->site_id){
                                                                        $site_recepteur = $s;
                                                                        break;
                                                                    }
                                                                }
                                                            ?>
                                                            @if($incident->deja_pris_en_compte == TRUE)
                                                            <span class="badge badge-light">DÉJA PRIS EN COMPTE</span>
                                                            @else
                                                            <span class="badge badge-light">{{ $site_recepteur ? $site_recepteur->name : "" }}</span>
                                                            @endif
                                                        </td>
                                                        
                                                        <td>
                                                            <a 
                                                                style="text-decoration:none;"
                                                                @if($incident->site_id == Auth::user()->site_id)
                                                                    href="{{ route('listedTask', ['number' => $incident->number, 'in' => $in]) }}"
                                                                @endif
                                                                title="Liste Des Tâches De L'incident">
                                                                @if(is_iterable($tasks) > 0)
                                                                <small class="text-lg">{{ count($tasks[$key]) < 10 ? 0 .''. count($tasks[$key]) : count($tasks[$key]) }}</small>
                                                                @else
                                                                <small class="text-lg">00</small>
                                                                @endif
                                                                <span class="fe fe-list"></span>
                                                                <span class="fe fe-check"></span>
                                                            </a>
                                                        </td>
                                                        
                                                        <td>
                                                                <a 
                                                                    style="text-decoration:none;" 
                                                                    type="button" 
                                                                    href="{{ route('printIncident', ['number' => $incident->number]) }}"
                                                                    title="Imprimer Cet Incident"
                                                                    class="fe fe-printer fe-32">
                                                                </a>
                                                        </td>

                                                        <td>
                                                                <a 
                                                                        type="button"
                                                                        @if(($incident->site_declarateur == Auth::user()->site_id) || ($incident->site_id != Auth::user()->site_id))
                                                                                    id="toggle"
                                                                                    data-incident="{{ json_encode($incident) }}"
                                                                                    @if($incident->closure_date)
                                                                                        style="text-decoration:none;"
                                                                                        title="Incident Clôturé"
                                                                                        class="text-primary fe fe-toggle-right fe-32 saiyan"
                                                                                    @else
                                                                                        style="text-decoration:none;"
                                                                                        title="Clôturer Cet Incident"
                                                                                        class="fe fe-toggle-left fe-32 saiyan"
                                                                                    @endif
                                                                        @endif
                                                                    >
                                                                </a>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <span class="text-muted sr-only">Action</span>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                @if(($incident->site_declarateur == Auth::user()->site_id) || ($incident->site_id != Auth::user()->site_id))
                                                                            @if($incident->status != "CLÔTURÉ" && $incident->status != "ANNULÉ")
                                                                                <a
                                                                                    href="#!"
                                                                                    id="btn_edit_in"
                                                                                    data-incident="{{ json_encode($incident) }}"
                                                                                    data-categories="{{ json_encode(Session::get('categories')) }}"
                                                                                    class="dropdown-item mb-1"
                                                                                    data-backdrop="static"
                                                                                    data-keyboard="false"
                                                                                    data-toggle="modal"
                                                                                    data-target="#modaledit_incident"><span class="fe fe-edit-2 mr-4"></span> Editer
                                                                                </a>
                                                                            @endif
                                                                @endif

                                                                @if(($incident->site_declarateur == Auth::user()->site_id) || ($incident->site_id != Auth::user()->site_id))
                                                                                <a 
                                                                                    class="dropdown-item mb-1" 
                                                                                    href="#!"
                                                                                    @if($incident->status != "ANNULÉ" && $incident->status != "CLÔTURÉ")
                                                                                        id="motas"
                                                                                        data-incident="{{ json_encode($incident) }}"
                                                                                        data-backdrop="static"
                                                                                        data-keyboard="false"
                                                                                        data-toggle="modal"
                                                                                        data-target="#motif_danul"
                                                                                    @elseif($incident['status'] == "ANNULÉ")
                                                                                        id="motiannulitions"
                                                                                        data-backdrop="static"
                                                                                        data-keyboard="false"
                                                                                        data-toggle="modal"
                                                                                        data-target="#modal_info_motifs"
                                                                                    @else
                                                                                        data-backdrop="static"
                                                                                        data-keyboard="false"
                                                                                        data-toggle="modal"
                                                                                        data-target="#modal_commentaire_clotiti"
                                                                                    @endif
                                                                                >
                                                                                @if($incident->status != "ANNULÉ" && $incident->status != "CLÔTURÉ")
                                                                                    <span class="fe fe-trash mr-4"></span> Annuler
                                                                                @elseif($incident->status == "ANNULÉ")
                                                                                    <span class="fe fe-pocket mr-4"></span>Motif D'annulation
                                                                                @elseif($incident->status == "ANNULÉ")
                                                                                    <span class="fe fe-pocket mr-4"></span>Commentaire Fait Lors De La Cloture
                                                                                @endif
                                                                                </a>
                                                                @endif

                                                                <a
                                                                    id="infos_incident"
                                                                    class="dropdown-item mb-1"
                                                                    href="#!"
                                                                    data-backdrop="static"
                                                                    data-keyboard="false"
                                                                    data-toggle="modal"
                                                                    data-incident="{{ json_encode($incident) }}"
                                                                    data-number="{{ $incident->number }}"
                                                                    data-description="{{ $incident->description }}"
                                                                    data-status="{{ $incident->status }}"
                                                                    data-cause="{{ $incident->cause }}"
                                                                    data-motif_annulation="{{ $incident->motif_annulation }}"
                                                                    data-proces_id="{{ $incident->proces_id }}"
                                                                    data-perimeter="{{ $incident->perimeter }}"
                                                                    data-priority="{{ $incident->priority }}"
                                                                    data-declaration_date="{{ $incident->declaration_date }}"
                                                                    data-battles="{{ $incident->battles }}"
                                                                    data-comment="{{ $incident->comment }}"
                                                                    data-site_id="{{ $incident->site_id }}"
                                                                    data-observation_rex="{{ $incident->observation_rex }}"
                                                                    data-archiver="{{ $incident->archiver }}"
                                                                    data-deja_pris_en_compte="{{ $incident->deja_pris_en_compte }}"
                                                                    data-categorie_id="{{ $incident->categorie_id }}"
                                                                    data-site_declarateur="{{ $incident->site_declarateur }}"
                                                                    data-observation="{{ $incident->observation }}"
                                                                    data-fullname_declarateur="{{ $incident->fullname_declarateur }}"
                                                                    data-closure_date="{{ $incident->closure_date }}"
                                                                    data-due_date="{{ $incident->due_date }}"
                                                                    data-valeur="{{ $incident->valeur }}"
                                                                    data-categories="{{ json_encode($categories) }}"
                                                                    data-processus="{{ json_encode(Session::get('processus')) }}"
                                                                    data-tasks="{{ json_encode($tasks[$key]) }}"
                                                                    data-sites="{{ json_encode($sites) }}"
                                                                    data-target="#modal_infos_incidant">
                                                                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                                                                </a>

                                                                @if(auth::user()->roles[0]->name == "COORDONATEUR")
                                                                        <a
                                                                                    class="dropdown-item mb-1"
                                                                                    href="#!"
                                                                                    id="assign_elt_gohan"
                                                                                    data-incident="{{ json_encode($incident) }}"
                                                                                    data-utilisateurs="{{ json_encode($users) }}"
                                                                                    data-sites="{{ json_encode($sites) }}"
                                                                                    data-backdrop="static"
                                                                                    data-keyboard="false"
                                                                                    data-toggle="modal"
                                                                                    data-target="#Grimjow_jagerjack">
                                                                                    <span class="fe fe-corner-down-right"></span>
                                                                                    <span class="fe fe-home mr-2"></span>
                                                                                    Assigner Une Entité A Cet Incident
                                                                        </a>
                                                                        <a
                                                                                    class="dropdown-item mb-1"
                                                                                    href="#!"
                                                                                    id="cloture_rex"
                                                                                    data-number="{{ $incident->number }}"
                                                                                    data-incident="{{ json_encode($incident) }}"
                                                                                    data-utilisateurs="{{ json_encode($users) }}"
                                                                                    data-sites="{{ json_encode($sites) }}">
                                                                                    <span class="fe fe-toggle-left mr-2"></span>
                                                                                    Cloturer Cet Incident
                                                                        </a>
                                                                @endif

                                                                @if($incident->site_id != Auth::user()->site_id)
                                                                    @if($incident->status != "CLÔTURÉ")
                                                                        <a 
                                                                            id="delete_incids"
                                                                            data-incident="{{ json_encode($incident) }}"
                                                                            class="dropdown-item mb-1" 
                                                                            href="#!"><span class="fe fe-x mr-4"></span> Supprimer
                                                                        </a>
                                                                    @endif
                                                                @endif

                                                                @if($incident->status == "CLÔTURÉ")
                                                                <a 
                                                                    id="commentaire_cloture" 
                                                                    data-incident="{{ json_encode($incident) }}"
                                                                    class="dropdown-item mb-1"
                                                                    data-backdrop="static"
                                                                    data-keyboard="false" 
                                                                    data-toggle="modal" 
                                                                    data-target="#modal_commentaire_cloture"
                                                                    href="#!"><span class="fe fe-message-square mr-4"></span> Commentaire De Clôture
                                                                </a>
                                                                @endif
                                                                
                                                                @if($incident->site_id == Auth::user()->site_id)
                                                                    <a
                                                                        class="dropdown-item"
                                                                        href="{{ route('listedTask', ['number' => $incident->number, 'in' => $in]) }}">
                                                                        <span class="fe fe-list mr-4"></span> Liste Des Tâches
                                                                    </a>
                                                                @endif

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

    <!-- Modal Assignation D'un Departement A Un Incident -->
    <div style="font-family: Century Gothic;" id="assignat" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="text-lg" id="verticalModalTitle">
                                            <i class="fe fe-feather mr-3" style="font-size:20px;"></i>
                                            Catégorie D'un Incident
                                    </h5>
                                    <button type="button" id="btn_Assign_Klose" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card shadow">
                                                <div class="row text-lg col-md-12 my-4">
                                                    <div class="col-md-6 text-left">
                                                        Incident Numéro
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <strong id="incassignt"></strong>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12 my-4">
                                                    <label for="deepa"><span class="fe fe-home mr-4"></span>Site <span style="color:red;"> *</span></label>
                                                    <select style="font-size:1.2em;" class="custom-select border-success" data-types="{{ json_encode(Session::get('types')) }}" data-categories="{{ json_encode(Session::get('categories')) }}" name="assignatdeepartes" id="deepartes">
                                                            <option selected value="">Choisissez...</option>
                                                            @if(is_iterable($sites))
                                                            @foreach($sites as $site)
                                                            <option value="{{ $site->id }}">{{ $site->name }}</option>
                                                            @endforeach
                                                            @endif
                                                    </select>
                                                </div>

                                                <div class="my-2">
                                                    <div class="form-group col-md-12">
                                                        <label for="categor"><span class="fe fe-navigation-2 mr-4"></span>Catégorie De L'incident<span style="color:red;"> *</span></label>
                                                        <select data-categories="{{ json_encode(Session::get('categories')) }}" class="form-control select2" id="categor"></select>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group col-md-12 my-4">
                                                    <button type="button" id="btn_assign" class="btn btn-block btn-success">
                                                        <i class="fe fe-feather mr-3"></i>    
                                                        Définir La Catégorie
                                                    </button>
                                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    </div> <!-- small modal -->


    <!-- Modal Proposition Ajout Tache De L'Incident -->
    <div style="font-family: Century Gothic;" id="proposition" class="modal fade  modal-slide" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-lg" id="verticalModalTitle">
                                            <i class="fe fe-info mr-3" style="font-size:20px;"></i>
                                            Attribution D'une Tâche A Cet Incident</h5>
                                    <button type="button" id="btnCloseProposition" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                        <div class="card shadow" style="padding:2em;">
                                            <div class="row my-4">
                                                <div class="alert alert-success col-xl-12" role="alert"> Incident Déclaré Avec Succèss ! </div>
                                            </div>
                                            <div class="row text-xl my-4">
                                                <div class="col-md-6 text-left">
                                                    Numéro Incident
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <strong id="nibiru"></strong>
                                                </div>
                                            </div>
                                            <p class="text-xl my-4" style="text-align:center;">Souhaitez-vous Attribuer Une Tâche à Cet Incident ?</p>
                                            <div class="form-group row">
                                                <button 
                                                        id="oui_tache"
                                                        type="button" 
                                                        title="OUI"
                                                        data-backdrop="static"
                                                        data-keyboard="false"
                                                        data-toggle="modal"
                                                        data-target="#modal_task"
                                                        class="mt-4 squircle bg-primary border-primary justify-content-center">
                                                    <span class="fe fe-thumbs-up fe-32 align-self-center text-white"></span>
                                                </button>
                                                <button id="btnCloseNon" title="NON" type="button" class="mt-4 squircle bg-danger border-danger justify-content-center"
                                                    data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true" class="fe fe-thumbs-down fe-32 align-self-center text-white"></span>
                                                </button>
                                            </div>
                                        </div>
                                </div>
                          </div>
                        </div>
    </div> <!-- small modal -->


    <!-- Modal SET Date D'échéance D'un Incident -->
    <div style="font-family: Century Gothic;" id="define_dat_echean" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-clock mr-3" style="font-size:20px;"></i>
                                        Échéance D'un Incident</h5>
                                <button type="button" id="btn_echeance_set_close" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="card shadow" style="padding:2em;">
                                        <div class="row text-lg my-4">
                                            <div class="col-md-6 text-left">
                                                Numéro
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
                                                <input type="date" class="form-control border-success" id="date_due" aria-describedby="button-addon2">
                                                <div class="input-group-append">
                                                    <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16 mx-2"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <button data-incident="" id="echeance_btn_inc" class="btn btn-block btn-outline-success">
                                                <span class="fe fe-clock fe-16 mr-3"></span>
                                                Définir La Date
                                            </button>
                                        </div>
                                    </div>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->


    <!-- Modal error Assignation Incident A Un Departement -->
    <div style="font-family:Century Gothic;" class="modal" id="error_dassign" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        Erreur D'assignation</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="text_dassign" disabled style="width:100%; height:4em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_dassign" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal error validation date echeance-->
    <div class="modal" id="dued" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
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

    <!-- Modal error validation cloture incident-->
    <div class="modal" id="close_inc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        Erreur Clôture Incident</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="textClo" disabled style="width:100%; height:5em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="btnCloture" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>


    <!-- Modal error validation set priority-->
    <div class="modal" id="prioryty" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        Erreur Priorité Incident</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="textprio" disabled style="width:100%; height:4em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="btnpriorite" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>


    <!-- Modal error validation-->
    <div class="modal" id="Falco" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 class="modal-title text-lg text-white" id="exampleModalLabel">
                                            <i class="fe fe-alert-triangle fe-16 mr-2"></i>
                                            Erreur Déclaration Incident</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea rows="17" id="validation" disabled style="width:100%; border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
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
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validtion_task" disabled style="width:100%; height:15em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
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
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea rows="17" id="validtion_edii" disabled style="width:100%; border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_btn_edii" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal error annulation incident-->
    <div class="modal" id="annulationError" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        Erreur D'annulation</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validtion_annu" disabled style="width:100%; height:4em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_btn_annu" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>


    <!-- Modal error validation Assignation && Edition -->
    <div  style="font-family:Century Gothic;" class="modal" id="erreur_assign_et_edition" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 class="text-lg" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        Erreur Assignation</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="ulkior" disabled style="width:100%; height:7em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="erreur_assign_et_btn" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>


    <!-- Modal -->
    <div style="font-family: Century Gothic; font-size:15px;" class="modal" id="modal_incident" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title text-xl" id="verticalModalTitle">
                                    <i class="fe fe-plus" style="font-size:15px;"></i>
                                    <i class="fe fe-bell mr-3" style="font-size:20px;"></i>
                                    Déclaration D'un Incident
                              </h5>
                              <button id="btnExitModalIncident" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                    <div class="card col-md-12">
                                        <div class="card-header">
                                            <span class="card-title text-lg">
                                                <i class="fe fe-info mr-2"></i>
                                                Informations Nouvel Incident
                                            </span>
                                        </div>
                                        <div class="card-body">
                                          <form id="form_incident">
                                                @csrf
                                                @method('POST')
                                            <div class="form-group mb-3">
                                                <label for="description"> <span class="fe fe-edit-2 mr-1"></span> Votre Nom Complèt <span style="color:red;"> *</span></label>
                                                <input style="font-size:1.1em;" class="form-control border-primary" id="fullname" name="fullname" placeholder="EX : Audrey Tekeu"/>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="site_incident"><span class="fe fe-home mr-2"></span>Site Où Est Survenu L'Incident<span style="color:red;"> *</span></label>
                                                <select style="font-size:1.2em;" class="custom-select border-primary" name="site_incident" id="site_incident">
                                                        <option selected value="">Choisissez...</option>
                                                        @if(is_iterable($sites))
                                                        @foreach($sites as $site)
                                                        <option value="{{ $site->id }}">{{ $site->name }}</option>
                                                        @endforeach
                                                        @endif
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="description"> <span class="fe fe-edit-2 mr-1"></span> A Propos Incident (Décrivez Votre Problème !) <span style="color:red;"> *</span></label>
                                                <textarea style="resize:none; font-size:1.1em;" rows="4" class="form-control border-primary" id="description" name="description" placeholder="Veuillez Entrer Une Description Précise."></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="cause"><span class="fe fe-edit-2 mr-1"></span> Cause Probable (Pas De Verbiage S'il-Vous-Plait !) <span style="color:red;"> *</span></label>
                                                <textarea style="resize:none; font-size:1.1em;" class="form-control border-primary" id="cause" name="cause" placeholder="Veuillez Entrer Une Cause Assez Exacte." rows="4"></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="perimeter"><span class="fe fe-map mr-1"></span> Périmètre (Jusqu'où S'étant L'incident ?)</label>
                                                <textarea style="resize:none; font-size:1.1em;" class="form-control border-primary" id="perimeter" name="perimeter" placeholder="Veuillez Entrer La Portée De L'incident." rows="3"></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="deepa"><span class="fe fe-home mr-1"></span>Affecté L'incident A Site/Service<span style="color:red;"> *</span></label>
                                                <select style="font-size:1.2em;" class="custom-select border-primary" data-sites="{{ json_encode($sites) }}" data-types="{{ json_encode($types) }}" data-categories="{{ json_encode($categories) }}" name="esperance" id="deepa">
                                                        <option selected value="">Choisissez...</option>
                                                        @if(is_iterable($sites))
                                                        @foreach($sites as $site)
                                                        <option value="{{ $site->id }}">{{ $site->name }}</option>
                                                        @endforeach
                                                        @endif
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="categorie"><span class="fe fe-box mr-1"></span>Catégorie De L'incident <span style="color:red;"> *</span></label>
                                                <select class="form-control select2" id="categorie" name="categorie_id">
                                                        <option selected value="">Choisissez...</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="battles"><span class="fe fe-box mr-1"></span>Quelles Actions Avez-vous Méneés ?</label>
                                                <textarea style="resize:none; font-size:1.1em;" class="form-control border-primary" id="battles" name="battles" placeholder="Veuillez Spécifiez Les Actions Méneés." rows="4"></textarea>
                                            </div> <!-- form-group -->
                                            <div class="form-group">
                                                <label for="process_incdent"><span class="fe fe-activity mr-1"></span>Procéssus Impacté <span style="color:red;"> *</span></label>
                                                <select style="height:10em;" class="form-control select2-multi border-primary" id="process_incdent" name="processus_id">
                                                    <optgroup label="Liste Procéssus">
                                                        <option value=""></option>
                                                        @if(is_iterable($processus))
                                                        @foreach($processus as $process)
                                                        <option value="{{ $process->id }}">{{ $process->name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="priority">Priorité <span style="color:red;"> *</span></label>
                                                <select style="font-size:1.2em;" class="custom-select border-primary my-2" id="priority" name="priority">
                                                    <option selected value="">Choisissez Une Priorité...</option>
                                                    <option value="FAIBLE">FAIBLE</option>
                                                    <option value="MOYENNE">MOYENNE</option>
                                                    <option value="ÉLEVÉE">ÉLÉVÉE</option>
                                                    <option value="URGENT">URGENT</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="obs"><span class="fe fe-edit-2 mr-1"></span> Observation (Vos Suggestion Pour Résoudre L'incident !) <span style="color:red;"> *</span></label>
                                                <textarea style="resize:none; font-size:1.1em;" class="form-control border-primary" id="obs" name="observation" placeholder="Veuillez Entrer Une Cause Assez Exacte." rows="4"></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div class="form-group my-4">
                                                <label for="date_echeance">
                                                    <span class="fe fe-calendar fe-16 mr-1"></span>
                                                    Date D'échéance <span style="color:red;"> *</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="date" class="form-control border-info" name="due_date" id="date_due_insert" aria-describedby="button-addon2">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16 mx-2"></span></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                        <button 
                                                                data-processus="{{ json_encode(Session::get('processus')) }}"
                                                                data-incidents="{{ json_encode($incidents) }}"
                                                                name="buttonAddingIncidants" 
                                                                type="button" 
                                                                class="btn btn-block btn-primary">

                                                            <span class="fe fe-save fe-16 mr-2"></span>
                                                            <span class="text">Enregister Incident</span>
                                                        </button>
                                                </div>
                                            </div>
                                          </form>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <div class="row col-md-12 my-4">
                                    <div class="col-md-6 text-left">
                                        <button type="button" id="btn_clear_fields_incident" class="btn btn-danger"><span class="fe fe-trash fe-16 mr-1"></span> Effacer Le Texte Saisi</button>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button data-dismiss="modal" id="serial_kill" class="btn btn-info"> <i class="fe fe-slash mr-2"></i> Fermer La Page</button>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
    </div>


    <!-- Modal Edit Incident -->
    <div style="font-family: Century Gothic; font-size:15px;" class="modal" id="modaledit_incident" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-xl" id="verticalModalTitle">
                                    <i class="fe fe-edit-2" style="font-size:15px;"></i>
                                    <i class="fe fe-bell mr-3" style="font-size:20px;"></i>
                                    Modification D'un Incident
                                </h5>
                              <button type="button" id="btncloseeditform" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row text-lg my-4">
                                                    <div class="col-md-6 text-left my-2">
                                                        <strong>Incident Numéro</strong>
                                                    </div>
                                                    <div class="col-md-6 text-right my-2">
                                                        <span id="nimero"></span>
                                                    </div>
                                            </div>
                                          <form id="formEditIncident">
                                                @csrf
                                                @method('POST')
                                            <input type="hidden" id="number_incident" name="number">
                                            <div class="form-group mb-3">
                                                <label for="description"> <span class="fe fe-edit-2 mr-1"></span> Votre Nom Complèt <span style="color:red;"> *</span></label>
                                                <input style="font-size:1.1em;" class="form-control border-primary" id="fullname_edit" name="fullname" placeholder="EX : Audrey Tekeu"/>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="site_incident"><span class="fe fe-home mr-2"></span>Site Où Est Survenu L'Incident<span style="color:red;"> *</span></label>
                                                <select style="font-size:1.2em;" class="custom-select border-primary" name="site_incident" id="site_incident_edit">
                                                        <option selected value="">Choisissez...</option>
                                                        @if(is_iterable($sites))
                                                        @foreach($sites as $site)
                                                        <option value="{{ $site->id }}">{{ $site->name }}</option>
                                                        @endforeach
                                                        @endif
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="description"> <span class="fe fe-edit-2 mr-1"></span> A Propos De L'incident (Décrivez Votre Problème !) <span style="color:red;"> *</span></label>
                                                <textarea style="resize:none; font-size:1.2em;" rows="4" class="form-control border-primary" id="description_edit" name="description" placeholder="Veuillez Entrer Une Description Précise."></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="cause"><span class="fe fe-edit-2 mr-1"></span> Cause Probable (Pas De Verbiage S'il-Vous-Plait !) <span style="color:red;"> *</span></label>
                                                <textarea style="resize:none; font-size:1.2em;" class="form-control border-primary" id="cause_edit" name="cause" placeholder="Veuillez Entrer Une Cause Assez Exacte." rows="4"></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="cause"><span class="fe fe-edit-2 mr-1"></span> Périmètre (Jusqu'où S'étant L'incident ?)</label>
                                                <textarea style="resize:none; font-size:1.2em;" class="form-control border-primary" id="perimeter_edit" name="perimeter" placeholder="Veuillez Entrer La Portée De L'incident." rows="4"></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="deepa">Affecté L'incident A Site/Service <span style="color:red;"> *</span></label>
                                                <select style="font-size:1.2em;" class="custom-select border-primary" data-types="{{ json_encode(Session::get('types')) }}" data-categories="{{ json_encode(Session::get('categories')) }}" name="esperanceEdit" id="deepaEdit">
                                                        <option selected value="">Choisissez...</option>
                                                        @if(is_iterable($sites))
                                                        @foreach($sites as $site)
                                                        <option value="{{ $site->id }}">{{ $site->name }}</option>
                                                        @endforeach
                                                        @endif
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="categorie"><span class="fe fe-box mr-1"></span>Catégorie De L'incident <span style="color:red;"> *</span></label>
                                                <select class="form-control select2 border-primary" id="categorie_edit" name="categorie_id">
                                                    <option value="">Choisissez...</option></optgroup>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="battles"><span class="fe fe-box mr-1"></span>Quelles Actions Avez-vous Méneés ?</label>
                                                <textarea style="resize:none; font-size:1.2em;" class="form-control border-primary" id="battles_edit" name="battles" placeholder="Veuillez Spécifiez Les Actions Méneés." rows="4"></textarea>
                                            </div> <!-- form-group -->
                                            <div class="form-group">
                                                <label for="process_edit"><span class="fe fe-activity mr-1"></span>Procéssus Impacté <span style="color:red;"> *</span></label>
                                                <select style="font-size:1.2em;" data-processus="{{ json_encode(Session::get('processus')) }}" class="custom-select border-primary" id="process_editss" name="processus_id">
                                                    <option value="">Sélectionner Un Procéssus</option>
                                                    @if(is_iterable($processus))
                                                    @foreach($processus as $process)
                                                    <option value="{{ $process->id }}">{{ $process->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="priority">Priorité <span style="color:red;"> *</span></label>
                                                <select style="font-size:1.2em;" class="custom-select border-primary" id="prioritys" name="priority">
                                                    <option value="">Sélectionner Une Priorité</option>
                                                    <option value="FAIBLE">FAIBLE</option>
                                                    <option value="MOYENNE">MOYENNE</option>
                                                    <option value="ÉLEVÉE">ÉLÉVÉE</option>
                                                    <option value="URGENT">URGENT</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="obs"><span class="fe fe-edit-2 mr-1"></span> Observation (Vos Suggestion Pour Résoudre L'incident !) <span style="color:red;"> *</span></label>
                                                <textarea style="resize:none; font-size:1.1em;" class="form-control border-primary" id="obs_edit" name="observation" placeholder="Veuillez Entrer Une Cause Assez Exacte." rows="4"></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div>
                                                    <label for="date_echeance_edit">
                                                        <span class="fe fe-calendar fe-16 mr-1"></span>    
                                                        Date D'échéance De L'incident
                                                    </label>
                                                    <div class="form-group">
                                                        <input type="date" class="form-control border-primary" name="due_date" id="date_echeance_edit">
                                                    </div>
                                            </div>
                                            <div class="row">
                                                        <div class="text-left col-md-6">
                                                            <button type="button" id="btn_clear_fields_edit_incident" class="btn btn-danger">
                                                                <span class="fe fe-trash fe-16 mr-1"></span>
                                                                 Effacer Le Texte Saisi
                                                            </button>
                                                        </div>
                                                        <div class="text-right col-md-6">
                                                            <button id="btn_edit_incident" type="button" class="btn btn-primary"><span class="fe fe-edit-3 fe-16 mr-2"></span>Modifier Incident</button>
                                                        </div>    
                                            </div>
                                          </form>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer"></div>
                          </div>
                        </div>
    </div>


    <!-- Modal Assignation Incident -->
    <div style="font-family: Century Gothic; font-size:15px;" class="modal" id="Grimjow_jagerjack" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header my-4">
                                <h5 class="modal-title text-lg text-center" id="verticalModalTitle">
                                    <i class="fe fe-corner-down-right" style="font-size:15px;"></i>
                                    <i class="fe fe-home mr-3" style="font-size:20px;"></i>
                                    Assignation De L'incident A Un Site
                                </h5>
                              <button type="button" id="btncloseeditform" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row text-lg my-4">
                                                    <div class="col-md-6 text-left my-2">
                                                        <strong>Incident Numéro</strong>
                                                    </div>
                                                    <div class="col-md-6 text-right my-2">
                                                        <span id="nimero_mappo"></span>
                                                    </div>
                                            </div>
                                          <form id="formEditIncident_mappo">
                                                @csrf
                                                @method('POST')
                                            <input type="hidden" id="number_incident_mappo" name="number">
                                            <div class="form-group mb-3">
                                                <label for="description"> <span class="fe fe-info mr-1"></span> A Propos De L'incident (Décrivez Votre Problème !)</label>
                                                <textarea disabled style="resize:none; font-size:1.2em;" rows="6" class="form-control bg-light" id="description_edit_mappo" name="description" placeholder="Veuillez Entrer Une Description Précise."></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="cause"><span class="fe fe-info mr-1"></span> Cause Probable (Pas De Verbiage S'il-Vous-Plait !)</label>
                                                <textarea disabled style="resize:none; font-size:1.2em;" class="form-control bg-light" id="cause_edit_mappo" name="cause" placeholder="Veuillez Entrer Une Cause Assez Exacte." rows="6"></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="cause"><span class="fe fe-info mr-1"></span> Périmètre (Jusqu'où S'étant L'incident ?)</label>
                                                <textarea disabled style="resize:none; font-size:1.2em;" class="form-control bg-light" id="perimeter_edit_mappo" name="perimeter" placeholder="AUCUN PERMIMETRE RENSEIGNER LORS DE LA DECLARATION DE L'INCIDENT." rows="6"></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="battles"><span class="fe fe-info mr-1"></span>Quelles Actions Avez-vous Méneés ?</label>
                                                <textarea disabled style="resize:none; font-size:1.2em;" class="form-control bg-light" id="battles_edit_mappo" name="battles" placeholder="AUCUNE ACTION MENEES LORS DE LA DECLARATION DE L'INCIDENT." rows="6"></textarea>
                                            </div> <!-- form-group -->

                                            <div class="form-group">
                                                <label for="priority"><span class="fe fe-info mr-1"></span>Priorité</label>
                                                <input disabled type="text" class="form-control bg-light" name="due_date" id="prioritys_mappo">
                                            </div>
                                            <div class="my-4">
                                                    <label for="date_echeance_edit">
                                                        <span class="fe fe-info mr-1"></span>
                                                        Date D'échéance De L'incident
                                                    </label>
                                                    <div class="form-group">
                                                        <input disabled type="text" placeholder="PAS DE DATE D'ECHEANCE" class="form-control bg-light" name="due_date" id="date_echeance_edit_mappo">
                                                    </div>
                                            </div>
                                            
                                            <div class="my-4">
                                                    <label for="date_echeance_edit">
                                                        <span class="fe fe-info mr-1"></span>
                                                        Catégorie De L'incident
                                                    </label>
                                                    <div class="form-group">
                                                        <input disabled type="text" class="form-control bg-light" name="due_date" id="caty_edit_mappo">
                                                    </div>
                                            </div>

                                            <div class="custom-control custom-switch my-4">
                                                <input type="checkbox" name="customSwitch1" class="custom-control-input" id="customSwitch1">
                                                <label class="custom-control-label" for="customSwitch1"><strong>Incident Déja Pris En Compte</strong> </br> (Il S'agit Ici D'un Incident Subvenu Dans plusieurs Site)</label>
                                            </div>

                                            <div class="form-group takeshi mb-3">
                                                <label for="deepa"><span class="fe fe-info mr-1"></span>Assigné A </label>
                                                <select 
                                                        style="font-size:1.2em;"
                                                        class="custom-select border-primary"
                                                        data-types="{{ json_encode(Session::get('types')) }}"
                                                        data-sites="{{ json_encode(Session::get('sites')) }}"
                                                        data-categories="{{ json_encode(Session::get('categories')) }}"
                                                        name="esperanceEditshow" 
                                                        id="regina">
                                                        <option selected value="">Choisissez...</option>
                                                        @if(is_iterable($sites))
                                                        @foreach($sites as $site)
                                                        <option value="{{ $site->id }}">{{ $site->name }}</option>
                                                        @endforeach
                                                        @endif
                                                </select>
                                            </div>
                                            
                                            <div id="artefact_intelligence"></div>

                                            <div class="form-group my-4">
                                                <label for="observation_rex"> <span class="fe fe-edit-2 mr-1"></span> Observation <span style="color:red;"> *</span></label>
                                                <textarea style="resize:none; font-size:1.2em;" rows="4" class="form-control border-primary" id="observation_rex" name="observation" placeholder="Veuillez Entrer Une Observation Précise."></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>

                                            <div class="row anagaki my-4">
                                                        <div class="text-left col-md-6">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button id="btn_edit_incident_mappo" type="button" class="btn btn-block btn-outline-primary">
                                                                <span class="fe fe-corner-down-right fe-16"></span>
                                                                <span class="fe fe-home fe-12 mr-2"></span>
                                                                Assigner L'Incident
                                                            </button>
                                                        </div>    
                                            </div>
                                            <div class="row badji">
                                                        <div class="text-left col-md-6">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button id="groupage" type="button" class="btn btn-block btn-outline-primary">
                                                                    OK
                                                            </button>
                                                        </div>    
                                            </div>
                                          </form>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer"></div>
                          </div>
                        </div>
    </div>


    <!-- Modal Assignation et Listage Incident -->
    <div style="font-family: Century Gothic;" class="modal" id="modalAssignListageIncident" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-xl" id="verticalModalTitle">
                                    <i class="fe fe-corner-down-right" style="font-size:15px;"></i>
                                    <i class="fe fe-home mr-3" style="font-size:20px;"></i>
                                    Liste Entités Assigneés A Cet Incident
                                    <span id="kimeros" class="ml-4"></span>
                                </h5>
                              <button type="button" id="btnAssicma" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                    <div class="card">
                                            <div class="card-header">
                                                <strong class="card-title text-lg"><span><i class="fe fe-home mr-3"></i>Entité(s)</span></strong>
                                                <strong class="float-right text-lg mr-4"><span><i class="fe fe-user mr-3"></i>Utilisateur(s)</span></strong>
                                            </div>
                                        <div class="card-body">
                                            <div id="terunoki"></div>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <div class="col text-center my-4">
                                            <button 
                                                id="shintaro"
                                                data-backdrop="static"
                                                data-keyboard="false"
                                                data-toggle="modal" 
                                                data-target="#Assignement"
                                                style="font-family: Century Gothic;"
                                                title="Assignation D'un Site Ou D'un Département A Un Incident" 
                                                class="btn btn-icon-split btn-primary"
                                                >
                                                <span class="icon text-white-80">
                                                    <i class="fe fe-corner-down-right" style="font-size:15px;"></i>
                                                    <i class="fe fe-lg fe-home mr-3"></i>
                                                </span>
                                                Assigner Un Site Ou Un Département A Cet Incident
                                            </button>
                                </div>
                            </div>
                          </div>
                        </div>
    </div>


    <!-- Modal Confirmation Save Incident -->
    <div style="font-family:Century Gothic;" class="modal" id="modalConfirmationSaveIncident" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-xl text-white">
                                    <h5 class="modal-title">
                                        <i class="fe fe-check fe-32 mr-3"></i>
                                        Confirmez-Vous Ces Informations ?
                                    </h5>
                                </div>
                                <div class="modal-body">
                                        <div class="card shadow col-xs-12">
                                                <div class="card-header">
                                                    <strong class="align-self-center" style="font-size:20px;">Informations Incident</strong>
                                                </div>  
                                                <table class="table table-bordered mb-2">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Nom & Prénom</span>
                                                            </td>
                                                            <td>
                                                                <input style="color:white;" disabled name="" id="fullname_conf"/>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Site Où Est Survenu L'incident</span>
                                                            </td>
                                                            <td>
                                                                <textarea style="color:white;" disabled name="" id="site_survenue_conf" cols="30" rows="3"></textarea>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Description</span>
                                                            </td>
                                                            <td>
                                                                <textarea style="color:white;" disabled name="" id="description_conf" cols="30" rows="5"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Cause</span>
                                                                </td>
                                                                <td>
                                                                <textarea style="color:white;" disabled name="" id="cause_conf" cols="30" rows="5"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Périmètre</span>
                                                                </td>
                                                                <td>
                                                                <textarea style="color:white;" disabled name="" id="perimeter_conf" cols="30" rows="5"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Actions Méneés</span>
                                                                </td>
                                                                <td>
                                                                <textarea style="color:white;" disabled name="" id="menees_actions_conf" cols="30" rows="5"></textarea>
                                                                <span style="color: white; font-size: 20px;" id="menees_actions_conf"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Processus Impacté</span>
                                                                </td>
                                                                <td>
                                                                <textarea style="color:white;" disabled name="" id="process_conf" cols="30" rows="5"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Incident Assigné A </span>
                                                                </td>
                                                                <td>
                                                                <textarea style="color:white;" disabled name="" id="personne_assigne" cols="30" rows="5"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Catégorie</span>
                                                                </td>
                                                                <td>
                                                                <textarea style="color:white;" disabled name="" id="Kate_conf" cols="30" rows="5"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Priorité</span>
                                                                </td>
                                                                <td>
                                                                <textarea style="color:white;" disabled name="" id="priori_conf" cols="30" rows="5"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <span class="text">
                                                                Observation</span>
                                                                </td>
                                                                <td>
                                                                <textarea style="color:white;" disabled name="" id="observe_conf" cols="30" rows="7"></textarea>
                                                            </td>
                                                        </tr>

                                                    <tbody>
                                                </table>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-user="{{ json_encode(Auth::user()) }}" id="conf_save_incident" class="btn btn-primary">OUI</button>
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
                                                                Description De La Tâche</span>
                                                                </td>
                                                                <td>
                                                                <textarea style="color:white; resize:none;" disabled name="" id="decrit_conf" rows="6"></textarea>
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
                                    <button type="button" id="non_conf_save_t" class="btn btn-secondary" data-dismiss="modal">NON</button>
                                </div>
                            </div>
                        </div>
    </div>

    <!-- Modal Cloture Incident -->
    <div style="font-family: Century Gothic;" id="clos" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="text-xl" id="verticalModalTitle">
                                        <i class="fe fe-lock mr-3" style="font-size:20px;"></i>
                                        Clôture D'un Incident</h5>
                                <button id="btnExitModalCloture" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card shadow" style="padding:2em;">
                                        <div class="row text-lg my-4">
                                            <div class="col-md-6 text-left">
                                                Numéro Incident
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <strong id="nibiru_number"></strong>
                                            </div>
                                        </div>
                                        <div class="form-group my-3">
                                            <label for="valeure"> <span class="fe fe-dollar-sign mr-2"></span>Montant (en FCFA)</label>
                                            <input type="number" placeholder="FCFA" min="0" class="form-control border-success" id="valeure" name="valeure">
                                            <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                        </div>
                                        <div class="form-group my-4">
                                                <label for="cloture_comment"> <span class="fe fe-edit mr-2"></span>Commentaire <span style="color:red;"> *</span></label>
                                                <textarea style="resize:none; font-size:1.2em;" rows="4" class="form-control border-success" id="cloture_comment" name="comment" placeholder="Veuillez Entrer Un Commentaire De Clôture."></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                        </div>
                                        <div class="form-group">
                                            <button data-incident="" data-tasks="{{ json_encode($taches) }}" id="Kloture" class="btn btn-outline-success btn-block">
                                                <span class="fe fe-lock fe-16 mr-3"></span>
                                                Clôturé
                                            </button>
                                        </div>
                                    </div>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->

    <!-- Modal Cloture Incident -->
    <div style="font-family: Century Gothic;" id="clos_rex" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="text-xl" id="verticalModalTitle">
                                        <i class="fe fe-lock mr-3" style="font-size:20px;"></i>
                                        Clôture D'un Incident</h5>
                                <button id="btnExitModalCloture" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card shadow" style="padding:2em;">
                                        <div class="row text-lg my-4">
                                            <div class="col-md-6 text-left">
                                                Numéro Incident
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <strong id="nibiru_number_rex"></strong>
                                            </div>
                                        </div>
                                        <div class="form-group my-3">
                                            <label for="valeure"> <span class="fe fe-dollar-sign mr-2"></span>Montant (en FCFA)</label>
                                            <input type="number" placeholder="FCFA" min="0" class="form-control border-success" id="valeure_rex" name="valeure">
                                            <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                        </div>
                                        <div class="form-group my-4">
                                                <label for="cloture_comment"> <span class="fe fe-edit mr-2"></span>Commentaire <span style="color:red;"> *</span></label>
                                                <textarea style="resize:none; font-size:1.2em;" rows="4" class="form-control border-success" id="cloture_comment_rex" name="comment" placeholder="Veuillez Entrer Un Commentaire De Clôture."></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                        </div>
                                        <div class="form-group">
                                            <button data-incident="" data-tasks="{{ json_encode($taches) }}" id="Kloture_rex" class="btn btn-outline-success btn-block">
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
                                            <button data-incident="" data-taches="{{ json_encode(Session::get('$tasks')) }}" id="sta_edi_inci" class="btn btn-sm btn-outline-success btn-block ml-3">
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
    <div style="font-family: Century Gothic;" id="edit_priority_incident" class="modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-alert-triangle mr-3" style="font-size:20px;"></i>
                                    Priorité D'un Incident</h5>
                                <button type="button" id="btn_prior_Kose" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card shadow" style="padding:2em;">
                                    <div class="row text-lg my-4">
                                        <div class="col-md-6 text-left"><span>Numéro</span> </div>
                                        <div class="col-md-6 text-right"><strong id="prior"></strong></div>
                                    </div>
                                    <div class="row my-4">
                                        <label for="statut_e">
                                            <i class="fe fe-alert-triangle mr-3"></i>
                                            Priorité De L'incident
                                        </label>
                                        <div class="form-group">
                                            <select style="width:17em;" class="custom-select border-success" id="priority_it">
                                                <option selected value="">Choisissez...</option>
                                                <option value="FAIBLE">FAIBLE</option>
                                                <option value="MOYENNE">MOYENNE</option>
                                                <option value="ÉLEVÉE">ÉLEVÉE</option>
                                                <option value="URGENT">URGENT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                            <button id="modif_s_i" data-incident="" class="btn btn-outline-success btn-block">
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
    <div style="font-family: Century Gothic;" id="motif_danul" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="text-xl" id="verticalModalTitle">
                                        <i class="fe fe-trash mr-3" style="font-size:20px;"></i>
                                    Annulation D'un Incident</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card shadow" style="padding:2em;">
                                    <div class="row text-xl mb-4">
                                        <div class="col-md-6 text-left"><span>Numéro Incident</span> </div>
                                        <div class=" col-md-6 text-right"><span id="moties"></span></div>
                                    </div>
                                    <div class="my-4">
                                            <div class="form-group">
                                                <label class="text-lg" for="mottifs"> <span class="fe fe-edit-2 mr-1"></span> Motif D'annulation De Cet Incident <span style="color:red;"> *</span></label>
                                                <textarea style="resize:none;font-size:1.2em;" rows="4" class="form-control" id="mottifs" name="mottifs" placeholder="Veuillez Entrer La Raison De L'annulation De L'incident."></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <button data-incident="" id="anule" class="btn btn-outline-success btn-block">
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
    <div id="modal_info_motifs" style="font-family: Century Gothic;" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="text-xl" id="verticalModalTitle">
                                        <i class="fe fe-pocket mr-3" style="font-size:20px;"></i>
                                    Motif D'annulation De L'Incident</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-lg">
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
                                                @if(is_iterable($users))
                                                @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                                @endforeach
                                                @endif
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
    </div>

    <!-- MODAL INFO INCIDENT -->
    <div style="font-family: Century Gothic;" id="modal_infos_incidant" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-18 fe-info mr-3"></i>
                                    <span class="text-xl">Informations Incident <i class="sident"></i></span>
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="col-md-12 mb-4 mt-4">
                                        <div class="card shadow">
                                            <div class="card-header">
                                                <div class="row text-lg my-4">
                                                    <div class="col-md-6 text-left"><strong>Numéro Incident</strong></div>
                                                    <div class="col-md-6 text-right">
                                                        <strong class="card-title"><span id="inf_number"></span></strong>
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
                                                            <div class="my-0 big"><span class="site_de_lincident"></span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <small class="badge badge-pill badge-light text-uppercase">Site De L'incident</small>
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
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <small><strong></strong></small>
                                                            <div class="my-0 big"><span class="statut_taches"></span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <small class="badge badge-pill badge-light text-uppercase">Statut Tâches</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-group-item">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <small><strong></strong></small>
                                                            <div class="my-0 big"><span class="les_taches"></span></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <small class="badge badge-pill badge-light text-uppercase">Tâches</small>
                                                        </div>
                                                    </div>
                                                </div>
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

    <script src="{{ url('incidents.js') }}"></script>

@endsection
