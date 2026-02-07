<x-layout title="Your Ideas">
    <div class="mb-6">
        <div class="mb-4 flex items-center justify-between mx-auto">
            <button
               aria-label="Your Ideas"
               class="inline-flex items-center btn btn-ghost">
                Your Ideas
            </button>
            <a href="{{ route('ideas.others') }}"
               aria-label="Other's Ideas"
               class="inline-flex items-center btn btn-accent">
                Other's Ideas
            </a>
        </div>
    </div>

    <div class="block w-full h-1 bg-black" aria-hidden="true"></div>

    <div class="mt-6">
        <div class="mb-4 flex items-center justify-between">
            <form method="POST" action="{{ route('ideas.destroy.all') }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Are you sure?\nThis will delete all ideas')
                                &&
                                confirm('Last Warning before deleting all ideas\nNo turning back\nAre you absolutely sure?');"
                        class="btn btn-error">
                    Delete All Ideas
                </button>
            </form>

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
            @elseif (session('purge_success'))
                <div role="status"
                     class="inline-block w-auto mt-4 rounded-md bg-red-50 border border-red-400
                        px-4 py-2 text-sm text-red-950 shadow-sm whitespace-nowrap">
                    {{ session('purge_success') }}
                </div>
            @endif

            <a href="{{ route('ideas.create') }}"
               aria-label="Create Idea"
               class="inline-flex items-center btn btn-success">
                Create New Idea
            </a>
        </div>

        <div class="mt-6">
            @if($ideas->isEmpty())
                <p>No ideas yet.</p>
            @else
                <ul class="mt-6 grid grid-cols-2 gap-x-6 gap-y-4">
                    @foreach($ideas as $idea)
                        <x-idea-card :idea="$idea" />
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-layout>