@extends('layouts.main')

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row mb-4" style="font-family: Century Gothic;">
                        <a title="Retour A La Liste Des Incidents" href="{{ URL::to('incidents') }}" style="border-radius: 3em;" class="btn btn-outline-primary"><span class="fe fe-corner-up-left fe-16 mr-2"></span><span class="text">Retour</span></a>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-left text-xl">
                            <h2 class="mb-2"><span class="fe fe-info mr-2"></span> Liste Des Utilisateurs Assigner A Cet Incident</h2>
                        </div>
                        <div class="col-md-6 text-right">
                                <button 
                                    data-backdrop="static"
                                    data-keyboard="false"
                                    data-toggle="modal" 
                                    data-target="#assign_incident"
                                    title="Assignation D'un Utilisateur A Un Incident" 
                                    style="background-color: #345B86;" 
                                    class="btn btn-icon-split"
                                    >
                                    <span class="icon text-white-80">
                                        <i class="fe fe-corner-down-right" style="font-size:15px;"></i>
                                        <i class="fe fe-lg fe-user mr-3"></i>
                                    </span>
                                    Assigner Un Utilisateur
                                </button>
                        </div>
                    </div>

                        <div class="row my-4">
                                <!-- Small table -->
                                @foreach($users as $user)
                                                <div class="card shadow mb-4 ml-4">
                                                    <div class="card-body text-center">
                                                        <div class="avatar avatar-lg mt-4 d-flex justify-content-center align-items-center">
                                                            <a href="">
                                                            <img src="./assets/avatars/tof.png" alt="..." class="avatar-img rounded-circle">
                                                            </a>
                                                        </div>
                                                        <div class="card-text my-4">
                                                            <strong class="card-title my-0">{{ $user->fullname }}</strong>
                                                            <!-- <p class="small text-muted mb-0">Accumsan Consulting</p>
                                                            <p class="small"><span class="badge badge-light text-muted">New York, USA</span></p> -->
                                                        </div>
                                                        </div> <!-- ./card-text -->
                                                        <div class="card-footer">
                                                        <div class="row align-items-center justify-content-between">
                                                            <div class="col-auto">
                                                                <a href="#" style="text-decoration:none;font-size:18px; color:red;">
                                                                    <small>
                                                                        <span class="fe fe-x mr-1 ml-3"></span> Revoquer L'incident
                                                                    </small>
                                                                </a>
                                                            </div>
                                                            <!-- <div class="col-auto">
                                                                <div class="file-action">
                                                                    <button type="button" class="btn btn-link dropdown-toggle more-vertical p-0 text-muted mx-auto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <span class="text-muted sr-only">Action</span>
                                                                    </button>
                                                                    <div class="dropdown-menu m-2">
                                                                        <a class="dropdown-item" href="#"><i class="fe fe-meh fe-12 mr-4"></i>Profile</a>
                                                                        <a class="dropdown-item" href="#"><i class="fe fe-message-circle fe-12 mr-4"></i>Chat</a>
                                                                        <a class="dropdown-item" href="#"><i class="fe fe-mail fe-12 mr-4"></i>Contact</a>
                                                                        <a class="dropdown-item" href="#"><i class="fe fe-delete fe-12 mr-4"></i>Delete</a>
                                                                    </div>
                                                                </div>
                                                            </div> -->
                                                        </div>
                                                    </div> <!-- /.card-footer -->
                                                </div>
                                @endforeach
                        </div>
                </div>
            </div> <!-- .row -->
        </div>
    </div>

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
                                            <select class="custom-select" name="users_s" id="users_s" required>
                                                <option selected value="">Choisissez...</option>
                                                @foreach($utilisateurs as $user)
                                                <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row col-md-12 mt-4">
                                            <button name="chanceux" data-incident_number="{{ $number }}" id="insert_assign" class="btn btn-sm btn-outline-success btn-block ml-3">
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

    <script src="{{ url('users_incidents.js') }}"></script>

@endsection