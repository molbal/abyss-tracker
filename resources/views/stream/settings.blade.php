@extends("layout.app")
@section("browser-title", "My stream settings")

@section("content")
    <div class="row mt-5">
        <div class="col-sm-12 col-md-10">
            <h4 class="font-weight-bold">Stream tools control center</h4>

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
                <div class="card card-body border-0">
                    <h5 class="font-weight-bold">Daily views</h5>
                    <p class="">You can pick your settings for a daily counter below. The counter will show your daily looted ISK sum, average daily run loot isk, and the run count.</p>

                    {{csrf_field()}}

                    <div class="form-group">
                        <label>Browsersource width - use px, min: 100px, max: 9999px</label>
                        <input type="text" class="form-control w-25" name="width" value="320px">
                    </div>
                    <div class="form-group">
                        <label>Browsersource height - use px, min: 100px, max: 9999px</label>
                        <input type="text" class="form-control w-25" name="height" value="320px">
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
                        <input type="text" class="form-control w-25" name="fontSize" value="36px">
                    </div>
                    <div class="form-group">
                        <label>Text color</label>
                        <input type="color" class="form-control w-25" name="fontColor" value="#dc3545">
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
