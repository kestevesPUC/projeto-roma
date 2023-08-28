<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request)
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
            'email' => $request->email ?? null,
//            'data_nascimento' => $request->data_nascimento,
//            'data_admissao' => $request->data_admissao,
            'cpf' => $request->cpf,
//            'descricao_id' => $request->descricao_id,
            'matricula' => $request->matricula,
//            'cargo_id' => $request->cargo_id,
//            'setor_id' => $request->setor_id,
//            'diretoria_id' => $request->diretoria_id,
            'password' => Hash::make($request->password),
//            'status' => true
        ]);

        event(new Registered($user));


        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    function createUser(Request $request)
    {
        $name = Arr::get($request->all(),'name');
        $cpf = Arr::get($request->all(),'cpf');
        $matricula = Arr::get($request->all(),'matricula');
        $password = Hash::make(Arr::get($request->all(),'senha'));


        if (!$this->checkUser($cpf,'cpf') && !$this->checkUser($matricula,'matricula')) {
            $id = Profile::query()
                ->insertGetId([
                    'name' => $name,
                    'cpf'  => $cpf,
                    'matricula' => $matricula,
                    'password' => $password
                ]);
            return Response::json([
                'success' => true,
                'message' => "Usuário criado com sucesso!",
                'id'      => $id
            ]);
        }

        return Response::json([
            'success' => false,
            'message' => "Erro: Este usuário já está cadastrado!\n Verifique o CPF ou a Matricula"
        ]);
    }

    private function checkUser($data,$column) {
        $user = Profile::where($column, $data)->get()->toArray();
        if(Arr::get(Arr::get($user, 0),'id'))
        {
            return true;
        }
        return false;
    }
}
