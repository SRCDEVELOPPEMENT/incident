
<!DOCTYPE html>
<html>
<head>
    <title></title>
    
            <style>
                tr{
                    border: 2px solid black;
                }
                th{
                    border: 1px solid black;
                }
                td{
                    border: 1px solid black;
                    width: 170px;
                    padding: 5px;
                }
                table {
                    border-collapse: collapse;
                }
                h1{
                  text-align:center;
                }
            </style>
</head>
<body>
                <div>
                    <span style="float:left;">
                        <img alt="" style="width:90px; height: 90px;" src="{{ public_path('img/sorepco.jpg') }}"/>
                    </span>
                    <span style="float:right;">
                        <img alt="" style="width:90px; height: 90px;" src="{{ public_path('img/sorepco.jpg') }}"/>
                    </span>
                </div>

                <p style="font-size: 30px; margin-bottom:1.1em;">
                    <span style="float:left; color:#008AD3; margin-left:0.2em;">SOREPCO SA</span>
                    <span style="float:right; color:#008AD3; margin-right:0.2em;">SOREPCO SA</span>
                </p>
                <p style="font-size: 10px;">
                    <span style="float:left; color:#008AD3; margin-left:-18em;">COMMERCE GENERAL - IMPORT - EXPORT</span>
                    <span style="float:right; color:#008AD3; margin-right:-18em;">COMMERCE GENERAL - IMPORT - EXPORT</span>
                </p>
                <p style="font-size: 10px;">
                    <span style="float:left; color:#008AD3; margin-left:3em;">Tout pour construction</span>
                    <span style="float:right; color:#008AD3; margin-right:5em;">Tout pour construction</span>
                </p>
                <p style="font-size: 10px;">
                    <span style="float:left; color:#008AD3; margin-left:-8.6em;">Alimentation - Equipement</span>
                    <span style="float:right; color:#008AD3; margin-right:-8em;">Alimentation - Equipement</span>
                </p>
                <p style="font-size: 10px;">
                    <span style="float:left; color:#008AD3; margin-left:7.2em;">Direction Générale - Douala-Cameroun BP 2854</span>
                    <span style="float:right; color:#008AD3; margin-right:7.2em;">Direction Générale - Douala-Cameroun BP 2854</span>
                </p>
                <p style="font-size: 10px;">
                    <span style="float:left; color:#008AD3; margin-left:-20em;">Tel : 00(237) 233425182/ 2333420836  - Tel/Fax: 233420857</span>
                    <span style="float:right; color:#008AD3; margin-right:-20em;">Tel : 00(237) 233425182/ 2333420836  - Tel/Fax: 233420857</span>
                </p>
                <p style="font-size: 10px;">
                    <span style="float:left; color:#008AD3; margin-left:5em;">N° contribuable M078900001041 M.R.C. N° 06776</span>
                    <span style="float:right; color:#008AD3; margin-right:4.5em;">N° contribuable M078900001041 M.R.C. N° 06776</span>
                </p>

                </br>

                <p style="text-align: center; font-size: 25px; margin-top: 1em;">FICHE DE DECLARATION INCIDENT <span style="margin-left: 0.3em;">{{ $incident->number }}</span></p>    
                <table class="table" style="margin-bottom: 1em;">
                    <tbody>
                        <tr>
                            <td>
                            <span>Emétteur Incident</span>
                            </td>
                            <td>
                            {{ $incident->siteDeclarateurs->name }}
                            </td>
                            <td>
                            <span>Récepteur Incident</span>
                            </td>
                            <td>
                            {{ $incident->sites->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <span  style="color:black;">Date Déclaration</span>
                            </td>
                            <td>
                            {{ substr($incident->created_at, 0, 10) }}
                            </td>
                            <td>
                            <span  style="color:black;">Date D'échéance</span>
                            </td>
                            <td>
                            {{ $incident->due_date ? substr($incident->due_date, 0, 10) : "ECHEANCE NON DEFINIT" }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Nom & Prénom
                            </td>
                            <td>
                            {{ $incident->fullname_declarateur ? $incident->fullname_declarateur : '' }}
                            </td>
                            <td>
                                Site / Service de L'émétteur
                            </td>
                            <td>{{ $incident->siteDeclarateurs->name }}</td>
                        </tr>
                        <tr>
                            <td>
                                Site Incident
                            </td>
                            <td></td>
                            <td>
                                Contact De L'émetteur
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                            <span>Statut</span>
                            </td>
                            <td>
                            {{ $incident->status }}
                            </td>
                            <td>
                            <span  style="color:black;">Priorité</span>
                            </td>
                            <td>
                            {{ $incident->priority }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <span  style="color:black;">Catégorie Incident</span>
                            </td>
                            <td>
                            {{ $incident->categories ? $incident->categories->name : "" }}
                            </td>
                            <td>
                            <span  style="color:black;">Procéssus Impacté</span>
                            </td>
                            <td>
                            {{ $incident->processus->name }}
                            </td>
                        </tr>
                        </tbody>
                </table>
                
                <p style="color:red;"><strong>NB:</strong> Les incidents reliés au budget doivent etre signé par le responsable du service controle de gestion</p>
                <div>
                    <strong><u>Déclaration de l'incident (Acteur et conditions) :</u></strong><br/>
                    <span style="font-size:1.3em;">{{ $incident->description }}</span>
                </div><br/>

                <div>
                    <strong><u>Cause probable :</u></strong><br/>
                    <span style="font-size:1.3em;">{{ $incident->cause }}</span>
                </div><br/>

                <div>
                    <strong><u>Périmètre :</u></strong><br/>
                    <span style="font-size:1.3em;">{{ $incident->perimeter }}</span>
                </div><br/>

                <div>
                    <strong><u>Détail des travaux réalisés :</u></strong><br/>
                    <span style="font-size:1.3em;">{{ $incident->battles ? $incident->battles : "" }}</span>
                </div><br/>

                <div>
                    <strong><u>Observation :</u></strong><br/>
                    <span style="font-size:1.3em;">{{ $incident->observation }}</span>
                </div><br/>

                <hr>
                <p class="row">
                    <div style="font-weight:bold;"><div><u>Visa</u></div> </br> <div><u>Constatatateur</u></div></div>
                    <div style="margin-left:10em; margin-top:-2.3em; font-weight:bold;"><div><u>Visa</u></div> <div> <u>Responsable Sce/Site</u></div></div>
                    <div style="margin-left:22em; margin-top:-2.7em; font-weight:bold;"><div><u>Visa</u></div> <div><u>REX</u></div></div>
                    <div style="margin-left:30em; margin-top:-4.1em; font-weight:bold;"><div><u>Visa</u></div> <div><u>Resp. RH</u></div></div>
                    <div style="margin-left:38em; margin-top:-4.6em; font-weight:bold;"><div><u>Visa</u></div> <div><u>RACI</u></div></div>
                </p>
</body>
</html>