@component("components.collapse.collapsible-card", ["title" => "Displaying ".$results->count()." fits", 'show' => true, 'icon' => 'search'])
    @forelse($filters as $filter)
        <span class="badge badge-secondary m-1" style="font-size: 0.9em">{{$filter}}</span>
    @empty
        <p>No filter applied</p>
    @endforelse
    <hr>
@component("components.fits.filter.result-list", ["results" => $results])@endcomponent
@endcomponent
