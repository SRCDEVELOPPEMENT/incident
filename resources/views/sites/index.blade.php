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
                                    Liste Sites</h1>
                                </div>
                                    <div class="col-md-7 text-right">
                                        <button 
                                                id="toto"
                                                data-backdrop="static" 
                                                data-keyboard="false"
                                                title="Déclaration D'incident" 
                                                class="btn btn-icon-split btn-primary"
                                                data-toggle="modal" 
                                                data-target="#modalSite">
                                                <span class="icon text-white-80">
                                                    <i class="fe fe-plus" style="font-size:15px;"></i>
                                                    <i class="fe fe-home mr-3" style="font-size:20px;"></i>
                                                </span>
                                            Ajout Site
                                        </button>
                                    </div>
                                    <!-- <div class="col-md-6 text-right">                                            
                                    </div> -->
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
                                                        <th>SITE</th>
                                                        <th>TYPE DE SITE</th>
                                                        <th>REGION DU SITE</th>
                                                        <th>ACTIONS</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        @if(is_iterable($sites))
                                                        @foreach($sites as $site)
                                                            <tr style="font-size:15px;">
                                                                <td><label>{{ $site->name }}</label></td>
                                                                <td><label>{{ $site->types ? $site->types->name : '' }}</label></td>
                                                                <td><label>{{ $site->region }}</label></td>
                                                                <td>
                                                                    <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <span class="text-muted sr-only">Action</span>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                            <a 
                                                                                id="btn_edi" 
                                                                                data-site="{{ json_encode($site) }}"
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
                                                                                data-site="{{ json_encode($site) }}" 
                                                                                data-incidents="{{ json_encode(Session::get('incidents')) }}"
                                                                                data-users="{{ json_encode(Session::get('users')) }}"
                                                                                class="dropdown-item" href="#">
                                                                                <span class="fe fe-x mr-4"></span>
                                                                                Supprimer
                                                                            </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        @endif
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>

        </div>
    </div>
    <!-- /.container-fluid -->
    
    <div style="font-family:Century Gothic;" class="modal" id="modalSite" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="text-xl ">
                <span class="icon text-white-80">
                            <i class="fe fe-plus" style="font-size:10px;"></i>
                            <i class="fe fe-home mr-3"></i>
                    </span>
                Ajout Site</h5>
                <button type="button" id="btnClose" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="card shadow" style="padding:2em;">
                        <form id="siteFormInsert" autocomplete="off">
                        {{ csrf_field() }}
                            @csrf
                                                    <div class="row">
                                                        <div class="form-group col-md-12 my-4">
                                                            <label for="site"> Région Du Site <span style="color:red;"> *</span></label>
                                                            <select style="font-size:20px;" class="form-control" id="site_region" name="region">
                                                                <option value="">Choisissez...</option>
                                                                @if(is_iterable($regions))
                                                                @foreach($regions as $region)
                                                                <option value="{{ $region }}">{{ $region }}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-12 my-4">
                                                            <label for="site"> Type Du Site <span style="color:red;"> *</span></label>
                                                            <select style="font-size:20px;" class="form-control" id="site_type" name="type">
                                                                <option value="">Choisissez...</option>
                                                                @if(is_iterable($types))
                                                                @foreach($types as $type)
                                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="site"> Désignation Du Site <span style="color:red;"> *</span></label>
                                                        <input style="font-size:20px;" type="text" class="form-control"
                                                            id="site" name="name"
                                                            placeholder="Veuillez Renseigner Un Site">
                                                    </div>
                                                    <hr class="my-4">
                                                    <div class="row">
                                                        <button  type="button" data-sites="{{ json_encode(Session::get('sites')) }}" id="btnSaveSite" class="btn btn-primary col-md-5 mr-4 ml-3">
                                                            <i class="fe fe-check" ></i>
                                                            <i class="fe fe-home mr-2"></i>
                                                            Enrégistrer
                                                        </button>
                                                        <button type="button" id="btnExit" class="btn btn-danger col-md-5">
                                                            <i class="fe fe-x"></i>
                                                            <i class="fe fe-home mr-2"></i>
                                                            Annuler</button>
                                                    </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                                                <div class="form-group">
                                                <label for="site"> Type De Site <span style="color:red;"> *</span></label>
                                                    <input style="font-size:20px;" type="text" class="form-control"
                                                        id="type_site" name="name"
                                                        placeholder="Veuillez Renseigner Un Type De Site">
                                                </div>
                                                <hr class="my-4">
                                                <div class="row">
                                                    <button  type="button" id="btnType_Site" class="btn btn-primary col-md-5 mr-4 ml-3" data-types="{{ json_encode(Session::get('types')) }}">
                                                        <i class="fe fe-check" ></i>
                                                        <i class="fe fe-type mr-2"></i>
                                                        Enrégistrer
                                                    </button>
                                                </div>
                </div>
            </div>
        </div>
    </div>

    <div style="font-family:Century Gothic;" class="modal" id="modalEditSite" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="text-lg">
                        <span class="icon text-white-80">
                                <i class="fe fe-edit-2" style="font-size:10px;"></i>
                                <i class="fe fe-16 fe-home mr-3"></i>
                        </span>
                    Edition Site
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="card shadow" style="padding:2em;">
                        <form id="siteFormEdit">
                        {{ csrf_field() }}
                            @csrf
                                                    <div class="form-group">
                                                        <input id="id" type="hidden" name="id">
                                                    </div>
                                                    <div class="form-group my-4">
                                                            <label for="site_regions"> Région Du Site <span style="color:red;"> *</span></label>
                                                            <select style="font-size:20px;" class="form-control" id="site_regions" name="region">
                                                                <option value="">Choisissez...</option>
                                                                @if(is_iterable($regions))
                                                                @foreach($regions as $region)
                                                                <option value="{{ $region }}">{{ $region }}</option>
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                    </div>
                                                    <div class="form-group my-4">
                                                        <label for="site"> Type Du Site <span style="color:red;"> *</span></label>
                                                        <select style="font-size:20px;" class="form-control" id="site_types" name="type">
                                                            <option value="">Choisissez...</option>
                                                            @if(is_iterable($types))
                                                            @foreach($types as $type)
                                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group my-4">
                                                        <label for="site"> Désignation Du Site <span style="color:red;"> *</span></label>
                                                        <input style="font-size:20px;" type="text" class="form-control"
                                                            id="sites" name="name"
                                                            placeholder="Veuillez Renseigner Un Site">
                                                    </div>
                                                    <hr class="my-4">
                                                    <button type="button" id="btnEditSite" class="btn btn-primary col-md-5 mr-4 ml-3">
                                                        <i class="fe fe-check mr-1" style="font-size:10px;"></i>
                                                        <i class="fe fe-home mr-2"></i>
                                                        Modifier
                                                    </button>
                                                    <button type="button" id="btnExit_site" class="btn btn-danger col-md-5">
                                                        <i class="fe fe-x mr-1"></i>
                                                        <i class="fe fe-home mr-2"></i>
                                                        Annuler
                                                    </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmation Save Site -->
    <div class="modal fade" id="modalConfirmationSaveSite" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                                                                                    <i style="color:#E02D1B;" class="fas fa-home mr-2"></i>
                                                                                                    <span  class="badge badge-success">
                                                                                                    SITE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                    <span style="color: black; font-size: 20px;" id="site_conf"></span>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-globe mr-2"></i>
                                                                                                    <span  class="badge badge-success">
                                                                                                    REGION</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                    <span style="color: black; font-size: 20px;" id="region_conf"></span>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-info mr-2"></i>
                                                                                                    <span  class="badge badge-success">
                                                                                                    TYPE DE SITE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="type_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            <tbody>
                                                        </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="conf_save_site" data-sites="{{ json_encode(Session::get('sites')) }}" class="btn btn-primary">OUI</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NON</button>
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
    <div class="modal" id="error_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
            style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation_edit" disabled style="width:100%; height:7em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="dismiss_bouton" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal error validation-->
    <div class="modal" id="errordel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur De Suppréssion</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation_del" disabled style="width:100%; height:6em;border-style:none; resize: none; font-size:19px;" class="form-control bg-light"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <script src="{{ url('sites.js') }}"></script>
@endsection