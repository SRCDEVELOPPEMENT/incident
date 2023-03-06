
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
                                    Liste Des Rôles
                                </h1>
                            </div>
                            <div class="col-md-6 text-right">
                                @can('creer-role')
                                    <button 
                                            type="button" 
                                            data-toggle="modal" 
                                            data-target="#modalRole" 
                                            data-backdrop="static" 
                                            data-keyboard="false" 
                                            class="btn btn-icon-split btn-primary">
                                            <span class="icon text-white-80">
                                                <i class="fe fe-plus" style="font-size:20px;"></i>
                                                <i class="fe fe-lock mr-2"></i>
                                            </span>
                                            <span class="text">Ajout Rôle</span>
                                    </button>
                                @endcan
                            </div>
                        </div>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                    <table class="table datatables" id="dataTable-1">
                                        <thead class="bg-dark">
                                        <tr>
                                            <th></th>
                                            <th>N°</th>
                                            <th>Rôle</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($roles as $key => $role)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input">
                                                        <label class="custom-control-label"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>{{ $role->description }}</td>
                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @can('attribuer-permission')
                                                            <a 
                                                                class="dropdown-item mb-1"
                                                                href="{{ route('roles.edit',$role->id) }}"
                                                                data-id="{{ $role->id }}">
                                                                <span style="font-size:10px;" class="fe fe-plus"></span>
                                                                <span class="fe fe-unlock mr-2"></span>
                                                                Attribuer Une Permission</a>
                                                        @endcan
                                                        @can('editer-role')
                                                            <a 
                                                                id="btn_edi" 
                                                                data-role="{{ $role }}"
                                                                class="dropdown-item mb-1" 
                                                                href="#"
                                                                data-backdrop="static"
                                                                data-keyboard="false" 
                                                                data-toggle="modal" 
                                                                data-target="#modalEdit">
                                                                <span class="fe fe-edit-2 mr-4"></span>
                                                                Editer
                                                            </a>
                                                        @endcan
                                                        @can('supprimer-role')
                                                            <a 
                                                                class="dropdown-item"
                                                                href="#"
                                                                id="btnDelete"
                                                                data-intituleRole="{{ $role->name }}"
                                                                data-id="{{ $role->id }}">
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
      
    <div style="font-family: Century Gothic;" class="modal" id="modalRole" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="text-xl">
                    <span class="icon text-white-80">
                    <i class="fe fe-plus" style="font-size:10px;"></i>
                    <i class="fe fe-lock mr-3"></i>
                    </span>
                    Ajout Rôle
                </h5>
                <button type="button" id="btnExit" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="card shadow" style="padding:2em;">
                        <form id="roleFormInsert" autocomplete="off">
                        {{ csrf_field() }}
                            @csrf
                            @method('POST')
                                                    <div class="form-group mb-4">
                                                        <label for="role"><i class="fe fe-lock fe-16 mr-2"></i>Nom Du Rôle <span style="color:red;"> *</span></label>
                                                        <input style="font-size:1.2em;" type="text" class="form-control"
                                                            id="role" name="name"
                                                            placeholder="Veuillez Renseigner L'intitulé De Votre Rôle">
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="description"><span class="fe fe-edit-2 mr-1"></span> Description Du Rôle</label>
                                                        <textarea style="resize:none; font-size:1.2em;" class="form-control" id="description" name="description" placeholder="Veuillez Décrire En Quoi Consiste Ce Rôle." rows="6"></textarea>
                                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div>
                                                    <hr class="my-4">
                                                    <div class="row">
                                                        <button type="button" id="btnSaveRole" class="btn btn-primary text-white col-md-5 mr-5 ml-3">
                                                            <i class="fe fe-lock fe-16"></i>
                                                            <i class="fe fe-check mr-2"></i>
                                                            Enregistrer Rôle
                                                        </button>
                                                        <button type="button" id="btnFermer" class="btn btn-danger col-md-5">
                                                            <i class="fe fe-lock fe-16"></i>
                                                            <i class="fe fe-x mr-2"></i>
                                                            Annuler Rôle
                                                        </button>
                                                    </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div style="font-family: Century Gothic;" class="modal" id="modalattributionPermissions" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="text-xl">
                    <span class="icon text-white-80">
                    <i class="fe fe-plus" style="font-size:10px;"></i>
                    <i class="fe fe-lock mr-3"></i>
                    </span>
                    Attribution De Permission
                </h5>
                <button type="button" id="btnExit" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="card shadow" style="padding:2em;">
                        <div style="margin-bottom:1em;" class="row text-xl text-white">
                            <div class="text-left col-md-6">Rôle</div>
                            <div class="text-right col-md-6"><span id="ril"></span></div>
                        </div>
                        <form id="permissionFormInsert" autocomplete="off">
                                    {{ csrf_field() }}
                                    @csrf
                                    @method('POST')
                                <input type="hidden" id="id_role" name="id">
                                <table class="table">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Permission</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodys">
                                        @foreach($permissions as $value)
                                            <tr>
                                                <td>
                                                    <label style="font-size:20px;">{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                                        {{ $value->name }}
                                                    </label>
                                                </td>
                                                <td>
                                                    {{ $value->description }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <hr class="my-4">
                        </form>
                        <div class="row">
                            <button type="button" id="btnattrPerm" class="btn btn-primary text-sm col-md-7 mr-2 ml-3">
                                <i class="fe fe-check mr-2"></i>
                                Attribuer La(es) Permission(s)
                            </button>
                            <button type="button" id="btnLock" class="btn btn-danger col-md-4">
                                <i class="fe fe-x mr-2"></i>
                                Annuler
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div style="font-family: Century Gothic;" class="modal" id="modalEdit" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="text-xl">
                    <span class="icon text-white-80 mr-4">
                        <i class="fe fe-lock mr-1"></i>
                        <i style="font-size:10px;" class="fe fe-edit-2"></i>
                    </span>
                    Edition Rôle
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="card shadow" style="padding:2em;">
                        <form id="roleFormEdit">
                        {{ csrf_field() }}
                            @csrf
                                                    <div class="form-group">
                                                            <input id="id" type="hidden" name="id">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="role"><i class="fe fe-lock fe-16 mr-2"></i>Nom Du Rôle <span style="color:red;"> *</span></label>
                                                        <input style="font-size:1.2em;" type="text" class="form-control"
                                                            id="roles" name="name"
                                                            placeholder="Veuillez Renseigner L'intitulé De Votre Rôle">
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="description"><span class="fe fe-edit-2 mr-1"></span> Description</label>
                                                        <textarea style="resize:none; font-size:1.2em;" class="form-control" id="descriptions" name="description" placeholder="Veuillez Décrire En Quoi Consiste Ce Rôle." rows="6"></textarea>
                                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div>                                              
                                                    <hr class="my-4">
                                                    <div class="row">
                                                        <button type="button" id="btnEditRole" class="btn btn-primary col-md-5 mr-5 ml-3">
                                                            <i class="fe fe-lock fe-16"></i>
                                                            <i class="fe fe-check mr-2"></i>
                                                            Editer
                                                        </button>
                                                        <button type="button" class="btn btn-secondary col-md-5" data-dismiss="modal">
                                                            <i class="fe fe-lock fe-16"></i>
                                                            <i class="fe fe-x mr-2"></i>
                                                            Fermer
                                                        </button>
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
                                        <button id="dismiss_btn_rol" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal error role edit -->
    <div style="font-family: Century Gothic;" class="modal" id="role_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation_edit" disabled style="width:100%; height:100px ;border-style:none;  resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_editions" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <script src="{{ url('roles.js') }}"></script>

@endsection
