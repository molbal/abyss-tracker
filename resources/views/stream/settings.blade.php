@extends("layout.app")
@section("browser-title", "My stream settings")

@section("content")
    <div class="row mt-5">

        <div class="col-sm-12 col-md-12 mb-5">
            <div id="banner" class="shadow-sm mb-0 rounded-b-none" style="background: url('{{asset('stream.jpg')}}')">
                <h4 class="font-weight-bold">Stream tools control center</h4>
            </div>
            <div class="card card-body shadow-sm border-0 rounded-b-none rounded-t-none">
                <h5 class="font-weight-bold">How to use these?</h5>
                <p class="mb-0">These tools will generate you a link that you can add to your broadcaster application in a <strong>Browser/Webpage Source</strong>.</p>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-start align-items-center">
                    <a href="https://www.youtube.com/watch?v=ceHqlHBTI4w" class="d-inline-flex align-items-center" target="_blank" rel="nofollow"><ion-icon class="smallicon mr-1" name="logo-youtube"></ion-icon>OBS browser source</a>
                    <span class="mx-2">&middot;</span>
                    <a href="https://www.youtube.com/watch?v=TmpZW2C_kzY" class="d-inline-flex align-items-center" target="_blank" rel="nofollow"><ion-icon class="smallicon mr-1" name="logo-youtube"></ion-icon>Streamlabs OBS browser source</a>
                    <span class="mx-2">&middot;</span>
                    <a href="https://www.youtube.com/watch?v=TZMl-r_NGhI" class="d-inline-flex align-items-center" target="_blank" rel="nofollow"><ion-icon class="smallicon mr-1" name="logo-youtube"></ion-icon>XSplit webpage source</a>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-10">
            @if(isset($errors))
                @if ($errors->any())
                    <div class="card card-body border-danger shadow-sm my-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <img src="https://img.icons8.com/cotton/64/000000/cancel-2--v1.png" class="icon48p mr-3">
                            <div style="width: 100%">
                                <small class="text-capitalize font-weight-bold text-danger pt-0">ERRORS</small>
                                <ul class="pl-0" style="list-style: none">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>


        <div class="col-md-6">
            <form action="{{route('stream-tools.daily.make')}}" method="post">
                <div class="card card-body border-0 shadow-sm p-0 rounded-b-none">
                    <a href="{{asset('stream-control/daily.jpg')}}" data-toggle="tooltip" target="_blank" title="Click to open image in a new tab - screenshot from Pyrophobic's stream"><img
                            src="{{asset('stream-control/daily.jpg')}}" alt="" class="w-100 rounded shadow-sm"></a>
                    <div class="p-3">
                        <h5 class="font-weight-bold">Daily views</h5>
                        <p class="">You can pick your settings for a daily counter below. The counter will show your daily looted ISK sum, average daily run loot isk, daily
                            ISK/hour and the run count. The widget automatically updates as you save a run.</p>

                        {{csrf_field()}}

                        <h6 class="font-weight-bold">Settings</h6>
                        <div class="form-group">
                            <label>Browsersource width - use px, min: 100px, max: 9999px</label>
                            <input type="text" class="form-control w-25" name="width" value="480px">
                        </div>
                        <div class="form-group">
                            <label>Browsersource height - use px, min: 100px, max: 9999px</label>
                            <input type="text" class="form-control w-25" name="height" value="480px">
                        </div>
                        <div class="form-group">
                            <label>Text align</label>
                            <select class="form-control select2-nosearch-narrow w-25" name="align">
                                <option>left</option>
                                <option>center</option>
                                <option>right</option>
                                <option>justify</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Text size - use px, min: 1px, max: 999px</label>
                            <input type="text" class="form-control w-25" name="fontSize" value="18px">
                        </div>
                        <div class="form-group">
                            <label>Text color</label>
                            <input type="color" class="form-control w-25" name="fontColor" value="#dc3545">
                        </div>
                    </div>
                </div>
                <div class="card-footer shadow-sm text-right">
                    <button class="btn btn-outline-primary" type="submit">Get link</button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form action="{{route('stream-tools.daily.make')}}" method="post">
                <div class="card card-body border-0 shadow-sm p-0 rounded-b-none">
                    <a href="{{asset('stream-control/run.jpg')}}" data-toggle="tooltip" target="_blank" title="Click to open image in a new tab - screenshot from Pyrophobic's stream"><img
                            src="{{asset('stream-control/run.jpg')}}" alt="" class="w-100 rounded shadow-sm"></a>
                    <div class="p-3">
                        <h5 class="font-weight-bold">Run finished screen</h5>
                        <p class="">You can pick your settings for a run finished screen counter below. Its size is fix 1920x1080. TODO The widget automatically updates as you save a run.</p>

                        {{csrf_field()}}

                        <h6 class="font-weight-bold">QR Code?</h6>
                        <div class="row">
                            <div class="col-sm-12 py-0 px-3">
                                @component("components.toggles.inputpicker", [
                                  'name' => "qr",
                                  'value' => "1",
                                  'checked' => true,
                                  'title' => "Show QR code",
                                  'description' => "A QR code will show up on the page with a link to the newly added run.",
                               ]) @endcomponent
                            </div>
                            <div class="col-sm-12 py-0 px-3">
                                @component("components.toggles.inputpicker", [
                                  'name' => "qr",
                                  'value' => "0",
                                  'checked' => false,
                                  'title' => "No QR code",
                                  'description' => "The QR link will be hidden.",
                               ]) @endcomponent
                            </div>
                        </div>
                        <h6 class="font-weight-bold">Character visibility</h6>
                        <div class="row">
                            <div class="col-sm-12 py-0 px-3">
                                @component("components.toggles.inputpicker", [
                                  'name' => "charVisible",
                                  'value' => "1",
                                  'checked' => true,
                                  'title' => "Show character",
                                  'description' => "The submitter's character name and avatar will be displayed on stream.",
                               ]) @endcomponent
                            </div>
                            <div class="col-sm-12 py-0 px-3">
                                @component("components.toggles.inputpicker", [
                                  'name' => "charVisible",
                                  'value' => "0",
                                  'checked' => false,
                                  'title' => "Hide character",
                                  'description' => "The submitter's character name and avatar will be hidden on stream.",
                               ]) @endcomponent
                            </div>
                        </div>
                        <h6 class="font-weight-bold">Other settings</h6>
                        <div class="form-group">
                            <label>Duration (in ms, 1000ms = 1 second, min: 3000ms, max 30000ms)</label>
                            <input type="text" class="form-control w-25" name="duration" value="8000">
                        </div>
                        <div class="form-group">
                            <label>Color accent</label>
                            <input type="color" class="form-control w-25" name="fontColor" value="#dc3545">
                        </div>
                    </div>
                </div>
                <div class="card-footer shadow-sm text-right">
                    <button class="btn btn-outline-primary" type="submit">Get link</button>
                </div>
            </form>
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
