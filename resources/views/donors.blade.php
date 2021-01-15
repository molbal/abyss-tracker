@extends("layout.app")
@section("browser-title", "Donors")

@section("content")
    <div class="row mt-5">
        <div class="col-md-4 offset-md-4 col-sm-6 offset-sm-3 col-xs-12">
            <img src="{{asset('veetor-sanders.jpg')}}" alt="" class="w-100 mt-3 mb-0 rounded-top">

            <div class="card card-body border-0 rounded-bottom mt-0" style="
            border-top-left-radius: 0rem !important;
            border-top-right-radius: 0rem !important;">
                <h5 class="font-weight-bold">How to donate?</h5>
                <p>You can use <a href="https://www.patreon.com/veetor" class="text-dark" target="_blank">Patreon</a> to set up donations.</p>
                <h5 class="font-weight-bold">What are donations used for?</h5>
                <p class="text-justify">Monthly hosting bills are approximately 48€. Recurring donations cover a large part of that. It also allows me to experiment with new features that require a budget normally outside of a single person's hobby project.</p>
                <h5 class="font-weight-bold">Where did the list go?</h5>
                <p class="text-justify pb-0 mb-0">it went opsec: I have been approached by multiple patrons, requesting privacy - turns out many of you registered to Patreon with your RL names and I would like to avoid doxxing anyone.</p>
            </div>
            <div class="card-footer">
                <a href="https://patreon.com/veetor" class="text-dark" target="_blank"><img class="tinyicon mr-1" src="https://img.icons8.com/material-sharp/24/{{App\Http\Controllers\ThemeController::getThemedNavBarIconColor(false)}}/patreon.png">Donate on Patreon</a>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-body border-0 mt-3">
                <h5 class="font-weight-bold"><img src="https://img.icons8.com/cotton/64/000000/charity.png" class="bringupper smallicon"/> Ingame donations</h5>
                <table class="w-100 table table-sm">
                    <tr>
                        <td>Name</td>
                        <td class="text-right">Amount</td>
                        <td>Message</td>
                        <td>Time</td>
                    </tr>
                    @foreach($ingameDonors as $donation)
                        @if (strtoupper($donation->REASON) == "PRIVATE")
                            <tr>
                                <td>
                                    <img src="https://images.evetech.net/characters/1/portrait?size=64" style="height: 24px;width: 24px;border: 2px solid #fff;" class="rounded-circle shadow-sm mr-2" alt="">
                                    Private donation
                                </td>
                                <td class="text-right">{{number_format($donation->AMOUNT, 0, ",", " ")}} ISK</td>
                               <td><span class="text-muted">Private donation</span></td>
                                <td>{{$donation->DATE}}</td>
                            </tr>
                        @else
                            <tr>
                                <td>
                                    <img src="https://images.evetech.net/characters/{{$donation->CHAR_ID}}/portrait?size=64" style="height: 24px;width: 24px;border: 2px solid #fff;" class="rounded-circle shadow-sm mr-2" alt="">
                                    <a href="{{route("profile.index", ["id" => $donation->CHAR_ID])}}" class="text-dark" target="_blank">
                                        {{$donation->NAME}}
                                    </a>
                                </td>
                                <td class="text-right">{{number_format($donation->AMOUNT, 0, ",", " ")}} ISK</td>
                                @if ($donation->REASON == "")
                                    <td><span class="text-muted">No message</span></td>
                                @else
                                    <td class="w-25">{{$donation->REASON}}</td>
                                @endif
                                <td>{{$donation->DATE}}</td>
                            </tr>
                          @endif
                    @endforeach
                </table>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-body border-0 mt-3">
                <h5 class="font-weight-bold">How to donate?</h5>
                <p>You can send ISK to <a href="https://evewho.com/character/93940047" target="_blank">Veetor Nara</a>. <br><img src="donate.png" class="w-100" alt=""></p>

                <h5 class="font-weight-bold">What are donations used for?</h5>
                <p class="text-justify">I like playing the game and the less time I have to grind for ISK the more time I can spend improving this site.</p>
                <h5 class="font-weight-bold">How often does this list update?</h5>
                <p class="text-justify">Every hour, this is automated. To avoid flooding this list only donations over 50 000 ISK are showing up in this list. On the home page the latest donation shows up with the limit of 1M ISK.</p>
                <h5 class="font-weight-bold">OPSEC?</h5>
                <p>If you type "PRIVATE" in the reason field of the "Transfer ISK" window, it will show up in this list without your character name listed.</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {

            $(".select2-nosearch-narrow").select2({
                theme: 'bootstrap',
                minimumResultsForSearch: -1,
                width: '25%'
            });
        });
    </script>
@endsection
