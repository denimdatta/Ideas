<x-layout title="Idea: {{ $idea->title }}">
    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('ideas.index') }}"
           aria-label="Back to ideas"
           class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <span class="mr-2 text-lg" aria-hidden="true">←</span>
            <span>Back to ideas</span>
        </a>

        <div class="flex items-center gap-3">
            <a href="{{ route('ideas.edit', $idea) }}" class="inline-flex items-center btn btn-primary">
                Edit
            </a>

            <form method="POST" action="{{ route('ideas.destroy', $idea) }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Are you sure you want to delete this idea?');"
                        class="btn btn-error">
                    Delete
                </button>
            </form>
        </div>
    </div>

    @if (session('edit_success'))
        <div role="status"
             class="inline-block w-auto mt-4 rounded-md bg-green-50 border border-green-200
                        px-4 py-2 text-sm text-green-800 shadow-sm whitespace-nowrap">
            {{ session('edit_success') }}
        </div>
    @endif

    <div class="card bg-sky-200 shadow-sm">
        <div class="card-body">
            <h2 class="card-title">{{ $idea->title }}</h2>
            <hr class="w-full h-0.5 bg-gray-800 border-0">
            <p class="card-description w-full">
                {{ $idea->description }}
            </p>

            <hr class="w-full">

            <div class="grid grid-cols-2">
                <small class="p-2 border-2 border-blue-400 rounded-lg w-fit justify-self-start">
                    <strong>{{ $idea->status->getDisplayName() }}</strong>
                </small>
                <small class="w-fit justify-self-end text-right">
                    <i><strong>Last Updated: </strong>{{ $idea->updated_at }}</i>
                    <br/>
                    <i><strong>Created: </strong>{{ $idea->created_at }}</i>
                </small>
            </div>
        </div>
    </div>
</x-layout>
