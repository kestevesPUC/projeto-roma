<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Tipo de Usuário') }}
        </h2>
    </header>
    <div class="mt-6 space-y-6">
        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        @foreach(\App\Helpers\Constants::GRUPO as $key => $tipo)
            <div class="form-check">
                <input class="form-check-input" type="radio" value="{{ $key }}" id="grupo_usuario{{$key}}" name="grupo_usuario{{$key}}"  @php echo \Illuminate\Support\Facades\Auth::user()->grupo_usuario == $key ? 'checked' : '' @endphp>
                <label class="form-check-label" for="grupo_usuario{{ $key }}">
                    {{ $tipo }}
                </label>
            </div>
        @endforeach

        <div class="flex items-center gap-4">
            <x-primary-button type="button" id="save_user_group">{{ __('Save') }}</x-primary-button>
        </div>
        </form>
    </div>
</section>
