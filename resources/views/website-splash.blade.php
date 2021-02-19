<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Club Foot Dashboard</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    </head>

    <body class="bg-blue-100">
        <img class="w-1/5 m-auto" src="../images/AppIcon.png" alt="App Icon"/>
        <div class="text-center p-4 w-3/4 lg:w-1/2 m-auto bg-white rounded shadow-lg">
            <h1 class="text-2xl font-bold">Welcome to the Club Foot Dashboard</h1>
            <p class="m-auto mt-4 w-3/4 lg:w-1/2">A website that aims to help you track your Boots and Bars wearing time and help you achieve your goals</p>
            <form action="/login">
                <input type="submit" class="button mt-3 p-4 bg-yellow-500 hover:bg-yellow-600" value="Sign in with email"/>
            </form>
            <p class="mt-4">Developed by <a class="text-blue-600" href="http://jakeshepherd.me">Jake Shepherd</a></p>
        </div>
    </body>
</html>
