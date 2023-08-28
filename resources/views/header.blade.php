<x-app-layout>
    <x-slot name="header" >
        <div class=" d-flex flex-row align-items-center gap-3">
            <div class="shrink-4 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </a>
            </div>
            <div class="dropdown">
                <button class="btn btn-secondary text-bg-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Cadastros
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('cadastro_usuario') }}">Usuário</a></li>
                    <li><a class="dropdown-item" href="{{ route('cadastro_perfil') }}">Perfil de acesso</a></li>
                </ul>
            </div>
            <div class="dropdown">
                <button class="btn btn-secondary text-bg-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Relatórios
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Controle de ponto</a></li>
                </ul>
            </div>
            <div class="ms-auto p-2">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-content-end h-16">
                        <!-- Settings Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                        <div>{{ Auth::user()->name }}</div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')"><span>{{ __('Perfil') }}</span>

                                    </x-dropdown-link>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            {{ __('Sair') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-app-layout>

