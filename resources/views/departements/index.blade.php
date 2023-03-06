@extends('layouts.main')

@section('content')
    <div class="main-content">
        <div class="container-fluid" style="font-family: 'Century Gothic';">
            <div class="row justify-content-center">
                <div class="col-12">
                        <div class="card-header py-3">
                            <div class="row">
                                    <div class="col-md-6 text-left text-xl text-uppercase">
                                        <h1 class="mb-2">
                                        <span class="fe fe-info mr-2"></span>    
                                        Liste Des Départements
                                    </h1>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button 
                                                data-backdrop="static" 
                                                data-keyboard="false"
                                                title="Ajout D'un Département" 
                                                class="btn btn-icon-split btn-primary"
                                                data-toggle="modal" 
                                                data-target="#modal_add_departement">
                                                <span class="icon text-white-80">
                                                    <i class="fe fe-plus" style="font-size:15px;"></i>
                                                    <i class="fe fe-home mr-3" style="font-size:20px;"></i>
                                                </span>
                                            Ajout D'un Département
                                        </button>
                                    </div>
                            </div>
                        </div>
                        <h2 class="mb-2 page-title"></h2>
                        <div class="row my-4">
                            <!-- Small table -->
                            <div class="col-md-12">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <!-- table -->
                                        <table class="table datatables" id="dataTable-1">
                                            <thead class="bg-dark">
                                            <tr>
                                                <th></th>
                                                <th>N°</th>
                                                <th>Département</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @if(Session::has('departements'))
                                                @if(is_iterable(Session::get('departements')))
                                                @foreach(Session::get('departements') as $key => $dept)
                                                    <tr>
                                                        <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input">
                                                            <label class="custom-control-label"></label>
                                                        </div>
                                                        </td>
                                                        <td>{{ intval($key) + 1 }}</td>
                                                        <td>{{ $dept->name }}</td>
                                                        <td>
                                                            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="text-muted sr-only">Action</span>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a 
                                                                    id="btn_edi" 
                                                                    data-dept="{{ json_encode($dept) }}"
                                                                    class="dropdown-item" 
                                                                    href="#!"
                                                                    data-backdrop="static"
                                                                    data-keyboard="false" 
                                                                    data-toggle="modal" 
                                                                    data-target="#modal_edit_departement">
                                                                    <span class="fe fe-edit-2 mr-4"></span>
                                                                    Edit
                                                                </a>
                                                                <a id="btnDelete" data-categories="{{ json_encode(Session::get('categories')) }}" data-departement="{{ json_encode($dept) }}" class="dropdown-item" href="#">
                                                                    <span class="fe fe-x mr-4"></span>
                                                                    Supprimer
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @endif
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- simple table -->
                        </div> <!-- end section -->
                </div>
            </div> <!-- .row -->
        </div>
    </div>

    <!-- Modal Edit Département -->
    <div style="font-family: Century Gothic;" class="modal" id="modal_edit_departement" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="verticalModalTitle">
                                    <i class="fe fe-plus" style="font-size:15px;"></i>
                                    <i class="fe fe-home mr-3" style="font-size:20px;"></i>
                                Edition D'un Département</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                    <div class="card">
                                            <div class="card-body">
                                                <form id="frmeditdept">
                                                        @csrf
                                                        @method('PUT')
                                                    <input type="hidden" id="id" value="" name="id">
                                                    <div class="form-group my-4">
                                                        <label for="dept_edit"> <span class="fe fe-edit mr-1"></span>Nom Département</label>
                                                        <input style="font-family: Century Gothic;font-size:20px;" class="form-control" id="dept_edit" name="name" placeholder="Veuillez Entrer Le Nom Du Département."/>
                                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="button" id="btn_edit_unique_dept" class="btn btn-block btn-info">
                                                            <span class="fe fe-home fe-32"></span>
                                                            <span class="fe fe-save mr-2"></span>
                                                            <span class="text-lg">Editer Le Département</span>
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                    </div>
                            </div>
                          </div>
                        </div>
    </div>


    <!-- Modal Add Département -->
    <div style="font-family: Century Gothic;" class="modal" id="modal_add_departement" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-plus" style="font-size:15px;"></i>
                                        <i class="fe fe-home mr-3" style="font-size:20px;"></i>
                                    Ajout D'un Département</h5>
                                <button id="btnExitModaldepart" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                        <div class="card">
                                                <div class="card-body">
                                                    <form id="frmdeparts">
                                                            @csrf
                                                            @method('POST')
                                                        <div class="form-group my-4">
                                                            <label for="task"> <span class="fe fe-edit mr-1"></span>Nom Département</label>
                                                            <input type="text" style="font-family: Century Gothic;font-size:20px;" class="form-control" id="dept_name" name="name" placeholder="Veuillez Entrer Le Nom Du Département."/>
                                                            <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <button type="button" id="btn_add_unique_dept" class="btn btn-block btn-info">
                                                                    <span class="fe fe-home fe-16"></span>
                                                                    <span class="fe fe-save mr-2"></span> 
                                                                    <span class="text-lg">Enrégistrer Le Département</span>
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


    <!-- Modal error validation-->
    <div class="modal" id="Falco" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation" disabled style="width:100%; height:5em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_btn" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal error validation-->
    <div class="modal" id="deee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="val_dep" disabled style="width:100%; height:7em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <script src="{{ url('departement.js') }}"></script>

@endsection
