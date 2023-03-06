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
                                    Liste Des Catégories
                                    </h1>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button 
                                        data-backdrop="static" 
                                        data-keyboard="false"
                                        title="Ajout D'une Catégorie" 
                                        class="btn btn-icon-split btn-primary"
                                        data-toggle="modal" 
                                        data-target="#modal_add_categorie">
                                        <span class="icon text-white-80">
                                            <i class="fe fe-plus" style="font-size:15px;"></i>
                                            <i class="fe fe-airplay mr-3" style="font-size:20px;"></i>
                                        </span>
                                        Ajout D'une Catégorie
                                    </button>
                                </div>
                            </div>
                    </div>
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
                                            <th>#</th>
                                            <th>Catégorie D'incident</th>
                                            <th>Département De La Catégorie</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($categories as $key => $cat)
                                            <tr>
                                                <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input">
                                                    <label class="custom-control-label"></label>
                                                </div>
                                                </td>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $cat->name }}</td>
                                                <td>{{ $cat->departements ? $cat->departements->name : $cat->type }}</td>
                                                <td>
                                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="text-muted sr-only">Action</span>
                                                    </button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a
                                                        id="edit_cati"
                                                        data-backdrop="static"
                                                        data-keyboard="false"
                                                        class="dropdown-item"
                                                        data-toggle="modal"
                                                        data-target="#categ"
                                                        href="#"
                                                        data-cat="{{ $cat }}">
                                                        <span class="fe fe-edit-2 mr-4"></span>
                                                        Editer
                                                    </a>
                                                    <a 
                                                        id="supp" 
                                                        data-incidents="{{ $incidents }}" 
                                                        data-categorie="{{ $cat }}" 
                                                        class="dropdown-item" 
                                                        href="#">
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
                        </div> <!-- simple table -->
                    </div> <!-- end section -->
            </div>
        </div> <!-- .row -->
    </div>
</div>

<!-- Modal Add Catégorie -->
<div style="font-family: Century Gothic;" class="modal" id="modal_add_categorie" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-plus" style="font-size:15px;"></i>
                                        <i class="fe fe-airplay mr-3" style="font-size:20px;"></i>
                                    Ajout D'une Catégorie</h5>
                                <button id="btnExitCat" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                        <div class="card">
                                                <div class="card-body">
                                                    <form id="frmaddcati">
                                                            @csrf
                                                            @method('POST')
                                                        <div class="my-3">
                                                            <label for="dept">Département <span style="color:red;"> *</span></label>
                                                            <select style="font-family: Century Gothic; font-size:20px;" class="custom-select" name="departement_id" id="dept">
                                                                <optgroup label="Liste Département">
                                                                    <option selected value="">Choisissez...</option>
                                                                    @foreach($departements as $dept)
                                                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                                <optgroup label="Liste Type">
                                                                    @foreach($types as $type)
                                                                    <option value="{{ $type->name }}">{{ $type->name }}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                            </select>
                                                            <div class="invalid-feedback"> Please select a valid state. </div>
                                                        </div>
                                                        <div class="form-group my-4">
                                                            <label for="task"> <span class="fe fe-edit mr-1"></span>Nom Catégorie <span style="color:red;"> *</span></label>
                                                            <input type="text" style="font-family: Century Gothic; font-size:20px;" class="form-control" id="cat_name" name="name" placeholder="Veuillez Entrer Une Catégorie."/>
                                                            <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                        </div>

                                                    </form>
                                                </div>
                                        </div>
                                        <hr class="my-4">
                                        <div class="row">
                                            <div class="col-md-12 text-left">
                                                <button type="button" id="btn_add_cate" class="btn btn-sm btn-info">
                                                    <span class="fe fe-airplay fe-16"></span>
                                                    <span class="fe fe-save mr-2"></span> 
                                                    <span class="text-lg">Enrégistrer La Catégorie</span>
                                                </button>
                                            </div>
                                        </div>
                                </div>
                          </div>
                        </div>
</div>

<!-- Modal Edit Catégorie -->
<div style="font-family: Century Gothic;" class="modal" id="categ" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-plus" style="font-size:15px;"></i>
                                        <i class="fe fe-airplay mr-3" style="font-size:20px;"></i>
                                    Edition D'une Catégorie
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                        <div class="card">
                                                <div class="card-body">
                                                    <form id="frmeditscati">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" value="" name="id" id="id_cat">
                                                        <div class="form-group mb-3">
                                                            <label for="task"> <span class="fe fe-edit mr-1"></span> Catégorie <span style="color:red;"> *</span></label>
                                                            <input type="text" style="font-family: Century Gothic; font-size:20px;" class="form-control" id="cat_names" name="name" placeholder="Veuillez Entrer Une Catégorie."/>
                                                            <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label for="dept">Département <span style="color:red;"> *</span></label>
                                                            <select style="font-family: Century Gothic; font-size:20px;" class="custom-select" name="departement_id" id="depts">
                                                                <optgroup label="Liste Département">
                                                                    <option selected value="">Choisissez...</option>
                                                                    @foreach($departements as $dept)
                                                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                                <optgroup label="Liste Type">
                                                                    @foreach($types as $type)
                                                                    <option value="{{ $type->name }}">{{ $type->name }}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                            </select>
                                                            <div class="invalid-feedback"> Please select a valid state. </div>
                                                        </div>
                                                    </form>
                                                </div>
                                        </div>
                                        <hr class="my-4">
                                        <div class="row">
                                            <div class="col-md-12 text-left">
                                                <button type="button" id="btn_edite_cate" class="btn btn-sm btn-info">
                                                    <span class="fe fe-airplay fe-16"></span>
                                                    <span class="fe fe-edit-2 mr-2"></span> 
                                                    <span class="text-lg">Editer La Catégorie</span>
                                                </button>
                                            </div>
                                        </div>
                                </div>
                          </div>
                        </div>
</div>


<!-- Modal error validation-->
<div class="modal" id="Falco" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation" disabled style="width:100%; height:7em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_btn" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
</div>

<!-- Modal error validation-->
<div class="modal" id="editCat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validationedito" disabled style="width:100%; height:7em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_btn_edito" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
</div>

<!-- Modal error validation-->
<div class="modal" id="jean" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation_et" disabled style="width:100%; height:7em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismibtn" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
</div>

<!-- Modal error validation-->
<div class="modal" id="tara" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation_tara" disabled style="width:100%; height:7em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
</div>

<script src="{{ url('categories.js') }}"></script>
@endsection