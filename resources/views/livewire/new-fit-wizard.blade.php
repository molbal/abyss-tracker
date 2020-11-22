<div>
    <div class="mt-5">
        <div class="row">
            <div class="col-sm-12">

                <div class="card border-0 shadow">
                    <div class="card-overlay" wire:loading>
                        <div class="loading-indicator-container">
{{--                            <img src="{{asset('loader.png')}}" alt="">--}}
                            <div class="{{\App\Http\Controllers\ThemeController::isDarkTheme() ? "text-white" : 'text-dark'}}" role="status">
                                <img src="{{asset('loader-lg.png')}}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-0 container">
                        <h5 class="font-weight-bold mb-4">
                            {{$wizardTitle}}
                        </h5>
                        <div class="row">
                            <div class="col-xs-12 col-sm-3">
                                <ol class="msform-steps">
                                    <li class="{{$step == 0 ? 'is-active' : ""}} {{$step > 0 ? 'is-completed' : ''}}">
                                        EFT import
                                        @if($step == 0)
                                            <ul>
                                                <li>
                                                <span class="msform-step-item">
                                                    <span>Fit import</span>
                                                </span>
                                                </li>
                                                <li>
                                                <span class="msform-step-item">
                                                    <span>Naming</span>
                                                </span>
                                                </li>
                                            </ul>
                                        @endif
                                    </li>
                                    <li class="{{$step == 1 ? 'is-active' : ""}} {{$step > 1 ? 'is-completed' : ''}}">Fit usage
                                        @if($step == 1)
                                        <ul>
                                            <li>
                                                <span class="msform-step-item">
                                                    <span>Description</span>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="msform-step-item">
                                                    <span>Tutorial video</span>
                                                </span>
                                            </li>
                                            <li>
                                                <span class="msform-step-item">
                                                    <span>Viable weather</span>
                                                </span>
                                            </li>
                                        </ul>
                                        @endif
                                    </li>
                                    <li class="{{$step == 2 ? 'is-active' : ""}} {{$step > 2 ? 'is-completed' : ''}}">Privacy
                                    @if($step == 2)
                                        <ul>
                                            <li>
                                                <span class="msform-step-item">
                                                    <span>Visibility setting</span>
                                                </span>
                                            </li>
                                        </ul>
                                    @endif
                                    </li>
                                </ol>
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                @if (session()->has('message') || (isset($errors) && $errors->any()))
                                    <div class="wizard-message border-{{session('messageType', 'danger')}} mb-3" style="border-width: 0 0 0 3px; border-style: solid">
                                        <div>
                                            {!! config('new-fit-wizard.images.'.session('messageType', 'danger')) !!}
                                        </div>
                                        <div>
                                            <h4>Message</h4>
                                            {{ session('message') }}
                                            <ul style="list-style: none">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                                @if($step == 0)
                                    <div class="form-group">
                                        <label for="eft" class="w-100 d-flex justify-content-between">
                                            <span>Please paste your fit as EFT below</span>
                                            <span>
                                                Import from <a href="javascript:void(0)" id="zkill_modal_link">zKillboard</a> or <a href="javascript:void(0)" id="ewb_modal_link">EVE Workbench</a>
                                            </span>
                                        </label>
                                        <textarea name="eft"  wire:loading.attr="disabled" wire:model.lazy="eft" id="eft" class="w-100 form-control" rows="10" required></textarea>
                                    </div>
                                    @component("components.info-line")
                                        After you paste the EFT, the Abyss Tracker will attempt to validate the fit. It will check if the ship can enter abyssal deadspace before letting you continue. Make sure to select ammunition in Pyfa.
                                            <br>
                                        From the EFT, the Abyss Tracker extracts the ship name, fit name, and calculates statistics to determine damage output, tanks strength (resistances and repair/boost speed), capacitor stats, targeting capabilities and maximum velocity with AB/MWD on.
                                    @endcomponent
                                    @component("components.import_zkill_modal") @endcomponent
                                    @component("components.import_ewb_modal") @endcomponent

                                @elseif($step == 1)
                                        <h5 class="font-weight-bold">Fit information</h5>
                                        @component("components.info-line", ['class' => "mb-2"])
                                        Good tips on what to write here: In which order should you destroy enemies (Eg. neuters, webbers first), how to deal with the rooms like the Karen room or the Leshaks room.
                                        @endcomponent
                                        <textarea wire:model.lazy="description" name="description" id="description" class="form-control w-100 mt-2" rows="10"></textarea>

                                        <h5 class="font-weight-bold mt-4">Video guide</h5>
                                        <div class="form-group">
                                            @component('components.info-line')
                                                If you have a video guide, we will embed it. Use a well formed Youtube link like <a
                                                    href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">https://www.youtube.com/watch?v=dQw4w9WgXcQ</a>
                                            @endcomponent
                                            <input type="text" name="video_link" id="video_link" class="form-control mt-2">
                                        </div>

                                        <h5 class="font-weight-bold mt-4 mb-0">Recommended weather</h5>
                                        <p class="mb-0">Which weather and difficulty do you recommend for this fit?
                                            @component("components.info-toggle")
                                                If you would like to upload a fit for Tranquil difficulty, please select the Calm difficulty.
                                            @endcomponent
                                        </p>
                                        <table class="w-100 table">
                                            <tr>
                                                @foreach(['Dark', 'Electrical', 'Exotic', 'Firestorm', 'Gamma'] as $weather)
                                                    <td class="pt-0">
                                                        <div class="form-group">
                                                            <label class="text-dark" for="{{$weather}}"><img src="{{asset('types/'.$weather.'.png')}}" class="tinyicon bringupper mr-1" alt="{{$weather}} weather">{{$weather}}</label>
                                                            <select name="{{$weather}}" id="{{$weather}}" class="form-control select2-nosearch">
                                                                <option value="0">-</option>
                                                                @for($i=1;$i<=6;$i++)
                                                                    <option value="{{$i}}">@lang("tiers.$i")</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </td>
                                                @endforeach
                                            </tr>
                                        </table>


                                    @elseif($step == 2)

                                        <div class="row">
                                            <div class="col-sm-12 px-0">
                                                <h5 class="font-weight-bold">Privacy</h5>
                                                <p class="mb-0">Please select what information should be visible about your fit.</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 p-1">
                                                <div class="pickerInputGroup">
                                                    <input id="privacy-public" name="privacy" value="public" type="radio" checked wire:model="privacy" />
                                                    <label for="privacy-public">
                                                        <p class="mb-1 font-weight-bold text-uppercase">Public</p>
                                                        <p class="mb-1 text-small">Public fitting with the modules and your name visible</p>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 p-1">
                                                <div class="pickerInputGroup">
                                                    <input id="privacy-incognito" name="privacy" value="incognito" type="radio" wire:model="privacy" />
                                                    <label for="privacy-incognito">
                                                        <p class="mb-1 font-weight-bold text-uppercase">Anonym</p>
                                                        <p class="mb-1 text-small">Anonym fitting with the modules visible, but your name hidden</p>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 p-1">
                                                <div class="pickerInputGroup">
                                                    <input id="privacy-private" name="privacy" value="private" type="radio" wire:model="privacy" />
                                                    <label for="privacy-private">
                                                        <p class="mb-1 font-weight-bold text-uppercase">Private</p>
                                                        <p class="mb-1 text-small">Private fitting with neither modules or your name visible</p>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="w-100 d-flex justify-content-between align-items-center">
                            <a href="{{route("fit_new")}}" class="text-muted">Restart wizard</a>
                            @switch($step)
                                @case(0)

                                    @if ($stepsReady->has(0))
                                        <button class="btn btn-outline-success" wire:click="goToStep(1)" wire:loading.attr="disabled">Next step</button>
                                        @else
                                        <button class="btn btn-outline-success disabled btn-disabled" style="cursor: not-allowed" disabled wire:click="goToStep(1)" wire:loading.attr="disabled" title="Please enter a valid fit">Next step</button>
                                    @endif
                                    @break
                                @case(1)
                                    <button class="btn btn-outline-success" wire:click="progressToPrivacy($('#description').val(), $('#video_link').val(), $('#Electrical').val() , $('#Dark').val() , $('#Exotic').val() , $('#Firestorm').val() , $('#Gamma').val() )"  wire:loading.attr="disabled">Next step</button>
                                @break
                                @case(2)
                                    <button class="btn btn-primary" onclick="finishPage()" wire:loading.attr="disabled" wire:click="process">Save fit</button>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
