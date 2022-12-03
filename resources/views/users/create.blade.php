@extends('layouts.main')


@section('content')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                                <!-- Sidebar Toggle (Topbar) -->
                                <form class="form-inline">
                                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                                        <i class="fa fa-bars"></i>
                                    </button>
                                </form>

                                <!-- Topbar Search -->
                                <form
                                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                            aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Topbar Navbar -->
                                <ul class="navbar-nav ml-auto">

                                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                                    <li class="nav-item dropdown no-arrow d-sm-none">
                                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-search fa-fw"></i>
                                        </a>
                                        <!-- Dropdown - Messages -->
                                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                            aria-labelledby="searchDropdown">
                                            <form class="form-inline mr-auto w-100 navbar-search">
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-light border-0 small"
                                                        placeholder="Search for..." aria-label="Search"
                                                        aria-describedby="basic-addon2">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button">
                                                            <i class="fas fa-search fa-sm"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </li>

                                    <!-- Nav Item - Alerts -->
                                    <li class="nav-item dropdown no-arrow mx-1">
                                        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-bell fa-fw"></i>
                                            <!-- Counter - Alerts -->
                                            <span class="badge badge-danger badge-counter">3+</span>
                                        </a>
                                        <!-- Dropdown - Alerts -->
                                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                            aria-labelledby="alertsDropdown">
                                            <h6 class="dropdown-header">
                                                Alerts Center
                                            </h6>
                                            <a class="dropdown-item d-flex align-items-center" href="#">
                                                <div class="mr-3">
                                                    <div class="icon-circle bg-primary">
                                                        <i class="fas fa-file-alt text-white"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="small text-gray-500">December 12, 2019</div>
                                                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                                </div>
                                            </a>
                                            <a class="dropdown-item d-flex align-items-center" href="#">
                                                <div class="mr-3">
                                                    <div class="icon-circle bg-success">
                                                        <i class="fas fa-donate text-white"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="small text-gray-500">December 7, 2019</div>
                                                    $290.29 has been deposited into your account!
                                                </div>
                                            </a>
                                            <a class="dropdown-item d-flex align-items-center" href="#">
                                                <div class="mr-3">
                                                    <div class="icon-circle bg-warning">
                                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="small text-gray-500">December 2, 2019</div>
                                                    Spending Alert: We've noticed unusually high spending for your account.
                                                </div>
                                            </a>
                                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                                        </div>
                                    </li>

                                    <!-- Nav Item - Messages -->
                                    <li class="nav-item dropdown no-arrow mx-1">
                                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-envelope fa-fw"></i>
                                            <!-- Counter - Messages -->
                                            <span class="badge badge-danger badge-counter">7</span>
                                        </a>
                                        <!-- Dropdown - Messages -->
                                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                            aria-labelledby="messagesDropdown">
                                            <h6 class="dropdown-header">
                                                Message Center
                                            </h6>
                                            <a class="dropdown-item d-flex align-items-center" href="#">
                                                <div class="dropdown-list-image mr-3">
                                                    <img class="rounded-circle" src="img/undraw_profile_1.svg"
                                                        alt="...">
                                                    <div class="status-indicator bg-success"></div>
                                                </div>
                                                <div class="font-weight-bold">
                                                    <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                                        problem I've been having.</div>
                                                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                                                </div>
                                            </a>
                                            <a class="dropdown-item d-flex align-items-center" href="#">
                                                <div class="dropdown-list-image mr-3">
                                                    <img class="rounded-circle" src="img/undraw_profile_2.svg"
                                                        alt="...">
                                                    <div class="status-indicator"></div>
                                                </div>
                                                <div>
                                                    <div class="text-truncate">I have the photos that you ordered last month, how
                                                        would you like them sent to you?</div>
                                                    <div class="small text-gray-500">Jae Chun · 1d</div>
                                                </div>
                                            </a>
                                            <a class="dropdown-item d-flex align-items-center" href="#">
                                                <div class="dropdown-list-image mr-3">
                                                    <img class="rounded-circle" src="img/undraw_profile_3.svg"
                                                        alt="...">
                                                    <div class="status-indicator bg-warning"></div>
                                                </div>
                                                <div>
                                                    <div class="text-truncate">Last month's report looks great, I am very happy with
                                                        the progress so far, keep up the good work!</div>
                                                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                                </div>
                                            </a>
                                            <a class="dropdown-item d-flex align-items-center" href="#">
                                                <div class="dropdown-list-image mr-3">
                                                    <img class="rounded-circle" src="#"
                                                        alt="...">
                                                    <div class="status-indicator bg-success"></div>
                                                </div>
                                                <div>
                                                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                                        told me that people say this to all dogs, even if they aren't good...</div>
                                                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                                </div>
                                            </a>
                                            <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                                        </div>
                                    </li>

                                    <div class="topbar-divider d-none d-sm-block"></div>

                                    <!-- Nav Item - User Information -->
                                    <li class="nav-item dropdown no-arrow">
                                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->fullname}}</span>
                                            <img class="img-profile rounded-circle"
                                                src="{{ url('img/undraw_profile.svg') }}">
                                        </a>
                                        <!-- Dropdown - User Information -->
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                            aria-labelledby="userDropdown">
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Profile
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Paramètres
                                            </a>
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Activité Connexion
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal" data-backdrop="static" data-keyboard="false">
                                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Déconnexion
                                            </a>
                                        </div>
                                    </li>

                                </ul>
                            </nav>
                <div class="container-fluid">
                            <p class="mb-4">
                                <a href="{{ URL::to('users.index')  }}" type="button" class="btn btn-info float-left btn-icon-back">
                                                    <span class="icon text-white-80">
                                                        <i class="fas fa-reply"></i>
                                                    </span>
                                                    <span class="text">Retour</span>
                                </a>
                            </p></br></br></br>
                 <div style="margin-left:250px;">
                 <form action="users.store" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Nom Complet</strong><span style="color:red;">  *</span>
                                <input type="text" class="form-control" name="fullname" style="border-radius: 10px;"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Matricule</strong><span style="color:red;">  *</span>
                                <input type="text" class="form-control" name="matricule" style="border-radius: 10px;"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong>Téléphone</strong><span style="color:red;">   *</span>
                                <input type="number" class="form-control" name="telephone" style="border-radius: 10px"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong>Site</strong><span style="color:red;">  *</span>
                                <select class="form-control" name="site_id">
                                    <option value="">toto</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong>Email</strong>
                                <input type="text" class="form-control" name="email" style="border-radius: 10px"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong>Nom Utilisateur</strong><span style="color:red;">  *</span>
                                <input type="text" class="form-control" name="login" style="border-radius: 10px"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Mot De Passe</strong><span style="color:red;">  *</span>
                                <input type="password" class="form-control" name="password" style="border-radius: 10px"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Confirmer Mot De Passe</strong><span style="color:red;">  *</span>
                                <input type="password" class="form-control" name="confirm-password" style="border-radius: 10px"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Role</strong><span style="color:red;">  *</span>
                                    <div class="form-group">
                                    <select class="form-control" name="roles">
                                        <option value="">toto</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <button style="margin-left:10px;" type="submit" class="btn btn-primary col-md-2">Soumèttre</button>
                        <button style="margin-left:120px;" class="btn btn-danger col-md-2">Annuler</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
@endsection