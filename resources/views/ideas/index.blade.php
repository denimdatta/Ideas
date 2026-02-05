<x-layout title="Your Ideas">
    <div class="mt-6">
        <div class="mb-4 flex items-center justify-between">
            <a href="{{ route('ideas.index') }}"
               aria-label="View Idea"
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
                    <a href="{{ route('ideas.show', session('idea_id')) }}" class="underline">View</a>
                </div>
            @elseif (session('delete_success'))
                <div role="status"
                     class="inline-block w-auto mt-4 rounded-md bg-red-50 border border-red-200
                        px-4 py-2 text-sm text-red-800 shadow-sm whitespace-nowrap">
                    {{ session('delete_success') }}
                </div>
            @endif

            <a href="{{ route('ideas.create') }}"
               aria-label="Create Idea"
               class="inline-flex items-center rounded-md bg-green-600 px-3 py-2
                    text-sm font-medium text-white hover:bg-green-700 focus:outline-2
                    focus:outline-offset-2 focus:outline-green-600">
                Create New Idea
            </a>
        </div>

        <div class="mt-6">
            @if($ideas->isEmpty())
                <p>No ideas yet.</p>
            @else
                <ul class="mt-6 grid grid-cols-2 gap-x-6 gap-y-4">
                    @foreach($ideas as $idea)
                        <div class="card bg-sky-200 shadow-sm">
                            <div class="card-body">
                                <h2 class="card-title">{{ $idea->title }}</h2>
                                <p class="card-description p-2 border-2 border-indigo-300 rounded-lg w-full">
                                    {{ $idea->description }}
                                </p>

                                <div class="grid grid-cols-2 gap-2 mt-4">
                                    <small class="p-2 border-2 border-blue-400 rounded-lg w-fit justify-self-start">
                                        {{ $idea->status->getDisplayName() }}
                                    </small>
                                    <a class="btn btn-primary w-fit justify-self-end" href="{{ route('ideas.show', $idea) }}">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-layout>