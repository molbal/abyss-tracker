@extends("layout.app")
@section("browser-title", "Add a new fit")
@section("content")
    @livewire('new-fit-wizard', [
        'oldFitId' => $oldFitId,
        'oldFitName' => $oldFitName
    ])
@endsection

@section("styles")
    @livewireStyles
    @if(App\Http\Controllers\ThemeController::isDarkTheme())
        <link rel="stylesheet" href="{{asset('/css/new-fit-deps-dark.css')}}">
    @else
        <link rel="stylesheet" href="{{asset('/css/new-fit-deps-light.css')}}">
    @endif
@endsection
@section("scripts")
    @livewireScripts
    <script src="{{asset('/js/new-fit.js')}}"></script>
@endsection
