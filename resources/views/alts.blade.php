@extends("layout.app")
@section("browser-title", "Alt characters")

@section("content")
    <div class="row mt-5">
        <div class="col-sm-6 offset-sm-3">
            <h4 class="font-weight-bold">Character manager for {{\App\Http\Controllers\Auth\AuthController::getCharName()}}</h4>
            <div class="card card-body border-info shadow-sm d-flex justify-content-start flex-row" style="align-items: center">
                <img src="https://img.icons8.com/cotton/128/000000/woman-with-a-suitcase.png" class="s-48 mr-2"/>
                <p class="m-0 p-0">
                    Your character's type is <em>{{$type}}</em>, which means @lang('alts.'.$type, ['name' => \App\Http\Controllers\Auth\AuthController::getCharName()])
                </p>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-6 offset-sm-3">
            @switch($type)
                @case(\App\Http\Controllers\Misc\Enums\CharacterType::MAIN)
                <div class="card card-body rounded-top shadow-sm pb-0">
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
                    <div class="card card-body border-0 shadow-sm pb-2">
                        <div class="donor">
                            <img src="https://images.evetech.net/characters/{{$main->id}}/portrait?size=128"  class="portrait rounded-circle shadow-sm" alt="">
                            <p class="h5 font-weight-bold mb-0 mt-2">{{$main->name}}</p>
                            <p>{{$main->name}} is your main character.</p>
                        </div>
                    </div>
                    <div class="card-footer shadow-sm">
                        <a href="{{route('alts.delete', ['altId' => \App\Http\Controllers\Auth\AuthController::getLoginId(), 'mainId' => $main->id])}}" class="text-muted">Delete main</a>
                    </div>
                @break
                @case(\App\Http\Controllers\Misc\Enums\CharacterType::SINGLE)
                <div class="card card-body border-0 shadow-sm pb-2">
                    <p class="text-center py-4">If you add a main character, or add this character as a main, your alts or main will appear here.</p>
                </div>
                @break
            @endswitch
        </div>

    </div>
    <div class="row mt-3">
        <div class="col-sm-6 offset-sm-3">
            @switch($type)
                @case(\App\Http\Controllers\Misc\Enums\CharacterType::ALT)
                <div class="card card-body border-0 shadow-sm pb-2">
                    <p class="text-center py-4">You can only have one main character. <a href="{{route('alts.delete', ['altId' => \App\Http\Controllers\Auth\AuthController::getLoginId(), 'mainId' => $main->id])}}" class="text-danger">Remove {{$main->name}} as your main</a> to add a new one.</p>
                </div>
                @break
                @case(\App\Http\Controllers\Misc\Enums\CharacterType::MAIN)
                <div class="card card-body border-0 shadow-sm pb-2">
                    <p class="text-center py-4">You already have alt characters. You can add more alt characters by logging in them, and setting {{\App\Http\Controllers\Auth\AuthController::getCharName()}} as their main. To use {{\App\Http\Controllers\Auth\AuthController::getCharName()}} as an alt character, first it have to delete all their alts.</p>
                </div>
                @break
                @case(\App\Http\Controllers\Misc\Enums\CharacterType::SINGLE)
                <form action="" method="post">
                    <div class="card card-body border-0 shadow-sm pb-2">
                            <div class="form-group">

                                <label for="CHAR_ID">Please select your main character.
                                @component('components.info-toggle')
                                    If you do not see your main here, sign in and then return to this screen.
                                @endcomponent
                                </label>
                                <select name="CHAR_ID" id="select_CHAR_ID" class="form-control select2-character">
    {{--                                @foreach($chars as $user)--}}
    {{--                                    <option--}}
    {{--                                        value="{{$user->CHAR_ID}}">{{$user->NAME}}--}}
    {{--                                    </option>--}}
    {{--                                @endforeach--}}
                                </select>
                            </div>
                    </div>
                    <div class="card-footer shadow-sm border-0">

                        <button class="btn btn-outline-primary" type="submit">Save</button>
                    </div>
                </form>
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
