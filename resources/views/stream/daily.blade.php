@extends('layout.stream-base')
@section("browser-title", "Daily browser source")
@section("content")
   hi
@endsection
@section('scripts')
    <script src="{{mix('js/stream/stream-base.js')}}"></script>
    <script>
        $(function () {
            console.log("Creating Echo");

            Echo.channel('runs.save')
                .listen('.run.saved', (e) => {
                    console.warn('run.saved: ', e);
                });
        });
    </script>
@endsection
