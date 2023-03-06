@extends('layouts.main')

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row" style="font-family: Century Gothic;">
                        <div class="col-md-7 text-left my-4">
                            <a title="Retour A La Liste Des Incidents" href="{{ URL::to('incidents') }}" style="border-radius: 3em;" class="btn btn-outline-primary"><span class="fe fe-corner-up-left fe-16 mr-2"></span><span class="text">Retour</span></a>
                        </div>
                        <div class="col-md-5 text-right my-4">
                            <span class="mr-4">NUMERO INCIDENT</span>
                            <span class="badge badge-pill badge-success text-xl">{{ $number }}</span>
                        </div>
                    </div>

                    <div class="row" style="font-family: Century Gothic;">
                        <div class="col-md-12 text-right my-4">
                            <span class="text-uppercase">Description incident</span></br>
                            <span class="text-lg">{{ $lincident_du_number_ci->description }}</span>
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col-md-7 text-left text-xl">
                            <h2 style="font-family: Century Gothic;" class="mb-2"><span class="fe fe-32 fe-info mr-2"></span> Liste Des Départements Ou Site Assignés A Cet Incident</h2>
                        </div>
                        <div class="col-md-5 text-right">
                                <!-- <button 
                                    id="btn_assign_user"
                                    data-backdrop="static"
                                    data-keyboard="false"
                                    data-toggle="modal" 
                                    data-target="#assign_incident"
                                    style="font-family: Century Gothic;"
                                    title="Assignation D'un Utilisateur A Un Incident" 
                                    class="btn btn-icon-split btn-primary"
                                    >
                                    <span class="icon text-white-80">
                                        <i class="fe fe-corner-down-right" style="font-size:15px;"></i>
                                        <i class="fe fe-lg fe-home mr-3"></i>
                                    </span>
                                    Assigner Un Site Ou Un Département
                                </button> -->
                        </div>
                    </div>

                    <div class="row my-4">
                            @if(is_iterable($entiter))
                                @foreach($entiter as $key => $entite)
                                                <div class="card shadow mb-4 ml-4">
                                                    <div class="card-body text-center">
                                                        <div class="avatar avatar-lg mt-4 d-flex justify-content-center align-items-center">
                                                            <a href="#!">
                                                            <img src="./assets/avatars/home.png" alt="..." class="avatar-img rounded-circle">
                                                            </a>
                                                        </div>
                                                        <div class="text-sm my-2 mt-4">
                                                            <span>{{ $entiter_utilisateurs[$key]->fullname }}</span>
                                                        </div>
                                                        <div class="card-text my-4">
                                                            <strong class="card-title my-0">{{ $entite->name }}</strong>
                                                        </div>
                                                        </div>
                                                        <div class="card-footer">
                                                        <div class="row align-items-center justify-content-between">
                                                            <div class="col-auto">
                                                                <a 
                                                                    id="revocation" 
                                                                    class="text-danger text-xl" 
                                                                    data-entite="{{ json_encode($entite) }}"
                                                                    data-entite_utilisateur="{{ json_encode($entiter_utilisateurs[$key]) }}"
                                                                    data-number="{{ $number }}" 
                                                                    href="#!" style="text-decoration:none;">
                                                                    <small>
                                                                        <span style="font-size: 18px;" class="fe fe-x text-danger"></span> Révoquer (Le Département | Le Site)
                                                                    </small>
                                                                </a>
                                                            </div>
                                                            <div class="col-auto">
                                                                    <div class="file-action">
                                                                        <button type="button" class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class="text-muted sr-only">Action</span>
                                                                        </button>

                                                                        <div class="dropdown-menu m-2" style="font-family: Century Gothic;">
                                                                            <a 
                                                                                id="revocation_modification" 
                                                                                data-entite="{{ json_encode($entite) }}"
                                                                                data-entite_utilisateur="{{ json_encode($entiter_utilisateurs[$key]) }}"
                                                                                data-number="{{ $number }}" 
                                                                                class="dropdown-item" href="#!">
                                                                                <i class="fe fe-lock fe-16 mr-2"></i>Révoquer La Modification Des Infos
                                                                            </a>
                                                                            <a class="dropdown-item" href="#!"><i class="fe fe-user fe-16 mr-2"></i>Infos {{ $entiter_utilisateurs[$key]->fullname }}</a>
                                                                            <!-- <a class="dropdown-item" href="#!"><i class="fe fe-home fe-16 mr-2"></i>Infos Département</a> -->
                                                                            <!-- <a class="dropdown-item" href="#"><i class="fe fe-delete fe-12 mr-4"></i>Delete</a> -->
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                @endforeach
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Assignation D'un Incident -->
    <div style="font-family: Century Gothic;" id="assign_incident" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="text-xs">
                                        <i class="fe fe-corner-down-right" style="font-size:22px;"></i>
                                        <i class="fe fe-home mr-3" style="font-size:20px;"></i>
                                    Assignation D'un Département | Site A Un Incident
                                </h5>
                                <button id="close_assine" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card shadow" style="padding:2em;">
                                    <div class="row text-lg my-2">
                                        <div class="col-md-6 text-left"><span>Numéro Incident</span> </div>
                                        <div class="col-md-6 text-right"><strong class="badge badge-success">{{ $number }}</strong></div>
                                    </div>
                                    <div class="my-2">
                                        <div class="form-group my-4">
                                            <label for="users_s">
                                                <span class="fe fe-home fe-16 mr-2"></span>
                                                Département / Site
                                            </label>
                                            <select 
                                                    style="font-size: 1.2em;" 
                                                    data-departements="{{ $departements }}" 
                                                    data-types="{{ $types }}" 
                                                    data-sites="{{ $sites }}" 
                                                    class="custom-select border-success my-4" 
                                                    name="deepartes" 
                                                    id="deepartes" 
                                                    data-number="{{ $number }}" 
                                                    data-users_incidents="{{ $u_incident }}">

                                                <optgroup label="Liste Département">
                                                            <option selected value="">Choisissez...</option>
                                                            @if(is_iterable($departements))
                                                            @foreach($departements as $departement)
                                                            <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                                                            @endforeach
                                                            @endif
                                                </optgroup>
                                                <optgroup label="Liste Type Site">
                                                            @if(is_iterable($types))
                                                            @foreach($types as $type)
                                                            <option value="{{ $type->name }}">{{ $type->name }}</option>
                                                            @endforeach
                                                            @endif
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div id="devdocs"></div>
                                        <div class="form-group">
                                            <button name="chanceux" data-incident_number="{{ $number }}" id="insert_assign" class="btn btn-outline-success btn-block">
                                                <span style="font-size:10px;" class="fe fe-home fe-16"></span>
                                                <span class="fe fe-save fe-16 mr-3"></span>
                                                Assigner Le Département | Site A L'incident
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->

    <!-- Modal error validation Assignation-->
    <div  style="font-family:Century Gothic;" class="modal" id="assi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger">
                                        <h5 class="text-lg" id="exampleModalLabel" style="color:white;">Erreur Assignation</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="texting_elt" disabled style="width:100%; height:4em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="btncros" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <script src="{{ url('users_incidents.js') }}"></script>

@endsection