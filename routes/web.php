<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProcessusController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\PersonneController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\BattleController;
use App\Http\Controllers\Users_IncidentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Incident;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('splash');
});

Route::get('/dashboard', function () {

    $incident_annee_encour = array();
    $incident_critiques = array();
    $incident_instances = array();

    $processus = DB::table('pros')->get();

    $departements = DB::table('departements')->get();

    $categories = DB::table('categories')->get();

    $incidents = Incident::with('categories', 'processus')->get();

    $today = Carbon::now()->format('Y-m-d');
    $tomorrow = Carbon::yesterday()->format('Y-m-d');

    $nombre_incident_save_today = 0;
    $nombre_incident_cloturer_today = 0;
    $clotures = array();
    $annuler = array();
    $years = array();

    $annee = Carbon::now()->format('Y');

    for ($i=1; $i < 9; $i++) {
        array_push($years, intval($annee) - $i+1);
    }

    for ($i=0; $i < count($incidents); $i++) {
        $incident_courant = $incidents[$i];
        
        $ann = substr($incident_courant->created_at, 0, 4);

        if($annee == $ann){
            array_push($incident_annee_encour, $incident_courant);
        }
    }

    for ($i=0; $i < count($incident_annee_encour); $i++) {

        $inci = $incident_annee_encour[$i];

        $time = Carbon::parse($inci->created_at)->format('Y-m-d');

        if($time == $today){
            $nombre_incident_save_today +=1;
        }

        if($inci->closure_date != NULL){
            
            $dd = Carbon::now()->format('Y-m-d');
            $elt = str_replace("-", "", $inci->closure_date);
            $toda = str_replace("-", "", $dd);

            if(intval($elt) == intval($toda)){
                $nombre_incident_cloturer_today +=1;
            }
        }

        if($inci->status == "ENCOUR"){
            if($inci->due_date < $today){
              array_push($incident_critiques, $inci);
            }
        }

        for ($i=0; $i < count($departements); $i++) {
            $dept_courant = $departements[$i];

            $nombre_incident_dept = 0;
            $nbr_incident_dept = array();
            $nombre = 0;
            $nbr_annul = 0;
            for ($j=0; $j < count($incident_annee_encour); $j++) {
                $incide = $incident_annee_encour[$j];
                if($incide->categories->departements->id == $dept_courant->id){
                    $nombre_incident_dept +=1;
                    array_push($nbr_incident_dept, $incide);
                }
            }

            for ($a=0; $a < count($nbr_incident_dept); $a++) {
                $inc = $nbr_incident_dept[$a];
                if($inc->status == "CLÔTURÉ"){
                    $nombre +=1;
                }else if($inc->status == "ANNULÉ"){
                    $nbr_annul +=1;
                }
            }
            array_push($clotures, $nombre);
            array_push($annuler, $nbr_annul);        
            array_push($incident_instances, $nombre_incident_dept);
        }
    }

    connectify('success', 'Connexion Etablit Avec Succèss', 'BIENVENUE '.Auth::user()->fullname.' !');

    return view('dashboard',
    [
        'incidents' => $incidents,
        'processus' => $processus,
        'departements' => $departements,
        'categories' => $categories,
        'years' => $years,
        'clotures' => $clotures,
        'annuler' => $annuler,
        'incident_annee_encour' => $incident_annee_encour,
        'nombre_incident_save_today' => $nombre_incident_save_today,
        'nombre_incident_cloturer_today' => $nombre_incident_cloturer_today,
        'incident_critiques' => $incident_critiques,
        'incident_instances' => $incident_instances,
    ]);
})->middleware(['auth'])->name('dashboard');


    Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('departements', DepartementController::class);
    Route::resource('categories', CategorieController::class);
    Route::resource('processus', ProcessusController::class);
    Route::resource('incidents', IncidentController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('personnes', PersonneController::class);
    Route::resource('battles', BattleController::class);


    Route::post('createPermission', [PermissionController::class, 'store'])->name('createPermission');

    Route::post('editPermission', [PermissionController::class, 'update'])->name('editPermission');

    Route::get('deletePermission', [PermissionController::class, 'destroy'])->name('deletePermission');


    
    Route::post('createUser', [UserController::class, 'store'])->name('createUser');
    Route::get('getusers', [UserController::class, 'getUsers'])->name('getusers');
    Route::get('deleteUser', [UserController::class, 'destroy'])->name('deleteUser');
    Route::put('editUser', [UserController::class, 'edit'])->name('editUser');



    Route::post('createRole', [RoleController::class, 'store'])->name('createRole');

    Route::get('deleteRole', [RoleController::class, 'destroy'])->name('deleteRole');



    Route::get('listedBattle', [BattleController::class, 'index'])->name('listedBattle');

    Route::post('createBattle', [BattleController::class, 'store'])->name('createBattle');

    Route::post('editBattle', [BattleController::class, 'update'])->name('editBattle');

    Route::get('deleteBattle', [BattleController::class, 'destroy'])->name('deleteBattle');

    
    Route::put('updateDegreeTask', [TaskController::class, 'updateDegree'])->name('updateDegreeTask');

    Route::put('updateStatusTask', [TaskController::class, 'updateStatus'])->name('updateStatusTask');

    Route::get('listedTask', [TaskController::class, 'index'])->name('listedTask');

    Route::delete('deleteTask', [TaskController::class, 'destroy'])->name('deleteTask');

    Route::post('createTask', [TaskController::class, 'store'])->name('createTask');

    Route::put('editTask', [TaskController::class, 'update'])->name('editTask');

    Route::post('demandeService', [TaskController::class, 'askService'])->name('demandeService');

    

    Route::post('createDepartement', [DepartementController::class, 'store'])->name('createDepartement');

    Route::delete('deleteDepartement', [DepartementController::class, 'destroy'])->name('deleteDepartement');

    Route::put('editDepartement', [DepartementController::class, 'update'])->name('editDepartement');


    Route::post('createProcessus', [ProcessusController::class, 'store'])->name('createProcessus');

    Route::delete('deleteProcessus', [ProcessusController::class, 'destroy'])->name('deleteProcessus');

    Route::put('editProcessus', [ProcessusController::class, 'update'])->name('editProcessus');



    Route::post('createCategorie', [CategorieController::class, 'store'])->name('createCategorie');

    Route::delete('deleteCategorie', [CategorieController::class, 'destroy'])->name('deleteCategorie');

    Route::put('editCategorie', [CategorieController::class, 'update'])->name('editCategorie');

    
    Route::post('createIncident', [IncidentController::class, 'store'])->name('createIncident');
    
    Route::put('editIncident', [IncidentController::class, 'update'])->name('editIncident');

    Route::delete('deleteIncident', [IncidentController::class, 'destroy'])->name('deleteIncident');

    Route::put('clotureIncident', [IncidentController::class, 'cloture'])->name('clotureIncident');

    Route::get('printIncident', [IncidentController::class, 'print'])->name('printIncident');

    Route::put('updateStatusIncident', [IncidentController::class, 'updateStatut'])->name('updateStatusIncident');
    
    Route::put('updatePrioriteIncident', [IncidentController::class, 'updatePriorite'])->name('updatePrioriteIncident');

    Route::put('setMotifAnnulation', [IncidentController::class, 'setMotifAnnul'])->name('setMotifAnnulation');

    Route::put('set_echeance_date', [IncidentController::class, 'setDueDate'])->name('set_echeance_date');


    Route::post('assign_user', [Users_IncidentController::class, 'assignation'])->name('assign_user');

    Route::get('viewUser', [Users_IncidentController::class, 'index'])->name('viewUser');
});

require __DIR__.'/auth.php';