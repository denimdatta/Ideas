<x-layout>
    <div class="mt-6 text-white">
        <div class="mb-4 flex items-center justify-between">
            <a href="{{ url('/ideas') }}"
               aria-label="Create Idea"
               class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2
                    text-sm font-medium text-white hover:bg-indigo-700 focus:outline-2
                    focus:outline-offset-2 focus:outline-indigo-600">
                View All Ideas
            </a>

            @if (session('create_success'))
                <div role="status"
                     class="inline-block w-auto mt-4 rounded-md bg-green-50 border border-green-200
                        px-4 py-2 text-sm text-green-800 shadow-sm whitespace-nowrap">
                    {{ session('create_success') }}
                    <a href="/ideas/{{ session('idea_id') }}" class="underline">View</a>
                </div>
            @elseif (session('delete_success'))
                <div role="status"
                     class="inline-block w-auto mt-4 rounded-md bg-red-50 border border-red-200
                        px-4 py-2 text-sm text-red-800 shadow-sm whitespace-nowrap">
                    {{ session('delete_success') }}
                </div>
            @endif

            <a href="{{ url('/ideas/create') }}"
               aria-label="Create Idea"
               class="inline-flex items-center rounded-md bg-green-600 px-3 py-2
                    text-sm font-medium text-white hover:bg-green-700 focus:outline-2
                    focus:outline-offset-2 focus:outline-green-600">
                Create New Idea
            </a>
        </div>

        <div class="mt-6 text-white">
            @if($ideas->isEmpty())
                <p>No ideas yet.</p>
            @else
                <ul class="mt-6">
                    @foreach($ideas as $idea)
                        <li class="text-sm mt-2">
                            {{ $idea->title }}
                            [{{ $idea->status->getDisplayName() }}]
                            <a href="/ideas/{{ $idea->id }}" class="underline">View</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-layout>