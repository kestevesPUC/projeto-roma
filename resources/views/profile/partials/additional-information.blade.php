<section>
    @include('profile.partials.header',['title' => "Informações Adicionais"])

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
            <x-input-label for="cargo_id" :value="__('Cargo')" />
            <select name="cargo_id" id="cargo_id" class="form-select" value="{{old('cargo_id', $user->cargo_id)}}" aria-label="Default select">
                @foreach(\App\Http\Controllers\Cargo\CargoController::getCargo() as $cargo)
                    <option value="{{ \Illuminate\Support\Arr::get($cargo, 'id') }}" @php echo ($user->cargo_id == \Illuminate\Support\Arr::get($cargo, 'id')) ? 'selected' : '' @endphp >{{\Illuminate\Support\Arr::get($cargo, 'descricao')}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <x-input-label for="setor_id" :value="__('Setor de serviço')" />
            <select name="setor_id" id="setor_id" class="form-select" value="{{old('setor_id', $user->setor_id)}}" aria-label="Default select">
                @foreach(App\Http\Controllers\Setor\SetorController::getSetor() as $setor)
                    <option value="{{ \Illuminate\Support\Arr::get($setor, 'id') }}" @php echo ($user->setor_id == \Illuminate\Support\Arr::get($setor, 'id')) ? 'selected' : '' @endphp >{{\Illuminate\Support\Arr::get($setor, 'descricao')}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <div>
                <x-input-label for="perfil_id" :value="__('Perfil')" />
                <select name="perfil_id" id="perfil_id" class="form-select" value="{{old('perfil_id', $user->perfil_id)}}" aria-label="Default select">
                    @foreach(\App\Http\Controllers\Perfil\PerfilController::getPerfil() as $perfil)
                        @if(\Illuminate\Support\Arr::get($perfil, 'ativo'))
                            <option value="{{ \Illuminate\Support\Arr::get($perfil, 'id') }}" @php echo ($user->perfil_id == \Illuminate\Support\Arr::get($perfil, 'id')) ? 'selected' : '' @endphp >{{\Illuminate\Support\Arr::get($perfil, 'descricao')}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <x-input-label for="diretoria_id" :value="__('É Diretor/Gerente')" />
            <select name="diretoria_id" id="diretoria_id" class="form-select" value="{{old('diretoria_id', $user->diretoria_id)}}" aria-label="Default select">
                @foreach(App\Http\Controllers\Diretoria\DiretoriaController::getDiretoria() as $diretoria)
                    <option value="{{ \Illuminate\Support\Arr::get($diretoria, 'id') }}" @php echo ($user->diretoria_id == \Illuminate\Support\Arr::get($diretoria, 'id')) ? 'selected' : '' @endphp >{{\Illuminate\Support\Arr::get($diretoria, 'descricao')}}</option>
                @endforeach
            </select>
        </div>

        <div>
            <x-input-label for="descricao_id" :value="__('Descricao')" />
            <textarea  id="descricao_id" name="descricao_id" type="textarea" class="mt-1 block w-full" data-description="{{$user->descricao_id}}" data-user="{{$user->id}}" :value="{{ old('descricao_id', $user->descricao_id) }}" required autofocus autocomplete="descricao_id" >{{ App\Http\Controllers\Descricao\DescricaoController::getDescricaoForId($user->descricao_id) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('descricao')" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button id="btn_info-additional">{{ __('Salvar') }}</x-primary-button>

            @if (session('status') === 'additional-information')
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
