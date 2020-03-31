@extends("layout.app")
@section("browser-title", $name)
@section("content")
    @if(session()->has('login_id') && session()->get('login_id') == $id)
        <div class="row mt-3">
            <div class="col-sm-12">
                <div class="card card-body border-info shadow-sm d-flex justify-content-between flex-row" style="align-items: center">
                    <img src="https://img.icons8.com/cotton/64/000000/data-encryption.png" style="width:64px; height: 64px" />
                    <p class="m-0 p-0 text-center">
                        This is your inventory, so you see every detail. To see how a guest sees this page, open it in a private window, and to edit the privacy of these panels, click <a target="_blank" href="{{route("settings.index")}}">settings</a>
                    </p>
                </div>
            </div>
        </div>
    @endif
    <div class="row mt-3">
        <div class="col-sm-12 col-md-12">
            <div id="banner" class="shadow-sm" style="background-image: url('inventory.jpg');">
                <img src="https://images.evetech.net/characters/{{$id}}/portrait?size=128" class="rounded-circle shadow-sm" width="128" height="128">
                <h4 class="font-weight-bold ">{{$name}}<small>'s loot from {{$from}} to {{$to}}</small></h4>
            </div>
        </div>
        <div class="col-sm-12 col-md-8">
            @component("components.restricted", ["title" => "Detailed loot summary","public" => $access["LOOT"], 'icon_size' => 32])
                <div class="card card-body border-0 shadow-sm mt-3">
                    <h5 class="font-weight-bold mb-2">All loot from {{$from}} to {{$to}}</h5>
                    <div>
                    @php
                        $ps = 0;
                        $pb = 0;
                    @endphp
                    @forelse($loot as $l)
                        @php
                            $ps += $l->PRICE_SELL*$l->COUNT;
                            $pb += $l->PRICE_BUY*$l->COUNT;
                        @endphp
                        @component('components.inventory_item', ['item' => $l]) @endcomponent
                    @empty
                        <p class="py-4 text-center"><img src="https://img.icons8.com/cotton/32/000000/empty-box.png" style="position: relative;top:-4px; width:32px; height: 32px" /> <em>No loot</em></p>
                    @endforelse
                    </div>
                </div>
                <div class="card-footer text-right">
                    <p>Total buy price: {{number_format($pb, 0, ".", " ")}} ISK <br> Total sell price: {{number_format($ps, 0, ".", " ")}} ISK</p>
                </div>
            @endcomponent
        </div>
        <div class="col-sm-12 col-md-4">
            @component("components.restricted", ["title" => "Excel export","public" => $access["LOOT"]])
                <div class="card card-body border-0 shadow-sm mt-3">
                    <h5 class="font-weight-bold mb-2"><img src="https://img.icons8.com/officexs/24/000000/xls.png"/> Excel export</h5>
                    <p>You can download this screen in a much more detailed Excel file.</p>
                    <a href="{{route('profile.export', ['id' => $id, 'from' => $from, 'to' => $to])}}" class="btn btn-outline-primary btn-sm">Export</a>
                </div>
            @endcomponent
            @component("components.restricted", ["title" => "Loot query","public" => $access["LOOT"]])
                <div class="card card-body border-0 shadow-sm mt-3">
                    <h5 class="font-weight-bold mb-2">Show loot from date</h5>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control daterange">

                        <div class="input-group-append">
                            <button type="button" id="loot_show" class="btn btn-outline-primary">Show</button>
                        </div>
                    </div>
                    <input type="hidden" id="datarangestart" name="from">
                    <input type="hidden" id="datarangestop" name="to">
                </div>
            @endcomponent
        </div>
    </div>
@endsection

@section("scripts")
    <script type="text/javascript">
        // When ready.
        $(function () {

            $("#loot_show").click(function () {
                var from = $("#datarangestart").val() ? $("#datarangestart").val() : "now";
                var to = $("#datarangestop").val() ? $("#datarangestop").val() : "now";

                window.location = '/char/{{$id}}/loot/'+from+"/"+to
            });

            $(".daterange").daterangepicker({
                "autoUpdateInput": false,
                "timePicker": false,
                "autoApply": true,
                "showCustomRangeLabel": true,
                "alwaysShowCalendars": true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, function (start, end, label) {
                $(".daterange").val(start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                $("#datarangestart").val(start.format("YYYY-MM-DD"));
                $("#datarangestop").val(end.format("YYYY-MM-DD"));
            });
        });
    </script>
@endsection

@section("styles")
    <style type="text/css">
        #banner {
            background: url("/profile.jpg");
            background-size: cover;
            display: flex;
            height: 86px;
            border-radius: 8px;
            align-items: center;
        }

        #banner > img {
            border: 3px solid{{App\Http\Controllers\ThemeController::getThemedBorderColor()}};
            position: relative;
            top: 0;
            left: 32px;
            z-index: 50;
        }

        #banner > h4 {
            color: #fff;
            text-shadow: 0 2px 0 rgba(0, 0, 0, 0.8);
            position: relative;
            top: 10px;
            left: 64px;
            text-transform: uppercase;
            font-size: 26px;
        }
    </style>
@endsection
