
<!DOCTYPE html>
<html>
    <?php

        $ouest_encours = 0;
        $ouest_clotures = 0;
        $ouest_annules = 0;

        $nord_ouest_encours = 0;
        $nord_ouest_clotures = 0;
        $nord_ouest_annules = 0;

        $sud_ouest_encours = 0;
        $sud_ouest_clotures = 0;
        $sud_ouest_annules = 0;

        $centre_encours = 0;
        $centre_clotures = 0;
        $centre_annules = 0;

        $littoral_encours = 0;
        $littoral_clotures = 0;
        $littoral_annules = 0;

        $sud_encours = 0;
        $sud_clotures = 0;
        $sud_annules = 0;

        $adamaoua_encours = 0;
        $adamaoua_clotures = 0;
        $adamaoua_annules = 0;

        $est_encours = 0;
        $est_clotures = 0;
        $est_annules = 0;

        if(is_iterable($incidents)){
            for ($g=0; $g < count($incidents); $g++) {
    
                $inci = $incidents[$g];
    
                switch ($inci->sites->region) {
                    case 'OUEST':
                        if($inci->status == "CLÔTURÉ"){
                            $ouest_clotures +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $ouest_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $ouest_annules +=1;
                        }

                        break;
                    case 'NORD-OUEST':
                        if($inci->status == "CLÔTURÉ"){
                            $nord_ouest_clotures +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $nord_ouest_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $nord_ouest_annules +=1;
                        }

                        break;
                    case 'CENTRE':
                        if($inci->status == "CLÔTURÉ"){
                            $centre_clotures +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $centre_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $centre_annules +=1;
                        }

                        break;
                    case 'LITTORAL':
                        if($inci->status == "CLÔTURÉ"){
                            $littoral_clotures +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $littoral_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $littoral_annules +=1;
                        }

                        break;
                    case 'SUD':
                        if($inci->status == "CLÔTURÉ"){
                            $sud_clotures +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $sud_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $sud_annules +=1;
                        }

                        break;
                    case 'ADAMAOUA':
                        if($inci->status == "CLÔTURÉ"){
                            $adamaoua_clotures +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $adamaoua_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $adamaoua_annules +=1;
                        }

                        break;
                    case 'EST':
                        if($inci->status == "CLÔTURÉ"){
                            $est_clotures +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $est_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $est_annules +=1;
                        }

                        break;
                    default:
                        break;
                }
        }}
    
    ?>
<head>
    <title></title>
            <style>
                table {
                    border-collapse: collapse;
                    margin:auto;
                    width:100%;
                }
                tr, th, td{
                    border: 2px solid black;
                    text-align:center;
                }
                h1{
                  text-align:center;
                }
            </style>
</head>
<body>
        <h1>Tableau Récapitulatif De La Qté Des Incidents De SOREPCO SA De Toutes Les Régions Du Cameroun De L'année {{ $annee }}</h1>
            
        <table class="table table-hover datatables text-center" id="dataTable-1">
                                                                        <thead class="thead-dark" style="font-family: Century Gothic;">
                                                                            <tr style="font-size: 0.8em;">
                                                                            <th><span class="fe fe-calendar mr-2"></span> REGION</th>
                                                                            <th><span class="dot dot-lg bg-primary mr-2"></span>Incident Encours</th>
                                                                            <th><span class="dot dot-lg bg-dark mr-2"></span>Incident Annulé</th>
                                                                            <th><span class="dot dot-lg bg-success mr-2"></span>Incident Clôturé </th>
                                                                            <th>Incident Total</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody style="font-size:1.3em; font-family: Century Gothic;">
                                                                            <tr>
                                                                            <td>OUEST</td>
                                                                            <td id="janv_encour_year_selec">{{ $ouest_encours < 10 ? 0 ."". $ouest_encours : $ouest_encours }}</td>
                                                                            <td id="janv_annuler_year_selec">{{ $ouest_annules < 10 ? 0 ."". $ouest_annules : $ouest_annules }}</td>
                                                                            <td id="janv_cloture_year_selec">{{ $ouest_clotures < 10 ? 0 ."". $ouest_clotures : $ouest_clotures  }}</td>
                                                                            <td id="janv_total_year_selec">{{ $ouest < 10 ? 0 ."". $ouest : $ouest }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>NORD-OUEST</td>
                                                                            <td id="fev_encour_year_selec">{{ $nord_ouest_encours < 10 ? 0 ."". $nord_ouest_encours : $nord_ouest_encours }}</td>
                                                                            <td id="fev_annuler_year_selec">{{ $nord_ouest_annules < 10 ? 0 ."". $nord_ouest_annules : $nord_ouest_annules }}</td>
                                                                            <td id="fev_cloture_year_selec">{{ $nord_ouest_clotures < 10 ? 0 ."". $nord_ouest_clotures : $nord_ouest_clotures}}</td>
                                                                            <td id="fev_total_year_selec">{{ $nord_ouest < 10 ? 0 ."". $nord_ouest : $nord_ouest}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>CENTRE</td>
                                                                            <td id="avril_encour_year_selec">{{ $centre_encours < 10 ? 0 ."". $centre_encours : $centre_encours}}</td>
                                                                            <td id="avril_annuler_year_selec">{{ $centre_annules < 10 ? 0 ."". $centre_annules : $centre_annules}}</td>
                                                                            <td id="avril_cloture_year_selec">{{ $centre_clotures < 10 ? 0 ."". $centre_clotures : $centre_clotures}}</td>
                                                                            <td id="avril_total_year_selec">{{ $centre < 10 ? 0 ."". $centre : $centre}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>LITTORAL</td>
                                                                            <td id="mai_encour_year_selec">{{ $littoral_encours < 10 ? 0 ."". $littoral_encours : $littoral_encours}}</td>
                                                                            <td id="mai_annuler_year_selec">{{ $littoral_annules < 10 ? 0 ."". $littoral_annules : $littoral_annules}}</td>
                                                                            <td id="mai_cloture_year_selec">{{ $littoral_clotures < 10 ? 0 ."". $littoral_clotures : $littoral_clotures}}</td>
                                                                            <td id="mai_total_year_selec">{{ $littoral < 10 ? 0 ."". $littoral : $littoral}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>SUD</td>
                                                                            <td id="juillet_encour_year_selec">{{ $sud_encours < 10 ? 0 ."". $sud_encours : $sud_encours}}</td>
                                                                            <td id="juillet_annuler_year_selec">{{ $sud_annules < 10 ? 0 ."". $sud_annules : $sud_annules}}</td>
                                                                            <td id="juillet_cloture_year_selec">{{ $sud_clotures < 10 ? 0 ."". $sud_clotures : $sud_clotures}}</td>
                                                                            <td id="juillet_total_year_selec">{{ $sud < 10 ? 0 ."". $sud :  $sud }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>ADAMAOUA</td>
                                                                            <td id="septembre_encour_year_selec">{{ $adamaoua_encours < 10 ? 0 ."". $adamaoua_encours : $adamaoua_encours}}</td>
                                                                            <td id="septembre_annuler_year_selec">{{ $adamaoua_annules < 10 ? 0 ."". $adamaoua_annules : $adamaoua_annules}}</td>
                                                                            <td id="septembre_cloture_year_selec">{{ $adamaoua_clotures < 10 ? 0 ."". $adamaoua_clotures : $adamaoua_clotures}}</td>
                                                                            <td id="septembre_total_year_selec">{{ $adamaoua < 10 ? 0 ."". $adamaoua : $adamaoua}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>EST</td>
                                                                            <td id="octobre_encour_year_selec">{{ $est_encours < 10 ? 0 ."". $est_encours : $est_encours}}</td>
                                                                            <td id="octobre_annuler_year_selec">{{ $est_annules < 10 ? 0 ."". $est_annules : $est_annules}}</td>
                                                                            <td id="octobre_cloture_year_selec">{{ $est_clotures < 10 ? 0 ."". $est_clotures : $est_clotures}}</td>
                                                                            <td id="octobre_total_year_selec">{{ $est < 10 ? 0 ."". $est : $est}}</td>
                                                                            </tr>
                                                                        </tbody>
        </table>
</body>
</html>