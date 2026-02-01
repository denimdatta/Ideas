@php use App\Enums\IdeaStatus; @endphp
<x-layout>
    <form method="POST" action="/ideas/{{ $idea->id }}">
        @csrf
        @method('PATCH')

        @if (session('success'))
            <div role="status"
                 class="inline-block w-auto mt-4 rounded-md bg-green-50 border border-green-200
                        px-4 py-2 text-sm text-green-800 shadow-sm whitespace-nowrap">
                {{ session('success') }}
            </div>
        @endif

        <p class="mt-3 mb-3 text-sm/6 text-black font-bold">Update Idea</p>
        <div class="col-span-full">
            <label for="title" class="block text-sm/6 font-medium text-gray-900">Title</label>

            <div class="mt-2">
                <input id="title"
                       name="title"
                       type="text"
                       value="{{ old('title', $idea->title) }}"
                       maxlength="255"
                       required
                       class="block w-full rounded-md bg-white px-3 py-1.5 text-base
                           text-gray-900 outline-1 -outline-offset-1 outline-gray-300
                           placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2
                           focus:outline-indigo-600 sm:text-sm/6"/>
            </div>

            <x-forms.error name="title"/>
        </div>

        <div class="col-span-full">
            <label for="description" class="block text-sm/6 font-medium text-gray-900">Describe Your Idea</label>
            <div class="mt-2">
                <textarea id="description"
                          name="description"
                          class="block w-full rounded-md bg-white px-3 py-1.5 text-base
                                text-gray-900 outline-1 -outline-offset-1 outline-gray-300
                                placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2
                                focus:outline-indigo-600 sm:text-sm/6"
                          rows="3">{{ old('description', $idea->description) }}</textarea>
            </div>

            <x-forms.error name="description"/>
        </div>

        @php
            $selectedStatus = old('status', $idea->status->value);
        @endphp

        <div class="mt-4 flex items-start justify-between gap-x-6">
            <div class="w-2/3">
                <div class="flex items-center gap-3">
                    <label for="status" class="text-sm/6 font-medium text-gray-900">Status</label>

                    <select id="status"
                            name="status"
                            required
                            class="inline-block w-auto rounded-md bg-white px-3 py-1.5 text-base text-gray-900
                                   outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400
                                   focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        @foreach(IdeaStatus::cases() as $status)
                            <option value="{{ $status->value }}" {{ $selectedStatus === $status->value ? 'selected' : '' }}>
                                {{ $status->getDisplayName() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <x-forms.error name="status"/>
            </div>

            <div class="flex items-center gap-3">
                <!-- Cancel -->
                <a href="{{ url('/ideas/'.$idea->id) }}"
                   class="inline-flex items-center rounded-md bg-gray-100 px-3 py-2 text-sm
                        font-medium text-gray-700 hover:bg-gray-400 focus:outline-2
                        focus:outline-offset-2 focus:outline-gray-300">
                    Cancel
                </a>

                <!-- Update -->
                <div class="flex items-center">
                    <button type="submit"
                            class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-layout>