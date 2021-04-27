@extends("layout.app")
@section("browser-title", $title)
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-8 offset-md-2 mt-5">
            <h4 class="font-weight-bold"><img src="https://img.icons8.com/cotton/64/000000/info.png"> {{$title}}</h4>
            @if(isset($message))
                <div class="card card-body border-info shadow-sm">
                    {{ $message }}
                    @if(isset($selectable))
                        <div class="form-group mt-3 w-100">
                            <input type="text" class="form-control" value="{{$selectable}}">
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection

@section("scripts")

    <script type="text/javascript">
        $(document).ready(function() {
            $("input:text").focus(function() { $(this).select(); } );
        });
    </script>
@endsection
