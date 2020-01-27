<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;    // se agrega para poder usar datos Request

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /*check if authenticated, then redirect to */

    protected function authenticated(Request $request, $user)
    {
        // Si hay redireccion de otra pagina que no sea 'login', redirige segun la cookie
        if (\Cookie::has('ref')) {
            return redirect(\Cookie::get("ref"));
        }

        // Si el usuario hace login en la pagina de 'login, redirige al home
        if($user){
            return redirect('/');
            //return redirect(url()->previous());
        }
    }


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

}
