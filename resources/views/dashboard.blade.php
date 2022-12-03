@extends('layouts.main')

@section('content')
    <!-- Begin Page Content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                <div class="row align-items-center mb-2">
                    <div class="col">
                    <h2 class="h5 text-xl my-4">
                        <span class="fe fe-trending-up fe-32 mr-2"></span>
                        Etat Statistique
                    </h2>
                    </div>
                </div>
                    <!-- <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-3 text-center">
                            <span class="circle circle-sm bg-primary">
                                <i class="fe fe-16 fe-shopping-cart text-white mb-0"></i>
                            </span>
                            </div>
                            <div class="col pr-0">
                            <p class="small text-muted mb-0">Orders</p>
                            <span class="h3 mb-0">1,869</span>
                            <span class="small text-success">+16.5%</span>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div> -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-4">
                            <div class="card shadow">
                                <div class="card-header">
                                <span class="card-title">Incident(s) Déclaré(s) Aujourd'huit</span>
                                <a class="float-right small text-muted" href="#!"><i class="fe fe-more-vertical fe-12"></i></a>
                                </div>
                                <div class="card-body my-n2">
                                <div class="d-flex">
                                    <div class="flex-fill">
                                    <h4 class="mb-0">{{ $nombre_incident_save_today }}</h4>
                                    </div>
                                    <div class="flex-fill text-right">
                                    <p class="mb-0 small"></p>
                                    <p class="text-muted mb-0 small"><span class="fe fe-bell fe-16"></span></p>
                                    </div>
                                </div>
                                </div> <!-- .card-body -->
                            </div> <!-- .card -->
                        </div> <!-- .col -->

                        <div class="col-md-6 mb-4">
                            <div class="card shadow">
                                <div class="card-header">
                                <span class="card-title">Incident(s) Cloturé(s) Aujourd'huit</span>
                                <a class="float-right small text-muted" href="#!"><i class="fe fe-more-vertical fe-12"></i></a>
                                </div>
                                <div class="card-body my-n2">
                                <div class="d-flex">
                                    <div class="flex-fill">
                                    <h4 class="mb-0">{{ $nombre_incident_cloturer_today }}</h4>
                                    </div>
                                    <div class="flex-fill text-right">
                                    <p class="mb-0 small"></p>
                                    <p class="text-muted mb-0 small"><span class="fe fe-bell fe-16"></span></p>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                                <select 
                                        class="custom-select" 
                                        id="annee_total"
                                        data-incidents="{{ $incidents }}"
                                        data-departements="{{ $departements }}">
                                    <option selected value="">Choisissez Une Année.....</option>
                                    @foreach($years as $annee)
                                        <option value="{{ $annee }}">{{ $annee }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"> Please select a valid state. </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card shadow">
                                <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col">
                                    <span class="h2 my-4 mb-0" id="tot">{{count($incident_annee_encour)}}</span>
                                    <p class="small text-muted mb-0">Nombre D'Incidents Total</p>
                                    <!-- <span class="badge badge-pill badge-warning">+1.5%</span> -->
                                    </div>
                                    <div class="col-auto">
                                    <span class="fe fe-32 fe-bell text-muted mb-0"></span>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <hr class="my-4">

                <!-- <div class="row">
                    <div class="col-md-3 mb-3">
                            <select class="custom-select" id="cello">
                                <option selected value="">Choisissez Un Département.....</option>
                                @foreach($departements as $depatement)
                                    <option value="{{ $depatement->id }}">{{ $depatement->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"> Please select a valid state. </div>
                    </div>
                </div> -->
                
                <div class="row">
                  @foreach($departements as $key => $departement)

                    <div id="moncard" class="card shadow my-3 ml-3">
                        <div class="card-body">
                            <div class="py-5 text-center">
                                <p class="text-muted mb-4"><span>{{ $departement->name }}</span></p>
                                <h2 class="mb-1">Nombre D'incidents En Instance</h2>
                                <span id="instances{{$key}}" style="font-size: 2em;" class="small text-white">{{ $incident_instances[$key] }}</span>
                            </div>
                            <div class="progress rounded" style="height:16px;">
                                <div class="progress-bar text-xl text-left" role="progressbar" style="width: 20%; background-color: #343A40;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"><span id="ko{{$key}}">{{ $clotures[$key] }}</span></div>
                                <!-- <div class="progress-bar text-lg" role="progressbar" style="width: 50%; background-color: #343A40;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">0</div> -->
                                <div class="progress-bar text-xl text-right" role="progressbar" style="width: 70%; background-color: #343A40;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"><span id="del">{{ $annuler[$key] }}</span></div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-auto">
                                    <div class="my-2 text-center">
                                        <small class="text-success text-left mr-2">CLÔTURÉ</small>
                                        <!-- <small class="text-warning mx-2">EN-RÉSOLUTION</small> -->
                                        <small style="margin-left:8em;" class="text-danger text-right">ANNULÉ</small>
                                    </div>
                                </div>
                            </div>
                            <div class="progress rounded mb-3" style="height:14px">
                                <!-- <div class="progress-bar bg-success" role="progressbar" style="width: 20%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">0%</div>
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">0%</div>
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">0%</div> -->
                            </div>
                        </div>
                    </div>
                  @endforeach
                </div>
                <hr class="my-4">
                
                <div class="row">
                    <h2 class="my-2">INCIDENT CRITIQUE</h2>
                    @foreach($incident_critiques as $inci)
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow bg-danger text-white">
                            <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-3 text-center">
                                <span class="text-xl">
                                    <i class="fe fe-32 fe-bell text-white mb-0"></i>
                                </span>
                                </div>
                                <div class="col pr-0">
                                <!--circle circle-sm bg-primary-light <p class="small text-light mb-0">Monthly Sales</p> -->
                                <span class="h3 mb-0 text-white">{{ $inci->number }}</span>
                                <!-- <span class="small text-muted">+5.5%</span> -->
                                </div>
                                <div class="col-3 text-center">
                                    <a 
                                        data-incident="{{ $inci }}"
                                        style="text-decoration:none;" 
                                        title="Voir Informations Supplémentaires"
                                        data-backdrop="static"
                                        data-keyboard="false" 
                                        data-toggle="modal" 
                                        data-target="#modal_infos_incidant"
                                        href="#">
                                        <span class="circle circle-sm bg-primary-light">
                                        <i class="fe fe-16 fe-eye fe-32 text-white mb-0"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-md-3 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="py-5 text-center">
                                        <p class="text-muted text-uppercase mb-4">Départements</p>
                                        <span class="small text-white" style="font-size:2em;">{{ count($departements) }}</span>
                                    </div>
                                    <div class="row align-items-center mb-1">
                                        <div class="col text-center">
                                            <small class="fe fe-home fe-32 text-success"></small>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- .card-body -->
                    </div> <!-- .card -->

                    <div class="col-md-3 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="py-5 text-center">
                                        <p class="text-muted text-uppercase mb-4">Catégories</p>
                                        <span class="small text-white" style="font-size:2em;">{{ count($categories) }}</span>
                                    </div>
                                    <div class="row align-items-center mb-1">
                                        <div class="col text-center">
                                            <small class="fe fe-aperture fe-32 text-success"></small>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- .card-body -->
                    </div> <!-- .card -->

                    <div class="col-md-3 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="py-5 text-center">
                                        <p class="text-muted text-uppercase mb-4">Procéssus</p>
                                        <span class="small text-white" style="font-size:2em;">{{ count($processus) }}</span>
                                    </div>
                                    <div class="row align-items-center mb-1">
                                        <div class="col text-center">
                                            <small class="fe fe-cpu fe-32 text-success"></small>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- .card-body -->
                    </div> <!-- .card -->
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
                                            </div> <!-- / .list-group -->
                                            </div> <!-- / .card-body -->
                                        </div> <!-- / .card -->
                          </div>
                        </div>
    </div> <!-- small modal -->

    <script src="{{ url('dashboard.js') }}"></script>

@endsection