@extends('layouts.main')


@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid" style="font-family: 'Century Gothic';">
                    <!-- Page Heading -->

                    <p class="mb-4">
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <a href="{{ URL::to('dashboard')  }}" type="button" class="btn btn-info float-left btn-icon-back">
                                                    <span class="icon text-white-80">
                                                        <i class="fas fa-reply"></i>
                                                    </span>
                                                    <span class="text">Retour</span>
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                            @can('creer-livraison')
                                <button type="button" data-toggle="modal" data-target="#modalLivraison" data-backdrop="static" data-keyboard="false" class="btn btn-dark btn-icon-split">
                                                    <span class="icon text-white-80">
                                                        <i class="fas fa-plus" style="font-size:10px;"></i>
                                                        <i class="fas fa-truck fa-lg"></i>
                                                        <i style="font-size:10px;" class="fas fa-clock"></i>
                                                    </span>
                                                    <span class="text">Ajout Livraison</span>
                                </button>
                            @endcan
                            </div>
                        </div>
                    </p>
                    <?php 
                        $site_user_connecte = DB::table('sites')->where('id', '=', auth()->user()->site_id)->get();
                    ?>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="text-left" style="color:black; font-size:20px;">
                                    Liste Des Livraison
                                </div>
                                <div class="col-md-12 text-right"></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="bg-dark text-white">
                                            <tr>
                                            <th>BON</th>
                                                <th>POINT DEPART</th>
                                                <th>INFOS CLIENT</th>
                                                <th>ETAT</th>
                                                <th>DATE</th>
                                                <th>CONTRIBUTION</th>
                                                <th>VEHICULE</th>
                                                <th>ITINERAIRE</th>
                                                <th>OBSERVATION</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tfoot class="bg-dark text-white">
                                            <tr>
                                                <th>BON</th>
                                                <th>POINT DEPART</th>
                                                <th>INFOS CLIENT</th>
                                                <th>ETAT</th>
                                                <th>DATE</th>
                                                <th>CONTRIBUTION</th>
                                                <th>VEHICULE</th>
                                                <th>ITINERAIRE</th>
                                                <th>OBSERVATION</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                                @foreach($livraisons as $livraison)
                                                    <tr style="font-size:15px; color:black;">
                                                        <td><label style="font-size:1.3em;" class="badge badge-primary">{{ $livraison->order_number }}</label></td>
                                                        @if(count($site_user_connecte) > 0)
                                                        <td><label>{{ $site_user_connecte[0]->site_name }}</label></td>
                                                        @else
                                                        <td><label></label></td>
                                                        @endif
                                                        <!-- <td><label>{{ $livraison->destination }}</label></td> -->
                                                        <td><label>{{ $livraison->nom_client }}  {{ $livraison->phone_client }}</label></td>
                                                        <td><label style="font-size:0.9em;" class="badge badge-success">{{ $livraison->state }}</label></td>
                                                        <td><label>{{ $livraison->delivery_date }}</label></td>
                                                        <td><label>{{ $livraison->delivery_amount }}</label></td>
                                                        <td><label>{{ $livraison->vehicules->Immatriculation }}</label></td>
                                                        <td><label>{{ $livraison->itinerary }}</label></td>
                                                        <td>{{ $livraison->observation }}</td>
                                                        <td>
                                                            @can('editer-livraison')
                                                            <button 
                                                                {{$livraison->state != 'LIVRER' ? '' : 'disabled'}}
                                                                {{$livraison->state != 'ANNULER' ? '' : 'disabled'}} 
                                                                class="btn btn-sm btn-info mr-2" 
                                                                id="btnEdit" 
                                                                data-livraisons="{{ $livraison }}" 
                                                                data-id="{{ $livraison->id }}">
                                                                <span class="icon text-white-80">
                                                                    <i class="fas fa-lg fa-truck"></i>
                                                                    <i class="fas fa-sm fa-pen"></i>
                                                                </span>
                                                            </button>
                                                            @endcan
                                                            @can('supprimer-livraison')
                                                            <button 
                                                                {{$livraison->state != 'LIVRER' ? '' : 'disabled'}}
                                                                {{$livraison->state != 'ANNULER' ? '' : 'disabled'}}
                                                                class="btn btn-sm btn-danger" 
                                                                id="btnDelete" data-id="{{ $livraison->id }}">
                                                                <span class="icon text-white-80">
                                                                    <i class="fas fa-lg fa-truck"></i>
                                                                    <i class="fas fa-sm fa-times"></i>
                                                                </span>
                                                            </button>
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

    <div class="modal fade" id="modalLivraison" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header  bg-dark text-white">
                <h5 class="modal-title">
                    <span class="icon text-white-80">
                        <i class="fas fa-plus" style="font-size:10px;"></i>
                        <i class="fas fa-truck fa-lg mr-3"></i>
                    </span>
                Ajout Livraison</h5>
                <button type="button" id="btnClose" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="livraisonFormInsert" autocomplete="off">
                    {{ csrf_field() }}
                        @csrf
                                                <div class="form-group">
                                                    <label>Type De Livraison <span style="color:red;"> *</span></label></br>
                                                    <select class="form-control" id="type_delivery" name="">
                                                        <option value="">Séléctionner Un Type De Livraison</option>
                                                        <option value="0">Payante</option>
                                                        <option value="1">Gratuite Autorisé</option>
                                                        <option value="1">Gratuite</option>
                                                        <option value="0">Prospection</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                        <label>Véhicule <span style="color:red;">  *</span></label></br>
                                                        <select class="form-control" id="vehicule_id" name="vehicule_id">
                                                            <option value="">Séléctionner Un Véhicule</option>
                                                            @foreach($cars as $car)
                                                                <option value="{{ $car->id }}">{{ $car->Immatriculation }} - {{ $car->tonnage }} Tonne</option>
                                                            @endforeach
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Elément De Recètte</label></br>
                                                    <select class="form-control" data-r="{{ $recipes }}" id="recipe_id" name="recipe_id">
                                                        <option value="">Séléctionner Une Recètte</option>
                                                        @foreach($recipes as $recipe)
                                                            <option value="{{ $recipe->id }}">{{ $recipe->nature }} - {{ $recipe->value }} FCFA - {{ $recipe->itinerary }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Distance (Kilomètre)</label></br>
                                                        <input type="number" class="form-control"
                                                            id="distance" name="distance">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="">Numéro Du Bon <span style="color:red;">  *</span></label>
                                                        <input type="text" class="form-control"
                                                            id="order_number" name="order_number">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <!-- <div class="form-group col-md-6">
                                                        <label>Destination <span style="color:red;">  *</span></label></br>
                                                        <input type="text" class="form-control"
                                                            id="destination" name="destination">
                                                    </div> -->
                                                    <div class="form-group col-md-6">
                                                        <label>Tonnage Marchandise (T)</label></br>
                                                        <input type="number" class="form-control"
                                                            id="tonnage" name="tonnage">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Itinéraire <span style="color:red;">  *</span></label></br>
                                                        <input type="text" class="form-control"
                                                            id="itinerary" name="itinerary">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Montant A Payer</label></br>
                                                        <input type="text" class="form-control" disabled id="vue_amount">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Montant Réelle Payé</label></br>
                                                        <input type="text" class="form-control" id="amount_paye">
                                                    </div>
                                                    <!-- <div class="form-group col-md-6">
                                                        <label>Distance (KM)</label></br>
                                                        <input type="number" class="form-control"
                                                            id="distance" name="distance">
                                                    </div> -->
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="">Nom Client <span style="color:red;">  *</span></label>
                                                        <input type="text" class="form-control"
                                                            id="nom_client" name="nom_client">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="">Téléphone Client<span style="color:red;">  *</span></label>
                                                        <input type="tel" class="form-control"
                                                            id="phone_client" name="phone_client">
                                                    </div>
                                                </div>
                                                    <div class="form-group">
                                                        <label>Date Livraison<span style="color:red;">  *</span></label></br>
                                                        <input type="date" class="form-control"
                                                            id="delivery_date" name="delivery_date">
                                                    </div>
                                                <div class="form-group">
                                                    <label>Observation</label></br>
                                                    <textarea type="text" class="form-control" name="observation" id="observation"></textarea>
                                                </div>
                                                <div class="row">
                                                    <button type="button" id="btnAddLivraison" class="btn btn-primary col-md-5 mr-3 ml-3">
                                                        <i class="fas fa-check mr-1" style="font-size:10px;"></i>
                                                        <i class="fas fa-truck fa-lg"></i>
                                                        <i class="fas fa-clock fa-sm mr-2"></i>
                                                        Enrégistrer
                                                    </button>
                                                    <button type="button" id="btnAnnuler" class="btn btn-danger col-md-6">
                                                        <i class="fas fa-times" style="font-size:10px;"></i>
                                                        <i class="fas fa-truck fa-lg"></i>
                                                        <i class="fas fa-clock fa-sm mr-2"></i>
                                                        Annuler
                                                    </button>
                                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditlivraison" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">
                <span class="icon text-white-80">
                <i class="fas fa-pen mr-1" style="font-size:10px;"></i>
                <i class="fas fa-truck fa-lg"></i>
                <i class="fas fa-clock mr-3" style="font-size:10px;"></i>
                    </span>
                Edition Livraison</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <form id="livraisonFormEdit">
                    {{ csrf_field() }}
                        @csrf
                                                <div class="form-group">
                                                        <input id="id" type="hidden" name="id">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Numéro Du Bon <span style="color:red;">  *</span></label>
                                                    <input type="text" class="form-control"
                                                        id="order_numbers" name="order_number">
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label for="">Nom Client <span style="color:red;">  *</span></label>
                                                        <input type="text" class="form-control"
                                                            id="nom_clients" name="nom_client">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="">Téléphone Client<span style="color:red;">  *</span></label>
                                                        <input type="tel" class="form-control"
                                                            id="phone_clients" name="phone_client">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Véhicule <span style="color:red;">  *</span></label></br>
                                                    <select class="form-control" id="vehicule_ids" name="vehicule_id">
                                                        <option value="">Séléctionner Un Véhicule</option>
                                                        @foreach($cars as $car)
                                                            <option value="{{ $car->id }}">{{ $car->Immatriculation }} - {{ $car->tonnage }} Tonne</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Date Livraison<span style="color:red;">  *</span></label></br>
                                                        <input type="date" class="form-control"
                                                            id="delivery_dates" name="delivery_date">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Date Réelle Livraison<span style="color:red;">  *</span></label></br>
                                                        <input type="date" class="form-control"
                                                            id="really_delivery_date" name="really_delivery_date">
                                                    </div>
                                                </div>
                                                    <div class="form-group">
                                                        <label>Itinéraire <span style="color:red;">  *</span></label></br>
                                                        <input type="text" class="form-control"
                                                            id="itinerarys" name="itinerary">
                                                    </div>
                                                <div class="form-group">
                                                    <label>Etat Livraison <span style="color:red;">  *</span></label></br>
                                                    <select class="form-control" id="states" name="state">
                                                        <option value="">Séléctionner Un Etat</option>
                                                        <option value="ENCOUR">ENCOURS</option>
                                                        <option value="ANNULER">ANNULER</option>
                                                        <option value="LIVRER">LIVRER</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Observation</label></br>
                                                    <textarea type="text" class="form-control" name="observation" id="observations"></textarea>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <button type="button" id="btnEditLivraison" class="btn btn-primary col-md-6 mr-2 ml-2">
                                                        <i class="fas fa-check mr-1" style="font-size:10px;"></i>
                                                        <i class="fas fa-truck fa-lg mr-2"></i>Modifier
                                                    </button>
                                                    <button type="button" id="btnExit" class="btn btn-danger col-md-5" data-dismiss="modal">
                                                        <i class="fas fa-times fa-lg mr-2"></i>
                                                        Fermer
                                                    </button>
                                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmation Save Livraison -->
    <div class="modal fade" id="modalConfirmationSaveLivraison" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                                                                                    <i style="color:#E02D1B;" class="fas fa-hashtag mr-2"></i>
                                                                                                    <span  class="badge badge-success">
                                                                                                    NUMERO BON</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                    <span style="color: black; font-size: 20px;" id="order_number_conf"></span>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-road mr-2"></i>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    ITINERAIRE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="itineraire_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-user mr-2"></i>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    CLIENT</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="client_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-weight mr-2"></i>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    TONNAGE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="tonnage_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-road mr-2"></i>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    DISTANCE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="distance_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-info mr-2"></i>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    RECETTE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="recette_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-truck mr-2"></i>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    VEHICULE</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="car_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-clock mr-2"></i>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    Date De Livraison</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="date_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                    <i style="color:#E02D1B;" class="fas fa-info mr-2"></i>
                                                                                                    <span  class="badge badge-primary">
                                                                                                    Observation</span>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="form-group">
                                                                                                            <span style="color: black; font-size: 20px;" id="observation_conf"></span>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            <tbody>
                                                        </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-livraisons="{{ $livraisons }}" id="conf_save_livraison" class="btn btn-primary">OUI</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">NON</button>
                                </div>
                            </div>
                        </div>
    </div> 

    <!-- Modal error validation-->
    <div class="modal fade" id="errorvalidationsModals" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header" style="background-color:red;">
                                        <h5 class="modal-title" id="exampleModalLabel" style="color:white;">Erreur</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <textarea id="validation" disabled style="width:100%; height:290px ;border-style:none; background-color:white;resize: none;color:black; font-size:19px;" class="form-control"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>
    
    
    <script src="{{ url('livraison.js') }}"></script>
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