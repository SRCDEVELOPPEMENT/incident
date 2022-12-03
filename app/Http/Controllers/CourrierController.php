<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\Statut;
use App\Models\User;
use App\Models\Personne;
use App\Models\Site;
use App\Models\Poste;
use App\Models\Region;
use App\Models\Itineraire;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use PDF;

class CourrierController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:lister-courrier|
                                      creer-courrier|
                                      editer-courrier|
                                      supprimer-courrier|
                                      voir-courrier|
                                      consulter-courrier|
                                      livrer-courrier|
                                      annuler-courrier|
                                      receptionner-courrier|
                                      retirer-courrier|', ['only' => ['index','show']]);
        $this->middleware('permission:creer-courrier', ['only' => ['store']]);
        $this->middleware('permission:editer-courrier', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-courrier', ['only' => ['destroy']]);
        $this->middleware('permission:consulter-courrier', ['only' => ['consulter']]);
        $this->middleware('permission:retirer-courrier', ['only' => ['retraitcourier']]);
        $this->middleware('permission:annuler-courrier', ['only' => ['annuler']]);
        $this->middleware('permission:receptionner-courrier', ['only' => ['reception', 'receptionShow']]);
        $this->middleware('permission:livrer-courrier', ['only' => ['livraison', 'livraisonShow']]);

    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index()
    {
        toastr()->info('Liste Des Courriers !');
        
        $courriers = Courrier::with('users', 
                                    'emetteurs', 
                                    'recepteurs', 
                                    'recepteur_effectifs', 
                                    'coursiers', 
                                    'users_recept',
                                    'site_exps', 
                                    'site_recepts',
                                    'destinateurs',
                                    'chauffeurs',
                                    'itineraires'
        )->where('user_create_id', Auth::user()->id)
        ->orderBy('date_create', 'DESC')
        ->get();

        $itineraires = Itineraire::all();

        $persons = Personne::with('postes', 'vehicules')->get();

        $postes = Poste::all();
        
        $sites = Site::with('regions')->get();

        $vehicules = DB::table('vehicules')->get();

        $transitoires = [
            "MAGASIN 120",
            "MAGASIN 130",
            "MAGASIN 100",
            "MAGZA RIZ",
            "MAGASIN 80"
        ];

        $courrier_encours = DB::table('courriers')
        ->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', 'ENCOURS')
        ->count();
        
        $courrier_entransit1 = DB::table('courriers')
        ->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', 'ENTRANSIT')
        ->get();

        $courrier_entransit2 = DB::table('courriers')
        ->where('user_recept_id', '=', Auth::user()->id)
        ->where('status', '=', 'ENTRANSIT')
        ->get();
        
        $tab = array();
        foreach ($courrier_entransit1 as $c) {
            array_push($tab, $c->code);
        }
        foreach ($courrier_entransit2 as $c) {
            array_push($tab, $c->code);
        }

        $elts = array_unique($tab);

        $cour0 = DB::table('courriers')
        ->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', 'RECEPTIONNER')
        ->get();

        $cour1 = DB::table('courriers')
        ->where('user_recept_id', '=', Auth::user()->id)
        ->where('status', '=', 'RECEPTIONNER')
        ->get();

        $tables = array();
        foreach ($cour0 as $c) {
            array_push($tables, $c->code);
        }
        foreach ($cour1 as $c) {
            array_push($tables, $c->code);
        }

        $recepts = array_unique($tables);

        $cou0 = DB::table('courriers')
        ->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', 'LIVRER')
        ->get();

        $cou1 = DB::table('courriers')
        ->where('user_recept_id', '=', Auth::user()->id)
        ->where('status', '=', 'LIVRER')
        ->get();
        
        $tab = array();
        foreach ($cou0 as $c) {
            array_push($tab, $c->code);
        }
        foreach ($cou1 as $c) {
            array_push($tab, $c->code);
        }

        $codes = array_unique($tab);

        $courrier_annuler = DB::table('courriers')
        ->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', 'ANNULER')
        ->count();

        return view('courriers.index', [
            'courriers' => $courriers, 
            'encours' => $courrier_encours,
            'entransit' => count($elts),
            'receptionner' => count($recepts),
            'livrer' => count($codes),
            'annuler' => $courrier_annuler,
            'sites' => $sites,
            'postes' => $postes,
            'transitoires' => $transitoires,
            'persons' => $persons,
            'vehicules' => $vehicules,
            'itineraires' => $itineraires,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function generateUniqueCode()
    {
        do {
            $code = random_int(100000, 999999);
        } while (Courrier::where("code", "=", $code)->get()->first());
  
        return $code;
    }


    public function getcourriers(){

        $courriers = Courrier::with('users', 
                                    'emetteurs', 
                                    'recepteurs', 
                                    'recepteur_effectifs', 
                                    'coursiers', 
                                    'users_recept',
                                    'site_exps', 
                                    'site_recepts',
                                    'destinateurs',
                                    'chauffeurs',
        )->get();

        $ouest = 0;
        $nordouest = 0;
        $sudouest = 0;
        $littoral = 0;
        $centre = 0;
        $adamaoua = 0;
        $extremenord = 0;
        $est = 0;
        $nord = 0;
        $sud = 0;

        foreach ($courriers as $courrier) {
            $site = DB::table('sites')->where('id', '=', $courrier->users->site_id)->get()->first();
            $region = DB::table('regions')->where('id', '=', $site->region_id)->get()->first();
            switch ($region->intituleRegion) {
                case 'OUEST':
                    $ouest +=1;
                    break;
                case 'NORD-OUEST':
                    $nordouest +=1;
                    break;
                case 'SUD-OUEST':
                    $sudouest +=1;
                    break;
                case 'LITTORAL':
                    $littoral +=1;
                    break;
                case 'CENTRE':
                    $centre +=1;
                    break;
                case 'ADAMAOUA':
                    $adamaoua +=1;
                    break;
                case 'EXTREME-NORD':
                    $extremenord +=1;
                    break;
                case 'EST':
                    $est +=1;
                    break;
                case 'NORD':
                    $nord +=1;
                    break;
                case 'SUD':
                    $sud +=1;
                    break;
                default:
                    break;
            }
        }

        $aray_region = array();
        array_push($aray_region, $ouest);
        array_push($aray_region, $nordouest);
        array_push($aray_region, $sudouest);
        array_push($aray_region, $littoral);
        array_push($aray_region, $centre);
        array_push($aray_region, $adamaoua);
        array_push($aray_region, $extremenord);
        array_push($aray_region, $est);
        array_push($aray_region, $nord);
        array_push($aray_region, $sud);

        return response()->json([$aray_region, $courriers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        toastr()->success('Courrier Enregistrer Avec Succèss !');

        $destinateur_courrier = NULL;
        $site_reception = NULL;
        $user = NULL;

        if($request->input('destinateur') && $request->input('telephone_destinateur'))
        {
            Personne::create([
                'fullname' => $request->input('destinateur'),
                'telephone' => intval($request->input('telephone_destinateur')),
            ]);

            $personneEmetteur = DB::table('personnes')->get()->last();
        }
        

        if($request->input('destinataire') && $request->input('telephone_destinataire'))
        {
            Personne::create([
                'fullname' => $request->input('destinataire'),
                'telephone' => intval($request->input('telephone_destinataire')),
            ]);

            $personneRecepteur = DB::table('personnes')->get()->last();
        }

        if($request->input('fullname_destinateur') && $request->input('phone_desti'))
        {
            Personne::create([
                'fullname' => $request->input('fullname_destinateur'),
                'telephone' => intval($request->input('phone_desti')),
            ]);

            $destinateur_courrier = DB::table('personnes')->get()->last();
        }

            $site_selectionner = DB::table('sites')->where('id', '=', intval($request->input('site_recept_id')))->get()->first();
            if($site_selectionner->categorieSite != "ENTITE EXTERNE"){

                $site_reception = DB::table('sites')
                ->where('region_id', '=', $site_selectionner->region_id)
                ->where('gestionnaire', '=', TRUE)
                ->get()->first();

                $user = DB::table('users')->where('site_id', '=', $site_reception->id)->get()->first();
            }else{
                $user = Auth::user();
            }

        $newCourrier = new Courrier();

        $newCourrier->date_create = Carbon::now()->setTimezone('Africa/Douala')->format('Y-m-d H:i:s');
        $newCourrier->code = $this->generateUniqueCode();
        $newCourrier->TypeCourrier = $request->input('TypeCourrier');
        $newCourrier->TypeEnvoie = $request->input('TypeEnvoie');
        $newCourrier->objet = $request->input('objet');
        $newCourrier->itineraire = intval($request->input('road'));

        if($request->input('destinateur_courrier') != NULL){
            $newCourrier->destinateur_id = intval($request->input('destinateur_courrier'));
        }else{
            if($destinateur_courrier){
                $newCourrier->destinateur_id = $destinateur_courrier->id;
            }else{
                $newCourrier->destinateur_id = NULL;
            }
        }

        $newCourrier->emetteur_id = $request->input('emetteur_id') ? intval($request->input('emetteur_id')) : $personneEmetteur->id;
        $newCourrier->recepteur_id = $request->input('recepteur_id') ? intval($request->input('recepteur_id')) : $personneRecepteur->id;
        $newCourrier->site_recept_id = $request->input('site_recept_id') ? intval($request->input('site_recept_id')) : NULL;
        $newCourrier->site_exp_id = $request->input('site_exp_id') ? intval($request->input('site_exp_id')) : NULL;
        $newCourrier->user_create_id = intval(Auth::user()->id);
        $newCourrier->user_recept_id = $user ? intval($user->id) : NULL;
        $newCourrier->status = $request->input('status');
        $newCourrier->save();

        $courrier = Courrier::with('users', 
                                   'users_recept', 
                                   'emetteurs', 
                                   'recepteurs', 
                                   'recepteur_effectifs', 
                                   'site_recepts',
                                   'site_exps',
                                   'chauffeurs',
                                   'destinateurs')
        ->get()->last();

        $courriers = Courrier::get();

        $personnes = Personne::get();

        return response([$courrier, $personnes, $courriers]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        toastr()->success('Courrier Modifier Avec Succèss !');

        $destinateur_courrier = NULL;

        if($request->input('destinateur') && $request->input('telephone_destinateur'))
        {
            Personne::create([
                'fullname' => $request->input('destinateur'),
                'telephone' => intval($request->input('telephone_destinateur')),
            ]);

            $personneEmetteur = DB::table('personnes')->get()->last();
        }
        

        if($request->input('destinataire') && $request->input('telephone_destinataire'))
        {
            Personne::create([
                'fullname' => $request->input('destinataire'),
                'telephone' => intval($request->input('telephone_destinataire')),
            ]);

            $peronneRecepteur = DB::table('personnes')->get()->last();
        }

        if($request->input('fullname_destinateur') && $request->input('phone_desti'))
        {
            Personne::create([
                'fullname' => $request->input('fullname_destinateur'),
                'telephone' => intval($request->input('phone_desti')),
            ]);

            $destinateur_courrier = DB::table('personnes')->get()->last();
        }

        if($request->input('site_recept_id')){
            $site_selectionner = DB::table('sites')->where('id', '=', intval($request->input('site_recept_id')))->get()->first();
            if($site_selectionner->categorieSite != "ENTITE EXTERNE"){
                $site_reception = DB::table('sites')
                ->where('region_id', '=', $site_selectionner->region_id)
                ->where('gestionnaire', '=', TRUE)
                ->get()->first();

                $user = DB::table('users')->where('site_id', '=', $site_reception->id)->get()->first();
            }else{
                $user = Auth::user();
            }
        }

        $courrier = Courrier::find($request->id);

        $courrier->TypeCourrier = $request->input('TypeCourrier');
        $courrier->TypeEnvoie = $request->input('TypeEnvoie');
        $courrier->objet = $request->input('objet');
        $courrier->chauffeur_id = $request->input('chauffeur_id') ? intval($request->input('chauffeur_id')) : NULL;
        $courrier->itineraire = $request->input('road') ? intval($request->input('road')) : NULL;

        if($request->input('chauffeur_id')){
            if($request->input('vehicule_effectif_id')){
                DB::table('personnes')->where('id', '=', intval($request->input('chauffeur_id')))->update([
                    'vehicule_effectif_id' => intval($request->input('vehicule_effectif_id'))
                ]);
            }
        }

        if($destinateur_courrier){
            $courrier->destinateur_id = $destinateur_courrier->id;
        }elseif($request->input('destinateur_courrier_edit')){
            $courrier->destinateur_id = intval($request->input('destinateur_courrier_edit'));
        }
        $courrier->emetteur_id = $request->input('emetteur_id') ? intval($request->input('emetteur_id')) : $personneEmetteur->id;
        $courrier->recepteur_id = $request->input('recepteur_id') ? intval($request->input('recepteur_id')) : $peronneRecepteur->id;
        $courrier->site_recept_id = $request->input('site_recept_id') ? intval($request->input('site_recept_id')) : NULL;
        $courrier->site_exp_id = $request->input('site_exp_id') ? intval($request->input('site_exp_id')) : NULL;
        $courrier->user_recept_id = $user ? intval($user->id) : NULL;
        $courrier->Transitoire = $request->input('Transitoire') ? $request->input('Transitoire') : NULL;
        $courrier->status = $request->input('status');
        $courrier->save();

        return response()->json();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function retraitcourier(Request $request)
    {
        toastr()->success('Courrier Retirer Avec Succèss !');

        $personne = NULL;

        if($request->input('fullname') && $request->input('telephone'))
        {
            Personne::create([
                'fullname' => $request->input('fullname'),
                'telephone' => intval($request->input('telephone')),
            ]);

            $personne = DB::table('personnes')->get()->last();
        }

        $courrier = Courrier::find($request->id);

        $site_exp = DB::table('sites')->where('id', '=', intval($courrier->site_exp_id))->get()->first();
        $site_recept = DB::table('sites')->where('id', '=', intval($courrier->site_recept_id))->get()->first();

        if($site_exp->categorieSite != "ENTITE EXTERNE" && $site_recept->categorieSite != "ENTITE EXTERNE"){
            if(intval($courrier->user_recept_id) == intval(Auth::user()->id)){
                $courrier->status = "RECEPTIONNER";
            }elseif (intval($courrier->user_recept_id) != intval(Auth::user()->id)) {
                $courrier->status = "ENTRANSIT";
            }
        }else{
            $courrier->TypeEnvoie == "EXTERNE" ? $courrier->status = "RECEPTIONNER" : $courrier->status = "ENTRANSIT";
        }

        $courrier->DateRetraitCourrier = Carbon::now()->format('Y-m-d H:i:s');
        $courrier->Transitoire = $request->input('Transitoire');

        if($personne){
            $courrier->coursier_id = $personne->id;
        }elseif ($request->input('coursier_id')) {
            $courrier->coursier_id = intval($request->input('coursier_id'));
        }

        if($request->input('cni') && $request->input('date_validite_cni')){
            $courrier->cni = $request->input('cni');
            $courrier->date_validite_cni = $request->input('date_validite_cni');
        }

        $courrier->save();

        return response()->json();
    }

    public function transitoireShow(Request $request){

        $transitoires = [
            "MAGASIN 120",
            "MAGASIN 130",
            "MAGASIN 100",
            "MAGZA RIZ",
            "MAGASIN 80"
        ];

        toastr()->info('Liste Courriers A Transiter !');

        $personnes = Personne::with('postes', 'vehicules')->get();

        $postes = Poste::all();

        $courriers = Courrier::with('users', 'emetteurs', 'recepteurs', 'coursiers', 'users_recept', 'site_recepts', 'site_exps', 'destinateurs', 'chauffeurs'
        )->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', 'ENTRANSIT')->get();
        
        return view('courriers.transitoire_courrier', ['courriers' => $courriers, 'personnes' => $personnes, 'postes' => $postes, 'transitoires' => $transitoires]);
    }

    public function transit(Request $request){

        $courrier = Courrier::find($request->id);

        $courrier->Transitoire = $request->input('magasin');
        $courrier->chauffeur_id = $request->input('chauffeur_id') ? intval($request->input('chauffeur_id')) : NULL;
        $courrier->save();

        return response()->json();
    }

    public function receptionShow(){

        toastr()->info('Courriers En Attente De Réception !');

        $courrier_encours = DB::table('courriers')
        ->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', 'ENCOURS')
        ->count();
        
        $courrier_entransit1 = DB::table('courriers')
        ->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', 'ENTRANSIT')
        ->get();

        $courrier_entransit2 = DB::table('courriers')
        ->where('user_recept_id', '=', Auth::user()->id)
        ->where('status', '=', 'ENTRANSIT')
        ->get();

        $tab = array();
        foreach ($courrier_entransit1 as $c) {
            array_push($tab, $c->code);
        }
        foreach ($courrier_entransit2 as $c) {
            array_push($tab, $c->code);
        }

        $elts = array_unique($tab);

        $cour0 = DB::table('courriers')
        ->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', 'RECEPTIONNER')
        ->get();

        $cour1 = DB::table('courriers')
        ->where('user_recept_id', '=', Auth::user()->id)
        ->where('status', '=', 'RECEPTIONNER')
        ->get();

        $tables = array();
        foreach ($cour0 as $c) {
            array_push($tables, $c->code);
        }
        foreach ($cour1 as $c) {
            array_push($tables, $c->code);
        }

        $recepts = array_unique($tables);

        $cou0 = DB::table('courriers')
        ->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', 'LIVRER')
        ->get();

        $cou1 = DB::table('courriers')
        ->where('user_recept_id', '=', Auth::user()->id)
        ->where('status', '=', 'LIVRER')
        ->get();

        $tab = array();
        foreach ($cou0 as $c) {
            array_push($tab, $c->code);
        }
        foreach ($cou1 as $c) {
            array_push($tab, $c->code);
        }

        $codes = array_unique($tab);

        $courrier_annuler = DB::table('courriers')
        ->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', 'ANNULER')
        ->count();

        $courriers = Courrier::with('users', 'emetteurs', 'recepteurs', 'coursiers', 'users_recept', 'site_recepts', 'site_exps', 'destinateurs', 'chauffeurs', 'itineraires'
        )->where('user_recept_id', '=', Auth::user()->id)
        ->where('status', '=', 'ENTRANSIT')
        ->orderBy('date_create', 'DESC')
        ->get();

        $vehicules = DB::table('vehicules')->get();

        return view('courriers.index_reception',
        [
            'courriers' => $courriers,
            'encours' => $courrier_encours,
            'entransit' => count($elts),
            'receptionner' => count($recepts),
            'livrer' => count($codes),
            'annuler' => $courrier_annuler,
            'vehicules' => $vehicules,
        ]);
    }

    public function reception(Request $request){

        toastr()->success('Courrier Receptionner Avec Succèss !');

        $courrier = Courrier::find($request->id);

        $courrier->DateReceptCourrier = Carbon::now()->format('Y-m-d H:i:s');
        $courrier->status = $request->input('status');
        $courrier->save();

        return response()->json();
    }

    public function livraisonShow(){

        toastr()->info('Courriers En Attente De Livraison !');

        $courrier_encours = DB::table('courriers')
        ->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', 'ENCOURS')
        ->count();
        
        $courrier_entransit1 = DB::table('courriers')
        ->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', 'ENTRANSIT')
        ->get();

        $courrier_entransit2 = DB::table('courriers')
        ->where('user_recept_id', '=', Auth::user()->id)
        ->where('status', '=', 'ENTRANSIT')
        ->get();

        $tab = array();
        foreach ($courrier_entransit1 as $c) {
            array_push($tab, $c->code);
        }
        foreach ($courrier_entransit2 as $c) {
            array_push($tab, $c->code);
        }

        $elts = array_unique($tab);

        $cour0 = DB::table('courriers')
        ->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', 'RECEPTIONNER')
        ->get();

        $cour1 = DB::table('courriers')
        ->where('user_recept_id', '=', Auth::user()->id)
        ->where('status', '=', 'RECEPTIONNER')
        ->get();

        $tables = array();
        foreach ($cour0 as $c) {
            array_push($tables, $c->code);
        }
        foreach ($cour1 as $c) {
            array_push($tables, $c->code);
        }

        $recepts = array_unique($tables);

        $cou0 = DB::table('courriers')
        ->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', 'LIVRER')
        ->get();

        $cou1 = DB::table('courriers')
        ->where('user_recept_id', '=', Auth::user()->id)
        ->where('status', '=', 'LIVRER')
        ->get();

        $tab = array();
        foreach ($cou0 as $c) {
            array_push($tab, $c->code);
        }
        foreach ($cou1 as $c) {
            array_push($tab, $c->code);
        }

        $codes = array_unique($tab);

        $courrier_annuler = DB::table('courriers')
        ->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', 'ANNULER')
        ->count();

        $courriers1 = Courrier::with('users', 
                                    'emetteurs', 
                                    'recepteurs', 
                                    'coursiers', 
                                    'users_recept', 
                                    'site_recepts',
                                    'site_exps',
                                    'destinateurs',
                                    'chauffeurs',
                                    'itineraires'
        )->where('user_recept_id', '=', Auth::user()->id)->where('status', '=', 'RECEPTIONNER')->get();

        $courriers2 = Courrier::with('users',
                                    'emetteurs',
                                    'recepteurs', 
                                    'coursiers', 
                                    'users_recept', 
                                    'site_recepts',
                                    'site_exps',
                                    'destinateurs',
                                    'chauffeurs',
                                    'itineraires'
        )->where('user_create_id', '=', Auth::user()->id)->where('status', '=', 'RECEPTIONNER')->get();

        $courriers = [];
        $courriers3 = [];

        foreach ($courriers1 as  $courrier) {
                array_push($courriers3, $courrier);
        }

        foreach ($courriers2 as  $courrier) {
                array_push($courriers3, $courrier);
        }

        //RECUPERATION COURRIERS SANS DOUBLON
                $tab = [];
                foreach ($courriers3 as $c) {
                    array_push($tab, $c->code);
                }
    
                $tab2 = array_unique($tab);
                
                foreach ($tab2 as $code) {
                    array_push($courriers, Courrier::with('users',
                                                        'emetteurs',
                                                        'recepteurs', 
                                                        'coursiers', 
                                                        'users_recept', 
                                                        'site_recepts',
                                                        'site_exps',
                                                        'destinateurs',
                                                        'chauffeurs',
                                                        'itineraires'
                    )->where('code', '=', $code)->get()->first());
                }
        //FIN RECUPERATION COURRIERS SANS DOUBLON
    

        $personnes = Personne::with('postes', 'vehicules')->get();

        $vehicules = DB::table('vehicules')->get();

        return view('courriers.index_livraison', 
        [
            'courriers' => $courriers, 
            'personnes' => $personnes,
            'encours' => $courrier_encours,
            'entransit' => count($elts),
            'receptionner' => count($recepts),
            'livrer' => count($codes),
            'annuler' => $courrier_annuler,
            'vehicules' => $vehicules,
        ]);
    }


    public function livraison(Request $request){

        toastr()->success('Courriers Livrer Avec Succèss !');

        $peronneEffective = NULL;

        if($request->input('fullname') && $request->input('telephone')){

            Personne::create([
                'fullname' => $request->input('fullname'),
                'telephone' => intval($request->input('telephone')),
            ]);

            $peronneEffective = DB::table('personnes')->get()->last();

        }

        $courrier = Courrier::find($request->id);

        $courrier->DateLivraionCourrier = Carbon::now()->format('Y-m-d H:i:s');

        $courrier->status = $request->input('status');

        if($peronneEffective){
            $courrier->recepteur_effectif_id = $peronneEffective->id;
        }elseif($request->input('recepteur_effectif_id')) {
            $courrier->recepteur_effectif_id = intval($request->input('recepteur_effectif_id'));
        }

        $courrier->save();

        return response()->json();
    }

    public function archive(){

        toastr()->info('Courriers Livrer !');

        $courriers1 = Courrier::with('users', 
                                    'emetteurs', 
                                    'recepteurs', 
                                    'recepteur_effectifs', 
                                    'coursiers', 
                                    'users_recept', 
                                    'site_recepts',
                                    'site_exps',
                                    'chauffeurs',
                                    'itineraires'
        )->where('user_recept_id', '=', Auth::user()->id)->where('status', '=', 'LIVRER')->get();
        
        $cour2 = Courrier::with('users', 
                                    'emetteurs', 
                                    'recepteurs', 
                                    'recepteur_effectifs', 
                                    'coursiers', 
                                    'users_recept', 
                                    'site_recepts',
                                    'site_exps',
                                    'chauffeurs',
                                    'itineraires'
        )->where('user_create_id', '=', Auth::user()->id)
        ->get();

        $courriers2 = [];
        foreach ($cour2 as $courrier) {
            if($courrier->status == 'LIVRER' || $courrier->status == 'ANNULER'){
                array_push($courriers2, $courrier);
            }
        }

        $courriers = [];
        $courriers3 = [];

        foreach ($courriers1 as  $courrier) {
            array_push($courriers3, $courrier);
        }

        foreach ($courriers2 as  $courrier) {
            array_push($courriers3, $courrier);
        }

        //RECUPERATION COURRIERS SANS DOUBLON
            $tab = [];
            foreach ($courriers3 as $c) {
                array_push($tab, $c->code);
            }

            $table = array_unique($tab);

            foreach ($table as $code) {
                array_push($courriers, Courrier::with('users', 
                                                    'emetteurs', 
                                                    'recepteurs', 
                                                    'recepteur_effectifs', 
                                                    'coursiers', 
                                                    'users_recept', 
                                                    'site_recepts',
                                                    'site_exps',
                                                    'chauffeurs',
                                                    'itineraires'
                )->where('code', $code)->get()->first());
            }
        //FIN RECUPERATION COURRIERS SANS DOUBLON
        $vehicules = DB::table('vehicules')->get();

        return view('courriers.index_courrier_livrer', ['courriers' => $courriers, 'vehicules' => $vehicules]);
    }


    public function annuler(Request $request){

        $courrier = Courrier::find($request->id);

        $courrier->status = $request->input('status');
        $courrier->save();

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Courrier::find($request->id)->delete();

        toastr()->info('Courrier Supprimer Avec Succèss !');

        return response()->json();
    }

    public function consulter(Request $request){

        toastr()->info('Liste Courriers Par Région !');

        $statuts = [
            "ENCOURS",
            "ENTRANSIT",
            "RECEPTIONNER",
            "LIVRER",
            "ANNULER"
        ];

        $encours = 0;
        $entransit = 0;
        $receptionner = 0;
        $livrer = 0;
        $annuler = 0;

        $regions = Region::all();
        $vehicules = DB::table('vehicules')->get();

        if($request->input('id')){

            $region_selectionner = DB::table('regions')->where('id', '=', $request->input('id'))->get()->first();

            $courrier1 = Courrier::with('users', 
                                        'emetteurs', 
                                        'recepteurs', 
                                        'recepteur_effectifs', 
                                        'coursiers', 
                                        'users_recept',
                                        'site_exps', 
                                        'site_recepts',
                                        'destinateurs',
                                        'chauffeurs',
                                        'itineraires'
            )->get();

            $courriers = [];

            foreach ($courrier1 as $courrier) {
                $site = Site::where('id', '=', $courrier->users->site_id)->get()->first();

                if($site){
                    if(intval($site->region_id) == intval($request->input('id'))){
                        array_push($courriers, $courrier);
                    }    
                }
            }

            foreach ($courrier1 as $courrier) {
                $sit = DB::table('sites')->where('id', '=', $courrier->site_recept_id)->get()->first();
                if($sit->region_id == $request->input('id')){
                    array_push($courriers, $courrier);
                }
            }

            $codes = [];
            foreach ($courriers as $courrier) {
                array_push($codes, $courrier->code);
            }

            $table = array_unique($codes);

            $tableCourriers = array();
            foreach ($table as $code) {
                array_push($tableCourriers, Courrier::with('users','emetteurs','recepteurs', 'coursiers', 'users_recept', 'site_recepts', 'site_exps', 'itineraires')->where('code', '=', $code)->get()->first());
            }

            foreach ($tableCourriers as $courrier) {
                switch ($courrier->status) {
                    case 'ENCOURS':
                        $encours +=1;
                        break;
                    case 'ENTRANSIT':
                        $entransit +=1;
                        break;
                    case 'RECEPTIONNER':
                        $receptionner +=1;
                        break;
                    case 'LIVRER':
                        $livrer +=1;
                        break;
                    case 'ANNULER':
                        $annuler +=1;
                        break;
                    default:
                        break;
                }
            }
            return view('courriers.consultation_courrier_region', 
            ['courriers' => $tableCourriers,
             'regions' => $regions, 
             'statuts' => $statuts, 
             'region_selectionner' => $region_selectionner,
             'encours' => $encours,
             'entransit' => $entransit,
             'receptionner' => $receptionner,
             'livrer' => $livrer,
             'annuler' => $annuler,
             'vehicules' => $vehicules
            ]);
        }else{
            //AUCUNE REGION SELECTIONNER
            $region_selectionner = NULL;

            $courriers = Courrier::with('users',
                                        'emetteurs',
                                        'recepteurs',
                                        'recepteur_effectifs',
                                        'coursiers',
                                        'users_recept',
                                        'site_recepts',
                                        'site_exps',
                                        'itineraires'
            )->get();
            
            return view('courriers.consultation_courrier_region', 
            ['courriers' => $courriers, 
             'regions' => $regions, 
             'statuts' => $statuts, 
             'region_selectionner' => $region_selectionner,
             'encours' => $encours,
             'entransit' => $entransit,
             'receptionner' => $receptionner,
             'livrer' => $livrer,
             'annuler' => $annuler,
             'vehicules' => $vehicules
            ]);
        }
    }

    public function generate_pdf_file(Request $request){
        $courriers = Courrier::with('users', 
                                    'emetteurs', 
                                    'recepteurs', 
                                    'coursiers', 
                                    'users_recept', 
                                    'site_recepts'
        )->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', $request->input('status'))->get();
        $pdf = PDF::loadView('PDF/courriers', ['courriers' => $courriers]);
        
        return $pdf->stream('courriers.pdf', array('Attachment'=> false));
    }

    public function generatePDF(Request $request){

        $courriers = array();
        $courriers1 = Courrier::with('users', 
                                    'emetteurs', 
                                    'recepteurs', 
                                    'coursiers', 
                                    'users_recept', 
                                    'site_recepts'
        )->where('user_create_id', '=', Auth::user()->id)
        ->where('status', '=', $request->input('status'))->get();
        
        foreach ($courriers1 as $courrier) {
            array_push($courriers, $courrier);
        }
        $courriers2 = Courrier::with('users', 
                                    'emetteurs', 
                                    'recepteurs', 
                                    'coursiers', 
                                    'users_recept', 
                                    'site_recepts'
        )->where('user_recept_id', '=', Auth::user()->id)
        ->where('status', '=', $request->input('status'))->get();

        foreach ($courriers2 as $courrier) {
            array_push($courriers, $courrier);
        }

        $codes = array();
        foreach ($courriers as $courrier) {
            array_push($codes, $courrier->code);
        }

        $table = array_unique($codes);

        $colis = array();
        foreach ($table as $code) {
            array_push($colis, 
            Courrier::with('users', 
                           'emetteurs', 
                           'recepteurs', 
                           'coursiers', 
                           'users_recept', 
                           'site_recepts')
            ->where('code', '=', $code)->get()->first());
        }
        $pdf = PDF::loadView('PDF/courriers', ['courriers' => $colis]);
        
        return $pdf->stream('courriers.pdf', array('Attachment'=> false));
    }

    public function generate(Request $request){

        $courriers = Courrier::with('users',
                                    'emetteurs',
                                    'recepteurs', 
                                    'coursiers', 
                                    'users_recept', 
                                    'site_recepts'
        )->where('status', '=', $request->input('status'))->get();

        $pdf = PDF::loadView('PDF/courriers', ['courriers' => $courriers]);
        
        return $pdf->stream('courriers.pdf', array('Attachment'=> false));
    }

    public function generateAllCourrier(){
            $courriers = Courrier::with('users', 
                                        'emetteurs', 
                                        'recepteurs', 
                                        'coursiers', 
                                        'users_recept', 
                                        'site_recepts'
            )->get();

            $pdf = PDF::loadView('PDF/courriers', ['courriers' => $courriers]);

            return $pdf->stream('courriers.pdf', array('Attachment'=> false));
    }

    public function generatePDF_par_date(Request $request){

        $courriers = array();

        $couriers1 = Courrier::with('users','emetteurs','recepteurs', 'coursiers', 'users_recept', 'site_recepts')
        ->where('user_create_id', '=', Auth::user()->id)->get();
        
        foreach ($couriers1 as  $courrier) {
            $d1 = Carbon::createFromFormat('Y-m-d', Carbon::parse($courrier->date_create)->format('Y-m-d'));
            $d2 = Carbon::createFromFormat('Y-m-d', $request->input('date_create'));
            if($d1->eq($d2)){
                array_push($courriers, $courrier);
            }
        }

        $courriers2 = array();
        $date_int = Carbon::createFromFormat('Y-m-d', $request->input('date_create'));
        $cours2 = Courrier::with('users','emetteurs','recepteurs', 'coursiers', 'users_recept', 'site_recepts')
        ->where('user_recept_id', '=', Auth::user()->id)
        ->get();

        foreach ($cours2 as $courrier) {
            if($courrier->status == "RECEPTIONNER" || $courrier->status == "LIVRER"){
                if($courrier->DateReceptCourrier){
                    $d1 = Carbon::createFromFormat('Y-m-d', Carbon::parse($courrier->DateReceptCourrier)->format('Y-m-d'));
                    $d2 = Carbon::createFromFormat('Y-m-d', $request->input('date_create'));
                    if($d1->eq($d2)){
                        array_push($courriers2, $courrier);
                    }
                }
            }
        }

        foreach ($courriers2 as $courrier) {
            array_push($courriers, $courrier);
        }

        $courriers3 = Courrier::with('users','emetteurs','recepteurs', 'coursiers', 'users_recept', 'site_recepts')
        ->where('user_create_id', '=', Auth::user()->id)
        ->get();

        foreach ($courriers3 as $courrier) {
            $d1 = Carbon::createFromFormat('Y-m-d', Carbon::parse($courrier->DateRetraitCourrier)->format('Y-m-d'));
            $d2 = Carbon::createFromFormat('Y-m-d', $request->input('date_create'));
            if($d1->eq($d2)){
                array_push($courriers, $courrier);
            }
        }

        $tab_code = [];
        foreach ($courriers as $c) {
            array_push($tab_code, $c->code);
        }
        $table = array_unique($tab_code);

        $all = array();
        foreach ($table as $code) {
            array_push($all, Courrier::with('users','emetteurs','recepteurs', 'coursiers', 'users_recept', 'site_recepts')->where('code', '=', $code)->get()->first());
        }


        $pdf = PDF::loadView('PDF/courriers', ['courriers' => $all]);
        
        return $pdf->stream('courriers_journalier.pdf', array('Attachment'=> false));
    }

    public function generatePDF_Journalier(){
        $courriers = array();

        $couriers1 = Courrier::with('users','emetteurs','recepteurs', 'coursiers', 'users_recept', 'site_recepts')
        ->where('user_create_id', '=', Auth::user()->id)->get();

        foreach ($couriers1 as  $courrier) {
            $d1 = Carbon::createFromFormat('Y-m-d', Carbon::parse($courrier->date_create)->format('Y-m-d'));
            $d2 = Carbon::createFromFormat('Y-m-d', Carbon::now()->format('Y-m-d'));
            if($d1->eq($d2)){
                array_push($courriers, $courrier);
            }
        }

        $courriers2 = array();
        $cours2 = Courrier::with('users','emetteurs','recepteurs', 'coursiers', 'users_recept', 'site_recepts')
        ->where('user_recept_id', '=', Auth::user()->id)
        ->get();

        foreach ($cours2 as $courrier) {
            if($courrier->status == "RECEPTIONNER" || $courrier->status == "LIVRER"){
                $d1 = Carbon::createFromFormat('Y-m-d', Carbon::parse($courrier->DateReceptCourrier)->format('Y-m-d'));
                $d2 = Carbon::createFromFormat('Y-m-d', Carbon::now()->format('Y-m-d'));
                if($d1->eq($d2)){
                        array_push($courriers2, $courrier);
                    }
                }
        }

        foreach ($courriers2 as $courrier) {
            array_push($courriers, $courrier);
        }

        $courriers3 = Courrier::with('users','emetteurs','recepteurs', 'coursiers', 'users_recept', 'site_recepts')
        ->where('user_create_id', '=', Auth::user()->id)
        ->get();

        foreach ($courriers3 as $courrier) {
            $d1 = Carbon::createFromFormat('Y-m-d', Carbon::parse($courrier->DateRetraitCourrier)->format('Y-m-d'));
            $d2 = Carbon::createFromFormat('Y-m-d', Carbon::now()->format('Y-m-d'));
            if($d1->eq($d2)){
                array_push($courriers, $courrier);
            }
        }

        $tab_code = [];
        foreach ($courriers as $c) {
            array_push($tab_code, $c->code);
        }
        $table = array_unique($tab_code);

        $all = array();
        foreach ($table as $code) {
            array_push($all, Courrier::with('users','emetteurs','recepteurs', 'coursiers', 'users_recept', 'site_recepts')->where('code', '=', $code)->get()->first());
        }

        $pdf = PDF::loadView('PDF/courriers', ['courriers' => $all]);
        
        return $pdf->stream('courriers_journalier.pdf', array('Attachment'=> false));
    }

    public function save_courrier_preview(Request $request)
    {
        $input = json_decode($request->input('courrier'));

        $site_expediteur = NULL;
        $site_reception = NULL;
        $destinateur = NULL;
        $phone_destinateur = NULL;

        $courrier = new Courrier();

        $courrier->code = $input->code;
        $courrier->TypeCourrier = $input->TypeCourrier;
        $courrier->TypeEnvoie = $input->TypeEnvoie;
        $courrier->objet = $input->objet;
        $courrier->status = $input->status;
        $courrier->Transitoire = $input->Transitoire ? $input->Transitoire : NULL;

        if($input->destinateurs){
            $destinateur = $input->destinateurs->fullname;
            $phone_destinateur = $input->destinateurs->telephone;
        }

        $expediteur = $input->emetteurs->fullname;
        $telephone_expediteur = $input->emetteurs->telephone;
        
        $expeditaire = $input->recepteurs->fullname;
        $telephone_expeditaire = $input->recepteurs->telephone;
                
        if($input->site_recepts){
            $site_reception = $input->site_recepts;
        }
        if($input->site_exps){
            $site_expediteur = $input->site_exps;
        }
        $pdf = PDF::loadView('PDF/preSaveCourrier',
            [
                'courrier' => $courrier,
                'destinateur' => $destinateur,
                'phone_destinateur' => $phone_destinateur,
                'expediteur' => $expediteur,
                'telephone_expediteur' => $telephone_expediteur,
                'expeditaire' => $expeditaire,
                'telephone_expeditaire' => $telephone_expeditaire,
                'site_reception' => $site_reception,
                'site_expediteur' => $site_expediteur,
            ]);

        return $pdf->stream('preview_courrier.pdf', array('Attachment'=> false));
    }

    public function generatePDF_par_region(Request $request){

        $courriers = array();

        $site = DB::table('sites')
        ->where('region_id', '=', $request->input('id'))
        ->where('gestionnaire', '=', TRUE)
        ->get()->first();

        if($site){
            $user = DB::table('users')
            ->where('site_id', '=', $site->id)
            ->get()->first();

            if($user){
                $courriers1 = DB::table('courriers')
                ->where('user_create_id', '=', $user->id)
                ->get();
                
                $courriers2 = DB::table('courriers')
                ->where('user_recept_id', '=', $user->id)
                ->get();
    
                $tab = array();

                foreach ($courriers1 as $courrier) {
                    array_push($tab, $courrier);
                }
                foreach ($courriers2 as $courrier) {
                    array_push($tab, $courrier);
                }
        
                $codes = array();
                foreach ($tab as $courrier) {
                    array_push($codes, $courrier->code);
                }

                $table = array_unique($codes);
        
                foreach ($table as $code) {
                    array_push($courriers, Courrier::with('users', 
                                                        'emetteurs', 
                                                        'recepteurs', 
                                                        'recepteur_effectifs', 
                                                        'coursiers', 
                                                        'users_recept', 
                                                        'site_recepts',
                                                        'site_exps',
                                                        'destinateurs',
                                                        'chauffeurs',
                    )->where('code', '=', $code)->get()->first());
                }
        
            }
        }
        
        $pdf = PDF::loadView('PDF/courrierParRegion',
        [
            'courriers' => $courriers,
        ]);

        return $pdf->stream('courrier_regions.pdf', array('Attachment'=> false));
    }
    
    public function suiviClient(Request $request){

        $sites = DB::table('sites')->get();

        $vehicules = DB::table('vehicules')->get();

        if(!$request->tous){
            $courriers = Courrier::with('users', 
                                        'emetteurs', 
                                        'recepteurs', 
                                        'recepteur_effectifs', 
                                        'coursiers', 
                                        'users_recept', 
                                        'site_recepts',
                                        'site_exps',
                                        'destinateurs',
                                        'chauffeurs',
                                        'itineraires',
            )->where('site_exp_id', '=', Auth::user()->site_id)
            ->where('site_exp_id', '<>', NULL)
            ->orWhere('site_recept_id', '=', Auth::user()->site_id)
            ->where('site_recept_id', '<>', NULL)
            ->get();
            return view('courriers.interface_client', ['courriers' => $courriers, 'services' => $sites, 'vehicules' => $vehicules]);
        }else{
            $courriers = Courrier::with('users', 
                        'emetteurs', 
                        'recepteurs', 
                        'recepteur_effectifs', 
                        'coursiers', 
                        'users_recept', 
                        'site_recepts',
                        'site_exps',
                        'destinateurs',
                        'chauffeurs',
                        'itineraires'
            )->get();
            return view('courriers.interface_client', ['courriers' => $courriers, 'services' => $sites, 'vehicules' => $vehicules]);
        }
    }

    public function suiviClientReq(Request $request){

            $courriers = Courrier::with('users', 
                        'emetteurs', 
                        'recepteurs', 
                        'recepteur_effectifs',
                        'coursiers',
                        'users_recept',
                        'site_recepts',
                        'site_exps',
                        'destinateurs',
                        'chauffeurs',
                        'itineraires',
            )->where('site_exp_id', intval($request->input('id')))
            ->orWhere('site_recept_id', intval($request->input('id')))
            ->get();

            $sites = DB::table('sites')->get();

            $vehicules = DB::table('vehicules')->get();

            return view('courriers.interface_client', ['courriers' => $courriers, 'services' => $sites, 'vehicules' => $vehicules]);
    }

    public function setGraph(Request $request){

        $years = [
            2022,2023,2024,2025,2026,2027,2028,2029,2030
        ];

        $Qte_total = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

        $colis_en_retard = array();
    
        $regions = DB::table('regions')->get();
    
        $sites = DB::table('sites')->get();
    
        $users = DB::table('users')->get();
    
        $courriers = Courrier::with('users','emetteurs','recepteurs','recepteur_effectifs','coursiers','users_recept','site_recepts', 'itineraires')->get();
    
        $nbre_courriers = DB::table('courriers')->count();
        $nbre_courriers_interne = DB::table('courriers')->where('TypeEnvoie', '=', 'INTERNE')->count();
        $nbre_courriers_externe = DB::table('courriers')->where('TypeEnvoie', '=', 'EXTERNE')->count();
        $nbre_courriers_encours = DB::table('courriers')->where('status', '=', 'ENCOURS')->count();
        $nbre_courriers_entransit = DB::table('courriers')->where('status', '=', 'ENTRANSIT')->count();
        $nbre_courriers_receptionner = DB::table('courriers')->where('status', '=', 'RECEPTIONNER')->count();
        $nbre_courriers_livrer = DB::table('courriers')->where('status', '=', 'LIVRER')->count();
        $nbre_courriers_annuler = DB::table('courriers')->where('status', '=', 'ANNULER')->count();
    
        $percent_encours = 0;
        $percent_entransit = 0;
        $percent_receptionner = 0;
        $percent_livrer = 0;
        $percent_annuler = 0;
    
        if($nbre_courriers > 0){
            $percent_encours = ($nbre_courriers_encours/$nbre_courriers) * 100;
            $percent_encours = intval(substr($percent_encours, 0, 5));
    
            $percent_entransit = ($nbre_courriers_entransit/$nbre_courriers) * 100;
            $percent_entransit = intval(substr($percent_entransit, 0, 5));
    
            $percent_receptionner = ($nbre_courriers_receptionner/$nbre_courriers) * 100;
            $percent_receptionner = intval(substr($percent_receptionner, 0, 5));
    
            $percent_livrer = ($nbre_courriers_livrer/$nbre_courriers) * 100;
            $percent_livrer = intval(substr($percent_livrer, 0, 5));
    
            $percent_annuler = ($nbre_courriers_annuler/$nbre_courriers) * 100;
            $percent_annuler = intval(substr($percent_annuler, 0, 5));
        }

        toastr()->info('BIENVENUE '. Auth::user()->fullname .' !');
    

        $Qte_janvier = 0;
        $Qte_fevrier = 0;
        $Qte_mars = 0;
        $Qte_avril = 0;
        $Qte_mai = 0;
        $Qte_juin = 0;
        $Qte_juillet = 0;
        $Qte_aout = 0;
        $Qte_septembre = 0;
        $Qte_octobre = 0;
        $Qte_novembre = 0;
        $Qte_deccembre = 0;
    
        $newCourDate = array();

        foreach ($courriers as $courrier) {
            if(intval(substr($courrier->date_create, 0, 4)) == intval($request->input('year'))){
                array_push($newCourDate, $courrier);
            }
        }

        foreach ($newCourDate as $courrier) {
            switch (intval(substr($courrier->date_create, 5, 2))) {
                    case 1:
                        $Qte_janvier +=1;
                        break;
                    case 2:
                        $Qte_fevrier +=1;
                        break;
                    case 3:
                        $Qte_mars +=1;
                        break;
                    case 4:
                        $Qte_avril +=1;
                        break;
                    case 5:
                        $Qte_mai +=1;
                        break;
                    case 6:
                        $Qte_juin +=1;
                        break;
                    case 7:
                        $Qte_juillet +=1;
                        break;
                    case 8:
                        $Qte_aout +=1;
                        break;
                    case 9:
                        $Qte_septembre +=1;
                        break;
                    case 10:
                        $Qte_octobre +=1;
                        break;
                    case 11:
                        $Qte_novembre +=1;
                        break;
                    case 12:
                        $Qte_deccembre +=1;
                        break;
                    default:
                        break;
            }
        }
        
        return view('dashboard', 
        [
                'Qte_janvier' => $Qte_janvier,
                'Qte_fevrier' => $Qte_fevrier,
                'Qte_mars' => $Qte_mars,
                'Qte_avril' => $Qte_avril,
                'Qte_mai' => $Qte_mai,
                'Qte_juin' => $Qte_juin,
                'Qte_juillet' => $Qte_juillet,
                'Qte_aout' => $Qte_aout,
                'Qte_septembre' => $Qte_septembre,
                'Qte_octobre' => $Qte_octobre,
                'Qte_novembre' => $Qte_novembre,
                'Qte_deccembre' => $Qte_deccembre,

                'regions' => $regions,
                'sites' => $sites,
                'users' => $users,
                'courriers' => $courriers,
                'percent_encours' => $percent_encours,
                'percent_entransit' => $percent_entransit,
                'percent_receptionner' => $percent_receptionner,
                'percent_livrer' => $percent_livrer,
                'percent_annuler' => $percent_annuler,
                'nbre_courriers' => $nbre_courriers,
                'nbre_courriers_interne' => $nbre_courriers_interne,
                'nbre_courriers_externe' => $nbre_courriers_externe,
                'nbre_courriers_encours' => $nbre_courriers_encours,
                'nbre_courriers_entransit' => $nbre_courriers_entransit,
                'nbre_courriers_receptionner' => $nbre_courriers_receptionner,
                'nbre_courriers_livrer' => $nbre_courriers_livrer,
                'nbre_courriers_annuler' => $nbre_courriers_annuler,
                'years' => $years,
                'colis_en_retard' => $colis_en_retard,
                'Qte_total' => $Qte_total,
        ]);
    }

    public function setGraphParRegion(Request $request){

        $years = [
            2022,2023,2024,2025,2026,2027,2028,2029,2030
        ];

        $Qte_total = array();

        $colis_en_retard = array();
    
        $regions = DB::table('regions')->get();
    
        $sites = DB::table('sites')->get();
    
        $users = DB::table('users')->get();
    
        $courriers = Courrier::with('users','emetteurs','recepteurs','recepteur_effectifs','coursiers','users_recept','site_recepts', 'itineraires')->get();
    
        $nbre_courriers = DB::table('courriers')->count();
        $nbre_courriers_interne = DB::table('courriers')->where('TypeEnvoie', '=', 'INTERNE')->count();
        $nbre_courriers_externe = DB::table('courriers')->where('TypeEnvoie', '=', 'EXTERNE')->count();
        $nbre_courriers_encours = DB::table('courriers')->where('status', '=', 'ENCOURS')->count();
        $nbre_courriers_entransit = DB::table('courriers')->where('status', '=', 'ENTRANSIT')->count();
        $nbre_courriers_receptionner = DB::table('courriers')->where('status', '=', 'RECEPTIONNER')->count();
        $nbre_courriers_livrer = DB::table('courriers')->where('status', '=', 'LIVRER')->count();
        $nbre_courriers_annuler = DB::table('courriers')->where('status', '=', 'ANNULER')->count();
    
        $percent_encours = 0;
        $percent_entransit = 0;
        $percent_receptionner = 0;
        $percent_livrer = 0;
        $percent_annuler = 0;
    
        if($nbre_courriers > 0){
            $percent_encours = ($nbre_courriers_encours/$nbre_courriers) * 100;
            $percent_encours = intval(substr($percent_encours, 0, 5));
    
            $percent_entransit = ($nbre_courriers_entransit/$nbre_courriers) * 100;
            $percent_entransit = intval(substr($percent_entransit, 0, 5));
    
            $percent_receptionner = ($nbre_courriers_receptionner/$nbre_courriers) * 100;
            $percent_receptionner = intval(substr($percent_receptionner, 0, 5));
    
            $percent_livrer = ($nbre_courriers_livrer/$nbre_courriers) * 100;
            $percent_livrer = intval(substr($percent_livrer, 0, 5));
    
            $percent_annuler = ($nbre_courriers_annuler/$nbre_courriers) * 100;
            $percent_annuler = intval(substr($percent_annuler, 0, 5));
        }

        toastr()->info('BIENVENUE '. Auth::user()->fullname .' !');
    

        $Qte_janvier = 0;
        $Qte_fevrier = 0;
        $Qte_mars = 0;
        $Qte_avril = 0;
        $Qte_mai = 0;
        $Qte_juin = 0;
        $Qte_juillet = 0;
        $Qte_aout = 0;
        $Qte_septembre = 0;
        $Qte_octobre = 0;
        $Qte_novembre = 0;
        $Qte_deccembre = 0;
        
        //Code Courrier Par Region
        $selected_year = intval($request->input('year'));

        $tab = array();
        foreach ($courriers as $courrier) {
            if(intval(substr($courrier->date_create, 0, 4)) == $selected_year){
                array_push($tab, $courrier);
            }
        }

        for ($i=0; $i < count($regions); $i++) { 
                 $region = $regions[$i];

                 $Qte_region_courante = 0;
                 for ($j=0; $j < count($tab); $j++) {
                    $courrier = $tab[$j];

                    $site = DB::table('sites')->where('id', '=', $courrier->users->site_id)->get()->first();
                    if(intval($site->region_id) == intval($region->id)){
                        $Qte_region_courante +=1;
                    }
                 }
                 array_push($Qte_total, $Qte_region_courante);
        }
            
        return view('dashboard', 
        [
                'Qte_janvier' => $Qte_janvier,
                'Qte_fevrier' => $Qte_fevrier,
                'Qte_mars' => $Qte_mars,
                'Qte_avril' => $Qte_avril,
                'Qte_mai' => $Qte_mai,
                'Qte_juin' => $Qte_juin,
                'Qte_juillet' => $Qte_juillet,
                'Qte_aout' => $Qte_aout,
                'Qte_septembre' => $Qte_septembre,
                'Qte_octobre' => $Qte_octobre,
                'Qte_novembre' => $Qte_novembre,
                'Qte_deccembre' => $Qte_deccembre,

                'Qte_total' => $Qte_total,
    
                'regions' => $regions,
                'sites' => $sites,
                'users' => $users,
                'courriers' => $courriers,
                'percent_encours' => $percent_encours,
                'percent_entransit' => $percent_entransit,
                'percent_receptionner' => $percent_receptionner,
                'percent_livrer' => $percent_livrer,
                'percent_annuler' => $percent_annuler,
                'nbre_courriers' => $nbre_courriers,
                'nbre_courriers_interne' => $nbre_courriers_interne,
                'nbre_courriers_externe' => $nbre_courriers_externe,
                'nbre_courriers_encours' => $nbre_courriers_encours,
                'nbre_courriers_entransit' => $nbre_courriers_entransit,
                'nbre_courriers_receptionner' => $nbre_courriers_receptionner,
                'nbre_courriers_livrer' => $nbre_courriers_livrer,
                'nbre_courriers_annuler' => $nbre_courriers_annuler,
                'years' => $years,
                'colis_en_retard' => $colis_en_retard,
        ]);    
    }

    public function setCourrierRetard(Request $request){

        $years = [
            2022,2023,2024,2025,2026,2027,2028,2029,2030
        ];

        $Qte_total = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    
        $regions = DB::table('regions')->get();
    
        $sites = DB::table('sites')->get();
    
        $users = DB::table('users')->get();
    
        $courriers = Courrier::with('users','emetteurs','recepteurs','recepteur_effectifs','coursiers','users_recept','site_recepts', 'itineraires')->get();
    
        $nbre_courriers = DB::table('courriers')->count();
        $nbre_courriers_interne = DB::table('courriers')->where('TypeEnvoie', '=', 'INTERNE')->count();
        $nbre_courriers_externe = DB::table('courriers')->where('TypeEnvoie', '=', 'EXTERNE')->count();
        $nbre_courriers_encours = DB::table('courriers')->where('status', '=', 'ENCOURS')->count();
        $nbre_courriers_entransit = DB::table('courriers')->where('status', '=', 'ENTRANSIT')->count();
        $nbre_courriers_receptionner = DB::table('courriers')->where('status', '=', 'RECEPTIONNER')->count();
        $nbre_courriers_livrer = DB::table('courriers')->where('status', '=', 'LIVRER')->count();
        $nbre_courriers_annuler = DB::table('courriers')->where('status', '=', 'ANNULER')->count();
    
        $percent_encours = 0;
        $percent_entransit = 0;
        $percent_receptionner = 0;
        $percent_livrer = 0;
        $percent_annuler = 0;
    
        if($nbre_courriers > 0){
            $percent_encours = ($nbre_courriers_encours/$nbre_courriers) * 100;
            $percent_encours = intval(substr($percent_encours, 0, 5));
    
            $percent_entransit = ($nbre_courriers_entransit/$nbre_courriers) * 100;
            $percent_entransit = intval(substr($percent_entransit, 0, 5));
    
            $percent_receptionner = ($nbre_courriers_receptionner/$nbre_courriers) * 100;
            $percent_receptionner = intval(substr($percent_receptionner, 0, 5));
    
            $percent_livrer = ($nbre_courriers_livrer/$nbre_courriers) * 100;
            $percent_livrer = intval(substr($percent_livrer, 0, 5));
    
            $percent_annuler = ($nbre_courriers_annuler/$nbre_courriers) * 100;
            $percent_annuler = intval(substr($percent_annuler, 0, 5));
        }

        
        toastr()->info('BIENVENUE '. Auth::user()->fullname .' !');
    
        $Qte_janvier = 0;
        $Qte_fevrier = 0;
        $Qte_mars = 0;
        $Qte_avril = 0;
        $Qte_mai = 0;
        $Qte_juin = 0;
        $Qte_juillet = 0;
        $Qte_aout = 0;
        $Qte_septembre = 0;
        $Qte_octobre = 0;
        $Qte_novembre = 0;
        $Qte_deccembre = 0;

        //Here Start Code for colis retard
        $colis_en_retard = array();

        $annee_selectionner = intval($request->input('year'));

        $tab = array();
        foreach ($courriers as $courrier) {
            if(intval(substr($courrier->date_create, 0, 4)) == $annee_selectionner){
                array_push($tab, $courrier);
            }
        }

        foreach ($tab as $key => $courrier) {
                    
            $date_create = Carbon::parse($courrier->date_create)->format('Y-m-d H:i:s');
    
            $date_reception = $courrier->DateReceptCourrier ? Carbon::parse($courrier->DateReceptCourrier) : NULL;
    
            if($date_reception){
                $diff = $date_reception->diff($date_create);
                
                $itineraire_duree = $courrier->itineraires ? $courrier->itineraires->duree : NULL;
                $duree = 0;

                if(intval($diff->d) > 0){
                    $duree += $diff->d * 24;
                }

                $duree += intval($diff->h);

                if($duree > intval($itineraire_duree)){
                    array_push($colis_en_retard, $courrier);
                }    
            }else{

                $date_livraison = $courrier->DateLivraionCourrier ? Carbon::parse($courrier->DateLivraionCourrier) : NULL;

                if($date_livraison){

                    $diff = $date_livraison->diff($date_create);
                    $itineraire_duree = $courrier->itineraires ? $courrier->itineraires->duree : NULL;
                    $duree = 0;

                    if(intval($diff->d) > 0){
                        $duree += $diff->d * 24;
                    }
    
                    $duree += intval($diff->h);
    
                    if($duree > intval($itineraire_duree)){
                        array_push($colis_en_retard, $courrier);
                    }        
                }
            }
        }

        return view('dashboard', 
        [
            'Qte_janvier' => $Qte_janvier,
            'Qte_fevrier' => $Qte_fevrier,
            'Qte_mars' => $Qte_mars,
            'Qte_avril' => $Qte_avril,
            'Qte_mai' => $Qte_mai,
            'Qte_juin' => $Qte_juin,
            'Qte_juillet' => $Qte_juillet,
            'Qte_aout' => $Qte_aout,
            'Qte_septembre' => $Qte_septembre,
            'Qte_octobre' => $Qte_octobre,
            'Qte_novembre' => $Qte_novembre,
            'Qte_deccembre' => $Qte_deccembre,

            'Qte_total' => $Qte_total,

            'regions' => $regions,
            'sites' => $sites,
            'users' => $users,
            'courriers' => $courriers,
            'percent_encours' => $percent_encours,
            'percent_entransit' => $percent_entransit,
            'percent_receptionner' => $percent_receptionner,
            'percent_livrer' => $percent_livrer,
            'percent_annuler' => $percent_annuler,
            'nbre_courriers' => $nbre_courriers,
            'nbre_courriers_interne' => $nbre_courriers_interne,
            'nbre_courriers_externe' => $nbre_courriers_externe,
            'nbre_courriers_encours' => $nbre_courriers_encours,
            'nbre_courriers_entransit' => $nbre_courriers_entransit,
            'nbre_courriers_receptionner' => $nbre_courriers_receptionner,
            'nbre_courriers_livrer' => $nbre_courriers_livrer,
            'nbre_courriers_annuler' => $nbre_courriers_annuler,
            'years' => $years,
            'colis_en_retard' => $colis_en_retard,
        ]);
    }
}
