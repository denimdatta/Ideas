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
        <div class="navbar bg-base-100 shadow-sm">
            <div class="navbar-start">
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /> </svg>
                    </div>
                    <ul
                            tabindex="-1"
                            class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                        <li>
                            <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                        </li>
                        <li>
                            <x-nav-link href="/ideas" :active="request()->is('ideas')">Ideas</x-nav-link>
                        </li>
                    </ul>
                </div>
                <a href="/" class="btn btn-ghost text-xl">
                    <span>
                        <img src="{{asset('ideas.svg')}}" alt="Your Company" class="size-8" />
                    </span>
                    <span> Ideas </span>

                </a>
            </div>
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1">
                    <li>
                        <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                    </li>
                    <li>
                        <x-nav-link href="/ideas" :active="request()->is('ideas')">Ideas</x-nav-link>
                    </li>
                </ul>
            </div>
            <div class="navbar-end">
                <a class="btn">Button</a>
            </div>
        </div>
        <div class="p-6 lg:p-8 items-center lg:justify-center min-h-screen h-full">
            <header class="relative bg-white shadow-sm">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $title }}</h1>
                </div>
            </header>
            <main>
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
