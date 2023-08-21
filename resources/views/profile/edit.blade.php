<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            @if(Auth::user()->grupo_usuario == \App\Helpers\Constants::ADMINISTRADOR)
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.status-user')
                    </div>
                </div>
            @endif
            @if(Auth::user()->grupo_usuario == \App\Helpers\Constants::ADMINISTRADOR)
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.additional-information')
                </div>
            </div>
            @endif
            @if(Auth::user()->grupo_usuario == \App\Helpers\Constants::ADMINISTRADOR)
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.group-user')
                    </div>
                </div>
            @endif
            @if(Auth::user()->grupo_usuario == \App\Helpers\Constants::ADMINISTRADOR)
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            @endif
            @if(Auth::user()->grupo_usuario == \App\Helpers\Constants::ADMINISTRADOR)
{{--                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">--}}
{{--                    <div class="max-w-xl">--}}
{{--                        @include('profile.partials.delete-user-form')--}}
{{--                    </div>--}}
{{--                </div>--}}
            @endif

        </div>
    </div>
</x-app-layout>

<script src="https://kit.fontawesome.com/ea8ce2d0f8.js" crossorigin="anonymous"></script>
<script src="{{ mix('/js/profile/index.js') }}"></script>
<script>Profile.init();</script>
{{--<script src="{{ mix('js/user/index.js') }}" ></script>--}}
{{--<script>User.init();</script>--}}
