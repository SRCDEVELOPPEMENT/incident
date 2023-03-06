<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Logtache;
use App\Models\Incident;
use App\Models\Tache;
use App\Models\User;
use App\Models\Site;
use App\Models\Type;
use App\Models\Categorie;
use App\Models\Departement;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        toastr()->warning('Page De Connexion, Veuillez Vous Identifiez !');

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $input = $request->all();

        if(! Auth::attempt(['login' => $input['login'], 'password' => $input['password']])){
            
            toastr()->error('Nom D\'utilisateur Ou Mot De Passe Incorrect !');
            
            return back()
            ->withErrors([
            ]);

        }else{

        $user = Auth::user();

        Auth::login($user, $request->boolean('remember'));
        //$request->authenticate();
    
        $request->session()->regenerate();
        $incidents = array();
        $roles = DB::table('roles')->get();
        $files = DB::table('fichiers')->get();
        $logs = Logtache::with('users', 'tasks')->get();
        $users = User::with('sites', 'departements')->get();
        $sites = Site::with('types')->get();
        $types = DB::table('types')->get();
        $tasks = array();
        $processus = DB::table('pros')->get();
        $categories = Categorie::with('departements')->get();
        $departements = Departement::get();
        $all_users_incidents = DB::table('users_incidents')->get();
        $users_incidents = DB::table('users_incidents')->where('user_id', '=', $user->id)->get();

        if(
            ($user->roles[0]->name == "EMPLOYE") ||
            ($user->roles[0]->name == "COORDONATEUR")
        ){
            
        $all_incidents = array();

        if(is_iterable($users_incidents)){
        for ($m=0; $m < count($users_incidents); $m++) {
            $ui = $users_incidents[$m];

            $problem = Incident::with('categories.departements', 'processus', 'sites')
            ->where('number', '=', $ui->incident_number)->get()->first();

            $ttaches = Tache::with('departements', 'sites.types')
            ->where('incident_number', '=', $problem->number)
            ->get();

            for ($xe=0; $xe < count($ttaches); $xe++) { 
                $tachi = $ttaches[$xe];
                array_push($tasks, $tachi);
            }

            array_push($incidents, $problem);

        }}}
        elseif (
            ($user->roles[0]->name == "ADMINISTRATEUR") ||
            ($user->roles[0]->name == "CONTROLLEUR")
        )
        {
            $all_incidents = Incident::with('categories.departements', 'processus', 'sites')
            ->get();
        }else {
            $all_incidents = array();
        }

        //IMPORTANT
        Session ([
            'incidents' => count($incidents) > 0 ? $incidents : (count($all_incidents) > 0 ? $all_incidents : []),
            'logs' => $logs,
            'files' => $files,
            'roles' => $roles,
            'users' => $users,
            'sites' => $sites,
            'types' => $types,
            'tasks' => $tasks,
            'processus' => $processus,
            'categories' => $categories,
            'departements' => $departements,
            'users_incidents' => $all_users_incidents,
            'users_incidents_logIn' => $users_incidents,
        ]);

        Session::save();

        return redirect()->intended(RouteServiceProvider::HOME);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }
}
