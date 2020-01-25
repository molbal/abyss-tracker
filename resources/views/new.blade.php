@extends("layout.app")
@section("content")
    <div class="row mt-5">
        <div class="card card-body border-0 shadow-sm">

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

            <h4>Add a new Abyss run</h4>
            <form action="{{route("store")}}" method="post">
                {{csrf_field()}}
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Abyss Type</label>
                                <select name="TYPE"  class="form-control">
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
                                <select name="TIER"  class="form-control">
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
                                <select name="SURVIVED"  class="form-control">
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
                                <select name="PUBLIC"  class="form-control">
                                    <option value="0">Submit as anonymus</option>
                                    <option value="1" selected>Submit with my name</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">How much loot did you return with?</label>
                                <input type="text" class="form-control" id="loot" name="LOOT_ISK" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Which day did you do this run?</label>
                                <input type="text" class="form-control datepicker" name="RUN_DATE" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section("scripts")

    <script type="text/javascript">
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-0d'
        });

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

            $form.submit( function(e) {
                $input.val($input.val().split(',').join(''));

            });
        });
    </script>
@endsection
