
<!DOCTYPE html>
<html>
<head>
    <title></title>
            <style>
                table {
                    border-collapse: collapse;
                    margin:auto;
                    width:50%;
                }
                tr, th, td{
                    border: 2px solid black;
                }
                h1{
                  text-align:center;
                }
            </style>
</head>
<body>
    <h1>Liste Courriers</h1>

    <table>
      <thead>
            <tr>
                <th>CODE</th>
                <th>Expéditeur</th>
                <th>Récepteur</th>
                <th>Statut</th>
                <th>Date Création</th>
                <th>Site Expéditeur</th>
                <th>Site Reception</th>
                <th>Transitoire</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courriers as $courrier)
                <tr>
                    <td style="font-size:20px;">{{ $courrier->code }}</td>
                    <td style="font-size:13px;">{{ $courrier->emetteurs->fullname }}</td>
                    <td style="font-size:13px;">{{ $courrier->recepteurs->fullname }}</td>
                    <td style="font-size:13px;">{{ $courrier->status }}</td>
                    <td style="font-size:13px;">{{ $courrier->date_create }}</td>
                    <td style="font-size:13px;">{{ $courrier->site_exps ? $courrier->site_exps->intituleSite : "" }}</td>
                    <td style="font-size:13px;">{{ $courrier->site_recepts ? $courrier->site_recepts->intituleSite : "" }}</td>

                    <td>{{ $courrier->Transitoire ? $courrier->Transitoire : "" }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>CODE</th>
                <th>Expéditeur</th>
                <th>Récepteur</th>
                <th>Statut</th>
                <th>Date Création</th>
                <th>Site Expéditeur</th>
                <th>Site Reception</th>
                <th>Transitoire</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>