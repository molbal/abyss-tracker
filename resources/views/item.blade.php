@extends("layout.app")
@section("content")
    <div class="row mt-5">
        <div class="col-sm-12">
            <h4 class="font-weight-bold">
                <img src="https://imageserver.eveonline.com/Type/{{$item->ITEM_ID}}_64.png"> {{$item->NAME}}
                <a href="{{route("item_group", ["group_id" => $item->GROUP_ID])}}" class="btn float-right btn-outline-secondary group_link">{{$item->GROUP_NAME}}</a>
            </h4>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-4 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row"><img src="https://img.icons8.com/cotton/64/000000/box--v2.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{number_format($item->PRICE_SELL, 0, ",", " ")}} ISK</h2>
                        <small class="text-muted font-weight-bold">Cheapest sell order</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="https://img.icons8.com/cotton/64/000000/empty-box.png" class="pull-left ml-2">
                    <div class="col">
                        <h2 class="font-weight-bold mb-0">{{number_format($item->PRICE_BUY, 0, ",", " ")}} ISK</h2>
                        <small class="text-muted font-weight-bold">Most expensive buy order</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card card-body shadow-sm border-0">
                <div class="row">
                    <img src="https://img.icons8.com/dotty/64/000000/time.png" class="pull-left ml-2">
                    <div class="col">
                        <h5 class="font-weight-bold mb-0">{{$item->PRICE_LAST_UPDATED}}</h5>
                        <small class="text-muted font-weight-bold">Price updated</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($item->DESCRIPTION)
        <div class="row mt-3">
            <div class="col-sm-12">
                <div class="card card-body border-0 shadow-sm">
                    <h5 class="font-weight-bold">Item description</h5>
                    <p class="text-justify mb-0">{!! $item->DESCRIPTION !!}</p>
                </div>
            </div>
        </div>
    @endif
    @if($count < 50)
        <div class="row mt-3">
            <div class="col-sm-12">
                <div class="card card-body shadow-sm border-warning p-4 d-flex justify-content-between flex-row">
                    <p class="text-justify mb-0 text-dark">
                        Currently we only have {{$count}} runs submitted where this item dropped, so drop levels displayed here might be incorrect
                    </p>
                </div>
            </div>
        </div>
    @endif

@endsection


@section("scripts")
    <script type="text/javascript">
    </script>
@endsection

@section("styles")
    <style>
        a.group_link {
            position: relative;
            top: 8px;
        }
    </style>
@endsection
