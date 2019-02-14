<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider(string $driver){
        //Redirige a la pagina para loguearnos (facbook o github)
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback(string $driver){
        if(!request()->has('code') || request()->has('denied')){

            session()->flash('message',['danger',__('Inicio de sesiosn cancelado')]);
            
            return redirect('login');
        }

        //Obtenemos los datos en caso de un login exitoso
        $socialUser = Socialite::driver($driver)->user();
        dd($socialUser);
    }
}
