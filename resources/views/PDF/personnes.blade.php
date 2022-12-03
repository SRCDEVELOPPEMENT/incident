
<!DOCTYPE html>
<html>
<head>
    <title></title>
            <style>
                table {
                    border-collapse: collapse;
                    margin:auto;
                }
                tr, th, td{
                    border: 2px solid black;
                }
                th{
                    padding: 5px;
                }
                td{
                    width: 100px;
                    padding: 5px;
                }
                h1{
                  text-align:center;
                }
            </style>
</head>
<body>
    <h1>Liste Personnes</h1>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Matricule</th>
                <th>Téléphone</th>
                <th>Poste</th>
                <th>Véhicule</th>
            </tr>
        </thead>
        <tbody>
            @foreach($personnes as $personne)
                <tr>
                    <td>{{ $personne->fullname }}</td>
                    <td>{{ $personne->matricule ? $personne->matricule : "AUCUN" }}</td>
                    <td>{{ $personne->telephone }}</td>
                    <td>{{ $personne->vehicules ? $personne->vehicules->Immatriculation : "AUCUN" }}</td>
                    <td>{{ $personne->postes ? $personne->postes->intitulePoste : 'AUCUN' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
        <tr>
                <th>Nom</th>
                <th>Matricule</th>
                <th>Téléphone</th>
                <th>Poste</th>
                <th>Véhicule</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>