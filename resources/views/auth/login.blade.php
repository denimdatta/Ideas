<x-layout title="Login Existing User">
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
                <label class="label cursor-pointer justify-start gap-2">
                    <input type="checkbox" name="remember" value="1" class="checkbox" {{ old('remember') ? 'checked' : '' }} />
                    <span class="label-text">Remember me</span>
                </label>
            </div>
            <x-forms.error name="login_error"/>

            <button class="btn btn-neutral mt-4">Login</button>
            <a class="link link-primary mt-2 inline-block" href="{{ route('password.request') }}">Forgot password?</a>
        </fieldset>
    </form>
</x-layout>
