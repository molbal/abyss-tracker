@extends("layout.app")
@section("browser-title", "My settings")

@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-10">
            <h4 class="font-weight-bold">Settings</h4>
        </div>
        <div class="col-md-6">
            <form action="{{route('settings.save')}}" method="post">
                <div class="card card-body border-0">
                    <h5 class="font-weight-bold">Privacy</h5>
                    <p class="">The settings below control which part of your public profile is visible and which part is hidden</p>

                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="LAST_RUNS">List of your public runs</label>
                        <select class="form-control select2-nosearch-narrow w-25" name="LAST_RUNS" id="LAST_RUNS">
                            <option value="0">Hidden</option>
                            <option value="1" {{$access['LAST_RUNS'] == 1 ? 'selected' : ''}}>Visible</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="TOTAL_LOOT">Your total and average loot</label>
                        <select class="form-control select2-nosearch-narrow w-25" name="TOTAL_LOOT" id="TOTAL_LOOT">
                            <option value="0">Hidden</option>
                            <option value="1" {{$access['TOTAL_LOOT'] == 1 ? 'selected' : ''}}>Visible</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="TOTAL_RUNS">Number of all runs and visibility in leaderboard</label>
                        <select class="form-control select2-nosearch-narrow w-25" name="TOTAL_RUNS" id="TOTAL_RUNS">
                            <option value="0">Hidden</option>
                            <option value="1" {{$access['TOTAL_RUNS'] == 1 ? 'selected' : ''}}>Visible</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="LOOT">Detailed loot information and excel export</label>
                        <select class="form-control select2-nosearch-narrow w-25" name="LOOT" id="LOOT">
                            <option value="0">Hidden</option>
                            <option value="1" {{$access['LOOT'] == 1 ? 'selected' : ''}}>Visible</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="SHIPS">Your most used ships</label>
                        <select class="form-control select2-nosearch-narrow w-25" name="SHIPS" id="SHIPS">
                            <option value="0">Hidden</option>
                            <option value="1" {{$access['SHIPS'] == 1 ? 'selected' : ''}}>Visible</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="SURVIVAL">Your survival ratio</label>
                        <select class="form-control select2-nosearch-narrow w-25" name="SURVIVAL" id="SURVIVAL">
                            <option value="0">Hidden</option>
                            <option value="1" {{$access['SURVIVAL'] == 1 ? 'selected' : ''}}>Visible</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <form action="{{route('settings.remove-esi')}}" method="post">
                <div class="card card-body border-0 shadow-sm">
                    {{csrf_field()}}
                    <h5 class="font-weight-bold">ESI connector</h5>
                    @if($esi_on)
                        <p class="my-2">
                            Stopwatch is enabled. To disable it and remove the ESI integration from your account use the button below. Doing this will disable the stopwatch
                            function for you.
                        </p>
                        </div>
                        <div class="card-footer">
                        <input type="submit" value="Revoke ESI tokens" class="btn btn-outline-danger">
                    @else
                        <div class="alert alert-info my-2">To use the stopwatch function, please go to the <a href="{{route('new')}}">new run</a> page and turn it on there</div>
                    @endif

                </div>
            </form>


            <form action="{{route("settings.save-cargo")}}" method="post">

                <div class="card card-body border-0 shadow-sm container mt-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="font-weight-bold">Remembering cargo</h5>
                            <p class="text-justify mb-0">Would you like to automatically copy your 'after cargo' loot in the 'before cargo' field of your next run if it starts within {{config("tracker.cargo.saveTime")}} minutes after finishing the last one?</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 py-0 px-3">
                            @component("components.toggles.inputpicker", [
                              'name' => "save_cargo",
                              'value' => "1",
                              'checked' => true,
                              'title' => "Remember cargo",
                              'description' => "This is recommended if you do more runs without dropping your cargo.",
                           ]) @endcomponent
                        </div>
                        <div class="col-sm-12 py-0 px-3">
                            @component("components.toggles.inputpicker", [
                              'name' => "save_cargo",
                              'value' => "0",
                              'checked' => false,
                              'title' => "Forget cargo",
                              'description' => "Use this if you usually drop your cargo between runs",
                           ]) @endcomponent
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-outline-primary" type="submit">Save</button>
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
