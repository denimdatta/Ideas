<div class="navbar mx-auto max-w-3xl bg-base-100 shadow-sm">
    <div class="navbar-start">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /> </svg>
            </div>
            <ul
                    tabindex="-1"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li>
                    <x-navbar.link href="/" :active="request()->is('/')">Home</x-navbar.link>
                </li>
                <li>
                    <x-navbar.link href="{{ route('ideas.index') }}" :active="request()->routeIs('ideas.*')">Ideas</x-navbar.link>
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
                <x-navbar.link href="/" :active="request()->is('/')">Home</x-navbar.link>
            </li>
            <li>
                <x-navbar.link href="{{ route('ideas.index') }}" :active="request()->routeIs('ideas.*')">Ideas</x-navbar.link>
            </li>
        </ul>
    </div>
    <div class="navbar-end">
        <a class="btn">Button</a>
    </div>
</div>
