
<!DOCTYPE html>
<html>
    @if($name)
    <?php
        $cloture = 0;
        $encours = 0;
        $annuler = 0;
        $enretard = 0;

        if(is_iterable($incidents)){
            for ($g=0; $g < count($incidents); $g++) {
    
                $inci = $incidents[$g];
                    
                if($inci->status == "CLÔTURÉ"){
                            $cloture +=1;
                }elseif($inci->status == "ENCOURS"){
                            $encours +=1;
                }elseif ($inci->status == "ANNULÉ") {
                            $annuler +=1;
                }
                        
                if($inci->due_date){
                    if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                            $enretard +=1;
                    }
                }
            }   
        }
    ?>
    @endif
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
        @if($name)
            <h1>Tableau Récapitulatif De La Qté Des Incidents Du Site {{ $name }} Du {{ $Du }} Au {{ $Au }} </h1>
        @else
            <h1>Tableau Récapitulatif De La Qté Des Incidents Par Site Du {{ $Du }} Au {{ $Au }} </h1>
        @endif

        @if($name)
        <table class="table table-hover datatables text-center" id="dataTable-1">
                <thead class="thead-dark" style="font-family: Century Gothic;">
                    <tr style="font-size: 0.8em;">
                        <th><span class="fe fe-calendar mr-2"></span> Période</th>
                        <th><span class="dot dot-lg bg-primary mr-2"></span>Incident Encours</th>
                        <th><span class="dot dot-lg bg-dark mr-2"></span>Incident Annulé</th>
                        <th><span class="dot dot-lg bg-success mr-2"></span>Incident Clôturé </th>
                        <th><span class="dot dot-lg bg-warning mr-2"></span>Incident En-Retard</th>
                        <th>Incident Total</th>
                    </tr>
                </thead>
                <tbody style="font-size:1.3em; font-family: Century Gothic;">
                    <tr>
                        <td>Du  {{ $Du }} Au {{ $Au }}</td>
                        <td>{{ $encours < 10 ? 0 ."". $encours : $encours }}</td>
                        <td>{{ $annuler < 10 ? 0 ."". $annuler : $annuler }}</td>
                        <td>{{ $cloture < 10 ? 0 ."". $cloture : $cloture  }}</td>
                        <td>{{ $enretard < 10 ? 0 ."". $enretard : $enretard }}</td>
                        <td>{{ count($incidents) < 10 ? 0 ."". count($incidents) : count($incidents) }}</td>
                    </tr>
                </tbody>
        </table>
        @else
        <table class="table table-hover datatables text-center" id="dataTable-1">
                <thead class="thead-dark" style="font-family: Century Gothic;">
                    <tr style="font-size: 0.8em;">
                        <th>SITE</th>
                        <th><span class="dot dot-lg bg-primary mr-2"></span>Incident Encours</th>
                        <th><span class="dot dot-lg bg-dark mr-2"></span>Incident Annulé</th>
                        <th><span class="dot dot-lg bg-dark mr-2"></span>Incident Clôturé </th>
                        <th><span class="dot dot-lg bg-warning mr-2"></span>Incident En-Retard</th>
                        <th>Incident Total</th>
                    </tr>
                </thead>
                <tbody style="font-size:1.3em; font-family: Century Gothic;">                                                                            
                    <?php
                        for ($i=0; $i < count($sites); $i++) {
                            $site = $sites[$i];
                                                                                
                            $encours = 0;
                            $cloture = 0;
                            $annuler = 0;
                            $enretard = 0;                                                                           
                                                                                
                            $cites = $incidents[$i];
                            $nbr = count($cites);
                            for ($k=0; $k < count($cites); $k++) {
                                $incid = $cites[$k];
                                if($incid->status == "CLÔTURÉ"){
                                    $cloture +=1;
                                }elseif($incid->status == "ENCOURS"){
                                    $encours +=1;
                                }elseif ($incid->status == "ANNULÉ") {
                                    $annuler +=1;
                                }
                                                                                    
                                if($incid->due_date){
                                    if(intval(str_replace("-", "", $incid->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                        $enretard +=1;
                                    }
                                }
                                                                
                            }
                                                                            
                            echo "<tr>";
                            echo    "<td>$site->name</td>";
                            echo    $encours > 10 ? "<td>$encours</td>" : "<td> 0$encours </td>";
                            echo    $annuler > 10 ? "<td>$annuler</td>" : "<td> 0$annuler</td>";
                            echo    $cloture > 10 ? "<td>$cloture</td>" : "<td> 0$cloture</td>";
                            echo    $enretard > 10 ? "<td>$enretard</td>" : "<td> 0$enretard</td>";
                            echo    $nbr > 10 ? "<td>$nbr</td>" : "<td> 0$nbr</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
        </table>
        @endif
</body>
</html>