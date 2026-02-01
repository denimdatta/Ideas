<x-layout>
    <form method="POST" action="/ideas/create">
        @csrf

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

        <p class="mt-3 mb-3 text-sm/6 text-black font-bold">New Idea</p>
        <div class="col-span-full">
            <label for="title" class="block text-sm/6 font-medium text-gray-900">Title</label>

            <div class="mt-2">
                <input id="title"
                       name="title"
                       type="text"
                       maxlength="255"
                       required
                       class="block w-full rounded-md bg-white px-3 py-1.5 text-base
                           text-gray-900 outline-1 -outline-offset-1 outline-gray-300
                           placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2
                           focus:outline-indigo-600 sm:text-sm/6" />
            </div>

            @error('title')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-span-full">
            <label for="idea" class="block text-sm/6 font-medium text-gray-900">Describe Your Idea</label>
            <div class="mt-2">
                <textarea id="idea"
                          name="idea"
                          rows="3"
                          class="block w-full rounded-md bg-white px-3 py-1.5 text-base
                                text-gray-900 outline-1 -outline-offset-1 outline-gray-300
                                placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2
                                focus:outline-indigo-600 sm:text-sm/6"></textarea>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="reset"
                    onclick="return confirm('Are you sure you want to clear the form?');"
                    class="rounded-md bg-red-400 px-3 py-2 text-sm font-semibold
                        text-black shadow-xs hover:bg-red-500 focus-visible:outline-2
                        focus-visible:outline-offset-2 focus-visible:outline-red-400">
                Clear
            </button>
            
            <button type="submit"
                    class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold
                        text-white shadow-xs hover:bg-green-800 focus-visible:outline-2
                        focus-visible:outline-offset-2 focus-visible:outline-green-600">
                Save
            </button>
        </div>
    </form>
</x-layout>