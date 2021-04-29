<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <base href="{{config("app.url")}}">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin />
    <link rel="preconnect" href="https://img.icons8.com" crossorigin />
    <link rel="preconnect" href="https://imageserver.eveonline.com" crossorigin />
    <link rel="preconnect" href="https://images.evetech.net" crossorigin />
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin />
        <link rel="stylesheet" href="css/app-dark.css" />
    <title>@yield('browser-title', config('app.name')) | {{ config('app.name') }}</title>
    <style>
        @-webkit-keyframes rotating /* Safari and Chrome */
        {
            from {
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            to {
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes rotating {
            from {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            to {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @font-face {
            font-family: 'Shentox 13';
            src: url('fonts/Shentox-Regular2.woff2') format('woff2'),
            url('fonts/Shentox-Regular2.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }
        @keyframes slideIn {
            0% {
                transform: translateY(-1rem) scale(0.9);
                opacity: 0;
            }
            100% {
                transform:translateY(0rem) scale(1);
                opacity: 1;
            }
            0% {
                transform: translateY(-1rem) scale(0.9);
                opacity: 0;
            }
        }
        html, body {
            background: transparent;
            margin: 0;
            padding: 0;
            border: 0;
        }
    </style>
    @yield('styles')
</head>
<body>
@yield('content')
<!-- Footer -->

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/spin.min.js"--}}
{{--        integrity="sha256-oNtUmAZAsXy3Pg53xwfYE1YYgfdktOImDPd57g6Ldek=" crossorigin="anonymous"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.8.0/echarts-en.min.js"
        charset="utf-8"></script>
<script src="https://abyss.eve-nt.uk/js/echart.theme.dark.js"
        charset="utf-8"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"
        type="text/javascript" ></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"
></script>
{{--<script src="{{asset("js/app.js")}}"></script>--}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
@yield('scripts')
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
@if(!config("app.debug"))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-86961430-8"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-86961430-8');
    </script>
@endif
</body>
</html>
