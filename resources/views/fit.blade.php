@extends("layout.app")
@section("browser-title", $ship_name." fit by ".$char_name)
@section("content")
    <div class="d-flex justify-content-between align-items-start mb-4 mt-5">
        <h4 class="font-weight-bold">{{$ship_name}} fit: {{$fit->NAME}} by <a href="{{route("profile.index", ['id' => $fit->CHAR_ID])}}">{{$char_name}}</a></h4>
        <p class="text-right text-sm mb-0 pb-0">
            Saved at: {{$fit->SUBMITTED}}
        </p>
    </div>
@endsection
