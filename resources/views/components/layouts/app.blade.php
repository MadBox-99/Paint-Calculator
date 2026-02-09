<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />

    <meta name="application-name" content="{{ config('app.name') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>{{ config('app.name') }}</title>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    @filamentStyles
    @vite(['resources/css/app.css'])
</head>

<body class="antialiased">
    @isset($title)
        <header class="bg-white">
            <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <img src="{{ Vite::asset('resources/images/HARZO-logo.webp') }}" alt="{{ config('app.name') }}"
                    class="w-32 h-32 mx-auto mb-4">
                <h1 class="mb-4 text-center text-3xl font-bold text-gray-900">
                    {{ $title }}
                </h1>
            </div>
        </header>
    @endisset
    @isset($content)
        <main class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            {{ $content }}
        </main>
    @endisset

    {{ $slot }}

    @filamentScripts
    @vite('resources/js/app.js')
</body>

</html>
