@extends('layout.stream-base')
@section("browser-title", "Daily browser source")
@section("content")
    @auth

        <table class="w-100">
            <tr>
                <td colspan="2">Today's stats for {{$charName}}</td>
            </tr>
            <tr>
                <td>Daily runs</td>
                <td id="runsCount">{{$runsCount}}</td>
            </tr>
            <tr>
                <td>Sum ISK</td>
                <td><span id="sumIsk">{{$sumIsk}}</span>M ISK</td>
            </tr>
            <tr>
                <td>Average ISK/run</td>
                <td><span id="avgIsk">{{$avgIsk}}</span>M ISK</td>
            </tr>
        </table>
    @elseauth
        <h1>ERROR: Expired session.</h1>
    @endauth
@endsection

@section('styles')
    <style type="text/css">
        html, body {
            margin: 0;
            padding: 0;
            border: 0;

            width: {{$width}};
            height: {{$height}};

        }

        body, tr, td, span, p, small {
            color: {{$fontColor}};
            font-size: {{$fontSize}};
            text-align: {{$align}};
            text-shadow: 0 2px 3px rgba(255,255,255, .15);
        }

        small.text-muted {
            font-size: 0.5rem;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{mix('js/stream/stream-base.js')}}"></script>
    <script>
        $(function () {
            !function(e){function t(e){var t=-1;try{if(-1!=String(e).indexOf(".")){var r=String(e).indexOf(".")+1,n=String(e).length-r;r>0&&(t=n)}}catch(e){t=-1}return t}function r(e){var r="",n=e+"",i="",a="";if(-1!=t(e)){var o=n.split(".");i=o[0],a=o[1]}else i=n;return r=i.split("").reverse().reduce(function(e,t,r){return(r%3?t:t+",")+e}),""!=a&&(r=r+"."+a),r}e.fn.numScroll=function(n){var i=e.extend({number:"0",step:1,time:1e3,delay:0,symbol:!1,fromZero:!0},n);return i.number=i.number.toString(),this.each(function(){var a=e(this),o=a.text()||"0";i.number.indexOf(",")>0&&(i.symbol=!0),n&&!1===n.symbol&&(i.symbol=!1);var l=i.number.replace(/,/g,"")||0,u=o.replace(/,/g,"");if(i.symbol?a.text(o):a.text(u),i.fromZero&&(u=0),isNaN(u)&&(u=0),!isNaN(l)){l=parseFloat(l);var f,c=u=parseFloat(u),s=function(e){var t=!1;try{-1==String(e).indexOf(".")&&-1==String(e).indexOf(",")&&(t=parseInt(e)%1==0)}catch(e){t=!1}return t}(l),m=t(l),v=i.time?10*Math.abs(l-u)/i.time:1;setTimeout(function(){f=setInterval(function(){!function(){var e="";if(s)e=Math.floor(c);else{if(-1==m)return b(l),void clearInterval(f);e=c.toFixed(m)}i.symbol&&(e=r(e)),a.text(e)}(),u<l?(c+=v)>l&&(b(l),clearInterval(f)):(c-=v)<l&&(b(l),clearInterval(f))},1)},i.delay)}function b(e){var t=e.toString().replace(/,/g,"");i.symbol&&(t=r(t)),a.text(t)}})}}(jQuery);
            console.log("Creating Echo");

            const channel = 'runs.save.{{$charId}}';
            const event = '.run-saved';
            console.log('Subscribing on ', channel,'for ', event);
            Echo.private(channel)
                .listen(event, (e) => {
                    console.warn('run.saved: ', e);
                    $("#runsCount").numScroll({number: e.runsCount, fromZero: false});
                    $("#sumIsk").numScroll({number: e.sumIsk, fromZero: false});
                    $("#avgIsk").numScroll({number: e.avgIsk, fromZero: false});
                });
        });
    </script>
@endsection
