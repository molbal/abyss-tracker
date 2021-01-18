@extends("layout.app")
@section("browser-title", "Alt characters")

@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-10 mb-3">
            <h4 class="font-weight-bold">Character manager for {{\App\Http\Controllers\Auth\AuthController::getCharName()}}</h4>
            <div class="card card-body border-info shadow-sm d-flex justify-content-start flex-row" style="align-items: center">
                <img src="https://img.icons8.com/cotton/128/000000/woman-with-a-suitcase.png" class="s-48 mr-2"/>
                <p class="m-0 p-0">
                    Your character's type is <em>{{$type}}</em>, which means @lang('alts.'.$type, ['name' => \App\Http\Controllers\Auth\AuthController::getCharName()])
                </p>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
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
            @endswitch
        </div>
    </div>
@endsection

@section('scripts')
    <script>

    </script>
@endsection
