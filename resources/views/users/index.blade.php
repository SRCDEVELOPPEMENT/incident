@extends('layouts.main')


@section('content')


    <!-- Begin Page Content -->
    <div class="main-content">
        <div class="container-fluid" style="font-family: 'Century Gothic';">

                        <!-- Page Heading -->

                        <div class="row my-4"> 
                                <div class="col-md-6 text-left text-xl">
                                    <h1 class="mb-2">
                                        <span class="fe fe-info mr-2"></span>    
                                        Liste Des Utilisateurs De L'application
                                    </h1>
                                </div>
                                <div class="col-md-6 text-right">
                                    @can('creer-utilisateur')
                                        <button 
                                                type="button" 
                                                data-toggle="modal" 
                                                data-target="#modalUser" 
                                                data-backdrop="static" 
                                                data-keyboard="false" 
                                                class="btn btn-icon-split"
                                                style="background-color: #345B86;">
                                                    <span class="icon text-white-80">
                                                        <i class="fe fe-user-plus"></i>
                                                    </span>
                                                    <span class="text">Ajout Compte Utilisateur</span>
                                        </button>
                                    @endcan
                                </div>
                        </div>

                            <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <table class="table datatables" id="dataTable-1">
                                            <thead class="bg-dark text-white">
                                                <tr>
                                                    <th>Nom Utilisateur</th>
                                                    <th>NOM</th>
                                                    <th>DEPARTEMENT</th>
                                                    <th>ROLE</th>
                                                    <th>ACTIONS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach($utilisateurs as $user)
                                                        <tr style="font-size:15px;">
                                                            <td><label>{{ $user->login }}</label></span></td>
                                                            <td><label>{{ $user->fullname }}</label></span></td>
                                                            <td><label>{{ $user->departements != NULL ? $user->departements->name : '' }}</label></td>
                                                            <td>
                                                                @if(!empty($user->getRoleNames()))
                                                                @foreach($user->getRoleNames() as $v)
                                                                    <label style="font-size:1.1em;" class="badge badge-success">{{ $v }}</label>
                                                                @endforeach
                                                                @endif
                                                            </td>                                                      
                                                            <td>
                                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <span class="text-muted sr-only">Action</span>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    @can('editer-utilisateur')
                                                                        <a 
                                                                            class="dropdown-item" 
                                                                            id="btnEdit" 
                                                                            data-user="{{ $user }}"
                                                                            data-password="{{ $user->password }}"
                                                                            data-toggle="modal" 
                                                                            data-target="#modalEditUser" 
                                                                            data-backdrop="static"
                                                                            data-keyboard="false">
                                                                            Editer
                                                                        </a>
                                                                    @endcan

                                                                    @can('supprimer-utilisateur')
                                                                        <a
                                                                            class="dropdown-item" 
                                                                            href="#"
                                                                            id="btnDelete" 
                                                                            data-fullname="{{ $user->fullname }}" 
                                                                            data-id="{{ $user->id }}">
                                                                            Supprimer
                                                                        </a>
                                                                    @endcan

                                                                    @can('voir-utilisateur')
                                                                        <a
                                                                            class="dropdown-item" 
                                                                            href="#"
                                                                            data-toggle="modal" 
                                                                            data-target="#viewUser"
                                                                            data-backdrop="static" 
                                                                            data-keyboard="false"
                                                                            id="btnViewUser"
                                                                            data-password="{{ $user->password }}"
                                                                            data-fullname="{{ $user->fullname }}"  
                                                                            data-user="{{ $user }}">
                                                                            Voir
                                                                        </a>
                                                                    @endcan
                                                                </div>
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                            </tbody>
                                </table>
                            </div>
                        </div>

        </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Modal Add User -->
    <div style="font-family: Century Gothic;" class="modal"  id="modalUser" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header  bg-dark text-white">
                <h5 class="text-xl">
                    <span class="icon text-white-80">
                            <i class="fe fe-user-plus mr-2"></i>
                    </span>
                    Ajout Compte Utilisateur
                </h5>
                <button type="button" id="btnCloseAddUser" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="card shadow col-xs-12">
                        <div class="card-body">
                            <form id="userFormInsert" autocomplete="off">
                            {{ csrf_field() }}
                                @csrf
                                                        <div class="form-group">
                                                            <input type="hidden" name="id">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for=""><i class="fe fe-user mr-2"></i> Nom Complèt <span style="color:red;"> *</span></label>
                                                            <input style="font-size:15px;" type="text" class="form-control"
                                                                id="fullname" name="fullname">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for=""><i class="fe fe-map mr-2"></i> Département <span style="color:red;"> *</span></label>
                                                            <select style="font-size:15px;" class="custom-select" id="departement_id" name="departement_id">
                                                                    <option selected value="">Choisissez...</option>
                                                                    @foreach($departements as $departement)
                                                                    <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                            <div class="form-group">
                                                                <label for=""><i class="fe fe-log-in mr-2"></i> Nom Utilisateur <span style="color:red;"> *</span></label>
                                                                <input style="font-size:15px;" type="text" class="form-control form-control-user"
                                                                    id="login" name="login">
                                                            </div>
                                                        
                                                            <div class="form-group">
                                                                <label for=""><i class="fe fe-key mr-2"></i>Mot De Passe <span style="color:red;"> *</span></label>
                                                                <input style="font-size:15px;" type="password" placeholder="************" class="form-control"
                                                                    id="password" name="password">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><i class="fe fe-key mr-2"></i>Confirmez Mot De Passe...<span style="color:red;"> *</span></label>
                                                                <input style="font-size:15px;" type="password" placeholder="************" class="form-control"
                                                                    id="confirm-password" name="confirm-password" placeholder="Confirmer Mot De Passe">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><i class="fe fe-lock mr-2"></i>Rôle <span style="color:red;"> *</span></label>
                                                                <select style="font-size:15px;" class="custom-select" id="role" name="roles">
                                                                    <option selected value="">Choisissez...</option>
                                                                    @foreach($roles as $role)
                                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        <hr class="my-2">
                                                        <div class="row">
                                                            <div class="col-md-6 text-left">
                                                                <button type="button" id="btnAddUser" class="btn btn-block btn-primary">
                                                                    <i class="fe fe-user-check mr-2"></i>
                                                                    Enrégistrer
                                                                </button>
                                                            </div>
                                                            <div class="col-md-6 text-right">
                                                                <button type="button" id="btnExitAddForm" class="btn btn-block btn-danger">
                                                                    <i class="fe fe-user-x mr-2"></i>
                                                                    Annuler
                                                                </button>
                                                            </div>
                                                        </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div style="font-family: Century Gothic;" class="modal"  id="modalEditUser" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header  bg-dark text-white">
                <h5 class="text-xl">
                    <span class="icon text-white-80">
                            <i class="fe fe-user-minus mr-3"></i>
                    </span>
                    Edition Compte Utilisateur
                </h5>
                <button type="button" id="btnClose" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="card shadow col-xs-12">
                            <div class="card-body">
                                <form id="userFormEdit" autocomplete="off">
                                {{ csrf_field() }}
                                    @csrf
                                    @method('PUT')
                                                            <div class="form-group">
                                                                <input id="idEditUser" type="hidden" name="id">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><i class="fe fe-user mr-2"></i>Nom Complèt<span style="color:red;"> *</span></label>
                                                                <input style="font-size:15px;" type="text" class="form-control"
                                                                    id="fullnames" name="fullname">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="departement_ids"><i class="fe fe-map mr-2"></i>Département<span style="color:red;"> *</span></label>
                                                                <select style="font-size:15px;" class="custom-select" id="departement_ids" name="departement_id">
                                                                        <option selected value="">Choisissez...</option>
                                                                        @foreach($departements as $departement)
                                                                        <option value="{{ $departement->id }}">{{ $departement->name }}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                                <div class="form-group">
                                                                    <label for="logins"><i class="fe fe-log-in mr-2"></i>Nom Utilisateur<span style="color:red;"> *</span></label>
                                                                    <input style="font-size:15px;" type="text" class="form-control form-control-user"
                                                                        id="logins" name="login">
                                                                </div>
                                                            
                                                                <div class="form-group">
                                                                    <label for="passwords"><i class="fe fe-key mr-2"></i>Mot De Passe<span style="color:red;"> *</span></label>
                                                                    <input style="font-size:15px;" placeholder="************" type="password" class="form-control form-control-lg"
                                                                        id="passwords" name="password">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="confirm-passwords"><i class="fe fe-key mr-2"></i>Confirmez Mot De Passe<span style="color:red;"> *</span></label>
                                                                    <input style="font-size:15px;" placeholder="************" type="password" class="form-control"
                                                                        id="confirm-passwords" name="confirm-password" placeholder="Confirmer Mot De Passe">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="roles"><i class="fe fe-lock mr-2"></i> Rôle <span style="color:red;"> *</span></label>
                                                                    <select style="font-size:15px;" class="custom-select" id="roles" name="roles">
                                                                        <option selected value="">Choisissez...</option>
                                                                        @foreach($roles as $role)
                                                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="text-left col-md-6">
                                                                    <button type="button" id="btnEditUser" class="btn btn-block btn-primary">
                                                                        <i class="fe fe-user-minus mr-2"></i>
                                                                        Modifier
                                                                    </button>
                                                                </div>
                                                                <div class="text-right col-md-6">
                                                                    <button type="button" id="btnExitEditUser" class="btn btn-block btn-danger">
                                                                        <i class="fe fe-user-x mr-2"></i>
                                                                        Annuler
                                                                    </button>
                                                                </div>
                                                            </div>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Confirmation Save USER -->
    <div class="modal fade" id="modalconfirm_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                    <i class="fas fa-check fa-lg mr-3"></i>    
                                    Confirmez-Vous Ces Informations ?</h5>
                                </div>
                                <div class="modal-body">
                                                        <table class="table table-bordered mb-2">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-signature mr-2"></i>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    NOM</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                    <span style="color: black; font-size: 15px;" id="fullname_conf"></span>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-sign-in-alt mr-2"></i>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    NOM UTILISATEUR</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 15px;" id="username_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-sign-in-alt mr-2"></i>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    MOT DE PASSE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 15px;" id="pass_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-user-lock mr-2"></i>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    ROLE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 15px;" id="role_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            <tbody>
                                                        </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="conf_save_user" data-utilisateurs="{{ $utilisateurs }}" class="btn btn-primary">OUI</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NON</button>
                                </div>
                            </div>
                        </div>
    </div>

    <!-- Modal View User -->
    <div class="modal" id="viewUser" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header bg-dark text-white">
                                      <h5 class="modal-title" id="exampleModalLabel" style="color:#FFFFFF;font-weight: bold;">
                                      <i class="fas fa-info fa-lg mr-3"></i>
                                      Informations Utilisateur  <span class="badge badge-success" id="use_name"></span></h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="row" id="ui">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-content collapse show">
                                                        <div class="table-responsive">
                                                            <table class="table table-responsive table-bordered mb-0 text-white">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                        <span>
                                                                        NOM
                                                                        </span>
                                                                        </td>
                                                                        <td>
                                                                                <div class="form-group">
                                                                                      <input style="background-color:#343A40; border-style: none; font-weight:bolder;" disabled type="text" id="name_user">
                                                                                </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <span>NOM UTILISATEUR</span>
                                                                        </td>
                                                                        <td>
                                                                              <div class="form-group">
                                                                                      <input style="background-color:#343A40; border-style: none; font-weight:bolder;" disabled type="text" id="username">
                                                                                </div>
                                                                      </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <span>MOT DE PASSE</span>
                                                                        </td>
                                                                        <td>
                                                                              <div class="form-group">
                                                                              <textarea style="background-color:#343A40; border-style: none; font-weight:bolder;" id="password_user" disabled rows="4" cols="30"></textarea>
                                                                                </div>
                                                                      </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <span>ROLE</span>
                                                                        </td>
                                                                        <td>
                                                                              <div class="form-group">
                                                                                    <textarea style="background-color:#343A40; border-style: none; font-weight:bolder;" id="role_user" disabled rows="3" cols="20"></textarea>
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
                                </div>
    </div>

    <!-- Modal error validation-->
    <div style="font-family: Century Gothic;" class="modal" id="errorvalidationsModals" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation" disabled style="width:100%;border-style:none;height:250px;background-color:#495057;resize: none; color:white; font-size:19px;" class="form-control"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_user" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal error validation-->
    <div style="font-family: Century Gothic;" class="modal" id="error_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation_edit" disabled style="width:100%;border-style:none;height:250px;background-color:#495057;resize: none; color:white; font-size:19px;" class="form-control"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_user_edit" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <script src="{{ url('users.js') }}"></script>

@endsection