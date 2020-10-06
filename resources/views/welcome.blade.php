<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet"> -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->

    <style>

    </style>
</head>

<body class="antialiased">
    <div id="app">
        <app></app>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>
