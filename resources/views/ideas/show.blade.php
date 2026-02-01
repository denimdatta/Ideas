<x-layout>
    <div class="mb-4 flex items-center justify-between">
        <a href="{{ url('/ideas') }}"
           aria-label="Back to ideas"
           class="inline-flex items-center text-gray-600 hover:text-gray-900">
            <span class="mr-2 text-lg" aria-hidden="true">←</span>
            <span>Back to ideas</span>
        </a>

        <div class="flex items-center gap-3">
            <a href="{{ url('/ideas/' . $idea->id . '/edit') }}"
               aria-label="Edit idea"
               class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2
           text-sm font-medium text-white hover:bg-indigo-700 focus:outline-2
           focus:outline-offset-2 focus:outline-indigo-600">
                Edit
            </a>

            <!-- Delete (uses JS to avoid nested forms) -->
            <button type="button"
                    onclick="if(confirm('Are you sure you want to delete this idea?')) {
							const f=document.createElement('form');
							f.method='POST';
							f.action='/ideas/{{ $idea->id }}';
							const t=document.createElement('input');
							t.type='hidden';
							t.name='_token';
							t.value='{{ csrf_token() }}';
							f.appendChild(t);
							const m=document.createElement('input');
							m.type='hidden';
							m.name='_method';
							m.value='DELETE';
							f.appendChild(m);
							document.body.appendChild(f);
							f.submit();
						}"
                    class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold
                            text-white shadow-xs hover:bg-red-800 focus-visible:outline-2
                            focus-visible:outline-offset-2 focus-visible:outline-red-600">
                Delete
            </button>
        </div>
    </div>

    @if (session('edit_success'))
        <div role="status"
             class="inline-block w-auto mt-4 rounded-md bg-green-50 border border-green-200
                        px-4 py-2 text-sm text-green-800 shadow-sm whitespace-nowrap">
            {{ session('edit_success') }}
        </div>
    @endif

    <x-json-card :data="$idea" />
</x-layout>
