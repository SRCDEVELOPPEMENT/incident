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
                                                class="btn btn-icon-split btn-primary"
                                                >
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
                                <table class="table table-hover datatables" id="dataTable-1">
                                            <thead class="bg-dark text-white">
                                                <tr>
                                                    <th>Nom Utilisateur</th>
                                                    <th>NOM</th>
                                                    <th>Lieu De Travail</th>
                                                    <th>Responsable(Supérieur Hiérarchique)</th>
                                                    <th>ROLE</th>
                                                    <th>ACTIONS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach($utilisateurs as $key => $user)
                                                        <?php
                                                            $responsable = DB::table('users')->where('id', '=', $user->responsable)->get()->first();
                                                        ?>
                                                        <tr style="font-size:15px;">
                                                            <td><label>{{ $user->login }}</label></span></td>
                                                            <td><label>{{ $user->fullname }}</label></span></td>
                                                            <td><label>{{ $user->departements != NULL ? "SERVICE" ."  ". $user->departements->name : ($user->sites != NULL ? $user->sites->name : '') }}</label></td>
                                                            <td>
                                                                <label>{{ $responsable ? $responsable->fullname : '' }}</label>
                                                            </td>                                                    
                                                            <td>
                                                                <a 
                                                                    id="roleUser"
                                                                    data-user="{{ $user }}"
                                                                    href="#"
                                                                    data-backdrop="static"
                                                                    data-keyboard="false"
                                                                    data-toggle="modal"
                                                                    data-target="#modif_role_user">
                                                                    @if(!empty($user->getRoleNames()))
                                                                        @foreach($user->getRoleNames() as $v)
                                                                            <label style="font-size:1.1em; cursor: pointer;" class="badge badge-success">{{ $v }}</label>
                                                                        @endforeach
                                                                    @endif
                                                                </a>
                                                            </td> 
                                                            <td>
                                                                <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <span class="text-muted sr-only">Action</span>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    @can('editer-utilisateur')
                                                                        <a
                                                                            href="#"
                                                                            class="dropdown-item"
                                                                            id="btnEdit"
                                                                            data-departements="{{ $departements }}"
                                                                            data-sites="{{ $sites }}"
                                                                            data-user="{{ $user }}"
                                                                            data-password="{{ $user->password }}"
                                                                            data-toggle="modal"
                                                                            data-target="#modalEditUser"
                                                                            data-backdrop="static"
                                                                            data-keyboard="false">
                                                                            <span class="fe fe-edit-2 mr-4"></span>
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
                                                                            <span class="fe fe-x mr-4"></span>
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
                                                                            <span class="fe fe-eye mr-4"></span>
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
            <div class="modal-header">
                <h5 class="text-xl">
                    <span class="icon">
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
                                                            <div class="form-group mb-4">
                                                                <label for="fullname"><i class="fe fe-user mr-2"></i> Nom Complèt <span style="color:red;"> *</span></label>
                                                                <input placeholder="EX: Ngo Jean" style="font-size:20px;font-family: Century Gothic;" type="text" class="form-control"
                                                                    id="fullname" name="fullname">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""><i class="fe fe-map-pin mr-2"></i>Lieu De Travail </label>
                                                            </div>
                                                            <fieldset class="my-4" style="border: 1px solid silver; padding: 3px; border-radius: 4px; font-size: 1em;">
                                                            <div style="margin-left:1em; margin-top:1em;" class="row mb-4">
                                                                <div class="form-group mr-4">
                                                                    <input checked="checked" style="width:1em; height:1em; font-family: Century Gothic;" type="checkbox" name="ag" id="agency">
                                                                    <label for="agency">EN AGENCE</label>
                                                                </div>
                                                                <div class="form-group mr-4">
                                                                    <input style="width:1em; height:1em; font-family: Century Gothic;" type="checkbox" name="st" id="store">
                                                                    <label for="store">AU MAGASIN</label>
                                                                </div>
                                                                <div class="form-group mr-4">
                                                                    <input style="width:1em; height:1em; font-family: Century Gothic;" type="checkbox" name="se" id="service">
                                                                    <label for="service">DANS UN SERVICE</label>
                                                                </div>
                                                                <div class="form-group mr-4">
                                                                    <input style="width:1em; height:1em; font-family: Century Gothic;" type="checkbox">
                                                                    <label for="service">DANS UN LDI</label>
                                                                </div>
                                                            </div>
                                                            </fieldset>
                                                            <div data-sites="{{ $sites }}" data-departements="{{ $departements }}" class="camer form-group mb-4">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="email"><i class="fe fe-mail mr-2"></i> Email <span style="color:red;"> *</span></label>
                                                                <input placeholder="abcd@hotmail.com" style="font-size:20px;font-family: Century Gothic;" type="email" class="form-control form-control-user"
                                                                    id="email" name="email">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="login"><i class="fe fe-log-in mr-2"></i> Nom Utilisateur <span style="color:red;"> *</span></label>
                                                                <input placeholder="EX: Ngo_Jean-01" style="font-size:20px;font-family: Century Gothic;" type="text" class="form-control form-control-user"
                                                                    id="login" name="login">
                                                            </div>
                                                            <!-- | Caractères Spéciaux Requis (@ ! # ?) -->
                                                            <div class="form-group">
                                                                <label for="password"><i class="fe fe-key mr-2"></i>Mot De Passe <span style="color:red;"> *</span></label></br>
                                                                <strong>06 Caractères Au moins </strong>
                                                                <input style="font-size:15px;" type="password" placeholder="************" class="form-control"
                                                                    id="password" name="password">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="confirm-password"><i class="fe fe-key mr-2"></i>Confirmez Mot De Passe...<span style="color:red;"> *</span></label>
                                                                <input style="font-size:15px;" type="password" placeholder="************" class="form-control"
                                                                    id="confirm-password" name="confirm-password" placeholder="Confirmer Mot De Passe">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="role"><i class="fe fe-user mr-2"></i>Supérieur Hierarchique De Cet Utilisateur </br>(Personne Chargé De Controller Et D'assigner Les Incidents Déclarés Par Celui-ci) <span style="color:red;"></span></label>
                                                                <select style="font-size:20px;" class="form-control select2" id="usings" name="usings">
                                                                    <option value="">Choisissez Un Coordonateur...</option>
                                                                    @foreach($utilisateurs as $user)
                                                                    @if($user->roles[0]->name == "COORDONATEUR")
                                                                        <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                                                    @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="role"><i class="fe fe-lock mr-2"></i>Rôle <span style="color:red;"> *</span></label>
                                                                <select style="font-size:20px;" class="custom-select" id="role" name="roles">
                                                                    <option value="">Choisissez...</option>
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
                                                                <button type="button" id="btnAnnulAddForm" class="btn btn-block btn-danger">
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
            <div class="modal-header text-white">
                <h5 class="text-xl">
                    <span class="icon text-white-80">
                            <i class="fe fe-user-minus mr-3"></i>
                    </span>
                    Edition Compte Utilisateur
                </h5>
                <button type="button" id="btnCloseEdit" class="close" data-dismiss="modal" aria-label="Close">
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
                                                                <div class="form-group my-4">
                                                                    <label for=""><i class="fe fe-user mr-2"></i>Nom Complèt<span style="color:red;"> *</span></label>
                                                                    <input style="font-size:20px;" placeholder="EX: Ngo Jean" type="text" class="form-control my-4"
                                                                        id="fullnames" name="fullname">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for=""><i class="fe fe-map-pin mr-2"></i>Lieu De Travail </label>
                                                                </div>
                                                                <fieldset class="my-4" style="border: 1px solid silver; padding: 3px; border-radius: 4px; font-size: 1em;">
                                                                    <div style="margin-left:1em; margin-top: 1em;" class="row mb-4">
                                                                        <div class="form-group mr-4">
                                                                            <input style="width:1em; height:1em; font-family: Century Gothic;" type="checkbox" name="ags" id="agencys">
                                                                            <label for="agency">EN AGENCE</label>
                                                                        </div>
                                                                        <div class="form-group mr-4">
                                                                            <input style="width:1em; height:1em; font-family: Century Gothic;" type="checkbox" name="sts" id="stores">
                                                                            <label for="store">AU MAGASIN</label>
                                                                        </div>
                                                                        <div class="form-group mr-4">
                                                                            <input style="width:1em; height:1em; font-family: Century Gothic;" type="checkbox" name="ses" id="services">
                                                                            <label for="service">DANS UN SERVICE</label>
                                                                        </div>
                                                                        <div class="form-group mr-4">
                                                                            <input style="width:1em; height:1em; font-family: Century Gothic;" type="checkbox">
                                                                            <label for="service">DANS UN LDI</label>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                                <div class="camer_edit form-group mb-4"></div>
                                                                <div class="form-group">
                                                                    <label for="emails"><i class="fe fe-mail mr-2"></i> Email <span style="color:red;"> *</span></label>
                                                                    <input placeholder="abcd@hotmail.com" style="font-size:20px;font-family: Century Gothic;" type="email" class="form-control form-control-user"
                                                                        id="emails" name="email">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="logins"><i class="fe fe-log-in mr-2"></i>Nom Utilisateur<span style="color:red;"> *</span></label>
                                                                    <input placeholder="EX: Ngo_Jean-01" style="font-size:20px;" type="text" class="form-control form-control-user"
                                                                        id="logins" name="login">
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="passwords"><i class="fe fe-key mr-2"></i>Mot De Passe<span style="color:red;"> *</span></label></br>
                                                                    <strong>06 Caractères Au moins </strong>
                                                                    <input style="font-size:15px;" placeholder="************" type="password" class="form-control form-control-lg"
                                                                        id="passwords" name="password">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="confirm-passwords"><i class="fe fe-key mr-2"></i>Confirmez Mot De Passe<span style="color:red;"> *</span></label>
                                                                    <input style="font-size:15px;" placeholder="************" type="password" class="form-control"
                                                                        id="confirm-passwords" name="confirm-password" placeholder="Confirmer Mot De Passe">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="usings_edit"><i class="fe fe-user mr-2"></i>Supérieur Hierarchique De Cet Utilisateur </br>(Personne Chargé De Controller Et D'assigner Les Incidents Déclarés Par Celui-ci) <span style="color:red;"></span></label>
                                                                    <select style="font-size:20px;" class="form-control select2" id="usings_edit" name="usings_edit">
                                                                        <option value="">Choisissez Un Coordonateur...</option>
                                                                        @foreach($utilisateurs as $user)
                                                                        @if($user->roles[0]->name == "COORDONATEUR")
                                                                            <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                                                        @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="roles"><i class="fe fe-lock mr-2"></i> Rôle <span style="color:red;"> *</span></label>
                                                                    <select style="font-size:20px;" class="custom-select" id="roles" name="roles">
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
                                                                    <button type="button" id="btnAnnulEditUser" class="btn btn-block btn-danger">
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
    <div style="font-family: Century Gothic;" class="modal" id="modalconfirm_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white text-xl">
                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                    <i class="fas fa-check fa-lg mr-3"></i>    
                                    Confirmez-Vous Ces Informations ?</h5>
                                </div>
                                <div class="modal-body">
                                                        <table class="table table-bordered mb-2">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    NOM</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                    <span style="color: black; font-size: 15px;" id="fullname_conf"></span>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
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
                                                                                                    <span  class="badge badge-primary">
                                                                                                    EMAIL</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 15px;" id="em_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    DEPARTEMENT</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 15px;" id="d_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    SITE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 15px;" id="sit_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
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
                                    <button type="button" id="non_confirmation_saveU" class="btn btn-secondary" data-dismiss="modal">NON</button>
                                </div>
                            </div>
                        </div>
    </div>

    <!-- Modal View User -->
    <div style="font-family: Century Gothic;" class="modal" id="viewUser" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
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
                                                    <div class="card-content">
                                                        <div class="table-responsive">
                                                            <table class="table table-responsive table-bordered mb-0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                        <span>
                                                                        NOM
                                                                        </span>
                                                                        </td>
                                                                        <td>
                                                                                <div class="form-group">
                                                                                      <input style="border-style: none; font-weight:bolder;" disabled type="text" id="name_user">
                                                                                </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <span>NOM UTILISATEUR</span>
                                                                        </td>
                                                                        <td>
                                                                              <div class="form-group">
                                                                                      <input style="border-style: none; font-weight:bolder;" disabled type="text" id="username">
                                                                                </div>
                                                                      </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <span>EMAIL</span>
                                                                        </td>
                                                                        <td>
                                                                              <div class="form-group">
                                                                              <textarea style="border-style: none; font-weight:bolder; resize:none;" id="email_user" disabled rows="1" cols="30"></textarea>
                                                                                </div>
                                                                      </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <span>SITE OU TRAVAILLE L'UTILISATEUR</span>
                                                                        </td>
                                                                        <td>
                                                                                <div class="form-group">
                                                                                      <input style="border-style: none; font-weight:bolder;" disabled type="text" id="site_user">
                                                                                </div>
                                                                      </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <span>ROLE</span>
                                                                        </td>
                                                                        <td>
                                                                              <div class="form-group">
                                                                                    <textarea style="border-style: none; font-weight:bolder; resize:none;" id="role_user" disabled rows="1" cols="20"></textarea>
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
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        Erreur Création Compte</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation" disabled style="width:100%;border-style:none;height:250px;resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_user" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal error Modif Role-->
    <div style="font-family: Century Gothic;" class="modal" id="update_rol" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="valiRole" disabled style="width:100%;border-style:none;height:3em;resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_riless" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal error validation-->
    <div style="font-family: Century Gothic;" class="modal" id="error_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger text-xl">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation_edit" disabled style="width:100%;border-style:none;height:250px; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_user_edit" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal Modification Role User -->
    <div id="modif_role_user" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="text-xl" id="verticalModalTitle">
                                        <i class="fe fe-lock mr-3" style="font-size:20px;"></i>
                                        Rôle</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card shadow">
                                    <div class="mb-3" style="padding:1.2em;">
                                        <div class="row my-4">
                                            <div class="col-md-6 text-left">
                                            <span class="fe fe-user mr-2"></span>
                                                UTILISATEUR
                                            </div>
                                            <div class="col-md-6 text-uppercase text-right">
                                                <strong id="nibiru"></strong>
                                            </div>
                                        </div>
                                        <div class="form-group my-4">
                                                <label for="role_utilisateur">
                                                    <span class="fe fe-lock mr-2"></span>
                                                    Rôle
                                                </label>
                                                <select style="font-size:1.5em;" class="custom-select" id="role_utilisateur">
                                                    <option selected value="">Choisissez...</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <button data-user="" id="update_role" class="btn btn-outline-success btn-block">
                                                <span class="fe fe-lock fe-16 mr-3"></span>
                                                Modifier
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->

    <script src="{{ url('users.js') }}"></script>

@endsection