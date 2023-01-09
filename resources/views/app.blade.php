<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Cong tac doan Thanh nien truong DHSP Hanoi.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{asset('assets/css/dashlite.css')}}">
    <link id="skin-default" rel="stylesheet" href="{{asset('assets/css/theme.css')}}">
    <title>{{ config('app.name') }}</title>
    @yield('css')
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div id="app">
        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main ">
                <!-- sidebar @s -->
                @include('pages.layouts.parts.sidebar')
                <!-- sidebar @e -->
                <!-- wrap @s -->
                <div class="nk-wrap ">
                    <!-- main header @s -->
                    @include('pages.layouts.parts.header')
                    <!-- main header @e -->
                    <!-- content @s -->
                    <router-view></router-view>
                    <!-- content @e -->
                    <!-- footer @s -->
                    @include('pages.layouts.parts.footer')
                    <!-- footer @e -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- main @e -->
        </div>
        <!-- app-root @e -->
    </div>
    <!-- JavaScript -->
    <script src="{{asset('assets/js/bundle.js')}}"></script>
    <script src="{{asset('assets/js/scripts.js')}}"></script>
    <script src="{{mix('js/app.js')}}"></script>
    @yield('js')
</body>

</html>
