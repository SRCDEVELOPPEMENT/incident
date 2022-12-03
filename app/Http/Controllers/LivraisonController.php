<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Livraison;
use App\Models\Recipe;
use App\Models\User;
use App\Models\Vehicule;
use App\Models\Consommation;
use DB;

class LivraisonController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:lister-livraison|creer-livraison|editer-livraison|supprimer-livraison|voir-livraison', ['only' => ['index','show']]);
        $this->middleware('permission:creer-livraison', ['only' => ['create','store']]);
        $this->middleware('permission:editer-livraison', ['only' => ['edit','update']]);
        $this->middleware('permission:supprimer-livraison', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        toastr()->info('Liste Des Livraisons !');

        $livraisons = Livraison::where('user_id', '=', Auth::user()->id)->get();

        $recipes = Recipe::all();

        $cars = Vehicule::all();

        $consommations = Consommation::all();
        
        return view('livraisons.index', compact('livraisons', 'recipes', 'cars', 'consommations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
            $amount = 0;

            $recipe_selectionner = DB::table('recipes')
            ->where('id', '=', intval($request->input('recipe_id')))
            ->get()->first();

            if((intval($request->input('tonnage')))){
                if(!intval($request->input('distance'))){
                    $amount = intval($request->input('tonnage')) * $recipe_selectionner->value;
                }
            }else{
                if(intval($request->input('distance'))){
                    if(!intval($request->input('tonnage'))){
                        if($request->input('recipe_id')){
                            $amount = (intval($request->input('distance')) * $recipe_selectionner->value)/10;
                        }
                    }
                }
            }

            Livraison::create([
                'observation' => $request->input('observation') ? $request->input('observation') : '',
                'amount_paye' => $amount,
                'phone_client' => intval($request->input('phone_client')),
                'nom_client' => $request->input('nom_client'),
                'itinerary' => $request->input('itinerary'),
                'delivery_amount' => $amount,
                'order_number' => $request->input('order_number'),
                // 'destination' => $request->input('destination') ? $request->input('destination') : NULL,
                'tonnage' => $request->input('tonnage') ? intval($request->input('tonnage')) : NULL,
                'distance' => $request->input('distance') ? intval($request->input('distance')) : NULL,
                'recipe_id' => $request->input('recipe_id') ? intval($request->input('recipe_id')) : NULL,
                'vehicule_id' => $request->input('vehicule_id') ? intval($request->input('vehicule_id')) : NULL,
                'user_id' => intval(Auth::user()->id),
                'state' => "ENCOUR",
                'delivery_date' => $request->input('delivery_date'),
            ]);

            $livraison = Livraison::get()->last();

            $livraisons = Livraison::all();

            toastr()->success('Livraison Enrégistrer Avec Succèss !');

            return response([$livraison, $livraisons]);
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
    public function edit(Request $request)
    {
        // $recipe_selectionner = DB::table('recipes')
        // ->where('id', '=', intval($request->input('recipe_id')))
        // ->get()->first();

        // if((intval($request->input('tonnage')))){
        //     if(!intval($request->input('distance'))){
        //         $amount = intval($request->input('tonnage')) * $recipe_selectionner->value;
        //     }
        // }else{
        //     if(intval($request->input('distance'))){
        //         if(!intval($request->input('tonnage'))){
        //                 if($request->input('consommation_id')){
        //                     $consommation = DB::table('consommations')->where('id', '=', intval($request->input('consommation_id')))->get()->first();
        //                     $amount = (intval($request->input('distance')) * $consommation->montant)/$consommation->kilometrage;
        //                 }
        //         }
        //     }
        // }

        DB::table('livraisons')->where('id', '=', intval($request->id))->update([
            'observation' => $request->input('observation') ? $request->input('observation') : '',
            'phone_client' => intval($request->input('phone_client')),
            'nom_client' => $request->input('nom_client'),
            'itinerary' => $request->input('itinerary'),
            'order_number' => $request->input('order_number'),
            // 'distance' => $request->input('distance') ? intval($request->input('distance')) : NULL,
            // 'delivery_amount' => $amount,
            'delivery_date' => $request->input('delivery_date'),
            'really_delivery_date' => $request->input('really_delivery_date'),
            // 'tonnage' => $request->input('tonnage') ? intval($request->input('tonnage')) : NULL,
            'state' => $request->input('state'),
            'vehicule_id' => intval($request->input('vehicule_id')),
            // 'destination' => $request->input('destination'),
        ]);
        
        toastr()->success('Livraison Modifier Avec Succèss !');
        return response()->json([1]);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::table('livraisons')->where('id', $request->id)->delete();

        toastr()->info('Livraison Supprimer Avec Succèss !');

        return response()->json([1]);
    }
}