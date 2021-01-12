<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="antialiased">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <x-button class="float-right m-5">
            {{ __('Logout') }}
        </x-button>
    </form>
        <div id="homepage"></div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
