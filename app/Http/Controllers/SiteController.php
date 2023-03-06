<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Site;
use App\Models\Type;
use App\Models\Region;
use Carbon\Carbon;
use DB;
use PDF;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:lister-site|creer-site|editer-site|supprimer-site', ['only' => ['index','show']]);
        $this->middleware('permission:creer-site|', ['only' => ['create','store']]);
        $this->middleware('permission:editer-site', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-site', ['only' => ['destroy']]);
    }

    public function getSites()
    {
        return Session::get('sites');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        notify()->info('Liste Des Sites ! ⚡️', 'Info Sites');

        $regions = [
            "OUEST",
            "NORD-OUEST",
            "SUD-OUEST",
            "CENTRE",
            "LITTORAL",
            "EXTREME-NORD",
            "SUD",
            "NORD",
            "ADAMAOUA",
            "EST",
        ];
        return view('sites.index',
        [
         'regions' => $regions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $get_sites = $this->getSites();
        $oui = true;

        foreach ($get_sites as $site) {
            $site_courrant = strtolower(Str::ascii(str_replace(" ", "", $site->name)));
            $site_saisi = strtolower(Str::ascii(str_replace(" ", "", $input['name'])));
            if(strcmp($site_courrant, $site_saisi) == 0){
                $oui = false;
            }
        }

        if(!$oui){
            return [];
        }else{

            $site = new Site();

            $site->name = $input['name'];
            $site->type_id = intval($input['type']);
            $site->region = $input['region'];
            $site->created_at = Carbon::now()->format('Y-m-d');
            $site->save();

            $site = Site::with('types')->get()->last();

            if(Session::has('sites')){
                $newSites = array();
                array_push($newSites, $site);

                for ($w=0; $w < count($get_sites); $w++) { 
                    $sit = $get_sites[$w];
                    array_push($newSites, $sit);
                }
                Session::put('sites', $newSites);
            }

            smilify('success', 'Site Enrégistrer Avec Succèss !');

            return response()->json([$site]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $site = Site::find($id);

        return view('sites.show',compact('site'));    
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $sites = $this->getSites();

        $Qte = 0;
        $tab = array();

        if(is_iterable($sites)){
            foreach ($sites as $site) {
                if($site->id != intval($request->input('id'))){
                    array_push($tab, $site);
                }
            }    
        }

        foreach ($tab as $site) {
            $site_present = strtolower(Str::ascii(str_replace(" ", "", $site->name)));
            $site_int = strtolower(Str::ascii(str_replace(" ", "", $request->input('name'))));
            if(strcmp($site_present, $site_int) == 0){
                $Qte += 1;
            }
        }

        if($Qte > 0){
            return [];
        }else{

            DB::table('sites')->where('id', $request->id)->update([
                'name' => $request->name,
                'region' => $request->region,
                'type_id' => intval($request->input('type')),
            ]);
            
            if(Session::has('sites')){

                $site_edit = NULL;
                $newSites = array();
    
                for ($j=0; $j < count($sites); $j++) {
                        $site_courant = $sites[$j];
                        if(intval($request->input('id')) == intval($site_courant->id)){

                            $site_edit = $site_courant;
                            $site_edit->name = $request->name;
                            $site_edit->region = $request->region;
                            $site_edit->type_id = intval($request->input('type'));

                        } else{
                            array_push($newSites, $site_courant);
                        }
                }

                array_push($newSites, $site_edit);

                Session::put('sites', $newSites);
            }

            smilify('success', 'Site Modifier Avec Succèss !');

            return response()->json([1]);    
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::table('sites')->where('id', $request->id)->delete();

        if(Session::has('sites')){
            $newSites = array();
            $sites = $this->getSites();

            for ($j=0; $j < count($sites); $j++) {
                $site_courant = $sites[$j];
                if(intval($request->id) != intval($site_courant->id)){
                    array_push($newSites, $site_courant);
                }
            }

            Session::put('sites', $newSites);
        }

        smilify('success', 'Site Supprimer Avec Succèss !');
        
        return response()->json();
    }


        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteTypeSite(Request $request)
    {
        DB::table('types')->where('id', $request->id)->delete();

        smilify('success', 'Type De Site Supprimer Avec Succèss !');
        
        return response()->json();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function type_index(Request $request){

        $types = DB::table('types')->get();

        $sites = DB::table('sites')->get();

        notify()->info('Liste Des Types ! ⚡️', 'Info Types');

        return view('type.index')->with(['types' => $types]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function type(Request $request)
    {
        DB::table('types')->insert([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);

        $type = DB::table('types')->get()->last();

        smilify('success', 'Type De Site Enrégistrer Avec Succèss !');

        return response()->json([$type]);
    }

    public function generate(){

        $sites = Site::with('regions')->get();

        $pdf = PDF::loadView('PDF/sites', ['sites' => $sites]);
        
        return $pdf->stream('sites.pdf', array('Attachment'=>0));
    }
}
