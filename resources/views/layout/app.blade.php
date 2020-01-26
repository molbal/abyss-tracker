<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <base href="{{config("app.url")}}">


    <link rel="stylesheet" href="css/app.css"/>

    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.standalone.min.css"
          integrity="sha256-BqW0zYSKgIYEpELUf5irBCGGR7wQd5VZ/N6OaBEsz5U=" crossorigin="anonymous"/>
    <title>{{ config('app.name', 'S') }}</title>
    <style>
        .navbar-brand > img {
            height: 32px;
        }

        .navbar ul.navbar-nav li a img {
            position: relative;
            top: -2px
        }

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

        .rotating {
            -webkit-animation: rotating 2s linear infinite;
            -moz-animation: rotating 2s linear infinite;
            -ms-animation: rotating 2s linear infinite;
            -o-animation: rotating 2s linear infinite;
            animation: rotating 2s linear infinite;
        }

        @font-face {
            font-family: 'Shentox 13';
            src: url('fonts/Shentox-Regular2.woff2') format('woff2'),
            url('fonts/Shentox-Regular2.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }

        * {
            font-family: 'Shentox 13';
        }
    </style>
    @yield('styles')
</head>
<body>
@component("layout.navbar")@endcomponent
<div class="container">
    @yield('content')
</div>
<footer class="footer mt-auto py-3 mt-5">
    <div class="container">
        <div class="col-sm-12">
            <p class="mt-5">This is an open source application created by <a href="https://twitter.com/veetor_in_eve">Veetor</a> - <a
                    href="https://github.com/molbal/abyss-tracker"><img src="https://img.icons8.com/small/16/000000/github.png"> source code here</a></p>
            <p class="text-justify mt-3 text-small text-black-50">
                All images are material are property of CCP Games: EVE Online and the EVE logo are the registered
                trademarks
                of CCP hf. All rights are reserved worldwide. All other trademarks are the property of their respective
                owners. EVE Online, the EVE logo, EVE and all associated logos and designs are the intellectual property
                of
                CCP hf. All artwork, screenshots, characters, vehicles, storylines, world facts or other recognizable
                features of the intellectual property relating to these trademarks are likewise the intellectual
                property of
                CCP hf. CCP hf. has granted permission to evewho.com to use EVE Online and all associated logos and
                designs
                for promotional and zKillboard.com purposes on its website but does not endorse, and is not in any way
                affiliated with, zKillboard.com. CCP is in no way responsible for the content on or functioning of this
                website, nor can it be liable for any damage arising from the use of this website. <br>
                Some icons were provided by <a href="https://icons8.com" rel="nofollow" target="_blank">Icons8</a>
            </p>
        </div>
    </div>
</footer>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.js"
        integrity="sha256-xqr6dAl11yzo9ssVFuVopsFNB/WWyFPb9sNOolhq43Q=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/spin.min.js"
        integrity="sha256-oNtUmAZAsXy3Pg53xwfYE1YYgfdktOImDPd57g6Ldek=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js" charset="utf-8"></script>

@yield('scripts')
<script>
    $(function () {
        Ladda.bind('[type=submit]');
    });
</script>
</body>
</html>
