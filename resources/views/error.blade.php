@extends("layout.app")
@section("content")
    <div class="row mt-5">
        <div class="card card-body border-danger border-0 shadow-sm">
            <h4>The website could not handle your request</h4>
            @if(isset($error))
                <div class="alert alert-danger">
                      {{ $error }}
                </div>
            @endif

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
