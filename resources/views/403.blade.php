@extends("layout.app")
@section("browser-title", "Error")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-8 offset-md-2">
            <h4 class="font-weight-bold"><img src="https://img.icons8.com/cotton/64/000000/lock--v1.png"> You are not allowed to view this</h4>
            @if(isset($error))
                <div class="card card-body border-warning shadow-sm">
                    {!! $error !!}
                </div>
            @endif
        </div>
    </div>
@endsection
