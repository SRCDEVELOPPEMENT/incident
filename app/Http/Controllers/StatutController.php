<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Redirect,Response;
use App\Models\Statut;
use DB;
class StatutController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:lister-statut|creer-statut|editer-statut|supprimer-statut|voir-statut', ['only' => ['index','show']]);
        $this->middleware('permission:creer-statut', ['only' => ['create','store']]);
        $this->middleware('permission:editer-statut', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-statut', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuts = DB::table('statuts')->get();

        toastr()->info('Liste Des Statuts !');

        return view('statuts.index', ['statuts' => $statuts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        DB::table('statuts')->insert([
            'IntituleStatut' => strtoupper($request->IntituleStatut),
            'DescriptionStatut' => $request->DescriptionStatut ? $request->DescriptionStatut : NULL,
        ]);

        $statut = DB::table('statuts')->get()->last();

        return response()->json($statut);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        DB::table('statuts')->where('id', $request->id)->update([

            'IntituleStatut'=> strtoupper($request->IntituleStatut),
            'DescriptionStatut'=> $request->DescriptionStatut ? $request->DescriptionStatut : NULL,
        ]);
        
        toastr()->success('Statut Modifier Avec Succèss !');

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
        DB::table('statuts')->where('id', $request->id)->delete();

        toastr()->info('Statut Supprimer Avec Succèss !');

        return response()->json();
    }
}
