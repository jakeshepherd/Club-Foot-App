<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Credit</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        @include('layouts.navigation')
        <div class="text-center mt-8">
            <h1 class="text-lg font-bold">Credit:</h1>
            <a target="_blank" href="https://icons8.com/icons/set/skin">Skin icon</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a>
            <br />
            <a target="_blank" href="https://icons8.com/icons/set/jumper">Jumper icon</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a>
            <br />
            <a target="_blank" href="https://icons8.com/icons/set/fireman-boots">Work Boot icon</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a>
            <br />
            <a target="_blank" href="https://icons8.com/icons/set/right-footprint">Foot icon</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a>
            <br />
            <a target="_blank" href="https://icons8.com/icons/set/phone">Phone icon</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a>
            <br />
            <a target="_blank" href="https://icons8.com/icons/set/email">Email icon</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a>
            <br />
            <a target="_blank" href="https://icons8.com/icons/set/guest-male">Account icon</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
