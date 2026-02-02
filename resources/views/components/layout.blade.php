@props(['title' => ''])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Ideas') }}</title>
        <link rel="icon" href="{{asset('ideas.svg')}}" type="image/svg+xml">

        <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="">
        <x-navbar.base/>

        <div class="p-6 lg:p-8 items-center lg:justify-center min-h-screen h-full">
            <header class="relative">
                <div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8 bg-cyan-200 shadow-sm">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $title }}</h1>
                </div>
            </header>
            <main>
                <div class="mx-auto max-w-3xl px-4 py-6 sm:px-6 lg:px-8 bg-sky-100 shadow-sm">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
