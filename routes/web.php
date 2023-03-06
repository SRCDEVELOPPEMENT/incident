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
use App\Http\Controllers\SiteController;
use App\Http\Controllers\BattleController;
use App\Http\Controllers\Users_IncidentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Http\Controllers\Auth\ForgotPasswordController;
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
    return view('auth.login');
});

Route::get('/dashboard', function () {

    $incident_direction_generale = array();
    $incident_annee_encour = array();
    $incident_critiques = array();
    $incident_instances = array();
    $probleme_open_date = array();
    $probleme_cloture_date = array();
    $incidentSites = array();
    $years = array();

    $nombre_incident_plage = 0;
    $nombre_incident_cloturer_plage = 0;
    $incidentsDepartement = array();


    $today = Carbon::now()->format('Y-m-d');
    $tomorrow = Carbon::yesterday()->format('Y-m-d');

    $annee = Carbon::now()->format('Y');

    for ($i=1; $i < 5; $i++) {
        array_push($years, intval($annee) - $i+1);
    }

    if(Session::has('incidents')){
    if(is_iterable(Session::get('incidents'))){
    for ($d=0; $d < count(Session::get('incidents')); $d++) {
        $incident_courant = Session::get('incidents')[$d];

        $ann = substr($incident_courant->created_at, 0, 4);

        if($annee == $ann){
            if(
                ($incident_courant->observation_rex != NULL) && 
                ($incident_courant->deja_pris_en_compte == NULL)
            ){
                array_push($incident_annee_encour, $incident_courant);
            }
        }
    }}}
    

    for ($p=0; $p < count($incident_annee_encour); $p++) {

        $probleme = $incident_annee_encour[$p];

        if($probleme->site_id == NULL){
            if($probleme->categories){
            if($probleme->categories->departement_id != NULL){
                array_push($incident_direction_generale, $probleme);
            }}
        }
    }

    if(Session::has('departements')){
    if(is_iterable(Session::get('departements'))){
    for ($s=0; $s < count(Session::get('departements')); $s++) {

            $dept_courant = Session::get('departements')[$s];

            $nbr_incident_dept = array();
            $nbr_incident_date = array();
            $nombre_incident_dept = 0;
            $enretard = 0;
            $nbr_annul = 0;
            $nbr_encour = 0;
            $nombre = 0;

            for ($j=0; $j < count($incident_direction_generale); $j++) {
                $incide = $incident_direction_generale[$j];
                if($incide->categories->departement_id){
                    if(intval($incide->categories->departement_id) == intval($dept_courant->id)){
                        $nombre_incident_dept +=1;
                        array_push($nbr_incident_dept, $incide);
                    }
                }
            }

            array_push($incidentsDepartement, $nbr_incident_dept);
            array_push($incident_instances, $nombre_incident_dept);
    }}}

    
    if(Session::has('sites')){
    if(is_iterable(Session::get('sites'))){
    for ($z=0; $z < count(Session::get('sites')); $z++) { 
        $siteCourant = Session::get('sites')[$z];

        $incidentDunSite = array();

        for ($b=0; $b < count($incident_annee_encour); $b++) { 
            $incident = $incident_annee_encour[$b];

            if($incident->site_id){
                if($incident->site_id == $siteCourant->id){
                    array_push($incidentDunSite, $incident);
                }
            }
        }

        array_push($incidentSites, $incidentDunSite);
    }}}

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

    connectify('success', 'Connexion Etablit Avec Succèss', 'BIENVENUE '.Auth::user()->fullname.' !');

    return view('dashboard',
    [

        'years' => $years,
        'regions' => $regions,
        'users' => Session::get('users'),
        'incidentSites' => $incidentSites,
        'sites' => Session::get('sites'),
        'tasks' => Session::get('tasks'),
        'incidents' => Session::get('incidents'),
        'processus' => Session::get('processus'),
        'categories' => Session::get('categories'),
        'departements' => Session::get('departements'),
        'users_incidents' => Session::get('users_incidents'),
        'incident_critiques' => $incident_critiques,
        'incident_instances' => $incident_instances,
        'incidentsDepartement' => $incidentsDepartement,
        'nombre_incident_plage' => $nombre_incident_plage,
        'incident_direction_generale' => $incident_direction_generale,
        'incident_annee_encour' => $incident_annee_encour,

    ]);

    })->middleware(['auth'])->name('dashboard');


    Route::group(['middleware' => ['auth']], function() {
    Route::resource('categories', CategorieController::class);
    Route::resource('processus', ProcessusController::class);
    Route::resource('incidents', IncidentController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('personnes', PersonneController::class);
    Route::resource('battles', BattleController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('sites', SiteController::class);


    Route::post('createPermission', [PermissionController::class, 'store'])->name('createPermission');

    Route::post('editPermission', [PermissionController::class, 'update'])->name('editPermission');

    Route::get('deletePermission', [PermissionController::class, 'destroy'])->name('deletePermission');


    
    Route::post('createUser', [UserController::class, 'store'])->name('createUser');

    Route::get('getusers', [UserController::class, 'getUsers'])->name('getusers');

    Route::get('deleteUser', [UserController::class, 'destroy'])->name('deleteUser');

    Route::put('editUser', [UserController::class, 'edit'])->name('editUser');

    Route::put('reset_pass', [UserController::class, 'resetpass'])->name('reset_pass');

    Route::put('updateRole', [UserController::class, 'changeRole'])->name('updateRole');

    
    Route::post('createSite', [SiteController::class, 'store'])->name('createSite');

    Route::put('editSite', [SiteController::class, 'update'])->name('editSite');
    
    Route::post('TypeSite', [SiteController::class, 'type'])->name('TypeSite');

    Route::delete('deleteSite', [SiteController::class, 'destroy'])->name('deleteSite');

    Route::get('types', [SiteController::class, 'type_index'])->name('types');

    Route::delete('deleteType', [SiteController::class, 'deleteTypeSite'])->name('deleteType');

    
    Route::get('editPermissionRole', [RoleController::class, 'edit'])->name('editPermissionRole');

    Route::put('setPermissionRole', [RoleController::class, 'update'])->name('setPermissionRole');

    Route::post('createRole', [RoleController::class, 'store'])->name('createRole');

    Route::get('deleteRole', [RoleController::class, 'destroy'])->name('deleteRole');

    Route::put('editRole', [RoleController::class, 'modify'])->name('editRole');



    Route::get('listedBattle', [BattleController::class, 'index'])->name('listedBattle');

    Route::post('createBattle', [BattleController::class, 'store'])->name('createBattle');

    Route::post('editBattle', [BattleController::class, 'update'])->name('editBattle');

    Route::get('deleteBattle', [BattleController::class, 'destroy'])->name('deleteBattle');

    
    Route::put('updateDegreeTask', [TaskController::class, 'updateDegree'])->name('updateDegreeTask');

    Route::put('updateStatusTask', [TaskController::class, 'updateStatus'])->name('updateStatusTask');

    Route::get('listedTask', [TaskController::class, 'index'])->name('listedTask');

    Route::get('tasks', [TaskController::class, 'listeTaches'])->name('tasks');

    Route::delete('deleteTask', [TaskController::class, 'destroy'])->name('deleteTask');

    Route::post('createTask', [TaskController::class, 'store'])->name('createTask');

    Route::put('editTask', [TaskController::class, 'update'])->name('editTask');

    Route::delete('delete_file', [TaskController::class, 'suppressionFile'])->name('delete_file');



    Route::put('set_echeance_date_task', [TaskController::class, 'setEcheanceDate'])->name('set_echeance_date_task');

    

    Route::get('departements', [DepartementController::class, 'index'])->name('departements');

    Route::post('createDepartement', [DepartementController::class, 'store'])->name('createDepartement');

    Route::delete('deleteDepartement', [DepartementController::class, 'destroy'])->name('deleteDepartement');

    Route::put('editDepartement', [DepartementController::class, 'update'])->name('editDepartement');


    Route::post('createProcessus', [ProcessusController::class, 'store'])->name('createProcessus');

    Route::delete('deleteProcessus', [ProcessusController::class, 'destroy'])->name('deleteProcessus');

    Route::put('editProcessus', [ProcessusController::class, 'update'])->name('editProcessus');



    Route::post('createCategorie', [CategorieController::class, 'store'])->name('createCategorie');

    Route::delete('deleteCategorie', [CategorieController::class, 'destroy'])->name('deleteCategorie');

    Route::put('editCategorie', [CategorieController::class, 'update'])->name('editCategorie');



    Route::get('tableau_statistique', [IncidentController::class, 'tableau'])->name('tableau_statistique');

    Route::post('createIncident', [IncidentController::class, 'store'])->name('createIncident');
    
    Route::put('editIncident', [IncidentController::class, 'update'])->name('editIncident');

    Route::delete('deleteIncident', [IncidentController::class, 'destroy'])->name('deleteIncident');

    Route::put('clotureIncident', [IncidentController::class, 'cloture'])->name('clotureIncident');

    Route::get('printIncident', [IncidentController::class, 'print'])->name('printIncident');

    Route::put('updateStatusIncident', [IncidentController::class, 'updateStatut'])->name('updateStatusIncident');
    
    Route::put('updatePrioriteIncident', [IncidentController::class, 'updatePriorite'])->name('updatePrioriteIncident');

    Route::put('setMotifAnnulation', [IncidentController::class, 'setMotifAnnul'])->name('setMotifAnnulation');

    Route::put('set_echeance_date', [IncidentController::class, 'setDueDate'])->name('set_echeance_date');

    Route::get('archivage', [IncidentController::class, 'archive'])->name('archivage');

    Route::put('archiving', [IncidentController::class, 'setArchive'])->name('archiving');

    Route::put('desarchiving', [IncidentController::class, 'setDesarchive'])->name('desarchiving');

    Route::put('restoration', [IncidentController::class, 'setRestoration'])->name('restoration');

    Route::put('assign_incident', [IncidentController::class, 'setCategorieIncident'])->name('assign_incident');

    Route::put('incident_deja_pris_encompte', [IncidentController::class, 'incident_encompte'])->name('incident_deja_pris_encompte');


    Route::get('viewUser', [Users_IncidentController::class, 'index'])->name('viewUser');

    Route::put('editAndAssignIncident', [Users_IncidentController::class, 'update_edit'])->name('editAndAssignIncident');

    Route::post('user_assignation', [Users_IncidentController::class, 'defineUserOfIncident'])->name('user_assignation');

    Route::delete('revoke_entiter', [Users_IncidentController::class, 'revocation'])->name('revoke_entiter');

    Route::put('revoke_modif', [Users_IncidentController::class, 'revocation_modification'])->name('revoke_modif');

});

require __DIR__.'/auth.php';