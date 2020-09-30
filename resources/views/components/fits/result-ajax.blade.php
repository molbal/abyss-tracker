@component("components.collapse.collapsible-card", ["title" => "Displaying ".$results->count()." fits", 'show' => true, 'icon' => 'runs-search.search'])
    @forelse($filters as $filter)
        <span class="badge badge-secondary m-1 text-wrap" style="font-size: 0.9em">{{$filter}}</span>
    @empty
        <p>No filter applied</p>
    @endforelse
    <hr>
@component("components.fits.filter.result-list", ["runs-search.results" => $results])@endcomponent
@endcomponent
