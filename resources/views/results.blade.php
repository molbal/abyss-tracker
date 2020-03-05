@extends("layout.app")
@section("browser-title", "Search")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12">
            <h4 class="font-weight-bold">Search results</h4>
			<p>
			@foreach($conditions as $condition)
				{{$condition->getName()}},
			@endforeach
			</p>
        </div>

        @if(isset($errors))
            @if ($errors->any())
                <div class="col-sm-12 alert alert-danger border-0 shadow-sm d-flex justify-content-between">
                    <img src="https://img.icons8.com/cotton/48/000000/cancel-2--v1.png" style="width: 48px;height: 48px">
                    <div style="width: 100%">
                        <span class="ml-3">Please fix the following errors before submittinh your search</span>
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
{{--                <th>Character</th>--}}
{{--                <th>PUBLIC</th>--}}
                <th>Tier</th>
                <th>Type</th>
                <th>Loot value</th>
                <th>Survived</th>
                <th>Run date</th>
                <th>Ship</th>
{{--                <th>DEATH_REASON</th>--}}
                <th>Proving spawned?</th>
                <th>Proving used?</th>
{{--                <th>FILAMENT_PRICE</th>--}}
{{--                <th>LOOT_TYPE</th>--}}
{{--                <th>KILLMAIL</th>--}}
{{--                <th>CREATED_AT</th>--}}
                <th>Run length</th>
{{--                <th>NAME</th>--}}
                <th>Ship type</th>
                <th>Ship size</th>
            </tr>
            </thead>
            <tbody>
            @forelse($results as $item)
                <tr>
                    <td><a href="{{route("view_single", ["id" => $item->ID ?? 0])}}" title="Open">{{$item->ID}}</a></td>
                    <td>{{$item->TIER}}</td>
                    <td>{{$item->TYPE}}</td>
                    <td class="text-right" data-order="{{$item->LOOT_ISK}}">{{number_format($item->LOOT_ISK, 0, ',', ' ')}} ISK</td>
                    <td>{{$item->SURVIVED ? "Survived" : "Failed"}}</td>
                    <td>{{$item->RUN_DATE}}</td>
                    <td>{!! $item->SHIP_ID ? $item->SHIP_NAME : '<em class="text-black-50">Unknown</em>'!!}</td>
                    <td>{{$item->PVP_CONDUIT_SPAWN ? "Spawned" : "-"}}</td>
                    <td>{{$item->PVP_CONDUIT_USED ? "Used" : "-"}}</td>
                    <td data-order="{{$item->RUNTIME_SECONDS}}">@if($item->RUNTIME_SECONDS){{(floor($item->RUNTIME_SECONDS/60)).":".($item->RUNTIME_SECONDS%60)}}@else - @endif</td>
                    <td>{{$item->SHIP_GROUP ?? "-"}}</td>
                    <td>{{$item->IS_CRUISER ? "Cruiser" : "Frigate"}}</td>
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

