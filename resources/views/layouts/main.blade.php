<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TRACKING-INCIDENT</title>
    <!-- <link rel="stylesheet" href="{{ url('css/atlantis.min.css') }}"> -->

    <!-- Simple bar CSS -->
    
    <link rel="stylesheet" href="{{ url('css/simplebar.css') }}">
    
    <script src="{{ url('jquery/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="{{ url('css/feather.css') }}">
    <link rel="stylesheet" href="{{ url('css/select2.css') }}">
    <link rel="stylesheet" href="{{ url('css/dropzone.css') }}">
    <link rel="stylesheet" href="{{ url('css/uppy.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/jquery.steps.css') }}">
    <link rel="stylesheet" href="{{ url('css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ url('css/quill.snow.css') }}">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="{{ url('css/daterangepicker.css') }}">
    <style>
      .container{
        width: 500px;
        height: 400px;
        overflow: hidden;
        position: relative;
        margin:50px auto;
      }

      .barcontainer{
        background-color: #343A40;
        position: relative;
        transform: translateY(-50%);
        top: 50%;
        margin-left: 50px;
        width: 1em;
        height: 320px;
        float: left;
        //border darken(#98AFC7, 40%) 3px solid
      }
        
      .bar{
        background-color: #9BC9C7;
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 80%;
        //border-top: 6px solid #FFF;
        box-sizing: border-box;
        animation: grow 1.5s ease-out forwards;
        transform-origin: bottom;
      }
      @keyframes grow{
        from{
          transform: scaleY(0);
        }
      }
    </style>
    <link rel="stylesheet" href="{{ url('css/dataTables.bootstrap4.css') }}">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="{{ url('css/daterangepicker.css') }}">
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ url('css/app-light.css') }}" id="lightTheme" disabled>
    <link rel="stylesheet" href="{{ url('css/app-dark.css') }}" id="darkTheme">

    @notifyCss
</head>
 <body class="vertical dark">
    <div class="wrapper">
      <!-- Topbar -->
        <nav style="font-family: Century Gothic;" class="topnav navbar navbar-light">
          <button style="visibility: hidden;" disabled type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
            <i class="fe fe-menu"></i>
          </button>
          <ul class="nav">
            <li class="nav-item">
            <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="dark">
              <i class="fe fe-sun fe-16"></i>
            </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-muted pr-0" href="#!" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="avatar avatar-sm mt-2">
                  <img src="{{ asset('img/sorepco.jpg') }}" alt="" class="rounded-circle">
                </span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a 
                    class="dropdown-item"
                    href="#!"
                    id="btnProfil"
                    data-user="{{ json_encode(Auth::user()) }}"
                    data-toggle="modal"
                    data-target="#resetModal"
                    data-backdrop="static"
                    data-keyboard="false"><span class="fe fe-16 fe-refresh-cw mr-3"></span> Reinitialisation
                </a>

                <a class="dropdown-item" href="#!" data-toggle="modal" data-target="#logoutModal" data-backdrop="static" data-keyboard="false">
                <span class="fe fe-16 fe-log-out mr-3"></span> Déconnexion</a>
              </div>
            </li>
          </ul>
        </nav>

        
        <aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
          <a href="#!" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
            <i class="fe fe-x"><span class="sr-only"></span></i>
          </a>
          <nav class="vertnav navbar navbar-light" style="font-family: Century Gothic;">

            <div style="margin: 0 auto;" class="w-50 my-4 d-flex">
              <img src="{{ asset('img/sorepco.jpg') }}" alt="..." class="avatar-img rounded-circle">
            </div>

            <ul class="navbar-nav flex-fill w-100 mb-2">
              <li class="w-100">
                <a class="nav-link mb-2" href="{{ URL::to('dashboard') }}">
                  <i class="fe fe-home fe-16"></i>
                  <span class="item-text text-lg ml-3">Tableau De Bord</span>
                </a>
              </li>
            </ul>

            @can('parametrage')
            <p class="text-muted nav-heading mt-4 mb-1">
              <span></span>
            </p>
            <ul class="navbar-nav flex-fill w-100 mb-2">
              <li class="dropdown">
                <a href="#ui-elements" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                  <i class="fe fe-settings fe-16"></i>
                  <span class="ml-3 item-text text-xl">Paramétrage</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="ui-elements">
                  @can('lister-categorie')
                  <li class="nav-item">
                    <a class="nav-link pl-3" href="{{ URL::to('categories') }}"><span class="ml-1 item-text"><i class="fe fe-airplay fe-16 mr-3"></i>Catégorie</span></a>
                  </li>
                  @endcan
                  @can('lister-processus')
                  <li class="nav-item">
                    <a class="nav-link pl-3" href="{{ URL::to('processus') }}"><span class="ml-1 item-text"><i class="fe fe-activity fe-16 mr-3"></i>Procéssus</span></a>
                  </li>
                  @endcan

                  @can('lister-site')
                  <li class="nav-item">
                    <a class="nav-link pl-3" href="{{ URL::to('sites') }}"><span class="ml-1 item-text"><i class="fe fe-home fe-16 mr-3"></i>Site/Service</span></a>
                  </li>
                  @endcan
                  <li class="nav-item">
                    <a class="nav-link pl-3" href="{{ URL::to('types') }}"><span class="ml-1 item-text"><i class="fe fe-type fe-16 mr-2"></i>Type De Site</span></a>
                  </li>
                </ul>
              </li>
            </ul>
            @endcan

            @can('gestion-utilisateur')
            <p class="text-muted nav-heading mt-4 mb-1">
              <span></span>
            </p>
            <ul class="navbar-nav flex-fill w-100 mb-2">
              <li class="dropdown">
                <a href="#profile" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                  <i class="fe fe-user fe-16"></i>
                  <span class="ml-3 item-text text-lg">Gestion Utilisateur</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="profile">
                  @can('lister-role')
                  <a class="nav-link pl-3" href="{{ URL::to('roles') }}"><span class="ml-1"><i class="fe fe-lock fe-16 mr-3"></i>Rôle</span></a>
                  @endcan
                  @can('lister-permission')
                  <a class="nav-link pl-3" href="{{ URL::to('permissions') }}"><span class="ml-1"><i class="fe fe-unlock fe-16 mr-3"></i>Permission</span></a>
                  @endcan
                  @can('lister-utilisateur')
                  <a class="nav-link pl-3" href="{{ URL::to('users') }}"><span class="ml-1"><i class="fe fe-user fe-16 mr-3"></i>Utilisateur</span></a>
                  @endcan
                </ul>
              </li>
            </ul>
            @endcan

            @can('gestion-incident')
            <p class="text-muted nav-heading mt-4 mb-1">
              <span></span>
            </p>

            <ul class="navbar-nav flex-fill w-100 mb-2">
              <li class="w-100">
                <a class="nav-link mb-2" href="{{ route('incidents', ['in' => 1]) }}">
                  <i class="fe fe-bell fe-16"></i>
                  <span class="item-text text-lg ml-3">Incident</span>
                </a>
              </li>
            </ul>

            <ul class="navbar-nav flex-fill w-100 mb-2">
              <li class="w-100">
                <a class="nav-link mb-2" href="{{ route('archivage', ['arc' => 1]) }}">
                  <i class="fe fe-bell fe-16"></i>
                  <span class="item-text text-lg ml-3">Incident Archivé</span>
                </a>
              </li>
            </ul>

            <ul class="navbar-nav flex-fill w-100 mb-2">
              <li class="w-100">
                <a class="nav-link mb-2" href="{{ route('tasks', ['ta' => 1]) }}">
                  <i class="fe fe-bell fe-16"></i>
                  <span class="item-text text-lg ml-3">Suivi Tâche(s)</span>
                </a>
              </li>
            </ul>

            <ul class="navbar-nav flex-fill w-100 mb-2">
              <li class="w-100">

                @if(
                    Auth::user()->roles[0]->name == "COORDONATEUR" ||
                    Auth::user()->roles[0]->name == "SuperAdmin" ||
                    Auth::user()->roles[0]->name == "CONTROLLEUR"
                  )
                  <a class="nav-link mb-2" href="{{ URL::to('tableau_statistique') }}">
                    <i class="fe fe-columns fe-12"></i>
                    <span class="ml-3 item-text text-sm">Tableau De Pilotage</span>
                  </a>
                @endif
              </li>
            </ul>
            @endcan

            <ul class="navbar-nav flex-fill w-100 text-xl mb-2" style="margin-top: 3em;">
              <li class="nav-item w-100 text-center my-2">
                  <span><i style="font-size:3em;" class="fe fe-user"></i></span>
              </li>
              <li class="nav-item w-100 text-center my-4">
                  <span class="item-text">{{ Auth::user()->fullname }}</span>
              </li>
              <li class="nav-item text-center my-1" style="margin-right: 4em;">
                @if(Auth::user()->site_id)
                <span class="badge badge-pill badge-success">
                  SITE
                </span>
                @endif
              </li>
              <li class="nav-item text-center w-100">
                <span>
                {{ Auth::user()->site_id ? Auth::user()->sites->name : "" }}
                  <!-- @if(Auth::user()->site_id)
                      @if(Session::has('sites'))
                        @if(is_iterable(Session::get('sites')))
                          @for($i=0; $i< count(Session::get('sites')); $i++)
                              @if(intval(Session::get('sites')[$i]->id) == intval(Auth::user()->site_id))
                                  {{ Session::get('sites')[$i]->name }}
                                  @break
                              @endif
                          @endfor
                        @endif
                      @endif
                  @endif -->
                </span>
              </li>
            </ul>
          </nav>
        </aside>

        
      @yield('content')

    </div>

    <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="defaultModalLabel">Notifications</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="list-group list-group-flush my-n3">
                    <div class="list-group-item bg-transparent">
                        <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="fe fe-box fe-24"></span>
                        </div>
                        <div class="col">
                            <small><strong>Package has uploaded successfull</strong></small>
                            <div class="my-0 text-muted small">Package is zipped and uploaded</div>
                            <small class="badge badge-pill badge-light text-muted">1m ago</small>
                        </div>
                        </div>
                    </div>
                    <div class="list-group-item bg-transparent">
                        <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="fe fe-download fe-24"></span>
                        </div>
                        <div class="col">
                            <small><strong>Widgets are updated successfull</strong></small>
                            <div class="my-0 text-muted small">Just create new layout Index, form, table</div>
                            <small class="badge badge-pill badge-light text-muted">2m ago</small>
                        </div>
                        </div>
                    </div>
                    <div class="list-group-item bg-transparent">
                        <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="fe fe-inbox fe-24"></span>
                        </div>
                        <div class="col">
                            <small><strong>Notifications have been sent</strong></small>
                            <div class="my-0 text-muted small">Fusce dapibus, tellus ac cursus commodo</div>
                            <small class="badge badge-pill badge-light text-muted">30m ago</small>
                        </div>
                        </div> <!-- / .row -->
                    </div>
                    <div class="list-group-item bg-transparent">
                        <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="fe fe-link fe-24"></span>
                        </div>
                        <div class="col">
                            <small><strong>Link was attached to menu</strong></small>
                            <div class="my-0 text-muted small">New layout has been attached to the menu</div>
                            <small class="badge badge-pill badge-light text-muted">1h ago</small>
                        </div>
                        </div>
                    </div> <!-- / .row -->
                    </div> <!-- / .list-group -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Clear All</button>
                </div>
                </div>
            </div>
    </div>

    <div class="modal fade modal-shortcut modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="defaultModalLabel">Shortcuts</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <div class="row align-items-center">
                    <div class="col-6 text-center">
                        <div class="squircle bg-success justify-content-center">
                        <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
                        </div>
                        <p>Control area</p>
                    </div>
                    <div class="col-6 text-center">
                        <div class="squircle bg-primary justify-content-center">
                        <i class="fe fe-activity fe-32 align-self-center text-white"></i>
                        </div>
                        <p>Activity</p>
                    </div>
                    </div>
                    <div class="row align-items-center">
                    <div class="col-6 text-center">
                        <div class="squircle bg-primary justify-content-center">
                        <i class="fe fe-droplet fe-32 align-self-center text-white"></i>
                        </div>
                        <p>Droplet</p>
                    </div>
                    <div class="col-6 text-center">
                        <div class="squircle bg-primary justify-content-center">
                        <i class="fe fe-upload-cloud fe-32 align-self-center text-white"></i>
                        </div>
                        <p>Upload</p>
                    </div>
                    </div>
                    <div class="row align-items-center">
                    <div class="col-6 text-center">
                        <div class="squircle bg-primary justify-content-center">
                        <i class="fe fe-users fe-32 align-self-center text-white"></i>
                        </div>
                        <p>Users</p>
                    </div>
                    <div class="col-6 text-center">
                        <div class="squircle bg-primary justify-content-center">
                        <i class="fe fe-settings fe-32 align-self-center text-white"></i>
                        </div>
                        <p>Settings</p>
                    </div>
                    </div>
                </div>
                </div>
            </div>
    </div>

    <!-- Modal error reinitialisation -->
    <div class="modal" id="error_resete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="font-family:Century Gothic;">
                                  <div class="modal-dialog modal-xs modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header bg-danger">
                                        <h5 class="modal-title text-xl" id="exampleModalLabel" style="color:white;">
                                        <i class="fe fe-alert-triangle fe-16 mr-2"></i>
                                        Erreur Réinitialisation Mot De Passe</h5>
                                      </div>
                                      <div class="modal-body">
                                          <div class="form-group">
                                          <p id="textreset" disabled style="width:100%; height:7em;border-style:none; resize: none; font-size:19px;" class="form-control"></p>
                                          </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button id="btnRezet" type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
                                      </div>
                                    </div>
                                  </div>
    </div>

    <!-- Logout Modal-->
    <div style="font-family:Century Gothic;" class="modal" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                                    <div class="modal-header text-lg">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            <i class="fe fe-log-out mr-2"></i>
                                            Pret A Partir ?
                                        </h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-lg" style="font-size:17px;">Cliquer Sur Déconnexion méttra Fin à Votre Session. </br> OK ? </div>
                                    <div class="modal-footer">
                                            <button class="btn btn-secondary btn-icon-split" type="button" data-dismiss="modal">
                                                <i class="fe fe-x mr-3"></i>    
                                                Annuler
                                            </button>
                                            <form method="post" action="{{ URL::to('logout') }}">
                                                @csrf
                                                <button class="btn btn-primary btn-icon-split" type="submit">
                                                <i class="fe fe-log-out mr-3"></i>  
                                                Déconnexion</button>
                                            </form>
                                    </div>
                    </div>
            </div>
    </div>
    
    <!-- Modal Reset Password -->
    <div style="font-family:Century Gothic;" id="resetModal" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xs modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="text-lg" id="verticalModalTitle">
                                        <i class="fe fe-key mr-3" style="font-size:20px;"></i>
                                        Réinitialisation Du Mot De Passe</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card shadow" style="padding:2em;">
                                    <div class="mb-3">
                                        <div class="form-group mb-3">
                                            <label for="oldpassword"> <span class="fe fe-key mr-2"></span>Mot De Passe Actuel</label>
                                            <input type="password" placeholder="Veuillez Renseigner Le Mot De Passe Actuel" class="form-control border-primary" id="oldpassword" name="password">
                                            <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="newpassword"> <span class="fe fe-key mr-2"></span>Nouveau Mot De Passe</label>
                                            <input type="password" placeholder="Veuillez Renseigner Le Nouveau Mot De Passe" class="form-control border-primary" id="newpassword" name="password">
                                            <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                        </div>
                                        <div class="form-group my-4">
                                            <label for="confirmpassword"> <span class="fe fe-key mr-2"></span>Confirmer Votre Nouveau Mot De Passe</label>
                                            <input type="password" placeholder="Veuillez Confirmer Le Nouveau Mot De Passe" class="form-control border-primary" id="confirmpassword" name="password">
                                            <div class="invalid-feedback"> Please enter a message in the textarea. </div>
                                        </div>
                                        <div class="form-group my-4">
                                            <button id="resset" data-user="" class="btn btn-sm btn-success btn-block">
                                                <span class="fe fe-key fe-16 mr-3"></span>
                                                Réinitialiser
                                            </button>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                          </div>
                        </div>
    </div>

    <script>
      $(document).on('click', '#btnProfil', function(){
          $('#resset').attr('data-user', $(this).attr('data-user'));
      });

      $(document).on('click', '#resset', function(){
        let reg =  /^(?=.*[0-9])(?=.*[a-z])(?=.*[!"#$%&'()*+,-./:;<=>?@[\]^_`{|}~])/;
        let good = true;
        let message = "";

        if(!$('#oldpassword').val().trim()){
            good = false;
            message+="Veuillez Renseigner Le Mot De Passe Actuel !\n";
        }
        if(!$('#newpassword').val().trim()){
            good = false;
            message+="Veuillez Renseigner Le Nouveau Mot De Passe !\n";
        }else{
          if(!$('#confirmpassword').val().trim()){
            good = false;
            message+="Veuillez Confirmer Le Nouveau Mot De Passe !\n";
          }else{
            if(!($('#newpassword').val().trim() == $('#confirmpassword').val().trim())){
                good = false;
                message+="Veuillez Renseigner Des Mot De Passe Identique !\n";
            }else{
                    if($('#newpassword').val().trim().length < 6){
                        good = false;
                        message+="Votre Nouveau Mot De Passe Doit Contenir Au Moins 6 Caractères !\n";
                    }
                }
          }
        }
        if(!good){
        good = false;
        $('#textreset').text(message)
        $('#resetModal').modal('hide');
        $('#error_resete').attr('data-backdrop', 'static');
        $('#error_resete').attr('data-keyboard', false);
        $('#error_resete').modal('show');
        }else{
          $.ajax({
            type: 'PUT',
            url: "reset_pass",
            data: {
              password: $('#newpassword').val(),
              id: JSON.parse($(this).attr('data-user'))['id']
            },
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                if(data.length == 2){
                  location.reload();
                }else{
                  alert('Veuillez Modifier Votre Mot De Passe, Car Déja Existant !');
                }
            } 
          })
        }

        $(document).on('click', '#btnRezet', function(){
            $('#error_resete').modal('hide');
            $('#resetModal').attr('data-backdrop', 'static');
            $('#resetModal').attr('data-keyboard', false);
            $('#resetModal').modal('show');
        });

      });
    </script>
    <x:notify-messages />
    @notifyJs
  </body>

    <script src="{{ url('js/jquery.min.js') }}"></script>
    <script src="{{ url('js/popper.min.js') }}"></script>
    <script src="{{ url('js/moment.min.js') }}"></script>
    <script src="{{ url('js/bootstrap.min.js') }}"></script>
    <script src="{{ url('js/simplebar.min.js') }}"></script>
    <script src="{{ url('js/daterangepicker.js') }}"></script>
    <script src="{{ url('js/jquery.stickOnScroll.js') }}"></script>
    <script src="{{ url('js/tinycolor-min.js') }}"></script>
    <script src="{{ url('js/config.js') }}"></script>

    <script src="{{ url('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
      $('#dataTable-1').DataTable(
      {
        autoWidth: true,
        "lengthMenu": [
          [16, 32, 64, -1],
          [16, 32, 64, "All"]
        ]
      });
      $('#dataTable-2').DataTable(
      {
        autoWidth: true,
        "lengthMenu": [
          [16, 32, 64, -1],
          [16, 32, 64, "All"]
        ]
      });
    </script>

    <!-- <script src="{{ url('js/d3.min.js') }}"></script> -->
    <!-- <script src="{{ url('js/topojson.min.js') }}"></script>
    <script src="{{ url('js/datamaps.all.min.js') }}"></script>
    <script src="{{ url('js/datamaps-zoomto.js') }}"></script>
    <script src="{{ url('js/datamaps.custom.js') }}"></script> -->
    <!-- <script src="{{ url('js/Chart.min.js') }}"></script> -->
    <!-- <script>
      Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
      Chart.defaults.global.defaultFontColor = colors.mutedColor;
    </script> -->
    <script src="{{ url('js/gauge.min.js') }}"></script>
    <script src="{{ url('js/jquery.sparkline.min.js') }}"></script>
    <!-- <script src="{{ url('js/apexcharts.min.js') }}"></script> -->
    <!-- <script src="{{ url('js/apexcharts.custom.js') }}"></script> -->
    <script src="{{ url('js/jquery.mask.min.js') }}"></script>
    <script src="{{ url('js/select2.min.js') }}"></script>
    <script src="{{ url('js/jquery.steps.min.js') }}"></script>
    <script src="{{ url('js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('js/jquery.timepicker.js') }}"></script>
    <script src="{{ url('js/dropzone.min.js') }}"></script>
    <script src="{{ url('js/uppy.min.js') }}"></script>
    <script src="{{ url('js/quill.min.js') }}"></script>
    <script>
      $('.select2').select2(
      {
        theme: 'bootstrap4',
      });
      $('.select2-multi').select2(
      {
        multiple: true,
        theme: 'bootstrap4',
      });

      $('#process_edit').select2(
      {
        multiple: true,
        theme: 'bootstrap4',
      });
      
      $('.drgpicker').daterangepicker(
      {
        singleDatePicker: true,
        timePicker: false,
        showDropdowns: true,
        locale:
        {
          format: 'MM/DD/YYYY'
        }
      });
      $('.time-input').timepicker(
      {
        'scrollDefault': 'now',
        'zindex': '9999' /* fix modal open */
      });
      /** date range picker */
      if ($('.datetimes').length)
      {
        $('.datetimes').daterangepicker(
        {
          timePicker: true,
          startDate: moment().startOf('hour'),
          endDate: moment().startOf('hour').add(32, 'hour'),
          locale:
          {
            format: 'M/DD hh:mm A'
          }
        });
      }
      var start = moment().subtract(29, 'days');
      var end = moment();

      function cb(start, end)
      {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      }
      $('#reportrange').daterangepicker(
      {
        startDate: start,
        endDate: end,
        ranges:
        {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
      }, cb);
      cb(start, end);
      $('.input-placeholder').mask("00/00/0000",
      {
        placeholder: "__/__/____"
      });
      $('.input-zip').mask('00000-000',
      {
        placeholder: "____-___"
      });
      $('.input-money').mask("#.##0,00",
      {
        reverse: true
      });
      $('.input-phoneus').mask('(000) 000-0000');
      $('.input-mixed').mask('AAA 000-S0S');
      $('.input-ip').mask('0ZZ.0ZZ.0ZZ.0ZZ',
      {
        translation:
        {
          'Z':
          {
            pattern: /[0-9]/,
            optional: true
          }
        },
        placeholder: "___.___.___.___"
      });
      // editor
      var editor = document.getElementById('editor');
      if (editor)
      {
        var toolbarOptions = [
          [
          {
            'font': []
          }],
          [
          {
            'header': [1, 2, 3, 4, 5, 6, false]
          }],
          ['bold', 'italic', 'underline', 'strike'],
          ['blockquote', 'code-block'],
          [
          {
            'header': 1
          },
          {
            'header': 2
          }],
          [
          {
            'list': 'ordered'
          },
          {
            'list': 'bullet'
          }],
          [
          {
            'script': 'sub'
          },
          {
            'script': 'super'
          }],
          [
          {
            'indent': '-1'
          },
          {
            'indent': '+1'
          }], // outdent/indent
          [
          {
            'direction': 'rtl'
          }], // text direction
          [
          {
            'color': []
          },
          {
            'background': []
          }], // dropdown with defaults from theme
          [
          {
            'align': []
          }],
          ['clean'] // remove formatting button
        ];
        var quill = new Quill(editor,
        {
          modules:
          {
            toolbar: toolbarOptions
          },
          theme: 'snow'
        });
      }
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function()
      {
        'use strict';
        window.addEventListener('load', function()
        {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');
          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form)
          {
            form.addEventListener('submit', function(event)
            {
              if (form.checkValidity() === false)
              {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
    <script>
      var uptarg = document.getElementById('drag-drop-area');
      if (uptarg)
      {
        var uppy = Uppy.Core().use(Uppy.Dashboard,
        {
          inline: true,
          target: uptarg,
          proudlyDisplayPoweredByUppy: false,
          theme: 'dark',
          width: 770,
          height: 210,
          plugins: ['Webcam']
        }).use(Uppy.Tus,
        {

        });
        uppy.on('complete', (result) =>
        {
          console.log('Upload complete! We’ve uploaded these files:', result.successful)
        });
      }
    </script>
    <script src="{{ url('js/apps.js') }}"></script>
</html>