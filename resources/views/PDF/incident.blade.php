
<!DOCTYPE html>
<html>
<head>
    <title></title>
            <style>
                #sous{
                    margin-bottom: 10rem;
                }
                tr{
                    border: 2px solid black;
                }
                th{
                    border: 1px solid black;
                }
                td{
                    border: 1px solid black;
                    width: 200px;
                    padding: 5px;
                }
                table {
                    border-collapse: collapse;
                    margin:auto;
                }
                h1{
                  text-align:center;
                }
            </style>
</head>
<body>
            <div id="sous" style="font-size: 30px;"><span style="float:left; color:#008AD3;">SOREPCO SA</span><span style="float:right; color:#008AD3;">SOREPCO SA</span></div>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                            <span  style="color:black; font-size: 20px;">NUMERO</span>
                            </td>
                            <td style="color:black; font-size: 20px;">
                                {{ $incident->number }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <span  style="color:black;">Date Déclaration</span>
                            </td>
                            <td>
                            {{ substr($incident->created_at, 0, 10) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <span  style="color:black;">Date D'échéance</span>
                            </td>
                            <td>
                            {{ substr($incident->due_date, 0, 10) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <span  style="color:black;">Date Clôture</span>
                            </td>
                            <td>
                                @if($incident->closure_date)
                                    {{ substr($incident->closure_date, 0, 10) }}
                                @else
                                    INCIDENT NON CLÔTURÉ
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <span  style="color:black;">Description</span>
                            </td>
                            <td>
                                {{ $incident->description }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <span  style="color:black;">Cause</span>
                            </td>
                            <td>
                                {{ $incident->cause }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <span  style="color:black;">Statut</span>
                            </td>
                            <td>
                            {{ $incident->status }}
                            </td>
                        </tr>
                    </tbody>
                </table>

</body>
</html>