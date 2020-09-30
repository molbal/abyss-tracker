@extends("layout.app")
@section("browser-title", "Search")
@section("content")
    <div class="d-flex justify-content-between align-items-start mt-3">
        <a class="text-dark" href="{{route("search.index")}}">←&nbsp;New search</a>
    </div>
    <div class="row mt-3">
        <div class="col-sm-12">
            <h4 class="font-weight-bold mb-0">Displaying {{$results->total()}} results</h4>
            <p>
                @foreach($conditions as $condition)
                    <span class="badge badge-primary py-1 mr-1 text-uppercase shadow-sm">{{$condition->getName()}}</span>
                @endforeach
            </p>
        </div>

        @if(isset($errors))
            @if ($errors->any())
                <div class="col-sm-12 alert alert-danger border-0 shadow-sm d-flex justify-content-between">
                    <img src="https://img.icons8.com/cotton/48/000000/cancel-2--v1.png" style="width: 48px;height: 48px">
                    <div style="width: 100%">
                        <span class="ml-3">Please fix the following errors before submitting your search</span>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        @endif
    </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 ">
                <div class="card card-body border-0">
                    <table class="table table-sm table-responsive-lg" id="">
                        <thead>
                        <tr>
                            <th>Run ID</th>
                            <th>Tier</th>
                            <th>Type</th>
                            <th class="text-right">Loot value</th>
                            <th>Survived</th>
                            <th>Run date</th>
                            <th>Ship</th>
                            <th class="text-right">Run length</th>
                            <th>Ship type</th>
                            <th>Ship size</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($results as $item)
                            <tr>
                                <td><a href="{{route("view_single", ["id" => $item->ID ?? 0])}}" class="text-dark" title="Open">{{$item->ID}}</a></td>
                                <td><img src="types/{{$item->TYPE}}.png" class="tinyicon bringupper mr-1" alt="">{{$item->TIER}}</td>
                                <td><img src="tiers/{{$item->TIER}}.png" class="tinyicon bringupper mr-1" alt="">{{$item->TYPE}}</td>
                                <td class="text-right" data-order="{{$item->LOOT_ISK}}">{{number_format($item->LOOT_ISK, 0, ',', ' ')}} ISK</td>
                                <td>{{$item->SURVIVED ? "Survived" : "Failed"}}</td>
                                <td>{{$item->RUN_DATE}}</td>
                                <td>@if($item->SHIP_ID === null)<em class="font-italic text-black-50 ">Unknown</em> @else <img
                                        src="https://imageserver.eveonline.com/Type/{{$item->SHIP_ID}}_32.png" class="rounded-circle shadow-sm" style="border: 1px solid #fff;" height="24px" width="24px"
                                        alt=""> {{$item->SHIP_NAME}} @endif</td>
                                <td class="text-right" data-order="{{$item->RUNTIME_SECONDS}}">@if($item->RUNTIME_SECONDS){{\App\Http\Controllers\TimeHelper::formatSecondsToMMSS($item->RUNTIME_SECONDS)}}@else
                                        <em
                                            class="font-italic text-black-50 ">Unknown</em> @endif</td>
                                <td> @if($item->SHIP_GROUP === null) <em class="font-italic text-black-50 ">Unknown</em> @else {{$item->SHIP_GROUP}}@endif</td>
                                <td> @if($item->HULL_SIZE === null) <em class="font-italic text-black-50 ">Unknown</em> @else {{ucfirst($item->HULL_SIZE)}}@endif</td>
                            </tr>
                        @empty
                            No results.
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if($results->hasPages())
                    <div class="card-footer">
                        {{$results->links()}}
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if (isset($link))
    <div class="container">

        <div class="row mt-3">
            <div class="col-sm-12">
                <h4 class="font-weight-bold mb-0">Share this search</h4>
                <p>
                    The link below will be saved for {{config('tracker.search.link_save_time_days')}} days.
                </p>
                <input type="text" class="form-control" value="{{$link}}">
            </div>

        </div>
    </div>
    @endif
    <div>

        @endsection

        @section("scripts")

            <script type="text/javascript">

                // When ready.
                $(function () {

                });
            </script>
@endsection

