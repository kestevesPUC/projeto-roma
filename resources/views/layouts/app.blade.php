<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Roma') }}</title>

        <!-- Fonts -->
{{--        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">--}}
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="shortcut icon" href="https://reweb-amp-static.nyc3.digitaloceanspaces.com/www-gruporomabrasil-com-br/d1cc4585f0333dac-roma9.png">
        @routes
        <!-- Scripts -->
        <script src="{{ mix('/assets/plugins/jquery/code.jquery.com_jquery-3.7.0.min.js') }}"></script>
        <script src="{{ mix('js/util/index.js') }}"></script>
{{--        <script src="{{ mix('/assets/essential.js') }}"></script>--}}
{{--        <script src="{{ mix('assets/plugins/EssentialTables.js')}}" type="text/javascript"></script>--}}
{{--        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>--}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

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
        <script src="https://kit.fontawesome.com/ea8ce2d0f8.js" crossorigin="anonymous"></script>
    </body>
</html>
