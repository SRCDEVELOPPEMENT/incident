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
                                        class="btn btn-icon-split btn-primary">
                                                    <span class="icon text-white-80">
                                                        <i class="fe fe-plus"></i>
                                                        <i class="fe fe-unlock mr-2"></i>
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
                                    <thead class="bg-dark">
                                        <tr>
                                            <th>N°</th>
                                            <th>PERMISSION</th>
                                            <th>DESCRIPTION</th>
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
                                                    <td class="text-uppercase">{{ $permission->description }}</td>
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
                                                                data-description="{{ $permission->description }}"
                                                                class="dropdown-item mb-1" 
                                                                href="#">
                                                                <span class="fe fe-edit-2 mr-4"></span>
                                                                Editer
                                                            </a>
                                                            @endcan
                                                            @can('supprimer-permission')
                                                            <a 
                                                                id="btnDelete" 
                                                                data-name="{{ $permission->name }}"
                                                                data-id="{{ $permission->id }}"
                                                                data-roles_has_permissions="{{ $roles_has_permissions }}"
                                                                class="dropdown-item" 
                                                                href="#">
                                                                <span class="fe fe-x mr-4"></span>
                                                                Supprimer
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
                <div class="modal-header text-white">
                    <h5 class="text-xl">
                    <span class="icon text-white-80">
                                <i class="fe fe-plus" style="font-size:10px;"></i>
                                <i class="fe fe-unlock mr-3"></i>
                        </span>
                    Ajout Permission</h5>
                    <button type="button" id="btnClose" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card shadow" style="padding:2em;">
                        <form id="permissionFormInsert" autocomplete="off">
                        {{ csrf_field() }}
                            @csrf
                                                    <div class="form-group">
                                                        <label for="name"><i class="fe fe-unlock mr-2"></i>Désignation De La Permission <span style="color:red;">  *</span></label>
                                                        <input style="font-size:1.2em;" type="text" class="form-control"
                                                            id="name" name="name"
                                                            placeholder="EX: creer-permission | lister-permission">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label for="description"> <span class="fe fe-edit-2 mr-1"></span> A Propos De La Permission (Décrivez Votre Permission !)</label>
                                                        <textarea style="resize:none; font-size:1.2em;" rows="4" class="form-control" id="description" name="description" placeholder="Veuillez Entrer Une Description Précise."></textarea>
                                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div>
                                                    <hr class="my-4">
                                                    <div class="row">
                                                        <div class="text-left col-md-6">
                                                            <button type="button"  id="btnAddPermission" class="btn btn-primary">
                                                                <i class="fe fe-save" style="font-size:10px;"></i>    
                                                                <i class="fe fe-unlock mr-2"></i>
                                                                Enregistrer
                                                            </button>
                                                        </div>
                                                        <div class="text-right col-md-6">
                                                            <button type="button" id="btnreset" class="btn btn-danger">
                                                                <i class="fe fe-x" style="font-size:10px;"></i>
                                                                <i class="fe fe-unlock mr-2"></i>
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
    
    <div style="font-family: Century Gothic;" class="modal" id="modalEditPermission" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="text-xl">
                    <span class="icon text-white-80">
                    <i class="fe fe-edit-2" style="font-size:10px;"></i>
                                <i class="fe fe-unlock mr-3"></i>
                        </span>
                    Edition Permission
                </h5>
                <button type="button" id="btnClose" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="card shadow" style="padding:2em;">
                        <form id="permissionFormEdit" autocomplete="off">
                        {{ csrf_field() }}
                            @csrf
                                                    <div class="form-group">
                                                        <input id="id" type="hidden" name="id">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="names"><i class="fe fe-unlock mr-2"></i>Désignation De La Permission  <span style="color:red;">  *</span></label>
                                                        <input style="font-size:1.2em;" type="text" class="form-control"
                                                            id="names" name="name"
                                                            placeholder="EX: creer-permission | lister-permission">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                            <label for="descriptions"> <span class="fe fe-edit-2 mr-1"></span> A Propos De La Permission (Décrivez Votre Permission !)</label>
                                                            <textarea style="resize:none; font-size:1.2em;" rows="4" class="form-control" id="descriptions" name="description" placeholder="Veuillez Entrer Une Description Précise."></textarea>
                                                            <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div>
                                                    <hr class="my-4">
                                                    <div class="row">
                                                        <div class="text-left col-md-6">
                                                            <button type="button"  id="btnEditPermission" class="btn btn-primary">
                                                                <i class="fe fe-edit" style="font-size:10px;"></i>
                                                                <i class="fe fe-lock mr-2"></i>
                                                                Modifier
                                                            </button>
                                                        </div>
                                                        <div class="text-right col-md-6">
                                                            <button type="button" id="btnExit" class="btn btn-danger" data-dismiss="modal">
                                                                <i class="fe fe-x" style="font-size:10px;"></i>
                                                                <i class="fe fe-lock mr-2"></i>
                                                                Fermer
                                                            </button>
                                                        </div>
                                                    </div>
                        </form>
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
                                          <textarea id="validation" disabled style="width:100%; height:100px ;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
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
