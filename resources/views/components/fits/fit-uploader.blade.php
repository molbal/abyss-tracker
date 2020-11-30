@if($fit->PRIVACY == 'public')
    <div class="text-small">
        <img src="https://images.evetech.net/characters/{{$fit->CHAR_ID}}/portrait?size=256" alt="{{$char_name}}"  id="char_prof">
        <br>
        <a href="{{route("profile.index", ['id' => $fit->CHAR_ID])}}" class="h5 font-weight-bold text-dark mb-1 d-inline-block">{{$char_name}} </a>
        <br>
        <a href="{{route("profile.index", ['id' => $fit->CHAR_ID])}}" class="text-muted mx-1 ">profile</a> &centerdot;
        <a href="{{route("fit.search", ['CHAR_ID' => $fit->CHAR_ID])}}" class="text-muted mx-1 ">fits</a> &centerdot;
        <a href="https://zkillboard.com/character/{{$fit->CHAR_ID}}/" target="_blank" class="text-muted mx-1 ">killboard</a> &centerdot;
        <a href="{{$eve_workbench_url}}" target="_blank" class="text-muted mx-1 ">eve workbench</a>
    </div>
@else
    <p class="mb-0">This is an anonym fit, so its uploader is hidden.</p>
@endif
