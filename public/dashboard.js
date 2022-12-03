    $(document).ready(function(){
        $('#annee_total').val(new Date().getFullYear());
    });

    $('#annee_total').change( function(){
        if($(this).val()){
            let incidents = JSON.parse($(this).attr('data-incidents'));
            let departements = JSON.parse($(this).attr('data-departements'));
            let nombre_incidents_instance = [];
            let clotures = [];
            let tab = [];

            for (let index = 0; index < incidents.length; index++) {
                const incident = incidents[index];
                let annee = incident.created_at.substring(0, 4);
                
                if(annee == $(this).val()){
                    tab.push(incident);
                }
            }
            $('#tot').replaceWith(`<span class="h2 my-4 mb-0" id="tot">${tab.length}</span>`);
            
            for (let indexx = 0; indexx < departements.length; indexx++) {
                const depart = departements[indexx];
                
                let nombre_incident_dept = 0;
                let nbr_incident_dept = [];
                let nombre = 0;
                let anuler = 0
                
                for (let index = 0; index < tab.length; index++) {
                    const incident = tab[index];
                    
                    if(incident.categories.departements.id == depart.id){
                        nombre_incident_dept +=1;
                        nbr_incident_dept.push(incident);
                    }
                }

                $(`#instances${indexx}`).replaceWith(`
                <span id="instances${indexx}" style="font-size: 2em;" class="small text-white">
                    ${nombre_incident_dept}
                </span>`);
                
                for (let index = 0; index < nbr_incident_dept.length; index++) {
                    const incide = nbr_incident_dept[index];
                    if(incide.status == "CLÔTURÉ"){
                        nombre +=1;
                    }else if(incide.status == "ANNULÉ"){
                        anuler +=1;
                    }
                }
                
                $(`#ko${indexx}`).replaceWith(`<span id="ko${indexx}">${nombre}</span>`);
                $(`#del${indexx}`).replaceWith(`<span id="del${indexx}">${anuler}</span>`);
            }
            
        }
    });

    // var today = new Date();
    // var dd = String(today.getDate()).padStart(2, '0');
    // var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    // var yyyy = today.getFullYear();
    
