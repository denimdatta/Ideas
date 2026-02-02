@props(['active' => false])

<a class="{{ $active ? 'bg-gray-950/50 text-white' : 'text-black hover:bg-white/5 hover:text-gray-950/50' }} rounded-md px-3 py-2 text-sm font-medium"
   aria-current="{{ $active ? 'page' : 'false' }}"
        {{ $attributes }}>
    {{ $slot }}
</a>