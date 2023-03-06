@extends('layouts.main')

<?php

    $le_role_du_user_connecte = Auth::user()->roles[0]->name;
    $tab_created = array();
    $tab_ids = array();

    if(Session::has('incidents')){
        if(is_iterable(Session::get('incidents'))){
            for ($j=0; $j < count(Session::get('incidents')); $j++) {
                $ines = Session::get('incidents')[$j];
                array_push($tab_ids, $ines->number);
                array_push($tab_created, substr(strval($ines->created_at), 0, 10));
            }
        }
    }

?>

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
                                    Liste Incidents</h1>
                                </div>
                                <div class="col-md-6 text-right">
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
                                            <div class="col-xs-2 mr-3">
                                                <select class="custom-select border-primary" id="emis_recus">
                                                        <option value="">Incident</option>
                                                        <option value="Emis">Emis</option>
                                                        <option value="Reçus">Reçus</option>
                                                </select>
                                            </div>

                                            @if($le_role_du_user_connecte == "COORDONATEUR")
                                            <div class="col-xs-2">
                                                <select class="custom-select border-primary" id="assigner_as">
                                                        <option value="">Assignation...</option>
                                                        <option value="Déja Pris En Compte">Déja Pris En Compte</option>
                                                </select>
                                            </div>
                                            @endif

                                            <div class="col-sm-2">
                                                <select data-categories="{{ json_encode(Session::get('categories')) }}" class="form-control select2" id="validationCustom04">
                                                    <option selected value="">Catégorie...</option>
                                                    @if(Session::has('categories'))
                                                    @if(is_iterable(Session::get('categories')))
                                                    @foreach(Session::get('categories') as $categorie)
                                                    <option value="{{ $categorie->name }}">{{ $categorie->name }}</option>
                                                    @endforeach
                                                    @endif
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
                                            <div class="col-md-2">
                                                <input class="form-control border-primary" id="searchMonth" type="month">
                                            </div>
                                            <div class="text-right col-md-2">
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
                                                    <th>Déclaration</th>
                                                    <th>Echéance</th>
                                                    <th>Clôture</th>
                                                    <th>Catégorie</th>
                                                    <th>Priorité</th>
                                                    
                                                    <th class="text-sm">Assignation</th>
                                                    
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
                                                        if(Session::has('tasks')){
                                                            if(is_iterable(Session::get('tasks'))){
                                                                for ($i=0; $i < count(Session::get('tasks')); $i++) {
                                                                    $task = Session::get('tasks')[$i];
                                                                    
                                                                    if($incident != NULL){
                                                                        if($task->incident_number == $incident->number){
                                                                            $nombre_taches +=1;
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }

                                                        $counte = 0;
                                                        $user_incident = NULL;
                                                        if(Session::has('users_incidents')){
                                                            if(is_iterable(Session::get('users_incidents'))){
                                                                for ($j=0; $j < count(Session::get('users_incidents')); $j++) {
                                                                    $ui = Session::get('users_incidents')[$j];

                                                                    if(($ui->incident_number == $incident->number)){

                                                                        $counte +=1;

                                                                        if(intval($ui->user_id) == intval(Auth::user()->id)){
                                                                            $user_incident  = $ui;
                                                                        }
                                                                        
                                                                    }

                                                                }
                                                            }
                                                        }

                                                    ?>

                                                    <tr id="myInc" data-incident="{{ json_encode($incident) }}">
                                                        <td class="font-weight-bold" style="font-size:0.9em;">
                                                            {{ $incident->number }}
                                                        </td>
                                                        <td>
                                                        @if($user_incident)
                                                            @if($user_incident->isDeclar)
                                                                <span class="badge badge-light">Emis</span>
                                                            @else
                                                                <span class="badge badge-light">Reçus</span>
                                                            @endif
                                                        @else
                                                                <span class="badge badge-light">Reçus</span>
                                                        @endif
                                                        </td>
                                                        <td style="font-size:0.7em;">{{ $incident->description }}
                                                        </td>
                                                        <td style="font-size:0.7em;" id="createcolumn">{{ substr($incident->created_at, 0, 10) }}</td>
                                                        <td style="font-size:0.7em;">
                                                            <a  
                                                                data-incident="{{ json_encode($incident) }}"
                                                                href="#!"
                                                                @if($incident->due_date)
                                                                        title="Ajuster La Date D'échéance"
                                                                @else
                                                                        title="DEFINISSEZ UNE ECHEANCE" 
                                                                @endif

                                                                @if($user_incident)
                                                                    @if($user_incident->isCoordo)
                                                                        @if($user_incident->isTrigger)
                                                                            @if(($incident->status != "CLÔTURÉ"))
                                                                                id="due_date_set"
                                                                                data-backdrop="static"
                                                                                data-keyboard="false"
                                                                                data-toggle="modal"
                                                                                data-target="#define_dat_echean"
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                                style="text-decoration:none;"

                                                                @if($incident->status != "CLÔTURÉ")
                                                                    @if(intval(str_replace("-", "", $incident->due_date)) < intval(str_replace("-", "", date('Y-m-d'))))
                                                                            style="color:danger;"
                                                                            class="text-danger"
                                                                    @elseif(intval(str_replace("-", "", $incident->due_date)) == intval(str_replace("-", "", date('Y-m-d'))))
                                                                            style="color:yellow;"
                                                                            class="text-warning"
                                                                    @else

                                                                    @endif
                                                                @endif
                                                                    >
                                                                {{ $incident->due_date ? $incident->due_date : "DEFINISSEZ UNE ECHEANCE" }}
                                                            </a>
                                                        </td>
                                                        <td style="font-size:0.7em;">{{ $incident->closure_date ? $incident->closure_date : '' }}</td>
                                                        <td style="font-size:0.7em;">
                                                            <a 
                                                                href="#!"
                                                                style="text-decoration: none;"
                                                                title="Catégorie De L'incident"
                                                                @if($user_incident)
                                                                    @if($user_incident->isCoordo)
                                                                        @if($user_incident->isTrigger)
                                                                            @if($incident->status != "CLÔTURÉ")
                                                                                id="set_categ"
                                                                                data-incident="{{ json_encode($incident) }}"
                                                                                data-backdrop="static"
                                                                                data-keyboard="false"
                                                                                data-toggle="modal"
                                                                                data-target="#assignat"
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                                >
                                                                {{ $incident->categories ? $incident->categories->name : "DEFINISSEZ UNE CATEGORIE" }}
                                                            </a>
                                                        </td>
                                                        <td style="font-size:0.7em;">
                                                                        <a 
                                                                            @if($incident->priority == 'URGENT')
                                                                                style="color:red; text-decoration:none;"
                                                                            @elseif($incident->priority == 'ÉLEVÉE')
                                                                                style="color:yellow; text-decoration:none;"
                                                                            @else
                                                                                style="color:green; text-decoration:none;"
                                                                            @endif
                                                                            href="#!"
                                                                            title="Modifier La Priorité"
                                                                            @if($user_incident)
                                                                                @if($user_incident->isCoordo)
                                                                                    @if($user_incident->isTrigger)
                                                                                        @if(($incident->status != "CLÔTURÉ") && ($incident->status != "ANNULÉ"))
                                                                                            id="define_prioriti"
                                                                                            data-incident="{{ json_encode($incident) }}"
                                                                                            data-backdrop="static"
                                                                                            data-keyboard="false"
                                                                                            data-toggle="modal"
                                                                                            data-target="#edit_priority_incident"
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                            >
                                                                            {{ $incident->priority }}
                                                                        </a>
                                                        </td>

                                                        
                                                        <td>
                                                            @if($incident->deja_pris_en_compte == TRUE)
                                                                <span title="Incident Déja Déclaré Par Un Autre Site" style="font-size: 0.8em;" class="badge badge-light">Déja Pris En Compte</span>
                                                            @else
                                                                @if($incident->observation_rex)
                                                                    @if(Session::has('users_incidents'))
                                                                    @if(is_iterable(Session::get('users_incidents')))
                                                                    @for($g=0; $g < count(Session::get('users_incidents')); $g ++)
                                                                        @if(Session::get('users_incidents')[$g]->incident_number == $incident->number)
                                                                            @if(Session::get('users_incidents')[$g]->isTrigger == TRUE)
                                                                                @if(Session::get('users_incidents')[$g]->isCoordo == TRUE)
                                                                                    @if(Session::get('users_incidents')[$g]->isTriggerPlus == TRUE)
                                                                                            
                                                                                        @if(Session::has('users'))
                                                                                            @if(is_iterable(Session::get('users')))
                                                                                            @for($h=0; $h < count(Session::get('users')); $h ++)
                                                                                                @if(intval(Session::get('users')[$h]->id) == intval(Session::get('users_incidents')[$g]->user_id))
                                                                                                    
                                                                                                    @if(Session::get('users')[$h]->site_id)
                                                                                                    
                                                                                                        @if(Session::has('sites'))
                                                                                                        @if(is_iterable(Session::get('sites')))
                                                                                                        @for($o=0; $o < count(Session::get('sites')); $o ++)
                                                                                                            @if(intval(Session::get('sites')[$o]->id) == intval(Session::get('users')[$h]->site_id))
                                                                                                                <span class="badge badge-light">{{ Session::get('sites')[$o]->name }}</span>
                                                                                                                @break
                                                                                                            @endif
                                                                                                        @endfor
                                                                                                        @endif
                                                                                                        @endif

                                                                                                    @elseif(Session::get('users')[$h]->departement_id)

                                                                                                        @if(Session::has('departements'))
                                                                                                        @if(is_iterable(Session::get('departements')))
                                                                                                        @for($o=0; $o < count(Session::get('departements')); $o ++)
                                                                                                            @if(intval(Session::get('departements')[$o]->id) == intval(Session::get('users')[$h]->departement_id))
                                                                                                                <span class="badge badge-light">{{ Session::get('departements')[$o]->name }}</span>
                                                                                                                @break
                                                                                                            @endif
                                                                                                        @endfor
                                                                                                        @endif
                                                                                                        @endif

                                                                                                    @endif
                                                                                                    @break
                                                                                                @endif
                                                                                            @endfor
                                                                                            @endif
                                                                                        @endif
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    @endfor
                                                                    @endif
                                                                    @endif
                                                                @else
                                                                    <span class="badge badge-light"></span>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        
                                                        <td>
                                                            <a 
                                                                style="text-decoration:none;"
                                                                @if($user_incident)
                                                                    @if($user_incident->isCoordo)
                                                                        @if($user_incident->isTrigger)
                                                                            href="{{ route('listedTask', ['number' => $incident->number]) }}"
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                                title="Liste Des Tâches De L'incident">
                                                                <small class="text-lg">{{ $nombre_taches < 10 ? 0 .''. $nombre_taches : $nombre_taches}}</small>
                                                                <span class="fe fe-list"></span>
                                                                <span class="fe fe-check"></span>
                                                            </a>
                                                        </td>
                                                        
                                                        <td>
                                                            @if($user_incident)
                                                                @if($user_incident->isTrigger)
                                                                <a 
                                                                    style="text-decoration:none;" 
                                                                    type="button" 
                                                                    href="{{ route('printIncident', ['number' => $incident->number]) }}" 
                                                                    title="Imprimer Cet Incident"
                                                                    class="fe fe-printer fe-32">
                                                                </a>
                                                                @endif
                                                            @endif
                                                        </td>

                                                        <td>                                                                        
                                                                <a 
                                                                        type="button"
                                                                        @if($user_incident)
                                                                            @if($user_incident->isCoordo)
                                                                                @if($user_incident->isTrigger)
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
                                                                @if($user_incident)
                                                                    @if($user_incident->isCoordo)
                                                                        @if($user_incident->isTrigger)
                                                                            @if($incident->status != "CLÔTURÉ" && $incident->status != "ANNULÉ")
                                                                                <a
                                                                                    href="#!"
                                                                                    data-departements="{{ json_encode(Session::get('departements')) }}"
                                                                                    data-categories="{{ json_encode(Session::get('categories')) }}"
                                                                                    data-incident="{{ json_encode($incident) }}"
                                                                                    id="btn_edit_in"
                                                                                    class="dropdown-item mb-1"
                                                                                    data-backdrop="static"
                                                                                    data-keyboard="false"
                                                                                    data-toggle="modal"
                                                                                    data-target="#modaledit_incident"><span class="fe fe-edit-2 mr-4"></span> Editer
                                                                                </a>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endif

                                                                @if($user_incident)
                                                                    @if($user_incident->isCoordo)
                                                                        @if($user_incident->isTrigger)
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
                                                                                    @elseif($incident->status == "ANNULÉ")
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
                                                                    @endif
                                                                @endif

                                                                <a
                                                                    id="infos_incident"
                                                                    data-sites="{{ json_encode(Session::get('sites')) }}"
                                                                    data-ids="{{ json_encode($tab_ids) }}"
                                                                    data-created="{{ json_encode($tab_created) }}"
                                                                    data-departements="{{ json_encode(Session::get('departements')) }}"
                                                                    data-users="{{ json_encode(Session::get('users')) }}"
                                                                    data-users_incidents="{{ json_encode(Session::get('users_incidents')) }}"
                                                                    data-number="{{ json_encode($incident) }}"
                                                                    data-task="{{ json_encode(Session::get('tasks')) }}"
                                                                    class="dropdown-item mb-1"
                                                                    href="#!"
                                                                    data-backdrop="static"
                                                                    data-keyboard="false"
                                                                    data-toggle="modal"
                                                                    data-target="#modal_infos_incidant">
                                                                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                                                                </a>

                                                                @if(auth::user()->roles[0]->name == "COORDONATEUR")
                                                                    <?php
                                                                        $usere = NULL;
                                                                        if(Session::has('users_incidents')){
                                                                        if(is_iterable(Session::get('users_incidents'))){
                                                                        for ($j=0; $j < count(Session::get('users_incidents')); $j++) {
                                                                            $xi = Session::get('users_incidents')[$j];
                                                                            if(($xi->incident_number == $incident->number) &&
                                                                              ($xi->isDeclar == TRUE)){

                                                                                if(Session::has('users_incidents')){
                                                                                if(is_iterable(Session::get('users_incidents'))){
                                                                                for ($gs=0; $gs < count(Session::get('users')); $gs++) {
                                                                                    $ur = Session::get('users')[$gs];
                                                                                    if(intval($ur->id) == intval($xi->user_id)){
                                                                                        $usere = $ur;
                                                                                        break;
                                                                                    }
                                                                                }}}
                                                                            }
                                                                        }}}
                                                                    ?>
                                                                    @if($usere)
                                                                    @if($usere->responsable)
                                                                        @if($usere->responsable == Auth::user()->id)
                                                                        <a
                                                                                    class="dropdown-item mb-1"
                                                                                    href="#!"
                                                                                    id="assign_elt_gohan"
                                                                                    data-incident="{{ json_encode($incident) }}"
                                                                                    data-utilisateurs="{{ json_encode(Session::get('users')) }}"
                                                                                    data-users_incidents="{{ json_encode(Session::get('users_incidents')) }}"
                                                                                    data-departements="{{ json_encode(Session::get('departements')) }}"
                                                                                    data-sites="{{ json_encode(Session::get('sites')) }}"
                                                                                    data-backdrop="static"
                                                                                    data-keyboard="false"
                                                                                    data-toggle="modal"
                                                                                    data-target="#Grimjow_jagerjack">
                                                                                    <span class="fe fe-corner-down-right"></span>
                                                                                    <span class="fe fe-home mr-2"></span>
                                                                                    Assigner Une Entité A Cet Incident
                                                                        </a>
                                                                        @endif
                                                                    @else
                                                                        @if($usere->id == Auth::user()->id)
                                                                        <a
                                                                                    class="dropdown-item mb-1"
                                                                                    href="#!"
                                                                                    id="assign_elt_gohan"
                                                                                    data-incident="{{ json_encode($incident) }}"
                                                                                    data-utilisateurs="{{ json_encode(Session::get('users')) }}"
                                                                                    data-users_incidents="{{ json_encode(Session::get('users_incidents')) }}"
                                                                                    data-departements="{{ json_encode(Session::get('departements')) }}"
                                                                                    data-sites="{{ json_encode(Session::get('sites')) }}"
                                                                                    data-backdrop="static"
                                                                                    data-keyboard="false"
                                                                                    data-toggle="modal"
                                                                                    data-target="#Grimjow_jagerjack">
                                                                                    <span class="fe fe-corner-down-right"></span>
                                                                                    <span class="fe fe-home mr-2"></span>
                                                                                    Assigner Une Entité A Cet Incident
                                                                        </a>
                                                                        @endif
                                                                    @endif
                                                                    @endif
                                                                @endif


                                                                @if(auth::user()->roles[0]->name == "COORDONATEUR")
                                                                    <?php
                                                                        $usere = NULL;
                                                                        if(Session::has('users_incidents')){
                                                                        if(is_iterable(Session::get('users_incidents'))){
                                                                        for ($j=0; $j < count(Session::get('users_incidents')); $j++) {
                                                                            $xi = Session::get('users_incidents')[$j];
                                                                            if(($xi->incident_number == $incident->number) &&
                                                                              ($xi->isDeclar == TRUE)){

                                                                                if(Session::has('users_incidents')){
                                                                                if(is_iterable(Session::get('users_incidents'))){
                                                                                for ($gs=0; $gs < count(Session::get('users')); $gs++) {
                                                                                    $ur = Session::get('users')[$gs];
                                                                                    if(intval($ur->id) == intval($xi->user_id)){
                                                                                        $usere = $ur;
                                                                                        break;
                                                                                    }
                                                                                }}}
                                                                            }
                                                                        }}}
                                                                    ?>
                                                                    @if($usere)
                                                                    @if($usere->responsable)
                                                                        @if($usere->responsable == Auth::user()->id)
                                                                        <a
                                                                            class="dropdown-item mb-1"
                                                                            href="{{ route('viewUser', ['number' => $incident->number]) }}">
                                                                            <span class="fe fe-eye"></span>
                                                                            <span class="fe fe-eye mr-2"></span>
                                                                            Voir Entités Assigneés A Cet Incident
                                                                        </a>
                                                                        @endif
                                                                    @else
                                                                        @if($usere->id == Auth::user()->id)
                                                                        <a
                                                                            class="dropdown-item mb-1"
                                                                            href="{{ route('viewUser', ['number' => $incident->number]) }}">
                                                                            <span class="fe fe-eye"></span>
                                                                            <span class="fe fe-eye mr-2"></span>
                                                                            Voir Entités Assigneés A Cet Incident
                                                                        </a>
                                                                        @endif
                                                                    @endif

                                                                    @endif
                                                                @endif

                                                                @if($user_incident)
                                                                    @if($user_incident->isCoordo)
                                                                        @if($user_incident->isTrigger)
                                                                            @if($incident->status != "CLÔTURÉ")
                                                                                <a 
                                                                                    id="delete_incids" 
                                                                                    data-incident="{{ json_encode($incident) }}"
                                                                                    class="dropdown-item mb-1" 
                                                                                    href="#!"><span class="fe fe-x mr-4"></span> Supprimer
                                                                                </a>
                                                                            @endif
                                                                        @endif
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

                                                                @if($user_incident)
                                                                    @if($user_incident->isCoordo)
                                                                        @if($user_incident->isTrigger)
                                                                            @if($incident->status == "CLÔTURÉ")
                                                                                <a 
                                                                                    href="#!"
                                                                                    id="archive_incident"
                                                                                    data-incident="{{ json_encode($incident) }}" 
                                                                                    class="dropdown-item mb-1" 
                                                                                    ><span class="fe fe-archive mr-4"></span> Archiver
                                                                                </a>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                @endif

                                                                @if($user_incident)
                                                                    @if($user_incident->isCoordo)
                                                                        @if($user_incident->isTrigger)
                                                                        <a 
                                                                            class="dropdown-item" 
                                                                            href="{{ route('listedTask', ['number' => $incident->number]) }}">
                                                                            <span class="fe fe-list mr-4"></span> Liste Des Tâches
                                                                        </a>
                                                                        @endif
                                                                    @endif
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
                                                    <label for="deepa"><span class="fe fe-home mr-4"></span>Département | Site <span style="color:red;"> *</span></label>
                                                    <select style="font-size:1.2em;" class="custom-select border-success" data-types="{{ json_encode(Session::get('types')) }}" data-categories="{{ json_encode(Session::get('categories')) }}" name="assignatdeepartes" id="deepartes">
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
                                                        <optgroup label="Liste Type">
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


    <!-- Modal Archivage D'un Incident -->
    <div id="archivag" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="text-white" id="verticalModalTitle">
                                            <i class="fe fe-archive mr-3" style="font-size:20px;"></i>
                                            ARCHIVAGE
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="card shadow">
                                                <div class="row my-4 text-xl">
                                                    <div class="col-md-5 text-left ml-5">
                                                        Incident Numéro
                                                    </div>
                                                    <div class="col-md-5 text-right">
                                                        <strong id="taboo"></strong>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-group" style="text-align:center; font-size:20px;">
                                                        Voulez-vous Vraiment Archiver Cet Incident ?
                                                    </div>
                                                </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                        <button type="button" id="btn_save_arching" class="btn btn-primary">OUI</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NON</button>
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
                                          <textarea id="validation" disabled style="width:100%; height:15em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
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
                                          <textarea id="validtion_edii" disabled style="width:100%; height:16em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
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
                                            <!-- <div class="form-group mb-3">
                                                <label for="deepa"><span class="fe fe-home mr-1"></span>Domaine De L'incident  <span style="color:red;"> *</span></label>
                                                <select style="font-size:1.2em;" class="custom-select border-primary" data-types="{{ json_encode(Session::get('types')) }}" data-categories="{{ json_encode(Session::get('categories')) }}" name="esperance" id="deepa">
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
                                                    <optgroup label="Liste Type">
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
                                            <div class="form-group mb-3">
                                                <label for="categorie"><span class="fe fe-box mr-1"></span>Catégorie De L'incident <span style="color:red;"> *</span></label>
                                                <select class="form-control select2" id="categorie" name="categorie_id">
                                                    
                                                </select>
                                            </div> -->
                                            <div class="form-group mb-3">
                                                <label for="battles"><span class="fe fe-box mr-1"></span>Quelles Actions Avez-vous Méneés ?</label>
                                                <textarea style="resize:none; font-size:1.1em;" class="form-control border-primary" id="battles" name="battles" placeholder="Veuillez Spécifiez Les Actions Méneés." rows="4"></textarea>
                                            </div> <!-- form-group -->
                                            <div class="form-group">
                                                <label for="process_incdent"><span class="fe fe-activity mr-1"></span>Procéssus Impacté <span style="color:red;"> *</span></label>
                                                <select style="height:10em;" class="form-control select2-multi border-primary" id="process_incdent" name="processus_id">
                                                    <optgroup label="Liste Procéssus">
                                                        <option value=""></option>
                                                        @if(Session::has('processus'))
                                                        @if(is_iterable(Session::get('processus')))
                                                        @foreach(Session::get('processus') as $process)
                                                        <option value="{{ $process->id }}">{{ $process->name }}</option>
                                                        @endforeach
                                                        @endif
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
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                        <button 
                                                                data-processus="{{ json_encode(Session::get('processus')) }}" 
                                                                name="buttonAddingIncidants" 
                                                                type="button" 
                                                                class="btn btn-block btn-outline-primary">

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
                                        <button type="button" id="btn_clear_fields_incident" class="btn btn-outline-danger"><span class="fe fe-trash fe-16 mr-1"></span> Effacer Le Texte Saisi</button>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button data-dismiss="modal" id="serial_kill" class="btn btn-outline-info"> <i class="fe fe-slash mr-2"></i> Fermer La Page</button>
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
                                                <label for="deepa">Domaine De L'incident <span style="color:red;"> *</span></label>
                                                <select style="font-size:1.2em;" class="custom-select border-primary" data-types="{{ json_encode(Session::get('types')) }}" data-categories="{{ json_encode(Session::get('categories')) }}" name="esperanceEdit" id="deepaEdit">
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
                                                    <optgroup label="Liste Type">
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
                                                    @if(Session::has('processus'))
                                                    @if(is_iterable(Session::get('processus')))
                                                    @foreach(Session::get('processus') as $process)
                                                    <option value="{{ $process->id }}">{{ $process->name }}</option>
                                                    @endforeach
                                                    @endif
                                                    @endif
                                                    </optgroup>
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
                                                            <button type="button" id="btn_clear_fields_edit_incident" class="btn btn-outline-danger">
                                                                <span class="fe fe-trash fe-16 mr-1"></span>
                                                                 Effacer Le Texte Saisi
                                                            </button>
                                                        </div>
                                                        <div class="text-right col-md-6">
                                                            <button id="btn_edit_incident" type="button" class="btn btn-outline-primary"><span class="fe fe-edit-3 fe-16 mr-2"></span>Modifier Incident</button>
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
                                    Assignation De L'incident A Un Site Ou Un Département
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
                                                    <optgroup label="Liste Type">
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
                                                            <span id="txt_num_i" style="margin-left: 13em;" class="text"> </span>
                                                        </div>
                                                    </strong>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <form id="frmtach">
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
                                                                id="set_departement_or_site" 
                                                                >

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
                                                            <button type="button" id="btn_clear_fields_unique" class="btn btn-danger">
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
                                                <label for="cloture_comment"> <span class="fe fe-edit mr-2"></span>Commentaire</label>
                                                <textarea style="resize:none; font-size:1.2em;" rows="4" class="form-control border-success" id="cloture_comment" name="comment" placeholder="Veuillez Entrer Un Commentaire De Clôture."></textarea>
                                                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                        </div>
                                        <div class="form-group">
                                            <button data-incident="" data-tasks="{{ json_encode(Session::get('tasks')) }}" id="Kloture" class="btn btn-outline-success btn-block">
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
                                                @if(Session::has('users'))
                                                @if(is_iterable(Session::get('users')))
                                                @foreach(Session::get('users') as $user)
                                                <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                                @endforeach
                                                @endif
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

    <script src="{{ url('incidents.js') }}"></script>

@endsection
