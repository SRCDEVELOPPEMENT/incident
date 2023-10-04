
<!DOCTYPE html>
<html>
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
        <h1>Tableau Récapitulatif De La Qté Des Incidents Par Site Aucour De L'année  {{$annee}}</h1>
        <table class="table table-hover datatables text-center" id="dataTable-1">
                                                                        <thead class="thead-dark" style="font-family: Century Gothic;">
                                                                            <tr style="font-size: 0.8em;">
                                                                            <th>SITE</th>
                                                                            <th><span class="dot dot-lg bg-primary mr-2"></span>Incident Encours</th>
                                                                            <th><span class="dot dot-lg bg-dark mr-2"></span>Incident Annulé</th>
                                                                            <th><span class="dot dot-lg bg-success mr-2"></span>Incident Clôturé </th>
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
                                                                                
                                                                                $cites = $incidentSites[$i];
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

</body>
</html>