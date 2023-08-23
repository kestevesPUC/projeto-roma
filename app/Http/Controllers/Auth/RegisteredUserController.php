<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        if(\Illuminate\Support\Facades\Auth::user()->grupo_usuario != \App\Helpers\Constants::ADMINISTRADOR){
            return redirect('/');
        }


        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'data_nascimento' => $request->data_nascimento,
            'data_admissao' => $request->data_admissao,
            'cpf' => $request->cpf,
            'descricao_id' => $request->descricao_id,
            'matricula' => $request->matricula,
            'cargo_id' => $request->cargo_id,
            'setor_id' => $request->setor_id,
            'diretoria_id' => $request->diretoria_id,
            'password' => Hash::make($request->password),
            'status' => true
        ]);

        event(new Registered($user));


        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
