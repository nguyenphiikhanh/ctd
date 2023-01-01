<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{mix('css/app.css')}}">
    </head>
    <body>
        <div id="app">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12 col-md-6 offset-md-3">
                        <div class="card shadow sm">
                            <div class="card-body">
                                <h1 class="text-center">Login</h1>
                                <hr/>
                                <form action="{{route('login.login')}}" class="row" method="post">
                                    @csrf
                                    <div class="form-group col-12">
                                        <label for="email" class="font-weight-bold">Username</label>
                                        <input type="text" name="username" class="form-control">
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="password" class="font-weight-bold">Password</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                    <div class="col-12 mb-2">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
