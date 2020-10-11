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
                                    <div class="d-flex justify-content-start p-3 mb-2 shadow rounded border-{{session('messageType')}}" style="border-width: 0 0 0 3px; border-style: solid">
                                        <div class="mr-3">
                                            {!! config('new-fit-wizard.images.'.session('messageType')) !!}
                                        </div>
                                        <div>
                                            <h4 class="font-weight-bold">Message</h4>
                                            {!! session('message') !!}
                                        </div>
                                    </div>
                                @endif

{{--                                STEP 1 STARTS--}}
                                @if($step == 0)
                                    <div class="form-group">
                                        <label for="eft">Please paste your fit as EFT here</label>
                                        <textarea name="eft"  wire:loading.attr="disabled" wire:model.lazy="eft" id="eft" class="w-100 form-control" rows="10" required></textarea>
                                    </div>

                                    <div wire:loading wire:target="eft">
                                        <img src="{{asset('loader.png')}}" alt=""> Verifying fit...
                                    </div>
                                    @component("components.info-line")
                                        After you paste the EFT, the Abyss Tracker will attempt to validate the fit. It will check if the ship can enter abyssal deadspace before letting you continue. Make sure to select ammunition in Pyfa
                                    @endcomponent

                                    @if ($stepsReady->has(0))
                                        <button class="btn btn-outline-primary mt-3" wire:click="goToStep(1)" wire:loading.attr="disabled">Next step <img wire:loading wire:target="goToStep" src="{{asset('loader.png')}}" alt=""></button>

                                    @endif
    {{--                                STEP 1 ENDS--}}
                                @elseif($step == 1)
                                    next steppo
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
