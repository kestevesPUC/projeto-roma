<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Descricao\Descricao;
use App\Models\Profile;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private $request;
    private $id;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        if (!Auth::user()->status) {
            Auth::guard('web')->logout();
            throw \Illuminate\Validation\ValidationException::withMessages([
                'message' => __('Este usuário está desativado!'),
            ]);
            return redirect('/');
        }
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $this->updateData($this->request->all());

        if(Auth::user()->id != Arr::get($this->request->all(),'id')) {
            // Usuario ADM modificando outro usuário
            $this->insertDataProfile($data);
            return throw ValidationException::withMessages(['file_name' => 'Dados alterados com sucesso!']);
        }
        // Usuário alterando seu próprio usuário
        foreach ($data as $i => $df) {
            $request->user()->$i = $df;
        }

        $request->user()->fill($request->validated());


        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Atribui o valor para à variável de cada coluna antes de salvar no DB
     * @param $user
     * @return array|void
     */
    private function updateData($user)
    {
        try {
            $data = array();

            if (Arr::get($user,'id')) {
                $data['id'] = Arr::get($user,'id');
            }
            if (Arr::get($user,'name')) {
                $data['name'] = Arr::get($user,'name');
            }
            if (Arr::get($user,'email')) {
                $data['email'] = Arr::get($user,'email');
            }
            if (Arr::get($user,'cpf')) {
                $data['cpf'] = Arr::get($user,'cpf');
            }
            if (Arr::get($user,'matricula')) {
                $data['matricula'] = Arr::get($user,'matricula');
            }
            if (Arr::get($user,'data_nascimento')) {
                $data['data_nascimento'] = Arr::get($user,'data_nascimento');
            }
            if (Arr::get($user,'data_demissao')) {
                $data['data_demissao'] = Arr::get($user,'data_demissao');
            }
            if (Arr::get($user,'empresa_id')) {
                $data['empresa_id'] = Arr::get($user,'empresa_id');
            }
            if (Arr::get($user,'tipo_acesso_id')) {
                $data['tipo_acesso_id'] = Arr::get($user,'tipo_acesso_id');
            }
            if (Arr::get($user,'data_admissao')) {
                $data['data_admissao'] = Arr::get($user,'data_admissao');
            }
            if (Arr::get($user,'cargo_id')) {
                $data['cargo_id'] = Arr::get($user,'cargo_id');
            }
            if (Arr::get($user,'setor_id')) {
                $data['setor_id'] = Arr::get($user,'setor_id');
            }
            if (Arr::get($user,'diretoria_id')) {
                $data['diretoria_id'] = Arr::get($user,'diretoria_id');
            }

            return $data;

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update type user
     */
    public function updateTipo() {
        $user = $this->request->all();
        if(Auth::user()->id != Arr::get($this->request->all(),'id')) {
            Profile::where('id', Arr::get($user,'id'))
                ->update([
                    'grupo_usuario' => Arr::get($user,'grupo_usuario')
                ]);
            return throw ValidationException::withMessages(['message' => 'Dados alterados com sucesso!']);
        }
        $this->request->user()->grupo_usuario = Arr::get($this->request->toArray(),'grupo_usuario');

        $this->request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function editarUsuarios($id) {
        if(Auth::user()->grupo_usuario != \App\Helpers\Constants::ADMINISTRADOR){
            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        }

        $user = Arr::get(User::query()->select()->where('id',$id)->get(),0);

        if($user == null) {
            return redirect('/profile');
        }
        return view('profile.edit')->with(['user' => $user]);

    }

    /**
     * Atualiza no DB os dados alterados pelo usuário ADM
     * @param $data
     * @return void
     */
    function insertDataProfile($data)
    {
        Profile::where('id', Arr::get($data,'id'))
            ->update($data);
    }


    /**
     * Busca a imagem do pefil
     * no S3
     * @return string|null
     */
    public function getPicture($id)
    {
        $data = base64_decode($this->getImageProfile(['id_person' => $id]));
        return response($data)->header('Content-Type', 'image/jpg');
    }

    /**
     * Busca a imagem do pefil
     * no S3
     * @return string|null
     */
    public function getImageProfile($id)
    {
        if(Storage::disk('DIR_ORD')->exists('img/avatar/profile_'. Arr::get($id, 'id_person') .'.png')){
            return base64_encode(Storage::disk('DIR_ORD')->get('img/avatar/profile_'. Arr::get($id, 'id_person') .'.png'));
        } else {
            return base64_encode(Storage::disk('DIR_ORD')->get('img/avatar/profile_default.png'));
        }
    }

    /**
     * Busca a imagem do pefil
     * no S3
     * @return string|null
     */
    public function getLogo()
    {
        return  response(base64_decode(base64_encode(Storage::disk('DIR_ORD')->get('img/logos/logo-laranja.png'))))->header('Content-Type', 'image/jpg');
    }

    public function updateImageProfile()
    {
        $data = $this->request->all();
        $file = $_FILES['imagem']['tmp_name'];
        $fileName = 'img/avatar/profile_'.Arr::get($data, 'id').'.png';

        Storage::disk('DIR_ORD')->put($fileName, file_get_contents($file));

        return ['message' => 'Foto alterada com sucesso!'];
    }

    public function updateDescricao()
    {
        $descricao = Arr::get($this->request->all(), 'value');
        $id = Arr::get($this->request->all(), 'id');
        $user = Arr::get($this->request->all(), 'user');
        $descricaoDB = Descricao::where('id', $id);

        if($id != null) {
            $descricaoDB->update(['descricao' => $descricao]);
        } else {
            $descricao_id = $descricaoDB->insertGetId(['descricao' => $descricao]);

            Profile::where('id', $user)
                ->update(['descricao_id' => $descricao_id]);
        }

    }

    public function updateStatus()
    {
        $status = $this->request->status;
        $user = $this->request->user;

        Profile::where('id', $user)
            ->update(['status' => $status]);
    }
}
