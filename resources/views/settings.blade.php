@extends("layout.app")
@section("browser-title", "My settings")

@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-10">
            <h4 class="font-weight-bold">Settings</h4>
        </div>

        <div class="col-sm-12">

            <form action="{{route('settings.save')}}" method="post">
                <div class="card card-body border-0 mt-3">
                    <h5 class="font-weight-bold">Privacy</h5>
                    <p class="font-italic">The settings below control which part of your public profile is visible and which part is hidden</p>

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
                        <label for="TOTAL_RUNS">Number of all runs</label>
                        <select class="form-control select2-nosearch-narrow w-25" name="TOTAL_RUNS" id="TOTAL_RUNS">
                            <option value="0">Hidden</option>
                            <option value="1" {{$access['TOTAL_RUNS'] == 1 ? 'selected' : ''}}>Visible</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="LOOT">Detailed loot information</label>
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
    </div>
@endsection

@section('scripts')
    <script >
        $(function () {

            $(".select2-nosearch-narrow").select2({
                theme: 'bootstrap',
                minimumResultsForSearch: -1,
                width: '25%'
            });
        });
    </script>
    @endsection
