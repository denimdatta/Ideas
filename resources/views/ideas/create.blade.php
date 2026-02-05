<x-layout title="Create New Idea">
    <form method="POST" action="{{ route('ideas.store') }}">
        @csrf

        <p class="mt-3 mb-3 text-sm/6 text-black font-bold">New Idea</p>
        <div class="col-span-full">
            <label for="title" class="block text-sm/6 font-medium text-gray-900">Title (in 250 characters)</label>

            <div class="mt-2">
                <input id="title"
                       name="title"
                       type="text"
                       value="{{ old('title') }}"
                       required
                       class="input w-full @error('title') input-error @enderror"/>
            </div>

            <x-forms.error name="title"/>
        </div>

        <div class="col-span-full">
            <label for="description" class="block text-sm/6 font-medium text-gray-900">Describe Your Idea</label>
            <div class="mt-2">
                <textarea id="description"
                          name="description"
                          class="textarea w-full @error('description') textarea-error @enderror"
                          rows="3">{{ old('description') }}</textarea>
            </div>

            <x-forms.error name="description"/>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <!-- Cancel -->
            <a href="{{ route('ideas.index') }}"
               class="inline-flex items-center btn bg-gray-300 text-gray-700 hover:bg-gray-400">
                Cancel
            </a>

            <!-- Clear Form -->
            <button type="reset"
                    onclick="return confirm('Are you sure you want to clear the form?');"
                    class="btn bg-red-300 text-red-950 hover:bg-red-400">
                Clear
            </button>

            <!-- Save -->
            <button type="submit"
                    class="btn btn-success">
                Save
            </button>
        </div>
    </form>
</x-layout>