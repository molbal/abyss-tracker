@extends("layout.app")
@section("content")

    <div class="d-flex justify-content-between align-items-start mb-4 mt-5">
        <h4 class="font-weight-bold"><img src="https://img.icons8.com/dusk/50/000000/add-file.png"> Add new Abyss run
        </h4>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-body border-0 shadow-sm">
                <h5>General information</h5>
                @if(isset($errors))
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif
                @if(isset($message))
                    <div class="alert alert-info">{{$message}}</div>
                @endif
                <form action="{{route("store")}}" method="post">
                    {{csrf_field()}}
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Abyss Type</label>
                                    <select name="TYPE" class="form-control">
                                        <option value="Electrical">Electrical</option>
                                        <option value="Dark">Dark</option>
                                        <option value="Exotic">Exotic</option>
                                        <option value="Firestorm">Firestorm</option>
                                        <option value="Gamma">Gamma</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Abyss Tier</label>
                                    <select name="TIER" class="form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Did you survive?</label>
                                    <select name="SURVIVED" class="form-control">
                                        <option value="0">My ship blew up</option>
                                        <option value="1" selected>Survived</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Submit with your name or anonymus?</label>
                                    <select name="PUBLIC" class="form-control">
                                        <option value="0">Submit as anonymus</option>
                                        <option value="1" selected>Submit with my name</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Which day did you do this run?</label>
                                    <input type="text" class="form-control datepicker" name="RUN_DATE" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">What ship did you fly?</label>
                                    <select name="PUBLIC" class="form-control select2-default">
                                        @foreach($ships as $ship)
                                            <option
                                                {{$ship->NAME == "Gila" ? "selected" : ""}} value="{{$ship->ID}}">{{$ship->NAME}}
                                                ({{$ship->GROUP}})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card card-body border-0 shadow-sm mt-3">
                <h5>Loot questions</h5>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="">How much loot did you return with? <img
                                src="https://img.icons8.com/small/16/000000/info.png" data-toggle="tooltip"
                                title="Please copy the loot from your inventory (list view!) and paste it here."></label>
{{--                        <input type="text" class="form-control" id="loot" name="LOOT_ISK" required>--}}
                        <textarea name="LOOT_DETAILED" id="" rows="4" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card card-body border-0 shadow-sm mt-3">
                <p>Thank you for your contribution: {{session()->get("login_name")}} is MVP.</p>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-success">Save run</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    <script type="text/javascript">
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        }).val("{{date("Y-m-d")}}");

        // When ready.
        $(function () {

            var $form = $("form");
            var $input = $form.find("input#loot");

            $input.on("keyup", function (event) {

                // When user select text in the document, also abort.
                var selection = window.getSelection().toString();
                if (selection !== '') {
                    return;
                }

                // When the arrow keys are pressed, abort.
                if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
                    return;
                }


                var $this = $(this);

                // Get the value.
                var input = $this.val();

                var input = input.replace(/[\D\s\._\-]+/g, "");
                input = input ? parseInt(input, 10) : 0;

                $this.val(function () {
                    return (input === 0) ? "" : input.toLocaleString("en-US");
                });
            });

            $form.submit(function (e) {
                $input.val($input.val().split(',').join(''));

            });
        });
    </script>
@endsection
