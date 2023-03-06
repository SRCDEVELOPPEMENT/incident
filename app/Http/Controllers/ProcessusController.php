<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Pros;
use DB;
use Carbon\Carbon;

class ProcessusController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:lister-processus|creer-processus|editer-processus|supprimer-processus|voir-processus', ['only' => ['index','show']]);
        $this->middleware('permission:creer-processus', ['only' => ['create','store']]);
        $this->middleware('permission:editer-processus', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-processus', ['only' => ['destroy']]);
    }


    public function getProcessus()
    {
        return Session::get('processus');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        notify()->info('Liste Des Procéssus ! ⚡️');
        
        return view('processus.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->all();
        $get_processus = array();

        $proc = $this->getProcessus();
        for ($u=0; $u < count($proc); $u++) { 
            $p = $proc[$u];
            if(intval($p->id) != intval($input['id'])){
                array_push($get_processus, $p);
            }
        }

        $oui = true;

        foreach ($get_processus as $processus) {
            $processus_courrant = strtolower(Str::ascii(str_replace(" ", "", $processus->name)));
            $processus_saisi = strtolower(Str::ascii(str_replace(" ", "", $input['name'])));
            if(strcmp($processus_courrant, $processus_saisi) == 0){
                $oui = false;
            }
        }

        if(!$oui){
            return [];
        }else{

            DB::table('pros')->where('id', '=', $input['id'])->update([
                'name' => $input['name'],
                'description' => $input['description'] ? $input['description'] : NULL,
            ]);
            
            if(Session::has('processus')){

                $processus_edit = NULL;
                $newProcessuss = array();
    
                for ($j=0; $j < count($proc); $j++) {
                        $processus_courant = $proc[$j];
                        if(intval($request->input('id')) == intval($processus_courant->id)){

                            $processus_edit = $processus_courant;
                            $processus_edit->name = $input['name'];
                            $processus_edit->description = $input['description'] ? $input['description'] : NULL;

                        } else{
                            array_push($newProcessuss, $processus_courant);
                        }
                }

                array_push($newProcessuss, $processus_edit);

                Session::put('processus', $newProcessuss);
            }

            smilify('success', 'Procéssus Modifier Avec Succès !');

            return response([1]);
        } 
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

        $get_processus = $this->getProcessus();
        $oui = true;

        foreach ($get_processus as $processus) {
            $processus_courrant = strtolower(Str::ascii(str_replace(" ", "", $processus->name)));
            $processus_saisi = strtolower(Str::ascii(str_replace(" ", "", $input['name'])));
            if(strcmp($processus_courrant, $processus_saisi) == 0){
                $oui = false;
            }
        }

        if(!$oui){
            return [];
        }else{

            $processus = new Pros();

            $processus->name = $input['name'];
            $processus->description = $input['description'] ? $input['description'] : NULL;
            $processus->created_at = Carbon::now()->format('Y-m-d');
            $processus->save();

            $processus = DB::table('pros')->get()->last();
            
            if(Session::has('processus')){
                $newProcessus = array();
                array_push($newProcessus, $processus);

                for ($w=0; $w < count($get_processus); $w++) {
                    $pros = $get_processus[$w];
                    array_push($newProcessus, $pros);
                }
                Session::put('processus', $newProcessus);
            }

            smilify('success', 'Procéssus Enrégistrer Avec Succès !');

            return response([$processus]);    
        }
    }

    public function destroy(Request $request)
    {
        DB::table('pros')->where('id', $request->id)->delete();

        if(Session::has('processus')){
            $newProcessus = array();
            $processus = $this->getProcessus();

            for ($j=0; $j < count($processus); $j++) {
                $processus_courant = $processus[$j];
                if(intval($request->id) != intval($processus_courant->id)){
                    array_push($newProcessus, $processus_courant);
                }
            }

            Session::put('processus', $newProcessus);
        }

        smilify('success', 'Procéssus Supprimer Avec Succèss !');

        return response()->json([1]);
    }
}