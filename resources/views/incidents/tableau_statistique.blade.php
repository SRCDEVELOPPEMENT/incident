@extends('layouts.main')


@section('content')

    <?php 
                              $tab_ids = array();
                              $tab_created = array();
                              $tab_exited = array();

                              $taches_ids = array();
                              $taches_created = array();
                              $taches_closure = array();

                              if(Session::has('incidents')){
                              if(is_iterable(Session::get('incidents'))){
                              for ($j=0; $j < count(Session::get('incidents')); $j++) {
                                $indi = Session::get('incidents')[$j];
                                array_push($tab_ids, $indi->number);
                                array_push($tab_exited, $indi->due_date);
                                array_push($tab_created, substr(strval($indi->created_at), 0, 10));
                              }}}

                              if(Session::has('tasks')){
                              if(is_iterable(Session::get('tasks'))){
                              for ($v=0; $v < count(Session::get('tasks')); $v++) {
                                $t = Session::get('tasks')[$v];
                                array_push($taches_ids, $t->id);
                                array_push($taches_closure, $t->closure_date);
                                array_push($taches_created, substr(strval($t->created_at), 0, 10));
                              }}}
  
    ?>

    <div class="main-content">
        <div>
            <div class="row justify-content-center">
                <div class="col-12">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-md-6 text-left text-xl text-uppercase">
                                    <h1 class="mb-2">
                                    <span class="fe fe-info mr-2"></span>
                                    Tableau Statistique Incident
                                </h1>
                                </div>
                                <div class="col-md-6 text-right">

                                </div>
                            </div>
                        </div>
                        <!-- <p class="card-text">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, built upon the foundations of progressive enhancement, that adds all of these advanced features to any HTML table. </p> -->
                        <div class="row my-4">
                            <!-- Small table -->
                            <div class="col-md-12">
                                <div>
                                    <div class="card-body">
                                        <div class="row">
                                        <span class="fe fe-32 fe-clock mr-4"></span>
                                            <div class="float-left mr-3">
                                                                        <select 
                                                                                class="custom-select text-lg"
                                                                                id="annee_total"
                                                                                data-taches_ids="{{ json_encode($taches_ids) }}"
                                                                                data-taches_created="{{ json_encode($taches_created) }}"
                                                                                data-tasks="{{ json_encode(Session::get('tasks')) }}"
                                                                                data-users="{{ json_encode(Session::get('users')) }}"
                                                                                data-sites="{{ json_encode(Session::get('sites')) }}"
                                                                                data-incidents="{{ json_encode(Session::get('incidents')) }}"
                                                                                data-ids="{{ json_encode($tab_ids) }}"
                                                                                data-departements="{{ json_encode(Session::get('departements')) }}"
                                                                                data-created="{{ json_encode($tab_created) }}"
                                                                                data-users_incidents="{{ json_encode(Session::get('users_incidents')) }}"
                                                                                data-exited="{{ json_encode($tab_exited) }}"
                                                                                >
                                                                            @foreach($years as $annee)
                                                                                <option value="{{ $annee }}">{{ $annee }}</option>
                                                                            @endforeach
                                                                        </select>
                                            </div>
                                        </div>
                                        <hr class="my-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="float-left">
                                                            <h1 class="text-xl"><i class="fe fe-32 fe-bell"></i><i style="font-size:15px;" class="fe fe-home mr-2"></i>INCIDENT PAR SITE</h1>
                                                </div>
                                                <div class="float-right">
                                                    <button class="btn btn-primary"><i class="fe fe-file mr-2"></i><strong>Générer PDF Qté Incident Par Site</strong></button>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                                <div class="row justify-content-center">
                                                        <div class="col-12 my-4">
                                                            <div class="row my-4">
                                                                <div class="col ml-auto my-4">
                                                                        <div class="float-left">
                                                                            <strong class="text-xl text-success" id="changer_site">DIRECTION GENERALE</strong>
                                                                        </div>
                                                                        <div class="dropdown float-right">
                                                                        <button class="btn btn-secondary dropdown-toggle text-xl" type="button" id="actionMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fe fe-home mr-2"></span> SITE </button>
                                                                        <div class="dropdown-menu" aria-labelledby="actionMenuButton">
                                                                            @if(Session::has('sites'))
                                                                            @if(is_iterable(Session::get('sites')))
                                                                            @for($i=0; $i < count(Session::get('sites')); $i++)
                                                                            <a href="#!" id="maison" class="dropdown-item" style="cursor:pointer;" class="text-xl text-white" data-site="{{ json_encode(Session::get('sites')[$i]) }}">{{ Session::get('sites')[$i]->name }}</a>
                                                                            @endfor
                                                                            @endif
                                                                            @endif
                                                                        </div>
                                                                        </div>
                                                                </div>
                                                            <div class="col-md-12">
                                                                <div class="card shadow">
                                                                <div class="card-body">
                                                                    <table class="table table-hover datatables text-center" id="dataTable-1">
                                                                    <thead class="thead-dark" style="font-family: Century Gothic;">
                                                                        <tr style="font-size: 0.8em;">
                                                                        <th><span class="fe fe-calendar mr-2"></span> Mois</th>
                                                                        <th><span class="dot dot-lg bg-primary mr-2"></span>Incident Encours</th>
                                                                        <th><span class="dot dot-lg bg-dark mr-2"></span>Incident Annulé</th>
                                                                        <th><span class="dot dot-lg bg-success mr-2"></span>Incident Clôturé </th>
                                                                        <th><span class="dot dot-lg bg-warning mr-2"></span>Incident En-Retard</th>
                                                                        <th>Incident Total</th>
                                                                        <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody style="font-size:1.3em; font-family: Century Gothic;">
                                                                        <tr>
                                                                        <td>Janvier</td>
                                                                        <td id="janv_encour">{{ $janvier_encours < 10 ? 0 ."". $janvier_encours : $janvier_encours }}</td>
                                                                        <td id="janv_annuler">{{ $janvier_annuler < 10 ? 0 ."". $janvier_annuler : $janvier_annuler }}</td>
                                                                        <td id="janv_cloture">{{ $janvier_cloture < 10 ? 0 ."". $janvier_cloture : $janvier_cloture  }}</td>
                                                                        <td id="janv_enretard">{{ $janvier_enretard < 10 ? 0 ."". $janvier_enretard : $janvier_enretard }}</td>
                                                                        <td id="janv_total">{{ $janvier_total < 10 ? 0 ."". $janvier_total : $janvier_total }}</td>
                                                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class="text-muted sr-only">Action</span>
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                            <a
                                                                                id="incident_janvier"
                                                                                class="dropdown-item mb-1" 
                                                                                href="#!"
                                                                                data-incident="{{ json_encode($janvier_incident) }}"
                                                                                data-backdrop="static"
                                                                                data-keyboard="false" 
                                                                                data-toggle="modal" 
                                                                                data-target="#modal_liste_incident">
                                                                                <span class="fe fe-eye mr-4"></span>Incident(s) Janvier
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-x mr-4"></span>Supprimer
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                            </a>
                                                                            </div>
                                                                        </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>Fevrier</td>
                                                                        <td id="fev_encour">{{ $fevrier_encours < 10 ? 0 ."". $fevrier_encours : $fevrier_encours }}</td>
                                                                        <td id="fev_annuler">{{ $fevrier_annuler < 10 ? 0 ."". $fevrier_annuler : $fevrier_annuler }}</td>
                                                                        <td id="fev_cloture">{{ $fevrier_cloture < 10 ? 0 ."". $fevrier_cloture : $fevrier_cloture}}</td>
                                                                        <td id="fev_enretard">{{ $fevrier_enretard < 10 ? 0 ."". $fevrier_enretard : $fevrier_enretard}}</td>
                                                                        <td id="fev_total">{{ $fevrier_total < 10 ? 0 ."". $fevrier_total : $fevrier_total}}</td>
                                                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class="text-muted sr-only">Action</span>
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                            <a
                                                                                id="incident_fevrier"
                                                                                class="dropdown-item mb-1" 
                                                                                href="#!"
                                                                                data-incident="{{ json_encode($fevrier_incident) }}"
                                                                                data-backdrop="static"
                                                                                data-keyboard="false" 
                                                                                data-toggle="modal" 
                                                                                data-target="#modal_liste_incident">
                                                                                <span class="fe fe-eye mr-4"></span>Incident(s) Fevrier
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-x mr-4"></span>Supprimer
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                            </a>
                                                                            </div>
                                                                        </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>Mars</td>
                                                                        <td id="mars_encour">{{ $mars_encours < 10 ? 0 ."". $mars_encours : $mars_encours}}</td>
                                                                        <td id="mars_annuler">{{ $mars_annuler < 10 ? 0 ."". $mars_annuler : $mars_annuler }}</td>
                                                                        <td id="mars_cloture">{{ $mars_cloture < 10 ? 0 ."". $mars_cloture : $mars_cloture}}</td>
                                                                        <td id="mars_enretard">{{ $mars_enretard < 10 ? 0 ."". $mars_enretard : $mars_enretard}}</td>
                                                                        <td id="mars_total">{{ $mars_total < 10 ? 0 ."". $mars_total : $mars_total}}</td>
                                                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class="text-muted sr-only">Action</span>
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                            <a
                                                                                id="incident_mars"
                                                                                class="dropdown-item mb-1" 
                                                                                href="#!"
                                                                                data-incident="{{ json_encode($mars_incident) }}"
                                                                                data-backdrop="static"
                                                                                data-keyboard="false" 
                                                                                data-toggle="modal" 
                                                                                data-target="#modal_liste_incident">
                                                                                <span class="fe fe-eye mr-4"></span>Incident(s) Mars
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-x mr-4"></span>Supprimer
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                            </a>
                                                                            </div>
                                                                        </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>Avril</td>
                                                                        <td id="avril_encour">{{ $avril_encours < 10 ? 0 ."". $avril_encours : $avril_encours}}</td>
                                                                        <td id="avril_annuler">{{ $avril_annuler < 10 ? 0 ."". $avril_annuler : $avril_annuler}}</td>
                                                                        <td id="avril_cloture">{{ $avril_cloture < 10 ? 0 ."". $avril_cloture : $avril_cloture}}</td>
                                                                        <td id="avril_enretard">{{ $avril_enretard < 10 ? 0 ."". $avril_enretard : $avril_enretard}}</td>
                                                                        <td id="avril_total">{{ $avril_total < 10 ? 0 ."". $avril_total : $avril_total}}</td>
                                                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class="text-muted sr-only">Action</span>
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                            <a
                                                                                id="incident_avril"
                                                                                class="dropdown-item mb-1" 
                                                                                href="#!"
                                                                                data-incident="{{ json_encode($avril_incident) }}"
                                                                                data-backdrop="static"
                                                                                data-keyboard="false" 
                                                                                data-toggle="modal" 
                                                                                data-target="#modal_liste_incident">
                                                                                <span class="fe fe-eye mr-4"></span>Incident(s) Avril
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-x mr-4"></span>Supprimer
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                            </a>
                                                                            </div>
                                                                        </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>Mai</td>
                                                                        <td id="mai_encour">{{ $mai_encours < 10 ? 0 ."". $mai_encours : $mai_encours}}</td>
                                                                        <td id="mai_annuler">{{ $mai_annuler < 10 ? 0 ."". $mai_annuler : $mai_annuler}}</td>
                                                                        <td id="mai_cloture">{{ $mai_cloture < 10 ? 0 ."". $mai_cloture : $mai_cloture}}</td>
                                                                        <td id="mai_enretard">{{ $mai_enretard < 10 ? 0 ."". $mai_enretard : $mai_enretard}}</td>
                                                                        <td id="mai_total">{{ $mai_total < 10 ? 0 ."". $mai_total : $mai_total}}</td>
                                                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class="text-muted sr-only">Action</span>
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                            <a
                                                                                id="incident_mai"
                                                                                class="dropdown-item mb-1" 
                                                                                href="#!"
                                                                                data-incident="{{ json_encode($mai_incident) }}"
                                                                                data-backdrop="static"
                                                                                data-keyboard="false" 
                                                                                data-toggle="modal" 
                                                                                data-target="#modal_liste_incident">
                                                                                <span class="fe fe-eye mr-4"></span>Incident(s) Mai
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-x mr-4"></span>Supprimer
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                            </a>                              
                                                                            </div>
                                                                        </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>Juin</td>
                                                                        <td id="juin_encour">{{ $juin_encours < 10 ? 0 ."". $juin_encours : $juin_encours}}</td>
                                                                        <td id="juin_annuler">{{ $juin_annuler < 10 ? 0 ."". $juin_annuler : $juin_annuler}}</td>
                                                                        <td id="juin_cloture">{{ $juin_cloture < 10 ? 0 ."". $juin_cloture : $juin_cloture}}</td>
                                                                        <td id="juin_enretard">{{ $juin_enretard < 10 ? 0 ."". $juin_enretard : $juin_enretard}}</td>
                                                                        <td id="juin_total">{{ $juin_total < 10 ? 0 ."". $juin_total : $juin_total}}</td>
                                                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class="text-muted sr-only">Action</span>
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                            <a
                                                                                id="incident_juin"
                                                                                class="dropdown-item mb-1" 
                                                                                href="#!"
                                                                                data-incident="{{ json_encode($juin_incident) }}"
                                                                                data-backdrop="static"
                                                                                data-keyboard="false" 
                                                                                data-toggle="modal" 
                                                                                data-target="#modal_liste_incident">
                                                                                <span class="fe fe-eye mr-4"></span>Incident(s) Juin
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-x mr-4"></span>Supprimer
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                            </a>                              
                                                                        </div>
                                                                        </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>Juillet</td>
                                                                        <td id="juillet_encour">{{ $juillet_encours < 10 ? 0 ."". $juillet_encours : $juillet_encours}}</td>
                                                                        <td id="juillet_annuler">{{ $juillet_annuler < 10 ? 0 ."". $juillet_annuler : $juillet_annuler}}</td>
                                                                        <td id="juillet_cloture">{{ $juillet_cloture < 10 ? 0 ."". $juillet_cloture : $juillet_cloture}}</td>
                                                                        <td id="juillet_enretard">{{ $juillet_enretard < 10 ? 0 ."". $juillet_enretard : $juillet_enretard}}</td>
                                                                        <td id="juillet_total">{{ $juillet_total < 10 ? 0 ."". $juillet_total :  $juillet_total }}</td>
                                                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class="text-muted sr-only">Action</span>
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                            <a
                                                                                id="incident_juillet"
                                                                                class="dropdown-item mb-1" 
                                                                                href="#!"
                                                                                data-incident="{{ json_encode($juillet_incident) }}"
                                                                                data-backdrop="static"
                                                                                data-keyboard="false" 
                                                                                data-toggle="modal" 
                                                                                data-target="#modal_liste_incident">
                                                                                <span class="fe fe-eye mr-4"></span>Incident(s) Juillet
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-x mr-4"></span>Supprimer
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                            </a>                              
                                                                            </div>
                                                                        </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>Août</td>
                                                                        <td id="aout_encour">{{ $aout_encours < 10 ? 0 ."". $aout_encours : $aout_encours}}</td>
                                                                        <td id="aout_annuler">{{ $aout_annuler < 10 ? 0 ."". $aout_annuler : $aout_annuler}}</td>
                                                                        <td id="aout_cloture">{{ $aout_cloture < 10 ? 0 ."". $aout_cloture : $aout_cloture}}</td>
                                                                        <td id="aout_enretard">{{ $aout_enretard < 10 ? 0 ."". $aout_enretard : $aout_enretard}}</td>
                                                                        <td id="aout_total">{{ $aout_total < 10 ? 0 ."". $aout_total : $aout_total}}</td>
                                                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class="text-muted sr-only">Action</span>
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                            <a
                                                                                id="incident_aout"
                                                                                class="dropdown-item mb-1" 
                                                                                href="#!"
                                                                                data-incident="{{ json_encode($aout_incident) }}"
                                                                                data-backdrop="static"
                                                                                data-keyboard="false" 
                                                                                data-toggle="modal" 
                                                                                data-target="#modal_liste_incident">
                                                                                <span class="fe fe-eye mr-4"></span>Incident(s) Août
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-x mr-4"></span>Supprimer
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                            </a>                              
                                                                            </div>
                                                                        </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>Septembre</td>
                                                                        <td id="septembre_encour">{{ $septembre_encours < 10 ? 0 ."". $septembre_encours : $septembre_encours}}</td>
                                                                        <td id="septembre_annuler">{{ $septembre_annuler < 10 ? 0 ."". $septembre_annuler : $septembre_annuler}}</td>
                                                                        <td id="septembre_cloture">{{ $septembre_cloture < 10 ? 0 ."". $septembre_cloture : $septembre_cloture}}</td>
                                                                        <td id="septembre_enretard">{{ $septembre_enretard < 10 ? 0 ."". $septembre_enretard : $septembre_enretard}}</td>
                                                                        <td id="septembre_total">{{ $septembre_total < 10 ? 0 ."". $septembre_total : $septembre_total}}</td>
                                                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class="text-muted sr-only">Action</span>
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                            <a
                                                                                id="incident_septembre"
                                                                                class="dropdown-item mb-1" 
                                                                                href="#!"
                                                                                data-incident="{{ json_encode($septembre_incident) }}"
                                                                                data-backdrop="static"
                                                                                data-keyboard="false" 
                                                                                data-toggle="modal" 
                                                                                data-target="#modal_liste_incident">
                                                                                <span class="fe fe-eye mr-4"></span>Incident(s) Septembre
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-x mr-4"></span>Supprimer
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                            </a>                              
                                                                            </div>
                                                                        </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>Octobre</td>
                                                                        <td id="octobre_encour">{{ $octobre_encours < 10 ? 0 ."". $octobre_encours : $octobre_encours}}</td>
                                                                        <td id="octobre_annuler">{{ $octobre_annuler < 10 ? 0 ."". $octobre_annuler : $octobre_annuler}}</td>
                                                                        <td id="octobre_cloture">{{ $octobre_cloture < 10 ? 0 ."". $octobre_cloture : $octobre_cloture}}</td>
                                                                        <td id="octobre_enretard">{{ $octobre_enretard < 10 ? 0 ."". $octobre_enretard : $octobre_enretard}}</td>
                                                                        <td id="octobre_total">{{ $octobre_total < 10 ? 0 ."". $octobre_total : $octobre_total}}</td>
                                                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class="text-muted sr-only">Action</span>
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                            <a
                                                                                id="incident_octobre"
                                                                                class="dropdown-item mb-1" 
                                                                                href="#!"
                                                                                data-incident="{{ json_encode($octobre_incident) }}"
                                                                                data-backdrop="static"
                                                                                data-keyboard="false" 
                                                                                data-toggle="modal" 
                                                                                data-target="#modal_liste_incident">
                                                                                <span class="fe fe-eye mr-4"></span>Incident(s) Octobre
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-x mr-4"></span>Supprimer
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                            </a>                              
                                                                            </div>
                                                                        </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>Novembre</td>
                                                                        <td id="novembre_encour">{{ $novembre_encours < 10 ? 0 ."". $novembre_encours : $novembre_encours}}</td>
                                                                        <td id="novembre_annuler">{{ $novembre_annuler < 10 ? 0 ."". $novembre_annuler : $novembre_annuler}}</td>
                                                                        <td id="novembre_cloture">{{ $novembre_cloture < 10 ? 0 ."". $novembre_cloture : $novembre_cloture}}</td>
                                                                        <td id="novembre_enretard">{{ $novembre_enretard < 10 ? 0 ."". $novembre_enretard : $novembre_enretard}}</td>
                                                                        <td id="novembre_total">{{ $novembre_total < 10 ? 0 ."". $novembre_total : $novembre_total}}</td>
                                                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class="text-muted sr-only">Action</span>
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                            <a
                                                                                id="incident_novembre"
                                                                                class="dropdown-item mb-1" 
                                                                                href="#!"
                                                                                data-incident="{{ json_encode($novembre_incident) }}"
                                                                                data-backdrop="static"
                                                                                data-keyboard="false" 
                                                                                data-toggle="modal" 
                                                                                data-target="#modal_liste_incident">
                                                                                <span class="fe fe-eye mr-4"></span>Incident(s) Novembre
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-x mr-4"></span>Supprimer
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                            </a>                              
                                                                        </div>
                                                                        </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td>Deccembre</td>
                                                                        <td id="deccembre_encour">{{ $deccembre_encours < 10 ? 0 ."". $deccembre_encours : $deccembre_encours}}</td>
                                                                        <td id="deccembre_annuler">{{ $deccembre_annuler < 10 ? 0 ."". $deccembre_annuler : $deccembre_annuler}}</td>
                                                                        <td id="deccembre_cloture">{{ $deccembre_cloture < 10 ? 0 ."". $deccembre_cloture : $deccembre_cloture}}</td>
                                                                        <td id="deccembre_enretard">{{ $deccembre_enretard < 10 ? 0 ."". $deccembre_enretard : $deccembre_enretard}}</td>
                                                                        <td id="deccembre_total">{{ $deccembre_total < 10 ? 0 ."". $deccembre_total : $deccembre_total}}</td>
                                                                        <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class="text-muted sr-only">Action</span>
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                            <a
                                                                                id="incident_deccembre"
                                                                                class="dropdown-item mb-1" 
                                                                                href="#!"
                                                                                data-incident="{{ json_encode($deccembre_incident) }}"
                                                                                data-backdrop="static"
                                                                                data-keyboard="false" 
                                                                                data-toggle="modal" 
                                                                                data-target="#modal_liste_incident">
                                                                                <span class="fe fe-eye mr-4"></span>Incident(s) Deccembre
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-x mr-4"></span>Supprimer
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!">
                                                                                <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                            </a>                              
                                                                        </div>
                                                                        </td>
                                                                        </tr>
                                                                    </tbody>
                                                                    </table>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>


                                        <hr class="my-4">
                                        <div class="row col-md-12">
                                            <div class="float-left col-md-6">
                                                <h1 class="text-xl"><i class="fe fe-32 fe-bell"></i><i style="font-size:15px;" class="fe fe-globe mr-2"></i>INCIDENT PAR REGION</h1>
                                            </div>
                                            <div class="text-right col-md-6">
                                                <button class="btn btn-primary"><i class="fe fe-file mr-2"></i><strong>Générer PDF Qté Incident Par Région</strong></button>
                                            </div>
                                        </div>
                                        <?php
                                            $encour_ouest = 0;
                                            $annule_ouest = 0;
                                            $cloture_ouest = 0;
                                            $enretard_ouest = 0;

                                            if(is_iterable($inc_ouest)){
                                            for ($i=0; $i < count($inc_ouest); $i++) {
                                                $incident = $inc_ouest[$i];
                                                if($incident->status == "ENCOURS"){
                                                $encour_ouest +=1;
                                                }elseif ($incident->status == "CLÔTURÉ") {
                                                $cloture_ouest +=1;
                                                }elseif ($incident->status == "ANNULÉ") {
                                                $annule_ouest +=1;
                                                }

                                                if($incident->due_date){
                                                if(intval(str_replace("-", "", $incident->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                                    $enretard_ouest +=1;
                                                }  
                                                }
                                            }}

                                            $encour_littoral = 0;
                                            $annule_littoral = 0;
                                            $cloture_littoral = 0;
                                            $enretard_littoral = 0;

                                            if(is_iterable($inc_littoral)){
                                            for ($i=0; $i < count($inc_littoral); $i++) {
                                                $incident = $inc_littoral[$i];
                                                if($incident->status == "ENCOURS"){
                                                $encour_littoral +=1;
                                                }elseif ($incident->status == "CLÔTURÉ") {
                                                $cloture_littoral +=1;
                                                }elseif ($incident->status == "ANNULÉ") {
                                                $annule_littoral +=1;
                                                }

                                                if($incident->due_date){
                                                if(intval(str_replace("-", "", $incident->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                                    $enretard_littoral +=1;
                                                }  
                                                }
                                            }}

                                            $encour_centre = 0;
                                            $annule_centre = 0;
                                            $cloture_centre = 0;
                                            $enretard_centre = 0;

                                            if(is_iterable($inc_centre)){
                                            for ($i=0; $i < count($inc_centre); $i++) {
                                                $incident = $inc_centre[$i];
                                                if($incident->status == "ENCOURS"){
                                                $encour_centre +=1;
                                                }elseif ($incident->status == "CLÔTURÉ") {
                                                $cloture_centre +=1;
                                                }elseif ($incident->status == "ANNULÉ") {
                                                $annule_centre +=1;
                                                }

                                                if($incident->due_date){
                                                if(intval(str_replace("-", "", $incident->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                                    $enretard_centre +=1;
                                                }  
                                                }
                                            }}

                                            $encour_nordouest = 0;
                                            $annule_nordouest = 0;
                                            $cloture_nordouest = 0;
                                            $enretard_nordouest = 0;

                                            if(is_iterable($inc_nord_ouest)){
                                            for ($i=0; $i < count($inc_nord_ouest); $i++) {
                                                $incident = $inc_nord_ouest[$i];
                                                if($incident->status == "ENCOURS"){
                                                $encour_nordouest +=1;
                                                }elseif ($incident->status == "CLÔTURÉ") {
                                                $cloture_nordouest +=1;
                                                }elseif ($incident->status == "ANNULÉ") {
                                                $annule_nordouest +=1;
                                                }

                                                if($incident->due_date){
                                                if(intval(str_replace("-", "", $incident->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                                    $enretard_nordouest +=1;
                                                }  
                                                }
                                            }}

                                            $encour_sudouest = 0;
                                            $annule_sudouest = 0;
                                            $cloture_sudouest = 0;
                                            $enretard_sudouest = 0;

                                            if(is_iterable($inc_sud_ouest)){
                                            for ($i=0; $i < count($inc_sud_ouest); $i++) {
                                                $incident = $inc_sud_ouest[$i];
                                                if($incident->status == "ENCOURS"){
                                                $encour_sudouest +=1;
                                                }elseif ($incident->status == "CLÔTURÉ") {
                                                $cloture_sudouest +=1;
                                                }elseif ($incident->status == "ANNULÉ") {
                                                $annule_sudouest +=1;
                                                }

                                                if($incident->due_date){
                                                if(intval(str_replace("-", "", $incident->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                                    $enretard_sudouest +=1;
                                                }  
                                                }
                                            }}

                                            $encour_extremenord = 0;
                                            $annule_extremenord = 0;
                                            $cloture_extremenord = 0;
                                            $enretard_extremenord = 0;

                                            if(is_iterable($inc_extreme_nord)){
                                            for ($i=0; $i < count($inc_extreme_nord); $i++) {
                                                $incident = $inc_extreme_nord[$i];
                                                if($incident->status == "ENCOURS"){
                                                $encour_extremenord +=1;
                                                }elseif ($incident->status == "CLÔTURÉ") {
                                                $cloture_extremenord +=1;
                                                }elseif ($incident->status == "ANNULÉ") {
                                                $annule_extremenord +=1;
                                                }

                                                if($incident->due_date){
                                                if(intval(str_replace("-", "", $incident->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                                    $enretard_extremenord +=1;
                                                }  
                                                }
                                            }}

                                            $encour_sud = 0;
                                            $annule_sud = 0;
                                            $cloture_sud = 0;
                                            $enretard_sud = 0;

                                            if(is_iterable($inc_sud)){
                                            for ($i=0; $i < count($inc_sud); $i++) {
                                                $incident = $inc_sud[$i];
                                                if($incident->status == "ENCOURS"){
                                                $encour_sud +=1;
                                                }elseif ($incident->status == "CLÔTURÉ") {
                                                $cloture_sud +=1;
                                                }elseif ($incident->status == "ANNULÉ") {
                                                $annule_sud +=1;
                                                }

                                                if($incident->due_date){
                                                if(intval(str_replace("-", "", $incident->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                                    $enretard_sud +=1;
                                                }  
                                                }
                                            }}

                                            $encour_nord = 0;
                                            $annule_nord = 0;
                                            $cloture_nord = 0;
                                            $enretard_nord = 0;

                                            if(is_iterable($inc_nord)){
                                            for ($i=0; $i < count($inc_nord); $i++) {
                                                $incident = $inc_nord[$i];
                                                if($incident->status == "ENCOURS"){
                                                $encour_nord +=1;
                                                }elseif ($incident->status == "CLÔTURÉ") {
                                                $cloture_nord +=1;
                                                }elseif ($incident->status == "ANNULÉ") {
                                                $annule_nord +=1;
                                                }

                                                if($incident->due_date){
                                                if(intval(str_replace("-", "", $incident->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                                    $enretard_nord +=1;
                                                }  
                                                }
                                            }}

                                            $encour_adamaoua = 0;
                                            $annule_adamaoua = 0;
                                            $cloture_adamaoua = 0;
                                            $enretard_adamaoua = 0;

                                            if(is_iterable($inc_adamaoua)){
                                            for ($i=0; $i < count($inc_adamaoua); $i++) {
                                                $incident = $inc_adamaoua[$i];
                                                if($incident->status == "ENCOURS"){
                                                $encour_adamaoua +=1;
                                                }elseif ($incident->status == "CLÔTURÉ") {
                                                $cloture_adamaoua +=1;
                                                }elseif ($incident->status == "ANNULÉ") {
                                                $annule_adamaoua +=1;
                                                }

                                                if($incident->due_date){
                                                if(intval(str_replace("-", "", $incident->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                                    $enretard_adamaoua +=1;
                                                }  
                                                }
                                            }}

                                            $encour_est = 0;
                                            $annule_est = 0;
                                            $cloture_est = 0;
                                            $enretard_est = 0;

                                            if(is_iterable($inc_est)){
                                            for ($i=0; $i < count($inc_est); $i++) {
                                                $incident = $inc_est[$i];
                                                if($incident->status == "ENCOURS"){
                                                $encour_est +=1;
                                                }elseif ($incident->status == "CLÔTURÉ") {
                                                $cloture_est +=1;
                                                }elseif ($incident->status == "ANNULÉ") {
                                                $annule_est +=1;
                                                }

                                                if($incident->due_date){
                                                if(intval(str_replace("-", "", $incident->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                                    $enretard_est +=1;
                                                }  
                                                }
                                            }}

                                        ?>

                                        <div class="row" style="font-family: Century Gothic;">
                                                    <div class="col-md-12 my-4">
                                                        <div class="card shadow">
                                                        <div class="card-body">
                                                            <table class="table table-hover table-borderless border-v">
                                                                <thead class="thead-dark">
                                                                    <tr style="font-size: 0.8em;">
                                                                    <th class="text-center">Région</th>
                                                                    <th><span class="dot dot-lg bg-primary mr-2"></span> Incident Encours</th>
                                                                    <th><span class="dot dot-lg bg-dark mr-2"></span> Incident Annulé</th>
                                                                    <th><span class="dot dot-lg bg-success mr-2"></span> Incident Clôturé </th>
                                                                    <th><span class="dot dot-lg bg-warning mr-2"></span> Incident En-Retard</th>
                                                                    <th>Incident Total</th>
                                                                    <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="text-center" style="font-size:1.3em; font-family: Century Gothic;">
                                                                    <tr class="accordion-toggle collapsed" id="c-2474" data-toggle="collapse" data-parent="#c-2474" href="#collap-2474">
                                                                    <td>{{ $regions[0] }}</td>
                                                                    <td id="encour_ouest">{{ $encour_ouest < 10 ? 0 ."". $encour_ouest : $encour_ouest  }}</td>
                                                                    <td id="annule_ouest">{{ $annule_ouest < 10 ? 0 ."". $annule_ouest : $annule_ouest }}</td>
                                                                    <td id="cloture_ouest">{{ $cloture_ouest < 10 ? 0 ."". $cloture_ouest : $cloture_ouest }}</td>
                                                                    <td id="enretard_ouest">{{ $enretard_ouest < 10 ? 0 ."". $enretard_ouest : $enretard_ouest }}</td>
                                                                    <td id="total_ouest">{{ $ouest < 10 ? 0 ."". $ouest : $ouest }}</td>
                                                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <span class="text-muted sr-only">Action</span>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                        <a 
                                                                            id="incident_ouest"
                                                                            data-ouest="{{ json_encode($inc_ouest) }}"
                                                                            class="dropdown-item" 
                                                                            href="#!"
                                                                            data-backdrop="static"
                                                                            data-keyboard="false" 
                                                                            data-toggle="modal" 
                                                                            data-target="#modal_liste_incident">
                                                                            <span class="fe fe-eye mr-2"></span> Incident(s) Ouest
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-x mr-4"></span>Supprimer
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                        </a>                              
                                                                        </div>
                                                                    </td>
                                                                    </tr>
                                                                    <tr class="accordion-toggle collapsed" id="c-3954" data-toggle="collapse" data-parent="#c-3954" href="#collap-3954">
                                                                    <td>{{ $regions[1] }}</td>
                                                                    <td id="encour_nordouest">{{ $encour_nordouest < 10 ? 0 ."". $encour_nordouest : $encour_nordouest }}</td>
                                                                    <td id="annule_nordouest">{{ $annule_nordouest < 10 ? 0 ."". $annule_nordouest : $annule_nordouest }}</td>
                                                                    <td id="cloture_nordouest">{{ $cloture_nordouest < 10 ? 0 ."". $cloture_nordouest : $cloture_nordouest }}</td>
                                                                    <td id="enretard_nordouest">{{ $enretard_nordouest < 10 ? 0 ."". $enretard_nordouest : $enretard_nordouest }}</td>
                                                                    <td id="total_nordouest">{{ $nord_ouest < 10 ? 0 ."". $nord_ouest : $nord_ouest}}</td>
                                                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <span class="text-muted sr-only">Action</span>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                        <a 
                                                                            id="incident_nordouest"
                                                                            data-nordouest="{{ json_encode($inc_nord_ouest) }}"
                                                                            class="dropdown-item" 
                                                                            href="#!"
                                                                            data-backdrop="static"
                                                                            data-keyboard="false" 
                                                                            data-toggle="modal" 
                                                                            data-target="#modal_liste_incident"><span class="fe fe-eye mr-2"></span> Incident(s) Nord-Ouest</a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-x mr-4"></span>Supprimer
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                        </a>                              
                                                                        </div>
                                                                    </td>
                                                                    </tr>
                                                                    <tr id="collap-3954" class="collapse in p-3 bg-light">
                                                                    <tr class="accordion-toggle collapsed" id="c-2429" data-toggle="collapse" data-parent="#c-2429" href="#collap-2429">
                                                                    <td>{{ $regions[2] }}</td>
                                                                    <td id="encour_sudouest">{{ $encour_sudouest < 10 ? 0 ."". $encour_sudouest : $encour_sudouest }}</td>
                                                                    <td id="annule_sudouest">{{ $annule_sudouest < 10 ? 0 ."". $annule_sudouest : $annule_sudouest}}</td>
                                                                    <td id="cloture_sudouest">{{ $cloture_sudouest < 10 ? 0 ."". $cloture_sudouest : $cloture_sudouest}}</td>
                                                                    <td id="enretard_sudouest">{{ $enretard_sudouest < 10 ? 0 ."". $enretard_sudouest : $enretard_sudouest}}</td>
                                                                    <td id="total_sudouest">{{ $sud_ouest < 10 ? 0 ."". $sud_ouest : $sud_ouest }}</td>
                                                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <span class="text-muted sr-only">Action</span>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                        <a 
                                                                            id="incident_sudouest"
                                                                            data-sudouest="{{ json_encode($inc_sud_ouest) }}"
                                                                            class="dropdown-item" 
                                                                            href="#!"
                                                                            data-backdrop="static"
                                                                            data-keyboard="false" 
                                                                            data-toggle="modal" 
                                                                            data-target="#modal_liste_incident">
                                                                            <span class="fe fe-eye mr-2"></span> Incident(s) Sud-Ouest
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-x mr-4"></span>Supprimer
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                        </a>                              
                                                                        </div>
                                                                    </td>
                                                                    </tr>
                                                                    <tr class="accordion-toggle collapsed" id="c-3987" data-toggle="collapse" data-parent="#c-3987" href="#collap-3987">
                                                                    <td>{{ $regions[3] }}</td>
                                                                    <td id="encour_centre">{{ $encour_centre < 10 ? 0 ."". $encour_centre : $encour_centre }}</td>
                                                                    <td id="annule_centre">{{ $annule_centre < 10 ? 0 ."". $annule_centre : $annule_centre }}</td>
                                                                    <td id="cloture_centre">{{ $cloture_centre < 10 ? 0 ."". $cloture_centre : $cloture_centre}}</td>
                                                                    <td id="enretard_centre">{{ $enretard_centre < 10 ? 0 ."". $enretard_centre : $enretard_centre}}</td>
                                                                    <td id="total_centre">{{ $centre < 10 ? 0 ."". $centre : $centre }}</td>
                                                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <span class="text-muted sr-only">Action</span>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                        <a 
                                                                            id="incident_centre"
                                                                            data-centre="{{ json_encode($inc_centre) }}"
                                                                            class="dropdown-item" 
                                                                            href="#!"
                                                                            data-backdrop="static"
                                                                            data-keyboard="false" 
                                                                            data-toggle="modal" 
                                                                            data-target="#modal_liste_incident"><span class="fe fe-eye mr-2"></span> Incident(s) Centre</a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-x mr-4"></span>Supprimer
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                        </a>                              
                                                                        </div>
                                                                    </td>
                                                                    </tr>
                                                                    <tr class="accordion-toggle collapsed" id="c-3165" data-toggle="collapse" data-parent="#c-3987" href="#collap-3165">
                                                                    <td>{{ $regions[4] }}</td>
                                                                    <td id="encour_littoral">{{ $encour_littoral < 10 ? 0 ."". $encour_littoral : $encour_littoral}}</td>
                                                                    <td id="annule_littoral">{{ $annule_littoral < 10 ? 0 ."". $annule_littoral : $annule_littoral}}</td>
                                                                    <td id="cloture_littoral">{{ $cloture_littoral < 10 ? 0 ."". $cloture_littoral : $cloture_littoral}}</td>
                                                                    <td id="enretard_littoral">{{ $enretard_littoral < 10 ? 0 ."". $enretard_littoral : $enretard_littoral}}</td>
                                                                    <td id="total_littoral">{{ $littoral < 10 ? 0 ."". $littoral : $littoral }}</td>
                                                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <span class="text-muted sr-only">Action</span>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                        <a 
                                                                            id="incident_littoral"
                                                                            data-littoral="{{ json_encode($inc_littoral) }}"
                                                                            class="dropdown-item" 
                                                                            href="#!"
                                                                            data-backdrop="static"
                                                                            data-keyboard="false" 
                                                                            data-toggle="modal" 
                                                                            data-target="#modal_liste_incident">
                                                                            <span class="fe fe-eye mr-2"></span> Incident(s) Littoral
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-x mr-4"></span>Supprimer
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                        </a>                              
                                                                        </div>
                                                                    </td>
                                                                    </tr>
                                                                    <tr class="accordion-toggle collapsed" id="c-5429" data-toggle="collapse" data-parent="#c-5429" href="#collap-5429">
                                                                    <td>{{ $regions[5] }}</td>
                                                                    <td id="encour_extremenord">{{ $encour_extremenord < 10 ? 0 ."". $encour_extremenord : $encour_extremenord}}</td>
                                                                    <td id="annule_extremenord">{{ $annule_extremenord < 10 ? 0 ."". $annule_extremenord : $annule_extremenord}}</td>
                                                                    <td id="cloture_extremenord">{{ $cloture_extremenord < 10 ? 0 ."". $cloture_extremenord : $cloture_extremenord}}</td>
                                                                    <td id="enretard_extremenord">{{ $enretard_extremenord < 10 ? 0 ."". $enretard_extremenord : $enretard_extremenord}}</td>
                                                                    <td id="total_extremenord">{{ $extreme_nord < 10 ? 0 ."". $extreme_nord : $extreme_nord }}</td>
                                                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <span class="text-muted sr-only">Action</span>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                        <a 
                                                                            id="incident_extremenord"
                                                                            data-extremenord="{{ json_encode($inc_extreme_nord) }}"
                                                                            class="dropdown-item" 
                                                                            href="#!"
                                                                            data-backdrop="static"
                                                                            data-keyboard="false" 
                                                                            data-toggle="modal" 
                                                                            data-target="#modal_liste_incident">
                                                                            <span class="fe fe-eye mr-2"></span> Incident(s) Extreme-Nord
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-x mr-4"></span>Supprimer
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                        </a>                              
                                                                        </div>
                                                                    </td>
                                                                    </tr>
                                                                    <tr class="accordion-toggle collapsed" id="c-3951" data-toggle="collapse" data-parent="#c-3951" href="#collap-3951">
                                                                    <td>{{ $regions[6] }}</td>
                                                                    <td id="encour_sud">{{ $encour_sud < 10 ? 0 ."". $encour_sud : $encour_sud}}</td>
                                                                    <td id="annule_sud">{{ $annule_sud < 10 ? 0 ."". $annule_sud : $annule_sud}}</td>
                                                                    <td id="cloture_sud">{{ $cloture_sud < 10 ? 0 ."". $cloture_sud : $cloture_sud}}</td>
                                                                    <td id="enretard_sud">{{ $enretard_sud < 10 ? 0 ."". $enretard_sud : $enretard_sud}}</td>
                                                                    <td id="total_sud">{{ $sud < 10 ? 0 ."". $sud : $sud }}</td>
                                                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <span class="text-muted sr-only">Action</span>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                        <a 
                                                                            id="incident_sud"
                                                                            data-sud="{{ json_encode($inc_sud) }}"
                                                                            class="dropdown-item" 
                                                                            href="#!"
                                                                            data-backdrop="static"
                                                                            data-keyboard="false" 
                                                                            data-toggle="modal" 
                                                                            data-target="#modal_liste_incident">
                                                                            <span class="fe fe-eye mr-2"></span> Incident(s) Sud
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-x mr-4"></span>Supprimer
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                        </a>                              
                                                                        </div>
                                                                    </td>
                                                                    </tr>
                                                                    <tr class="accordion-toggle collapsed" id="c-3599" data-toggle="collapse" data-parent="#c-3599" href="#collap-3599">
                                                                    <td>{{ $regions[7] }}</td>
                                                                    <td id="encour_nord">{{ $encour_nord < 10 ? 0 ."". $encour_nord : $encour_nord}}</td>
                                                                    <td id="annule_nord">{{ $annule_nord < 10 ? 0 ."". $annule_nord : $annule_nord}}</td>
                                                                    <td id="cloture_nord">{{ $cloture_nord < 10 ? 0 ."". $cloture_nord : $cloture_nord}}</td>
                                                                    <td id="enretard_nord">{{ $enretard_nord < 10 ? 0 ."". $enretard_nord : $enretard_nord}}</td>
                                                                    <td id="total_nord">{{ $nord < 10 ? 0 ."". $nord : $nord }}</td>
                                                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <span class="text-muted sr-only">Action</span>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                        <a 
                                                                            id="incident_nord"
                                                                            data-nord="{{ json_encode($inc_nord) }}"
                                                                            class="dropdown-item" 
                                                                            href="#!"
                                                                            data-backdrop="static"
                                                                            data-keyboard="false" 
                                                                            data-toggle="modal" 
                                                                            data-target="#modal_liste_incident">
                                                                            <span class="fe fe-eye mr-2"></span> Incident(s) Nord
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-x mr-4"></span>Supprimer
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                        </a>                              
                                                                        </div>
                                                                    </td>
                                                                    </tr>
                                                                    <tr class="accordion-toggle collapsed" id="c-3599" data-toggle="collapse" data-parent="#c-3599" href="#collap-3599">
                                                                    <td>{{ $regions[8] }}</td>
                                                                    <td id="encour_adamaoua">{{ $encour_adamaoua < 10 ? 0 ."". $encour_adamaoua : $encour_adamaoua }}</td>
                                                                    <td id="annule_adamaoua">{{ $annule_adamaoua < 10 ? 0 ."". $annule_adamaoua : $annule_adamaoua}}</td>
                                                                    <td id="cloture_adamaoua">{{ $cloture_adamaoua < 10 ? 0 ."". $cloture_adamaoua : $cloture_adamaoua}}</td>
                                                                    <td id="enretard_adamaoua">{{ $enretard_adamaoua < 10 ? 0 ."". $enretard_adamaoua : $enretard_adamaoua}}</td>
                                                                    <td id="total_adamaoua">{{ $adamaoua < 10 ? 0 ."". $adamaoua : $adamaoua }}</td>
                                                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <span class="text-muted sr-only">Action</span>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                        <a 
                                                                            id="incident_adamaoua"
                                                                            data-adamaoua="{{ json_encode($inc_adamaoua) }}"
                                                                            class="dropdown-item" 
                                                                            href="#!"
                                                                            data-backdrop="static"
                                                                            data-keyboard="false" 
                                                                            data-toggle="modal" 
                                                                            data-target="#modal_liste_incident">
                                                                            <span class="fe fe-eye mr-2"></span> Incident(s) Adamaoua
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-x mr-4"></span>Supprimer
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                        </a>                              
                                                                        </div>
                                                                    </td>
                                                                    </tr>
                                                                    <tr class="accordion-toggle collapsed" id="c-3599" data-toggle="collapse" data-parent="#c-3599" href="#collap-3599">
                                                                    <td>{{ $regions[9] }}</td>
                                                                    <td id="encour_est">{{ $encour_est < 10 ? 0 ."". $encour_est : $encour_est}}</td>
                                                                    <td id="annule_est">{{ $annule_est < 10 ? 0 ."". $annule_est : $annule_est }}</td>
                                                                    <td id="cloture_est">{{ $cloture_est < 10 ? 0 ."". $cloture_est : $cloture_est }}</td>
                                                                    <td id="enretard_est">{{ $enretard_est < 10 ? 0 ."". $enretard_est :  $enretard_est}}</td>
                                                                    <td id="total_est">{{ $est < 10 ? 0 ."". $est : $est }}</td>
                                                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <span class="text-muted sr-only">Action</span>
                                                                        </button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                        <a 
                                                                            id="incident_est"
                                                                            data-est="{{ json_encode($inc_est) }}"
                                                                            class="dropdown-item" 
                                                                            href="#!"
                                                                            data-backdrop="static"
                                                                            data-keyboard="false" 
                                                                            data-toggle="modal" 
                                                                            data-target="#modal_liste_incident">
                                                                            <span class="fe fe-eye mr-2"></span> Incident(s) Est
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-x mr-4"></span>Supprimer
                                                                        </a>
                                                                        <a class="dropdown-item" href="#!">
                                                                            <span class="fe fe-edit-2 mr-4"></span>Editer
                                                                        </a>                              
                                                                        </div>
                                                                    </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        </div>
                                                    </div>
                                        </div> <!-- end section -->

                                    </div>
                                </div>
                            </div> <!-- simple table -->
                        </div> <!-- end section -->
                </div>
            </div> <!-- .row -->
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
    </div> <!-- small modal --></div>


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

    <script src="{{ url('tableau.js') }}"></script>

@endsection
