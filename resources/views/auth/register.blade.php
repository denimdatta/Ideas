<x-layout title="Register New User">
    <form action="/register" method="POST">
        @csrf

        <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-fit border p-4 m-auto">
            <legend class="fieldset-legend">Register</legend>

            <div class="mb-4 grid grid-cols-2 gap-4">
                <div class="flex flex-col col-span-2 space-y-1">
                    <label class="label" for="username">Username</label>
                    <input id="username" name="username" class="input w-full" placeholder="Username" value="{{ old('username') }}" required />
                    <x-forms.error name="username"/>
                </div>
                <div class="flex flex-col col-span-2 space-y-1">
                    <label class="label" for="first_name">First Name</label>
                    <input id="first_name" name="first_name" class="input w-full" placeholder="Given Name" value="{{ old('first_name') }}" required />
                    <x-forms.error name="first_name"/>
                </div>
                <div class="flex flex-col col-span-2 space-y-1">
                    <label class="label" for="last_name">Last Name</label>
                    <input id="last_name" name="last_name" class="input w-full" placeholder="Family Name" value="{{ old('last_name') }}" />
                    <x-forms.error name="last_name"/>
                </div>
                <div class="flex flex-col space-y-1">
                    <label class="label" for="email">Email</label>
                    <input id="email" name="email" type="email" class="input" placeholder="Email" value="{{ old('email') }}" required />
                </div>
                <div class="flex flex-col space-y-1">
                    <label class="label" for="email_confirmation">Confirm Email</label>
                    <input id="email_confirmation" name="email_confirmation" type="email" class="input" placeholder="Confirm Email" required />
                </div>
                <div class="flex flex-col col-span-2 space-y-1">
                    <x-forms.error name="email"/>
                </div>
                <div class="flex flex-col space-y-1">
                    <label class="label" for="password">Password</label>
                    <input id="password" name="password" type="password" class="input" placeholder="Password" required />
                </div>
                <div class="flex flex-col space-y-1">
                    <label class="label" for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="input" placeholder="Confirm Password" required />
                </div>
                <div class="flex flex-col col-span-2 space-y-1">
                    <x-forms.error name="password"/>
                </div>
            </div>

            <button class="btn btn-neutral mt-4">Register</button>
        </fieldset>
    </form>
</x-layout>
