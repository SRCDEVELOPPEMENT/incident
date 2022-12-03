<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use DB;
use Carbon\Carbon;
use App\Models\User;
use Mail;
use Hash;
use Illuminate\Support\Str;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users'],
        ]);

        $token = Str::random(64);
        // dd($token);


        Mail::send('auth.verify-email', ['token' => $token], function($message) use ($request){
            $message->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
            $message->to($request->email);
            $message->subject('Reset Password Notification');
        });

        return back()->with('message', 'Nous avons envoyé votre lien de réinitialisation de mot de passe par e-mail !');

    }

    /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) {

        return view('auth.reset-password', ['token' => $token]);
     }



     /**
       * Write code on Method
       *
       * @return response()
      */
      public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
  
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
          return redirect('/login')->with('message', 'Votre Mot De Passe A éte Changer !');
      }
}

// $status = Password::sendResetLink(
//     $request->only('email')
// );

// return $status == Password::RESET_LINK_SENT
//             ? back()->with('status', __($status))
//             : back()->withInput($request->only('email'))
//                     ->withErrors(['email' => __($status)]);
