{{--                            <p class="mb-3">You submitted this fit so you can delete it or modify its privacy.</p>--}}
<div class="btn-group mb-2 d-block">
    <a href="{{route("fit.change_privacy", ['id' => $fit->ID, 'privacySetting' => 'public'])}}" class="btn text-dark {{$fit->PRIVACY == 'public' ? 'active btn-outline-primary' : 'btn-outline-secondary '}}">Set privacy to 'Public'
    </a><a href="{{route("fit.change_privacy", ['id' => $fit->ID, 'privacySetting' => 'incognito'])}}" class="btn text-dark {{$fit->PRIVACY == 'incognito' ? 'active btn-outline-primary' : 'btn-outline-secondary '}}">Set privacy to 'Anonym'
    </a><a href="{{route("fit.change_privacy", ['id' => $fit->ID, 'privacySetting' => 'private'])}}" class="btn text-dark {{$fit->PRIVACY == 'private' ? 'active btn-outline-primary' : 'btn-outline-secondary '}}">Set privacy to 'Private'
    </a>
</div>
<h5 class="font-weight-bold mt-5">Is the fit tested with the latest patch?</h5>
{{--                            <p class="mb-3"></p>--}}
<div class="btn-group mb-2 d-block">
    <a href="{{route("fit.update.last-patch", ['id' => $fit->ID, 'status' => 'untested'])}}" class="btn text-dark  {{$fit->LAST_PATCH == 'untested' ? 'active btn-outline-primary' : 'btn-outline-secondary'}}" data-toggle="tooltip" title="@lang('tags.untested-tooltip')">Untested
    </a><a href="{{route("fit.update.last-patch", ['id' => $fit->ID, 'status' => 'works'])}}" class="btn text-dark  {{$fit->LAST_PATCH == 'works' ? 'active btn-outline-primary' : 'btn-outline-secondary'}}" data-toggle="tooltip" title="@lang('tags.works-tooltip')">Works
    </a><a href="{{route("fit.update.last-patch", ['id' => $fit->ID, 'status' => 'deprecated'])}}" class="btn text-dark  {{$fit->LAST_PATCH == 'deprecated' ? 'active btn-outline-primary' : 'btn-outline-secondary'}}" data-toggle="tooltip" title="@lang('tags.deprecated-tooltip')">Deprecated
    </a>
</div>
<h5 class="font-weight-bold mt-5">Update fit settings</h5>
{{--                            <p class="mb-3">To upgrade a fit's version</p>--}}
{{--<div class="btn-group mb-2 d-block">--}}
<ul>
    <li><a href="{{route("fit_new", ['id' => $fit->ROOT_ID ?? $fit->ID])}}" data-toggle="tooltip" title="Allows you to change all fields. Switches to a new revision.">Edit fit</a></li>
    <li><a href="javascript:void(0)" id="editDescription" data-toggle="tooltip" title="Only changes the description field. Stays on the current revision.">Change description</a></li>
    <li><a href="javascript:void(0)" id="editVideo" data-toggle="tooltip" title="Only changes the video. Stays on the current revision.">Change tutorial video</a></li>
</ul>
{{--</div>--}}
<h5 class="font-weight-bold text-danger mt-5">Danger zone</h5>
<p>If you want to delete this fit, you may click the red link: <a href="{{route("fit.delete", ['id' => $fit->ID])}}" class="text-danger">Delete fit</a></p>

@component('components.fits.fit_new_description_modal', ['id' => $fit->ID, 'description' => $fit->DESCRIPTION]) @endcomponent
@component('components.fits.fit_new_video_modal', ['id' => $fit->ID, 'video' => $fit->VIDEO_LINK]) @endcomponent
