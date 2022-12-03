<?php

namespace App\Http\Controllers;
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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        notify()->info('Liste Des Procéssus ! ⚡️');

        $processus = Pros::all();

        $incidents = DB::table('incidents')->get();
        
        return view('processus.index', compact('processus', 'incidents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $input = $request->all();

        $get_processus = DB::table('pros')->where('id', '<>', $input['id'])->get();

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
            $processus = DB::table('pros')->where('id', '=', $input['id'])->update([
                'name' => $input['name'],
                'description' => $input['description'] ? $input['description'] : NULL,
            ]);
            
            smilify('success', 'Procéssus Modifier Avec Succès !');

            return response([$processus]);
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

        $get_processus = Pros::get();
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
            
            smilify('success', 'Procéssus Enrégistrer Avec Succès !');

            return response([$processus]);    
        }
    }

    public function destroy(Request $request)
    {
        DB::table('pros')->where('id', $request->id)->delete();

        smilify('success', 'Procéssus Supprimer Avec Succèss !');

        return response()->json([1]);
    }
}