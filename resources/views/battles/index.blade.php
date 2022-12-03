@extends('layouts.main')


@section('content')

    <div class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                        <div class="card-header py-3">
                            <div class="row mb-4" style="font-family: Century Gothic;">
                                <a title="Retour A La Liste Des Incidents" href="{{ URL::to('incidents') }}" style="border-radius: 3em;" class="btn btn-outline-primary"><span class="fe fe-corner-up-left fe-16 mr-2"></span><span class="text">Retour</span></a>
                            </div>
                            <div class="row">
                                <div class="col-md-6 text-xl text-uppercase text-left">
                                    <h2 class="mb-2">
                                    <span class="fe fe-info"></span>    
                                    Liste Travaux Réalisés</h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button 
                                            id="bnt_battle"
                                            data-number="{{ $number }}"
                                            data-backdrop="static" 
                                            data-keyboard="false"
                                            title="Ajout D'un Travail Réalisé" 
                                            style="background-color: #345B86;" 
                                            class="btn btn-icon-split"
                                            data-toggle="modal" 
                                            data-target="#battles">
                                        <span class="icon text-white-80">
                                            <i class="fe fe-check-circle mr-3" style="font-size:20px;"></i>
                                        </span>
                                        Ajout Travail Réalisé
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- <p class="card-text">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, built upon the foundations of progressive enhancement, that adds all of these advanced features to any HTML table. </p> -->
                        <div class="row my-4">
                            <!-- Small table -->
                            <div class="col-md-12">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-md-3">
                                            </div>
                                            <div class="col-md-9 text-right">

                                            </div>
                                        </div>
                                        <!-- table -->
                                        <table class="table table-borderless table-hover" id="dataTable-1">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th></th>
                                                    <th>N°</th>
                                                    <th>Catégorie</th>
                                                    <th>Description</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($battles as $key => $battle)
                                                    <tr>
                                                        <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input">
                                                            <label class="custom-control-label"></label>
                                                        </div>
                                                        </td>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $battle->title }}</td>
                                                        <td><p class="mb-0 text-muted">{{ $battle->description }}</p></td>
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
                                          <textarea id="validation" disabled style="width:100%; height:10em;border-style:none; resize: none;color:white; background-color: #495057; font-size:19px;" class="form-control"></textarea>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Modal Battles Incident -->
    <div id="battles" style="font-family: Century Gothic;" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="verticalModalTitle">
                                        <i class="fe fe-check-circle mr-3" style="font-size:20px;"></i>
                                    Travaux Réalisés <span class="ml-4" id="batt_inc"></span>
                                </h5>
                                <button id="bat_boy" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="frm_bat" autocomplete="off">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="id_incidan" id="num_In">
                                    <div class="row mb-4">
                                        <div class="card shadow col-xs-12 ml-5 mr-5">
                                            <div class="card-header">
                                                    <strong>
                                                        Travail 1
                                                    </strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group mb-3">
                                                    <label for="simpleinput" style="font-size: 15px;">Catégorie Du Travail (Ex: Plomberie | Elèctricité | Maconnerie)</label>
                                                    <input style="font-size:17px; font-family: Century Gothic;" type="text" id="cat1" name="title" class="form-control">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="description" style="font-size: 15px;"> <span class="fe fe-edit-2 mr-1"></span> A Propos Du Travail (Décrivez Le Travail Effectué !)</label>
                                                    <textarea style="resize:none; font-size:17px; font-family: Century Gothic;" rows="5" class="form-control" id="description1" name="description" placeholder="Veuillez Entrer Une Description Précise."></textarea>
                                                    <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card shadow col-xs-12">
                                            <div class="card-header">
                                                    <strong>
                                                        Travail 2
                                                    </strong>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group mb-3">
                                                    <label for="simpleinput" style="font-size: 15px;">Catégorie Du Travail (Ex: Plomberie | Elèctricité | Maconnerie)</label>
                                                    <input style="font-size:17px; font-family: Century Gothic;" type="text" id="cat2" name="title2" class="form-control">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="description" style="font-size: 15px;"> <span class="fe fe-edit-2 mr-1"></span> A Propos Du Travail (Décrivez Le Travail Effectué !)</label>
                                                    <textarea style="resize:none; font-size:17px; font-family: Century Gothic;" rows="5" class="form-control" id="description2" name="description2" placeholder="Veuillez Entrer Une Description Précise."></textarea>
                                                    <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ml-4">
                                        <div class="col-md-3">
                                            <button id="btnSaveBattle" type="button" class="btn btn-sm btn-outline-primary btn-block">
                                                <span class="fe fe-check-circle fe-16 mr-3 text-white"></span>
                                                <span style="font-size: 20px; color:white;">Valider</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                          </div>
                        </div>
    </div> <!-- small modal -->

    <script src="{{ url('battles.js') }}"></script>

@endsection