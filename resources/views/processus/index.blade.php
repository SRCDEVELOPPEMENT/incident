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
                                        Liste Des Procéssus
                                    </h1>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button 
                                                data-backdrop="static" 
                                                data-keyboard="false"
                                                title="Ajout D'un Procéssus"
                                                class="btn btn-icon-split btn-primary"
                                                data-toggle="modal" 
                                                data-target="#modal_add_processus">
                                                <span class="icon text-white-80">
                                                    <i class="fe fe-plus" style="font-size:15px;"></i>
                                                    <i class="fe fe-activity mr-3" style="font-size:20px;"></i>
                                                </span>
                                            Ajout D'un Procéssus
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
                                                <th>Procéssus</th>
                                                <th>Description</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(Session::has('processus'))
                                            @if(is_iterable(Session::get('processus')))
                                            @foreach(Session::get('processus') as $key => $pro)
                                                <tr>
                                                    <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input">
                                                        <label class="custom-control-label"></label>
                                                    </div>
                                                    </td>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $pro->name }}</td>
                                                    <td>{{ $pro->description }}</td>
                                                    <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a 
                                                            id="btn_edi_po"
                                                            data-pro="{{ json_encode($pro) }}"
                                                            class="dropdown-item"
                                                            href="#"
                                                            data-backdrop="static"
                                                            data-keyboard="false"
                                                            data-toggle="modal"
                                                            data-target="#modal_edit_processus">
                                                            <span class="fe fe-edit-2 mr-4"></span>
                                                            Edit
                                                        </a>
                                                        <a id="btnDelete" data-incidents="{{ json_encode(Session::get('incidents')) }}" data-processus="{{ json_encode($pro) }}" class="dropdown-item" href="#!">
                                                        <span class="fe fe-x mr-4"></span>
                                                        Supprimer</a>
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

    <!-- Modal Edit Procéssus -->
    <div style="font-family: Century Gothic; font-size:15px;" class="modal" id="modal_edit_processus" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="verticalModalTitle">
                                    <i class="fe fe-plus" style="font-size:15px;"></i>
                                    <i class="fe fe-activity mr-3" style="font-size:20px;"></i>
                                Edition D'un Procéssus</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                    <div class="card">
                                            <div class="card-body">
                                                <form id="frmedit_pos">
                                                        @csrf
                                                        @method('PUT')
                                                    <input type="hidden" id="id" value="" name="id">
                                                    <div class="form-group mb-3">
                                                        <label for="p_edit"> <span class="fe fe-edit mr-1"></span>Désignation Du Procéssus <span style="color:red;"> *</span></label>
                                                        <input style="font-family: Century Gothic; font-size:1.2em;" class="form-control" id="p_edit" name="name" placeholder="Veuillez Entrer Le Nom Du Procéssus."/>
                                                        <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                            <label for="de_edit"><span class="fe fe-edit-2 mr-1"></span> Description</label>
                                                            <textarea style="resize:none; font-size:1.2em;" class="form-control" id="de_edit" name="description" placeholder="Veuillez Entrer Une Description Du Procéssus." rows="4"></textarea>
                                                            <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                    </div>
                                                </form>

                                            </div>
                                    </div>
                                    <hr class="my-4">
                                    <div class="row">
                                        <div class="col-md-12 text-left">
                                            <button type="button" id="btn_editpr" class="btn btn-sm btn-info">
                                                <span class="fe fe-activity fe-32"></span>
                                                <span class="fe fe-save mr-2"></span>
                                                <span class="text-lg">Editer Le Procéssus</span>
                                            </button>
                                        </div>
                                    </div>
                            </div>
                          </div>
                        </div>
    </div>


    <!-- Modal Add Procéssus -->
    <div style="font-family: Century Gothic; font-size:15px;" class="modal" id="modal_add_processus" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-plus" style="font-size:15px;"></i>
                                        <i class="fe fe-activity mr-3" style="font-size:20px;"></i>
                                    Ajout D'un Procéssus</h5>
                                <button id="btnExitp" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                        <div class="card">
                                                <div class="card-body">
                                                    <form id="frmprocessus">
                                                            @csrf
                                                            @method('POST')
                                                        <div class="form-group mb-3">
                                                            <label for="pro_name"> <span class="fe fe-edit mr-1"></span>Désignation Du Procéssus <span style="color:red;"> *</span></label>
                                                            <input type="text" style="font-family: Century Gothic; font-size:1.2em;" class="form-control" id="pro_name" name="name" placeholder="Veuillez Entrer Le Nom Du Procéssus."/>
                                                            <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="descr"><span class="fe fe-edit-2 mr-1"></span> Description</label>
                                                            <textarea style="resize:none; font-size:1.2em;" class="form-control" id="descr" name="description" placeholder="Veuillez Entrer Une Description Du Procéssus." rows="4"></textarea>
                                                            <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                        </div>
                                                    </form>
                                                </div>
                                        </div>
                                        <hr class="my-4">
                                        <div class="row">
                                            <div class="col-md-12 text-left">
                                                <button type="button" id="btn_add_process" class="btn btn-sm btn-info">
                                                    <span class="fe fe-activity fe-16"></span>
                                                    <span class="fe fe-save mr-2"></span> 
                                                    <span class="text-lg">Enrégistrer Le Procéssus</span>
                                                </button>
                                            </div>
                                        </div>
                                </div>
                          </div>
                        </div>
    </div>


    <!-- Modal error validation-->
    <div class="modal" id="gaby" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
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
    <div class="modal" id="eren" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="val_pros" disabled style="width:100%; height:6em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal error validation-->
    <div class="modal" id="sia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="val_sia" disabled style="width:100%; height:5em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="sia_btn" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <script src="{{ url('processus.js') }}"></script>

@endsection
