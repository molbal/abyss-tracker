@extends("layout.app")
@section("browser-title", $item->typeName)
@php
/** @var \App\Models\Models\Partners\NPC $item */
/** @var string $groupName */
@endphp
@section("content")
    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">
            <img src="https://imageserver.eveonline.com/Type/{{$item->typeId}}_64.png" class="mr-2 rounded-circle shadow" style="border: 2px solid #fff; width: 48px; height: 48px;">{{$item->typeName}}
        </h4>
        <span class="float-right group_link">{{$groupName}}</span>
    </div>

    <div class="row mt-3">
        <div class="col-sm-9">
            <div class="card card-body border-0 shadow-sm p-3">
                <h5 class="font-weight-bold">Item description</h5>
                <p class="text-justify mb-0">{!! $item->description !!}</p>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card card-body border-0 shadow-sm p-3">
                <h5 class="font-weight-bold">External links</h5>
                <small class="text-uppercase font-weight-bold">Item reference</small>
                <ul class="pl-0 list-unstyled">
                    <li class="ml-0"><a href="https://everef.net/type/{{$item->typeId}}" rel="nofollow" target="_blank">Eve ref</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
