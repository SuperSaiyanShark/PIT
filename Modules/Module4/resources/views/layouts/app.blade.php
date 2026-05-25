<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>WELLMEADOWS HOSPITAL</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-cyan-50 to-cyan-100">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <div class="bg-gradient-to-r from-cyan-600 to-cyan-500 text-white py-8 px-6 shadow-lg">
                <div class="flex flex-col sm:flex-row justify-between items-center max-w-7xl mx-auto gap-4">
                    <div>
                        <h1 class="text-4xl font-bold tracking-wide">WELLMEADOWS HOSPITAL</h1>
                        <p class="text-cyan-100 mt-2 text-lg font-medium tracking-wider uppercase">Appointment and Treatment Module</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-3">
                        @isset($header)
                            {{ $header }}
                        @endisset
                        <a href="{{ route('dashboard') }}" class="bg-white text-cyan-600 px-6 py-2.5 rounded-lg font-bold hover:bg-cyan-50 transition shadow-md text-sm whitespace-nowrap">
                            Back to Main Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <main class="py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>