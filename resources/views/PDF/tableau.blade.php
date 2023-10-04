
<!DOCTYPE html>
<html>
    <?php

        $janvier_total_year = 0;
        $fevrier_total_year = 0;
        $mars_total_year = 0;
        $avril_total_year = 0;
        $mai_total_year = 0;
        $juin_total_year = 0;
        $juillet_total_year = 0;
        $aout_total_year = 0;
        $septembre_total_year = 0;
        $octobre_total_year = 0;
        $novembre_total_year = 0;
        $deccembre_total_year = 0;

        $janvier_total_cloture = 0;
        $fevrier_total_cloture = 0;
        $mars_total_cloture = 0;
        $avril_total_cloture = 0;
        $mai_total_cloture = 0;
        $juin_total_cloture = 0;
        $juillet_total_cloture = 0;
        $aout_total_cloture = 0;
        $septembre_total_cloture = 0;
        $octobre_total_cloture = 0;
        $novembre_total_cloture = 0;
        $deccembre_total_cloture = 0;

        $janvier_total_annuler = 0;
        $fevrier_total_annuler = 0;
        $mars_total_annuler = 0;
        $avril_total_annuler = 0;
        $mai_total_annuler = 0;
        $juin_total_annuler = 0;
        $juillet_total_annuler = 0;
        $aout_total_annuler = 0;
        $septembre_total_annuler = 0;
        $octobre_total_annuler = 0;
        $novembre_total_annuler = 0;
        $deccembre_total_annuler = 0;

        $janvier_total_encours = 0;
        $fevrier_total_encours = 0;
        $mars_total_encours = 0;
        $avril_total_encours = 0;
        $mai_total_encours = 0;
        $juin_total_encours = 0;
        $juillet_total_encours = 0;
        $aout_total_encours = 0;
        $septembre_total_encours = 0;
        $octobre_total_encours = 0;
        $novembre_total_encours = 0;
        $deccembre_total_encours = 0;

        $janvier_total_enretard = 0;
        $fevrier_total_enretard = 0;
        $mars_total_enretard = 0;
        $avril_total_enretard = 0;
        $mai_total_enretard = 0;
        $juin_total_enretard = 0;
        $juillet_total_enretard = 0;
        $aout_total_enretard = 0;
        $septembre_total_enretard = 0;
        $octobre_total_enretard = 0;
        $novembre_total_enretard = 0;
        $deccembre_total_enretard = 0;

        if(is_iterable($incidents)){
            for ($g=0; $g < count($incidents); $g++) {
    
                $inci = $incidents[$g];
                $mois_de_my_incident = intval(substr($inci->declaration_date, 5, 2));
    
                switch ($mois_de_my_incident) {
                    case 1:
                        
                        $janvier_total_year +=1;
    
                        if($inci->status == "CLÔTURÉ"){
                            $janvier_total_cloture +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $janvier_total_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $janvier_total_annuler +=1;
                        }
                        
                        if($inci->due_date){
                            if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                $janvier_total_enretard +=1;
                            }
                        }
    
                        break;
                    case 2:
                        
                        $fevrier_total_year +=1;
    
                        if($inci->status == "CLÔTURÉ"){
                            $fevrier_total_cloture +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $fevrier_total_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $fevrier_total_annuler +=1;
                        }
                        
                        if($inci->due_date){
                            if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                $fevrier_total_enretard +=1;
                            }
                        }
    
                        break;
                    case 3:
                        
                        $mars_total_year +=1;
    
                        if($inci->status == "CLÔTURÉ"){
                            $mars_total_cloture +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $mars_total_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $mars_total_annuler +=1;
                        }
                        
                        if($inci->due_date){
                            if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                $mars_total_enretard +=1;
                            }
                        }
    
                        break;
                    case 4:
                        
                        $avril_total_year +=1;
    
                        if($inci->status == "CLÔTURÉ"){
                            $avril_total_cloture +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $avril_total_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $avril_total_annuler +=1;
                        }
                        
                        if($inci->due_date){
                            if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                $avril_total_enretard +=1;
                            }
                        }
    
                        break;
                    case 5:
                        
                        $mai_total_year +=1;
    
                        if($inci->status == "CLÔTURÉ"){
                            $mai_total_cloture +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $mai_total_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $mai_total_annuler +=1;
                        }
                        
                        if($inci->due_date){
                            if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                $mai_total_enretard +=1;
                            }
                        }
    
                        break;
                    case 6:
                        
                        $juin_total_year +=1;
    
                        if($inci->status == "CLÔTURÉ"){
                            $juin_total_cloture +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $juin_total_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $juin_total_annuler +=1;
                        }
                        
                        if($inci->due_date){
                            if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                $juin_total_enretard +=1;
                            }
                        }
    
                        break;
                    case 7:
                        
                        $juillet_total_year +=1;
    
                        if($inci->status == "CLÔTURÉ"){
                            $juillet_total_cloture +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $juillet_total_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $juillet_total_annuler +=1;
                        }
                        
                        if($inci->due_date){
                            if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                $juillet_total_enretard +=1;
                            }
                        }
    
                        break;
                    case 8:
                        
                        $aout_total_year +=1;
    
                        if($inci->status == "CLÔTURÉ"){
                            $aout_total_cloture +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $aout_total_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $aout_total_annuler +=1;
                        }
                        
                        if($inci->due_date){
                            if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                $aout_total_enretard +=1;
                            }
                        }
    
                        break;
                    case 9:
                        
                        $septembre_total_year +=1;
    
                        if($inci->status == "CLÔTURÉ"){
                            $septembre_total_cloture +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $septembre_total_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $septembre_total_annuler +=1;
                        }
                        
                        if($inci->due_date){
                            if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                $septembre_total_enretard +=1;
                            }
                        }
    
                        break;
                    case 10:
                        
                        $octobre_total_year +=1;
    
                        if($inci->status == "CLÔTURÉ"){
                            $octobre_total_cloture +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $octobre_total_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $octobre_total_annuler +=1;
                        }
                        
                        if($inci->due_date){
                            if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                $octobre_total_enretard +=1;
                            }
                        }
    
                        break;
                    case 11:
                        
                        $novembre_total_year +=1;
    
                        if($inci->status == "CLÔTURÉ"){
                            $novembre_total_cloture +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $novembre_total_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $novembre_total_annuler +=1;
                        }
                        
                        if($inci->due_date){
                            if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                $novembre_total_enretard +=1;
                            }
                        }
    
                        break;
                    case 12:
                        
                        $deccembre_total_year +=1;
    
                        if($inci->status == "CLÔTURÉ"){
                            $deccembre_total_cloture +=1;
                        }elseif($inci->status == "ENCOURS"){
                            $deccembre_total_encours +=1;
                        }elseif ($inci->status == "ANNULÉ") {
                            $deccembre_total_annuler +=1;
                        }
                        
                        if($inci->due_date){
                            if(intval(str_replace("-", "", $inci->due_date)) < intval(str_replace("-", "", date('Y-m-d')))){
                                $deccembre_total_enretard +=1;
                            }
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
        @if($Du)
            <h1>Tableau Récapitulatif De La Qté Des Incidents Du Site {{ $name }} Du {{ $Du }} Au {{ $Au }} </h1>
        @else
            <h1>Tableau Récapitulatif De La Qté Des Incidents Aucour De L'année {{ $annee }} </h1>
        @endif
        <table class="table table-hover datatables text-center" id="dataTable-1">
                                                                        <thead class="thead-dark" style="font-family: Century Gothic;">
                                                                            <tr style="font-size: 0.8em;">
                                                                            <th><span class="fe fe-calendar mr-2"></span> Mois</th>
                                                                            <th><span class="dot dot-lg bg-primary mr-2"></span>Incident Encours</th>
                                                                            <th><span class="dot dot-lg bg-dark mr-2"></span>Incident Annulé</th>
                                                                            <th><span class="dot dot-lg bg-success mr-2"></span>Incident Clôturé </th>
                                                                            <th><span class="dot dot-lg bg-warning mr-2"></span>Incident En-Retard</th>
                                                                            <th>Incident Total</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody style="font-size:1.3em; font-family: Century Gothic;">
                                                                            <tr>
                                                                            <td>Janvier</td>
                                                                            <td id="janv_encour_year_selec">{{ $janvier_total_encours < 10 ? 0 ."". $janvier_total_encours : $janvier_total_encours }}</td>
                                                                            <td id="janv_annuler_year_selec">{{ $janvier_total_annuler < 10 ? 0 ."". $janvier_total_annuler : $janvier_total_annuler }}</td>
                                                                            <td id="janv_cloture_year_selec">{{ $janvier_total_cloture < 10 ? 0 ."". $janvier_total_cloture : $janvier_total_cloture  }}</td>
                                                                            <td id="janv_enretard_year_selec">{{ $janvier_total_enretard < 10 ? 0 ."". $janvier_total_enretard : $janvier_total_enretard }}</td>
                                                                            <td id="janv_total_year_selec">{{ $janvier_total_year < 10 ? 0 ."". $janvier_total_year : $janvier_total_year }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>Fevrier</td>
                                                                            <td id="fev_encour_year_selec">{{ $fevrier_total_encours < 10 ? 0 ."". $fevrier_total_encours : $fevrier_total_encours }}</td>
                                                                            <td id="fev_annuler_year_selec">{{ $fevrier_total_annuler < 10 ? 0 ."". $fevrier_total_annuler : $fevrier_total_annuler }}</td>
                                                                            <td id="fev_cloture_year_selec">{{ $fevrier_total_cloture < 10 ? 0 ."". $fevrier_total_cloture : $fevrier_total_cloture}}</td>
                                                                            <td id="fev_enretard_year_selec">{{ $fevrier_total_enretard < 10 ? 0 ."". $fevrier_total_enretard : $fevrier_total_enretard}}</td>
                                                                            <td id="fev_total_year_selec">{{ $fevrier_total_year < 10 ? 0 ."". $fevrier_total_year : $fevrier_total_year}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>Mars</td>
                                                                            <td id="mars_encour_year_selec">{{ $mars_total_encours < 10 ? 0 ."". $mars_total_encours : $mars_total_encours}}</td>
                                                                            <td id="mars_annuler_year_selec">{{ $mars_total_annuler < 10 ? 0 ."". $mars_total_annuler : $mars_total_annuler }}</td>
                                                                            <td id="mars_cloture_year_selec">{{ $mars_total_cloture < 10 ? 0 ."". $mars_total_cloture : $mars_total_cloture}}</td>
                                                                            <td id="mars_enretard_year_selec">{{ $mars_total_enretard < 10 ? 0 ."". $mars_total_enretard : $mars_total_enretard}}</td>
                                                                            <td id="mars_total_year_selec">{{ $mars_total_year < 10 ? 0 ."". $mars_total_year : $mars_total_year}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>Avril</td>
                                                                            <td id="avril_encour_year_selec">{{ $avril_total_encours < 10 ? 0 ."". $avril_total_encours : $avril_total_encours}}</td>
                                                                            <td id="avril_annuler_year_selec">{{ $avril_total_annuler < 10 ? 0 ."". $avril_total_annuler : $avril_total_annuler}}</td>
                                                                            <td id="avril_cloture_year_selec">{{ $avril_total_cloture < 10 ? 0 ."". $avril_total_cloture : $avril_total_cloture}}</td>
                                                                            <td id="avril_enretard_year_selec">{{ $avril_total_enretard < 10 ? 0 ."". $avril_total_enretard : $avril_total_enretard}}</td>
                                                                            <td id="avril_total_year_selec">{{ $avril_total_year < 10 ? 0 ."". $avril_total_year : $avril_total_year}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>Mai</td>
                                                                            <td id="mai_encour_year_selec">{{ $mai_total_encours < 10 ? 0 ."". $mai_total_encours : $mai_total_encours}}</td>
                                                                            <td id="mai_annuler_year_selec">{{ $mai_total_annuler < 10 ? 0 ."". $mai_total_annuler : $mai_total_annuler}}</td>
                                                                            <td id="mai_cloture_year_selec">{{ $mai_total_cloture < 10 ? 0 ."". $mai_total_cloture : $mai_total_cloture}}</td>
                                                                            <td id="mai_enretard_year_selec">{{ $mai_total_enretard < 10 ? 0 ."". $mai_total_enretard : $mai_total_enretard}}</td>
                                                                            <td id="mai_total_year_selec">{{ $mai_total_year < 10 ? 0 ."". $mai_total_year : $mai_total_year}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>Juin</td>
                                                                            <td id="juin_encour_year_selec">{{ $juin_total_encours < 10 ? 0 ."". $juin_total_encours : $juin_total_encours}}</td>
                                                                            <td id="juin_annuler_year_selec">{{ $juin_total_annuler < 10 ? 0 ."". $juin_total_annuler : $juin_total_annuler}}</td>
                                                                            <td id="juin_cloture_year_selec">{{ $juin_total_cloture < 10 ? 0 ."". $juin_total_cloture : $juin_total_cloture}}</td>
                                                                            <td id="juin_enretard_year_selec">{{ $juin_total_enretard < 10 ? 0 ."". $juin_total_enretard : $juin_total_enretard}}</td>
                                                                            <td id="juin_total_year_selec">{{ $juin_total_year < 10 ? 0 ."". $juin_total_year : $juin_total_year}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>Juillet</td>
                                                                            <td id="juillet_encour_year_selec">{{ $juillet_total_encours < 10 ? 0 ."". $juillet_total_encours : $juillet_total_encours}}</td>
                                                                            <td id="juillet_annuler_year_selec">{{ $juillet_total_annuler < 10 ? 0 ."". $juillet_total_annuler : $juillet_total_annuler}}</td>
                                                                            <td id="juillet_cloture_year_selec">{{ $juillet_total_cloture < 10 ? 0 ."". $juillet_total_cloture : $juillet_total_cloture}}</td>
                                                                            <td id="juillet_enretard_year_selec">{{ $juillet_total_enretard < 10 ? 0 ."". $juillet_total_enretard : $juillet_total_enretard}}</td>
                                                                            <td id="juillet_total_year_selec">{{ $juillet_total_year < 10 ? 0 ."". $juillet_total_year :  $juillet_total_year }}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>Août</td>
                                                                            <td id="aout_encour_year_selec">{{ $aout_total_encours < 10 ? 0 ."". $aout_total_encours : $aout_total_encours}}</td>
                                                                            <td id="aout_annuler_year_selec">{{ $aout_total_annuler < 10 ? 0 ."". $aout_total_annuler : $aout_total_annuler}}</td>
                                                                            <td id="aout_cloture_year_selec">{{ $aout_total_cloture < 10 ? 0 ."". $aout_total_cloture : $aout_total_cloture}}</td>
                                                                            <td id="aout_enretard_year_selec">{{ $aout_total_enretard < 10 ? 0 ."". $aout_total_enretard : $aout_total_enretard}}</td>
                                                                            <td id="aout_total_year_selec">{{ $aout_total_year < 10 ? 0 ."". $aout_total_year : $aout_total_year}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>Septembre</td>
                                                                            <td id="septembre_encour_year_selec">{{ $septembre_total_encours < 10 ? 0 ."". $septembre_total_encours : $septembre_total_encours}}</td>
                                                                            <td id="septembre_annuler_year_selec">{{ $septembre_total_annuler < 10 ? 0 ."". $septembre_total_annuler : $septembre_total_annuler}}</td>
                                                                            <td id="septembre_cloture_year_selec">{{ $septembre_total_cloture < 10 ? 0 ."". $septembre_total_cloture : $septembre_total_cloture}}</td>
                                                                            <td id="septembre_enretard_year_selec">{{ $septembre_total_enretard < 10 ? 0 ."". $septembre_total_enretard : $septembre_total_enretard}}</td>
                                                                            <td id="septembre_total_year_selec">{{ $septembre_total_year < 10 ? 0 ."". $septembre_total_year : $septembre_total_year}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>Octobre</td>
                                                                            <td id="octobre_encour_year_selec">{{ $octobre_total_encours < 10 ? 0 ."". $octobre_total_encours : $octobre_total_encours}}</td>
                                                                            <td id="octobre_annuler_year_selec">{{ $octobre_total_annuler < 10 ? 0 ."". $octobre_total_annuler : $octobre_total_annuler}}</td>
                                                                            <td id="octobre_cloture_year_selec">{{ $octobre_total_cloture < 10 ? 0 ."". $octobre_total_cloture : $octobre_total_cloture}}</td>
                                                                            <td id="octobre_enretard_year_selec">{{ $octobre_total_enretard < 10 ? 0 ."". $octobre_total_enretard : $octobre_total_enretard}}</td>
                                                                            <td id="octobre_total_year_selec">{{ $octobre_total_year < 10 ? 0 ."". $octobre_total_year : $octobre_total_year}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>Novembre</td>
                                                                            <td id="novembre_encour_year_selec">{{ $novembre_total_encours < 10 ? 0 ."". $novembre_total_encours : $novembre_total_encours}}</td>
                                                                            <td id="novembre_annuler_year_selec">{{ $novembre_total_annuler < 10 ? 0 ."". $novembre_total_annuler : $novembre_total_annuler}}</td>
                                                                            <td id="novembre_cloture_year_selec">{{ $novembre_total_cloture < 10 ? 0 ."". $novembre_total_cloture : $novembre_total_cloture}}</td>
                                                                            <td id="novembre_enretard_year_selec">{{ $novembre_total_enretard < 10 ? 0 ."". $novembre_total_enretard : $novembre_total_enretard}}</td>
                                                                            <td id="novembre_total_year_selec">{{ $novembre_total_year < 10 ? 0 ."". $novembre_total_year : $novembre_total_year}}</td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td>Deccembre</td>
                                                                            <td id="deccembre_encour_year_selec">{{ $deccembre_total_encours < 10 ? 0 ."". $deccembre_total_encours : $deccembre_total_encours}}</td>
                                                                            <td id="deccembre_annuler_year_selec">{{ $deccembre_total_annuler < 10 ? 0 ."". $deccembre_total_annuler : $deccembre_total_annuler}}</td>
                                                                            <td id="deccembre_cloture_year_selec">{{ $deccembre_total_cloture < 10 ? 0 ."". $deccembre_total_cloture : $deccembre_total_cloture}}</td>
                                                                            <td id="deccembre_enretard_year_selec">{{ $deccembre_total_enretard < 10 ? 0 ."". $deccembre_total_enretard : $deccembre_total_enretard}}</td>
                                                                            <td id="deccembre_total_year_selec">{{ $deccembre_total_year < 10 ? 0 ."". $deccembre_total_year : $deccembre_total_year}}</td>
                                                                            </tr>
                                                                        </tbody>
        </table>
</body>
</html>