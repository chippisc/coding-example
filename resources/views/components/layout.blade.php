@props(['pageTitle' => '', 'orientation' => 'center'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->

        @routes
        @vite('resources/css/app.css')
    </head>
    <body class="font-sans antialiased">
        <div id="app" class="flex items-center h-screen w-screen justify-center bg-white">
            <div id="main" @class(['w-screen max-w-[1024px] bg-white px-2', 'h-screen' => $orientation === 'top'])>
                <h1 class="font-bold text-2xl py-4">
                    {{ $pageTitle }}
                </h1>
                {{ $slot }}
            </div>
        </div>
        @vite(['resources/js/app.js'])
    </body>
</html>
