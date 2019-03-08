<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use App\Rules\StrengthPassword;

class ProfileController extends Controller
{


    public function index()
    {
        $user = auth()->user()->load('socialAccount');

        return view('profile.index', compact('user'));
    }


    public function update(Request $request)
    {
        /*Solo se actualiza el password, en caso de que uno se loguea con alguna red social
            Y despues quiere entrar con el mismo correo colocandolo en el login y con la nueva constraseña
            que esta editando
        */
        $this->validate($request, [
            'password' => ['required', 'confirmed', new StrengthPassword],
        ]);

        $user = auth()->user();
        $user->password = bcrypt($request->password);

        $user->save();

        return back()->with('message', ['success', "Usuario actualizado correctamente"]);
    }
}
