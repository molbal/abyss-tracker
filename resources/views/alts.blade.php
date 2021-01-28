@extends("layout.app")
@section("browser-title", "Alt characters")

@section("content")
    <div class="row mt-5">
        <div class="col-sm-6 offset-sm-3">

            <div class="card card-body border-0 shadow-sm pb-2">
                <div class="donor">
                    <img src="https://images.evetech.net/characters/{{\App\Http\Controllers\Auth\AuthController::getLoginId()}}/portrait?size=128"  class="portrait rounded-circle shadow-sm" alt="">
                    <p class="h5 font-weight-bold mb-0 mt-2">{{\App\Http\Controllers\Auth\AuthController::getCharName()}}</p>
                    <p style="letter-spacing: 2px" class="text-uppercase font-bold">alts relationship manager</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-6 offset-sm-3">
            @switch($type)
                @case(\App\Http\Controllers\Misc\Enums\CharacterType::MAIN)
                <div class="card card-body border-0 rounded-top shadow-sm pb-0">
                    <h5 class="font-weight-bold">Your alts</h5>
                    <table class="table table-sm table-hover w-100">
                        <thead class="mb-3">
                        <tr >
                            <th>Name</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($alts as $char)
                            <tr>
                                <td class="pt-2">
                                    <a href="{{route('alts.switch', ['altId' => $char->id])}}" data-toggle="tooltip" title="Switch to the character">
                                        <img src="https://images.evetech.net/characters/{{$char->id}}/portrait?size=64" alt="{{$char->name}}" class="switcher-image bringupper2" style="width: 24px; height: 24px">{{\Illuminate\Support\Str::of($char->name)->limit(18, '...')}}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('alts.delete', ['mainId' => \App\Http\Controllers\Auth\AuthController::getLoginId(), 'altId' => $char->id])}}" class="text-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @break
                @case(\App\Http\Controllers\Misc\Enums\CharacterType::ALT)
                    <div class="card card-body border-0 shadow-sm pb-2 ">
                        <div class="d-flex justify-content-start align-items-center">
                            <img src="https://images.evetech.net/characters/{{$main->id}}/portrait?size=128" style="border: 1px solid #fff; width: 64px; height: 64px;" class= rounded-circle shadow-sm" alt="">
                            <p class="text-center mb-0 ml-3">{{\App\Http\Controllers\Auth\AuthController::getCharName()}} is an alt character of {{$main->name}}. Please <a href="{{route('alts.switch', ['altId' => $main->id])}}">switch to {{$main->name}}</a>, if you want to add an alt.</p>
                        </div>
                    </div>
                    <div class="card-footer shadow-sm text-center">
                        <a href="{{route('alts.delete', ['altId' => \App\Http\Controllers\Auth\AuthController::getLoginId(), 'mainId' => $main->id])}}" class="text-muted">Remove main</a>
                        <span class="mx-2">&middot;</span>
                        <a href="{{route('alts.switch', ['altId' => $main->id])}}" class="text-muted">Switch to main</a>
                    </div>
                @break

                @case(\App\Http\Controllers\Misc\Enums\CharacterType::SINGLE)
                <div class="card card-body border-0 shadow-sm pb-2">
                    <p class="text-center py-4 mb-0">You do not have any alts or mains added to {{\App\Http\Controllers\Auth\AuthController::getCharName()}}. You can add an alt character, if you sign in via the button below.
                    </p>
                    <p class="text-center">
                        <a href="{{route("auth-start", ['addAltCharacter' => true])}}" class="my-sm-0"><img src="{{asset("sso.png")}}" alt="Log in with EVE Online Single sign on" width="195" height="30"></a>
                    </p>
                </div>
                @break
            @endswitch
        </div>

    </div>
    <div class="row mt-3">
        <div class="col-sm-6 offset-sm-3">
            @switch($type)
                @case(\App\Http\Controllers\Misc\Enums\CharacterType::MAIN)
                <div class="card card-body border-0 shadow-sm pb-2">
                    <p class="text-center py-4 mb-0">You already have alt characters. You can add another alt character by loggin in using the button below.
                    </p>
                    <p class="text-center">
                        <a href="{{route("auth-start", ['addAltCharacter' => true])}}" class="my-sm-0"><img src="{{asset("sso.png")}}" alt="Log in with EVE Online Single sign on" width="195" height="30"></a>
                    </p>
                </div>
                @break
            @endswitch
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $(".select2-character").select2({
                theme: 'bootstrap',
                minimumInputLength: 3,
                ajax: {
                    url: '{{route('alts.ajax')}}',
                    dataType: 'json',
                },
                templateResult: function templateResult(state) {
                    console.log(state);
                    if (!state.id) {
                        return state.text;
                    }

                    var $state = $('<span><img style="width: 24px; height: 24px" src="https://images.evetech.net/characters/' + state.id + '/portrait?size=32" class="rounded-circle shadow-sm movealilbitup" /> ' + state.text + '</span>');
                    return $state;
                },
                width: '100%'
            });
        })

    </script>
@endsection
