<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="{{ url('fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ url('css/sb-admin-2.min.css') }}" rel="stylesheet">
        <link href="{{ url('datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

        <title>TRACKING-INCIDENT</title>
        <style>
            footer{
                position: fixed;
                left: 0;
                bottom: 0;
                width: 100%;
                background-color: #212529;
            }
        </style>
    </head>
    <body style="background-color: #212529;">
            <div class="row" style="width:800px; margin:0 auto;">
                <div style="margin-left:30em; margin-top:8em;">
                    <img src="{{ asset('img/gaine.png') }}" alt="">
                </div>
                <div style="margin-left:-10rem;">
                    <div style="margin-top:-25em;">
                        <h4 style="font-weight:bold;">
                            <span style="color:#1F541D; font-size:70px; font-family: Century Gotic;">SOREPCO. SA</span>
                        </h4>
                        <span style="color:#1F541D; font-size:25px; font-family:Brush Script MT;">Toujours les meilleurs prix.</span>
                    </div>
                    <div style="margin-top: 1em;">
                        </br></br> <h4 class="mb-4" style="color: #FA5941;"> TRACKING-INCIDENT</h4>

                        <h7 style="color: white; font-size:20px;">Avec Tracking-Incident</br>Manager  et suivez plus objectivement</br> les Incidents à l’échelle du groupe Sorepco.</h7></br></br>
                        <a title="Continuer Vers La Page Suivante" class="btn btn-block btn-outline-danger" style="border-radius: 1.5rem; font-size:20px; font-family: Century Gothic;" href="{{ url('login') }}">Suivant
                        <i class="fas fa-lg fa-forward ml-3"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <footer class="sticky-footer bg-dark">
                <div>
                    <div style="font-size:13px;" class="text-center text-gray-500">
                        <span class="mr-3">
                            <i class="fas fa-eye mr-1"></i>
                            <a target="_blank" href="https://groupesorepco.com/">Site Web</a>
                        </span>
                        <span class="mr-3">
                            <i class="fas fa-crosshairs mr-1"></i>
                            Address: Salle des fêtes, Douala Cameroun
                        </span>
                        <span class="mr-3">
                            <i class="fas fa-envelope mr-1"></i>
                            Email: info@groupesorepco.com
                        </span>
                        <span class="mr-3">
                            <i class="fas fa-phone mr-1"></i>
                            Phone: (237) 6 999 66 000
                        </span>
                        <span >
                        <i class="fas fa-thin fa-clock mr-1"></i>
                            Working Days/Hours: Mon - Fri/7:30 AM - 6:00 PM Sam/7:30 AM - 2:00 PM
                        </span>
                    </div>
                    <hr>
                    <div style="font-size:13px;" class="text-center text-gray-500 mr-3">
                        <span class="mr-3"><span class="mr-3">Copyright &copy; SOREPCO SA 2022</span>| Nous Suivre sur les réseaux sociaux</span>
                        <a target="_blank" href="https://www.facebook.com/sorepcogroup"><i class="fab fa-1x fa-facebook mr-1"></i></a>
                        <a target="_blank" href="https://www.youtube.com/channel/UCAyBoJnJxN1fx0QoKNCkd4w"><i class="fab fa-1x fa-youtube mr-1"></i></a>
                        <a target="_blank" href="https://www.instagram.com/sorepcogroup/"><i class="fab fa-1x fa-instagram"></i></a>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
    </body>
</html>
