<x-layout title="Reset Password">
    <form action="{{ route('password.update') }}" method="POST">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-fit border p-4 m-auto">
            <legend class="fieldset-legend">Set new password</legend>

            <div class="mb-4 gap-4">
                <div class="space-y-1">
                    <label class="label" for="email">Email</label>
                    <input id="email" name="email" type="email" class="input w-full" placeholder="Email" value="{{ old('email') }}" required />
                    <x-forms.error name="email"/>
                </div>

                <div class="space-y-1">
                    <label class="label" for="password">New password</label>
                    <input id="password" name="password" type="password" class="input w-full" placeholder="New password" required />
                    <x-forms.error name="password"/>
                </div>

                <div class="space-y-1">
                    <label class="label" for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="input w-full" placeholder="Confirm password" required />
                </div>
            </div>

            <button class="btn btn-neutral mt-4">Reset password</button>
        </fieldset>
    </form>
</x-layout>
