@extends("layout.app")
@section("browser-title", "Search")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12">
            <h4 class="font-weight-bold">Search results for the following filters</h4>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 card card-body border-0">

                <table class="table table-sm table-responsive-lg datatable" id="datatable">
                    <thead>
                    <tr>
                        <th>Run ID</th>
                        <th>Tier</th>
                        <th>Type</th>
                        <th>Loot value</th>
                        <th>Survived</th>
                        <th>Run date</th>
                        <th>Ship</th>
                        <th>Proving spawned?</th>
                        <th>Proving used?</th>
                        <th>Run length</th>
                        <th>Ship type</th>
                        <th>Ship size</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($results as $item)
                        <tr>
                            <td><a href="{{route("view_single", ["id" => $item->ID ?? 0])}}" title="Open">{{$item->ID}}</a></td>
                            <td><img src="types/{{$item->TYPE}}.png" style="width:16px;height:16px;" alt=""> {{$item->TIER}}</td>
                            <td><img src="tiers/{{$item->TIER}}.png" style="width:16px;height:16px;" alt=""> {{$item->TYPE}}</td>
                            <td class="text-right" data-order="{{$item->LOOT_ISK}}">{{number_format($item->LOOT_ISK, 0, ',', ' ')}} ISK</td>
                            <td>{{$item->SURVIVED ? "Survived" : "Failed"}}</td>
                            <td>{{$item->RUN_DATE}}</td>
                            <td>@if($item->SHIP_ID === null)<em class="font-italic text-black-50 ">Unknown</em> @else <img
                                    src="https://imageserver.eveonline.com/Type/{{$item->SHIP_ID}}_32.png" class="rounded-circle shadow-sm" height="24px" width="24px"
                                    alt=""> {{$item->SHIP_NAME}} @endif</td>
                            <td>@if($item->PVP_CONDUIT_SPAWN === null) <em
                                    class="font-italic text-black-50 ">Unknown</em> @else{{$item->PVP_CONDUIT_SPAWN ? "Spawned" : "Did not spawn"}}@endif</td>
                            <td>@if($item->PVP_CONDUIT_USED === null) <em
                                    class="font-italic text-black-50 ">Unknown</em> @else{{$item->PVP_CONDUIT_USED ? "Used" : "Did not use"}}@endif</td>
                            <td data-order="{{$item->RUNTIME_SECONDS}}">@if($item->RUNTIME_SECONDS){{(floor($item->RUNTIME_SECONDS/60)).":".($item->RUNTIME_SECONDS%60)}}@else <em
                                    class="font-italic text-black-50 ">Unknown</em> @endif</td>
                            <td> @if($item->SHIP_GROUP === null) <em class="font-italic text-black-50 ">Unknown</em> @else {{$item->SHIP_GROUP}}@endif</td>
                            <td> @if($item->IS_CRUISER === null) <em class="font-italic text-black-50 ">Unknown</em> @else {{$item->IS_CRUISER ? "Cruiser" : "Frigate"}}@endif</td>
                        </tr>
                    @empty
                        No results.
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div>
        @endsection

        @section("scripts")

            <script type="text/javascript">

                // When ready.
                $(function () {

                });
            </script>
@endsection

