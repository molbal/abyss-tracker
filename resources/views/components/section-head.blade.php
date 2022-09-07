
<div class="d-flex justify-content-between align-items-start mt-5">
    <h4 class="font-weight-bold">{!! $slot !!}</h4>
    {!! $other ?? '' !!}
    @isset($link_url)
        <a class="text-dark"
           {{ $link_external ?? false ? "target='_blank' ": '' }}
           href="{{$link_url}}">{!! $link_text !!}
        </a>
    @endisset
</div>
