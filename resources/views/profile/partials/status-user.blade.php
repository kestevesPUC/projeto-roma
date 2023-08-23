<section>
    @include('profile.partials.header',['title' => "Status"])


    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div>
            <x-text-input id="id" name="id" type="hidden" :value="old('id', $user->id)" />
        </div>
        <div>
            <x-input-label for="data_admissao" :value="__('Admissão')" />
            <x-text-input id="data_admissao" name="data_admissao" type="date" class="mt-1 block w-full" :value="old('data_admissao',\Illuminate\Support\Arr::get(explode(' ',$user->data_admissao),0))" autofocus autocomplete="data_admissao" />
            <x-input-error class="mt-2" :messages="$errors->get('data_admissao')" />
        </div>

        <div>
            <x-input-label for="data_demissao" :value="__('Demissão')" />
            <x-text-input id="data_demissao" name="data_demissao" type="date" class="mt-1 block w-full" :value="old('data_demissao',\Illuminate\Support\Arr::get(explode(' ',$user->data_demissao),0))" autofocus autocomplete="data_demissao" />
            <x-input-error class="mt-2" :messages="$errors->get('data_demissao')" />
        </div>

        <div>
            <x-input-label for="empresa_id" :value="__('Empresa')" />
            <select name="empresa_id" id="empresa_id" class="form-select" value="{{old('empresa_id', $user->empresa_id)}}" aria-label="Default select">
                @foreach(\App\Http\Controllers\Empresa\EmpresaController::getEmpresas() as $empresa)
                    <option  value="{{ \Illuminate\Support\Arr::get($empresa, 'id') }}" @php echo ($user->empresa_id == \Illuminate\Support\Arr::get($empresa, 'id')) ? 'selected' : '' @endphp >{{\Illuminate\Support\Arr::get($empresa, 'descricao')}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <x-input-label for="tipo_acesso_id" :value="__('Tipo de Acesso')" />
            <select name="tipo_acesso_id" id="tipo_acesso_id" class="form-select" value="{{ old('tipo_acesso_id', $user->tipo_acesso_id) }}" aria-label="Default select">

                @foreach(\App\Http\Controllers\TipoAcesso\TipoAcessoController::getTipoAcessos() as $acesso)
                    <option value="{{ \Illuminate\Support\Arr::get($acesso, 'id') }}" @php echo ($user->tipo_acesso_id == \Illuminate\Support\Arr::get($acesso, 'id')) ? 'selected' : '' @endphp >{{\Illuminate\Support\Arr::get($acesso, 'descricao')}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="status" value="{{  $user->status }}"  @php echo ($user->status) ? 'checked' : '' @endphp >
            <label for="status" > {{__('Ativo')}}</label>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button id="btn-status">{{ __('Salvar') }}</x-primary-button>

            @if (session('status') === 'status-user')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Alterações salvas. ') }}</p>
            @endif
        </div>
    </form>
</section>
