<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <base href="{{config("app.url")}}">


    @if(App\Http\Controllers\ThemeController::isDarkTheme())
        <link rel="stylesheet" href="css/app-dark.css"/>
    @else
        <link rel="stylesheet" href="css/app.css"/>
        <link rel="stylesheet"
              href="https://cdn.jsdelivr.net/npm/bootstrap4-select2-theme@1.0.3/src/css/bootstrap4-select2-theme.css">
    @endif

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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css"
          integrity="sha256-nbyata2PJRjImhByQzik2ot6gSHSU4Cqdz5bNYL2zcU=" crossorigin="anonymous"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-html5-1.5.1/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <title>@yield('browser-title', config('app.name')) | {{ config('app.name') }}</title>
    <style>
        .navbar-brand > img {
            height: 32px;
        }

        .navbar ul.navbar-nav li a img {
            position: relative;
            top: -2px
        }

        tr, td {
            vertical-align: middle !important;
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

        option {
            font-family: 'Shentox 13';
        }

        img.pull-left.ml-2 {
            height: 64px;
            width: 64px;
        }

        table {
            border-collapse: collapse;
        }

        a.dropdown-item.active {
            border: 3px solid #e3342f;
            border-width: 0 0 0 3px;
            background-color: transparent;
            color:#000;
        }
        .navbar-light .navbar-nav .nav-link.active {
            color:#e3342f;
            border:0;
            border-width:0 !important;
            -webkit-box-shadow:inset 0 3px 0 0 #e3342f;
            box-shadow:inset 0 3px 0 0 #e3342f;
        }

        .nav-link img{
            width: 16px;
            height: 16px;
        }
        .nav-link img.rounded-circle{
            width: 24px;
            width: 24px;
            height: 24px;
            height: 24px;
        }

        .navbar-brand img {
            width: 32px;
            height: 32px;
        }

        .tooltip, .tooltip-inner {
            width: 360px;
            max-width: 360px;
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
        }
       .tooltip-inner {
        }
    </style>
    @yield('styles')
</head>
<body>
@component("layout.navbar")@endcomponent
<div class="container">
    @if(\Illuminate\Support\Facades\Cache::has("recalc-notice"))
        <div class="alert alert-warning border-0 shadow-sm mt-3">
            {{\Illuminate\Support\Facades\Cache::get("recalc-notice")}} <br>
            We are currently processing task #{{\Illuminate\Support\Facades\Cache::get("recalc-current")}} out
            of {{\Illuminate\Support\Facades\Cache::get("recalc-all")}}
        </div>
    @endif
    @yield('content')
</div>
<footer class="footer mt-auto py-3 mt-5">
    <div class="container mt-5">
        <div class="col-sm-12 mt-5">
            <p class="mt-5 text-center">Abyss Tracker is an open source application created by <a
                    href="https://twitter.com/veetor_in_eve">Veetor Nara</a> - <a
                    href="https://github.com/molbal/abyss-tracker"><img
                        src="https://img.icons8.com/small/16/{{App\Http\Controllers\ThemeController::getThemedIconColor()}}/github.png">
                    source code here</a> - Set <a href="{{route("customize_set_dark", true)}}">dark theme</a> or <a
                    href="{{route("customize_set_dark", 0)}}">bright theme</a></p>
            <p class="text-justify mt-3 text-small text-black-50"><small>
                    All images are material are property of CCP Games: EVE Online and the EVE logo are the registered
                    trademarks
                    of CCP hf. All rights are reserved worldwide. All other trademarks are the property of their
                    respective
                    owners. EVE Online, the EVE logo, EVE and all associated logos and designs are the intellectual
                    property
                    of
                    CCP hf. All artwork, screenshots, characters, vehicles, storylines, world facts or other
                    recognizable
                    features of the intellectual property relating to these trademarks are likewise the intellectual
                    property of
                    CCP hf. CCP hf. has granted permission to evewho.com to use EVE Online and all associated logos and
                    designs
                    for promotional and zKillboard.com purposes on its website but does not endorse, and is not in any
                    way
                    affiliated with, zKillboard.com. CCP is in no way responsible for the content on or functioning of
                    this
                    website, nor can it be liable for any damage arising from the use of this website. The website uses
                    cookies for Google Analytics reporting.
                    Some icons were provided by <a href="https://icons8.com" rel="nofollow"
                                                   target="_blank">Icons8</a>
                    Thank you <a href="http://evepraisal.com" rel="follow" target="_blank">EVEpraisal</a> for loot
                    estimation and market data
                </small>
            </p>
        </div>
    </div>
</footer>
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
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/ladda.min.js"--}}
{{--        integrity="sha256-xqr6dAl11yzo9ssVFuVopsFNB/WWyFPb9sNOolhq43Q=" crossorigin="anonymous"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Ladda/1.0.6/spin.min.js"
        integrity="sha256-oNtUmAZAsXy3Pg53xwfYE1YYgfdktOImDPd57g6Ldek=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"
        integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js" charset="utf-8"></script>

{{--<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.full.min.js"
        integrity="sha256-vucLmrjdfi9YwjGY/3CQ7HnccFSS/XRS1M/3k/FDXJw=" crossorigin="anonymous"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.16/b-1.5.1/b-html5-1.5.1/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
@yield('scripts')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $(".select2-default").select2({
            theme: 'bootstrap',
            width: '100%'
        });

        $(".select2-nosearch").select2({
            theme: 'bootstrap',
            minimumResultsForSearch: -1,
            width: '100%'
        });

        var buttonCommon = {};
        var buttonExcelCopy = {
            exportOptions: {
                format: {
                    body: function ( data, row, column, node ) {
                        // Strip $ from salary column to make it numeric
                        var regex = /^[0-9 ]{1,13} ISK$/;
                        if (data.match(regex)) {
                            replaced = data.match(/\d+/g).join("");
                            console.log("Matched: ", data, " and ", replaced);
                            return replaced;

                        }
                        else {
                            var div = document.createElement("div");
                            div.innerHTML = data;
                            var text = div.textContent || div.innerText || "";
                            return text;
                        }
                    }
                }
            }
        };

        $(".datatable").append('<caption style="caption-side: bottom">Result list generated at {{date("Y-m-d H:i:s")}}</caption>');
        $('.datatable').DataTable({
            paginate: false,
            dom: 'Bfrtip',
            // buttons: [
            //     'copy', 'csv', 'excel', 'pdf'
            // ],
            buttons: [
                $.extend( true, {}, buttonCommon, {
                    extend: 'copyHtml5'
                } ),
                $.extend( true, {}, buttonExcelCopy, {
                    extend: 'excelHtml5'
                } ),
                $.extend( true, {}, buttonCommon, {
                    extend: 'pdfHtml5'
                } )]
        });
    });
</script>
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
</body>
</html>
