<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @fonts

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])

        @endif
    </head>
    <body>
        <x-navbar />
            <form
                class="mt-5 flex justify-center items-center flex-col"
                action="{{route('login')}}"
                method="POST"
            >
                @csrf

                <h1 class="text-xl text-center">Login</h1>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="border p-3 m-2" type="email" name="email" required />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input  class="border p-3 m-2" type="{{
                        config('app.env') === 'local'
                            ? 'text'
                            : 'password'
                    }}" name="password" required />
                </div>

                <button class="border p-3 m-2 cursor-pointer">Submit</button>
            </form>
    </body>
</html>
