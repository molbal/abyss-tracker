@extends("layout.app")
@section("browser-title", "Donors")

@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-10">
            <h4 class="font-weight-bold">Most Valuable People</h4>
        </div>
        <div class="col-md-8">
            <div class="card card-body border-0 mt-3">
                <h5 class="font-weight-bold"><img src="https://img.icons8.com/cotton/64/000000/volunteering.png" class="bringupper smallicon"/> Patreon donations</h5>
                <table class="w-100 table table-sm">
                    <tr>
                        <td>Name</td>
                        <td class="text-right">Total donations</td>
                        <td>&nbsp;</td>
                    </tr>
                    @foreach($patreon as $patreonDonor)
                        <tr>
                            <td><a class="text-dark" href="https://www.patreon.com/user?u={{$patreonDonor->getPatreonId()}}" target="_blank">{{$patreonDonor->getName()}}</a></td>
                            <td class="text-right">{{number_format($patreonDonor->getTotalAmount(), 2, ",", "")}} €</td>
                            <td>{!! $patreonDonor->isActivePatron() ? "Current patron" : "<span class='text-muted'>Former patron</span>" !!}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="col-md-4">
            <img src="{{asset('veetor-sanders.jpg')}}" alt="" class="w-100 mt-3 mb-0 rounded-top">

            <div class="card card-body border-0 rounded-bottom mt-0" style="
            border-top-left-radius: 0rem !important;
            border-top-right-radius: 0rem !important;">
                <h5 class="font-weight-bold">How to donate?</h5>
                <p>You can use <a href="https://www.patreon.com/veetor" target="_blank">Patreon</a> to set up donations.</p>
                <h5 class="font-weight-bold">What are donations used for?</h5>
                <p class="text-justify">Monthly hosting bills are approximately 48€. Recurring donations cover a large part of that. It also allows me to experiment with new features that require a budget normally outside of a single person's hobby project.</p>
                <h5 class="font-weight-bold">How often does this list update?</h5>
                <p class="text-justify">I haven't automated it yet, around the 5th of each month I manually update this list.</p>
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
                <p class="text-justify">Every hour, this is automated</p>
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
