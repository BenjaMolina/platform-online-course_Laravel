<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Student;
use App\UserSocialAccount;
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

        $user = null;
        $succes = true;
        $email = $socialUser->email;

        $check = User::whereEmail($email)->first();

        if($check){
            $user = $check;
        }
        else{
            \DB::beginTransaction();
            try{
                $user = User::create([
                    "name" => $socialUser->name,
                    "email" => $email,
                ]);

                UserSocialAccount::create([
                    "user_id" => $user->id,
                    "provider" => $driver,
                    "provider_uid" => $socialUser->id,
                ]);

                Student::create([
                    "user_id" => $user->id,
                ]);

            }catch(\Exception $exception){
                $succes = $exception->getMessage();
                \DB::rollBack();
            }
        }

        if($succes === true){
            \DB::commit();
            auth()->loginUsingId($user->id); //Hace un login automatico con el id

            return redirect(route('home'));
        }

        session()->flash('message',['danger', $succes]);

        return redirect('login');
    }
}
