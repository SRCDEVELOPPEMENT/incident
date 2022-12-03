<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Battle;
use DB;
use Carbon\Carbon;

class BattleController extends Controller
{

    // function __construct()
    // {
    //     $this->middleware('permission:lister-battle|creer-battle|editer-battle|supprimer-battle|', ['only' => ['index','show']]);
    //     $this->middleware('permission:creer-battle', ['only' => ['store']]);
    //     $this->middleware('permission:editer-battle', ['only' => ['edit','update']]);
    //     $this->middleware('permission:supprimer-battle', ['only' => ['destroy']]);
    // }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $battles = DB::table('battles')
        ->where('incident_id', '=', $request->number)
        ->get();

        notify()->info('Liste Des Travaux Réalisés ! ⚡️');

        return view('battles.index', ['battles' => $battles, 'number' => $request->number]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newBattle = new Battle();

        if($request->input('title') && $request->input('description')){
            $newBattle->title = $request->input('title');
            $newBattle->description = $request->input('description');
            $newBattle->incident_id = intval($request->input('id_incidan'));
            $newBattle->created_at = Carbon::now()->format('Y-m-d');
            $newBattle->save();
        }
        if($request->input('title2') && $request->input('description2')){
            $newBattle->title = $request->input('title2');
            $newBattle->description = $request->input('description2');
            $newBattle->incident_id = intval($request->input('id_incidan'));
            $newBattle->save();
        }

        $last_battle = DB::table('battles')->get()->last();

        notify()->success('Travail Enrégistré Avec Succèss ! ⚡️');

        return response()->json([$last_battle]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        // $itineraire = Itineraire::find($request->id);

        // $itineraire->lieux_depart = $request->input('lieux_depart');
        // $itineraire->lieux_arrivee = $request->input('lieux_arrivee');
        // $itineraire->duree = $request->input('duree');

        // $itineraire->save();

        // toastr()->success('Itineraire Modifier Avec Succèss !');

        // return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // Itineraire::find($request->id)->delete();

        // toastr()->success('Itineraire Supprimer Avec Succèss !');

        // return response()->json();
    }
}
