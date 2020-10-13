<div>
    <div class="mt-5">
        <div class="row">
            <div class="col-sm-12">
                @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger border-0 shadow-sm d-flex justify-content-between">
                        <img src="https://img.icons8.com/cotton/64/000000/cancel-2--v1.png">
                        <div style="width: 100%">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="card border-0 shadow">
                    <div class="card-overlay" wire:loading>
                        <div class="loading-indicator-container">
                            <img src="{{asset('loader.png')}}" alt="">
                        </div>
                    </div>
                    <div class="card-body border-0 container">
                        <h5 class="font-weight-bold">
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
                                    <li class="{{$step == 2 ? 'is-active' : ""}} {{$step > 2 ? 'is-completed' : ''}}">Privacy</li>
                                    @if($step == 2)
                                        <ul>
                                            <li>
                                                <span class="msform-step-item">
                                                    <span>Visibility setting</span>
                                                </span>
                                            </li>
                                        </ul>
                                    @endif
                                </ol>
                            </div>
                            <div class="col-xs-12 col-sm-9">
                                @if (session()->has('message'))
                                    <div class="wizard-message border-{{session('messageType')}}" style="border-width: 0 0 0 3px; border-style: solid">
                                        <div>
                                            {!! config('new-fit-wizard.images.'.session('messageType')) !!}
                                        </div>
                                        <div>
                                            <h4>Message</h4>
                                            {{ session('message') }}
                                        </div>
                                    </div>
                                @endif

                                @if($step == 0)
                                    <div class="form-group">
                                        <label for="eft">Please paste your fit as EFT here</label>
                                        <textarea name="eft"  wire:loading.attr="disabled" wire:model.lazy="eft" id="eft" class="w-100 form-control" rows="10" required></textarea>
                                    </div>
                                    @component("components.info-line")
                                        After you paste the EFT, the Abyss Tracker will attempt to validate the fit. It will check if the ship can enter abyssal deadspace before letting you continue. Make sure to select ammunition in Pyfa.
                                            <br>
                                        From the EFT, the Abyss Tracker extracts the ship name, fit name, and calculates statistics to determine damage output, tanks strength (resistances and repair/boost speed), capacitor stats, targeting capabilities and maximum velocity with AB/MWD on.
                                    @endcomponent

                                    @if ($stepsReady->has(0))
                                        <button class="btn btn-outline-primary float-right mt-3" wire:click="goToStep(1)" wire:loading.attr="disabled">Next step <img wire:loading wire:target="goToStep" src="{{asset('loader.png')}}" alt=""></button>

                                    @endif


                                @elseif($step == 1)
                                        <h5 class="font-weight-bold">Fit information</h5>
                                        @component("components.info-line")
                                        Good tips on what to write here: In which order should you destroy enemies (Eg. neuters, webbers first), how to deal with the rooms like the Karen room or the Leshaks room.
                                        @endcomponent
                                        <textarea wire:model.lazy="description" name="description" id="description" class="form-control w-100 mt-2" rows="10"></textarea>

                                        <h5 class="font-weight-bold mt-4">Video guide</h5>
                                        <div class="form-group">
                                            @component('components.info-line', ['class' => "mb-2"])
                                                If you have a video guide, we will embed it. Use a well formed Youtube link like <a
                                                    href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">https://www.youtube.com/watch?v=dQw4w9WgXcQ</a>
                                            @endcomponent
                                            <input type="text" name="video_link" id="video_link" class="form-control mt-3">
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
                                                    <td>
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

                                        <button class="btn btn-outline-primary float-right mt-3" wire:click="progressToPrivacy($('#description').val(), $('#video_link').val(), $('#Electrical').val() , $('#Dark').val() , $('#Exotic').val() , $('#Firestorm').val() , $('#Gamma').val() )">Next step</button>

                                    @elseif($step == 2)

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h5 class="font-weight-bold">Privacy</h5>
                                                <p>Please select what information should be visible about your fit</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 p-1">
                                                <div class="pickerInputGroup">
                                                    <input id="privacy-public" name="privacy" value="public" type="radio" checked/>
                                                    <label for="privacy-public">
                                                        <p class="mb-1 font-weight-bold text-uppercase">Public</p>
                                                        <p class="mb-1 text-small">Public fitting with the modules and your name visible</p>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 p-1">
                                                <div class="pickerInputGroup">
                                                    <input id="privacy-incognito" name="privacy" value="incognito" type="radio"/>
                                                    <label for="privacy-incognito">
                                                        <p class="mb-1 font-weight-bold text-uppercase">Anonym</p>
                                                        <p class="mb-1 text-small">Anonym fitting with the modules visible, but your name hidden</p>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 p-1">
                                                <div class="pickerInputGroup">
                                                    <input id="privacy-private" name="privacy" value="private" type="radio"/>
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
{{--                    <div class="card-footer">--}}
{{--                        <div class="w-100 d-flex justify-content-between">--}}
{{--                            <button class="btn btn-outline-secondary" disabled>&laquo; Back</button>--}}
{{--                            <button class="btn btn-outline-primary" disabled>Next step</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</div>
