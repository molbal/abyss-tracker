@php
    $currentRoute = Route::currentRouteName();
@endphp
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <a class="navbar-brand" href="{{route("home")}}" data-toggle="tooltip" title="Homepage">
        <svg width="233" height="48" viewBox="0 0 233 48" class="css-1j8o68f"><defs id="SvgjsDefs2399"><linearGradient id="SvgjsLinearGradient2404"><stop id="SvgjsStop2405" stop-color="#7f00ff" offset="0"></stop><stop id="SvgjsStop2406" stop-color="#e100ff" offset="1"></stop></linearGradient></defs><g id="SvgjsG2400" featurekey="nameContainer" transform="matrix(1,0,0,1,0,0)" fill="url(#SvgjsLinearGradient2404)">    <path xmlns="http://www.w3.org/2000/svg" fill-rule="nonzero" d="             M0,0             H233             V48             H0,0             z             M4,4             v40             h225             v-40             z     "></path></g><g id="SvgjsG2401" featurekey="nameFeature-0" transform="matrix(0.6790932416915894,0,0,0.6790932416915894,14.824184996947313,6.612398912141071)" fill="#ffffff"><path d="M20.645 17.754 l-10 0 l0 4.6875 l8.9063 0 l0 6.4063 l-8.9063 0 l0 4.6289 l10 0 l0 6.5234 l-17.441 0 l0 -28.711 l17.441 0 l0 6.4648 z M44.882875 11.289000000000001 l7.9297 0 l-10.645 28.711 l-8.3594 0 l-10.566 -28.711 l7.9297 0 l6.8555 20.176 z M73.6528125 17.754 l-10 0 l0 4.6875 l8.9063 0 l0 6.4063 l-8.9063 0 l0 4.6289 l10 0 l0 6.5234 l-17.441 0 l0 -28.711 l17.441 0 l0 6.4648 z M99.0626875 11.289000000000001 l7.4414 0 l0 28.711 l-8.8477 0 l-10.957 -18.633 l0 18.633 l-7.4414 0 l0 -28.711 l8.75 0 l11.055 18.535 l0 -18.535 z M130.6055 11.289000000000001 l0 6.4648 l-6.4844 0 l0 22.246 l-7.3633 0 l0 -22.246 l-6.5039 0 l0 -6.4648 l20.352 0 z M149.1211 40 l-7.0313 -28.711 l7.7148 0 l4.8438 20.508 l5.918 -20.508 l6.1914 0 l5.8789 20.508 l4.8828 -20.508 l7.7148 0 l-7.0313 28.711 l-9.8438 0 l-4.7266 -14.961 l-4.668 14.961 l-9.8438 0 z M208.69171875 40 l-1.8555 -5.3125 l-11.484 0 l-1.8359 5.3125 l-7.5586 0 l10.566 -28.711 l9.1602 0 l10.566 28.711 l-7.5586 0 z M197.48071875 28.555 l7.2266 0 l-3.6133 -10.391 z M237.3633125 11.289000000000001 l0 6.4648 l-6.4844 0 l0 22.246 l-7.3633 0 l0 -22.246 l-6.5039 0 l0 -6.4648 l20.352 0 z M254.1206875 40.39063 c-8.6719 0 -14.902 -5.8398 -14.902 -14.746 c0 -8.9258 6.2305 -14.766 14.902 -14.766 c6.8555 0 12.207 3.5938 14.121 9.4336 l-6.9531 2.4414 c-0.95703 -3.2031 -3.7109 -5.1172 -7.168 -5.1172 c-4.3164 0 -7.5195 3.0859 -7.5195 8.0078 s3.2031 7.9883 7.5195 7.9883 c3.457 0 6.2109 -1.9141 7.168 -5.1172 l6.9531 2.4414 c-1.9141 5.8398 -7.2656 9.4336 -14.121 9.4336 z M290.27296875 11.289000000000001 l7.4414 0 l0 28.711 l-7.4414 0 l0 -11.191 l-10.586 0 l0 11.191 l-7.4414 0 l0 -28.711 l7.4414 0 l0 11.113 l10.586 0 l0 -11.113 z"></path></g></svg>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        </ul>
        <div id="autocomplete" class="ml-auto mr-0" style="min-height: 45px; min-width: 200px;"></div>
    </div>
</nav>
