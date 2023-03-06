@extends('layouts.main')

@section('content')

    <!-- Begin Page Content -->
    <div class="main-content">
        <div class="container-fluid" style="font-family: 'Century Gothic';">

                            <!-- Page Heading -->
                            <p class="mb-2">
                                <div class="row my-4">
                                <div class="col-md-5 text-left text-xl text-uppercase">
                                    <h1 class="mb-2">
                                    <span class="fe fe-info mr-2"></span>    
                                    Liste Types De Site Notable</h1>
                                </div>
                                    <div class="col-md-7 text-right">
                                        <button
                                                id="toto"
                                                data-backdrop="static"
                                                data-keyboard="false"
                                                title="Déclaration D'incident"
                                                class="btn btn-icon-split btn-primary"
                                                data-toggle="modal"
                                                data-target="#modalType">
                                                <span class="icon text-white-80">
                                                    <i class="fe fe-plus" style="font-size:15px;"></i>
                                                    <i class="fe fe-type mr-3" style="font-size:20px;"></i>
                                                </span>
                                            Ajout Type
                                        </button>
                                    </div>
                                </div>
                            </p>

                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header text-lg text-white py-3" style="color:black;">
                                    
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover datatables" id="dataTable-1">
                                                <thead class="bg-dark">
                                                    <tr>
                                                        <th>TYPE</th>
                                                        <th>DESCRIPTION</th>
                                                        <th>ACTIONS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        @foreach($types as $key => $type)
                                                            <tr style="font-size:15px;">
                                                                <td><label>{{ $type->name }}</label></td>
                                                                <td><label>{{ $type->description }}</label></td>
                                                                <td>
                                                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <span class="text-muted sr-only">Action</span>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                            <a
                                                                                id="btn_edi"
                                                                                class="dropdown-item"
                                                                                href="#"
                                                                                data-backdrop="static"
                                                                                data-keyboard="false"
                                                                                data-toggle="modal"
                                                                                data-target="#modalEditSite">
                                                                                <span class="fe fe-edit-2 mr-4"></span>
                                                                                Edit
                                                                            </a>
                                                                            <a
                                                                                id="btnDelete"
                                                                                data-type="{{$type->id}}"
                                                                                data-name="{{$type->name}}"
                                                                                class="dropdown-item" href="#">
                                                                                <span class="fe fe-x mr-4"></span>
                                                                                Supprimer
                                                                            </a>
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
    </div>
    <!-- /.container-fluid -->
    
    <div style="font-family:Century Gothic;" class="modal" id="modalType" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="text-xl ">
                <span class="icon text-white-80">
                            <i class="fe fe-plus" style="font-size:10px;"></i>
                            <i class="fe fe-type mr-3"></i>
                    </span>
                Ajout Type De Site</h5>
                <button type="button" id="Klos" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                        <div class="card shadow" style="padding:2em;">
                                                <div class="form-group my-4">
                                                    <label for="type_site"><i class="fe fe-type mr-2"></i> Type De Site <span style="color:red;"> *</span></label>
                                                    <input style="font-size:20px;" type="text" class="form-control"
                                                        id="type_site" name="name"
                                                        placeholder="Veuillez Renseigner Un Type De Site">
                                                </div>
                                                <div class="form-group">
                                                            <label for="descr"><span class="fe fe-edit-2 mr-1"></span> Description Du Type</label>
                                                            <textarea style="resize:none;" class="form-control" id="descr" name="description" placeholder="Veuillez Entrer Une Description Du Procéssus." rows="5"></textarea>
                                                            <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                        </div>
                                                <hr class="my-4">
                                                <div class="form-group">
                                                    <button  type="button" id="btnType_Site" class="btn btn-block btn-primary" data-types="{{ $types }}">
                                                        <i class="fe fe-check" ></i>
                                                        <i class="fe fe-type mr-2"></i>
                                                        Enrégistrer
                                                    </button>
                                                </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal error validation-->
    <div class="modal" id="errorvalidationsModals" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation" disabled style="width:100%; height:6em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_btn1" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal error validation-->
    <div class="modal" id="error_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation_edit" disabled style="width:100%; height:6em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_bouton" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <script src="{{ url('types.js') }}"></script>
@endsection