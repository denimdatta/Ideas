@php
    use App\Enums\IdeaStatus;
@endphp

<x-layout title="Edit: {{ $idea->title }}">
    <form method="POST" action="{{ route('ideas.update', $idea) }}">
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
                       class="input w-full @error('title') input-error @enderror"/>
            </div>

            <x-forms.error name="title"/>
        </div>

        <div class="col-span-full">
            <label for="description" class="block text-sm/6 font-medium text-gray-900">Describe Your Idea</label>
            <div class="mt-2">
                <textarea id="description"
                          name="description"
                          class="textarea field-sizing-content w-full @error('description') textarea-error @enderror"
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
                            class="inline-block w-auto select select-info @error('status') select-error @enderror">
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
                <a href="{{ route('ideas.show', $idea) }}"
                   class="inline-flex items-center btn btn-info">
                    Cancel
                </a>

                <!-- Update -->
                <div class="flex items-center">
                    <button type="submit"
                            class="btn btn-success">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </form>
</x-layout>