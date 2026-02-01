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
                                focus:outline-indigo-600 sm:text-sm/6">{{ old('idea', $idea->description) }}
                </textarea>
            </div>
        </div>

        <div class="mt-4 flex items-start justify-between gap-x-6">
            <div class="w-2/3">

                @php
                    $selectedStatus = old('status', $idea->status->value);
                @endphp

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

                @error('status')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <button type="submit"
                        class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold
                               text-white shadow-xs hover:bg-green-800 focus-visible:outline-2
                               focus-visible:outline-offset-2 focus-visible:outline-green-600">
                    Update
                </button>
            </div>
        </div>
    </form>
</x-layout>