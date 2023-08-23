<section>
    @include('profile.partials.header',['title' => "Tipo de Usuário"])

    <div class="mt-6 space-y-6">
        <form method="post" action="{{ route('profile.tipo') }}" class="mt-6 space-y-6">
        @csrf
        @method('post')

            <div>
                <x-text-input id="id" name="id" type="hidden" :value="old('id', $user->id)" />
            </div>
        @foreach(\App\Helpers\Constants::GRUPO as $key => $tipo)
            <div class="">

                <input class="form-check-input" type="radio" value="{{ $key }}" id="grupo_usuario" name="grupo_usuario"  @php echo ($user->grupo_usuario == $key) ? 'checked' : '' @endphp ></input>
                <label class="form-check-label" for="grupo_usuario">
                    {{ $tipo }}
                </label>
            </div>
        @endforeach

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Salvar') }}</x-primary-button>
        </div>
        </form>
    </div>
</section>
