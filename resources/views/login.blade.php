<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Đăng nhập - {{ config('app.name') }}</title>
        <!-- Fav Icon  -->
        <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{mix('css/app.css')}}">
    </head>
    <body>
        <div id="app">
            <Login/>
        </div>

        <script src="{{mix('js/app.js')}}"></script>
    </body>
</html>
