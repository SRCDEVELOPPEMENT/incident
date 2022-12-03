@extends('layouts.main')
@section('content')

    <!-- Begin Page Content -->
    <div class="main-content">
        <div class="container-fluid" style="font-family: 'Century Gothic';">

                <!-- Page Heading -->


                @can('creer-permission')
                    <div class="row my-4">
                        <div class="col-md-6 text-left text-xl">
                            <h1 class="mb-2">
                                <span class="fe fe-info mr-2"></span>    
                                Liste Des Permissions
                            </h1>
                        </div>
                        <div class="col-md-6 text-right">
                                <button 
                                        type="button" 
                                        data-toggle="modal" 
                                        data-target="#modalPermission" 
                                        data-backdrop="static" 
                                        data-keyboard="false" 
                                        class="btn btn-icon-split"
                                        style="background-color: #345B86;">
                                                    <span class="icon text-white-80">
                                                        <i class="fe fe-plus"></i>
                                                        <i class="fe fe-lock mr-2"></i>
                                                    </span>
                                                    <span class="text">Ajout Permission</span>
                                </button>
                        </div>
                    </div>
                @endcan

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                            <table class="table datatables" id="dataTable-1">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>PERMISSION</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach($permissions as $permission)
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input">
                                                            <label class="custom-control-label"></label>
                                                        </div>
                                                    </td>
                                                    <td class="text-uppercase">{{ $permission->name }}</td>
                                                    <td>
                                                        <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            @can('editer-permission')
                                                            <a 
                                                                id="btnEdit" 
                                                                data-id="{{ $permission->id }}" 
                                                                data-name="{{ $permission->name }}"
                                                                class="dropdown-item" 
                                                                href="#">
                                                                Editer
                                                            </a>
                                                            @endcan
                                                            @can('supprimer-permission')
                                                            <a 
                                                                id="btnDelete" 
                                                                data-id="{{ $permission->id }}"
                                                                data-roles_has_permissions="{{ $roles_has_permissions }}"
                                                                class="dropdown-item" 
                                                                href="#">
                                                                Supprimer
                                                            </a>
                                                            @endcan
                                                            @can('voir-permission')
                                                            <a 
                                                                id="btnView" 
                                                                data-id="{{ $permission->id }}" 
                                                                data-name="{{ $permission->name }}"
                                                                class="dropdown-item" 
                                                                href="#">
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

    
    <div style="font-family: Century Gothic;" class="modal" id="modalPermission" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header  bg-dark text-white">
                    <h5 class="text-xl">
                    <span class="icon text-white-80">
                                <i class="fe fe-plus" style="font-size:10px;"></i>
                                <i class="fe fe-lock mr-3"></i>
                        </span>
                    Ajout Permission</h5>
                    <button type="button" id="btnClose" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="modal-body">
                        <form id="permissionFormInsert" autocomplete="off">
                        {{ csrf_field() }}
                            @csrf
                                                    <div class="form-group">
                                                        <label for="">Permission <span style="color:red;">  *</span></label>
                                                        <input type="text" class="form-control"
                                                            id="name" name="name"
                                                            placeholder="EX: creer-permission | lister-permission">
                                                    </div>
                                                    <hr class="my-4">
                                                    <div class="row">
                                                        <button type="button"  id="btnAddPermission" class="btn btn-primary col-md-6 mr-2 ml-2">
                                                            <i class="fe fe-save" style="font-size:10px;"></i>    
                                                            <i class="fe fe-lock mr-2"></i>
                                                            Enregistrer</button>
                                                        <button type="button" id="btnExit" class="btn btn-danger col-md-5">
                                                            <i class="fe fe-x" style="font-size:10px;"></i>
                                                            <i class="fe fe-lock mr-2"></i>
                                                            Annuler</button>
                                                    </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div style="font-family: Century Gothic;" class="modal" id="modalEditPermission" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header  bg-dark text-white">
                <h5 class="text-xl">
                    <span class="icon text-white-80">
                                <i class="fe fe-lock mr-3"></i>
                        </span>
                    Edition Permission
                </h5>
                <button type="button" id="btnClose" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="permissionFormEdit" autocomplete="off">
                    {{ csrf_field() }}
                        @csrf
                                                <div class="form-group">
                                                    <input id="id" type="hidden" name="id">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Permission <span style="color:red;">  *</span></label>
                                                    <input type="text" class="form-control"
                                                        id="names" name="name"
                                                        placeholder="EX: creer-permission | lister-permission">
                                                </div>
                                                <hr class="my-4">
                                                <div class="row">
                                                    <button type="button"  id="btnEditPermission" class="btn btn-primary col-md-6 mr-2 ml-2">
                                                        <i class="fe fe-edit" style="font-size:10px;"></i>
                                                        <i class="fe fe-lock mr-2"></i>
                                                        Modifier
                                                    </button>
                                                    <button type="button" id="btnExit" class="btn btn-danger col-md-5" data-dismiss="modal">
                                                        <i class="fe fe-x" style="font-size:10px;"></i>
                                                        <i class="fe fe-lock mr-2"></i>
                                                        Fermer
                                                    </button>
                                                </div>
                    </form>
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
                                          <textarea id="validation" disabled style="width:100%; height:100px ;border-style:none; background-color:#495057;resize: none;color:white; font-size:19px;" class="form-control"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_btn_perm" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <script src="{{ url('permissions.js') }}"></script>

@endsection

                                    <!-- <tbody>
                                            @foreach($permissions as $permission)
                                                <tr>
                                                    <td><label style="font-size:1.5em; color:black;">{{ $permission->name }}</label></td>
                                                    <td>
                                                        @can('editer-permission')
                                                        <button class="btn btn-sm btn-info btn-icon-split mr-2" id="btnEdit" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}">
                                                            <span class="icon text-white-80">
                                                                <i class="fas fa-lock-open fa-lg"></i>
                                                                <i class="fas fa-sm fa-pen mr-2"></i>
                                                            </span>
                                                            <span class="text">Editer</span>
                                                        </button>
                                                        @endcan
                                                        @can('supprimer-permission')
                                                        <button class="btn btn-sm btn-danger btn-icon-split mr-2" 
                                                                id="btnDelete" 
                                                                data-id="{{ $permission->id }}"
                                                                data-roles_has_permissions="{{ $roles_has_permissions }}">
                                                            <span class="icon text-white-80">
                                                                <i class="fas fa-lock-open fa-lg"></i>
                                                                <i class="fas fa-sm fa-times mr-2"></i>
                                                            </span>
                                                            <span class="text">Supprimer</span>
                                                        </button>
                                                        @endcan
                                                        @can('voir-permission')
                                                        <button class="btn btn-sm btn-primary btn-icon-split" id="btnView" data-id="{{ $permission->id }}" data-name="{{ $permission->name }}">
                                                            <span class="icon text-white-80">
                                                            <i class="fas fa-lock-open fa-lg"></i>
                                                                <i class="fas fa-sm fa-eye mr-2"></i>
                                                            </span>
                                                            <span class="text">Vue</span>
                                                        </button>
                                                        @endcan
                                                    </td>

                                                </tr>
                                            @endforeach
                                    </tbody> -->
