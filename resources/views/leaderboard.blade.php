@extends("layout.app")
@section("browser-title", "Leaderboard")
@section("content")
    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">Leaderboards for most recorded runs</h4>
    </div>
    <div class="row mt-3">
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Top 20 (last 90 days)</h5>
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    <tr>
                        <th>Character</th>
                        <th class="text-right">Runs</th>
                    </tr>
                    @forelse($leaderboard_90 as $l)
                        @component("components.leaderboard_char", ['item' => $l])@endcomponent
                    @empty
                        <tr>
                            <td colspan="2"><p class="text-center py-3">Noone here yet!</p></td>
                        </tr>
                    @endforelse
                    </thead>
                </table>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Top 20 (last 30 days)</h5>
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    <tr>
                        <th>Character</th>
                        <th class="text-right">Runs</th>
                    </tr>
                    @forelse($leaderboard_30 as $l)
                        @component("components.leaderboard_char", ['item' => $l])@endcomponent
                    @empty
                        <tr>
                            <td colspan="2"><p class="text-center py-3">Noone here yet!</p></td>
                        </tr>
                    @endforelse
                    </thead>
                </table>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Top 20 (last 7 days)</h5>
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    <tr>
                        <th>Character</th>
                        <th class="text-right">Runs</th>
                    </tr>
                    @forelse($leaderboard_07 as $l)
                        @component("components.leaderboard_char", ['item' => $l])@endcomponent
                    @empty
                        <tr>
                            <td colspan="2"><p class="text-center py-3">Noone here yet!</p></td>
                        </tr>
                    @endforelse
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">Leaderboards for most average loot/run</h4>
    </div>
    <div class="row mt-3">
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Top 20 (last 90 days)</h5>
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    <tr>
                        <th>Character</th>
                        <th class="text-right">Average loot/run</th>
                    </tr>
                    @forelse($avgloot_leaderboard_90 as $l)
                        @component("components.leaderboard_char_avg", ['item' => $l])@endcomponent
                    @empty
                        <tr>
                            <td colspan="2"><p class="text-center py-3">Noone here yet!</p></td>
                        </tr>
                    @endforelse
                    </thead>
                </table>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Top 20 (last 30 days)</h5>
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    <tr>
                        <th>Character</th>
                        <th class="text-right">Average loot/run</th>
                    </tr>
                    @forelse($avgloot_leaderboard_30 as $l)
                        @component("components.leaderboard_char_avg", ['item' => $l])@endcomponent
                    @empty
                        <tr>
                            <td colspan="2"><p class="text-center py-3">Noone here yet!</p></td>
                        </tr>
                    @endforelse
                    </thead>
                </table>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Top 20 (last 7 days)</h5>
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    <tr>
                        <th>Character</th>
                        <th class="text-right">Average loot/run</th>
                    </tr>
                    @forelse($avgloot_leaderboard_07 as $l)
                        @component("components.leaderboard_char_avg", ['item' => $l])@endcomponent
                    @empty
                        <tr>
                            <td colspan="2"><p class="text-center py-3">Noone here yet!</p></td>
                        </tr>
                    @endforelse
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-start mt-5">
        <h4 class="font-weight-bold">Leaderboards for the quickest runs on average</h4>
    </div>
    <div class="row mt-3">
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Top 20 (last 90 days)</h5>
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    <tr>
                        <th>Character</th>
                        <th class="text-right">Average loot/run</th>
                    </tr>
                    @forelse($rtsloot_leaderboard_90 as $l)
                        @component("components.leaderboard_char_rts", ['item' => $l])@endcomponent
                    @empty
                        <tr>
                            <td colspan="2"><p class="text-center py-3">Noone here yet!</p></td>
                        </tr>
                    @endforelse
                    </thead>
                </table>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Top 20 (last 30 days)</h5>
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    <tr>
                        <th>Character</th>
                        <th class="text-right">Average loot/run</th>
                    </tr>
                    @forelse($rtsloot_leaderboard_30 as $l)
                        @component("components.leaderboard_char_rts", ['item' => $l])@endcomponent
                    @empty
                        <tr>
                            <td colspan="2"><p class="text-center py-3">Noone here yet!</p></td>
                        </tr>
                    @endforelse
                    </thead>
                </table>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5 class="font-weight-bold mb-2">Top 20 (last 7 days)</h5>
                <table class="table table-sm table-responsive-sm mb-0">
                    <thead>
                    <tr>
                        <th>Character</th>
                        <th class="text-right">Average loot/run</th>
                    </tr>
                    @forelse($rtsloot_leaderboard_07 as $l)
                        @component("components.leaderboard_char_rts", ['item' => $l])@endcomponent
                    @empty
                        <tr>
                            <td colspan="2"><p class="text-center py-3">Noone here yet!</p></td>
                        </tr>
                    @endforelse
                    </thead>
                </table>
            </div>
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

                window.location = '/leaderboard/'+from+"/"+to
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
