<x-layout title="Other's Ideas">
    <div class="mb-6">
        <div class="mb-4 flex items-center justify-between mx-auto">
            <a href="{{ route('ideas.index') }}"
               aria-label="Your Ideas"
               class="inline-flex items-center btn btn-accent">
                Your Ideas
            </a>
            <button
                    aria-label="Other's Ideas"
                    class="inline-flex items-center btn btn-ghost">
                Other's Ideas
            </button>
        </div>
    </div>

    <div class="block w-full h-1 bg-black" aria-hidden="true"></div>

    <div class="mt-6">
        <div class="mt-6">
            @if($ideas->isEmpty())
                <p>No ideas from Others.</p>
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