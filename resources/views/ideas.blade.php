<x-layout>
    <form method="POST" action="/ideas">
        @csrf

        <div class="col-span-full">
            <label for="idea" class="block text-sm/6 font-medium text-gray-900">New Idea</label>
            <div class="mt-2">
                <textarea id="idea"
                          name="idea"
                          rows="3"
                          class="block w-full rounded-md bg-white px-3 py-1.5 text-base
                                text-gray-900 outline-1 -outline-offset-1 outline-gray-300
                                placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2
                                focus:outline-indigo-600 sm:text-sm/6"></textarea>
            </div>
            <p class="mt-3 text-sm/6 text-gray-700">What's in your mind?</p>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="reset"
                    class="rounded-md bg-red-400 px-3 py-2 text-sm font-semibold
                        text-black shadow-xs hover:bg-red-500 focus-visible:outline-2
                        focus-visible:outline-offset-2 focus-visible:outline-red-400">
                Cancel
            </button>
            <button type="submit"
                    class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold
                        text-white shadow-xs hover:bg-green-800 focus-visible:outline-2
                        focus-visible:outline-offset-2 focus-visible:outline-green-600">
                Save
            </button>
        </div>

        @if (count($ideas))
            <div class="mt-6 text-white">
                <p class="font-bold">
                    <a href="/ideas" class="underline">View all Ideas</a>
                </p>
                <ul class="mt-6">
                    @foreach($ideas as $idea)
                        <li class="text-sm mt-2">{{ $idea }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
</x-layout>