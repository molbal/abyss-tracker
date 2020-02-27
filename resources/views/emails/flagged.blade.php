@component('mail::message')
# Run {{$id}} flagged

{{$message}}

@component('mail::button', ['url' => route("view_single", ["id" => $id])])
Check run
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
