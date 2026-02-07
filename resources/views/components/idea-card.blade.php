<div class="card bg-sky-200 shadow-sm">
    <div class="card-body">
        <h2 class="card-title">{{ $idea->title }}</h2>
        <p class="card-description p-2 border-2 border-indigo-300 rounded-lg w-full">
            {!! nl2br(e($idea->description)) !!}
        </p>

        <div class="flex items-center gap-2 mt-4">
            @can('access', $idea)
                <small class="p-2 border-2 border-blue-400 rounded-lg">
                    {{ $idea->status->getDisplayName() }}
                </small>
            @endcan
            
            <a class="btn btn-primary ml-auto" href="{{ route('ideas.show', $idea) }}">
                View
            </a>
        </div>
    </div>
</div>
