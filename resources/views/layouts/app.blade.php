<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Roma') }}</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <!-- Fonts -->
{{--        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">--}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 
        <script src="{{ mix('/assets/essential.js') }}"></script>
{{--        <script src="{{ mix('assets/plugins/EssentialTables.js')}}" type="text/javascript"></script>--}}
{{--        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>--}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])


        @routes
        <!-- Scripts -->
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            
            <!-- Page Heading -->
            
            
                <header class="bg-light">
                    <div class="max-w-7xl mx-auto py-2 px-2 sm:px-6 lg:px-8">
                        <div class=" d-flex flex-row align-items-center gap-3">
                            @if(Auth::user()->grupo_usuario == \App\Helpers\Constants::ADMINISTRADOR)
                            <div class="dropdown">
                                <button class="btn btn-secondary text-bg-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Cadastros
                                </button>
                                <ul class="dropdown-menu">
                                    <li><button class="dropdown-item" onclick="window.location.href='{{ route('cadastro_usuario') }}'">Usuário</button></li>
                                    <li><button class="dropdown-item" onclick="window.location.href='{{ route('cadastro_perfil') }}'">Perfil</button></li>
                                </ul>
                            </div>
                            @endif
                            <div class="dropdown">
                                <button class="btn btn-secondary text-bg-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Relatórios
                                </button>
                                <ul class="dropdown-menu">
                                    <li><button class="dropdown-item" onclick="window.location.href='{{ route('ponto_usuario') }}'">Histórico de Ponto</button></li>
                                </ul>
                            </div>
                            <div class="ms-auto p-0">
                                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                                    <div class="flex justify-content-end h-16">
                                        <!-- Settings Dropdown -->
                                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                                            <x-dropdown align="right" width="48">
                                                <x-slot name="trigger">
                                                    <button class="inline-flex items-center px-3 py-2 border border-transparent rounded-md   btn-secondary text-bg-secondary hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                        <div>{{ Auth::user()->name }}</div>

                                                        <div class="ml-1">
                                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    </button>
                                                </x-slot>

                                                <x-slot name="content">
                                                    <x-dropdown-link :href="route('profile.edit')"><span>{{ __('Profile') }}</span>

                                                    </x-dropdown-link>

                                                    <!-- Authentication -->
                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf

                                                        <x-dropdown-link :href="route('logout')"
                                                                onclick="event.preventDefault();
                                                                            this.closest('form').submit();">
                                                            {{ __('Log Out') }}
                                                        </x-dropdown-link>
                                                    </form>
                                                </x-slot>
                                            </x-dropdown>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                </header>
            

            <!-- Page Content -->
            <main>
                @yield('content')
                @if(isset($slot))
                   {{ $slot }} 
                @endif
            </main>
        </div>
        @yield('scripts')
        @yield('scriptConsulta')
        

    </body>
</html>
