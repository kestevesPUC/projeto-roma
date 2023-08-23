<section>
    @include('profile.partials.header',['title' => "Informações do Usuário"])

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>


    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="row">
            <div class="col-6">
                <div class="me-7 mb-4 mx-5">
                    {{--        Imagem do Usuário         --}}
                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative" style="width: 100%; position: relative;">
                        <a type="button" href="#" id="get_file" class="d-flex align-items-end" style="right: 10px;">
                            <input name="image" type="file" id="image" style="display: none" accept=".png, .jpg, .jpeg">
                            <input type="file" id="image" style="display: none">
                            <img id="image_preview" src="{{ route('profile.get.picture', ['idUser' => $user->id]) }}" alt="image" style="display: block;">
                            <i class="fa fa-pencil" style="padding: 10px; align-items: end; position: absolute; bottom:0; left:0;" aria-hidden="true"></i>
                        </a>
                        <div class="position-absolute translate-middle bottom-0 @if ($user->id) bg-success @else bg-danger @endif start-100 mb-6 rounded-circle border border-4 border-body h-20px w-20px"></div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="col-2">
                        <div>
                            <x-input-label for="name" :value="__('Codigo')" />
                            <label class="ml-10" for="">{{ old('id', $user->id) }}</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mt-3">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div>
                <x-text-input id="id" name="id" type="hidden" :value="old('id', $user->id)" />
            </div>
        </div>
        <div>
            <x-input-label for="cpf" :value="__('CPF')" />
            <x-text-input id="cpf" name="cpf" type="text" class="mt-1 block w-full cpfcnpj" :value="old('cpf', $user->cpf)" required autofocus autocomplete="cpf" />
            <x-input-error class="mt-2" :messages="$errors->get('cpf')" />
        </div>

        <div>
            <x-input-label for="data_nascimento" :value="__('Data de Nascimento')" />
            <x-text-input id="data_nascimento" name="data_nascimento" type="date" class="mt-1 block w-full" :value="old('data_nascimento',\Illuminate\Support\Arr::get(explode(' ',$user->data_nascimento),0))" autofocus autocomplete="data_nascimento" />
            <x-input-error class="mt-2" :messages="$errors->get('data_nascimento')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        @if(Auth::user()->grupo_usuario == \App\Helpers\Constants::ADMINISTRADOR)
            <div>
                <x-input-label for="matricula" :value="__('Matricula')" />
                <x-text-input id="matricula" name="matricula" type="text" class="mt-1 block w-full" :value="old('matricula', $user->matricula)" required autofocus autocomplete="matricula" />
                <x-input-error class="mt-2" :messages="$errors->get('matricula')" />
            </div>
        @endif

{{--        <div>--}}
{{--            <x-input-label for="data_admissao" :value="__('Admissão')" />--}}
{{--            <x-text-input id="data_admissao" name="data_admissao" type="date" class="mt-1 block w-full" :value="old('data_admissao',\Illuminate\Support\Arr::get(explode(' ',$user->data_admissao),0))" autofocus autocomplete="data_admissao" />--}}
{{--            <x-input-error class="mt-2" :messages="$errors->get('data_admissao')" />--}}
{{--        </div>--}}

{{--        <div>--}}
{{--            <x-input-label for="data_demissao" :value="__('Demissão')" />--}}
{{--            <x-text-input id="data_demissao" name="data_demissao" type="date" class="mt-1 block w-full" :value="old('data_demissao',\Illuminate\Support\Arr::get(explode(' ',$user->data_demissao),0))" autofocus autocomplete="data_demissao" />--}}
{{--            <x-input-error class="mt-2" :messages="$errors->get('data_demissao')" />--}}
{{--        </div>--}}

{{--        <div>--}}
{{--            <x-input-label for="empresa_id" :value="__('Empresa')" />--}}
{{--            <select   name="empresa_id" id="empresa_id" class="form-select" value="{{old('empresa_id', $user->empresa_id)}}" aria-label="Default select">--}}

{{--                @foreach(\App\Http\Controllers\Empresa\EmpresaController::getEmpresas() as $empresa)--}}
{{--                    <option  value="{{ \Illuminate\Support\Arr::get($empresa, 'id') }}" @php echo ($user->empresa_id == \Illuminate\Support\Arr::get($empresa, 'id')) ? 'selected' : '' @endphp >{{\Illuminate\Support\Arr::get($empresa, 'descricao')}}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}

{{--        <div>--}}
{{--            <x-input-label for="tipo_acesso_id" :value="__('Tipo de Acesso')" />--}}
{{--            <select name="tipo_acesso_id" id="tipo_acesso_id" class="form-select" value="{{ old('tipo_acesso_id', $user->tipo_acesso_id) }}" aria-label="Default select">--}}

{{--                @foreach(\App\Http\Controllers\TipoAcesso\TipoAcessoController::getTipoAcessos() as $acesso)--}}
{{--                    <option value="{{ \Illuminate\Support\Arr::get($acesso, 'id') }}" @php echo ($user->tipo_acesso_id == \Illuminate\Support\Arr::get($acesso, 'id')) ? 'selected' : '' @endphp >{{\Illuminate\Support\Arr::get($acesso, 'descricao')}}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}

{{--        <div class="form-check form-switch">--}}
{{--            <input class="form-check-input" type="checkbox" id="status" name="status" value="{{ old('status', $user->status) }}"  @php echo (old('status', $user->status)) ? 'checked' : '' @endphp >--}}
{{--            <label for="status" > {{__('Ativo')}}</label>--}}
{{--        </div>--}}
        <div class="flex items-center gap-4">
            <x-primary-button id="save-info-profile">{{ __('Salvar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Alterações salvas.') }}</p>
            @endif
        </div>
    </form>
</section>
