@extends("layout.app")
@section("browser-title", $event->name)
@section("content")
    <div class="d-flex justify-content-center align-items-center mt-5">
        <h4 class="font-weight-bold text-uppercase">{{$event->name}}</h4>
    </div>
@endsection

@section("scripts")
    <script type="text/javascript">
        $(function () {

        });
    </script>
@endsection

@section("styles")
    <style type="text/css">
    </style>
@endsection
