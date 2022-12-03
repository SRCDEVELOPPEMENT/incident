@extends('layouts.main')


@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

                    <!-- Page Heading -->

                    <p class="mb-4">
                      @can('creer-statut')
                          <button type="button" name="btnstats" data-statuts="{{ $statuts }}" data-toggle="modal" data-target="#modalStatut" data-backdrop="static" data-keyboard="false" class="btn btn-primary btn-icon-split">
                                              <span class="icon text-white-80">
                                                  <i class="fas fa-plus"></i>
                                              </span>
                                              <span class="text">Ajout Statut</span>
                          </button>
                          <a href="{{ URL::to('dashboard')  }}" type="button" class="btn btn-info float-right btn-icon-back">
                                              <span class="icon text-white-80">
                                                  <i class="fas fa-reply"></i>
                                              </span>
                                              <span class="text">Retour</span>
                          </a>
                      @endcan
                    </p>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Liste Des Statuts</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>Statut</th>
                                                <th>Description Statut</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot class="bg-primary text-white">
                                            <tr>
                                                <th>Statut</th>
                                                <th>Description Statut</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                                @foreach($statuts as $statut)
                                                    <tr>
                                                        <td><label class="badge badge-info">{{ $statut->IntituleStatut }}</label></td>
                                                        <td>{{ $statut->DescriptionStatut }}</td>
                                                        <td>
                                                            @can('editer-statut')
                                                                <button class="btn btn-info" id="btnEdit" 
                                                                data-id="{{ $statut->id }}" 
                                                                data-intituleStatut="{{ $statut->IntituleStatut }}"  
                                                                data-DescriptionStatut="{{ $statut->DescriptionStatut }}" ><span class="icon text-white-80"><i class="fas fa-edit"></i></span></button>
                                                            @endcan

                                                            @can('supprimer-statut')
                                                                <button class="btn btn-danger" id="btnDelete" data-id="{{ $statut->id }}"><span class="icon text-white-80"><i class="fas fa-trash"></i></span></button>
                                                            @endcan
                                                            @can('voir-statut')
                                                                <button class="btn btn-primary" id="btnView"><span class="icon text-white-80"><i class="fas fa-eye"></i></span></button>
                                                            @endcan
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

    <div class="modal fade" id="modalStatut" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header  bg-primary text-white">
                <h5 class="modal-title">Ajout Statut Courrier</h5>
                <button type="button" id="btnExit" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="statutFormInsert" autocomplete="off">
                    {{ csrf_field() }}
                        @csrf
                                                <div class="form-group">
                                                <label for="">Statut <span style="color:red;">  *</span></label>
                                                    <input type="text" class="form-control"
                                                        id="statut" name="IntituleStatut"
                                                        placeholder="EX : arrivé">
                                                </div>
                                                <div class="form-group">
                                                    <label>Description</label></br>
                                                    <textarea rows="6" id="Description" name="DescriptionStatut" class="form-control"></textarea>
                                                </div>
                                                <hr>
                                                <button type="button" id="btnSaveStatut" class="btn btn-block btn-primary">Enregistrer</button>
                                                <button type="button" id="btnClose" class="btn btn-block btn-danger" data-dismiss="modal">Fermer</button>
                </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditStatut" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Edition Statut Courrier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="statutFormEdit">
                    {{ csrf_field() }}
                        @csrf
                                                <div class="form-group">
                                                        <input id="id" type="hidden" name="id">
                                                </div>
                                                <div class="form-group">
                                                <label>Statut <span style="color:red;">  *</span></label></br>
                                                    <input type="text" class="form-control"
                                                        id="statuts" name="IntituleStatut"
                                                        placeholder="EX: livrer">
                                                </div>
                                                <div class="form-group">
                                                <label>Description</label></br>
                                                <textarea rows="6" id="Descriptions" name="DescriptionStatut" class="form-control"></textarea>
                                                </div>
                                                <hr>
                                                <button type="button" id="btnEditStatut" class="btn btn-block btn-primary">Editer</button>
                                                <button type="button" class="btn btn-block btn-danger" data-dismiss="modal">Fermer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <script src="{{ url('statuts.js') }}"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ url('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ url('jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ url('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ url('datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ url('js/demo/datatables-demo.js') }}"></script>

@endsection