@extends("layout.app")
@section("browser-title", "Tutorials")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-9">
            <h4 class="font-weight-bold">Tutorials</h4>
                @foreach($tutorials as $tutorial)
                    @component("components.tutorials.list", ['tutorial' => $tutorial]) @endcomponent
                @endforeach
        </div>
        <div class="col-sm-12 col-md-3">

            <div class="card card-body border-0 shadow-sm pb-2">
                <div class="donor">
                    <img src="https://images.evetech.net/characters/2115246489/portrait?size=128" class="portrait rounded-circle shadow-sm" alt="">
                    <p class="h5 font-weight-bold mb-3 mt-2">KurodaAkira</p>
                    <p>Tutorials are curated by <a href="{{route('profile.index', ['id' => 2115246489])}}"><u>KurodaAkira</u></a> - thank you for your hard work!</p>
                </div>
            </div>
        </div>

    </div>
@endsection
@section("styles")
    <style>
        img.tutorial-uploader {
            width:  48px;
            height: 48px;

            border: 2px solid #fff;
            margin-right: 8px;
        }
    </style>
@endsection
{{--@section("scripts")--}}
{{--    <script>--}}

{{--    </script>--}}
{{--@endsection--}}
