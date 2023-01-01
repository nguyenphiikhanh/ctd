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
                                <form action="javascript:void(0)" class="row" method="post">
                                    <div class="form-group col-12">
                                        <label for="email" class="font-weight-bold">Email</label>
                                        <input type="text" v-model="auth.email" name="email" id="email" class="form-control">
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="password" class="font-weight-bold">Password</label>
                                        <input type="password" v-model="auth.password" name="password" id="password" class="form-control">
                                    </div>
                                    <div class="col-12 mb-2">
                                        <button type="submit" :disabled="processing" @click="login" class="btn btn-primary btn-block">
                                            {{ processing ? "Please wait" : "Login" }}
                                        </button>
                                    </div>
                                    <div class="col-12 text-center">
                                        <label>Don't have an account? <router-link :to="{name:'register'}">Register Now!</router-link></label>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
