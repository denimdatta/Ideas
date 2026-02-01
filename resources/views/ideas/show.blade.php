<x-layout>
    <div class="mb-4">
        <a href="{{ url('/ideas') }}"
           aria-label="Back to ideas"
           class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <span class="mr-2 text-lg" aria-hidden="true">←</span>
            <span>Back to ideas</span>
        </a>
    </div>

    <x-json-card :data="$idea" />
</x-layout>