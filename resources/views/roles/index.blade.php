
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
                                            class="btn btn-icon-split"
                                            style="background-color: #345B86;">
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
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>N°</th>
                                            <th>Rôle</th>
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
                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        @can('editer-role')
                                                            <a class="dropdown-item" href="{{ route('roles.edit',$role->id) }}" data-id="{{ $role->id }}">Editer</a>
                                                        @endcan

                                                        @can('supprimer-role')
                                                            <a 
                                                                class="dropdown-item" 
                                                                href="#" id="btnDelete" 
                                                                data-intituleRole="{{ $role->name }}" 
                                                                data-id="{{ $role->id }}">
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header  bg-dark text-white">
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
                    <form id="roleFormInsert" autocomplete="off">
                    {{ csrf_field() }}
                        @csrf
                        @method('POST')
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        id="role" name="name"
                                                        placeholder="Rôle">
                                                </div>
                                                <form id="form_roles_add">
                                                    @foreach($permissions as $value)
                                                        <label style="font-size:25px;">{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                                        {{ $value->name }}</label>
                                                    <br/>
                                                    @endforeach
                                                </form>
                                                <hr class="my-4">
                                                <div class="row">
                                                    <button type="button" id="btnSaveRole" class="btn btn-primary col-md-6 mr-4 ml-2"><i class="fe fe-save mr-2"></i>Enregistrer Rôle</button>
                                                    <button type="button" id="btnFermer" class="btn btn-danger col-md-4"><i class="fe fe-times"></i><i class="fe fe-trash mr-2"></i>Annuler Rôle</button>
                                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modalEdit" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">
                <span class="icon text-white-80">
                            <i class="fas fa-edit"></i>
                    </span>
                Edition Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="roleFormEdit">
                    {{ csrf_field() }}
                        @csrf
                                                <div class="form-group">
                                                        <input id="id" data-ids type="hidden" name="id">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control"
                                                        id="role" name="name"
                                                        placeholder="Role">
                                                </div>
                                                @foreach($permissions as $value)
                                                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                                    {{ $value->name }}</label>
                                                <br/>
                                                @endforeach                                                
                                                <hr>
                                                <button type="button" id="btnEditRole" class="btn btn-primary">Editer</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
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
                                        <button id="dismiss_btn_rol" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <script src="{{ url('roles.js') }}"></script>

@endsection
