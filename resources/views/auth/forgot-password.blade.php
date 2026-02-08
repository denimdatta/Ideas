<x-layout title="Forgot Password">
    <form action="{{ route('password.email') }}" method="POST">
        @csrf

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-fit border p-4 m-auto">
            <legend class="fieldset-legend">Reset link</legend>

            @if (session('status'))
                <p class="mt-2 text-sm text-success">{{ session('status') }}</p>
            @endif

            <div class="mb-4 gap-4">
                <div class="space-y-1">
                    <label class="label" for="email">Email</label>
                    <input id="email" name="email" type="email" class="input w-full" placeholder="Email" value="{{ old('email') }}" required />
                    <x-forms.error name="email"/>
                </div>
            </div>

            <button class="btn btn-neutral mt-4">Send reset link</button>
        </fieldset>
    </form>
</x-layout>
