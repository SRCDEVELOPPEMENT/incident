$('#annee_total').change( function(){
    if($(this).val()){
        
        $('#par_region').val($(this).val());
        $('#par_site').val($(this).val());
        $('#par_global').val($(this).val());

        let ids = JSON.parse($(this).attr('data-ids'));
        let dates = JSON.parse($(this).attr('data-created'));
        let due_dates = JSON.parse($(this).attr('data-exited'));
        let incidents = JSON.parse($(this).attr('data-incidents'));
        let tab = [];
        let incident_direction = [];

        for (let k = 0; k < incidents.length; k++) {
            const monincident = incidents[k];
            let annee = dates[k].substring(0, 4);
            
            if(parseInt(annee) == parseInt($(this).val())){
                tab.push(monincident);
            }
        }

        $('#namels').replaceWith(`<span id="namels"></span>`);
        $('#date_du').replaceWith(`<span id="date_du"></span>`);
        $('#nom_site_ou_departement').replaceWith(`<span id="nom_site_ou_departement"> Nombre D'Incidents Total</span>`);
        $('#tot').replaceWith(`<span class="h2 my-4 mb-0" id="tot">${tab.length < 10 ? 0 +""+ tab.length : tab.length}</span>`);
        
        $('#changer_site').replaceWith(`<strong class="text-xl text-success" id="changer_site">DIRECTION GENERALE</strong>`);

        let ens = 0;
        let cls = 0;
        let ann = 0;
        let enretard = 0;
        let incidant_encours = [];
        let incidant_enretard = [];
        let incidant_cloturer = [];
        let incidant_annuller = [];

        let ouest = 0;
        let nord_ouest = 0;
        let sud_ouest = 0;
        let centre = 0;
        let littoral = 0;
        let extreme_nord = 0;
        let sud = 0;
        let nord = 0;
        let adamaoua = 0;
        let est = 0;
    
        let inc_ouest = [];
        let inc_nord_ouest = [];
        let inc_sud_ouest = [];
        let inc_centre = [];
        let inc_littoral = [];
        let inc_extreme_nord = [];
        let inc_sud = [];
        let inc_nord = [];
        let inc_adamaoua = [];
        let inc_est = [];
    
        for (let i = 0; i < tab.length; i++) {
            const incid = tab[i];
            if(incid.status == "ENCOURS"){
                ens +=1;
                incidant_encours.push(incid);

                let indes = -1;

                if(incid.due_date){

                    for (let q = 0; q < ids.length; q++) {
                        const number = ids[q];
                        if(number == incid.number){
                            indes = q;
                        }
                    }

                    let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                    let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                    if(dateEcheance < today){
                        enretard +=1;
                        incidant_enretard.push(incid);                   
                    }    
                }
                
            }else if(incid.status == "CLÔTURÉ"){
                cls +=1;
                incidant_cloturer.push(incid);
            }else{
                ann +=1;
                incidant_annuller.push(incid);
            }

            
            if(!incid.site_id){
                incident_direction.push(incid);
            }

            if(incid.site_id){
                switch (incid.sites.region) {
                    case 'OUEST':
                        ouest +=1;
                        inc_ouest.push(incid);
                        break;
                    case 'NORD-OUEST':
                        nord_ouest +=1;
                        inc_nord_ouest.push(incid);
                        break;
                    case 'SUD-OUEST':
                        sud_ouest +=1;
                        inc_sud_ouest.push(incid);
                        break;
                    case 'CENTRE':
                        centre +=1;
                        inc_centre.push(incid);
                        break;
                    case 'LITTORAL':
                        littoral +=1;
                        inc_littoral.push(incid);
                        break;
                    case 'EXTREME-NORD':
                        extreme_nord +=1;
                        inc_extreme_nord.push(incid);
                        break;
                    case 'SUD':
                        sud +=1;
                        inc_sud.push(incid);
                        break;
                    case 'NORD':
                        nord +=1;
                        inc_nord.push(incid);
                        break;
                    case 'ADAMAOUA':
                        adamaoua +=1;
                        inc_adamaoua.push(incid);
                        break;
                    case 'EST':
                        est +=1;
                        inc_est.push(incid);
                        break;
    
                    default:
                        break;
                }
            }else{
                littoral +=1;
                inc_littoral.push(incid);
            }
        }

        $('#floder_encour').attr('data-encours', JSON.stringify(incidant_encours));
        $('#floder_retard').attr('data-retards', JSON.stringify(incidant_enretard));
        $('#floder_cloture').attr('data-clotures', JSON.stringify(incidant_cloturer));
        $('#floder_annuler').attr('data-annules', JSON.stringify(incidant_annuller));

        $('#incident_ouest').attr('data-ouest', JSON.stringify(inc_ouest));
        $('#incident_nordouest').attr('data-nordouest', JSON.stringify(inc_nord_ouest));
        $('#incident_sudouest').attr('data-sudouest', JSON.stringify(inc_sud_ouest));
        $('#incident_centre').attr('data-centre', JSON.stringify(inc_centre));
        $('#incident_littoral').attr('data-littoral', JSON.stringify(inc_littoral));
        $('#incident_extremenord').attr('data-extremenord', JSON.stringify(inc_extreme_nord));
        $('#incident_sud').attr('data-sud', JSON.stringify(inc_sud));
        $('#incident_nord').attr('data-nord', JSON.stringify(inc_nord));
        $('#incident_adamaoua').attr('data-adamaoua', JSON.stringify(inc_adamaoua));
        $('#incident_est').attr('data-est', JSON.stringify(inc_est));

        let encour_ouest = 0;
        let annule_ouest = 0;
        let cloture_ouest = 0;
        let enretard_ouest = 0;

        for (let o = 0; o < inc_ouest.length; o++) {
            const p = inc_ouest[o];
            if(p.status == "ENCOURS"){
                encour_ouest +=1;
            }else if(p.status == "CLÔTURÉ"){
                cloture_ouest +=1;
            }else if(p.status == "ANNULÉ"){
                annule_ouest +=1;
            }

            if(p.due_date){
                let indes = -1;
                for (let x = 0; x < ids.length; x++) {
                    const number = ids[x];

                    if(number == p.number){
                        indes = x;
                    }
                }

                let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                if(dateEcheance < today){
                    enretard_ouest +=1;
                }      
            }
        }

        let encour_nordouest = 0;
        let annule_nordouest = 0;
        let cloture_nordouest = 0;
        let enretard_nordouest = 0;

        for (let w = 0; w < inc_nord_ouest.length; w++) {
            const p = inc_nord_ouest[w];
            if(p.status == "ENCOURS"){
                encour_nordouest +=1;
            }else if(p.status == "CLÔTURÉ"){
                cloture_nordouest +=1;
            }else if(p.status == "ANNULÉ"){
                annule_nordouest +=1;
            }

            if(p.due_date){
                let indes = -1;
                for (let x = 0; x < ids.length; x++) {
                    const number = ids[x];

                    if(number == p.number){
                        indes = x;
                    }
                }

                let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                if(dateEcheance < today){
                    enretard_nordouest +=1;
                }        
            }

        }

        let encour_sudouest = 0;
        let annule_sudouest = 0;
        let cloture_sudouest = 0;
        let enretard_sudouest = 0;

        for (let w = 0; w < inc_sud_ouest.length; w++) {
            const p = inc_sud_ouest[w];
            if(p.status == "ENCOURS"){
                encour_sudouest +=1;
            }else if(p.status == "CLÔTURÉ"){
                cloture_sudouest +=1;
            }else if(p.status == "ANNULÉ"){
                annule_sudouest +=1;
            }

            if(p.due_date){
                let indes = -1;
                for (let x = 0; x < ids.length; x++) {
                    const number = ids[x];

                    if(number == p.number){
                        indes = x;
                    }
                }

                let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                if(dateEcheance < today){
                    enretard_sudouest +=1;
                }        
            }

        }

        let encour_centre = 0;
        let annule_centre = 0;
        let cloture_centre = 0;
        let enretard_centre = 0;

        for (let w = 0; w < inc_centre.length; w++) {
            const p = inc_centre[w];
            if(p.status == "ENCOURS"){
                encour_centre +=1;
            }else if(p.status == "CLÔTURÉ"){
                cloture_centre +=1;
            }else if(p.status == "ANNULÉ"){
                annule_centre +=1;
            }

            if(p.due_date){
                let indes = -1;
                for (let x = 0; x < ids.length; x++) {
                    const number = ids[x];

                    if(number == p.number){
                        indes = x;
                    }
                }

                let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                if(dateEcheance < today){
                    enretard_centre +=1;
                }    
            }

        }

        let encour_littoral = 0;
        let annule_littoral = 0;
        let cloture_littoral = 0;
        let enretard_littoral = 0;

        for (let w = 0; w < inc_littoral.length; w++) {
            const p = inc_littoral[w];
            if(p.status == "ENCOURS"){
                encour_littoral +=1;
            }else if(p.status == "CLÔTURÉ"){
                cloture_littoral +=1;
            }else if(p.status == "ANNULÉ"){
                annule_littoral +=1;
            }

            if(p.due_date){
                let indes = -1;
                for (let x = 0; x < ids.length; x++) {
                    const number = ids[x];

                    if(number == p.number){
                        indes = x;
                    }
                }

                let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                if(dateEcheance < today){
                    enretard_littoral +=1;
                }    
            }

        }

        let encour_extremenord = 0;
        let annule_extremenord = 0;
        let cloture_extremenord = 0;
        let enretard_extremenord = 0;

        for (let w = 0; w < inc_extreme_nord.length; w++) {
            const p = inc_extreme_nord[w];
            if(p.status == "ENCOURS"){
                encour_extremenord +=1;
            }else if(p.status == "CLÔTURÉ"){
                cloture_extremenord +=1;
            }else if(p.status == "ANNULÉ"){
                annule_extremenord +=1;
            }

            if(p.due_date){
                let indes = -1;
                for (let x = 0; x < ids.length; x++) {
                    const number = ids[x];

                    if(number == p.number){
                        indes = x;
                    }
                }

                let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                if(dateEcheance < today){
                    enretard_extremenord +=1;
                }        
            }

        }

        let encour_sud = 0;
        let annule_sud = 0;
        let cloture_sud = 0;
        let enretard_sud = 0;

        for (let w = 0; w < inc_sud.length; w++) {
            const p = inc_sud[w];
            if(p.status == "ENCOURS"){
                encour_sud +=1;
            }else if(p.status == "CLÔTURÉ"){
                cloture_sud +=1;
            }else if(p.status == "ANNULÉ"){
                annule_sud +=1;
            }

            if(p.due_date){
                let indes = -1;
                for (let x = 0; x < ids.length; x++) {
                    const number = ids[x];

                    if(number == p.number){
                        indes = x;
                    }
                }

                let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                if(dateEcheance < today){
                    enretard_sud +=1;
                }    
            }

        }

        let encour_nord = 0;
        let annule_nord = 0;
        let cloture_nord = 0;
        let enretard_nord = 0;

        for (let w = 0; w < inc_nord.length; w++) {
            const p = inc_nord[w];
            if(p.status == "ENCOURS"){
                encour_nord +=1;
            }else if(p.status == "CLÔTURÉ"){
                cloture_nord +=1;
            }else if(p.status == "ANNULÉ"){
                annule_nord +=1;
            }

            if(p.due_date){
                let indes = -1;
                for (let x = 0; x < ids.length; x++) {
                    const number = ids[x];

                    if(number == p.number){
                        indes = x;
                    }
                }

                let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                if(dateEcheance < today){
                    enretard_nord +=1;
                }        
            }

        }

        let encour_adamaoua = 0;
        let annule_adamaoua = 0;
        let cloture_adamaoua = 0;
        let enretard_adamaoua = 0;

        for (let w = 0; w < inc_adamaoua.length; w++) {
            const p = inc_adamaoua[w];
            if(p.status == "ENCOURS"){
                encour_adamaoua +=1;
            }else if(p.status == "CLÔTURÉ"){
                cloture_adamaoua +=1;
            }else if(p.status == "ANNULÉ"){
                annule_adamaoua +=1;
            }

            if(p.due_date){
                let indes = -1;
                for (let x = 0; x < ids.length; x++) {
                    const number = ids[x];

                    if(number == p.number){
                        indes = x;
                    }
                }

                let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                if(dateEcheance < today){
                    enretard_adamaoua +=1;
                }    
            }

        }

        let encour_est = 0;
        let annule_est = 0;
        let cloture_est = 0;
        let enretard_est = 0;

        for (let w = 0; w < inc_est.length; w++) {
            const p = inc_est[w];
            if(p.status == "ENCOURS"){
                encour_est +=1;
            }else if(p.status == "CLÔTURÉ"){
                cloture_est +=1;
            }else if(p.status == "ANNULÉ"){
                annule_est +=1;
            }

            if(p.due_date){
                let indes = -1;
                for (let x = 0; x < ids.length; x++) {
                    const number = ids[x];

                    if(number == p.number){
                        indes = x;
                    }
                }

                let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                let dateEcheance = parseInt(due_dates[indes].replaceAll("-", ""));
                if(dateEcheance < today){
                    enretard_est +=1;
                }    
            }

        }
        
        $('#enc').replaceWith(`<span class="h5 text-primary" id="enc">${ens < 10 ? 0 +""+ ens : ens}</span>`);
        $('#clot').replaceWith(`<span class="h5 text-success" id="clot">${cls < 10 ? 0 +""+ cls : cls}</span>`);
        $('#ann').replaceWith(`<span class="h5 text-gray-300" id="ann">${ann < 10 ? 0 +""+ ann : ann}</span>`);
        $('#en_retar').replaceWith(`<span class="h5 text-warning" id="en_retar">${enretard < 10 ? 0 +""+ enretard : enretard}</span>`);

        //TOTAL
        $('#total_ouest').replaceWith(`<td id="total_ouest">${ouest < 10 ? 0 +""+ ouest : ouest }</td>`);
        $('#total_nordouest').replaceWith(`<td id="total_nordouest">${nord_ouest < 10 ? 0 +""+ nord_ouest : nord_ouest}</td>`);
        $('#total_sudouest').replaceWith(`<td id="total_sudouest">${sud_ouest < 10 ? 0 +""+ sud_ouest : sud_ouest}</td>`);
        $('#total_centre').replaceWith(`<td id="total_centre">${centre < 10 ? 0 +""+ centre : centre}</td>`);
        $('#total_littoral').replaceWith(`<td id="total_littoral">${littoral < 10 ? 0 +""+ littoral : littoral}</td>`);
        $('#total_extremenord').replaceWith(`<td id="total_extremenord">${extreme_nord < 10 ? 0 +""+ extreme_nord : extreme_nord}</td>`);
        $('#total_sud').replaceWith(`<td id="total_sud">${sud < 10 ? 0 +""+ sud : sud}</td>`);
        $('#total_nord').replaceWith(`<td id="total_nord">${nord < 10 ? 0 +""+ nord : nord}</td>`);
        $('#total_adamaoua').replaceWith(`<td id="total_adamaoua">${adamaoua < 10 ? 0 +""+ adamaoua : adamaoua}</td>`);
        $('#total_est').replaceWith(`<td id="total_est">${est < 10 ? 0 +""+ est : est}</td>`);

        //ENCOURS
        $('#encour_ouest').replaceWith(`<td id="encour_ouest">${encour_ouest < 10 ? 0 +""+ encour_ouest : encour_ouest}</td>`);
        $('#encour_nordouest').replaceWith(`<td id="encour_nordouest">${encour_nordouest < 10 ? 0 +""+ encour_nordouest : encour_nordouest}</td>`);
        $('#encour_sudouest').replaceWith(`<td id="encour_sudouest">${encour_sudouest < 10 ? 0 +""+ encour_sudouest : encour_sudouest}</td>`);
        $('#encour_centre').replaceWith(`<td id="encour_centre">${encour_centre < 10 ? 0 +""+ encour_centre : encour_centre}</td>`);
        $('#encour_littoral').replaceWith(`<td id="encour_littoral">${encour_littoral < 10 ? 0 +""+ encour_littoral : encour_littoral}</td>`);
        $('#encour_extremenord').replaceWith(`<td id="encour_extremenord">${encour_extremenord < 10 ? 0 +""+ encour_extremenord : encour_extremenord}</td>`);
        $('#encour_sud').replaceWith(`<td id="encour_sud">${encour_sud < 10 ? 0 +""+ encour_sud : encour_sud }</td>`);
        $('#encour_nord').replaceWith(`<td id="encour_nord">${encour_nord < 10 ? 0 +""+ encour_nord : encour_nord}</td>`);
        $('#encour_adamaoua').replaceWith(`<td id="encour_adamaoua">${encour_adamaoua < 10 ? 0 +""+ encour_adamaoua : encour_adamaoua}</td>`);
        $('#encour_est').replaceWith(`<td id="encour_est">${encour_est < 10 ? 0 +""+ encour_est : encour_est}</td>`);

        //CLOTURE
        $('#cloture_ouest').replaceWith(`<td id="cloture_ouest">${cloture_ouest < 10 ? 0 +""+ cloture_ouest : cloture_ouest}</td>`);
        $('#cloture_nordouest').replaceWith(`<td id="cloture_nordouest">${cloture_nordouest < 10 ? 0 +""+ cloture_nordouest : cloture_nordouest}</td>`);
        $('#cloture_sudouest').replaceWith(`<td id="cloture_sudouest">${cloture_sudouest < 10 ? 0 +""+ cloture_sudouest : cloture_sudouest}</td>`);
        $('#cloture_centre').replaceWith(`<td id="cloture_centre">${cloture_centre < 10 ? 0 +""+ cloture_centre : cloture_centre}</td>`);
        $('#cloture_littoral').replaceWith(`<td id="cloture_littoral">${cloture_littoral < 10 ? 0 +""+ cloture_littoral : cloture_littoral}</td>`);
        $('#cloture_extremenord').replaceWith(`<td id="cloture_extremenord">${cloture_extremenord < 10 ? 0 +""+ cloture_extremenord : cloture_extremenord}</td>`);
        $('#cloture_sud').replaceWith(`<td id="cloture_sud">${cloture_sud < 10 ? 0 +""+ cloture_sud : cloture_sud}</td>`);
        $('#cloture_nord').replaceWith(`<td id="cloture_nord">${cloture_nord < 10 ? 0 +""+ cloture_nord : cloture_nord}</td>`);
        $('#cloture_adamaoua').replaceWith(`<td id="cloture_adamaoua">${cloture_adamaoua < 10 ? 0 +""+ cloture_adamaoua : cloture_adamaoua}</td>`);
        $('#cloture_est').replaceWith(`<td id="cloture_est">${cloture_est < 10 ? 0 +""+ cloture_est : cloture_est}</td>`);

        //ANNULE
        $('#annule_ouest').replaceWith(`<td id="annule_ouest">${annule_ouest < 10 ? 0 +""+ annule_ouest : annule_ouest}</td>`);
        $('#annule_nordouest').replaceWith(`<td id="annule_nordouest">${annule_nordouest < 10 ? 0 +""+ annule_nordouest : annule_nordouest}</td>`);
        $('#annule_sudouest').replaceWith(`<td id="annule_sudouest">${annule_sudouest < 10 ? 0 +""+ annule_sudouest : annule_sudouest}</td>`);
        $('#annule_centre').replaceWith(`<td id="annule_centre">${annule_centre < 10 ? 0 +""+ annule_centre : annule_centre}</td>`);
        $('#annule_littoral').replaceWith(`<td id="annule_littoral">${annule_littoral < 10 ? 0 +""+ annule_littoral : annule_littoral}</td>`);
        $('#annule_extremenord').replaceWith(`<td id="annule_extremenord">${annule_extremenord < 10 ? 0 +""+ annule_extremenord : annule_extremenord}</td>`);
        $('#annule_sud').replaceWith(`<td id="annule_sud">${annule_sud < 10 ? 0 +""+ annule_sud : annule_sud}</td>`);
        $('#annule_nord').replaceWith(`<td id="annule_nord">${annule_nord < 10 ? 0 +""+ annule_nord : annule_nord}</td>`);
        $('#annule_adamaoua').replaceWith(`<td id="annule_adamaoua">${annule_adamaoua < 10 ? 0 +""+ annule_adamaoua : annule_adamaoua}</td>`);
        $('#annule_est').replaceWith(`<td id="annule_est">${annule_est < 10 ? 0 +""+ annule_est : annule_est}</td>`);

        //EN-RETARD
        $('#enretard_ouest').replaceWith(`<td id="enretard_ouest">${enretard_ouest < 10 ? 0 +""+ enretard_ouest : enretard_ouest}</td>`);
        $('#enretard_nordouest').replaceWith(`<td id="enretard_nordouest">${enretard_nordouest < 10 ? 0 +""+ enretard_nordouest : enretard_nordouest}</td>`);
        $('#enretard_sudouest').replaceWith(`<td id="enretard_sudouest">${enretard_sudouest < 10 ? 0 +""+ enretard_sudouest : enretard_sudouest}</td>`);
        $('#enretard_centre').replaceWith(`<td id="enretard_centre">${enretard_centre < 10 ? 0 +""+ enretard_centre : enretard_centre}</td>`);
        $('#enretard_littoral').replaceWith(`<td id="enretard_littoral">${enretard_littoral < 10 ? 0 +""+ enretard_littoral : enretard_littoral}</td>`);
        $('#enretard_extremenord').replaceWith(`<td id="enretard_extremenord">${enretard_extremenord < 10 ? 0 +""+ enretard_extremenord : enretard_extremenord}</td>`);
        $('#enretard_sud').replaceWith(`<td id="enretard_sud">${enretard_sud < 10 ? 0 +""+ enretard_sud : enretard_sud}</td>`);
        $('#enretard_nord').replaceWith(`<td id="enretard_nord">${enretard_nord < 10 ? 0 +""+ enretard_nord : enretard_nord}</td>`);
        $('#enretard_adamaoua').replaceWith(`<td id="enretard_adamaoua">${enretard_adamaoua < 10 ? 0 +""+ enretard_adamaoua : enretard_adamaoua}</td>`);
        $('#enretard_est').replaceWith(`<td id="enretard_est">${enretard_est < 10 ? 0 +""+ enretard_est : enretard_est}</td>`);

        let janvier_total = 0;
        let fevrier_total = 0;
        let mars_total = 0;
        let avril_total = 0;
        let mai_total = 0;
        let juin_total = 0;
        let juillet_total = 0;
        let aout_total = 0;
        let septembre_total = 0;
        let octobre_total = 0;
        let novembre_total = 0;
        let deccembre_total = 0;
    
        let janvier_cloture = 0;
        let fevrier_cloture = 0;
        let mars_cloture = 0;
        let avril_cloture = 0;
        let mai_cloture = 0;
        let juin_cloture = 0;
        let juillet_cloture = 0;
        let aout_cloture = 0;
        let septembre_cloture = 0;
        let octobre_cloture = 0;
        let novembre_cloture = 0;
        let deccembre_cloture = 0;

        let janvier_annuler = 0;
        let fevrier_annuler = 0;
        let mars_annuler = 0;
        let avril_annuler = 0;
        let mai_annuler = 0;
        let juin_annuler = 0;
        let juillet_annuler = 0;
        let aout_annuler = 0;
        let septembre_annuler = 0;
        let octobre_annuler = 0;
        let novembre_annuler = 0;
        let deccembre_annuler = 0;
    
        let janvier_encours = 0;
        let fevrier_encours = 0;
        let mars_encours = 0;
        let avril_encours = 0;
        let mai_encours = 0;
        let juin_encours = 0;
        let juillet_encours = 0;
        let aout_encours = 0;
        let septembre_encours = 0;
        let octobre_encours = 0;
        let novembre_encours = 0;
        let deccembre_encours = 0;

        let janvier_enretard = 0;
        let fevrier_enretard = 0;
        let mars_enretard = 0;
        let avril_enretard = 0;
        let mai_enretard = 0;
        let juin_enretard = 0;
        let juillet_enretard = 0;
        let aout_enretard = 0;
        let septembre_enretard = 0;
        let octobre_enretard = 0;
        let novembre_enretard = 0;
        let deccembre_enretard = 0;

        let janvier_incident = [];
        let fevrier_incident = [];
        let mars_incident = [];
        let avril_incident = [];
        let mai_incident = [];
        let juin_incident = [];
        let juillet_incident = [];
        let aout_incident = [];
        let septembre_incident = [];
        let octobre_incident = [];
        let novembre_incident = [];
        let deccembre_incident = [];
    
    
        let dates_declarations = JSON.parse($('#annee_total').attr('data-created'));

        for (let z = 0; z < incident_direction.length; z++) {
            const my_incident = incident_direction[z];
            
            let index_declaration = -1;
            let ids = JSON.parse($('#annee_total').attr('data-ids'));

            for (let g = 0; g < ids.length; g++) {
                const number = ids[g];
                if(number == my_incident.number){
                    index_declaration = g;
                }
            }
            
            if((index_declaration == 0) || (index_declaration > 0)){

            switch (dates_declarations[index_declaration].substring(5, 7)) {
                case "01":
                    janvier_total +=1;
                    janvier_incident.push(my_incident);

                    if(my_incident.status == "CLÔTURÉ"){
                        janvier_cloture +=1;
                    }else if(my_incident.status == "ENCOURS"){
                        janvier_encours +=1;

                        if(my_incident.due_date){
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(my_incident.due_date.replaceAll("-", ""));
                            if(dateEcheance < today){
                                janvier_enretard +=1;               
                            }    
                        }
                            
                    }else if (my_incident.status == "ANNULÉ") {
                        janvier_annuler +=1;
                    }
                    break;
                case "02":
                    fevrier_total +=1;
                    fevrier_incident.push(my_incident);

                    if(my_incident.status == "CLÔTURÉ"){
                        fevrier_cloture +=1;
                    }else if(my_incident.status == "ENCOURS"){
                        fevrier_encours +=1;

                        if(my_incident.due_date){
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(my_incident.due_date.replaceAll("-", ""));
                            if(dateEcheance < today){
                                fevrier_enretard +=1;                   
                            }    
                        }

                    }else if (my_incident.status == "ANNULÉ") {
                        fevrier_annuler +=1;
                    }
                    break;
                case "03":
                    mars_total +=1;
                    mars_incident.push(my_incident);

                    if(my_incident.status == "CLÔTURÉ"){
                        mars_cloture +=1;
                    }else if(my_incident.status == "ENCOURS"){
                        mars_encours +=1;

                        if(my_incident.due_date){
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(my_incident.due_date.replaceAll("-", ""));
                            if(dateEcheance < today){
                                mars_enretard +=1;                   
                            }      
                        }

                    }else if (my_incident.status == "ANNULÉ") {
                        mars_annuler +=1;
                    }
                    break;
                case "04":
                    avril_total +=1;
                    avril_incident.push(my_incident);

                    if(my_incident.status == "CLÔTURÉ"){
                        avril_cloture +=1;
                    }else if(my_incident.status == "ENCOURS"){
                        avril_encours +=1;

                        if(my_incident.due_date){
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(my_incident.due_date.replaceAll("-", ""));
                            if(dateEcheance < today){
                                avril_enretard +=1;                   
                            }      
                        }

                    }else if (my_incident.status == "ANNULÉ") {
                        avril_annuler +=1;
                    }
                    break;
                case "05":
                    mai_total +=1;
                    mai_incident.push(my_incident);

                    if(my_incident.status == "CLÔTURÉ"){
                        mai_cloture +=1;
                    }else if(my_incident.status == "ENCOURS"){
                        mai_encours +=1;

                        if(my_incident.due_date){
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(my_incident.due_date.replaceAll("-", ""));
                            if(dateEcheance < today){
                                mai_enretard +=1;                   
                            }    
                        }

                    }else if (my_incident.status == "ANNULÉ") {
                        mai_annuler +=1;
                    }
                    break;
                case "06":
                    juin_total +=1;
                    juin_incident.push(my_incident);

                    if(my_incident.status == "CLÔTURÉ"){
                        juin_cloture +=1;
                    }else if(my_incident.status == "ENCOURS"){
                        juin_encours +=1;

                        if(my_incident.due_date){
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(my_incident.due_date.replaceAll("-", ""));
                            if(dateEcheance < today){
                                juin_enretard +=1;                   
                            }    
                        }

                    }else if (my_incident.status == "ANNULÉ") {
                        juin_annuler +=1;
                    }
                    break;
                case "07":
                    juillet_total +=1;
                    juillet_incident.push(my_incident);

                    if(my_incident.status == "CLÔTURÉ"){
                        juillet_cloture +=1;
                    }else if(my_incident.status == "ENCOURS"){
                        juillet_encours +=1;

                        if(my_incident.due_date){
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(my_incident.due_date.replaceAll("-", ""));
                            if(dateEcheance < today){
                                juillet_enretard +=1;                   
                            }      
                        }

                    }else if (my_incident.status == "ANNULÉ") {
                        juillet_annuler +=1;
                    }
                    break;
                case "08":
                    aout_total +=1;
                    aout_incident.push(my_incident);

                    if(my_incident.status == "CLÔTURÉ"){
                        aout_cloture +=1;
                    }else if(my_incident.status == "ENCOURS"){
                        aout_encours +=1;

                        if(my_incident.due_date){
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(my_incident.due_date.replaceAll("-", ""));
                            if(dateEcheance < today){
                                aout_enretard +=1;                   
                            }      
                        }

                    }else if (my_incident.status == "ANNULÉ") {
                        aout_annuler +=1;
                    }
                    break;
                case "09":
                    septembre_total +=1;
                    septembre_incident.push(my_incident);

                    if(my_incident.status == "CLÔTURÉ"){
                        septembre_cloture +=1;
                    }else if(my_incident.status == "ENCOURS"){
                        septembre_encours +=1;

                        if(my_incident.due_date){
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(my_incident.due_date.replaceAll("-", ""));
                            if(dateEcheance < today){
                                septembre_enretard +=1;                   
                            }      
                        }

                    }else if (my_incident.status == "ANNULÉ") {
                        septembre_annuler +=1;
                    }
                    break;
                case "10":
                    octobre_total +=1;
                    octobre_incident.push(my_incident);

                    if(my_incident.status == "CLÔTURÉ"){
                        octobre_cloture +=1;
                    }else if(my_incident.status == "ENCOURS"){
                        octobre_encours +=1;

                        if(my_incident.due_date){
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(my_incident.due_date.replaceAll("-", ""));
                            if(dateEcheance < today){
                                octobre_enretard +=1;                   
                            }    
                        }

                    }else if (my_incident.status == "ANNULÉ") {
                        octobre_annuler +=1;
                    }
                    break;
                case "11":
                    novembre_total +=1;
                    novembre_incident.push(my_incident);

                    if(my_incident.status == "CLÔTURÉ"){
                        novembre_cloture +=1;
                    }else if(my_incident.status == "ENCOURS"){
                        novembre_encours +=1;

                        if(my_incident.due_date){
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(my_incident.due_date.replaceAll("-", ""));
                            if(dateEcheance < today){
                                novembre_enretard +=1;                   
                            }    
                        }

                    }else if (my_incident.status == "ANNULÉ") {
                        novembre_annuler +=1;
                    }
                    break;
                case "12":
                    deccembre_total +=1;
                    deccembre_incident.push(my_incident);

                    if(my_incident.status == "CLÔTURÉ"){
                        deccembre_cloture +=1;
                    }else if(my_incident.status == "ENCOURS"){
                        deccembre_encours +=1;

                        if(my_incident.due_date){
                            let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                            let dateEcheance = parseInt(my_incident.due_date.replaceAll("-", ""));
                            if(dateEcheance < today){
                                deccembre_enretard +=1;                
                            }      
                        }

                    }else if (my_incident.status == "ANNULÉ") {
                        deccembre_annuler +=1;
                    }
                    break;
                default:
                    break;
            }

            }
        }

        $('#incident_janvier').attr('data-incident', JSON.stringify(janvier_incident));
        $('#incident_fevrier').attr('data-incident', JSON.stringify(fevrier_incident));
        $('#incident_mars').attr('data-incident', JSON.stringify(mars_incident));
        $('#incident_avril').attr('data-incident', JSON.stringify(avril_incident));
        $('#incident_mai').attr('data-incident', JSON.stringify(mai_incident));
        $('#incident_juin').attr('data-incident', JSON.stringify(juin_incident));
        $('#incident_juillet').attr('data-incident', JSON.stringify(juillet_incident));
        $('#incident_aout').attr('data-incident', JSON.stringify(aout_incident));
        $('#incident_septembre').attr('data-incident', JSON.stringify(septembre_incident));
        $('#incident_octobre').attr('data-incident', JSON.stringify(octobre_incident));
        $('#incident_novembre').attr('data-incident', );JSON.stringify(novembre_incident)
        $('#incident_deccembre').attr('data-incident', JSON.stringify(deccembre_incident));


        // $('#janv_total').replaceWith(`<td id="janv_total">${janvier_total < 10 ? 0 +""+ janvier_total : janvier_total}</td>`);
        // $('#fev_total').replaceWith(`<td id="fev_total">${fevrier_total < 10 ? 0 +""+ fevrier_total : fevrier_total}</td>`);
        // $('#mars_total').replaceWith(`<td id="mars_total">${mars_total < 10 ? 0 +""+ mars_total : mars_total}</td>`);
        // $('#avril_total').replaceWith(`<td id="avril_total">${avril_total < 10 ? 0 +""+ avril_total : avril_total}</td>`);
        // $('#mai_total').replaceWith(`<td id="mai_total">${mai_total < 10 ? 0 +""+ mai_total : mai_total}</td>`);
        // $('#juin_total').replaceWith(`<td id="juin_total">${juin_total < 10 ? 0 +""+ juin_total : juin_total}</td>`);
        // $('#juillet_total').replaceWith(`<td id="juillet_total">${juillet_total < 10 ? 0 +""+ juillet_total : juillet_total}</td>`);
        // $('#aout_total').replaceWith(`<td id="aout_total">${aout_total < 10 ? 0 +""+ aout_total : aout_total}</td>`);
        // $('#septembre_total').replaceWith(`<td id="septembre_total">${septembre_total < 10 ? 0 +""+ septembre_total : septembre_total}</td>`);
        // $('#octobre_total').replaceWith(`<td id="octobre_total">${octobre_total < 10 ? 0 +""+ octobre_total : octobre_total}</td>`);
        // $('#novembre_total').replaceWith(`<td id="novembre_total">${novembre_total < 10 ? 0 +""+ novembre_total : novembre_total}</td>`);
        // $('#deccembre_total').replaceWith(`<td id="deccembre_total">${deccembre_total < 10 ? 0 +""+ deccembre_total : deccembre_total}</td>`);
        
        // $('#janv_encour').replaceWith(`<td id="janv_encour">${janvier_encours < 10 ? 0 +""+ janvier_encours : janvier_encours}</td>`);
        // $('#fev_encour').replaceWith(`<td id="fev_encour">${fevrier_encours < 10 ? 0 +""+ fevrier_encours : fevrier_encours}</td>`);
        // $('#mars_encour').replaceWith(`<td id="mars_encour">${mars_encours < 10 ? 0 +""+ mars_encours : mars_encours}</td>`);
        // $('#avril_encour').replaceWith(`<td id="avril_encour">${avril_encours < 10 ? 0 +""+ avril_encours : avril_encours}</td>`);
        // $('#mai_encour').replaceWith(`<td id="mai_encour">${mai_encours < 10 ? 0 +""+ mai_encours : mai_encours}</td>`);
        // $('#juin_encour').replaceWith(`<td id="juin_encour">${juin_encours < 10 ? 0 +""+ juin_encours : juin_encours}</td>`);
        // $('#juillet_encour').replaceWith(`<td id="juillet_encour">${juillet_encours < 10 ? 0 +""+ juillet_encours : juillet_encours}</td>`);
        // $('#aout_encour').replaceWith(`<td id="aout_encour">${aout_encours < 10 ? 0 +""+ aout_encours : aout_encours}</td>`);
        // $('#septembre_encour').replaceWith(`<td id="septembre_encour">${septembre_encours < 10 ? 0 +""+ septembre_encours : septembre_encours}</td>`);
        // $('#octobre_encour').replaceWith(`<td id="octobre_encour">${octobre_encours < 10 ? 0 +""+ octobre_encours : octobre_encours}</td>`);
        // $('#novembre_encour').replaceWith(`<td id="novembre_encour">${novembre_encours < 10 ? 0 +""+ novembre_encours : novembre_encours}</td>`);
        // $('#deccembre_encour').replaceWith(`<td id="deccembre_encour">${deccembre_encours < 10 ? 0 +""+ deccembre_encours : deccembre_encours}</td>`);

        // $('#janv_annuler').replaceWith(`<td id="janv_annuler">${janvier_annuler < 10 ? 0 +""+ janvier_annuler : janvier_annuler}</td>`);
        // $('#fev_annuler').replaceWith(`<td id="fev_annuler">${fevrier_annuler < 10 ? 0 +""+ fevrier_annuler : fevrier_annuler}</td>`);
        // $('#mars_annuler').replaceWith(`<td id="mars_annuler">${mars_annuler < 10 ? 0 +""+ mars_annuler : mars_annuler}</td>`);
        // $('#avril_annuler').replaceWith(`<td id="avril_annuler">${avril_annuler < 10 ? 0 +""+ avril_annuler : avril_annuler}</td>`);
        // $('#mai_annuler').replaceWith(`<td id="mai_annuler">${mai_annuler < 10 ? 0 +""+ mai_annuler : mai_annuler}</td>`);
        // $('#juin_annuler').replaceWith(`<td id="juin_annuler">${juin_annuler < 10 ? 0 +""+ juin_annuler : juin_annuler}</td>`);
        // $('#juillet_annuler').replaceWith(`<td id="juillet_annuler">${juillet_annuler < 10 ? 0 +""+ juillet_annuler : juillet_annuler}</td>`);
        // $('#aout_annuler').replaceWith(`<td id="aout_annuler">${aout_annuler < 10 ? 0 +""+ aout_annuler : aout_annuler}</td>`);
        // $('#septembre_annuler').replaceWith(`<td id="septembre_annuler">${septembre_annuler < 10 ? 0 +""+ septembre_annuler : septembre_annuler}</td>`);
        // $('#octobre_annuler').replaceWith(`<td id="octobre_annuler">${octobre_annuler < 10 ? 0 +""+ octobre_annuler : octobre_annuler}</td>`);
        // $('#novembre_annuler').replaceWith(`<td id="novembre_annuler">${novembre_annuler < 10 ? 0 +""+ novembre_annuler : novembre_annuler}</td>`);
        // $('#deccembre_annuler').replaceWith(`<td id="deccembre_annuler">${deccembre_annuler < 10 ? 0 +""+ deccembre_annuler : deccembre_annuler}</td>`);

        // $('#janv_cloture').replaceWith(`<td id="janv_cloture">${janvier_cloture < 10 ? 0 +""+ janvier_cloture : janvier_cloture}</td>`);
        // $('#fev_cloture').replaceWith(`<td id="fev_cloture">${fevrier_cloture < 10 ? 0 +""+ fevrier_cloture : fevrier_cloture}</td>`);
        // $('#mars_cloture').replaceWith(`<td id="mars_cloture">${mars_cloture < 10 ? 0 +""+ mars_cloture : mars_cloture}</td>`);
        // $('#avril_cloture').replaceWith(`<td id="avril_cloture">${avril_cloture < 10 ? 0 +""+ avril_cloture : avril_cloture}</td>`);
        // $('#mai_cloture').replaceWith(`<td id="mai_cloture">${mai_cloture < 10 ? 0 +""+ mai_cloture : mai_cloture}</td>`);
        // $('#juin_cloture').replaceWith(`<td id="juin_cloture">${juin_cloture < 10 ? 0 +""+ juin_cloture : juin_cloture}</td>`);
        // $('#juillet_cloture').replaceWith(`<td id="juillet_cloture">${juillet_cloture < 10 ? 0 +""+ juillet_cloture : juillet_cloture}</td>`);
        // $('#aout_cloture').replaceWith(`<td id="aout_cloture">${aout_cloture < 10 ? 0 +""+ aout_cloture : aout_cloture}</td>`);
        // $('#septembre_cloture').replaceWith(`<td id="septembre_cloture">${septembre_cloture < 10 ? 0 +""+ septembre_cloture : septembre_cloture}</td>`);
        // $('#octobre_cloture').replaceWith(`<td id="octobre_cloture">${octobre_cloture < 10 ? 0 +""+ octobre_cloture : octobre_cloture}</td>`);
        // $('#novembre_cloture').replaceWith(`<td id="novembre_cloture">${novembre_cloture < 10 ? 0 +""+ novembre_cloture : novembre_cloture}</td>`);
        // $('#deccembre_cloture').replaceWith(`<td id="deccembre_cloture">${deccembre_cloture < 10 ? 0 +""+ deccembre_cloture : deccembre_cloture}</td>`);

        // $('#janv_enretard').replaceWith(`<td id="janv_enretard">${janvier_enretard < 10 ? 0 +""+ janvier_enretard : janvier_enretard}</td>`);
        // $('#fev_enretard').replaceWith(`<td id="fev_enretard">${fevrier_enretard < 10 ? 0 +""+ fevrier_enretard : fevrier_enretard}</td>`);
        // $('#mars_enretard').replaceWith(`<td id="mars_enretard">${mars_enretard < 10 ? 0 +""+ mars_enretard : mars_enretard}</td>`);
        // $('#avril_enretard').replaceWith(`<td id="avril_enretard">${avril_enretard < 10 ? 0 +""+ avril_enretard : avril_enretard}</td>`);
        // $('#mai_enretard').replaceWith(`<td id="mai_enretard">${mai_enretard < 10 ? 0 +""+ mai_enretard : mai_enretard}</td>`);
        // $('#juin_enretard').replaceWith(`<td id="juin_enretard">${juin_enretard < 10 ? 0 +""+ juin_enretard : juin_enretard}</td>`);
        // $('#juillet_enretard').replaceWith(`<td id="juillet_enretard">${juillet_enretard < 10 ? 0 +""+ juillet_enretard : juillet_enretard}</td>`);
        // $('#aout_enretard').replaceWith(`<td id="aout_enretard">${aout_enretard < 10 ? 0 +""+ aout_enretard : aout_enretard}</td>`);
        // $('#septembre_enretard').replaceWith(`<td id="septembre_enretard">${septembre_enretard < 10 ? 0 +""+ septembre_enretard : septembre_enretard}</td>`);
        // $('#octobre_enretard').replaceWith(`<td id="octobre_enretard">${octobre_enretard < 10 ? 0 +""+ octobre_enretard : octobre_enretard}</td>`);
        // $('#novembre_enretard').replaceWith(`<td id="novembre_enretard">${novembre_enretard < 10 ? 0 +""+ novembre_enretard : novembre_enretard}</td>`);
        // $('#deccembre_enretard').replaceWith(`<td id="deccembre_enretard">${deccembre_enretard < 10 ? 0 +""+ deccembre_enretard : deccembre_enretard}</td>`);

    }
});

$(document).on('click', '#vues', function(){
    let nbr_taches = 0;
    let tasks = JSON.parse($(this).attr('data-tasks'));
    let ids = JSON.parse($(this).attr('data-ids'));
    let dates = JSON.parse($(this).attr('data-created'));
    let incident = JSON.parse($(this).attr('data-incident'));
    let users_incidents = JSON.parse($(this).attr('data-users_incidents'));
    let departements = JSON.parse($(this).attr('data-departements'));
    let sites = JSON.parse($(this).attr('data-sites'));
    
    $('.no').replaceWith(`<i class="badge badge-success text-xl no ml-2">${incident.number}</i>`);
    $('.desc').replaceWith(`<span class="text-xl desc">${incident.description}</span>`);
    $('.cose').replaceWith(`<span class="text-xl desc">${incident.cause}</span>`);
    $('.perim').replaceWith(`<span class="text-xl perim">${incident.perimeter ? incident.perimeter : ''}</span>`);
    $('.actions_do').replaceWith(`<span class="text-xl actions_do">${incident.battles ? incident.battles : ''}</span>`);
    $('.due_dat').replaceWith(`<span class="text-danger text-xl due_dat">${incident.due_date ? incident.due_date : ''}</span>`);
    $('.closur_dat').replaceWith(`<span class="text-danger text-xl closur_dat">${incident.closure_date ? incident.closure_date : ''}</span>`);
    $('.kate').replaceWith(`<span class="text-xl kate">${incident.categories.name}</span>`);
    let index_declaration = -1;
    for (let y = 0; y < ids.length; y++) {
        const number = ids[y];
        if(number == incident.number){
            index_declaration = y;
        }
    }
    $('.creat_dat').replaceWith(`<span class="text-xl creat_dat">${dates[index_declaration]}</span>`);

    for (let index = 0; index < tasks.length; index++) {
        const task = tasks[index];
        if(task.incident_number == incident.number){
            nbr_taches +=1;
        }
    }

    $('.tac').replaceWith(`<span class="text-xl tac">${nbr_taches < 10 ? 0 +""+ nbr_taches : nbr_taches}</span>`);

    let mon_user = users_incidents.find(u => u.incident_number == incident.number && u.isCoordo === '1' && u.isTrigger === '0');

    let mon_user_ince = users_incidents.find(u => u.incident_number == incident.number && u.isCoordo === '1' && u.isTrigger === '1' && u.isTriggerPlus === '1');

    if(mon_user){
        let Utilisateur = users.find(u => u.id == mon_user.user_id);

        if(Utilisateur){
            var dept = departements.find(d => d.id == Utilisateur.departement_id);
            var sit = sites.find(s => s.id == Utilisateur.site_id);
        }
    }
    
    $('.deeps').replaceWith(`<span class="deeps">${dept ? dept.name : ''}</span>`);
    $('.site_emeter').replaceWith(`<span class="site_emeter">${sit ? sit.name : ''}</span>`);

    if(mon_user_ince){
        let Utilisateur = users.find(u => u.id == mon_user_ince.user_id);
        if(Utilisateur){
            var dept_recept = departements.find(d => d.id == Utilisateur.departement_id);
            var sit_recept = sites.find(s => s.id == Utilisateur.site_id);
        }
    }

    $('.dept_receptt').replaceWith(`<span class="dept_receptt">${dept_recept ? dept_recept.name : ''}</span>`);
    $('.syte_receppt').replaceWith(`<span class="syte_receppt">${sit_recept ? sit_recept.name : ''}</span>`);

});


$(document).ready(function(){

    $('#annee_total').val(new Date().getFullYear());
    $('#par_region').val($('#annee_total').val());
    $('#par_site').val($('#annee_total').val());
    $('#par_global').val($('#annee_total').val());

    $("#searchDepartement").on("change", function() {
      var value = $(this).val().toLowerCase();
      $("#moncard .winner").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

    
    $('#search_incidant').on('input', function(){
        var value = $(this).val().toLowerCase();
        $("#shaw tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });  
    });

    $("#searchDate").on("change", function() {
        var filter = $(this).val();
        var table = document.getElementById("dataTable_incident");
        var tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
              txtValue = td.textContent || td.innerText;
              if (txtValue.indexOf(filter) > -1) {
                tr[i].style.display = "";
              } else {
                tr[i].style.display = "none";
              }
            }
        }
    })

    $("#searchMonthDash").on("change", function() {
        var filter = $(this).val();
        var table = document.getElementById("dataTable_incident");
        var tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
              txtValue = td.textContent || td.innerText;
              if (txtValue.indexOf(filter) > -1) {
                tr[i].style.display = "";
              } else {
                tr[i].style.display = "none";
              }
            }
        }
    })

});
  
$(document).on('click', '#maison', function(){

    let tab = [];
    let tab_site = [];
    let site = JSON.parse($(this).attr('data-site'));
    let dates = JSON.parse($('#annee_total').attr('data-created'));
    let incidents = JSON.parse($('#annee_total').attr('data-incidents'));
    $('#changer_site').replaceWith(`<strong class="text-xl text-success" id="changer_site">${site.name}</strong>`);

    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];
        let annee = dates[index].substring(0, 4);

        if(annee == $('#annee_total').val()){
            tab.push(incident);
        }
    }

    for (let x = 0; x < tab.length; x++) {
        const inci = tab[x];
        
        if(inci.site_id){
            if(inci.site_id == site.id){
                tab_site.push(inci);
            }
        }
    }

    let janvier_total = 0;
    let fevrier_total = 0;
    let mars_total = 0;
    let avril_total = 0;
    let mai_total = 0;
    let juin_total = 0;
    let juillet_total = 0;
    let aout_total = 0;
    let septembre_total = 0;
    let octobre_total = 0;
    let novembre_total = 0;
    let deccembre_total = 0;

    let janvier_cloture = 0;
    let fevrier_cloture = 0;
    let mars_cloture = 0;
    let avril_cloture = 0;
    let mai_cloture = 0;
    let juin_cloture = 0;
    let juillet_cloture = 0;
    let aout_cloture = 0;
    let septembre_cloture = 0;
    let octobre_cloture = 0;
    let novembre_cloture = 0;
    let deccembre_cloture = 0;

    let janvier_annuler = 0;
    let fevrier_annuler = 0;
    let mars_annuler = 0;
    let avril_annuler = 0;
    let mai_annuler = 0;
    let juin_annuler = 0;
    let juillet_annuler = 0;
    let aout_annuler = 0;
    let septembre_annuler = 0;
    let octobre_annuler = 0;
    let novembre_annuler = 0;
    let deccembre_annuler = 0;

    let janvier_encours = 0;
    let fevrier_encours = 0;
    let mars_encours = 0;
    let avril_encours = 0;
    let mai_encours = 0;
    let juin_encours = 0;
    let juillet_encours = 0;
    let aout_encours = 0;
    let septembre_encours = 0;
    let octobre_encours = 0;
    let novembre_encours = 0;
    let deccembre_encours = 0;

    let janvier_enretard = 0;
    let fevrier_enretard = 0;
    let mars_enretard = 0;
    let avril_enretard = 0;
    let mai_enretard = 0;
    let juin_enretard = 0;
    let juillet_enretard = 0;
    let aout_enretard = 0;
    let septembre_enretard = 0;
    let octobre_enretard = 0;
    let novembre_enretard = 0;
    let deccembre_enretard = 0;

    let janvier_incident = [];
    let fevrier_incident = [];
    let mars_incident = [];
    let avril_incident = [];
    let mai_incident = [];
    let juin_incident = [];
    let juillet_incident = [];
    let aout_incident = [];
    let septembre_incident = [];
    let octobre_incident = [];
    let novembre_incident = [];
    let deccembre_incident = [];

    
    for (let n = 0; n < tab_site.length; n++) {
        const mon_incident = tab_site[n];

        let index_declaration = -1;
        let ids = JSON.parse($('#annee_total').attr('data-ids'));
        let dates_declarations = JSON.parse($('#annee_total').attr('data-created'));

        for (let g = 0; g < ids.length; g++) {
            const number = ids[g];
            if(number == mon_incident.number){
                index_declaration = g;
            }
        }

        if((index_declaration == 0) || (index_declaration > 0)){
        switch (dates_declarations[index_declaration].substring(5, 7)) {
            case "01":
                janvier_total +=1;
                janvier_incident.push(mon_incident);

                if(mon_incident.status == "CLÔTURÉ"){
                    janvier_cloture +=1;
                }else if(mon_incident.status == "ENCOURS"){
                    janvier_encours +=1;

                    if(mon_incident.due_date){
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(mon_incident.due_date.replaceAll("-", ""));
                        if(dateEcheance < today){
                            janvier_enretard +=1;               
                        }    
                    }
                }else if (mon_incident.status == "ANNULÉ") {
                    janvier_annuler +=1;
                }
                break;
            case "02":
                fevrier_total +=1;
                fevrier_incident.push(mon_incident);

                if(mon_incident.status == "CLÔTURÉ"){
                    fevrier_cloture +=1;
                }else if(mon_incident.status == "ENCOURS"){
                    fevrier_encours +=1;

                    if(mon_incident.due_date){
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(mon_incident.due_date.replaceAll("-", ""));
                        if(dateEcheance < today){
                            fevrier_enretard +=1;                   
                        }    
                    }

                }else if (mon_incident.status == "ANNULÉ") {
                    fevrier_annuler +=1;
                }
                break;
            case "03":
                mars_total +=1;
                mars_incident.push(mon_incident);

                if(mon_incident.status == "CLÔTURÉ"){
                    mars_cloture +=1;
                }else if(mon_incident.status == "ENCOURS"){
                    mars_encours +=1;

                    if(mon_incident.due_date){
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(mon_incident.due_date.replaceAll("-", ""));
                        if(dateEcheance < today){
                            mars_enretard +=1;                   
                        }      
                    }

                }else if (mon_incident.status == "ANNULÉ") {
                    mars_annuler +=1;
                }
                break;
            case "04":
                avril_total +=1;
                avril_incident.push(mon_incident);

                if(mon_incident.status == "CLÔTURÉ"){
                    avril_cloture +=1;
                }else if(mon_incident.status == "ENCOURS"){
                    avril_encours +=1;

                    if(mon_incident.due_date){
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(mon_incident.due_date.replaceAll("-", ""));
                        if(dateEcheance < today){
                            avril_enretard +=1;                   
                        }      
                    }

                }else if (mon_incident.status == "ANNULÉ") {
                    avril_annuler +=1;
                }
                break;
            case "05":
                mai_total +=1;
                mai_incident.push(mon_incident);

                if(mon_incident.status == "CLÔTURÉ"){
                    mai_cloture +=1;
                }else if(mon_incident.status == "ENCOURS"){
                    mai_encours +=1;

                    if(mon_incident.due_date){
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(mon_incident.due_date.replaceAll("-", ""));
                        if(dateEcheance < today){
                            mai_enretard +=1;                   
                        }    
                    }

                }else if (mon_incident.status == "ANNULÉ") {
                    mai_annuler +=1;
                }
                break;
            case "06":
                juin_total +=1;
                juin_incident.push(mon_incident);

                if(mon_incident.status == "CLÔTURÉ"){
                    juin_cloture +=1;
                }else if(mon_incident.status == "ENCOURS"){
                    juin_encours +=1;

                    if(mon_incident.due_date){
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(mon_incident.due_date.replaceAll("-", ""));
                        if(dateEcheance < today){
                            juin_enretard +=1;                   
                        }    
                    }

                }else if (mon_incident.status == "ANNULÉ") {
                    juin_annuler +=1;
                }
                break;
            case "07":
                juillet_total +=1;
                juillet_incident.push(mon_incident);

                if(mon_incident.status == "CLÔTURÉ"){
                    juillet_cloture +=1;
                }else if(mon_incident.status == "ENCOURS"){
                    juillet_encours +=1;

                    if(mon_incident.due_date){
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(mon_incident.due_date.replaceAll("-", ""));
                        if(dateEcheance < today){
                            juillet_enretard +=1;                   
                        }      
                    }

                }else if (mon_incident.status == "ANNULÉ") {
                    juillet_annuler +=1;
                }
                break;
            case "08":
                aout_total +=1;
                aout_incident.push(mon_incident);

                if(mon_incident.status == "CLÔTURÉ"){
                    aout_cloture +=1;
                }else if(mon_incident.status == "ENCOURS"){
                    aout_encours +=1;

                    if(mon_incident.due_date){
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(mon_incident.due_date.replaceAll("-", ""));
                        if(dateEcheance < today){
                            aout_enretard +=1;                   
                        }      
                    }

                }else if (mon_incident.status == "ANNULÉ") {
                    aout_annuler +=1;
                }
                break;
            case "09":
                septembre_total +=1;
                septembre_incident.push(mon_incident);

                if(mon_incident.status == "CLÔTURÉ"){
                    septembre_cloture +=1;
                }else if(mon_incident.status == "ENCOURS"){
                    septembre_encours +=1;

                    if(mon_incident.due_date){
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(mon_incident.due_date.replaceAll("-", ""));
                        if(dateEcheance < today){
                            septembre_enretard +=1;                   
                        }      
                    }

                }else if (mon_incident.status == "ANNULÉ") {
                    septembre_annuler +=1;
                }
                break;
            case "10":
                octobre_total +=1;
                octobre_incident.push(mon_incident);

                if(mon_incident.status == "CLÔTURÉ"){
                    octobre_cloture +=1;
                }else if(mon_incident.status == "ENCOURS"){
                    octobre_encours +=1;

                    if(mon_incident.due_date){
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(mon_incident.due_date.replaceAll("-", ""));
                        if(dateEcheance < today){
                            octobre_enretard +=1;                   
                        }    
                    }

                }else if (mon_incident.status == "ANNULÉ") {
                    octobre_annuler +=1;
                }
                break;
            case "11":
                novembre_total +=1;
                novembre_incident.push(mon_incident);

                if(mon_incident.status == "CLÔTURÉ"){
                    novembre_cloture +=1;
                }else if(mon_incident.status == "ENCOURS"){
                    novembre_encours +=1;

                    if(mon_incident.due_date){
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(mon_incident.due_date.replaceAll("-", ""));
                        if(dateEcheance < today){
                            novembre_enretard +=1;                   
                        }    
                    }

                }else if (mon_incident.status == "ANNULÉ") {
                    novembre_annuler +=1;
                }
                break;
            case "12":
                deccembre_total +=1;
                deccembre_incident.push(mon_incident);

                if(mon_incident.status == "CLÔTURÉ"){
                    deccembre_cloture +=1;
                }else if(mon_incident.status == "ENCOURS"){
                    deccembre_encours +=1;

                    if(mon_incident.due_date){
                        let today = parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""));
                        let dateEcheance = parseInt(mon_incident.due_date.replaceAll("-", ""));
                        if(dateEcheance < today){
                            deccembre_enretard +=1;                
                        }      
                    }

                }else if (mon_incident.status == "ANNULÉ") {
                    deccembre_annuler +=1;
                }
                break;
            default:
                break;
        }
        }
    }

    $('#incident_janvier').attr('data-incident', JSON.stringify(janvier_incident));
    $('#incident_fevrier').attr('data-incident', JSON.stringify(fevrier_incident));
    $('#incident_mars').attr('data-incident', JSON.stringify(mars_incident));
    $('#incident_avril').attr('data-incident', JSON.stringify(avril_incident));
    $('#incident_mai').attr('data-incident', JSON.stringify(mai_incident));
    $('#incident_juin').attr('data-incident', JSON.stringify(juin_incident));
    $('#incident_juillet').attr('data-incident', JSON.stringify(juillet_incident));
    $('#incident_aout').attr('data-incident', JSON.stringify(aout_incident));
    $('#incident_septembre').attr('data-incident', JSON.stringify(septembre_incident));
    $('#incident_octobre').attr('data-incident', JSON.stringify(octobre_incident));
    $('#incident_novembre').attr('data-incident', );JSON.stringify(novembre_incident)
    $('#incident_deccembre').attr('data-incident', JSON.stringify(deccembre_incident));

    $('#janv_total').replaceWith(`<td id="janv_total">${janvier_total < 10 ? 0 +""+ janvier_total : janvier_total }</td>`);
    $('#fev_total').replaceWith(`<td id="fev_total">${fevrier_total < 10 ? 0 +""+ fevrier_total : fevrier_total}</td>`);
    $('#mars_total').replaceWith(`<td id="mars_total">${mars_total < 10 ? 0 +""+ mars_total : mars_total}</td>`);
    $('#avril_total').replaceWith(`<td id="avril_total">${avril_total < 10 ? 0 +""+ avril_total : avril_total}</td>`);
    $('#mai_total').replaceWith(`<td id="mai_total">${mai_total < 10 ? 0 +""+ mai_total : mai_total}</td>`);
    $('#juin_total').replaceWith(`<td id="juin_total">${juin_total < 10 ? 0 +""+ juin_total : juin_total}</td>`);
    $('#juillet_total').replaceWith(`<td id="juillet_total">${juillet_total < 10 ? 0 +""+ juillet_total : juillet_total}</td>`);
    $('#aout_total').replaceWith(`<td id="aout_total">${aout_total < 10 ? 0 +""+ aout_total : aout_total}</td>`);
    $('#septembre_total').replaceWith(`<td id="septembre_total">${septembre_total < 10 ? 0 +""+ septembre_total : septembre_total}</td>`);
    $('#octobre_total').replaceWith(`<td id="octobre_total">${octobre_total < 10 ? 0 +""+ octobre_total : octobre_total}</td>`);
    $('#novembre_total').replaceWith(`<td id="novembre_total">${novembre_total < 10 ? 0 +""+ novembre_total : novembre_total}</td>`);
    $('#deccembre_total').replaceWith(`<td id="deccembre_total">${deccembre_total < 10 ? 0 +""+ deccembre_total : deccembre_total}</td>`);
    
    $('#janv_encour').replaceWith(`<td id="janv_encour">${janvier_encours < 10 ? 0 +""+ janvier_encours : janvier_encours}</td>`);
    $('#fev_encour').replaceWith(`<td id="fev_encour">${fevrier_encours < 10 ? 0 +""+ fevrier_encours : fevrier_encours}</td>`);
    $('#mars_encour').replaceWith(`<td id="mars_encour">${mars_encours < 10 ? 0 +""+ mars_encours : mars_encours}</td>`);
    $('#avril_encour').replaceWith(`<td id="avril_encour">${avril_encours < 10 ? 0 +""+ avril_encours : avril_encours}</td>`);
    $('#mai_encour').replaceWith(`<td id="mai_encour">${mai_encours < 10 ? 0 +""+ mai_encours : mai_encours}</td>`);
    $('#juin_encour').replaceWith(`<td id="juin_encour">${juin_encours < 10 ? 0 +""+ juin_encours : juin_encours}</td>`);
    $('#juillet_encour').replaceWith(`<td id="juillet_encour">${juillet_encours < 10 ? 0 +""+ juillet_encours : juillet_encours}</td>`);
    $('#aout_encour').replaceWith(`<td id="aout_encour">${aout_encours < 10 ? 0 +""+ aout_encours : aout_encours}</td>`);
    $('#septembre_encour').replaceWith(`<td id="septembre_encour">${septembre_encours < 10 ? 0 +""+ septembre_encours : septembre_encours}</td>`);
    $('#octobre_encour').replaceWith(`<td id="octobre_encour">${octobre_encours < 10 ? 0 +""+ octobre_encours : octobre_encours}</td>`);
    $('#novembre_encour').replaceWith(`<td id="novembre_encour">${novembre_encours < 10 ? 0 +""+ novembre_encours : novembre_encours}</td>`);
    $('#deccembre_encour').replaceWith(`<td id="deccembre_encour">${deccembre_encours < 10 ? 0 +""+ deccembre_encours : deccembre_encours}</td>`);

    $('#janv_annuler').replaceWith(`<td id="janv_annuler">${janvier_annuler < 10 ? 0 +""+ janvier_annuler : janvier_annuler}</td>`);
    $('#fev_annuler').replaceWith(`<td id="fev_annuler">${fevrier_annuler < 10 ? 0 +""+ fevrier_annuler : fevrier_annuler}</td>`);
    $('#mars_annuler').replaceWith(`<td id="mars_annuler">${mars_annuler < 10 ? 0 +""+ mars_annuler : mars_annuler}</td>`);
    $('#avril_annuler').replaceWith(`<td id="avril_annuler">${avril_annuler < 10 ? 0 +""+ avril_annuler : avril_annuler}</td>`);
    $('#mai_annuler').replaceWith(`<td id="mai_annuler">${mai_annuler < 10 ? 0 +""+ mai_annuler : mai_annuler}</td>`);
    $('#juin_annuler').replaceWith(`<td id="juin_annuler">${juin_annuler < 10 ? 0 +""+ juin_annuler : juin_annuler}</td>`);
    $('#juillet_annuler').replaceWith(`<td id="juillet_annuler">${juillet_annuler < 10 ? 0 +""+ juillet_annuler : juillet_annuler}</td>`);
    $('#aout_annuler').replaceWith(`<td id="aout_annuler">${aout_annuler < 10 ? 0 +""+ aout_annuler : aout_annuler}</td>`);
    $('#septembre_annuler').replaceWith(`<td id="septembre_annuler">${septembre_annuler < 10 ? 0 +""+ septembre_annuler : septembre_annuler}</td>`);
    $('#octobre_annuler').replaceWith(`<td id="octobre_annuler">${octobre_annuler < 10 ? 0 +""+ octobre_annuler : octobre_annuler}</td>`);
    $('#novembre_annuler').replaceWith(`<td id="novembre_annuler">${novembre_annuler < 10 ? 0 +""+ novembre_annuler : novembre_annuler}</td>`);
    $('#deccembre_annuler').replaceWith(`<td id="deccembre_annuler">${deccembre_annuler < 10 ? 0 +""+ deccembre_annuler : deccembre_annuler}</td>`);

    $('#janv_cloture').replaceWith(`<td id="janv_cloture">${janvier_cloture < 10 ? 0 +""+ janvier_cloture : janvier_cloture}</td>`);
    $('#fev_cloture').replaceWith(`<td id="fev_cloture">${fevrier_cloture < 10 ? 0 +""+ fevrier_cloture : fevrier_cloture}</td>`);
    $('#mars_cloture').replaceWith(`<td id="mars_cloture">${mars_cloture < 10 ? 0 +""+ mars_cloture : mars_cloture}</td>`);
    $('#avril_cloture').replaceWith(`<td id="avril_cloture">${avril_cloture < 10 ? 0 +""+ avril_cloture : avril_cloture}</td>`);
    $('#mai_cloture').replaceWith(`<td id="mai_cloture">${mai_cloture < 10 ? 0 +""+ mai_cloture : mai_cloture}</td>`);
    $('#juin_cloture').replaceWith(`<td id="juin_cloture">${juin_cloture < 10 ? 0 +""+ juin_cloture : juin_cloture}</td>`);
    $('#juillet_cloture').replaceWith(`<td id="juillet_cloture">${juillet_cloture < 10 ? 0 +""+ juillet_cloture : juillet_cloture}</td>`);
    $('#aout_cloture').replaceWith(`<td id="aout_cloture">${aout_cloture < 10 ? 0 +""+ aout_cloture : aout_cloture}</td>`);
    $('#septembre_cloture').replaceWith(`<td id="septembre_cloture">${septembre_cloture < 10 ? 0 +""+ septembre_cloture : septembre_cloture}</td>`);
    $('#octobre_cloture').replaceWith(`<td id="octobre_cloture">${octobre_cloture < 10 ? 0 +""+ octobre_cloture : octobre_cloture}</td>`);
    $('#novembre_cloture').replaceWith(`<td id="novembre_cloture">${novembre_cloture < 10 ? 0 +""+ novembre_cloture : novembre_cloture}</td>`);
    $('#deccembre_cloture').replaceWith(`<td id="deccembre_cloture">${deccembre_cloture < 10 ? 0 +""+ deccembre_cloture : deccembre_cloture}</td>`);

    $('#janv_enretard').replaceWith(`<td id="janv_enretard">${janvier_enretard < 10 ? 0 +""+ janvier_enretard : janvier_enretard}</td>`);
    $('#fev_enretard').replaceWith(`<td id="fev_enretard">${fevrier_enretard < 10 ? 0 +""+ fevrier_enretard : fevrier_enretard}</td>`);
    $('#mars_enretard').replaceWith(`<td id="mars_enretard">${mars_enretard < 10 ? 0 +""+ mars_enretard : mars_enretard}</td>`);
    $('#avril_enretard').replaceWith(`<td id="avril_enretard">${avril_enretard < 10 ? 0 +""+ avril_enretard : avril_enretard}</td>`);
    $('#mai_enretard').replaceWith(`<td id="mai_enretard">${mai_enretard < 10 ? 0 +""+ mai_enretard : mai_enretard}</td>`);
    $('#juin_enretard').replaceWith(`<td id="juin_enretard">${juin_enretard < 10 ? 0 +""+ juin_enretard : juin_enretard}</td>`);
    $('#juillet_enretard').replaceWith(`<td id="juillet_enretard">${juillet_enretard < 10 ? 0 +""+ juillet_enretard : juillet_enretard}</td>`);
    $('#aout_enretard').replaceWith(`<td id="aout_enretard">${aout_enretard < 10 ? 0 +""+ aout_enretard : aout_enretard}</td>`);
    $('#septembre_enretard').replaceWith(`<td id="septembre_enretard">${septembre_enretard < 10 ? 0 +""+ septembre_enretard : septembre_enretard}</td>`);
    $('#octobre_enretard').replaceWith(`<td id="octobre_enretard">${octobre_enretard < 10 ? 0 +""+ octobre_enretard : octobre_enretard}</td>`);
    $('#novembre_enretard').replaceWith(`<td id="novembre_enretard">${novembre_enretard < 10 ? 0 +""+ novembre_enretard : novembre_enretard}</td>`);
    $('#deccembre_enretard').replaceWith(`<td id="deccembre_enretard">${deccembre_enretard < 10 ? 0 +""+ deccembre_enretard : deccembre_enretard}</td>`);

});

$(document).on('click', '#btn_liste_incident_this', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();

    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let departement = JSON.parse($(this).attr('data-departement'));
    let tasks = JSON.parse($(this).attr('data-tasks'));
    let incidents = JSON.parse($(this).attr('data-incidentsDepartement'));

    $('#name_of_hight').replaceWith(`<span class="text-xl ml-3" id="name_of_hight">
    <span class="badge badge-pill badge-success mr-2">service</span>
    ${departement.name}</span>`);

    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];
        let id_taches = [];

        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                id_taches.push(task.id);
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
            <tr class="text-sm">
                <td class="font-weight-bold">${incident.number}</td>
                <td>${created[indice]}</td>
                <td>${incident.due_date ? incident.due_date : ''}</td>
                <td>${incident.processus.name}</td>
                <td>${incident.categories.name}</td>
                <td>${incident.priority}</td>
                <td>
                    <a 
                        style="text-decoration:none;"
                        href="#"
                        title="Liste Des Tâches De L'incident">
                        <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                        <span class="fe fe-list"></span>
                        <span class="fe fe-check"></span>
                    </a>
                </td>
                <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="text-muted sr-only">Action</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a
                        id="infos_incident"
                        data-number="${incident.number}"
                        data-task="${taches_incident.length}"
                        class="dropdown-item mb-1" 
                        href="#!"
                        data-backdrop="static"
                        data-keyboard="false" 
                        data-toggle="modal" 
                        data-target="#modal_infos_incidant">
                        <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                    </a>
                    <a
                        id="liste_taches"
                        data-number="${incident.number}"
                        data-tasks="${id_taches}"
                        class="dropdown-item"
                        href="#!"
                        data-backdrop="static" 
                        data-keyboard="false"
                        data-toggle="modal" 
                        data-target="#modall_tasks_incidents">
                        <span class="fe fe-list mr-4"></span> Liste Des Tâches
                    </a>
                    <a class="dropdown-item" href="#!">
                        <span class="fe fe-x mr-4"></span>Supprimer
                    </a>
                    <a class="dropdown-item" href="#!">
                        <span class="fe fe-edit-2 mr-4"></span>Editer
                    </a>
                </div>
                </td>
            </tr>
        `);
    }
});


$(document).on('click', '#close_fight, #btnTaskListExte', function(){
    $('#modal_liste_incident').modal('show');
});


$(document).on('click', '#infos_incident', function(){

    $('#modal_liste_incident').modal('hide');

    let index_declarations = -1;
    let number = $(this).attr('data-number');
    let tasks = $(this).attr('data-task');
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let dates = JSON.parse($('#annee_total').attr('data-created'));
    let incidents = JSON.parse($('#annee_total').attr('data-incidents'));
    let users = JSON.parse($('#annee_total').attr('data-users'));
    let sites = JSON.parse($('#annee_total').attr('data-sites'));
    let departements = JSON.parse($('#annee_total').attr('data-departements'));
    let users_incidents = JSON.parse($('#annee_total').attr('data-users_incidents'));

    let incident = incidents.find(i => i.number == number);

    for (let l = 0; l < numbers.length; l++) {
        const number = numbers[l];
        if(number == incident.number){
            index_declarations = l;
        }
    }

    if(incident.deja_pris_en_compte === "1"){
        $('.deja_pris_encompte').replaceWith(`<span class="text-xl text-danger deja_pris_encompte">${incident.comment ? incident.comment : ""}</span>`)
    }else if(!incident.deja_pris_en_compte){
        if(incident.observation_rex){
            $('.deja_pris_encompte').replaceWith(`<span class="text-xl text-success deja_pris_encompte">Incident Assigné Avec Succèss !</span>`)
        }else{
            $('.deja_pris_encompte').replaceWith(`<span class="text-xl text-warning deja_pris_encompte">Incident Pas Encore Assigné !</span>`)  
        }
    }

    $('.observation_coordos').replaceWith(`<span class="observation_coordos">${incident.observation_rex ? incident.observation_rex : ""}</span>`);
    $('.processus_impacter').replaceWith(`<span class="text-xl processus_impacter">${incident.processus.name}</span>`);
    $('.no').replaceWith(`<i class="badge badge-pill badge-success text-xs no ml-2">${incident.number}</i>`);
    $('.desc').replaceWith(`<span class="text-xl desc">${incident.description}</span>`);
    $('.cose').replaceWith(`<span class="text-xl desc">${incident.cause}</span>`);

    if(incident.status == "ENCOURS"){
        $('.stat_inci').replaceWith(`<span class="text-xl text-primary stat_inci">${incident.status}</span>`);
    }else if(incident.status == "CLÔTURÉ"){
        $('.stat_inci').replaceWith(`<span class="text-xl text-success stat_inci">${incident.status}</span>`);
    }else{
        $('.stat_inci').replaceWith(`<span class="text-xl text-muted stat_inci">${incident.status}</span>`);
    }
    $('.perim').replaceWith(`<span class="text-xl perim">${incident.perimeter ? incident.perimeter : ''}</span>`);
    $('.actions_do').replaceWith(`<span class="text-xl actions_do">${incident.battles ? incident.battles : ''}</span>`);
    $('.kate').replaceWith(`<span class="text-xl kate">${incident.categories ? incident.categories.name : ""}</span>`);
    
    if(incident.due_date){
        if(parseInt(incident.due_date.replaceAll("-", "")) < parseInt(new Date().toISOString().split('T')[0].replaceAll("-", ""))){
            if(incident.status == "ENCOURS"){
                $('.due_dat').replaceWith(`<span class="text-warning text-xl due_dat">${incident.due_date ? incident.due_date : ''}</span>`);
            }else{
                $('.due_dat').replaceWith(`<span class="text-primary text-xl due_dat">${incident.due_date ? incident.due_date : ''}</span>`);
            }
        }else{
            $('.due_dat').replaceWith(`<span class="text-primary text-xl due_dat">${incident.due_date ? incident.due_date : ''}</span>`);
        }
    }else{
        $('.due_dat').replaceWith(`<span class="due_dat"></span>`);
    }
    $('.creat_dat').replaceWith(`<span class="text-xl creat_dat">${dates[index_declarations]}</span>`);
    $('.closur_dat').replaceWith(`<span class="text-xl closur_dat">${incident.closure_date ? incident.closure_date : ''}</span>`);
    $('.tac').replaceWith(`<span class="text-xl tac">${tasks < 10 ? 0 +""+ tasks : tasks}</span>`);

    //Entité Emetteur Et Récèpteur
    $('.site_emeter').replaceWith(`<span class="site_emeter"></span>`);
    $('.syte_receppt').replaceWith('<span class="syte_receppt"></span>');

    let mon_user_inci_recepteur = users_incidents.find(u => u.incident_number == incident.number && u.isTrigger === '1' && u.isCoordo === '1' && u.isTriggerPlus === '1');

    for (let bi = 0; bi < users_incidents.length; bi++) {
        const u = users_incidents[bi];
        if((u.incident_number == number) && (u.isDeclar === "1")){
            var id_utili = u.user_id;
        }

    }

    
    let Utilisateur = users.find(u => u.id == id_utili);
    if(Utilisateur){
        var dept = departements.find(d => d.id == Utilisateur.departement_id);
        var sit = sites.find(s => s.id == Utilisateur.site_id);
    }

    if(mon_user_inci_recepteur){
        let user = users.find(u => u.id == mon_user_inci_recepteur.user_id);

        if(user){
            var dept_recepteur = departements.find(d => d.id == user.departement_id);
            var sit_recepteur = sites.find(s => s.id == user.site_id);
        }
    }

    $('.syte_receppt').replaceWith(`<span class="syte_receppt">${dept_recepteur ? dept_recepteur.name : sit_recepteur ? sit_recepteur.name : ""}</span>`);
    $('.site_emeter').replaceWith(`<span class="site_emeter">${sit ? sit.name : dept ? dept.name : ""}</span>`);

});



$(document).on('click', '#liste_taches', function(){
    
    $('#modal_liste_incident').modal('hide');

    $('#shadow tr').remove();

    $('#name_of_mon_incident').replaceWith(`
    <span class="text-xl ml-3" id="name_of_mon_incident">${$(this).attr('data-number')}
    </span>`);

    let ids = $(this).attr('data-tasks').split(",");

    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));

    let incidents = JSON.parse($('#annee_total').attr('data-incidents'));

    let ids_taches = JSON.parse($('#annee_total').attr('data-taches_ids'));

    let created_taches = JSON.parse($('#annee_total').attr('data-taches_created'));

    let monIncidentCourant = incidents.find(I => I.number == $(this).attr('data-number'));

    for (let u = 0; u < ids.length; u++) {
        const id = ids[u];
        
        let tache = tasks.find(t => t.id == id);

        let index_id_tache = -1;
        for (let n = 0; n < ids_taches.length; n++) {
            const id = ids_taches[n];
            
            if(id == tache.id){
                index_id_tache = n;
            }
        }

        $('#shadow').append(`
        <tr class="text-sm">
            <td>${tache.description}</td>
            <td>${created_taches[index_id_tache]}</td>
            <td>${tache.maturity_date}</td>
            <td>${tache.departement_id ? tache.departements.name : monIncidentCourant.site_id ? monIncidentCourant.sites.name : ""}</td>
            <td>${tache.resolution_degree}%</td>
            <td>${tache.status}</td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_taach"
                    class="dropdown-item mb-1"
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false" 
                    data-toggle="modal" 
                    data-target="#">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Tâche 
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>

        `);
    }
});

//EVENT MOIS

$(document).on('click', '#incident_janvier', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">JANVIER</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-incident'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));

    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];

        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td class="font-weight-bold">${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1" 
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false" 
                    data-toggle="modal" 
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
    `);

    }

});


$(document).on('click', '#incident_fevrier', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">FEVRIER</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-incident'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));
    
    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];

        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td class="font-weight-bold">${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1" 
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false" 
                    data-toggle="modal" 
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
    `);

    }

});


$(document).on('click', '#incident_mars', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">MARS</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-incident'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));
    
    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];

        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td class="font-weight-bold">${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1" 
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false" 
                    data-toggle="modal" 
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
    `);

    }

});


$(document).on('click', '#incident_avril', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">AVRIL</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-incident'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));
    
    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];

        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td class="font-weight-bold">${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1" 
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false" 
                    data-toggle="modal" 
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
    `);

    }

});


$(document).on('click', '#incident_mai', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">MAI</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-incident'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));
    
    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];

        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td class="font-weight-bold">${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1" 
                    href="#"
                    data-backdrop="static"
                    data-keyboard="false" 
                    data-toggle="modal" 
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
    `);

    }

});


$(document).on('click', '#incident_juin', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">JUIN</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-incident'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));
    
    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];

        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td class="font-weight-bold">${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1" 
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false" 
                    data-toggle="modal" 
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
    `);

    }

});


$(document).on('click', '#incident_juillet', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">JUILLET</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-incident'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));
    
    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];

        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td class="font-weight-bold">${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1" 
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false" 
                    data-toggle="modal" 
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
    `);

    }

});


$(document).on('click', '#incident_aout', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">AOUT</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-incident'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));
    
    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];

        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td class="font-weight-bold">${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1" 
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false" 
                    data-toggle="modal" 
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
    `);

    }

});


$(document).on('click', '#incident_septembre', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">SEPTEMBRE</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-incident'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));
    
    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];

        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td class="font-weight-bold">${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1" 
                    href="#"
                    data-backdrop="static"
                    data-keyboard="false" 
                    data-toggle="modal" 
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
    `);

    }

});


$(document).on('click', '#incident_octobre', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">OCTOBRE</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-incident'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));
    
    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];

        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td class="font-weight-bold">${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1" 
                    href="#"
                    data-backdrop="static"
                    data-keyboard="false" 
                    data-toggle="modal" 
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
    `);

    }

});


$(document).on('click', '#incident_novembre', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">NOVEMBRE</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-incident'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));
    
    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];

        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td class="font-weight-bold">${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1" 
                    href="#"
                    data-backdrop="static"
                    data-keyboard="false" 
                    data-toggle="modal" 
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a class="dropdown-item" href="#">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
    `);

    }

});


$(document).on('click', '#incident_deccembre', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">DECCEMBRE</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-incident'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));
    
    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];

        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td class="font-weight-bold">${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1" 
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false" 
                    data-toggle="modal" 
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
    `);

    }

});


$(document).on('click', '#incident_ouest', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">OUEST</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-ouest'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));

    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];
        var id_taches = [];
        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                id_taches.push(task.id);
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td>${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1"
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false"
                    data-toggle="modal"
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a
                    id="liste_taches"
                    data-number="${incident.number}"
                    data-tasks="${id_taches}"
                    class="dropdown-item"
                    href="#!"
                    data-backdrop="static" 
                    data-keyboard="false"
                    data-toggle="modal" 
                    data-target="#modall_tasks_incidents">
                    <span class="fe fe-list mr-4"></span> Liste Des Tâches
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
        `);
    }

});


$(document).on('click', '#incident_nordouest', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">NORD-OUEST</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-nordouest'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));

    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];
        var id_taches = [];
        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                id_taches.push(task.id);
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td>${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1"
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false"
                    data-toggle="modal"
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a
                    id="liste_taches"
                    data-number="${incident.number}"
                    data-tasks="${id_taches}"
                    class="dropdown-item"
                    href="#!"
                    data-backdrop="static" 
                    data-keyboard="false"
                    data-toggle="modal" 
                    data-target="#modall_tasks_incidents">
                    <span class="fe fe-list mr-4"></span> Liste Des Tâches
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
        `);
    }

});


$(document).on('click', '#incident_sudouest', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">SUD-OUEST</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-sudouest'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));

    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];
        var id_taches = [];
        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                id_taches.push(task.id);
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td>${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1"
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false"
                    data-toggle="modal"
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a
                    id="liste_taches"
                    data-number="${incident.number}"
                    data-tasks="${id_taches}"
                    class="dropdown-item"
                    href="#!"
                    data-backdrop="static" 
                    data-keyboard="false"
                    data-toggle="modal" 
                    data-target="#modall_tasks_incidents">
                    <span class="fe fe-list mr-4"></span> Liste Des Tâches
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
        `);
    }

});


$(document).on('click', '#incident_centre', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">CENTRE</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-centre'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));

    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];
        var id_taches = [];
        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                id_taches.push(task.id);
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td>${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1"
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false"
                    data-toggle="modal"
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a
                    id="liste_taches"
                    data-number="${incident.number}"
                    data-tasks="${id_taches}"
                    class="dropdown-item"
                    href="#!"
                    data-backdrop="static" 
                    data-keyboard="false"
                    data-toggle="modal" 
                    data-target="#modall_tasks_incidents">
                    <span class="fe fe-list mr-4"></span> Liste Des Tâches
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
        `);
    }

});

$(document).on('click', '#incident_littoral', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">LITTORAL</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-littoral'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));

    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];
        var id_taches = [];
        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                id_taches.push(task.id);
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td>${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1"
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false"
                    data-toggle="modal"
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a
                    id="liste_taches"
                    data-number="${incident.number}"
                    data-tasks="${id_taches}"
                    class="dropdown-item"
                    href="#!"
                    data-backdrop="static" 
                    data-keyboard="false"
                    data-toggle="modal" 
                    data-target="#modall_tasks_incidents">
                    <span class="fe fe-list mr-4"></span> Liste Des Tâches
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
        `);
    }

});

$(document).on('click', '#incident_extremenord', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">EXTREME-NORD</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-extremenord'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));

    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];
        var id_taches = [];
        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                id_taches.push(task.id);
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td>${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1"
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false"
                    data-toggle="modal"
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a
                    id="liste_taches"
                    data-number="${incident.number}"
                    data-tasks="${id_taches}"
                    class="dropdown-item"
                    href="#!"
                    data-backdrop="static" 
                    data-keyboard="false"
                    data-toggle="modal" 
                    data-target="#modall_tasks_incidents">
                    <span class="fe fe-list mr-4"></span> Liste Des Tâches
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
        `);
    }

});

$(document).on('click', '#incident_sud', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">SUD</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-sud'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));

    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];
        var id_taches = [];
        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                id_taches.push(task.id);
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td>${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1"
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false"
                    data-toggle="modal"
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a
                    id="liste_taches"
                    data-number="${incident.number}"
                    data-tasks="${id_taches}"
                    class="dropdown-item"
                    href="#!"
                    data-backdrop="static" 
                    data-keyboard="false"
                    data-toggle="modal" 
                    data-target="#modall_tasks_incidents">
                    <span class="fe fe-list mr-4"></span> Liste Des Tâches
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
        `);
    }

});

$(document).on('click', '#incident_nord', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">NORD</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-nord'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));

    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];
        var id_taches = [];
        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                id_taches.push(task.id);
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td>${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1"
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false"
                    data-toggle="modal"
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a
                    id="liste_taches"
                    data-number="${incident.number}"
                    data-tasks="${id_taches}"
                    class="dropdown-item"
                    href="#!"
                    data-backdrop="static" 
                    data-keyboard="false"
                    data-toggle="modal" 
                    data-target="#modall_tasks_incidents">
                    <span class="fe fe-list mr-4"></span> Liste Des Tâches
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
        `);
    }

});

$(document).on('click', '#incident_adamaoua', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">ADAMAOUA</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-adamaoua'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));

    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];
        var id_taches = [];
        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                id_taches.push(task.id);
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td>${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1"
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false"
                    data-toggle="modal"
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a
                    id="liste_taches"
                    data-number="${incident.number}"
                    data-tasks="${id_taches}"
                    class="dropdown-item"
                    href="#!"
                    data-backdrop="static" 
                    data-keyboard="false"
                    data-toggle="modal" 
                    data-target="#modall_tasks_incidents">
                    <span class="fe fe-list mr-4"></span> Liste Des Tâches
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
        `);
    }

});


$(document).on('click', '#incident_est', function(){

    $('#shaw tr').remove();
    $('#cloturation').hide();
    $('#name_of_hight').replaceWith(`
    <span class="text-xl ml-3" id="name_of_hight">
        <span class="badge badge-pill badge-success mr-2">EST</span>
    </span>`);

    let incidents = JSON.parse($(this).attr('data-est'));
    let numbers = JSON.parse($('#annee_total').attr('data-ids'));
    let created = JSON.parse($('#annee_total').attr('data-created'));
    let tasks = JSON.parse($('#annee_total').attr('data-tasks'));

    for (let index = 0; index < incidents.length; index++) {
        const incident = incidents[index];

        let indice = -1;
        for (let u = 0; u < numbers.length; u++) {
            const number = numbers[u];
            if(number == incident.number){
                indice = u;
            }
        }

        let nombre_tache = 0;
        let taches_incident = [];
        var id_taches = [];
        for (let i = 0; i < tasks.length; i++) {
            const task = tasks[i];
            if(task.incident_number == incident.number){
                nombre_tache +=1;
                id_taches.push(task.id);
                taches_incident.push(task);
            }
        }

        $('#shaw').append(`
        <tr class="text-sm">
            <td>${incident.number}</td>
            <td>${created[indice]}</td>
            <td>${incident.due_date ? incident.due_date : ''}</td>
            <td>${incident.processus.name}</td>
            <td>${incident.categories ? incident.categories.name : ""}</td>
            <td>${incident.priority}</td>
            <td>
                <a 
                    style="text-decoration:none;"
                    href="#!"
                    title="Liste Des Tâches De L'incident">
                    <small class="text-lg mr-1">${nombre_tache < 10 ? 0 +''+ nombre_tache : nombre_tache}</small>
                    <span class="fe fe-list"></span>
                    <span class="fe fe-check"></span>
                </a>
            </td>
            <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a
                    id="infos_incident"
                    data-number="${incident.number}"
                    data-task="${taches_incident.length}"
                    class="dropdown-item mb-1"
                    href="#!"
                    data-backdrop="static"
                    data-keyboard="false"
                    data-toggle="modal"
                    data-target="#modal_infos_incidant">
                    <span class="fe fe-eye mr-4"></span> Voir Infos Incident
                </a>
                <a
                    id="liste_taches"
                    data-number="${incident.number}"
                    data-tasks="${id_taches}"
                    class="dropdown-item"
                    href="#!"
                    data-backdrop="static" 
                    data-keyboard="false"
                    data-toggle="modal" 
                    data-target="#modall_tasks_incidents">
                    <span class="fe fe-list mr-4"></span> Liste Des Tâches
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-x mr-4"></span>Supprimer
                </a>
                <a class="dropdown-item" href="#!">
                    <span class="fe fe-edit-2 mr-4"></span>Editer
                </a>
            </div>
            </td>
        </tr>
        `);
    }

});

//FIN EVEN MOIS 

// $(document).on('click', '#btn_print_incident_specific', function(){
//     $.ajax({
//         type: 'GET',
//         url: "generation_incidents_annee_specifique",
//         data: {
//             annee: $('#annee_total').val()
//         },
//          headers:{
//              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//          },
//          success: function(){

//          }
        
//     })
// });


// $(document).on('click', '#btn_print_incident_siting', function(){
//     $.ajax({
//         type: 'GET',
//         url: "generation_incidents_par_site",
//         data: {
//             annee: $('#annee_total').val()
//         },
//          headers:{
//              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//          },
//          success: function(){

//          }
        
//     })
// });


// $(document).on('click', '#print_region', function(){
//     console.log($('#annee_total').val())
//     $.ajax({
//         type: 'GET',
//         url: "generation_incidents_par_region",
//         data: {
//             annee: $('#annee_total').val()
//         },
//          headers:{
//              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//          },
//          success: function(){

//          }
        
//     })
// });


$(document).on('click', '#btn_print_entre_debut_et_fin', function(){
    let date_debut = $('#resi').val().replaceAll("-", "");
    let date_fin = $('#desi').val().replaceAll("-", "");
    
    if(!$('#resi').val() || !$('#desi').val() || (date_debut > date_fin)){

        let message = "";
        message+="Veuillez Renseigner Une Date De Début ! \n";
        message +="Veuillez Renseigner Une Date De Fin ! \n";
        message +="Veuillez Vous Rassurrer Que La Date De Début Est Inférieur A la Date De Fin ! \n";

        $('#validtitor').val(message);
        $('#annulationE').attr('data-backdrop', 'static');
        $('#annulationE').attr('data-keyboard', false);
        $('#annulationE').modal('show');
    
    }else{

        var _date_debut = $('#resi').val();
        var _date_fin = $('#desi').val();
        var _site_id = $('#dfsite').val();

        $('#resi').val('');
        $('#desi').val('');
        $('#dfsite').val('');

        $.ajax({
            type: 'GET',
            url: "generation_incidents_entre_deux_date",
            data: {
                date_debut: _date_debut,
                date_fin: _date_fin,
                site_id: _site_id,
            },
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
    }
});

$(document).on('click', '#btn_print_pdf_entre_deux_date_pour_departement', function(){
    if(!$('#debut_departe').val() || !$('#fin_departe').val() || !$('#departement_coice').val()){

        let message = "";
        message+="Veuillez Choisir Un Département ! \n";
        message+="Veuillez Renseigner Une Date De Début ! \n";
        message +="Veuillez Renseigner Une Date De Fin ! \n";

        $('#validtitor').val(message);
        $('#annulationE').attr('data-backdrop', 'static');
        $('#annulationE').attr('data-keyboard', false);
        $('#annulationE').modal('show');
    
    }else{

        var _date_debut = $('#debut_departe').val();
        var _date_fin = $('#fin_departe').val();
        var _departement_id = $('#departement_coice').val();

        $('#debut_departe').val('');
        $('#fin_departe').val('');
        $('#departement_coice').val('');

        $.ajax({
            type: 'GET',
            url: "generate_between_deux_date_departement",
            data: {
                date_debut: _date_debut,
                date_fin: _date_fin,
                departement_id: _departement_id,
            },
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })
    }
});