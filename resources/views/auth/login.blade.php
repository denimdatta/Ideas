<x-layout title="Register New User">
    <form action="/login" method="POST">
        @csrf

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-fit border p-4 m-auto">
            <legend class="fieldset-legend">Login</legend>

            <x-forms.error name="status"/>
            <div class="mb-4 gap-4">
                <div class="space-y-1">
                    <label class="label" for="username">Username</label>
                    <input id="username" name="username" class="input w-full" placeholder="Username" value="{{ old('username') }}" required />
                    <x-forms.error name="username"/>
                </div>
                <x-forms.error name="username"/>
                <div class="flex flex-col space-y-1">
                    <label class="label" for="password">Password</label>
                    <input id="password" name="password" type="password" class="input" placeholder="Password" required />
                </div>
                <x-forms.error name="password"/>
            </div>
            <x-forms.error name="login_error"/>

            <button class="btn btn-neutral mt-4">Login</button>
        </fieldset>
    </form>
</x-layout>
